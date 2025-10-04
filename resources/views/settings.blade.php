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

                {{-- content --}}
                <div class="mt-20 md:mt-6 mx-auto w-full md:w-2/3 lg:w-1/3">
                    <form action="" method="POST" class="flex flex-col gap-4" enctype="multipart/form-data">
                        @csrf

                        <div class="flex gap-4 lg:gap-6 items-center">
                            <x-profile-picture.profile-picture width="w-16" height="h-16">
                                <x-slot:src>
                                    {{ Storage::url(session('profilePicture')) }}
                                </x-slot:src>
                            </x-profile-picture.profile-picture>

                            <h1 class="text-2xl lg:text-3xl font-semibold">{{ session('username') }}</h1>
                        </div>

                        <x-forms.form type="text" required=''>
                            <x-slot:label>
                                Change Username
                            </x-slot:label>
                            <x-slot:id>
                                changeUsername
                            </x-slot:id>
                        </x-forms.form>

                        <div class="mt-6">
                            <x-forms.form type="file" bg='bg-transparent' padding='p-1' required=''>
                                <x-slot:label>
                                    Change Profile Picture
                                </x-slot:label>
                                <x-slot:id>
                                    changeProfilePicture
                                </x-slot:id>
                            </x-forms.form>
                        </div>

                        <div class="mt-6 flex flex-col gap-4">
                            <h1 class="text-lg font-semibold">Change Password</h1>
                            <x-forms.form type="text" size="text-md" required=''>
                                <x-slot:label>
                                    Enter Current Password
                                </x-slot:label>
                                <x-slot:id>
                                    currentPassword
                                </x-slot:id>
                            </x-forms.form>

                            <x-forms.form type="text" size="text-md" required=''>
                                <x-slot:label>
                                    Enter New Password
                                </x-slot:label>
                                <x-slot:id>
                                    newPassword
                                </x-slot:id>
                            </x-forms.form>
                        </div>

                        <button type="submit" class="mt-6 bg-[#222831] text-white rounded-3xl px-4 py-2 font-semibold w-full text-sm lg:text-base">Save Changes</button>
                    </form>
                </div>

            </div>
        </div>

    </div>

    @vite('resources/js/app.js')
    @vite('resources/js/alert.js')
</body>
</html>
