<?php

namespace App\Livewire\Accounting;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateJournalEntry extends Component
{
    public string $reference_number = '';
    public string $entry_date;
    public string $description = '';
    
    public array $rows = [
        ['account_id' => '', 'debit' => 0, 'credit' => 0],
        ['account_id' => '', 'debit' => 0, 'credit' => 0],
    ];

    public function mount()
    {
        $this->entry_date = date('Y-m-d');
        $this->reference_number = 'JE-' . strtoupper(uniqid());
    }

    public function addRow()
    {
        $this->rows[] = ['account_id' => '', 'debit' => 0, 'credit' => 0];
    }

    public function removeRow($index)
    {
        if (count($this->rows) > 2) {
            unset($this->rows[$index]);
            $this->rows = array_values($this->rows);
        }
    }

    public function getTotalDebitProperty()
    {
        return collect($this->rows)->sum(fn($row) => floatval($row['debit']));
    }

    public function getTotalCreditProperty()
    {
        return collect($this->rows)->sum(fn($row) => floatval($row['credit']));
    }

    public function save()
    {
        $this->validate([
            'reference_number' => 'required|unique:journal_entries,reference_number',
            'entry_date' => 'required|date',
            'description' => 'required|string|max:255',
            'rows.*.account_id' => 'required|exists:accounts,id',
            'rows.*.debit' => 'required|numeric|min:0',
            'rows.*.credit' => 'required|numeric|min:0',
        ]);

        if (round($this->totalDebit, 2) !== round($this->totalCredit, 2)) {
            session()->flash('error', 'Total Debits must equal Total Credits.');
            return;
        }

        DB::transaction(function () {
            $entry = JournalEntry::create([
                'reference_number' => $this->reference_number,
                'entry_date' => $this->entry_date,
                'description' => $this->description,
                'status' => 'posted',
                'created_by' => auth()->id(),
            ]);

            foreach ($this->rows as $row) {
                JournalEntryItem::create([
                    'journal_entry_id' => $entry->id,
                    'accounts_id' => $row['account_id'],
                    'debit' => $row['debit'] ?? 0,
                    'credit' => $row['credit'] ?? 0,
                ]);

                // Optional: Update account current balance based on account type normal balances
                $account = Account::find($row['account_id']);
                // Add balance logic here if needed
            }
        });

        session()->flash('success', 'Journal entry posted successfully.');
        return redirect()->route('accounting.ledger');
    }

    public function render()
    {
        return view('livewire.accounting.create-journal-entry', [
            'accounts' => Account::where('is_active', true)->orderBy('code')->get()
        ]);
    }
}