<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Goal;
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
    public function markComplete(Goal $goal)
{
    $goal->update(['is_completed' => true]);
    return redirect()->back()->with('success', 'Goal marked as completed!');
}

}
