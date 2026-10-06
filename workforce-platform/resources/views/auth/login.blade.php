<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-ink-900 font-display">Welcome back</h2>
        <p class="text-sm text-ink-500 mt-1">Sign in to your expert dashboard</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-ink-700 mb-1.5">Email address</label>
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-ink-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-outlier-600 hover:text-outlier-700" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-outlier-500 shadow-sm focus:ring-outlier-500/20" name="remember">
                <span class="ms-2 text-xs font-medium text-ink-600">{{ __('Keep me signed in') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full py-3.5 text-base">
                {{ __('Sign In to Workforce Platform') }}
            </x-primary-button>
        </div>

        <div class="pt-4 text-center border-t border-gray-100">
            <p class="text-xs text-ink-500">
                Don't have an account yet?
                <a href="{{ route('register') }}" class="font-bold text-outlier-600 hover:text-outlier-700 ml-1">
                    Apply as an Expert →
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
