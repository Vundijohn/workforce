<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">My work</h2></x-slot>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))<div class="p-3 bg-green-50 text-green-800 rounded">{{ session('status') }}</div>@endif
        <x-input-error :messages="$errors->get('claim')" />

        <section class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-3">Open tasks</h3>
            @forelse ($tasks as $task)
                <a href="{{ route('worker.tasks.show', $task) }}" class="block border-b py-2 hover:bg-gray-50">
                    {{ $task->project->title }} · task #{{ $task->id }}
                    <span class="text-sm text-gray-500">due {{ $task->due_at?->diffForHumans() }}</span>
                    @if ($task->status->value === 'revision_required')<span class="ml-2 text-sm text-amber-700">revision requested</span>@endif
                </a>
            @empty
                <p class="text-gray-600">Nothing in progress.</p>
            @endforelse
        </section>

        <section class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-3">Claim work</h3>
            @forelse ($projects as $project)
                <form method="POST" action="{{ route('worker.tasks.claim', $project) }}" class="flex justify-between items-center border-b py-2">@csrf
                    <span>{{ $project->title }} <span class="text-sm text-gray-500">({{ $project->available_tasks_count }} available)</span></span>
                    <x-primary-button>Get next task</x-primary-button>
                </form>
            @empty
                <p class="text-gray-600">You are not onboarded on any project yet. <a class="underline" href="{{ route('worker.projects') }}">Browse projects</a>.</p>
            @endforelse
        </section>

        <section class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-3">Earnings</h3>
            @forelse ($earnings as $e)
                <div class="flex justify-between border-b py-1 text-sm">
                    <span>Submission #{{ $e->task_submission_id }}</span>
                    <span>{{ $e->currency }} {{ number_format($e->amount_minor / 100, 2) }} · {{ $e->status->value }}</span>
                </div>
            @empty
                <p class="text-gray-600">No earnings yet.</p>
            @endforelse
        </section>
    </div>
</x-app-layout>
