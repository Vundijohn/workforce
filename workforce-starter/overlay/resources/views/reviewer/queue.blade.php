<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-outlier-600 bg-outlier-100 px-2.5 py-0.5 rounded-full">
                    Auditing & Quality Control
                </span>
                <h1 class="font-extrabold text-2xl text-ink-900 tracking-tight font-display mt-1">Review Queue</h1>
            </div>
            <div class="text-xs text-ink-500">
                Ordered oldest-first · Self-review blocked by policy
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <span class="text-lg">✓</span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-bold text-ink-900 font-display">Pending Submissions</h2>
                    <p class="text-xs text-ink-500">Review answers carefully according to the project rubric</p>
                </div>
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-gray-100 text-ink-700">
                    {{ $submissions->total() }} waiting
                </span>
            </div>

            @if ($submissions->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach ($submissions as $s)
                        <div class="py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 hover:bg-gray-50/80 -mx-4 px-4 rounded-2xl transition">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-outlier-100 text-outlier-700">
                                        {{ $s->task->project->title }}
                                    </span>
                                    <span class="text-xs text-ink-400">
                                        Submission #{{ $s->id }}
                                    </span>
                                </div>
                                <div class="text-sm font-bold text-ink-900">
                                    Submitted by {{ $s->user->name }}
                                </div>
                                <div class="text-xs text-ink-500">
                                    Received {{ $s->submitted_at->diffForHumans() }}
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('reviewer.review.show', $s) }}"
                                   class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full text-xs font-bold text-white bg-outlier-500 hover:bg-outlier-600 shadow-sm transition">
                                    <span>Inspect & Score</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $submissions->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-4xl mb-3">🎉</div>
                    <h3 class="font-bold text-ink-900 text-base">The review queue is empty</h3>
                    <p class="text-xs text-ink-500 mt-1 max-w-sm mx-auto">
                        All worker submissions have been graded. New submissions will appear here automatically.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
