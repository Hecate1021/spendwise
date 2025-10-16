<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/logo/logobg.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>SpendWise - User Feedback</title>
</head>
<body class="bg-[#EEEEEE] h-screen text-[#222831] overflow-hidden">
<div class="flex h-full">
    <x-sidebar.adminNav />

    <div class="h-full w-full md:pl-0 md:pr-6 md:py-10 overflow-hidden">
        <div class="flex flex-col bg-neutral-50 h-full md:rounded-3xl px-6 md:px-10 py-8 overflow-y-auto no-scrollbar">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl md:text-3xl font-semibold">{{ $page }}</h1>
                <div class="bg-teal-500 text-white px-5 py-2 rounded-full shadow font-semibold text-sm">
                    Total Users: {{ $users->count() }}
                </div>
            </div>

            {{-- User Feedback List --}}
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse ($users as $user)
                    <a href="{{ route('admin.feedback.show', $user->id) }}"
                       class="flex items-center gap-4 bg-white rounded-2xl shadow p-4 hover:shadow-lg hover:bg-gray-50 transition">
                        <img
                            src="{{ $user->profilePicture ? asset('storage/'.$user->profilePicture) : asset('images/default-avatar.png') }}"
                            alt="Profile Picture"
                            class="w-14 h-14 rounded-full border border-gray-300 object-cover">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $user->username }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <p class="text-xs text-gray-400 mt-1">Feedbacks: {{ $user->feedbacks_count }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-center text-gray-500 font-semibold col-span-full mt-10">No feedback yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</div>
</body>
</html>
