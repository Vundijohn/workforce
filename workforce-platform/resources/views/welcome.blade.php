<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workforce Platform · Train the Next Generation of AI as an Expert</title>

    <meta name="description" content="What is Workforce Platform? A platform for building AI with expert human input. Join a global community of specialists training frontier models.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-ink-900 bg-[#F8F9FA] selection:bg-outlier-500 selection:text-white">

    <!-- Ambient Mesh Glow Background -->
    <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-20 w-[600px] h-[600px] bg-gradient-to-br from-outlier-200/50 via-pink-100/40 to-transparent rounded-full blur-3xl opacity-70"></div>
        <div class="absolute top-10 right-0 w-[550px] h-[550px] bg-gradient-to-bl from-sky-200/50 via-teal-100/30 to-transparent rounded-full blur-3xl opacity-60"></div>
        <div class="absolute top-[40%] left-[25%] w-[700px] h-[700px] bg-gradient-to-r from-outlier-100/30 via-indigo-100/20 to-transparent rounded-full blur-3xl opacity-50"></div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/60 transition-all">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-1.5 group">
                <span class="font-extrabold text-2xl tracking-tight text-ink-900 font-display">
                    Workforce<span class="text-outlier-500">.</span>
                </span>
                <span class="text-[10px] tracking-widest uppercase font-bold px-2.5 py-0.5 rounded-full bg-outlier-100 text-outlier-700 border border-outlier-200/60 ml-0.5">
                    Platform
                </span>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-ink-600">
                <a href="#how-it-works" class="hover:text-ink-900 transition-colors">How It Works</a>
                <a href="#capabilities" class="hover:text-ink-900 transition-colors">What You'll Do</a>
                <a href="#benefits" class="hover:text-ink-900 transition-colors">Why Workforce Platform</a>
                <a href="#faqs" class="hover:text-ink-900 transition-colors">FAQs</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center px-5 py-2.5 rounded-full text-sm font-semibold bg-ink-900 text-white hover:bg-black transition shadow-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center px-5 py-2.5 rounded-full text-sm font-semibold text-ink-800 hover:text-ink-900 border border-ink-900/20 hover:border-ink-900 bg-white/70 hover:bg-white transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center px-6 py-2.5 rounded-full text-sm font-semibold text-white bg-outlier-500 hover:bg-outlier-600 shadow-sm shadow-outlier-500/30 transition transform hover:-translate-y-0.5">
                                View Opportunities
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative pt-16 pb-20 md:pt-24 md:pb-28 overflow-hidden text-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Eyebrow Tag -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/80 border border-outlier-200 shadow-sm text-xs font-bold uppercase tracking-wider text-outlier-600 mb-8 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-outlier-500 animate-pulse"></span>
                    <span>Frontier AI Training & Human Feedback</span>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-ink-900 tracking-tight leading-[1.08] font-display mb-6">
                    Become the expert that <span class="bg-gradient-to-r from-outlier-600 via-outlier-500 to-amber-500 bg-clip-text text-transparent">AI learns from</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-lg sm:text-xl text-ink-600 max-w-2xl mx-auto mb-10 leading-relaxed font-normal">
                    Join over 900,000+ domain specialists, researchers, coders, and writers shaping the next generation of artificial intelligence. Work remotely, get paid reliably.
                </p>

                <!-- CTA Button Group -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                    <a href="{{ route('register') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full text-base font-bold text-white bg-outlier-500 hover:bg-outlier-600 shadow-lg shadow-outlier-500/25 transition-all transform hover:-translate-y-0.5">
                        <span>Get Started as an Expert</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>

                    <a href="#how-it-works"
                       class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-full text-base font-semibold text-ink-700 bg-white hover:bg-gray-50 border border-gray-200 shadow-sm transition">
                        Explore How It Works
                    </a>
                </div>

                <!-- Metric Highlights -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-3xl mx-auto pt-6 border-t border-gray-200/60">
                    <div class="p-3">
                        <div class="text-2xl sm:text-3xl font-extrabold text-ink-900 font-display">$500M+</div>
                        <div class="text-xs text-ink-500 mt-0.5 font-medium">Paid to Experts</div>
                    </div>
                    <div class="p-3">
                        <div class="text-2xl sm:text-3xl font-extrabold text-ink-900 font-display">900K+</div>
                        <div class="text-xs text-ink-500 mt-0.5 font-medium">Specialists Worldwide</div>
                    </div>
                    <div class="p-3">
                        <div class="text-2xl sm:text-3xl font-extrabold text-ink-900 font-display">50+</div>
                        <div class="text-xs text-ink-500 mt-0.5 font-medium">Countries Active</div>
                    </div>
                    <div class="p-3">
                        <div class="text-2xl sm:text-3xl font-extrabold text-ink-900 font-display">4.8 / 5</div>
                        <div class="text-xs text-ink-500 mt-0.5 font-medium">Expert Satisfaction</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Floating Domain Specialist Cards -->
        <section class="py-12 bg-white/50 border-y border-gray-200/50 backdrop-blur-sm">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-xl mx-auto mb-10">
                    <span class="text-xs font-bold text-outlier-600 uppercase tracking-widest">Global Talent Network</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-ink-900 mt-1">Specialists Across Every Discipline</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- Expert 1 -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-soft hover:shadow-card transition duration-200 group">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-100 to-outlier-200 text-outlier-700 flex items-center justify-center font-bold text-lg">
                                SC
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-ink-900">Dr. Sarah Chen</h3>
                                <p class="text-xs text-ink-500">PhD, AI Alignment</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-3 text-xs text-ink-700 leading-relaxed">
                            "Rating complex prompt outputs and crafting mathematical edge cases keeps my domain skills razor sharp."
                        </div>
                        <div class="mt-4 flex items-center justify-between text-[11px] text-ink-400">
                            <span class="font-semibold text-emerald-600">Active Reviewer</span>
                            <span>Top 1% Contributor</span>
                        </div>
                    </div>

                    <!-- Expert 2 -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-soft hover:shadow-card transition duration-200 group">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-100 to-blue-200 text-blue-700 flex items-center justify-center font-bold text-lg">
                                JO
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-ink-900">John Ochieng</h3>
                                <p class="text-xs text-ink-500">Staff Software Engineer</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-3 text-xs text-ink-700 leading-relaxed">
                            "I review code explanations and test LLM debugging accuracy in Python and Rust with full schedule flexibility."
                        </div>
                        <div class="mt-4 flex items-center justify-between text-[11px] text-ink-400">
                            <span class="font-semibold text-emerald-600">Active Contributor</span>
                            <span>KES 250 / task</span>
                        </div>
                    </div>

                    <!-- Expert 3 -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-soft hover:shadow-card transition duration-200 group">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-100 to-fuchsia-200 text-purple-700 flex items-center justify-center font-bold text-lg">
                                MR
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-ink-900">Maria Rodriguez</h3>
                                <p class="text-xs text-ink-500">Computational Linguistics</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-3 text-xs text-ink-700 leading-relaxed">
                            "Grading multi-turn conversational nuances in multilingual settings provides steady earnings between research semesters."
                        </div>
                        <div class="mt-4 flex items-center justify-between text-[11px] text-ink-400">
                            <span class="font-semibold text-emerald-600">Active Reviewer</span>
                            <span>Oxford Fellow</span>
                        </div>
                    </div>

                    <!-- Expert 4 -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-soft hover:shadow-card transition duration-200 group">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-200 text-teal-700 flex items-center justify-center font-bold text-lg">
                                DA
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-ink-900">David Adebayo</h3>
                                <p class="text-xs text-ink-500">MSc, Pure Mathematics</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-3 text-xs text-ink-700 leading-relaxed">
                            "Creating challenging step-by-step proofs for frontier reasoners is both intellectually engaging and rewarding."
                        </div>
                        <div class="mt-4 flex items-center justify-between text-[11px] text-ink-400">
                            <span class="font-semibold text-emerald-600">Active Contributor</span>
                            <span>Verified STEM</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive "What You Will Do" Tabbed Feature Section -->
        <section id="capabilities" class="py-24" x-data="{ tab: 'rate' }">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-xs font-bold text-outlier-600 uppercase tracking-widest">The Core Work</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-ink-900 tracking-tight mt-1 font-display">
                        What you will do on Workforce Platform
                    </h2>
                    <p class="text-ink-600 mt-3 text-base">
                        Frontier models require nuanced human judgment that simple algorithms cannot replicate.
                    </p>
                </div>

                <!-- Tab Pills -->
                <div class="flex justify-center mb-10">
                    <div class="inline-flex p-1.5 rounded-full bg-gray-200/70 backdrop-blur-sm border border-gray-300/40 gap-1">
                        <button @click="tab = 'rate'"
                                :class="tab === 'rate' ? 'bg-white text-ink-900 shadow-sm' : 'text-ink-600 hover:text-ink-900'"
                                class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition duration-150">
                            Rate & Compare Answers
                        </button>
                        <button @click="tab = 'prompt'"
                                :class="tab === 'prompt' ? 'bg-white text-ink-900 shadow-sm' : 'text-ink-600 hover:text-ink-900'"
                                class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition duration-150">
                            Write Challenging Prompts
                        </button>
                        <button @click="tab = 'rubric'"
                                :class="tab === 'rubric' ? 'bg-white text-ink-900 shadow-sm' : 'text-ink-600 hover:text-ink-900'"
                                class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition duration-150">
                            Create Grading Rubrics
                        </button>
                    </div>
                </div>

                <!-- Tab 1: Rate & Compare -->
                <div x-show="tab === 'rate'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" class="bg-white rounded-4xl p-8 sm:p-12 border border-gray-200/80 shadow-soft">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                        <div class="lg:col-span-5 space-y-5">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-outlier-100 text-outlier-700">
                                RLHF & Model Comparison
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-ink-900 font-display">
                                Evaluate two model outputs side by side
                            </h3>
                            <p class="text-ink-600 text-sm sm:text-base leading-relaxed">
                                Inspect competing AI answers for factual correctness, reasoning soundness, and clarity. Score them against strict rubrics and provide the corrective rewrite that trains the model.
                            </p>
                            <div class="space-y-2.5 pt-2">
                                <div class="flex items-center gap-3 text-sm text-ink-700 font-medium">
                                    <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">✓</span>
                                    <span>Identify subtle hallucinations and false citations</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-ink-700 font-medium">
                                    <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">✓</span>
                                    <span>Reward deep multi-step logical coherence</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm text-ink-700 font-medium">
                                    <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">✓</span>
                                    <span>Provide expert justification for each grade</span>
                                </div>
                            </div>
                        </div>

                        <!-- Mockup Card -->
                        <div class="lg:col-span-7 bg-[#F8F9FA] rounded-3xl p-6 border border-gray-200/80 shadow-inner">
                            <div class="bg-white rounded-2xl p-5 border border-gray-200/60 shadow-sm space-y-4">
                                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <span class="text-xs font-bold text-ink-500 uppercase">Prompt: Rayleigh Scattering in Atmospheric Optics</span>
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">Project Active</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    <div class="p-3 rounded-xl bg-gray-50 border border-gray-200/80">
                                        <div class="font-bold text-ink-900 mb-1">Response A</div>
                                        <p class="text-ink-600 line-clamp-3">Light scatters in the air because of molecules. Blue has short wavelengths, which bounce more than red wavelengths...</p>
                                        <div class="mt-3 flex items-center gap-1 text-amber-500">★★★★☆ <span class="text-ink-400 text-[10px] ml-1">4.2 / 5</span></div>
                                    </div>
                                    <div class="p-3 rounded-xl bg-outlier-50/50 border border-outlier-200">
                                        <div class="font-bold text-outlier-900 mb-1 flex items-center justify-between">
                                            <span>Response B</span>
                                            <span class="text-[10px] bg-outlier-500 text-white font-bold px-1.5 py-0.2 rounded">Preferred</span>
                                        </div>
                                        <p class="text-ink-700 line-clamp-3">Rayleigh scattering intensity is inversely proportional to the 4th power of wavelength (1/λ⁴), meaning 400nm blue scatters ~10x more than 700nm red...</p>
                                        <div class="mt-3 flex items-center gap-1 text-amber-500">★★★★★ <span class="text-outlier-700 font-bold text-[10px] ml-1">5.0 / 5</span></div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3 border border-gray-200 text-xs flex justify-between items-center">
                                    <span class="font-medium text-ink-700">Payout per verified submission:</span>
                                    <span class="font-extrabold text-ink-900 text-sm">KES 250.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Write Prompts -->
                <div x-show="tab === 'prompt'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" class="bg-white rounded-4xl p-8 sm:p-12 border border-gray-200/80 shadow-soft">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                        <div class="lg:col-span-5 space-y-5">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-outlier-100 text-outlier-700">
                                Red Teaming & Stress Testing
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-ink-900 font-display">
                                Create prompts that push models to their limit
                            </h3>
                            <p class="text-ink-600 text-sm sm:text-base leading-relaxed">
                                Author complex questions requiring multi-hop synthesis, tricky boundary constraints, and deep subject-matter knowledge that generic benchmarks miss.
                            </p>
                        </div>
                        <div class="lg:col-span-7 bg-[#F8F9FA] rounded-3xl p-6 border border-gray-200/80 shadow-inner">
                            <div class="bg-white rounded-2xl p-5 border border-gray-200/60 shadow-sm space-y-3 text-xs">
                                <div class="font-bold text-ink-900 text-sm">Prompt Engineering Studio</div>
                                <p class="text-ink-600 bg-gray-50 p-3 rounded-xl border border-gray-200 font-mono text-[11px]">
                                    "Write a valid SQL query with recursive CTEs calculating employee hierarchies, while enforcing that root managers with NULL supervisor IDs are excluded and cyclic loops are halted."
                                </p>
                                <div class="flex items-center gap-2 text-outlier-700 font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-outlier-500"></span>
                                    <span>Constraint Complexity: Level 4 · High Value Task</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Create Rubrics -->
                <div x-show="tab === 'rubric'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" class="bg-white rounded-4xl p-8 sm:p-12 border border-gray-200/80 shadow-soft">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                        <div class="lg:col-span-5 space-y-5">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-outlier-100 text-outlier-700">
                                Quality Standards
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-ink-900 font-display">
                                Establish ground-truth grading criteria
                            </h3>
                            <p class="text-ink-600 text-sm sm:text-base leading-relaxed">
                                Define what makes an answer truly exceptional: factual grounding, structure, tone, and conciseness so that automated evaluators learn human expectations.
                            </p>
                        </div>
                        <div class="lg:col-span-7 bg-[#F8F9FA] rounded-3xl p-6 border border-gray-200/80 shadow-inner">
                            <div class="bg-white rounded-2xl p-5 border border-gray-200/60 shadow-sm space-y-3 text-xs">
                                <div class="font-bold text-ink-900 text-sm">Evaluation Matrix</div>
                                <div class="space-y-2">
                                    <div class="p-2.5 rounded-lg bg-gray-50 border border-gray-200 flex justify-between">
                                        <span class="font-medium text-ink-800">1. Mathematical Soundness</span>
                                        <span class="text-emerald-600 font-bold">Mandatory Pass</span>
                                    </div>
                                    <div class="p-2.5 rounded-lg bg-gray-50 border border-gray-200 flex justify-between">
                                        <span class="font-medium text-ink-800">2. Instruction Following</span>
                                        <span class="text-ink-600 font-bold">100% Match</span>
                                    </div>
                                    <div class="p-2.5 rounded-lg bg-gray-50 border border-gray-200 flex justify-between">
                                        <span class="font-medium text-ink-800">3. Source Hallucination Check</span>
                                        <span class="text-outlier-600 font-bold">Zero Tolerance</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Join Workforce Platform (2x2 Grid) -->
        <section id="benefits" class="py-20 bg-white/60 border-y border-gray-200/60">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-xl mx-auto mb-16">
                    <span class="text-xs font-bold text-outlier-600 uppercase tracking-widest">Why Specialists Choose Us</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-ink-900 tracking-tight mt-1 font-display">
                        Built for freedom and impact
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200/70 shadow-soft hover:shadow-card transition duration-200">
                        <div class="w-12 h-12 rounded-2xl bg-outlier-100 text-outlier-600 flex items-center justify-center font-bold text-xl mb-6">
                            ⏱️
                        </div>
                        <h3 class="text-xl font-bold text-ink-900 mb-2 font-display">100% Flexible & Remote</h3>
                        <p class="text-ink-600 text-sm leading-relaxed">
                            No fixed hours or weekly minimums. Log into your dashboard whenever you have time, claim tasks from open queues, and work from anywhere in the world.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200/70 shadow-soft hover:shadow-card transition duration-200">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xl mb-6">
                            💳
                        </div>
                        <h3 class="text-xl font-bold text-ink-900 mb-2 font-display">Transparent, Reliable Earnings</h3>
                        <p class="text-ink-600 text-sm leading-relaxed">
                            Every approved task records an immediate earning in your local currency. Get paid directly via automated deposits with full audit visibility.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200/70 shadow-soft hover:shadow-card transition duration-200">
                        <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xl mb-6">
                            🧠
                        </div>
                        <h3 class="text-xl font-bold text-ink-900 mb-2 font-display">Direct Frontier AI Impact</h3>
                        <p class="text-ink-600 text-sm leading-relaxed">
                            Work directly with leading AI research labs and top frontier models. Your feedback directly shapes model weights and future breakthroughs.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200/70 shadow-soft hover:shadow-card transition duration-200">
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xl mb-6">
                            📈
                        </div>
                        <h3 class="text-xl font-bold text-ink-900 mb-2 font-display">Clear Merit-Based Promotion</h3>
                        <p class="text-ink-600 text-sm leading-relaxed">
                            Consistent high ratings advance you to Senior Reviewer and Quality Auditor roles, unlocking higher-tier compensation and leadership opportunities.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works (4 Steps) -->
        <section id="how-it-works" class="py-24">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-xl mx-auto mb-16">
                    <span class="text-xs font-bold text-outlier-600 uppercase tracking-widest">Simple Process</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-ink-900 tracking-tight mt-1 font-display">
                        How to get started in 4 steps
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Step 1 -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-200/70 shadow-soft relative">
                        <span class="text-4xl font-extrabold text-outlier-500/20 font-display">01</span>
                        <h3 class="font-bold text-lg text-ink-900 mt-2 mb-2 font-display">Create Your Profile</h3>
                        <p class="text-xs text-ink-600 leading-relaxed">
                            Sign up in seconds, select your domain specialties, and share your background and academic degrees.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-200/70 shadow-soft relative">
                        <span class="text-4xl font-extrabold text-outlier-500/20 font-display">02</span>
                        <h3 class="font-bold text-lg text-ink-900 mt-2 mb-2 font-display">Fast Screening</h3>
                        <p class="text-xs text-ink-600 leading-relaxed">
                            Complete an initial onboarding check to verify your domain skills and instruction compliance.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-200/70 shadow-soft relative">
                        <span class="text-4xl font-extrabold text-outlier-500/20 font-display">03</span>
                        <h3 class="font-bold text-lg text-ink-900 mt-2 mb-2 font-display">Get Engaged</h3>
                        <p class="text-xs text-ink-600 leading-relaxed">
                            Gain access to live project backlogs. Use our single-click claiming mechanism to get assigned work.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-200/70 shadow-soft relative">
                        <span class="text-4xl font-extrabold text-outlier-500/20 font-display">04</span>
                        <h3 class="font-bold text-lg text-ink-900 mt-2 mb-2 font-display">Submit & Earn</h3>
                        <p class="text-xs text-ink-600 leading-relaxed">
                            Reviewers verify submissions, and approved earnings automatically accumulate into your balance.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQs Accordion -->
        <section id="faqs" class="py-20 bg-white/60 border-t border-gray-200/60" x-data="{ active: null }">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-xl mx-auto mb-14">
                    <span class="text-xs font-bold text-outlier-600 uppercase tracking-widest">Got Questions?</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-ink-900 tracking-tight mt-1 font-display">
                        Frequently Asked Questions
                    </h2>
                </div>

                <div class="space-y-3">
                    <!-- Q1 -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden shadow-sm">
                        <button @click="active = (active === 1 ? null : 1)"
                                class="w-full px-6 py-5 text-left flex justify-between items-center font-bold text-base text-ink-900">
                            <span>How and when do I get paid?</span>
                            <span class="text-outlier-500 font-bold text-lg" x-text="active === 1 ? '−' : '+'">+</span>
                        </button>
                        <div x-show="active === 1" class="px-6 pb-5 text-sm text-ink-600 leading-relaxed border-t border-gray-100 pt-3">
                            Approved tasks record earnings immediately in your profile dashboard. Earnings are disbursed regularly in your local currency after standard quality holding windows.
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden shadow-sm">
                        <button @click="active = (active === 2 ? null : 2)"
                                class="w-full px-6 py-5 text-left flex justify-between items-center font-bold text-base text-ink-900">
                            <span>What qualifications do I need to join?</span>
                            <span class="text-outlier-500 font-bold text-lg" x-text="active === 2 ? '−' : '+'">+</span>
                        </button>
                        <div x-show="active === 2" class="px-6 pb-5 text-sm text-ink-600 leading-relaxed border-t border-gray-100 pt-3">
                            We accept specialists across computer science, natural languages, mathematics, biology, law, and creative writing. A university degree or demonstrable industry expertise is required.
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden shadow-sm">
                        <button @click="active = (active === 3 ? null : 3)"
                                class="w-full px-6 py-5 text-left flex justify-between items-center font-bold text-base text-ink-900">
                            <span>How does task claiming work?</span>
                            <span class="text-outlier-500 font-bold text-lg" x-text="active === 3 ? '−' : '+'">+</span>
                        </button>
                        <div x-show="active === 3" class="px-6 pb-5 text-sm text-ink-600 leading-relaxed border-t border-gray-100 pt-3">
                            Once onboarded to a project, simply click "Get next task" in your workspace. Our database locks available tasks for you with a 24-hour completion limit to prevent conflicts.
                        </div>
                    </div>

                    <!-- Q4 -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden shadow-sm">
                        <button @click="active = (active === 4 ? null : 4)"
                                class="w-full px-6 py-5 text-left flex justify-between items-center font-bold text-base text-ink-900">
                            <span>Can I work as a Reviewer?</span>
                            <span class="text-outlier-500 font-bold text-lg" x-text="active === 4 ? '−' : '+'">+</span>
                        </button>
                        <div x-show="active === 4" class="px-6 pb-5 text-sm text-ink-600 leading-relaxed border-t border-gray-100 pt-3">
                            Yes! Contributors who consistently score 5/5 quality ratings on submissions are invited to become Reviewers, where they inspect and approve work submitted by other contributors.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Banner -->
        <section class="py-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-mesh-banner rounded-4xl p-10 sm:p-16 border border-outlier-200 shadow-card text-center relative overflow-hidden">
                    <div class="max-w-2xl mx-auto relative z-10">
                        <span class="inline-block px-3.5 py-1 rounded-full bg-white text-outlier-700 font-bold text-xs uppercase tracking-wider mb-4 shadow-sm">
                            Shape Frontier Intelligence
                        </span>
                        <h2 class="text-3xl sm:text-5xl font-extrabold text-ink-900 tracking-tight font-display mb-4">
                            Ready to build the future of AI?
                        </h2>
                        <p class="text-ink-700 text-base sm:text-lg mb-8 leading-relaxed">
                            Join over 900,000+ domain experts worldwide on Workforce Platform. Work on your own schedule and earn competitively.
                        </p>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-9 py-4 rounded-full text-base font-bold text-white bg-outlier-500 hover:bg-outlier-600 shadow-xl shadow-outlier-500/30 transition transform hover:-translate-y-0.5">
                            <span>Apply as an Expert Today</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Full Footer -->
    <footer class="bg-white border-t border-gray-200/80 py-12 text-ink-600">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-10">
                <div class="max-w-sm">
                    <div class="flex items-center gap-1.5 mb-3">
                        <span class="font-extrabold text-2xl tracking-tight text-ink-900 font-display">
                            Workforce<span class="text-outlier-500">.</span>
                        </span>
                        <span class="text-[10px] tracking-widest uppercase font-bold px-2.5 py-0.5 rounded-full bg-outlier-100 text-outlier-700 border border-outlier-200/60 ml-0.5">
                            Platform
                        </span>
                    </div>
                    <p class="text-xs text-ink-500 leading-relaxed">
                        A global platform for building artificial intelligence with expert human feedback. Train the next generation of models as a remote specialist.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-8 text-xs">
                    <div>
                        <h4 class="font-bold text-ink-900 uppercase tracking-wider mb-3">Platform</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('login') }}" class="hover:text-outlier-600">Expert Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-outlier-600">View Opportunities</a></li>
                            <li><a href="#how-it-works" class="hover:text-outlier-600">How It Works</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-ink-900 uppercase tracking-wider mb-3">Roles</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('register') }}" class="hover:text-outlier-600">AI Trainer</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-outlier-600">Code Reviewer</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-outlier-600">STEM Evaluator</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-ink-900 uppercase tracking-wider mb-3">Legal & Safety</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-outlier-600">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-outlier-600">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-outlier-600">Security</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-ink-400 gap-3">
                <div>
                    © {{ date('Y') }} Workforce Platform. Empowering human-in-the-loop intelligence.
                </div>
                <div class="flex items-center gap-4">
                    <span>English (US)</span>
                    <span>Status: All Systems Operational</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
