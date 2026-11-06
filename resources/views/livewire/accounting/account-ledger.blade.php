<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Account General Ledger</h2>
        
        <div class="flex flex-wrap gap-2 items-center">
            <!-- Account Selector -->
            <div>
                <label class="block text-xs text-gray-500">Select Account</label>
                <select wire:model.live="accountId" class="rounded-md border-gray-300 shadow-sm border p-1.5 text-sm bg-white">
                    <option value="">Choose Account...</option>
                    @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }} ({{ ucfirst($acc->type) }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500">From</label>
                <input type="date" wire:model.live="startDate" class="rounded-md border-gray-300 shadow-sm border p-1.5 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500">To</label>
                <input type="date" wire:model.live="endDate" class="rounded-md border-gray-300 shadow-sm border p-1.5 text-sm">
            </div>
        </div>
    </div>

    @if($selectedAccount)
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-1 rounded">{{ $selectedAccount->type }}</span>
                    <h3 class="text-lg font-bold text-gray-900 mt-1">{{ $selectedAccount->code }} - {{ $selectedAccount->name }}</h3>
                </div>
                <div class="text-right">
                    <span class="text-xs text-gray-500 block">Current Balance</span>
                    <span class="text-lg font-mono font-bold text-gray-900">₱{{ number_format($selectedAccount->current_balance, 2) }}</span>
                </div>
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ref #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Debit (₱)</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Credit (₱)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @php $runningBalance = 0; @endphp
                    @forelse ($ledgerItems as $item)
                        @php
                            if (in_array($selectedAccount->type, ['asset', 'expense'])) {
                                $runningBalance += ($item->debit - $item->credit);
                            } else {
                                $runningBalance += ($item->credit - $item->debit);
                            }
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->journalEntry->entry_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">{{ $item->journalEntry->reference_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $item->journalEntry->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900">
                                {{ $item->debit > 0 ? number_format($item->debit, 2) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900">
                                {{ $item->credit > 0 ? number_format($item->credit, 2) : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No transactions recorded for this account within the selected date range.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-white p-8 text-center rounded-lg border border-gray-200 text-gray-500">
            Please select an account to view its ledger.
        </div>
    @endif
</div>