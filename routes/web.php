<?php

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\addUserController;
use App\Http\Controllers\addExpenseController;
use App\Http\Controllers\addIncomeController;
use App\Http\Controllers\editExpenseController;
use App\Http\Controllers\editIncomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\settingsController;
use App\Models\Goal;
use App\Models\Income;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\UserFeedbackController;

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [loginController::class, 'login']);

//admin
Route::get('/admin/dashboard', function () {
    $username = session('username');
    $role = session('role');

    // 🔒 Check authentication and role
    if (!$username) {
        return redirect('/login')->with('error', 'Please log in first.');
    }

    if ($role !== 'admin') {
        return redirect('/')->with('error', 'Unauthorized access.');
    }

    // ✅ Fetch all users (except admin if desired)
    $users = User::where('role', '!=', 'admin')->get();

    return view('admin.dashboard', [
        'page' => 'Admin Dashboard',
        'username' => $username,
        'users' => $users,
    ]);
})->name('admin.dashboard');



//feedbackroutes
Route::post('/feedback', [FeedbackController::class, 'userSend']);
Route::get('/admin/feedback', [FeedbackController::class, 'index'])->name('admin.feedback.index');
Route::get('/admin/feedbacks/{user}', [FeedbackController::class, 'show'])->name('admin.feedback.show');
Route::post('/admin/feedbacks/reply/{feedback}', [FeedbackController::class, 'reply'])->name('admin.feedback.reply');


Route::get('/register', function () {
    return view('register'); // your register blade
})->name('register');

Route::post('/register', [addUserController::class, 'register'])->name('register.submit');
Route::get('/verify', function () {
    return view('auth.verify');
})->name('register.verify');

Route::post('/verify', [addUserController::class, 'verify'])->name('register.verify.submit');
Route::post('/resend-code', [addUserController::class, 'resend'])->name('register.resend');
Route::post('/verify', [addUserController::class, 'verify'])->name('register.verify.submit');
Route::post('/resend-code', [addUserController::class, 'resend'])->name('register.resend');


//dashboard route

Route::get('/', function () {
    $username = session('username');
    if (!$username) return redirect('/login');

    // Fetch logged-in user details
    $authUser = User::where('username', $username)->first();

    // Transactions & incomes
    $transactions = Transaction::where('user', $username)->orderBy('date', 'asc')->get();
    $incomes = Income::where('user', $username)->orderBy('date', 'asc')->get();

    // Totals
    $totalExpense = $transactions->sum('total');
    $totalIncome = $incomes->sum('total');
    $balance = $totalIncome - $totalExpense;

    // DAILY
    $dailyExpenses = $transactions->groupBy('date')->map(
        fn($group) =>
        ['x' => strtotime($group->first()->date) * 1000, 'y' => $group->sum('total')]
    )->values();

    $dailyIncomes = $incomes->groupBy('date')->map(
        fn($group) =>
        ['x' => strtotime($group->first()->date) * 1000, 'y' => $group->sum('total')]
    )->values();

    // WEEKLY
    $weeklyExpenses = $transactions->groupBy(
        fn($item) =>
        Carbon::parse($item->date)->format('o-W')
    )->map(fn($group, $key) => [
        'x' => Carbon::now()->setISODate(substr($key, 0, 4), substr($key, 5))->startOfWeek()->timestamp * 1000,
        'y' => $group->sum('total')
    ])->values();

    $weeklyIncomes = $incomes->groupBy(
        fn($item) =>
        Carbon::parse($item->date)->format('o-W')
    )->map(fn($group, $key) => [
        'x' => Carbon::now()->setISODate(substr($key, 0, 4), substr($key, 5))->startOfWeek()->timestamp * 1000,
        'y' => $group->sum('total')
    ])->values();

    // MONTHLY
    $monthlyExpenses = $transactions->groupBy(
        fn($item) =>
        Carbon::parse($item->date)->format('Y-m')
    )->map(fn($group, $key) => [
        'x' => Carbon::createFromFormat('Y-m', $key)->startOfMonth()->timestamp * 1000,
        'y' => $group->sum('total')
    ])->values();

    $monthlyIncomes = $incomes->groupBy(
        fn($item) =>
        Carbon::parse($item->date)->format('Y-m')
    )->map(fn($group, $key) => [
        'x' => Carbon::createFromFormat('Y-m', $key)->startOfMonth()->timestamp * 1000,
        'y' => $group->sum('total')
    ])->values();

    // GOALS — only incomplete
    $goals = Goal::where('user', $username)
        ->where('is_completed', false)
        ->orderBy('aim_date', 'asc')
        ->get();

    return view('dashboard', [
        'page' => 'Dashboard',
        'authUser' => $authUser, // 👈 pass user info to Blade
        'transactions' => $transactions,
        'incomes' => $incomes,
        'goals' => $goals,
        'balance' => $balance,
        'dailyData' => ['expenses' => $dailyExpenses, 'income' => $dailyIncomes],
        'weeklyData' => ['expenses' => $weeklyExpenses, 'income' => $weeklyIncomes],
        'monthlyData' => ['expenses' => $monthlyExpenses, 'income' => $monthlyIncomes],
    ]);
})->name('dashboard');


