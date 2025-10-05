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
<body class="bg-[#EEEEEE] h-screen">

    {{-- container --}}
    <div class="flex h-full">

        {{-- sidebar --}}
        <x-sidebar.nav/>

        {{-- main --}}
        <div class="h-full w-full md:pl-0 md:pr-6 md:py-10 overflow-hidden">
            <div class="flex flex-col bg-neutral-50 h-full md:rounded-3xl px-6 md:px-10 py-8 overflow-y-auto lg:overflow-hidden no-scrollbar">
                <div class="flex items-center justify-between " id="heading">
                    <div class="bg-neutral-50 fixed md:static w-full pt-10 md:pt-0 z-0">
                        <h1 class="text-2xl md:text-3xl font-semibold py-5 md:py-0">{{ $page }}</h1>
                    </div>

                </div>

                {{-- content --}}
                <div class="mt-20 md:mt-6 mx-auto w-full md:w-2/3 lg:w-1/3">
                    <form action="/edit-income/{{ $incomes['id'] }}" method="POST" class="flex flex-col gap-4">
                        @csrf

                        <x-forms.form type="text">
                            <x-slot:label>
                                Income Soure
                            </x-slot:label>

                            <x-slot:id>
                                income_source
                            </x-slot:id>

                            <x-slot:value>
                                {{ $incomes['income_source'] }}
                            </x-slot:value>
                        </x-forms.form>

                        <x-forms.form type="number">
                            <x-slot:label>
                                Amount
                            </x-slot:label>

                            <x-slot:id>
                                total
                            </x-slot:id>

                            <x-slot:value>
                                {{ $incomes['total'] }}
                            </x-slot:value>
                        </x-forms.form>

                        <x-forms.form type="date" value="{{ date('Y-m-d') }}">
                            <x-slot:label>
                                Date
                            </x-slot:label>

                            <x-slot:id>
                                date
                            </x-slot:id>

                            <x-slot:value>
                                {{ $incomes['date'] }}
                            </x-slot:value>
                        </x-forms.form>

                        <div class="flex justify-between gap-4 items-center">
                            <a href="/delete-income/{{ $incomes['id'] }}" class="mt-6 bg-red-600 text-white rounded-3xl px-4 py-2 font-semibold w-full text-center text-sm lg:text-base">Delete</a>
                            <button type="submit" class="mt-6 bg-[#222831] text-white rounded-3xl px-4 py-2 font-semibold w-full text-sm lg:text-base">Edit Expense</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    @vite('resources/js/app.js')
</body>
</html>
