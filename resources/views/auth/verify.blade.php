<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-neutral-50 flex justify-center items-center h-screen text-[#222831]">
    <div class="bg-white p-8 rounded-3xl shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Verify Your Email</h1>

        @if(session('error'))
            <div class="bg-red-200 text-red-800 p-2 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Verification Form -->
        <form action="{{ route('register.verify.submit') }}" method="POST" class="mb-4">
            @csrf
            <label class="block mb-2">Enter the 6-digit code sent to your email</label>
            <input type="text" name="code" class="border rounded w-full p-2 mb-4" required>

            <button type="submit" class="bg-[#222831] text-white w-full py-2 rounded">Verify</button>
        </form>

        <!-- Resend Form -->
        <form action="{{ route('register.resend') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-blue-600 underline">Resend Code</button>
        </form>
    </div>
</body>
</html>
