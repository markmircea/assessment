<div>
    @if ($currentBrand)
        <div class="h-1 w-full" style="background-color: {{ $currentBrand->color }}"></div>
    @endif

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="mb-6 flex flex-wrap gap-2">
            <button
                wire:click="clearBrand"
                class="px-4 py-2 rounded text-sm font-medium {{ !$currentBrandId ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
            >
                All Brands
            </button>
            @foreach ($brands as $brand)
                <button
                    wire:click="switchBrand({{ $brand->id }})"
                    class="px-4 py-2 rounded text-sm font-medium {{ $currentBrandId == $brand->id ? 'text-white' : 'text-gray-700 bg-gray-200 hover:bg-gray-300' }}"
                    style="{{ $currentBrandId == $brand->id ? 'background-color: ' . $brand->color : '' }}"
                >
                    {{ $brand->name }}
                </button>
            @endforeach
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ $currentBrand ? $currentBrand->name . ' Stores' : 'All Stores' }}
        </h2>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" wire:loading.class="opacity-50">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Revenue</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Profit</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($stores as $store)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $store->number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded text-white" style="background-color: {{ $store->brand->color }}">
                                    {{ $store->brand->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $store->address }}, {{ $store->city }}, {{ $store->state }} {{ $store->zip_code }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                ${{ number_format($store->journals_sum_revenue, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right {{ $store->journals_sum_profit > 0 ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($store->journals_sum_profit, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-medium">
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-sm text-gray-700">Totals</td>
                        <td class="px-6 py-3 text-sm text-right">${{ number_format($stores->sum('journals_sum_revenue'), 2) }}</td>
                        <td class="px-6 py-3 text-sm text-right">${{ number_format($stores->sum('journals_sum_profit'), 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
