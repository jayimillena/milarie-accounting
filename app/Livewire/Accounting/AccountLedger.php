<?php 

namespace App\Livewire\Accounting;

use App\Models\Account;
use App\Models\JournalEntryItem;
use Livewire\Component;

class AccountLedger extends Component
{
    public ?int $accountId = null;
    public string $startDate;
    public string $endDate;

    public function mount(?int $accountId = null)
    {
        $this->accountId = $accountId ?? Account::first()?->id;
        $this->startDate = date('Y-01-01');
        $this->endDate = date('Y-m-d');
    }

    public function render()
    {
        $selectedAccount = $this->accountId ? Account::find($this->accountId) : null;
        
        $ledgerItems = collect();
        $openingBalance = 0;

        if ($selectedAccount) {
            // Fetch items within date range
            $ledgerItems = JournalEntryItem::with(['journalEntry', 'account'])
                ->where('accounts_id', $this->accountId)
                ->whereHas('journalEntry', function($q) {
                    $q->where('status', 'posted')
                      ->whereBetween('entry_date', [$this->startDate, $this->endDate]);
                })
                ->join('journal_entries', 'journal_entry_items.journal_entry_id', '=', 'journal_entries.id')
                ->orderBy('journal_entries.entry_date', 'asc')
                ->orderBy('journal_entries.id', 'asc')
                ->select('journal_entry_items.*')
                ->get();
        }

        return view('livewire.accounting.account-ledger', [
            'accounts' => Account::orderBy('code')->get(),
            'selectedAccount' => $selectedAccount,
            'ledgerItems' => $ledgerItems,
        ]);
    }
}