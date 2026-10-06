<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Enums\ProjectStatus;
use App\Enums\Role;
use App\Enums\TaskStatus;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Local development only. Never run in production (demo passwords are weak by design). */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $make = function (string $name, string $email, Role $role): User {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => 'password']
            );
            $user->forceFill(['email_verified_at' => now()])->save();
            $user->syncRoles([$role->value]);

            return $user;
        };

        $admin = $make('Demo Admin', 'admin@example.test', Role::SuperAdmin);
        $make('Demo Reviewer', 'reviewer@example.test', Role::Reviewer);
        $worker = $make('Demo Worker', 'worker@example.test', Role::Worker);

        $client = Client::firstOrCreate(
            ['slug' => 'demo-ai-lab'],
            ['name' => 'Demo AI Lab', 'created_by' => $admin->id]
        );

        $project = Project::firstOrCreate(
            ['client_id' => $client->id, 'title' => 'Prompt Response Rating'],
            [
                'description' => 'Rate and rewrite AI answers for helpfulness and accuracy.',
                'instructions' => "1. Read the prompt.\n2. Write the best possible answer in your own words.\n3. Keep it factual and clear.",
                'pay_rate_minor' => 25000, // KES 250.00
                'currency' => 'KES',
                'status' => ProjectStatus::Active,
            ]
        );

        $project->applications()->updateOrCreate(
            ['user_id' => $worker->id],
            ['status' => ApplicationStatus::Engaged]
        );

        if ($project->tasks()->count() === 0) {
            foreach (range(1, 8) as $i) {
                Task::create([
                    'project_id' => $project->id,
                    'status' => TaskStatus::Available,
                    'payload' => ['prompt' => "Explain, in two short paragraphs, why the sky looks blue (variation #{$i})."],
                ]);
            }
        }
    }
}
