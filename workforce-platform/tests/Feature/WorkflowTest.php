<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Enums\ProjectStatus;
use App\Enums\ReviewDecision;
use App\Enums\Role;
use App\Enums\TaskStatus;
use App\Models\Client;
use App\Models\Earning;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\SubmissionService;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use RuntimeException;
use Tests\TestCase;

class WorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    private function userWithRole(Role $role): User
    {
        $user = User::factory()->create();
        $user->syncRoles([$role->value]);

        return $user;
    }

    private function projectWithTask(): array
    {
        $client = Client::create(['name' => 'Acme', 'slug' => 'acme']);
        $project = Project::create([
            'client_id' => $client->id, 'title' => 'Rating', 'pay_rate_minor' => 2500,
            'currency' => 'USD', 'status' => ProjectStatus::Active,
        ]);
        $task = Task::create(['project_id' => $project->id, 'status' => TaskStatus::Available, 'payload' => ['prompt' => 'Hi']]);

        return [$project, $task];
    }

    private function engage(Project $project, User $worker): void
    {
        $project->applications()->create(['user_id' => $worker->id, 'status' => ApplicationStatus::Engaged]);
    }

    public function test_self_registered_users_are_workers_only(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($user->hasRole(Role::Worker->value));
        $this->assertFalse($user->can('review_submissions'));
        $this->assertFalse($user->can('manage_users'));
    }

    public function test_worker_cannot_open_reviewer_queue(): void
    {
        $worker = $this->userWithRole(Role::Worker);

        $this->actingAs($worker)->get('/reviewer/queue')->assertForbidden();
    }

    public function test_unonboarded_worker_cannot_claim_tasks(): void
    {
        [$project] = $this->projectWithTask();
        $worker = $this->userWithRole(Role::Worker);

        $this->actingAs($worker)->post(route('worker.tasks.claim', $project))
            ->assertSessionHasErrors('claim');

        $this->assertSame(0, Task::where('assigned_to', $worker->id)->count());
    }

    public function test_full_flow_creates_exactly_one_earning(): void
    {
        [$project, $task] = $this->projectWithTask();
        $worker = $this->userWithRole(Role::Worker);
        $reviewer = $this->userWithRole(Role::Reviewer);
        $this->engage($project, $worker);

        $this->actingAs($worker)->post(route('worker.tasks.claim', $project))
            ->assertRedirect(route('worker.tasks.show', $task));

        $this->actingAs($worker)->post(route('worker.tasks.submit', $task), ['answer' => 'Rayleigh scattering.'])
            ->assertRedirect(route('worker.tasks'));

        $submission = $task->fresh()->submissions()->firstOrFail();

        $this->actingAs($reviewer)->post(route('reviewer.review.store', $submission), ['decision' => 'approved', 'score' => 5])
            ->assertRedirect(route('reviewer.queue'));

        $this->assertSame(TaskStatus::Approved, $task->fresh()->status);
        $this->assertSame(1, Earning::count());
        $this->assertSame(2500, Earning::first()->amount_minor);

        // A second review attempt must fail and must not create another earning.
        $this->actingAs($reviewer)->post(route('reviewer.review.store', $submission), ['decision' => 'approved'])
            ->assertForbidden();
        $this->assertSame(1, Earning::count());
    }

    public function test_reviewer_cannot_review_own_work(): void
    {
        [$project, $task] = $this->projectWithTask();
        $reviewer = $this->userWithRole(Role::Reviewer);
        $this->engage($project, $reviewer);
        $task->update(['assigned_to' => $reviewer->id, 'status' => TaskStatus::Assigned]);

        $submission = app(SubmissionService::class)->submit($task, $reviewer, ['answer' => 'x']);

        $this->actingAs($reviewer)->post(route('reviewer.review.store', $submission), ['decision' => 'approved'])
            ->assertForbidden();
    }

    public function test_worker_cannot_view_or_submit_someone_elses_task(): void
    {
        [$project, $task] = $this->projectWithTask();
        $owner = $this->userWithRole(Role::Worker);
        $intruder = $this->userWithRole(Role::Worker);
        $task->update(['assigned_to' => $owner->id, 'status' => TaskStatus::Assigned]);

        $this->actingAs($intruder)->get(route('worker.tasks.show', $task))->assertForbidden();
        $this->actingAs($intruder)->post(route('worker.tasks.submit', $task), ['answer' => 'x'])->assertForbidden();
    }

    public function test_revision_request_does_not_pay_and_allows_resubmission(): void
    {
        [$project, $task] = $this->projectWithTask();
        $worker = $this->userWithRole(Role::Worker);
        $reviewer = $this->userWithRole(Role::Reviewer);
        $task->update(['assigned_to' => $worker->id, 'status' => TaskStatus::Assigned]);

        $service = app(SubmissionService::class);
        $first = $service->submit($task, $worker, ['answer' => 'draft']);
        $service->review($first, $reviewer, ReviewDecision::RevisionRequested, 2, 'Too short');

        $this->assertSame(0, Earning::count());
        $this->assertSame(TaskStatus::RevisionRequired, $task->fresh()->status);

        $second = $service->submit($task->fresh(), $worker, ['answer' => 'better']);
        $this->assertNotSame($first->id, $second->id);
    }

    public function test_application_status_transitions_are_enforced(): void
    {
        [$project] = $this->projectWithTask();
        $worker = $this->userWithRole(Role::Worker);
        $application = $project->applications()->create(['user_id' => $worker->id, 'status' => ApplicationStatus::Submitted]);

        $application->transitionTo(ApplicationStatus::Screening);
        $this->assertSame(ApplicationStatus::Screening, $application->fresh()->status);

        $this->expectException(InvalidArgumentException::class);
        $application->transitionTo(ApplicationStatus::Engaged); // cannot skip steps
    }

    public function test_service_rejects_submit_by_non_assignee(): void
    {
        [$project, $task] = $this->projectWithTask();
        $owner = $this->userWithRole(Role::Worker);
        $other = $this->userWithRole(Role::Worker);
        $task->update(['assigned_to' => $owner->id, 'status' => TaskStatus::Assigned]);

        $this->expectException(RuntimeException::class);
        app(SubmissionService::class)->submit($task, $other, ['answer' => 'x']);
    }
}
