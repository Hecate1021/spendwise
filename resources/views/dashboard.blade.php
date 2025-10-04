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
<body class="bg-[#EEEEEE] h-screen text-[#222831]">

    {{-- container --}}
    <div class="flex h-full">

        {{-- sidebar --}}
        <x-sidebar.nav/>

        {{-- main --}}
        <div class="h-full w-full md:pl-0 md:pr-6 md:py-10 overflow-hidden">
            <div class="flex flex-col bg-neutral-50 h-full md:rounded-3xl px-6 md:px-10 py-8 overflow-y-auto lg:overflow-hidden no-scrollbar">
                {{-- headings --}}
                <div class="flex items-center justify-between " id="heading">
                    <div class="bg-neutral-50 fixed md:static w-full pt-10 md:pt-0 z-0">
                        <h1 class="text-2xl md:text-3xl font-semibold py-5 md:py-0">{{ $page }}</h1>
                    </div>
                    <div class="hidden md:block">
                        <x-profile-picture.profile-picture>
                            <x-slot:src>
                                {{ asset('images/logo/Default_pfp.jpg')}}
                            </x-slot:src>
                        </x-profile-picture.profile-picture>
                    </div>
                </div>

                {{-- alert --}}
                @if (session('success'))
                    <x-alerts.success-alert class="mt-4 {{ session('success') == 'Expense deleted successfully!' ? 'bg-red-500' : 'bg-teal-500' }}">
                        {{ session('success') }}
                    </x-alerts.success-alert>
                @endif

                {{-- content --}}
                <div class="mt-20 lg:mt-10 min-h-[150vh] lg:min-h-0 h-full flex flex-col lg:flex-row gap-6 overflow-hidden">
                    {{-- last transactions --}}
                    <div class="flex flex-col w-full lg:w-1/2 min-h-1/2 lg:min-h-0 h-full border-solid border-2 border-[#EEEEEE] rounded-2xl overflow-hidden">
                        {{-- card --}}
                        @php
                             $total = 0
                        @endphp

                        @foreach ($transactions as $transaction)
                            @if (date('M', strtotime($transaction['date'])) == date('M'))
                                <?php $total += $transaction['total'] ?>
                            @endif
                        @endforeach

                        <x-cards.expense-card class="p-6" h1Class="text-2xl lg:text-3xl" spanClass="text-sm lg:text-base" date="{{ date('M Y') }}" total="{{ $total }}"/>

                        {{-- transactions --}}
                        <h2 class="mt-4 px-6 text-lg font-bold">Last Transactions</h2>
                        <div class="mt-4 flex flex-col gap-4 px-6 pb-6 overflow-y-auto">
                            @if (count($transactions) == 0)
                                <span class="mt-10 text-md font-semibold text-center text-gray-500">No transactions yet</span>
                            @else
                                @foreach ($transactions as $transaction)
                                    <a href="expense/{{ $transaction['id'] }}">
                                        <x-cards.transaction-card>
                                            <x-slot:expense>
                                                {{ $transaction['expense'] }}
                                            </x-slot:expense>

                                            <x-slot:total>
                                                {{ number_format($transaction['total'], 0, ',', '.') }}
                                            </x-slot:total>

                                            <x-slot:date>
                                                {{ date('d M Y', strtotime($transaction['date'])) }}
                                            </x-slot:date>
                                        </x-cards.transaction-card>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 min-h-1/2 lg:min-h-0 h-full flex flex-col gap-6">
                        {{-- monthly spend --}}
                        <div class="p-6 {{ count($transactions) == 0 ? 'h-1/3' : 'h-max' }} border-solid border-2 border-[#EEEEEE] rounded-2xl">
                            <span class="font-bold text-lg">Your expenses</span>
                            <div class="flex gap-6 mt-4 overflow-x-auto no-scrollbar md:pb-2">
                                {{-- card --}}
                                @if (count($transactions) == 0)
                                    <span class="mt-10 text-md font-semibold text-center text-gray-500 w-full">No transactions yet</span>
                                @else
                                    @php
                                        $date = fn($transaction) => date('M Y', strtotime($transaction['date']));
                                        $grouped = collect($transactions)->groupBy($date)
                                    @endphp

                                    @foreach ($grouped as $month => $transactions)
                                        <x-cards.expense-card class="w-[200px] lg:w-[250px] p-4 lg:p-6" h1Class="text-xl lg:text-2xl" spanClass="text-xs lg:text-sm" spanText="{{ date('M', strtotime($month)) }}" date="{{ date('Y', strtotime($month)) }}" total="{{ $transactions->sum('total') }}"/>

                                        @php
                                        $dataPoints[] = [
                                            "x" => strtotime($month . "-01") * 1000,
                                            "y" => $transactions->sum('total')
                                        ];
                                        @endphp
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- charts --}}
                        <div class="p-6 h-2/3 flex items-center gap-6 border-solid border-2 border-[#EEEEEE] rounded-2xl overflow-hidden">
                            {{-- charts --}}
                            @if (count($transactions) == 0)
                                <span class="mt-10 text-md font-semibold text-center text-gray-500 w-full">No transactions yet</span>
                            @else
                                <div id="chartContainer" class="w-full h-[250px] md:h-full"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    @vite('resources/js/jquery-3.7.1.min.js')
    @vite('resources/js/app.js')
    @vite('resources/js/alert.js')

    @if (count($transactions) > 0)
        <script>
            window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                backgroundColor: "transparent",
                zoomEnabled: true,
                axisX:{
                    valueFormatString: "D MMM",
                    labelAngle: -45,
                    interval: 2628000,
                },
                axisY: {
                    valueFormatString: "#,###"
                },
                data: [{
                    type: "spline",
                    markerSize: 5,
                    xValueFormatString: "MMMM",
                    yValueFormatString: "#,###",
                    xValueType: "dateTime",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });

            chart.render();

            };
        </script>
    @endif
</body>
</html>
