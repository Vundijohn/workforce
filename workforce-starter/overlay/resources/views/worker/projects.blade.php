<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-extrabold text-2xl text-ink-900 tracking-tight font-display">Available Opportunities</h1>
                <p class="text-xs text-ink-500 mt-0.5">Apply to specialized domain projects to unlock task backlogs</p>
            </div>
            <div>
                <a href="{{ route('worker.tasks') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold text-ink-700 bg-white hover:bg-gray-50 border border-gray-200 shadow-sm transition">
                    <span>Back to My Work</span>
                    <span>→</span>
                </a>
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($projects as $project)
                @php($application = $applications->get($project->id))
                <div class="bg-white rounded-4xl p-7 border border-gray-200/80 shadow-soft hover:shadow-card transition duration-200 flex flex-col justify-between">
                    <div>
                        <!-- Header Tags -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-outlier-100 text-outlier-700">
                                {{ $project->client->name }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-gray-100 text-ink-900">
                                {{ $project->payRateLabel() }}
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <h3 class="text-xl font-bold text-ink-900 mb-2 font-display">{{ $project->title }}</h3>
                        <p class="text-xs text-ink-600 leading-relaxed mb-6">{{ $project->description }}</p>

                        <!-- Project Guidelines snippet -->
                        @if ($project->instructions)
                            <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 text-[11px] text-ink-600 mb-6">
                                <div class="font-bold text-ink-800 mb-1">Key Focus & Rubric:</div>
                                <div class="line-clamp-2 whitespace-pre-line">{{ $project->instructions }}</div>
                            </div>
                        @endif
                    </div>

                    <!-- Footer Action -->
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        @if ($application)
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-ink-400">Application status:</span>
                                <span class="px-3 py-1 text-xs font-bold rounded-full capitalize {{ $application->status->canWork() ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-sky-100 text-sky-800 border border-sky-200' }}">
                                    {{ $application->status->value }}
                                </span>
                            </div>

                            @if ($application->status->canWork())
                                <a href="{{ route('worker.tasks') }}"
                                   class="inline-flex items-center gap-1 text-xs font-bold text-outlier-600 hover:text-outlier-700">
                                    <span>Claim from Queue</span>
                                    <span>→</span>
                                </a>
                            @endif
                        @else
                            <div class="text-xs text-ink-500">Ready for applications</div>
                            <form method="POST" action="{{ route('worker.projects.apply', $project) }}">
                                @csrf
                                <x-primary-button class="py-2.5 px-6 text-xs">
                                    <span>Apply for Project</span>
                                    <span class="ml-1">→</span>
                                </x-primary-button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-16 bg-white rounded-4xl border border-dashed border-gray-200 p-8">
                    <div class="text-4xl mb-3">🔍</div>
                    <h3 class="font-bold text-ink-900 text-base">No open projects right now</h3>
                    <p class="text-xs text-ink-500 mt-1 max-w-sm mx-auto">
                        New client queues are posted weekly. Check back shortly for open project intakes.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