Route::get('/feedback/messages', [UserFeedbackController::class, 'getMessages'])->name('feedback.messages');
Route::post('/feedback/send', [UserFeedbackController::class, 'send'])->name('feedback.send');


Route::group(['middleware' => ['verified']], function () {

    //income routes
    Route::get('/add-income', function () {
        $data = ['page' => 'Add Income'];

        if (session('username') == null) {
            return redirect('/login');
        }

        return view('add-income', $data);
    });

    Route::post('/income_source', [addIncomeController::class, 'storeIncome'])->name('income.store');
    Route::get('income/{id}', function ($id) {
        $data = ['page' => 'Edit Income', 'incomes' => Income::find($id)];

        if (session('username') == null) {
            return redirect('/login');
        }

        return view('income', $data);
    });
    Route::post('/edit-income/{id}', [editIncomeController::class, 'editIncome'])->name('incomes.editIncome');
    Route::get('delete-income/{id}', function ($id) {
        Income::find($id)->delete();
        return redirect('/')->with('success', 'Income deleted successfully!');
    });

    //expense routes

    Route::get('/add-expense', function () {
        $data = ['page' => 'Add Expense'];

        if (session('username') == null) {
            return redirect('/login');
        }

        return view('add-expense', $data);
    });

    Route::get('expense/{id}', function ($id) {
        $data = ['page' => 'Edit Expense', 'transactions' => Transaction::find($id)];

        if (session('username') == null) {
            return redirect('/login');
        }

        return view('expense', $data);
    });

    Route::post('/edit-expense/{id}', [editExpenseController::class, 'editExpense'])->name('transactions.editExpense');

    Route::get('delete-expense/{id}', function ($id) {
        Transaction::find($id)->delete();
        return redirect('/')->with('success', 'Expense deleted successfully!');
    });
    Route::post('/transactions', [addExpenseController::class, 'store'])->name('transactions.store');



    //analytics routes
    Route::get('/analytics', function () {
        $user = session('username');

        if ($user === null) {
            return redirect('/login');
        }

        $data = [
            'page' => 'Analytics',
            'transactions' => Transaction::where('user', $user)
                ->orderBy('date', 'asc')
                ->get(),
            'incomes' => Income::where('user', $user)
                ->orderBy('date', 'asc')
                ->get(),
        ];

        return view('analytics', $data);
    });

    Route::get('/pdf', [PDFController::class, 'generatePDF']);

    Route::get('/search', [PostController::class, 'search']);

    Route::get('/reports', function () {
        $data = ['page' => 'Reports'];

        if (session('username') == null) {
            return redirect('/login');
        }

        return view('reports', $data);
    });

    Route::get('/settings', function () {
        $data = ['page' => 'Settings'];

        if (session('username') == null) {
            return redirect('/login');
        }

        return view('settings', $data);
    });

    Route::post('/settings', [settingsController::class, 'update']);

    Route::get('/logout', function () {
        session()->forget('username');
        session()->forget('profilePicture');
        session()->flush();
        return redirect('/login')->with('success', 'You have been logged out!');
    });

    Route::get('/add-goal', function () {
        $data = ['page' => 'Add Goal'];

        if (session('username') == null) {
            return redirect('/login');
        }

        return view('add-goal', $data);
    });
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');

    Route::get('edit-goal/{id}', function ($id) {
        $data = ['page' => 'Edit Goal', 'goals' => Goal::find($id)];

        if (session('username') == null) {
            return redirect('/login');
        }

        return view('edit-goal', $data);
    });

    Route::post('/edit-goal/{id}', [GoalController::class, 'editGoal'])->name('goals.editGoal');
    Route::get('delete-goal/{id}', function ($id) {
        Goal::find($id)->delete();
        return redirect('/')->with('success', 'Goal deleted successfully!');
    });


    Route::patch('/goals/{goal}/complete', [GoalController::class, 'markComplete'])->name('goals.complete');
});
