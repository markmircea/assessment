<x-app-layout>
    <div class="h-1 w-full" style="background-color: {{ $store->brand->color }}"></div>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="mb-4">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline text-sm">&larr; Back to Dashboard</a>
        </div>

        <div class="flex items-center gap-3 mb-6">
            <span class="px-2 py-1 text-xs font-semibold rounded text-white" style="background-color: {{ $store->brand->color }}">
                {{ $store->brand->name }}
            </span>
            <h2 class="text-xl font-semibold text-gray-800">Store #{{ $store->number }}</h2>
        </div>

        <p class="text-gray-600 mb-6">{{ $store->address }}, {{ $store->city }}, {{ $store->state }} {{ $store->zip_code }}</p>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Revenue</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Food Cost</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Labor Cost</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Profit</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($journals as $journal)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $journal->date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">${{ number_format($journal->revenue, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">${{ number_format($journal->food_cost, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">${{ number_format($journal->labor_cost, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $journal->profit > 0 ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($journal->profit, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $journals->links() }}
        </div>
    </div>
</x-app-layout>