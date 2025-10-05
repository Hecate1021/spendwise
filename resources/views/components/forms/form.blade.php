@props([
    'label',                // The label text
    'id' => null,           // Input ID (optional)
    'type' => 'text',       // Input type (default: text)
    'value' => '',          // Default input value
    'required' => false,    // Whether the field is required
    'size' => 'text-sm',    // Default label size (Tailwind class)
    'inputClass' => 'w-full p-2 border rounded-md' // Default input classes
])

<div>
    <label for="{{ $id ?? $label }}" class="{{ $size }} font-semibold block">
        {{ $label }}
    </label>

    <input 
        type="{{ $type }}" 
        name="{{ $id ?? Str::slug($label, '_') }}" 
        id="{{ $id ?? Str::slug($label, '_') }}" 
        value="{{ $value }}" 
        @if($required) required @endif
        class="{{ $inputClass }}"
    >
</div>
