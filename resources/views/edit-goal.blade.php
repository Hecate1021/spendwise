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
        <x-sidebar.nav />

        {{-- main --}}
        <div class="h-full w-full md:pl-0 md:pr-6 md:py-10 overflow-hidden">
            <div
                class="flex flex-col bg-neutral-50 h-full md:rounded-3xl px-6 md:px-10 py-8 overflow-y-auto lg:overflow-hidden no-scrollbar">
                <div class="flex items-center justify-between " id="heading">
                    <div class="bg-neutral-50 fixed md:static w-full pt-10 md:pt-0 z-0">
                        <h1 class="text-2xl md:text-3xl font-semibold py-5 md:py-0">{{ $page }}</h1>
                    </div>

                </div>

                {{-- content --}}
                <div class="mt-20 md:mt-6 mx-auto w-full md:w-2/3 lg:w-1/3">
                    <form action="/edit-goal/{{ $goals['id'] }}" method="POST" class="flex flex-col gap-4">
                        @csrf

                        <x-forms.form type="text">
                            <x-slot:label>
                                Goal Title
                            </x-slot:label>

                            <x-slot:id>
                                title
                            </x-slot:id>

                            <x-slot:value>
                                {{ $goals['title'] }}
                            </x-slot:value>

                        </x-forms.form>

                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full rounded-lg border-gray-300 focus:border-[#00ADB5] focus:ring-[#00ADB5]"
                                placeholder="Enter your goal description">{{ $goals['description'] ?? '' }}</textarea>
                        </div>


                        <x-forms.form type="number">
                            <x-slot:label>
                                Amount Target
                            </x-slot:label>

                            <x-slot:id>
                                target_amount
                            </x-slot:id>

                            <x-slot:value>
                                {{ $goals['target_amount'] }}
                            </x-slot:value>
                        </x-forms.form>

                        <x-forms.form type="date" value="{{ date('Y-m-d') }}">
                            <x-slot:label>
                                Aim Date
                            </x-slot:label>

                            <x-slot:id>
                                aim_date
                            </x-slot:id>

                            <x-slot:value>
                                {{ $goals['aim_date'] }}
                            </x-slot:value>
                        </x-forms.form>

                        <div class="flex justify-between gap-4 items-center">
                            <a href="/delete-expense/{{ $goals['id'] }}"
                                class="mt-6 bg-red-600 text-white rounded-3xl px-4 py-2 font-semibold w-full text-center text-sm lg:text-base">Delete</a>
                            <button type="submit"
                                class="mt-6 bg-[#222831] text-white rounded-3xl px-4 py-2 font-semibold w-full text-sm lg:text-base">Edit
                                Goal</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

    @vite('resources/js/app.js')
</body>

</html>
