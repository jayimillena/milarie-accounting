<?php

namespace App\Livewire\Accounting;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class ChartOfAccounts extends Component
{
    use WithPagination;

    public string $code = '';
    public string $name = '';
    public string $type = 'asset';
    public bool $is_active = true;
    
    public ?int $editingAccountId = null;
    public bool $showModal = false;

    protected function rules()
    {
        return [
            'code' => 'required|string|unique:accounts,code,' . $this->editingAccountId,
            'name' => 'required|string|max:255',
            'type' => 'required|in:asset,liability,equity,revenue,expense',
            'is_active' => 'boolean',
        ];
    }

    public function openModal()
    {
        $this->reset(['code', 'name', 'type', 'is_active', 'editingAccountId']);
        $this->showModal = true;
    }

    public function edit(Account $account)
    {
        $this->editingAccountId = $account->id;
        $this->code = $account->code;
        $this->name = $account->name;
        $this->type = $account->type;
        $this->is_active = $account->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        Account::updateOrCreate(
            ['id' => $this->editingAccountId],
            [
                'code' => $this->code,
                'name' => $this->name,
                'type' => $this->type,
                'is_active' => $this->is_active,
            ]
        );

        session()->flash('success', $this->editingAccountId ? 'Account updated successfully.' : 'Account created successfully.');
        $this->showModal = false;
        $this->reset(['code', 'name', 'type', 'is_active', 'editingAccountId']);
    }

    public function render()
    {
        return view('livewire.accounting.chart-of-accounts', [
            'accounts' => Account::orderBy('code')->paginate(10)
        ]);
    }
}