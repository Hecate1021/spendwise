@php
    date_default_timezone_set("Asia/Jakarta");
    $from = strtotime($_GET['fromDate']);
    $to = strtotime($_GET['toDate']);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">
    <title>Spendly</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');

        body{
            font-family: 'Nunito', sans-serif;
            width: 100%;
        }

        .heading{
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .user-data-container{
            width: 100%;
            padding: 10px;
            border: solid 2px #EEEEEE;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .user-data{
            width: 100%;
            display: block;
            font-size: 14px;
            margin: 0;
        }

        .user-data span{
            font-weight: bold;
        }

        .section-title{
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #EEEEEE;
            padding-bottom: 5px;
        }

        .transaction-container{
            width: 100%;
            border-bottom: solid 1px #EEEEEE;
            padding: 6px 12px;
            margin-bottom: 6px;
        }

        .transaction-container .title{
            display: block;
            margin-bottom: 4px;
            font-size: 14px;
            font-weight: bold;
        }

        .transaction-container .total{
            width: 100%;
            font-size: 14px;
        }

        .summary{
            width: 100%;
            display: block;
            text-align: right;
            font-size: 15px;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <h1 class="heading">FINANCIAL SUMMARY REPORT</h1>

    <div class="user-data-container">
        <p class="user-data"><span>User: </span>{{ session('username') }}</p>
        <p class="user-data"><span>Period:</span> {{ date('d M Y', $from) }} - {{ date('d M Y', $to) }}</p>
        <p class="user-data"><span>Printed on:</span> {{ date('d M Y H:i:s') }}</p>
    </div>

    {{-- Income Section --}}
    <h2 class="section-title">Incomes</h2>
    @php
        $incomeSum = 0;
    @endphp
    @foreach ($incomes as $income)
        @php
            $date = strtotime($income['date']);
        @endphp
        @if ($date >= $from && $date <= $to)
            @php $incomeSum += $income['total']; @endphp
            <div class="transaction-container">
                <span class="title">{{ $income['income_source'] }} ({{ date('d M Y', strtotime($income['date'])) }})</span>
                <span class="total">{{ 'P ' . number_format($income['total'], 2, '.', ',') }}</span>
            </div>
        @endif
    @endforeach
    <span class="summary">Total Income: {{ 'P ' . number_format($incomeSum, 2, '.', ',') }}</span>

    {{-- Expense Section --}}
    <h2 class="section-title">Expenses</h2>
    @php
        $expenseSum = 0;
    @endphp
    @foreach ($transactions as $transaction)
        @php
            $date = strtotime($transaction['date']);
        @endphp
        @if ($date >= $from && $date <= $to)
            @php $expenseSum += $transaction['total']; @endphp
            <div class="transaction-container">
                <span class="title">{{ $transaction['expense'] }} ({{ date('d M Y', strtotime($transaction['date'])) }})</span>
                <span class="total">{{ 'P ' . number_format($transaction['total'], 2, '.', ',') }}</span>
            </div>
        @endif
    @endforeach
    <span class="summary">Total Expenses: {{ 'P ' . number_format($expenseSum, 2, '.', ',') }}</span>

    {{-- Cash on Hand --}}
    <h2 class="section-title">Cash on Hand</h2>
    @php
        $cashOnHand = $incomeSum - $expenseSum;
    @endphp
    <span class="summary">Cash on Hand: {{ 'P ' . number_format($cashOnHand, 2, '.', ',') }}</span>

</body>
</html>
