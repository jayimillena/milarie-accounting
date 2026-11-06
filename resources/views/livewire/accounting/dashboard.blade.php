<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header & Date Filters -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Accounting Dashboard</h1>
            <p class="text-sm text-gray-500">Overview of your financial performance and recent journal activity.</p>
        </div>
        <div class="flex space-x-2 bg-white p-2 rounded-lg shadow-sm border border-gray-200">
            <div>
                <label class="block text-xs text-gray-500">From</label>
                <input type="date" wire:model.live="startDate" class="rounded-md border-gray-300 shadow-sm border p-1 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500">To</label>
                <input type="date" wire:model.live="endDate" class="rounded-md border-gray-300 shadow-sm border p-1 text-sm">
            </div>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <p class="text-xs font-semibold tracking-wider text-gray-500 uppercase">Total Revenue</p>
            <p class="mt-2 text-3xl font-extrabold text-indigo-600 font-mono">₱{{ number_format($totalRevenue, 2) }}</p>
            <span class="text-xs text-gray-400 mt-1 block">For selected period</span>
        </div>

        <!-- Operating Expenses -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <p class="text-xs font-semibold tracking-wider text-gray-500 uppercase">Operating Expenses</p>
            <p class="mt-2 text-3xl font-extrabold text-red-600 font-mono">₱{{ number_format($totalExpense, 2) }}</p>
            <span class="text-xs text-gray-400 mt-1 block">For selected period</span>
        </div>

        <!-- Net Income -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <p class="text-xs font-semibold tracking-wider text-gray-500 uppercase">Net Income / (Loss)</p>
            <p class="mt-2 text-3xl font-extrabold font-mono {{ $netIncome >= 0 ? 'text-green-600' : 'text-red-600' }}">
                ₱{{ number_format($netIncome, 2) }}
            </p>
            <span class="text-xs text-gray-400 mt-1 block">Revenue minus Expenses</span>
        </div>

        <!-- Total Assets -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <p class="text-xs font-semibold tracking-wider text-gray-500 uppercase">Total Assets</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-800 font-mono">₱{{ number_format($totalAssets, 2) }}</p>
            <span class="text-xs text-gray-400 mt-1 block">Cumulative balance</span>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('accounting.journal-entries.create') }}" class="p-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow transition flex items-center justify-between">
            <span class="font-semibold text-sm">+ New Journal Entry</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </a>
        <a href="{{ route('accounting.accounts.index') }}" class="p-4 bg-white hover:bg-gray-50 border border-gray-200 text-gray-800 rounded-xl shadow-sm transition flex items-center justify-between">
            <span class="font-semibold text-sm">Chart of Accounts</span>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </a>
        <a href="{{ route('accounting.reports.trial-balance') }}" class="p-4 bg-white hover:bg-gray-50 border border-gray-200 text-gray-800 rounded-xl shadow-sm transition flex items-center justify-between">
            <span class="font-semibold text-sm">Trial Balance</span>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
        </a>
        <a href="{{ route('accounting.reports.financial-statements') }}" class="p-4 bg-white hover:bg-gray-50 border border-gray-200 text-gray-800 rounded-xl shadow-sm transition flex items-center justify-between">
            <span class="font-semibold text-sm">Financial Statements</span>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </a>
    </div>

    <!-- Recent Journal Entries Table -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Recent Posted Journal Entries</h3>
            <span class="text-xs text-gray-500">Showing last 5 entries</span>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Amount (₱)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($recentEntries as $entry)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">{{ $entry->reference_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $entry->entry_date }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $entry->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900">
                            ₱{{ number_format($entry->items->sum('debit'), 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No journal entries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>