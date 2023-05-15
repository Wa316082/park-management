<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketSettingsController;
use App\Http\Controllers\TicketSellsReportController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    //Tickets Routes
    Route::get('ticket-list', [TicketController::class, 'ticket_list'] )->name('ticket-list');
    Route::get('ticket-create', [TicketController::class, 'ticket_create'] )->name('ticket-create');
    Route::get('ticket-delete/{id}', [TicketController::class, 'ticket_delete'] )->name('ticket-delete');
    Route::get('ticket-edit/{id}', [TicketController::class, 'ticket_edit'] )->name('ticket-edit');
    Route::post('ticket-store', [TicketController::class, 'ticket_store'] )->name('ticket-store');
    Route::post('ticket-update', [TicketController::class, 'ticket_update'] )->name('ticket-update');
    Route::get('ticket-sell', [TicketController::class, 'ticket_sell'] )->name('ticket-sell');
    Route::get('ticket-print',[TicketController::class, 'ticket_print'])->name('ticket-print');
    Route::get('barcode-print',[TicketController::class, 'barcode_print'])->name('barcode-print');

    //Riders routes
    Route::get('ride-list',[RideController::class, 'ride_list'])->name('ride-list');
    Route::get('ride-create',[RideController::class, 'ride_create'])->name('ride-create');
    Route::get('ride-edit/{id}',[RideController::class, 'ride_edit'])->name('ride-edit');
    Route::post('ride-store',[RideController::class, 'ride_store'])->name('ride-store');
    Route::post('ride-update',[RideController::class, 'ride_update'])->name('ride-update');
    Route::get('ride-delete/{id}',[RideController::class, 'ride_delete'])->name('ride-delete');


    // Report routes
    Route::get('ticket-sells-report',[TicketSellsReportController::class , 'ticket_sells_report'])->name('ticket-sells-report');
    Route::get('ticket-report-search',[TicketSellsReportController::class , 'ticket_report_search'])->name('ticket-report-search');

    //user routes
    Route::get('users',[UserController::class, 'index'])->name('users');
    Route::get('user-create',[UserController::class, 'create'])->name('user-create');
    Route::post('user-store',[UserController::class, 'store'])->name('user-store');
    Route::get('user-edit/{id}',[UserController::class, 'edit'])->name('user-edit');
    Route::post('user-update',[UserController::class, 'update'])->name('user-update');
    Route::get('user-delete/{id}',[UserController::class, 'delete'])->name('user-delete');

    //ticket settings route
    Route::get('ticket-settings',[TicketSettingsController::class, 'show_ticket'])->name('ticket-settings');
    Route::get('edit', [TicketSettingsController::class, 'edit_ticket'])->name('edit');
    Route::post('update', [TicketSettingsController::class, 'update_ticket'])->name('update');
    Route::get('demo-ticket', [TicketSettingsController::class, 'demo_ticket']);



});
