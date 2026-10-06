<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 bg-outlier-500 hover:bg-outlier-600 active:bg-outlier-700 border border-transparent rounded-full font-bold text-sm text-white shadow-sm shadow-outlier-500/25 focus:outline-none focus:ring-2 focus:ring-outlier-500 focus:ring-offset-2 transition-all duration-150 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
