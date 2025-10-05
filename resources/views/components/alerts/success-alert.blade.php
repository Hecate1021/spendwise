@props(['class' => ''])

<div 
    x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, 3000)" 
    x-show="show"
    x-transition.opacity.duration.700ms
    {{ $attributes->merge(['class' => "relative flex items-center justify-between text-white px-4 py-2 rounded-lg shadow-lg $class"]) }}
>
    <!-- Message -->
    <span>{{ $slot }}</span>

    <!-- Close button -->
    <button 
        type="button" 
        class="ml-4 text-xl font-bold leading-none hover:text-gray-200"
        @click="show = false"
    >
        &times;
    </button>
</div>
