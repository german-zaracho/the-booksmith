@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#f09224] focus:ring-[#f09224] rounded-md shadow-sm']) }}>
