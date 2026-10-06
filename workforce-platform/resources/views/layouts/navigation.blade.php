<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-200/70 sticky top-0 z-50 transition-all duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex items-center gap-10">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group transition-transform hover:scale-[1.02]">
                        <x-application-logo />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:gap-2">
                    @can('work_on_tasks')
                        <a href="{{ route('worker.tasks') }}"
                           class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-150 {{ request()->routeIs('worker.tasks*') ? 'bg-ink-900 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900 hover:bg-gray-100/80' }}">
                            My Work
                        </a>
                        <a href="{{ route('worker.projects') }}"
                           class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-150 {{ request()->routeIs('worker.projects*') ? 'bg-ink-900 text-white shadow-sm' : 'text-ink-600 hover:text-ink-900 hover:bg-gray-100/80' }}">
                            Opportunities
                        </a>
                    @endcan

                    @can('review_submissions')
                        <a href="{{ route('reviewer.queue') }}"
                           class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-150 {{ request()->routeIs('reviewer.*') ? 'bg-outlier-500 text-white shadow-sm shadow-outlier-500/20' : 'text-ink-600 hover:text-ink-900 hover:bg-gray-100/80' }}">
                            Review Queue
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-ink-600 border border-gray-200/60 uppercase tracking-wider">
                    {{ Auth::user()->roles->first()?->name ?? 'Member' }}
                </span>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold rounded-full text-ink-900 hover:bg-gray-100/80 border border-gray-200/80 bg-white transition duration-150 shadow-sm">
                            <span class="w-6 h-6 rounded-full bg-outlier-100 text-outlier-700 flex items-center justify-center text-xs font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-3.5 w-3.5 text-ink-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 text-xs text-ink-400 border-b border-gray-100">
                            Signed in as<br>
                            <span class="font-medium text-ink-800 text-xs">{{ Auth::user()->email }}</span>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="text-sm">
                            {{ __('Account Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-sm text-red-600 hover:text-red-700 hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-full text-ink-500 hover:text-ink-900 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200/80 bg-white/95 backdrop-blur-md">
        <div class="pt-3 pb-3 space-y-1.5 px-4">
            @can('work_on_tasks')
                <x-responsive-nav-link :href="route('worker.tasks')" :active="request()->routeIs('worker.tasks*')" class="rounded-xl">
                    {{ __('My Work') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('worker.projects')" :active="request()->routeIs('worker.projects*')" class="rounded-xl">
                    {{ __('Opportunities') }}
                </x-responsive-nav-link>
            @endcan

            @can('review_submissions')
                <x-responsive-nav-link :href="route('reviewer.queue')" :active="request()->routeIs('reviewer.*')" class="rounded-xl">
                    {{ __('Review Queue') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-gray-200/80 px-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-outlier-100 text-outlier-700 flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-semibold text-sm text-ink-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-ink-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Account Settings') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600 font-medium">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
