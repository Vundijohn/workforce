<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-ink-900 font-display">Create Your Expert Account</h2>
        <p class="text-sm text-ink-500 mt-1">Join the frontier AI training network</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-ink-700 mb-1.5">Full Name</label>
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Dr. Jane Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-ink-700 mb-1.5">Email address</label>
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@domain.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-ink-700 mb-1.5">Password</label>
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="At least 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-ink-700 mb-1.5">Confirm Password</label>
            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Re-type password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full py-3.5 text-base">
                {{ __('Create Expert Account') }}
            </x-primary-button>
        </div>

        <div class="pt-4 text-center border-t border-gray-100">
            <p class="text-xs text-ink-500">
                Already have an account?
                <a href="{{ route('login') }}" class="font-bold text-outlier-600 hover:text-outlier-700 ml-1">
                    Log in here →
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
