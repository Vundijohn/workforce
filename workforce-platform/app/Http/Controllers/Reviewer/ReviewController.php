<?php

namespace App\Http\Controllers\Reviewer;

use App\Enums\ReviewDecision;
use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Models\TaskSubmission;
use App\Services\SubmissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use RuntimeException;

class ReviewController extends Controller
{
    public function queue(Request $request)
    {
        // Oldest first; never show a reviewer their own work.
        $submissions = TaskSubmission::with('task.project', 'user')
            ->where('status', SubmissionStatus::Submitted->value)
            ->where('user_id', '!=', $request->user()->id)
            ->oldest('submitted_at')->paginate(20);

        return view('reviewer.queue', compact('submissions'));
    }

    public function show(TaskSubmission $submission)
    {
        Gate::authorize('view', $submission);

        return view('reviewer.review', ['submission' => $submission->load('task.project', 'user')]);
    }

    public function store(Request $request, TaskSubmission $submission, SubmissionService $service)
    {
        Gate::authorize('review', $submission);

        $data = $request->validate([
            'decision' => ['required', Rule::enum(ReviewDecision::class)],
            'score' => ['nullable', 'integer', 'between:1,5'],
            'comments' => ['nullable', 'string', 'max:5000', 'required_unless:decision,approved'],
        ]);

        try {
            $service->review(
                $submission,
                $request->user(),
                ReviewDecision::from($data['decision']),
                $data['score'] ?? null,
                $data['comments'] ?? null,
            );
        } catch (RuntimeException $e) {
            return back()->withErrors(['decision' => $e->getMessage()]);
        }

        return redirect()->route('reviewer.queue')->with('status', 'Review saved.');
    }
}
