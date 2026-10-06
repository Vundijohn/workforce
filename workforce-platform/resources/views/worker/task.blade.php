<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $task->project->title }} · task #{{ $task->id }}</h2></x-slot>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <section class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-2">Instructions</h3>
            <div class="whitespace-pre-line text-gray-700">{{ $task->project->instructions }}</div>
        </section>
        <section class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-2">Task</h3>
            <div class="whitespace-pre-line">{{ $task->payload['prompt'] ?? '' }}</div>
        </section>
        @can('submit', $task)
            <form method="POST" action="{{ route('worker.tasks.submit', $task) }}" class="bg-white shadow sm:rounded-lg p-6 space-y-3">@csrf
                <x-input-label for="answer" value="Your response" />
                <textarea id="answer" name="answer" rows="8" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('answer') }}</textarea>
                <x-input-error :messages="$errors->get('answer')" />
                <x-primary-button>Submit for review</x-primary-button>
            </form>
        @endcan
    </div>
</x-app-layout>
