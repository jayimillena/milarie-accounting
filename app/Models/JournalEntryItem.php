<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalEntryItem extends Model
{
    protected $fillable = [
        'journal_entry_id',
        'accounts_id',
        'debit',
        'credit',
    ];

    /**
     * Get the parent journal entry.
     */
    public function journalEntry(): BelongsTo
    {
        return $this->belongsTo(JournalEntry::class);
    }

    /**
     * Get the chart of accounts item associated with this line.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'accounts_id');
    }
}