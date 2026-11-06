<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FinancialReportPdfController extends Controller
{
    public function downloadIncomeStatement(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-01-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        $accounts = Account::with(['items' => function($query) use ($startDate, $endDate) {
            $query->whereHas('journalEntry', function($q) use ($startDate, $endDate) {
                $q->where('status', 'posted')
                  ->whereBetween('entry_date', [$startDate, $endDate]);
            });
        }])->get();

        $revenues = $accounts->where('type', 'revenue')->map(function($acc) {
            return ['code' => $acc->code, 'name' => $acc->name, 'balance' => $acc->items->sum('credit') - $acc->items->sum('debit')];
        })->filter(fn($item) => $item['balance'] != 0);

        $expenses = $accounts->where('type', 'expense')->map(function($acc) {
            return ['code' => $acc->code, 'name' => $acc->name, 'balance' => $acc->items->sum('debit') - $acc->items->sum('credit')];
        })->filter(fn($item) => $item['balance'] != 0);

        $totalRevenue = $revenues->sum('balance');
        $totalExpense = $expenses->sum('balance');
        $netIncome = $totalRevenue - $totalExpense;

        $pdf = Pdf::loadView('pdf.accounting.income-statement', compact(
            'revenues', 'expenses', 'totalRevenue', 'totalExpense', 'netIncome', 'startDate', 'endDate'
        ));

        return $pdf->download('income-statement-' . $startDate . '-to-' . $endDate . '.pdf');
    }

    public function downloadBalanceSheet(Request $request)
    {
        $endDate = $request->input('end_date', date('Y-m-d'));

        $cumulativeAccounts = Account::with(['items' => function($query) use ($endDate) {
            $query->whereHas('journalEntry', function($q) use ($endDate) {
                $q->where('status', 'posted')->where('entry_date', '<=', $endDate);
            });
        }])->get();

        // Calculate Net Income up to endDate for Retained Earnings
        $revTotal = Account::with('items.journalEntry')->where('type', 'revenue')->get()->sum(fn($acc) => $acc->items->where('journalEntry.status', 'posted')->where('journalEntry.entry_date', '<=', $endDate)->sum('credit') - $acc->items->where('journalEntry.status', 'posted')->where('journalEntry.entry_date', '<=', $endDate)->sum('debit'));
        
        $expTotal = Account::with('items.journalEntry')->where('type', 'expense')->get()->sum(fn($acc) => $acc->items->where('journalEntry.status', 'posted')->where('journalEntry.entry_date', '<=', $endDate)->sum('debit') - $acc->items->where('journalEntry.status', 'posted')->where('journalEntry.entry_date', '<=', $endDate)->sum('credit'));

        $netIncome = $revTotal - $expTotal;

        $assets = $cumulativeAccounts->where('type', 'asset')->map(fn($acc) => ['code' => $acc->code, 'name' => $acc->name, 'balance' => $acc->items->sum('debit') - $acc->items->sum('credit')])->filter(fn($i) => $i['balance'] != 0);
        $liabilities = $cumulativeAccounts->where('type', 'liability')->map(fn($acc) => ['code' => $acc->code, 'name' => $acc->name, 'balance' => $acc->items->sum('credit') - $acc->items->sum('debit')])->filter(fn($i) => $i['balance'] != 0);
        $equity = $cumulativeAccounts->where('type', 'equity')->map(fn($acc) => ['code' => $acc->code, 'name' => $acc->name, 'balance' => $acc->items->sum('credit') - $acc->items->sum('debit')])->filter(fn($i) => $i['balance'] != 0);

        $totalAssets = $assets->sum('balance');
        $totalLiabilities = $liabilities->sum('balance');
        $totalEquity = $equity->sum('balance') + $netIncome;

        $pdf = Pdf::loadView('pdf.accounting.balance-sheet', compact(
            'assets', 'liabilities', 'equity', 'netIncome', 'totalAssets', 'totalLiabilities', 'totalEquity', 'endDate'
        ));

        return $pdf->download('balance-sheet-as-of-' . $endDate . '.pdf');
    }
}