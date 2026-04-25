@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#7C3AED] focus:ring-[#7C3AED] rounded-lg shadow-sm']) }}>
