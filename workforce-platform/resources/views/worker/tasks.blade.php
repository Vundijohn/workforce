<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-extrabold text-2xl text-ink-900 tracking-tight font-display">Contributor Workspace</h1>
                <p class="text-xs text-ink-500 mt-0.5">Claim tasks, complete prompt evaluations, and track your earnings</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Account Active & Verified
                </span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        @if (session('status'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <span class="text-lg">✓</span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->has('claim'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 text-sm font-medium">
                <span class="text-lg">⚠️</span>
                <span>{{ $errors->first('claim') }}</span>
            </div>
        @endif

        <!-- Quick Metrics Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-3xl p-6 border border-gray-200/70 shadow-soft">
                <div class="text-xs font-bold uppercase tracking-wider text-ink-400 mb-1">Open Active Tasks</div>
                <div class="text-3xl font-extrabold text-ink-900 font-display">{{ count($tasks) }} <span class="text-xs font-normal text-ink-400">/ 3 max</span></div>
                <div class="mt-2 text-xs text-ink-500">Tasks currently reserved for you</div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-gray-200/70 shadow-soft">
                <div class="text-xs font-bold uppercase tracking-wider text-ink-400 mb-1">Active Projects</div>
                <div class="text-3xl font-extrabold text-ink-900 font-display">{{ count($projects) }}</div>
                <div class="mt-2 text-xs text-ink-500">Engaged queues ready for work</div>
            </div>

            @php
                $totalMinor = $earnings->sum('amount_minor');
                $currency = $earnings->first()?->currency ?? 'USD';
                $formattedTotal = $currency === 'USD' ? '$'.number_format($totalMinor / 100, 2) : $currency.' '.number_format($totalMinor / 100, 2);
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-gray-200/70 shadow-soft">
                <div class="text-xs font-bold uppercase tracking-wider text-ink-400 mb-1">Total Recorded Earnings</div>
                <div class="text-3xl font-extrabold text-outlier-600 font-display">
                    {{ $formattedTotal }}
                </div>
                <div class="mt-2 text-xs text-ink-500">Across {{ $earnings->count() }} approved submissions</div>
            </div>
        </div>

        <!-- 1. Open Tasks Section -->
        <section class="bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-extrabold text-ink-900 font-display">Tasks in Progress</h2>
                    <p class="text-xs text-ink-500">Submit before the 24-hour expiration deadline</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-ink-600">
                    {{ count($tasks) }} active
                </span>
            </div>

            @if (count($tasks) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($tasks as $task)
                        <div class="p-5 rounded-3xl border {{ $task->status->value === 'revision_required' ? 'border-amber-300 bg-amber-50/30' : 'border-gray-200/90 bg-gray-50/50' }} hover:shadow-md transition">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-ink-500">
                                    {{ $task->project->title }}
                                </span>
                                @if ($task->status->value === 'revision_required')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        Revision Requested
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800 border border-sky-200">
                                        In Progress
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-bold text-ink-900 text-base mb-1">
                                Task #{{ $task->id }}
                            </h3>

                            <p class="text-xs text-ink-600 line-clamp-2 mb-4">
                                {{ $task->payload['prompt'] ?? 'Complete the instruction assessment.' }}
                            </p>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-200/60">
                                <span class="text-xs text-ink-500">
                                    ⏰ Due {{ $task->due_at?->diffForHumans() }}
                                </span>
                                <a href="{{ route('worker.tasks.show', $task) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold text-white bg-outlier-500 hover:bg-outlier-600 shadow-sm transition">
                                    <span>Work on Task</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 px-4 border border-dashed border-gray-200 rounded-3xl bg-gray-50/50">
                    <div class="text-3xl mb-2">📋</div>
                    <h3 class="font-bold text-ink-800 text-sm">No tasks currently checked out</h3>
                    <p class="text-xs text-ink-500 mt-1 max-w-sm mx-auto">
                        Select a project below and claim your next available task from the backlog.
                    </p>
                </div>
            @endif
        </section>

        <!-- 2. Claim Work Section -->
        <section class="bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-extrabold text-ink-900 font-display">Available Project Queues</h2>
                    <p class="text-xs text-ink-500">Projects where your application is verified and engaged</p>
                </div>
                <a href="{{ route('worker.projects') }}" class="text-xs font-bold text-outlier-600 hover:text-outlier-700">
                    Browse All Projects →
                </a>
            </div>

            @forelse ($projects as $project)
                <div class="p-5 rounded-3xl border border-gray-200/80 bg-white hover:border-outlier-300 transition duration-150 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-outlier-100 text-outlier-700">
                                {{ $project->client->name }}
                            </span>
                            <span class="text-xs font-medium text-emerald-600">
                                • {{ $project->available_tasks_count }} tasks available in backlog
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-ink-900 font-display">{{ $project->title }}</h3>
                        <p class="text-xs text-ink-500 max-w-xl">{{ $project->description }}</p>
                    </div>

                    <div class="flex items-center sm:flex-col sm:items-end justify-between gap-3 shrink-0">
                        <div class="text-right">
                            <div class="text-sm font-extrabold text-ink-900">{{ $project->payRateLabel() }}</div>
                            <div class="text-[11px] text-ink-400">per approved task</div>
                        </div>

                        <form method="POST" action="{{ route('worker.tasks.claim', $project) }}">
                            @csrf
                            <x-primary-button class="py-2 px-5 text-xs">
                                <span>Get Next Task</span>
                                <span class="ml-1">→</span>
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 px-4 border border-dashed border-gray-200 rounded-3xl bg-gray-50/50">
                    <div class="text-3xl mb-2">🚀</div>
                    <h3 class="font-bold text-ink-800 text-sm">No engaged project queues yet</h3>
                    <p class="text-xs text-ink-500 mt-1 max-w-sm mx-auto mb-4">
                        You need to apply to a project and pass onboarding before tasks can be claimed.
                    </p>
                    <a href="{{ route('worker.projects') }}"
                       class="inline-flex items-center px-5 py-2.5 rounded-full text-xs font-bold text-white bg-ink-900 hover:bg-black transition">
                        Browse Open Projects
                    </a>
                </div>
            @endforelse
        </section>

        <!-- 3. Earnings History Section -->
        <section class="bg-white rounded-4xl p-6 sm:p-8 border border-gray-200/80 shadow-soft">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-extrabold text-ink-900 font-display">Earnings Breakdown</h2>
                    <p class="text-xs text-ink-500">Every approved submission is uniquely recorded and verified</p>
                </div>
            </div>

            @if ($earnings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-gray-100 text-ink-400 uppercase tracking-wider font-bold">
                                <th class="pb-3">Submission</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3">Available Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($earnings as $e)
                                <tr>
                                    <td class="py-3.5 font-medium text-ink-900">
                                        Submission #{{ $e->task_submission_id }}
                                    </td>
                                    <td class="py-3.5 font-bold text-ink-900">
                                        {{ $e->currency === 'USD' ? '$' : $e->currency.' ' }}{{ number_format($e->amount_minor / 100, 2) }}
                                    </td>
                                    <td class="py-3.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60 capitalize">
                                            {{ $e->status->value }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 text-ink-500">
                                        {{ $e->available_at?->toFormattedDateString() ?? 'Instant' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-xs text-ink-500">
                    No earnings recorded yet. Once you submit tasks and reviewers approve them, your ledger will update here.
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
