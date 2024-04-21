<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

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

Route::resource('/listing', ListingController::class)->only(['index', 'show']);

Route::resource('notification', NotificationController::class)
    ->middleware(['auth', 'verified'])
    ->only(['index', 'show']);

Route::name('notification.seen')->put('notification/{notification}/seen', NotificationSeenController::class)
    ->middleware(['auth', 'verified']);

Route::resource('listing.offer', ListingOfferController::class)
    ->middleware(['auth', 'verified'])
    ->only(['store']);

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::resource('user-account', UserAccountController::class)->only(['create', 'store']);

//realtor
Route::prefix('realtor')->name('realtor.')->middleware(['auth', 'verified'])->group(function() {
    Route::put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])->name('listing.restore')
        ->withTrashed();

    Route::resource('listing', RealtorListingController::class)
        ->withTrashed();

    Route::name('offer.accept')->put('offer/{offer}/accept', RealtorListingAcceptOfferController::class);

    Route::resource('listing.image', RealtorListingImageController::class)->only(['create', 'store', 'destroy']);
});

//verification related
Route::get('/email/verify', function() {
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('listing.index')->with('success', 'E-mail was verified');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function(\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return redirect()->back()->with('success', 'Verification email was send again');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
