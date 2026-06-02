<?php

use App\Http\Controllers\ActivitylogController;
use App\Http\Controllers\CatalogCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\DistributorCustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/vehicalloading', function () {
//     return view('vehicalloading.loading');

// });
Route::get('/vehicalunloading', function () {
    return view('vehicalloading.unloading');
});
Route::get('/inoicere', function () {
    return view('productreturn.productreturn');

});
Route::get('/customeroutstanding', function () {
    return view('reports.customeroutstanding');

});
Route::get('/seleReport', function () {
    return view('reports.customerporeport');

});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('companyprofile.index');
Route::get('/company-profile/data', [CompanyProfileController::class, 'getCompanyData'])->name('companyprofile.data');
Route::post('/company-profile/save', [CompanyProfileController::class, 'store'])->name('companyprofile.store');
Route::get('/company-profile/{id}', [CompanyProfileController::class, 'show'])->name('companyprofile.show');
Route::delete('/company-profile/{id}', [CompanyProfileController::class, 'destroy'])->name('companyprofile.destroy');

Route::get('/activitylog', [ActivitylogController::class, 'index'])->name('activitylog.index');
Route::get('/activitylog/{id}', [ActivitylogController::class, 'show'])->name('activitylog.show');

require __DIR__ . '/auth.php';
