<div class="max-w-5xl mx-auto py-8 px-4">
    <!-- Header & Filters -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex space-x-2">
            <button wire:click="$set('activeTab', 'income-statement')" class="px-4 py-2 text-sm font-semibold rounded-md {{ $activeTab === 'income-statement' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                Income Statement
            </button>
            <button wire:click="$set('activeTab', 'balance-sheet')" class="px-4 py-2 text-sm font-semibold rounded-md {{ $activeTab === 'balance-sheet' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                Balance Sheet
            </button>
        </div>
        <div class="flex space-x-2">
            <div>
                <label class="block text-xs text-gray-500">From</label>
                <input type="date" wire:model.live="startDate" class="rounded-md border-gray-300 shadow-sm border p-1.5 text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500">To / As of</label>
                <input type="date" wire:model.live="endDate" class="rounded-md border-gray-300 shadow-sm border p-1.5 text-sm">
            </div>
        </div>
    </div>

    @if($activeTab === 'income-statement')
        <!-- INCOME STATEMENT REPORT -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Income Statement</h2>
                <p class="text-sm text-gray-500">For the period from {{ $startDate }} to {{ $endDate }}</p>
            </div>

            <!-- Revenues -->
            <h3 class="text-md font-semibold text-gray-800 border-b pb-2 mb-3">Revenues</h3>
            <table class="min-w-full mb-6">
                @forelse($revenues as $rev)
                    <tr>
                        <td class="py-1.5 text-sm text-gray-600 w-24 font-mono">{{ $rev['code'] }}</td>
                        <td class="py-1.5 text-sm text-gray-800">{{ $rev['name'] }}</td>
                        <td class="py-1.5 text-sm text-right font-mono text-gray-900">₱{{ number_format($rev['balance'], 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-sm text-gray-500 py-2">No revenue recorded.</td></tr>
                @endforelse
                <tr class="font-semibold border-t">
                    <td colspan="2" class="py-2 text-right text-sm">Total Revenue:</td>
                    <td class="py-2 text-right text-sm font-mono text-indigo-600">₱{{ number_format($totalRevenue, 2) }}</td>
                </tr>
            </table>

            <!-- Expenses -->
            <h3 class="text-md font-semibold text-gray-800 border-b pb-2 mb-3">Operating Expenses</h3>
            <table class="min-w-full mb-6">
                @forelse($expenses as $exp)
                    <tr>
                        <td class="py-1.5 text-sm text-gray-600 w-24 font-mono">{{ $exp['code'] }}</td>
                        <td class="py-1.5 text-sm text-gray-800">{{ $exp['name'] }}</td>
                        <td class="py-1.5 text-sm text-right font-mono text-gray-900">₱{{ number_format($exp['balance'], 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-sm text-gray-500 py-2">No expenses recorded.</td></tr>
                @endforelse
                <tr class="font-semibold border-t">
                    <td colspan="2" class="py-2 text-right text-sm">Total Expenses:</td>
                    <td class="py-2 text-right text-sm font-mono text-red-600">₱{{ number_format($totalExpense, 2) }}</td>
                </tr>
            </table>

            <!-- Net Income Summary -->
            <div class="bg-gray-50 p-4 rounded-md flex justify-between items-center font-bold text-lg border">
                <span>Net Income / (Loss):</span>
                <span class="font-mono {{ $netIncome >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    ₱{{ number_format($netIncome, 2) }}
                </span>
            </div>
        </div>
    @else
        <!-- BALANCE SHEET REPORT -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Balance Sheet</h2>
                <p class="text-sm text-gray-500">As of {{ $endDate }}</p>
            </div>

            <!-- Assets -->
            <h3 class="text-md font-semibold text-gray-800 border-b pb-2 mb-3">Assets</h3>
            <table class="min-w-full mb-6">
                @foreach($assets as $asset)
                    <tr>
                        <td class="py-1.5 text-sm text-gray-600 w-24 font-mono">{{ $asset['code'] }}</td>
                        <td class="py-1.5 text-sm text-gray-800">{{ $asset['name'] }}</td>
                        <td class="py-1.5 text-sm text-right font-mono text-gray-900">₱{{ number_format($asset['balance'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="font-semibold border-t">
                    <td colspan="2" class="py-2 text-right text-sm">Total Assets:</td>
                    <td class="py-2 text-right text-sm font-mono text-indigo-600">₱{{ number_format($totalAssets, 2) }}</td>
                </tr>
            </table>

            <!-- Liabilities -->
            <h3 class="text-md font-semibold text-gray-800 border-b pb-2 mb-3">Liabilities</h3>
            <table class="min-w-full mb-6">
                @forelse($liabilities as $liab)
                    <tr>
                        <td class="py-1.5 text-sm text-gray-600 w-24 font-mono">{{ $liab['code'] }}</td>
                        <td class="py-1.5 text-sm text-gray-800">{{ $liab['name'] }}</td>
                        <td class="py-1.5 text-sm text-right font-mono text-gray-900">₱{{ number_format($liab['balance'], 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-sm text-gray-500 py-2">No liabilities recorded.</td></tr>
                @endforelse
                <tr class="font-semibold border-t">
                    <td colspan="2" class="py-2 text-right text-sm">Total Liabilities:</td>
                    <td class="py-2 text-right text-sm font-mono text-red-600">₱{{ number_format($totalLiabilities, 2) }}</td>
                </tr>
            </table>

            <!-- Equity -->
            <h3 class="text-md font-semibold text-gray-800 border-b pb-2 mb-3">Equity</h3>
            <table class="min-w-full mb-6">
                @foreach($equity as $eq)
                    <tr>
                        <td class="py-1.5 text-sm text-gray-600 w-24 font-mono">{{ $eq['code'] }}</td>
                        <td class="py-1.5 text-sm text-gray-800">{{ $eq['name'] }}</td>
                        <td class="py-1.5 text-sm text-right font-mono text-gray-900">₱{{ number_format($eq['balance'], 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="py-1.5 text-sm text-gray-600 font-mono">-</td>
                    <td class="py-1.5 text-sm text-gray-800">Retained Earnings (Current Period Net Income)</td>
                    <td class="py-1.5 text-sm text-right font-mono text-gray-900">₱{{ number_format($netIncome, 2) }}</td>
                </tr>
                <tr class="font-semibold border-t">
                    <td colspan="2" class="py-2 text-right text-sm">Total Equity:</td>
                    <td class="py-2 text-right text-sm font-mono text-indigo-600">₱{{ number_format($totalEquity, 2) }}</td>
                </tr>
            </table>

            <!-- Balance Sheet Equation Check -->
            <div class="bg-gray-50 p-4 rounded-md flex justify-between items-center font-bold text-md border">
                <span>Total Liabilities & Equity:</span>
                <span class="font-mono text-gray-900">
                    ₱{{ number_format($totalLiabilities + $totalEquity, 2) }}
                </span>
            </div>
        </div>
    @endif
</div>