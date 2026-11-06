<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accounting\FinancialReportPdfController;
use App\Http\Controllers\Auth\GoogleAuthController;

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

// Authenticated Accounting & Financial Management Routes
Route::middleware(['auth'])->prefix('accounting')->name('accounting.')->group(function () {

    Route::get('/dashboard', App\Livewire\Accounting\Dashboard::class)->name('dashboard');
    
    // Chart of Accounts Management
    Route::get('/chart-of-accounts', App\Livewire\Accounting\ChartOfAccounts::class)->name('accounts.index');

    // Journal Entry Creation
    Route::get('/journal-entries/create', App\Livewire\Accounting\CreateJournalEntry::class)->name('journal-entries.create');

    // Trial Balance Report
    Route::get('/reports/trial-balance', App\Livewire\Accounting\TrialBalanceReport::class)->name('reports.trial-balance');

    // Income Statement & Balance Sheet Livewire View
    Route::get('/reports/financial-statements', App\Livewire\Accounting\FinancialStatements::class)->name('reports.financial-statements');

    // PDF Report Downloads
    Route::prefix('reports/pdf')->name('reports.pdf.')->group(function () {
        Route::get('/income-statement', [FinancialReportPdfController::class, 'downloadIncomeStatement'])->name('income-statement');
        Route::get('/balance-sheet', [FinancialReportPdfController::class, 'downloadBalanceSheet'])->name('balance-sheet');
    });

    Route::get('/ledger/{accountId?}', App\Livewire\Accounting\AccountLedger::class)->name('ledger');
});

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
