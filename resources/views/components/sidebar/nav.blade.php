<div>
    {{-- hamburger --}}
    <div class="absolute z-50 top-7 right-6 p-2 bg-[#EEEEEE] rounded-xl cursor-pointer md:hidden" id="hamburger">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16"
            class="size-6 transition-all duration-150" id="hamburger-svg">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M2.75 12.25h10.5m-10.5-4h10.5m-10.5-4h10.5" />
        </svg>
    </div>

    {{-- overlay --}}
    <div class="absolute top-0 bottom-0 right-0 left-0 bg-[#222831] opacity-0 hidden transition-all duration-150 z-10"
        id="overlay"></div>

    {{-- sidebar --}}
    <div class="absolute top-0 -left-60 bg-[#EEEEEE] md:static transition-all duration-200 z-20 shadow-lg md:shadow-none" id="sidebar">
        <div class="flex flex-col justify-between px-6 py-10 md:px-8 md:py-14 h-screen w-64">

            {{-- logo + username --}}
            <div class="flex flex-col items-center">
                <a href="/" class="flex flex-col items-center justify-center">
                    <img src="{{ asset('images/logo/logobg.png') }}" alt="Logo"
                        class="w-[60px] h-[60px] cursor-pointer">
                    <h1 class="text-2xl font-bold text-[#222831] mt-2">SpendWise</h1>
                </a>

                @if (session('username'))
                    <div class="flex items-center mt-4 bg-white px-4 py-2 rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-[#222831]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                        </svg>
                        <span class="text-sm font-semibold text-[#222831] ml-2">
                            {{ session('username') }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- navigation --}}
            <nav class="flex-1 mt-10">
                <ul class="space-y-3">
                    {{-- dashboard --}}
                    <li>
                        <a href="/" class="flex items-center gap-4 rounded-lg p-3 w-full font-medium
                            {{ request()->is('/') ? 'bg-[#222831] text-white' : 'hover:bg-[#222831] hover:text-white text-[#222831]' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 9q-.425 0-.712-.288T13 8V4q0-.425.288-.712T14 3h6q.425 0 .713.288T21 4v4q0 .425-.288.713T20 9zM4 13q-.425 0-.712-.288T3 12V4q0-.425.288-.712T4 3h6q.425 0 .713.288T11 4v8q0 .425-.288.713T10 13zm10 8q-.425 0-.712-.288T13 20v-8q0-.425.288-.712T14 11h6q.425 0 .713.288T21 12v8q0 .425-.288.713T20 21zM4 21q-.425 0-.712-.288T3 20v-4q0-.425.288-.712T4 15h6q.425 0 .713.288T11 16v4q0 .425-.288.713T10 21z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    {{-- add expense --}}
                    <li>
                        <a href="/add-expense" class="flex items-center gap-4 rounded-lg p-3 w-full font-medium
                            {{ request()->is('add-expense') ? 'bg-[#222831] text-white' : 'hover:bg-[#222831] hover:text-white text-[#222831]' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4zm-6 4q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21z"/>
                            </svg>
                            Add Expense
                        </a>
                    </li>

                    {{-- add goal --}}
                    <li>
                        <a href="/add-goal" class="flex items-center gap-4 rounded-lg p-3 w-full font-medium
                            {{ request()->is('add-goal') ? 'bg-[#222831] text-white' : 'hover:bg-[#222831] hover:text-white text-[#222831]' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 1 0 3.49 19.39l-.66-1.89A8 8 0 1 1 20 12h2a10 10 0 0 0-10-10zm0 4a6 6 0 1 0 1.95 11.66l-.65-1.87a4 4 0 1 1 2.57-2.57l1.87.65A6 6 0 0 0 12 6zm0 4a2 2 0 1 0 1.41 3.41l4.59 4.59L20 16l-4.59-4.59A2 2 0 0 0 12 10z"/>
                            </svg>
                            Add Goal
                        </a>
                    </li>

                    {{-- analytics --}}
                    <li>
                        <a href="/analytics" class="flex items-center gap-4 rounded-lg p-3 w-full font-medium
                            {{ request()->is('analytics') ? 'bg-[#222831] text-white' : 'hover:bg-[#222831] hover:text-white text-[#222831]' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21zm3-11q-.425 0-.712.288T7 11v5q0 .425.288.713T8 17t.713-.288T9 16v-5q0-.425-.288-.712T8 10m4-3q-.425 0-.712.288T11 8v8q0 .425.288.713T12 17t.713-.288T13 16V8q0-.425-.288-.712T12 7m4 6q-.425 0-.712.288T15 14v2q0 .425.288.713T16 17t.713-.288T17 16v-2q0-.425-.288-.712T16 13"/>
                            </svg>
                            Analytics
                        </a>
                    </li>

                    {{-- reports --}}
                    <li>
                        <a href="/reports" class="flex items-center gap-4 rounded-lg p-3 w-full font-medium
                            {{ request()->is('reports') ? 'bg-[#222831] text-white' : 'hover:bg-[#222831] hover:text-white text-[#222831]' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 8V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v3zm2 13q-.825 0-1.412-.587T3 19v-9h4.5v11zm11.5 0V10H21v9q0 .825-.587 1.413T19 21zm-7 0V10h5v11z"/>
                            </svg>
                            Reports
                        </a>
                    </li>

                    {{-- settings --}}
                    <li>
                        <a href="/settings" class="flex items-center gap-4 rounded-lg p-3 w-full font-medium
                            {{ request()->is('settings') ? 'bg-[#222831] text-white' : 'hover:bg-[#222831] hover:text-white text-[#222831]' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10.825 22q-.675 0-1.162-.45t-.588-1.1L8.85 18.8q-.325-.125-.612-.3t-.563-.375l-1.55.65q-.625.275-1.25.05t-.975-.8l-1.175-2.05q-.35-.575-.2-1.225t.675-1.075l1.325-1Q4.5 12.5 4.5 12.337v-.675q0-.162.025-.337l-1.325-1Q2.675 9.9 2.525 9.25t.2-1.225L3.9 5.975q.35-.575.975-.8t1.25.05l1.55.65q.275-.2.575-.375t.6-.3l.225-1.65q.1-.65.588-1.1T10.825 2h2.35q.675 0 1.163.45t.587 1.1l.225 1.65q.325.125.613.3t.562.375l1.55-.65q.625-.275 1.25-.05t.975.8l1.175 2.05q.35.575.2 1.225t-.675 1.075l-1.325 1q.025.175.025.338v.674q0 .163-.05.338l1.325 1q.525.425.675 1.075t-.2 1.225l-1.2 2.05q-.35.575-.975.8t-1.25-.05l-1.5-.65q-.275.2-.575.375t-.6.3l-.225 1.65q-.1.65-.587 1.1t-1.163.45zm1.225-6.5q1.45 0 2.475-1.025T15.55 12t-1.025-2.475T12.05 8.5q-1.475 0-2.488 1.025T8.55 12t1.013 2.475T12.05 15.5"/>
                            </svg>
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- logout --}}
            <div class="mt-6">
                <a href="/logout" class="flex items-center gap-4 rounded-lg p-3 w-full font-medium hover:bg-red-500 hover:text-white text-[#222831]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 rotate-180" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M23.992 6H6v36h18m9-9l9-9l-9-9m-17 8.992h26"/>
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>
