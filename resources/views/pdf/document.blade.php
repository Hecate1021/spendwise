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
            font-family: 'Nunito', sans-serif;
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
            font-family: 'Nunito', sans-serif;
            margin: 0;
        }

        .user-data span{
            font-weight: bold;
        }

        .transaction-container{
            width: 100%;
            border-bottom: solid 2px #EEEEEE;
            padding: 8px 12px;
            margin-bottom: 10px;
            font-family: 'Nunito', sans-serif;
        }

        .transaction-container .expense-title{
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: bold;
            font-family: 'Nunito', sans-serif;
        }

        .transaction-container .expense-total{
            width: 100%;
            font-size: 14px;
            font-weight: 400;
            font-family: 'Nunito', sans-serif;
        }

        .total{
            width: 100%;
            display: block;
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            font-family: 'Nunito', sans-serif;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1 class="heading">EXPENSE REPORT</h1>

    <div class="user-data-container">
        <p class="user-data"><span>User: </span>{{ session('username') }}</p>
        <p class="user-data"><span>Peroid:</span> {{ date('d M Y', $from) }} - {{ date('d M Y', $to) }}</p>
        <p class="user-data"><span>Printed on:</span> {{ date('d M Y H:i:s') }}</p>
    </div>
    @php
        $sum = 0;
    @endphp
    @foreach ($transactions as $transaction)
        @php
            $sum += $transaction['total'];
        @endphp

        <div class="transaction-container">
            <span class="expense-title">{{ $transaction['expense'] }} ({{ date('d M Y', strtotime($transaction['date'])) }})</span>
            <span class="expense-total">{{ 'P ' . number_format($transaction['total'], 2, '.', ',') }}</span>
        </div>
    @endforeach

    <span class="total">Total: {{ 'P ' . number_format($sum, 2, '.', ',') }}</span>
</body>
</html>
