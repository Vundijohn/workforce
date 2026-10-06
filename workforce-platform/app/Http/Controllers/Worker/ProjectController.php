<?php

namespace App\Http\Controllers\Worker;

use App\Enums\ApplicationStatus;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::where('status', ProjectStatus::Active->value)->with('client')->latest()->get();
        $applications = $request->user()->applications()->get()->keyBy('project_id');

        return view('worker.projects', compact('projects', 'applications'));
    }

    public function apply(Request $request, Project $project, AuditLogger $audit)
    {
        abort_unless($project->status === ProjectStatus::Active && $request->user()->isActive(), 403);

        $application = $project->applications()->firstOrCreate(
            ['user_id' => $request->user()->id],
            ['status' => ApplicationStatus::Submitted]
        );

        if ($application->wasRecentlyCreated) {
            $audit->log('application.created', $application);
        }

        return back()->with('status', 'Application received.');
    }
}
