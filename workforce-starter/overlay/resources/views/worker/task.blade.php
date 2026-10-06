<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-outlier-600 bg-outlier-100 px-2.5 py-0.5 rounded-full">
                        {{ $task->project->title }}
                    </span>
                    <span class="text-xs text-ink-400">· Task #{{ $task->id }}</span>
                </div>
                <h1 class="font-extrabold text-2xl text-ink-900 tracking-tight font-display">Prompt Evaluation Studio</h1>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200">
                    ⏰ Due {{ $task->due_at?->diffForHumans() }}
                </span>
                <a href="{{ route('worker.tasks') }}"
                   class="text-xs font-bold text-ink-600 hover:text-ink-900 px-3 py-1.5 rounded-full border border-gray-200 bg-white">
                    ← Save & Exit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Two Column Context & Guidelines -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left: Task Prompt -->
            <div class="lg:col-span-7 bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-outlier-500"></span>
                        <h2 class="font-bold text-sm text-ink-900 uppercase tracking-wider">Evaluation Prompt</h2>
                    </div>
                    <span class="text-xs text-ink-400">Active Item</span>
                </div>

                <div class="p-5 rounded-2xl bg-[#F8F9FA] border border-gray-200/70 text-sm sm:text-base text-ink-900 leading-relaxed whitespace-pre-line font-medium">
                    {{ $task->payload['prompt'] ?? 'No prompt data provided.' }}
                </div>
            </div>

            <!-- Right: Instructions & Rubric -->
            <div class="lg:col-span-5 bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-base">📋</span>
                        <h2 class="font-bold text-sm text-ink-900 uppercase tracking-wider">Project Rubric</h2>
                    </div>
                </div>

                <div class="text-xs text-ink-700 leading-relaxed whitespace-pre-line space-y-2">
                    {{ $task->project->instructions }}
                </div>
            </div>
        </div>

        <!-- Submission Form Area -->
        @can('submit', $task)
            <div class="bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
                <div class="mb-4">
                    <h2 class="text-lg font-extrabold text-ink-900 font-display">Your Response & Rewrite</h2>
                    <p class="text-xs text-ink-500 mt-0.5">Ensure high quality, factual accuracy, and clear reasoning before submitting.</p>
                </div>

                <form method="POST" action="{{ route('worker.tasks.submit', $task) }}" class="space-y-4">
                    @csrf

                    <div>
                        <textarea id="answer" name="answer" rows="10"
                                  class="w-full rounded-3xl border-gray-200 focus:border-outlier-500 focus:ring-4 focus:ring-outlier-500/10 p-5 text-sm text-ink-900 placeholder-ink-400 leading-relaxed shadow-sm transition"
                                  placeholder="Write your detailed expert answer here in your own words..."
                                  required>{{ old('answer') }}</textarea>
                        <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-100">
                        <div class="text-xs text-ink-500 flex items-center gap-2">
                            <span>🛡️ Submissions are audited by Senior Reviewers for accuracy.</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('worker.tasks') }}"
                               class="px-5 py-2.5 rounded-full text-xs font-bold text-ink-600 hover:text-ink-900 transition">
                                Cancel
                            </a>
                            <x-primary-button class="py-3 px-8 text-sm">
                                <span>Submit for Quality Review</span>
                                <span class="ml-1.5">→</span>
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="p-6 bg-gray-50 rounded-3xl border border-gray-200 text-center text-xs text-ink-500">
                This task is currently not available for submission.
            </div>
        @endcan
    </div>
</x-app-layout>
