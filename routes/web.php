<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\AuthController as superadminauth;
use App\Http\Controllers\AuthController as userauth;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\GeneratedUrlController;

use App\Http\Controllers\SuperAdmin\DashboardController;

use App\Models\GeneratedUrl;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/superadmin/login', [superadminauth::class, 'showLogin'])
    ->name('superadmin.login');

Route::post('/superadmin/login', [superadminauth::class, 'login'])
    ->name('superadmin.login.submit');

Route::post('/superadmin/logout', [superadminauth::class, 'logout'])
    ->name('superadmin.logout');


Route::middleware('auth:superadmin')->group(function () {

    Route::get('/superadmin/company/create', [CompanyController::class, 'create'])
        ->name('superadmin.company.create');

    Route::post('/superadmin/company', [CompanyController::class, 'store'])
        ->name('superadmin.company.store');

    Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])
    ->name('superadmin.dashboard');

});

Route::middleware('guest')->group(function () {

    Route::get('/register/invite/{token}', [InvitationController::class, 'showRegistration'])
        ->name('invitation.register');

    Route::post('/register/invite/{token}', [InvitationController::class, 'register'])
        ->name('invitation.register.submit');

});


Route::get('/login', [userauth::class, 'showLogin'])
    ->name('login');

Route::post('/login', [userauth::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [userauth::class, 'logout'])
    ->name('logout');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {

        $user = auth()->user();

        if ($user->role == 'admin') {
            $urls = GeneratedUrl::where('company_id', $user->company_id)
                ->get();
        } else {
            $urls = GeneratedUrl::where('user_id', $user->id)
                ->get();
        }

        return view('dashboard', compact('urls'));

    })->name('dashboard');

    Route::get('/invite-user', [InvitationController::class, 'create'])
        ->name('invite.user');

    Route::post('/invite-user', [InvitationController::class, 'store'])
        ->name('invite.user.store');

    Route::get('/urls/create', [GeneratedUrlController::class, 'create'])
        ->name('urls.create');

    Route::post('/urls', [GeneratedUrlController::class, 'store'])
        ->name('urls.store');

});

Route::get('/{shortUrl}', [GeneratedUrlController::class, 'redirect'])
    ->name('short-url.redirect');
