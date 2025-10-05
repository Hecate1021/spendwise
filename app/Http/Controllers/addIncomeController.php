<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;

class addIncomeController extends Controller
{

    public function storeIncome(Request $request)
    {
        // Create a new transaction record
        Income::create([
            'user' => session('username'),
            'income_source' => $request->income_source,
            'total' => $request->total,
            'date' => $request->date,
        ]);
        return redirect('/')->with('success', 'Income added successfully!');
    }
}
