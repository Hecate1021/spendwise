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

<body class="bg-neutral-50 md:bg-[#EEEEEE] h-screen text-[#222831]">
    <div class="flex justify-center w-full h-full items-center">
        <div class="bg-neutral-50 w-full md:w-1/2 xl:w-1/3 md:rounded-3xl p-8 px-10">
            <h1 class="text-2xl md:text-3xl font-bold text-center md:text-left">Log In</h1>

            {{-- alert --}}
            @if (session('success'))
                <x-alerts.success-alert class="mt-4 bg-teal-500">
                    <x-slot:status>
                        success
                    </x-slot:status>
                    {{ session('success') }}
                </x-alerts.success-alert>
            @endif

            @if (session('error'))
                <x-alerts.success-alert class="mt-4 bg-red-500">
                    <x-slot:status>
                        Error
                    </x-slot:status>
                    {{ session('error') }}
                </x-alerts.success-alert>
            @endif

            <form action="" method="POST" class="flex flex-col gap-2 mt-6">
                @csrf
                <x-forms.form type="text">
                    <x-slot:label>
                        Username
                    </x-slot:label>
                    <x-slot:id>
                        username
                    </x-slot:id>
                </x-forms.form>

                <x-forms.form type="password">
                    <x-slot:label>
                        Password
                    </x-slot:label>
                    <x-slot:id>
                        password
                    </x-slot:id>
                </x-forms.form>

                <a href="/register" class="text-[#222831] text-sm underline">Don't have an account? Sign Up</a>

                <button type="submit" class="mt-6 bg-[#222831] text-white rounded-3xl px-4 py-2 font-semibold w-full text-sm lg:text-base">Log In</button>

            </form>
        </div>
    </div>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/js/jquery-3.7.1.min.js')
    @vite('resources/js/alert.js')
</body>
</html>
