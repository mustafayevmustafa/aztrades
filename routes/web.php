<?php


use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpensesTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnionController;
use App\Http\Controllers\PotatoController;
use App\Http\Controllers\WasteController;
use App\Http\Middleware\Localization;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::group(["prefix" => "Admin", "middleware" => ['auth', 'optimizeImages']], function () {
    Route::redirect('/', config('app.url') . '/Admin/dashboard');

    Route::resource('dashboard', DashboardController::class);
    Route::resource('onions', OnionController::class);
    Route::resource('potatoes', PotatoController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('cities', CityController::class);
    Route::resource('sellings', SellingController::class)->except('edit',  'update');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('expenses_types', ExpensesTypeController::class);
    Route::resource('expenses', ExpenseController::class);

    Route::get('income-debts', [DebtController::class, 'incomeIndex'])->name('debts.income');
    Route::get('expense-debts', [DebtController::class, 'expenseIndex'])->name('debts.expense');
    Route::get('waste', WasteController::class)->name('waste.index');

    Route::post('/toggle-active', [DashboardController::class, 'toggleActive'])->name('settings.toggle-state');
});

Auth::routes([
    'register' => false,
    'password.reset' => false,
    'password.confirm' => false,
    'password.update' => false,
    'password.email' => false,
    'password.request' => false,
    'home' => false,
    'verify' => false,
]);

Route::get('locale/{locale}', [Localization::class, 'locale'])->whereAlpha('locale')->where('locale', '[a-z]{2}')->name('locale');
