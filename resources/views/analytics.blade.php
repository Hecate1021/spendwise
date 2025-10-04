<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('images/logo/logobg.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>SpendWise</title>
</head>
<body class="bg-[#EEEEEE] h-screen text-[#222831]">

    {{-- container --}}
    <div class="flex h-full">

        {{-- sidebar --}}
        <x-sidebar.nav/>

        {{-- main --}}
        <div class="h-full w-full md:pl-0 md:pr-6 md:py-10 overflow-hidden">
            <div class="flex flex-col bg-neutral-50 h-full md:rounded-3xl px-6 md:px-10 py-8 overflow-y-auto lg:overflow-hidden no-scrollbar">
                {{-- headings --}}
                <div class="flex items-center justify-between bg-neutral-50" id="heading">
                    <div class="flex items-center justify-between" id="heading">
                        <div class="bg-neutral-50 fixed md:static w-full z-0">
                            <h1 class="text-2xl md:text-3xl font-semibold py-5 md:py-0">{{ $page }}</h1>
                        </div>
                    </div>

                    {{-- search --}}
                    <div class="w-full md:w-auto">
                        <form action="" method="">
                            <div class="inline-flex items-center gap-2 bg-[#EEEEEE] px-4 py-2 rounded-3xl w-4/5 md:w-auto">
                                <label for="search" class="bg-transparent">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="size-5 text-[#222831]"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314"/></svg>
                                </label>
                                <input type="text" name="search" id="search" placeholder="Search" class="bg-transparent focus:outline-none text-md">
                            </div>
                        </form>
                    </div>
                </div>

                {{-- content --}}
                <h1 class="mt-10 text-lg md:text-xl font-semibold">Transaction History</h1>

                <div class="mt-4 flex flex-col gap-2 overflow-y-auto no-scrollbar transaction-container">
                    @if (count($transactions) == 0)
                        <span class="mt-10 text-md font-semibold text-center text-gray-500 w-full">No transactions yet</span>
                    @else
                        @foreach ($transactions as $transaction)
                            <a href="expense/{{ $transaction['id'] }}">
                                <x-cards.transaction-card>
                                    <x-slot:expense>
                                        {{ $transaction['expense'] }}
                                    </x-slot:expense>

                                    <x-slot:total>
                                       P {{ number_format($transaction['total'], 0, '.', ',') }}
                                    </x-slot:total>

                                    <x-slot:date>
                                        {{ date('d M Y', strtotime($transaction['date'])) }}
                                    </x-slot:date>
                                </x-cards.transaction-card>
                            </a>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>

    </div>

    @vite('resources/js/jquery-3.7.1.min.js')
    @vite('resources/js/app.js')
    @vite('resources/js/analytics.js')
</body>
</html>
