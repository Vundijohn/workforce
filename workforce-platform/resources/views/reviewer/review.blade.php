<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-outlier-600 bg-outlier-100 px-2.5 py-0.5 rounded-full">
                        {{ $submission->task->project->title }}
                    </span>
                    <span class="text-xs text-ink-400">· Submission #{{ $submission->id }}</span>
                </div>
                <h1 class="font-extrabold text-2xl text-ink-900 tracking-tight font-display">Quality Evaluation Studio</h1>
            </div>

            <div>
                <a href="{{ route('reviewer.queue') }}"
                   class="text-xs font-bold text-ink-600 hover:text-ink-900 px-3.5 py-2 rounded-full border border-gray-200 bg-white">
                    ← Back to Queue
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Two Column Context -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left: Task & Prompt -->
            <div class="lg:col-span-7 bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft space-y-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-outlier-500"></span>
                        <h2 class="font-bold text-sm text-ink-900 uppercase tracking-wider">Evaluation Prompt</h2>
                    </div>
                    <div class="p-4 rounded-2xl bg-[#F8F9FA] border border-gray-200/70 text-sm text-ink-900 font-medium whitespace-pre-line">
                        {{ $submission->task->payload['prompt'] ?? '' }}
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h2 class="font-bold text-sm text-ink-900 uppercase tracking-wider">Worker Submitted Answer</h2>
                    </div>
                    <div class="p-5 rounded-2xl bg-white border border-gray-200 text-sm text-ink-900 leading-relaxed whitespace-pre-line shadow-inner">
                        {{ $submission->response['answer'] ?? '' }}
                    </div>
                    <div class="mt-2 text-right text-xs text-ink-400">
                        Submitted by: {{ $submission->user->name }}
                    </div>
                </div>
            </div>

            <!-- Right: Instructions & Rubric -->
            <div class="lg:col-span-5 bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
                    <span class="text-base">📋</span>
                    <h2 class="font-bold text-sm text-ink-900 uppercase tracking-wider">Scoring Rubric</h2>
                </div>

                <div class="text-xs text-ink-700 leading-relaxed whitespace-pre-line">
                    {{ $submission->task->project->instructions }}
                </div>
            </div>
        </div>

        <!-- Evaluation Form -->
        @can('review', $submission)
            <div class="bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
                <div class="mb-6">
                    <h2 class="text-lg font-extrabold text-ink-900 font-display">Evaluation Decision & Feedback</h2>
                    <p class="text-xs text-ink-500 mt-0.5">Approved submissions immediately award credit to the worker's balance.</p>
                </div>

                <form method="POST" action="{{ route('reviewer.review.store', $submission) }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Decision -->
                        <div>
                            <label for="decision" class="block text-xs font-bold uppercase tracking-wider text-ink-700 mb-2">
                                Review Decision
                            </label>
                            <select id="decision" name="decision"
                                    class="w-full rounded-2xl border-gray-200 focus:border-outlier-500 focus:ring-4 focus:ring-outlier-500/10 text-sm py-3 px-4 bg-white text-ink-900 shadow-sm" required>
                                <option value="approved">✓ Approve (Passes Rubric & Credit Worker)</option>
                                <option value="revision_requested">↺ Request Revision (Worker Must Improve)</option>
                                <option value="rejected">✕ Reject (Does Not Meet Guidelines)</option>
                            </select>
                            <x-input-error :messages="$errors->get('decision')" class="mt-1" />
                        </div>

                        <!-- Score -->
                        <div>
                            <label for="score" class="block text-xs font-bold uppercase tracking-wider text-ink-700 mb-2">
                                Quality Score (1 to 5 Stars)
                            </label>
                            <input id="score" name="score" type="number" min="1" max="5" placeholder="5"
                                   class="w-full rounded-2xl border-gray-200 focus:border-outlier-500 focus:ring-4 focus:ring-outlier-500/10 text-sm py-3 px-4 bg-white text-ink-900 shadow-sm" />
                            <x-input-error :messages="$errors->get('score')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Comments -->
                    <div>
                        <label for="comments" class="block text-xs font-bold uppercase tracking-wider text-ink-700 mb-2">
                            Auditor Comments & Critique <span class="text-ink-400 font-normal">(Required if requesting revision or rejecting)</span>
                        </label>
                        <textarea id="comments" name="comments" rows="4"
                                  class="w-full rounded-3xl border-gray-200 focus:border-outlier-500 focus:ring-4 focus:ring-outlier-500/10 p-4 text-sm text-ink-900 placeholder-ink-400 leading-relaxed shadow-sm transition"
                                  placeholder="Provide constructive feedback explaining why this answer was scored this way...">{{ old('comments') }}</textarea>
                        <x-input-error :messages="$errors->get('comments')" class="mt-1" />
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                        <a href="{{ route('reviewer.queue') }}"
                           class="px-5 py-2.5 rounded-full text-xs font-bold text-ink-600 hover:text-ink-900 transition">
                            Cancel
                        </a>
                        <x-primary-button class="py-3 px-8 text-sm">
                            <span>Finalize Review & Record</span>
                            <span class="ml-1.5">→</span>
                        </x-primary-button>
                    </div>
                </form>
            </div>
        @else
            <div class="p-6 bg-gray-50 rounded-3xl border border-gray-200 text-center text-xs text-ink-500">
                You cannot review this submission (either already reviewed or authored by you).
            </div>
        @endcan
    </div>
</x-app-layout>
