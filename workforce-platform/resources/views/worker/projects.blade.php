<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2></x-slot>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))<div class="p-3 bg-green-50 text-green-800 rounded">{{ session('status') }}</div>@endif
        @forelse ($projects as $project)
            @php($application = $applications->get($project->id))
            <div class="bg-white shadow sm:rounded-lg p-6 flex justify-between items-start gap-4">
                <div>
                    <h3 class="font-semibold text-lg">{{ $project->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $project->client->name }} · {{ $project->payRateLabel() }} per approved task</p>
                    <p class="mt-2 text-gray-700">{{ $project->description }}</p>
                </div>
                @if ($application)
                    <span class="px-3 py-1 text-sm rounded bg-gray-100 capitalize">{{ $application->status->value }}</span>
                @else
                    <form method="POST" action="{{ route('worker.projects.apply', $project) }}">@csrf
                        <x-primary-button>Apply</x-primary-button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-600">No open projects right now.</p>
        @endforelse
    </div>
</x-app-layout>
