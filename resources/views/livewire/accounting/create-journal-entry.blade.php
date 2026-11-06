<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-6">New General Ledger Journal Entry</h2>

        @if (session()->has('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 text-red-700 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="save">
            <!-- Header Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Reference Number</label>
                    <input type="text" wire:model="reference_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                    @error('reference_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Entry Date</label>
                    <input type="date" wire:model="entry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                    @error('entry_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Description / Memo</label>
                    <input type="text" wire:model="description" placeholder="e.g., Monthly office supply purchase" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Line Items Table -->
            <div class="mb-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Account</th>
                            <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase w-40">Debit</th>
                            <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase w-40">Credit</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase w-16">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($rows as $index => $row)
                            <tr>
                                <td class="px-3 py-2">
                                    <select wire:model="rows.{{ $index }}.account_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                        <option value="">Select Account</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }} ({{ ucfirst($account->type) }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-3 py-2">
                                    <input type="number" step="0.01" wire:model.live="rows.{{ $index }}.debit" class="block w-full text-right rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                </td>
                                <td class="px-3 py-2">
                                    <input type="number" step="0.01" wire:model.live="rows.{{ $index }}.credit" class="block w-full text-right rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <button type="button" wire:click="removeRow({{ $index }})" class="text-red-600 hover:text-red-900 text-sm font-semibold">&times;</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold">
                        <tr>
                            <td class="px-3 py-3 text-right text-sm text-gray-700">Totals:</td>
                            <td class="px-3 py-3 text-right text-sm {{ round($this->totalDebit, 2) !== round($this->totalCredit, 2) ? 'text-red-600' : 'text-gray-900' }}">
                                ₱{{ number_format($this->totalDebit, 2) }}
                            </td>
                            <td class="px-3 py-3 text-right text-sm {{ round($this->totalDebit, 2) !== round($this->totalCredit, 2) ? 'text-red-600' : 'text-gray-900' }}">
                                ₱{{ number_format($this->totalCredit, 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-4">
                    <button type="button" wire:click="addRow" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                        + Add Line
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Post Journal Entry
                </button>
            </div>
        </form>
    </div>
</div>