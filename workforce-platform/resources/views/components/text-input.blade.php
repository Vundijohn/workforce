@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-outlier-500 focus:ring-4 focus:ring-outlier-500/10 rounded-2xl shadow-sm text-sm py-3 px-4 bg-white text-ink-900 placeholder-ink-400 transition duration-150']) }}>
