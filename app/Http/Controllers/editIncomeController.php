<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class editIncomeController extends Controller
{
    public function editIncome(Request $request, $id)
    {
        // Find the income record by ID
        $income = Income::find($id);

        if (!$income) {
            return redirect('/')->with('error', 'Income record not found.');
        }

        // Update the income record with new data
        $income->update([
            'income_source' => $request->income_source,
            'total' => $request->total,
            'date' => $request->date,
        ]);

        return redirect('/')->with('success', 'Income updated successfully!');
    }
}
