<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Trial Balance Report</h2>
        <div class="flex space-x-2">
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

    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Name</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Debit (₱)</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Credit (₱)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($reportData as $row)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row['code'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $row['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900">
                            {{ $row['debit'] > 0 ? number_format($row['debit'], 2) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900">
                            {{ $row['credit'] > 0 ? number_format($row['credit'], 2) : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No posted transactions found within this date range.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50 font-bold">
                <tr>
                    <td colspan="2" class="px-6 py-4 text-right text-sm text-gray-900">Total:</td>
                    <td class="px-6 py-4 text-right text-sm font-mono {{ round($totalDebit, 2) !== round($totalCredit, 2) ? 'text-red-600' : 'text-gray-900' }}">
                        ₱{{ number_format($totalDebit, 2) }}
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-mono {{ round($totalDebit, 2) !== round($totalCredit, 2) ? 'text-red-600' : 'text-gray-900' }}">
                        ₱{{ number_format($totalCredit, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if(round($totalDebit, 2) === round($totalCredit, 2) && $totalDebit > 0)
        <div class="mt-4 bg-green-50 border border-green-200 p-4 rounded-md text-green-800 text-sm flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            Trial Balance is balanced! Total Debits equal Total Credits.
        </div>
    @elseif($totalDebit > 0 || $totalCredit > 0)
        <div class="mt-4 bg-red-50 border border-red-200 p-4 rounded-md text-red-800 text-sm flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            Warning: Trial Balance is out of balance! Please review your journal entry line items.
        </div>
    @endif
</div>