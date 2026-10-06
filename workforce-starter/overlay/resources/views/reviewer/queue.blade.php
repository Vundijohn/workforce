<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Review queue</h2></x-slot>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))<div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('status') }}</div>@endif
        <div class="bg-white shadow sm:rounded-lg p-6">
            @forelse ($submissions as $s)
                <a href="{{ route('reviewer.review.show', $s) }}" class="block border-b py-2 hover:bg-gray-50">
                    {{ $s->task->project->title }} · submission #{{ $s->id }}
                    <span class="text-sm text-gray-500">{{ $s->submitted_at->diffForHumans() }}</span>
                </a>
            @empty
                <p class="text-gray-600">The queue is empty.</p>
            @endforelse
            <div class="mt-4">{{ $submissions->links() }}</div>
        </div>
    </div>
</x-app-layout>
