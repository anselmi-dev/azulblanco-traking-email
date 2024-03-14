<?php

use App\Livewire\ExcelFileReview;
use App\Livewire\ImportExcel;
use App\Livewire\ReviewEmails;
use App\Models\ExcelEmail;
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
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', ImportExcel::class)->name('dashboard');

    Route::get('/historial-email/{excel_email}', function (ExcelEmail $excel_email) {
        return (new \App\Mail\PrivateShipped($excel_email))->render();
    })->name('historial.preview.email');

    Route::get('/historial/{file}', ExcelFileReview::class)->name('historial.preview');

    Route::get('/review-emails', ReviewEmails::class)->name('review-emails');

    Route::get('/import-excel', ImportExcel::class)->name('import-excel');
});
