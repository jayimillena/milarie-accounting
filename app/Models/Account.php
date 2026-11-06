<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = ['code', 'name', 'type', 'current_balance', 'is_active'];

    public function items(): HasMany
    {
        return $this->hasMany(JournalEntryItem::class, 'accounts_id');
    }
}