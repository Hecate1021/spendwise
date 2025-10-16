<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('images/logo/logobg.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>SpendWise — Admin Dashboard</title>
</head>

<body class="bg-[#EEEEEE] h-screen text-[#222831] overflow-hidden">
    <div class="flex h-full">
        {{-- Sidebar --}}
        <x-sidebar.adminNav />

        {{-- Main --}}
        <div class="h-full w-full md:pl-0 md:pr-6 md:py-6 overflow-hidden">
            <div class="flex flex-col bg-neutral-50 h-full md:rounded-3xl px-6 md:px-10 py-6 overflow-y-auto no-scrollbar">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="bg-neutral-50 fixed md:static w-full pt-6 md:pt-0 z-0">
                        <h1 class="text-3xl font-bold">{{ $page }}</h1>
                        <p class="text-gray-500 text-sm">Welcome, {{ $username }} 👋</p>
                    </div>
                    <div class="hidden md:block">
                        <x-profile-picture.profile-picture
                            src="{{ asset('images/logo/logobg.png') }}"
                            alt="Profile Picture" width="w-16" height="h-16" />
                    </div>
                </div>

                {{-- Alert --}}
                @if (session('success'))
                    <x-alerts.success-alert
                        class="mt-4 {{ session('success') == 'Expense deleted successfully!' ? 'bg-red-500' : 'bg-teal-500' }}">
                        {{ session('success') }}
                    </x-alerts.success-alert>
                @endif

                {{-- Content --}}
                <div class="mt-16 lg:mt-8 flex flex-col gap-6 overflow-visible">
                    {{-- User List Section --}}
                    <div class="flex flex-col w-full border-solid border-2 border-[#EEEEEE] rounded-2xl bg-white shadow-sm">
                        {{-- Header --}}
                        <div class="flex justify-between items-center p-6 border-b border-gray-200">
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold flex items-center gap-3">
                                    👥 User List
                                    <span class="bg-blue-600 text-white text-sm font-semibold px-3 py-1 rounded-full">
                                        {{ $users->count() }}
                                    </span>
                                </h1>
                                <p class="text-sm text-gray-500 mt-1">{{ date('F Y') }}</p>
                            </div>

                            {{-- Optional Search Bar --}}
                            <input type="text" placeholder="Search users..."
                                class="hidden md:block border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"
                                onkeyup="filterUsers(this.value)">
                        </div>

                        {{-- User Cards --}}
                        <div class="flex flex-col gap-4 px-6 pb-6 overflow-y-auto max-h-[500px] pt-4" id="user-list">
                            @forelse ($users as $user)
                                <div
                                    class="flex items-center justify-between bg-neutral-50 rounded-xl border border-gray-200 shadow-sm p-4 hover:shadow-md hover:bg-gray-50 transition">
                                    <div class="flex items-center gap-4">
                                        {{-- Profile Picture --}}
                                        <img src="{{ $user->profilePicture ? asset('storage/' . $user->profilePicture) : asset('images/default-avatar.png') }}"
                                            alt="Profile Picture"
                                            class="w-12 h-12 rounded-full object-cover border border-gray-300">

                                        {{-- User Info --}}
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $user->username }}</h3>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>

                                    {{-- Role Badge --}}
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 py-10 font-medium">No users found</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    @vite('resources/js/app.js')
    @vite('resources/js/jquery-3.7.1.min.js')
    @vite('resources/js/alert.js')

    {{-- 🔍 Optional: Live search filter --}}
    <script>
        function filterUsers(query) {
            const cards = document.querySelectorAll('#user-list > div');
            query = query.toLowerCase();
            cards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const email = card.querySelector('p').textContent.toLowerCase();
                card.style.display = name.includes(query) || email.includes(query) ? '' : 'none';
            });
        }
    </script>
</body>

</html>
