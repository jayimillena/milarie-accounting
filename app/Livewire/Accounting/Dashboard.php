<?php

namespace App\Livewire\Accounting;

use App\Models\Account;
use App\Models\JournalEntry;
use Livewire\Component;

class Dashboard extends Component
{
    public string $startDate;
    public string $endDate;

    public function mount()
    {
        $this->startDate = date('Y-01-01');
        $this->endDate = date('Y-m-d');
    }

    public function render()
    {
        // Fetch accounts and posted items within the selected period
        $accounts = Account::with(['items' => function($query) {
            $query->whereHas('journalEntry', function($q) {
                $q->where('status', 'posted')
                  ->whereBetween('entry_date', [$this->startDate, $this->endDate]);
            });
        }])->get();

        $totalRevenue = $accounts->where('type', 'revenue')->sum(fn($acc) => $acc->items->sum('credit') - $acc->items->sum('debit'));
        $totalExpense = $accounts->where('type', 'expense')->sum(fn($acc) => $acc->items->sum('debit') - $acc->items->sum('credit'));
        $netIncome = $totalRevenue - $totalExpense;

        // Cumulative Assets up to end date
        $cumulativeAssets = Account::with(['items' => function($query) {
            $query->whereHas('journalEntry', function($q) {
                $q->where('status', 'posted')->where('entry_date', '<=', $this->endDate);
            });
        }])->where('type', 'asset')->get();

        $totalAssets = $cumulativeAssets->sum(fn($acc) => $acc->items->sum('debit') - $acc->items->sum('credit'));

        // Recent Journal Entries
        $recentEntries = JournalEntry::with('creator', 'items.account')
            ->where('status', 'posted')
            ->latest('entry_date')
            ->take(5)
            ->get();

        return view('livewire.accounting.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalExpense' => $totalExpense,
            'netIncome' => $netIncome,
            'totalAssets' => $totalAssets,
            'recentEntries' => $recentEntries,
        ]);
    }
}