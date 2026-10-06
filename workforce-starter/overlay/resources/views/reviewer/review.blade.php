<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Review submission #{{ $submission->id }}</h2></x-slot>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <section class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-2">Instructions</h3>
            <div class="whitespace-pre-line text-gray-700">{{ $submission->task->project->instructions }}</div>
        </section>
        <section class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-2">Task</h3>
            <div class="whitespace-pre-line">{{ $submission->task->payload['prompt'] ?? '' }}</div>
        </section>
        <section class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-2">Worker response</h3>
            <div class="whitespace-pre-line">{{ $submission->response['answer'] ?? '' }}</div>
        </section>
        @can('review', $submission)
            <form method="POST" action="{{ route('reviewer.review.store', $submission) }}" class="bg-white shadow sm:rounded-lg p-6 space-y-3">@csrf
                <x-input-label for="decision" value="Decision" />
                <select id="decision" name="decision" class="border-gray-300 rounded-md">
                    <option value="approved">Approve</option>
                    <option value="revision_requested">Request revision</option>
                    <option value="rejected">Reject</option>
                </select>
                <x-input-label for="score" value="Quality score (1-5)" />
                <input id="score" name="score" type="number" min="1" max="5" class="border-gray-300 rounded-md" />
                <x-input-label for="comments" value="Comments (required unless approving)" />
                <textarea id="comments" name="comments" rows="4" class="w-full border-gray-300 rounded-md">{{ old('comments') }}</textarea>
                <x-input-error :messages="$errors->get('decision')" />
                <x-input-error :messages="$errors->get('comments')" />
                <x-primary-button>Save review</x-primary-button>
            </form>
        @endcan
    </div>
</x-app-layout>
