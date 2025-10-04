<div>
    <div {{ $attributes->class(['bg-[#222831] text-[#EEEEEE] rounded-2xl']) }}>
        <span class="{{ $spanClass }}">You spent</span>
        <h1 class="mt-2 lg:mt-4 {{ $h1Class }} font-bold">{{ number_format($total, 0, ',', ',') }}</h1>

        <div class="flex justify-between items-center mt-4 lg:mt-6">
            <span class="{{ $spanClass }}">{{ $spanText }}</span>
            <span class="{{ $spanClass }}">{{ $date }}</span>
        </div>
    </div>
</div>
