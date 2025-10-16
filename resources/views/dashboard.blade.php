<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('images/logo/logobg.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>SpendWise</title>
</head>

<body class="bg-[#EEEEEE] h-screen text-[#222831] overflow-hidden">

    <div class="flex h-full">
        {{-- Sidebar --}}
        <x-sidebar.nav />

        {{-- Main --}}
        <div class="h-full w-full md:pl-0 md:pr-6 md:py-6 overflow-hidden">
            <div
                class="flex flex-col bg-neutral-50 h-full md:rounded-3xl px-6 md:px-10 py-6 overflow-y-auto no-scrollbar">

                {{-- Heading --}}
                <div class="flex items-center justify-between">
                    <div class="bg-neutral-50 fixed md:static w-full pt-6 md:pt-0 z-0">
                        <h1 class="text-2xl md:text-3xl font-semibold py-3 md:py-0">{{ $page }}</h1>
                    </div>
                    <div class="hidden md:block">
                        <x-profile-picture.profile-picture
                            src="{{ $authUser && $authUser->profilePicture
                                ? asset('storage/' . $authUser->profilePicture)
                                : asset('images/logo/Default_pfp.jpg') }}"
                            width="w-16" height="h-16" />
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

                    {{-- Top two columns --}}
                    <div class="flex flex-col lg:flex-row gap-6">
                        {{-- Left column: incomes --}}
                        <div
                            class="flex flex-col w-full lg:w-1/2 border-solid border-2 border-[#EEEEEE] rounded-2xl overflow-hidden">
                            <x-cards.cashonhand-card class="p-6" h1Class="text-2xl lg:text-3xl"
                                spanClass="text-sm lg:text-base" date="{{ date('M Y') }}" :total="$balance" />

                            <h2 class="mt-2 px-6 text-lg font-bold">Income Summary</h2>
                            <div class="mt-2 flex flex-col gap-4 px-6 pb-6 overflow-y-auto max-h-[400px]">
                                @forelse ($incomes as $income)
                                    <a href="income/{{ $income['id'] }}">
                                        <x-cards.transaction-card>
                                            <x-slot:expense>{{ $income['income_source'] }}</x-slot:expense>
                                            <x-slot:total>{{ number_format($income['total'], 0, '.', ',') }}</x-slot:total>
                                            <x-slot:date>{{ date('d M Y', strtotime($income['date'])) }}</x-slot:date>
                                        </x-cards.transaction-card>
                                    </a>
                                @empty
                                    <span class="mt-10 text-md font-semibold text-center text-gray-500">No income
                                        yet</span>
                                @endforelse
                            </div>
                        </div>

                        {{-- Right column: transactions --}}
                        <div
                            class="flex flex-col w-full lg:w-1/2 border-solid border-2 border-[#EEEEEE] rounded-2xl overflow-hidden">
                            @php $total = $transactions->sum('total'); @endphp
                            <x-cards.expense-card class="p-6" h1Class="text-2xl lg:text-3xl"
                                spanClass="text-sm lg:text-base" date="{{ date('M Y') }}"
                                total="{{ $total }}" />

                            <h2 class="mt-2 px-6 text-lg font-bold">Last Transactions</h2>
                            <div class="mt-2 flex flex-col gap-4 px-6 pb-6 overflow-y-auto max-h-[400px]">
                                @forelse ($transactions as $transaction)
                                    <a href="expense/{{ $transaction['id'] }}">
                                        <x-cards.transaction-card>
                                            <x-slot:expense>{{ $transaction['expense'] }}</x-slot:expense>
                                            <x-slot:total>{{ number_format($transaction['total'], 0, '.', ',') }}</x-slot:total>
                                            <x-slot:date>{{ date('d M Y', strtotime($transaction['date'])) }}</x-slot:date>
                                        </x-cards.transaction-card>
                                    </a>
                                @empty
                                    <span class="mt-10 text-md font-semibold text-center text-gray-500">No transactions
                                        yet</span>
                                @endforelse
                            </div>
                        </div>
                    </div>


                    {{-- Income vs Expenses Chart --}}
                    <div
                        class="p-6 w-full border-solid border-2 border-[#EEEEEE] rounded-2xl overflow-hidden flex flex-col">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold">Income vs Expenses</h2>
                            <div class="flex gap-2">
                                <button
                                    class="chart-toggle px-3 py-1 rounded-lg text-sm font-medium border border-gray-300"
                                    data-type="daily">Daily</button>
                                <button
                                    class="chart-toggle px-3 py-1 rounded-lg text-sm font-medium border border-gray-300 bg-[#00ADB5] text-white"
                                    data-type="weekly">Weekly</button>
                                <button
                                    class="chart-toggle px-3 py-1 rounded-lg text-sm font-medium border border-gray-300"
                                    data-type="monthly">Monthly</button>
                            </div>
                        </div>
                        <div id="chartContainer" class="w-full h-[400px]"></div>
                    </div>

                    {{-- Aim Goals --}}
                    {{-- Aim Goals --}}
                    <div x-data="{ openModal: false, selectedGoalId: null }"
                        class="p-6 w-full border-solid border-2 border-[#EEEEEE] rounded-2xl flex flex-col overflow-hidden">

                        <h2 class="text-lg font-bold mb-4">Your Aim Goals</h2>

                        <div class="flex flex-col gap-4 overflow-y-auto max-h-[400px]">
                            @forelse ($goals as $goal)
                                <div
                                    class="bg-white shadow-sm hover:shadow-md transition rounded-xl p-4 flex flex-col gap-2">
                                    <div class="flex justify-between items-start">

                                        {{-- Goal Info --}}
                                        <a href="{{ url("edit-goal/{$goal->id}") }}" class="flex-1">
                                            <h3 class="font-semibold text-lg text-[#222831]">{{ $goal->title }}</h3>
                                            <p class="text-sm text-gray-600">{{ $goal->description }}</p>
                                            <span
                                                class="text-sm text-gray-500">{{ date('d M Y', strtotime($goal->aim_date)) }}</span>

                                            {{-- Progress Bar --}}
                                            <div class="mt-2">
                                                @php
                                                    $progress = min(
                                                        100,
                                                        round(($balance / $goal->target_amount) * 100),
                                                    );
                                                @endphp
                                                <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                                                    <div class="h-2 bg-teal-500" style="width: {{ $progress }}%">
                                                    </div>
                                                </div>
                                                <span class="text-xs text-gray-500 mt-1 block">
                                                    ₱{{ number_format($balance, 0, '.', ',') }} /
                                                    ₱{{ number_format($goal->target_amount, 0, '.', ',') }}
                                                    ({{ $progress }}%)
                                                </span>
                                            </div>
                                        </a>

                                        {{-- ✅ Check Circle Button --}}
                                        <button @click="selectedGoalId = {{ $goal->id }}; openModal = true"
                                            class="ml-3 w-12 h-12 flex items-center justify-center rounded-full bg-green-500 hover:bg-green-600 transition transform hover:scale-105 shadow-md"
                                            title="Mark as done">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                class="w-8 h-8">
                                                <circle cx="12" cy="12" r="10" fill="white"
                                                    fill-opacity="0" />
                                                <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="white" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>



                                    </div>
                                </div>
                            @empty
                                <span class="mt-10 text-md font-semibold text-center text-gray-500">No goals yet</span>
                            @endforelse
                        </div>

                        {{-- 🟢 Confirmation Modal --}}
                        <div x-show="openModal" x-transition x-cloak
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div @click.away="openModal = false"
                                class="bg-white p-6 rounded-2xl shadow-lg w-80 text-center">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Mark Goal as Completed?</h3>
                                <p class="text-sm text-gray-600 mb-6">Are you sure you want to mark this goal as done?
                                    This action cannot be undone.</p>

                                <div class="flex justify-center gap-3">
                                    <button @click="openModal = false"
                                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                                        Cancel
                                    </button>

                                    <form x-bind:action="'{{ url('goals') }}/' + selectedGoalId + '/complete'"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
                                            Confirm
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 💬 Floating Feedback Messenger -->
                    <div x-data="feedbackChat()" x-init="loadMessages()" class="z-50">
                        <!-- Floating Button -->
                        <button @click="open = !open"
                            class="fixed bottom-6 right-6 bg-[#00ADB5] hover:bg-[#00949b] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10h8m-8 4h5m-8 6h10a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12l2-2h12" />
                            </svg>
                        </button>

                        <!-- Messenger Box -->
                        <div x-show="open" x-transition x-cloak
                            class="fixed bottom-24 right-6 bg-white w-80 max-h-[70vh] shadow-2xl rounded-2xl flex flex-col overflow-hidden border border-gray-200">

                            <!-- Header -->
                            <div
                                class="bg-[#00ADB5] text-white px-4 py-3 font-semibold flex justify-between items-center">
                                <span>Feedback Chat</span>
                                <button @click="open = false" class="text-white hover:text-gray-200">✕</button>
                            </div>

                            <!-- Messages -->
                            <div id="messages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50">
                                <template x-for="(msg, index) in messages" :key="index">
                                    <div
                                        :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                                        <div :class="msg.sender === 'user' ?
                                            'bg-[#00ADB5] text-white rounded-2xl px-4 py-2 max-w-[70%]' :
                                            'bg-gray-200 text-gray-800 rounded-2xl px-4 py-2 max-w-[70%]'"
                                            x-text="msg.message"></div>
                                    </div>
                                </template>
                            </div>

                            <!-- Input -->
                            <form @submit.prevent="sendMessage" class="flex border-t border-gray-300">
                                <input type="text" x-model="newMessage" placeholder="Type a message..."
                                    class="flex-1 px-3 py-2 text-sm outline-none" />
                                <button type="submit"
                                    class="px-4 text-[#00ADB5] hover:text-[#00949b] font-semibold">Send</button>
                            </form>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Scripts --}}
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    @vite('resources/js/app.js')
    @vite('resources/js/jquery-3.7.1.min.js')
    @vite('resources/js/alert.js')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const datasets = {
                daily: {
                    expenses: @json($dailyData['expenses']),
                    income: @json($dailyData['income'])
                },
                weekly: {
                    expenses: @json($weeklyData['expenses']),
                    income: @json($weeklyData['income'])
                },
                monthly: {
                    expenses: @json($monthlyData['expenses']),
                    income: @json($monthlyData['income'])
                }
            };

            let currentType = "weekly";
            const chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                backgroundColor: "transparent",
                axisX: {
                    title: "Date",
                    valueFormatString: "MMM DD YYYY",
                    labelAngle: -45,
                    labelFontSize: 12
                },
                axisY: {
                    title: "Amount (₱)",
                    valueFormatString: "#,###",
                    labelFontSize: 12
                },
                legend: {
                    verticalAlign: "top",
                    horizontalAlign: "center",
                    fontSize: 14
                },
                data: []
            });

            function updateChart(type) {
                const d = datasets[type];
                chart.options.data = [{
                        type: "line",
                        name: "Expenses",
                        color: "#FF6B6B",
                        showInLegend: true,
                        xValueType: "dateTime",
                        markerSize: 6,
                        dataPoints: d.expenses
                    },
                    {
                        type: "line",
                        name: "Income",
                        color: "#00ADB5",
                        showInLegend: true,
                        xValueType: "dateTime",
                        markerSize: 6,
                        dataPoints: d.income
                    }
                ];
                chart.render();
            }

            updateChart(currentType);

            document.querySelectorAll(".chart-toggle").forEach(btn => {
                btn.addEventListener("click", () => {
                    document.querySelectorAll(".chart-toggle").forEach(b => b.classList.remove(
                        "bg-[#00ADB5]", "text-white"));
                    btn.classList.add("bg-[#00ADB5]", "text-white");
                    currentType = btn.dataset.type;
                    updateChart(currentType);
                });
            });
        });


        function feedbackChat() {
            return {
                open: false,
                messages: [],
                newMessage: '',

                async loadMessages() {
                    const res = await fetch('/feedback/messages');
                    if (res.ok) {
                        this.messages = await res.json();
                        this.scrollToBottom();
                    }
                },

                async sendMessage() {
                    if (this.newMessage.trim() === '') return;
                    const msg = this.newMessage;
                    this.newMessage = '';

                    // Optimistic UI
                    this.messages.push({
                        sender: 'user',
                        message: msg
                    });
                    this.scrollToBottom();

                    await fetch('/feedback/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({
                            message: msg
                        })
                    });

                    this.loadMessages(); // reload full thread
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById('messages');
                        el.scrollTop = el.scrollHeight;
                    });
                }
            };
        }
    </script>

</body>

</html>
