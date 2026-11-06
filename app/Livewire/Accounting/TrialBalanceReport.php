<?php 

namespace App\Livewire\Accounting;

use App\Models\Account;
use App\Models\JournalEntryItem;
use Livewire\Component;

class TrialBalanceReport extends Component
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
        // Calculate total debits and credits per account within date filters
        $accounts = Account::with(['items' => function($query) {
            $query->whereHas('journalEntry', function($q) {
                $q->where('status', 'posted')
                  ->whereBetween('entry_date', [$this->startDate, $this->endDate]);
            });
        }])->orderBy('code')->get();

        $reportData = $accounts->map(function($account) {
            $totalDebit = $account->items->sum('debit');
            $totalCredit = $account->items->sum('credit');
            
            // Determine normal balance presentation
            $netDebit = 0;
            $netCredit = 0;

            if (in_array($account->type, ['asset', 'expense'])) {
                $balance = $totalDebit - $totalCredit;
                if ($balance >= 0) {
                    $netDebit = $balance;
                } else {
                    $netCredit = abs($balance);
                }
            } else {
                $balance = $totalCredit - $totalDebit;
                if ($balance >= 0) {
                    $netCredit = $balance;
                } else {
                    $netDebit = abs($balance);
                }
            }

            return [
                'code' => $account->code,
                'name' => $account->name,
                'type' => $account->type,
                'debit' => $netDebit,
                'credit' => $netCredit,
            ];
        })->filter(fn($item) => $item['debit'] > 0 || $item['credit'] > 0);

        return view('livewire.accounting.trial-balance-report', [
            'reportData' => $reportData,
            'totalDebit' => $reportData->sum('debit'),
            'totalCredit' => $reportData->sum('credit'),
        ]);
    }
}