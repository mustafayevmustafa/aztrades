<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnionController;
use App\Http\Controllers\PotatoController;
use App\Http\Middleware\Localization;
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
    Route::redirect('/', 'Admin/dashboard');
    Route::resource('dashboard', DashboardController::class);
    Route::resource('onions', OnionController::class);
    Route::resource('potatoes', PotatoController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('cities', CityController::class);
    Route::resource('sellings', SellingController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('roles', RoleController::class);

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

// tiny mce upload
Route::post('/image/uploads', function (Request $request) {
    $newMediaUpload = $request->file('file') ? 'media/uploads/' . time() . '.' . $request->file('file')->extension() : "";

    if ($request->hasFile('file')) {
        $request->file('file')->storeAs('public', $newMediaUpload);
        return response()->json(['location' => '/storage/' . $newMediaUpload]);
    }

    return response()->setStatusCode('204');
});

