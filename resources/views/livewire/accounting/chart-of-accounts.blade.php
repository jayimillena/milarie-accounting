<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Chart of Accounts</h2>
        <button wire:click="openModal" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md shadow hover:bg-indigo-700">
            + Add Account
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Accounts Table -->
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Current Balance</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($accounts as $account)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $account->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $account->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 uppercase font-semibold">{{ $account->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900">₱{{ number_format($account->current_balance, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $account->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $account->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $account->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No accounts found. Create your first account above.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            {{ $accounts->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white rounded-lg max-w-md w-full p-6 shadow-xl">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $editingAccountId ? 'Edit Account' : 'New Account' }}</h3>
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Account Code</label>
                        <input type="text" wire:model="code" placeholder="e.g., 1010" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                        @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Account Name</label>
                        <input type="text" wire:model="name" placeholder="e.g., Cash on Hand" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Account Type</label>
                        <select wire:model="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                            <option value="asset">Asset</option>
                            <option value="liability">Liability</option>
                            <option value="equity">Equity</option>
                            <option value="revenue">Revenue</option>
                            <option value="expense">Expense</option>
                        </select>
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Active Account</label>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Save Account</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>