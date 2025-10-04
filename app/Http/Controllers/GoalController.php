<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoalController extends Controller
{
     public function create()
    {
        $page = 'Add Goal';
    return view('add-goal', compact('page'));

    }
}
