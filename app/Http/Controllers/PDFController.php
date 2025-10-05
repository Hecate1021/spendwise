<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Income;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF(Request $request)
    {
        $user = session('username');

        if ($user === null) {
            return redirect('/login');
        }

        // Get expenses
        $transactions = Transaction::where('user', $user)
            ->whereBetween('date', [$request->fromDate, $request->toDate])
            ->orderBy('date', 'asc')
            ->get();

        // Get incomes
        $incomes = Income::where('user', $user)
            ->whereBetween('date', [$request->fromDate, $request->toDate])
            ->orderBy('date', 'asc')
            ->get();

        // Calculate totals
        $totalIncome = $incomes->sum('total');
        $totalExpense = $transactions->sum('total');
        $cashOnHand = $totalIncome - $totalExpense;

        $data = [
            'transactions' => $transactions,
            'incomes' => $incomes,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'cashOnHand' => $cashOnHand,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'user' => $user,
        ];

        $pdf = PDF::loadView('pdf.document', $data);
        return $pdf->stream('report.pdf');
    }
}
