<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>{{ $page }}</title>
</head>
<body class="bg-[#EEEEEE] h-screen text-[#222831] overflow-hidden">
<div class="flex h-full">
    <x-sidebar.adminNav />

    <div class="h-full w-full md:pl-0 md:pr-6 md:py-10 overflow-hidden">
        <div class="flex flex-col bg-neutral-50 h-full md:rounded-3xl px-6 md:px-10 py-8 overflow-y-auto no-scrollbar">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-semibold">{{ $page }}</h1>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
                <a href="{{ route('admin.feedback.index') }}" class="text-sm text-gray-600 hover:text-teal-600">&larr; Back to list</a>
            </div>

            {{-- Conversation --}}
<div id="messages-container"
     class="bg-white rounded-2xl shadow p-6 flex flex-col gap-4 max-h-[500px] overflow-y-auto scroll-smooth">
    @forelse ($feedbacks as $feedback)
        <div class="text-left">
            <div class="inline-block bg-gray-100 px-4 py-2 rounded-xl text-gray-800">
                <strong>{{ $user->username }}:</strong> {{ $feedback->message }}
            </div>
            <div class="text-xs text-gray-500 mt-1 ml-2">{{ $feedback->created_at->diffForHumans() }}</div>

            {{-- Replies --}}
            @foreach ($feedback->replies as $reply)
                <div class="text-right mt-2">
                    <div class="inline-block bg-teal-100 px-4 py-2 rounded-xl text-gray-800">
                        <strong>Admin:</strong> {{ $reply->message }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">{{ $reply->created_at->diffForHumans() }}</div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-center text-gray-500 font-semibold py-10">No feedback yet.</p>
    @endforelse
</div>

            {{-- Reply Form --}}
            <form action="{{ route('admin.feedback.reply', $feedbacks->last()?->id ?? 0) }}" method="POST" class="mt-6">
                @csrf
                <div class="flex gap-3">
                    <input type="text" name="message" placeholder="Type a reply..."
                           class="w-full border rounded-xl px-4 py-2 focus:ring-teal-400 focus:border-teal-400 text-sm">
                    <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-xl hover:bg-teal-600">Send</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("messages-container");

        // Function to scroll smoothly to the bottom
        const scrollToBottom = () => {
            container.scrollTop = container.scrollHeight;
        };

        // Initial scroll on page load
        scrollToBottom();

        // Optional: scroll again if content changes (for live updates or replies)
        const observer = new MutationObserver(scrollToBottom);
        observer.observe(container, { childList: true, subtree: true });
    });
</script>

</body>
</html>
