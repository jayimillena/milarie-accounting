<?php 

namespace App\Livewire\Accounting;

use App\Models\Account;
use Livewire\Component;

class FinancialStatements extends Component
{
    public string $startDate;
    public string $endDate;
    public string $activeTab = 'income-statement'; // 'income-statement' or 'balance-sheet'

    public function mount()
    {
        $this->startDate = date('Y-01-01');
        $this->endDate = date('Y-m-d');
    }

    public function render()
    {
        // Fetch all accounts with their posted journal entry items filtered by date
        $accounts = Account::with(['items' => function($query) {
            $query->whereHas('journalEntry', function($q) {
                $q->where('status', 'posted')
                  ->whereBetween('entry_date', [$this->startDate, $this->endDate]);
            });
        }])->get();

        // --- INCOME STATEMENT DATA (Revenue & Expenses) ---
        $revenues = $accounts->where('type', 'revenue')->map(function($acc) {
            $debit = $acc->items->sum('debit');
            $credit = $acc->items->sum('credit');
            return [
                'code' => $acc->code,
                'name' => $acc->name,
                'balance' => $credit - $debit // Normal balance for revenue is credit
            ];
        })->filter(fn($item) => $item['balance'] != 0);

        $expenses = $accounts->where('type', 'expense')->map(function($acc) {
            $debit = $acc->items->sum('debit');
            $credit = $acc->items->sum('credit');
            return [
                'code' => $acc->code,
                'name' => $acc->name,
                'balance' => $debit - $credit // Normal balance for expense is debit
            ];
        })->filter(fn($item) => $item['balance'] != 0);

        $totalRevenue = $revenues->sum('balance');
        $totalExpense = $expenses->sum('balance');
        $netIncome = $totalRevenue - $totalExpense;

        // --- BALANCE SHEET DATA (Assets, Liabilities, Equity) ---
        // Note: Balance Sheet accounts are typically cumulative from inception up to the end date
        $cumulativeAccounts = Account::with(['items' => function($query) {
            $query->whereHas('journalEntry', function($q) {
                $q->where('status', 'posted')
                  ->where('entry_date', '<=', $this->endDate);
            });
        }])->get();

        $assets = $cumulativeAccounts->where('type', 'asset')->map(function($acc) {
            $debit = $acc->items->sum('debit');
            $credit = $acc->items->sum('credit');
            return ['code' => $acc->code, 'name' => $acc->name, 'balance' => $debit - $credit];
        })->filter(fn($item) => $item['balance'] != 0);

        $liabilities = $cumulativeAccounts->where('type', 'liability')->map(function($acc) {
            $debit = $acc->items->sum('debit');
            $credit = $acc->items->sum('credit');
            return ['code' => $acc->code, 'name' => $acc->name, 'balance' => $credit - $debit];
        })->filter(fn($item) => $item['balance'] != 0);

        $equity = $cumulativeAccounts->where('type', 'equity')->map(function($acc) {
            $debit = $acc->items->sum('debit');
            $credit = $acc->items->sum('credit');
            return ['code' => $acc->code, 'name' => $acc->name, 'balance' => $credit - $debit];
        })->filter(fn($item) => $item['balance'] != 0);

        $totalAssets = $assets->sum('balance');
        $totalLiabilities = $liabilities->sum('balance');
        $totalEquity = $equity->sum('balance') + $netIncome; // Include current period net income in equity

        return view('livewire.accounting.financial-statements', [
            'revenues' => $revenues,
            'expenses' => $expenses,
            'totalRevenue' => $totalRevenue,
            'totalExpense' => $totalExpense,
            'netIncome' => $netIncome,
            'assets' => $assets,
            'liabilities' => $liabilities,
            'equity' => $equity,
            'totalAssets' => $totalAssets,
            'totalLiabilities' => $totalLiabilities,
            'totalEquity' => $totalEquity,
        ]);
    }
}