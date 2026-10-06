<?php

namespace App\Http\Controllers\Worker;

use App\Enums\ApplicationStatus;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Services\SubmissionService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RuntimeException;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $tasks = $user->tasks()->with('project')
            ->whereIn('status', array_map(fn ($s) => $s->value, TaskStatus::workable()))
            ->orderBy('due_at')->get();

        $projects = Project::whereHas('applications', fn ($q) => $q
            ->where('user_id', $user->id)
            ->where('status', ApplicationStatus::Engaged->value))
            ->withCount('availableTasks')->get();

        $earnings = $user->earnings()->get();

        return view('worker.tasks', compact('tasks', 'projects', 'earnings'));
    }

    public function claim(Request $request, Project $project, TaskService $service)
    {
        try {
            $task = $service->claimNext($project, $request->user());
        } catch (RuntimeException $e) {
            return back()->withErrors(['claim' => $e->getMessage()]);
        }

        return redirect()->route('worker.tasks.show', $task);
    }

    public function show(Task $task)
    {
        Gate::authorize('view', $task);

        return view('worker.task', ['task' => $task->load('project')]);
    }

    public function submit(Request $request, Task $task, SubmissionService $service)
    {
        Gate::authorize('submit', $task);

        $data = $request->validate(['answer' => ['required', 'string', 'min:1', 'max:20000']]);

        try {
            $service->submit($task, $request->user(), ['answer' => $data['answer']]);
        } catch (RuntimeException $e) {
            return back()->withErrors(['answer' => $e->getMessage()]);
        }

        return redirect()->route('worker.tasks')->with('status', 'Submitted for review.');
    }
}
