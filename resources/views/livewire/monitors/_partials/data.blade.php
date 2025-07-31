

    <div>
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>




                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Product') }}
                            </th>

                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Marketplace') }}
                            </th>

                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('URL') }}</th>

                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('USafety Price') }}</th>

                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Last Scraped') }}</th>




                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">

                        @foreach($items as $item)
                        <tr class="hover:bg-gray-100">


                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">


                                {{ $item->product->name ?? '-' }}

                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">


                                {{ $item->marketplace->name ?? '-' }}

                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">


                                <a href="{{ $item->external_url }}" class="text-blue-600 underline" target="_blank">
                                    {{ Str::limit($item->external_url, 40) }}
                                </a>

                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">


                                {{ number_format($item->safety_price, 2) }} €

                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">


                            {{ $item->last_scraped_at ? $item->last_scraped_at->diffForHumans() : '-' }}

                            </td>



                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

