<?php

use App\Http\Controllers\RolesController;
use App\Http\Livewire\DirectBooking;
use App\Http\Livewire\DirectCustomer;
use App\Http\Livewire\DirectLeads;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BookingController;

Route::get('services/{id}', [BookingController::class, 'index']);
Route::get('booking/{id}', [BookingController::class, 'book'])->name('book');
Route::post('get/slots', [BookingController::class, 'slots'])->name('slots');
Route::post('get/details', [BookingController::class, 'details'])->name('details');
Route::post('checking/reserve', [BookingController::class, 'reserveChecking'])->name('reserve.checking');
Route::post('reserve', [BookingController::class, 'reserve'])->name('reserve');
Route::get('confirm/book/{id}', [BookingController::class, 'confirmPage'])->name('confirm.book');


Auth::routes(['verify' => true, 'register' => false]);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('direct-booking', DirectBooking::class)->name('direct-booking');
    Route::get('direct-customer', DirectCustomer::class)->name('direct-customer');
    Route::get('direct-leads', DirectLeads::class)->name('direct-leads');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/home/search', [HomeController::class, 'search'])->name('home.search');
    Route::post('/cancel/booking', [HomeController::class, 'cancelBooking'])->name('cancel.booking');
    Route::get('/export/scheduled/{dated}/{service}', [HomeController::class, 'exportFile'])->name('export.scheduled');
    Route::post('/home/services', [HomeController::class, 'getServices'])->name('home.services');

    Route::get('appointment', [AppointmentController::class, 'index'])->name('appointment');
    Route::post('table/appointment', [AppointmentController::class, 'table'])->name('appointment.table');
    Route::get('form/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('store/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('show/appointment/{id}', [AppointmentController::class, 'show'])->name('appoint');
    Route::post('store/schedule', [AppointmentController::class, 'saveSchedule'])->name('schedule.store');
    Route::post('get/schedule', [AppointmentController::class, 'getSchedule'])->name('schedule.get');
    Route::post('list/schedule', [AppointmentController::class, 'listSchedule'])->name('schedule.list');
    Route::post('appointment/delete', [AppointmentController::class, 'deleteService'])->name('appointment.delete');
    Route::post('schedule/delete', [AppointmentController::class, 'deleteSchedule'])->name('schedule.delete');

    Route::get('business', [BusinessController::class, 'index'])->name('business');
    Route::post('add/other/details', [BusinessController::class, 'addOtherDetails'])->name('add.other.details');
    Route::post('get/other/details', [BusinessController::class, 'getOtherDetails'])->name('get.other.details');
    Route::post('business/update', [BusinessController::class, 'businessUpdate'])->name('business.update');
    Route::post('store/person/notify', [BusinessController::class, 'storeNotifiable'])->name('store.notifiable');
    Route::post('get/person/notify', [BusinessController::class, 'getNotifiable'])->name('get.notifiable');
    Route::post('delete/notifiable', [BusinessController::class, 'deleteNotifiable'])->name('delete.notifiable');

    Route::resource('settings', SettingsController::class);
    Route::post('settings/change/pass', [SettingsController::class, 'changePass'])->name('settings.change.pass');
    Route::post('settings/delete/account', [SettingsController::class, 'deleteAccount'])
         ->name('settings.delete.account');

    Route::middleware(['can:accounts'])->group(function () {
        Route::resource('users', UsersController::class);
        Route::post('users/table', [UsersController::class, 'table'])->name('users.table');
        Route::post('users/assign/Role', [UsersController::class, 'assignRole'])->name('assign.role');
        Route::post('users/reset/pass', [UsersController::class, 'resetPass'])->name('users.reset.pass');
    });

    Route::middleware(['can:roles'])->group(function () {
        Route::resource('roles', RolesController::class);
        Route::post('roles/table', [RolesController::class, 'table'])->name('roles.table');
        Route::get('roles/abilities/{name}', [RolesController::class, 'abilities'])->name('roles.abilities');
        Route::post('roles/save/abiltiies', [RolesController::class, 'saveAbilities'])->name('abilities.save');
    });
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
