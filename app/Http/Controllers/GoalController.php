<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\Transaction;
use Illuminate\Http\Request;

class GoalController extends Controller
{
     public function create()
    {
        $page = 'Add Goal';
    return view('add-goal', compact('page'));

    }

    public function store(Request $request)
    {
       Goal::create([
            'user' => session('username'),
            'title' => $request->title,
            'description' => $request->description,
            'aim_date' => $request->aim_date,
            'target_amount' => $request->target_amount,
        ]);
        return redirect('/')->with('success', 'Goal added successfully!');
    }

    public function editGoal($id, Request $request)
    {
       Goal::find($id)->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'target_amount' => $request->input('target_amount'),
            'aim_date' => $request->input('aim_date'),
        ]);

        return redirect('/')->with('success', 'Goal updated successfully!');
    }
public function markComplete($id)
{
    $goal = Goal::findOrFail($id);

    // Prevent duplicate entry
    if ($goal->is_completed) {
        return redirect()->back()->with('info', 'Goal already marked as completed.');
    }

    // Mark the goal as completed
    $goal->update(['is_completed' => true]);

    // Record as an expense
    Transaction::create([
        'user' => session('username'), // or Auth::user()->username if using Auth
        'expense' => $goal->title,
        'total' => $goal->target_amount,
        'date' => now(),
    ]);

    return redirect()->back()->with('success', 'Goal marked as completed and recorded as expense!');
}

}
