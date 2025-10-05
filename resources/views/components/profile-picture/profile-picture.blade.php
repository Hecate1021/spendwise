@props([
    'src',
    'width' => 'w-24',   // Tailwind size (96px)
    'height' => 'h-24',
    'alt' => 'Profile Picture',
])

<div class="relative {{ $width }} {{ $height }}">
    <img src="{{ $src }}" 
         alt="{{ $alt }}" 
         class="{{ $width }} {{ $height }} rounded-full object-cover border border-gray-300">
</div>
