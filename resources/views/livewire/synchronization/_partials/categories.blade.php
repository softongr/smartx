

    <div>
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>

                                <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                    {{ __('ID') }}
                                </th>

                                <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                    {{ __('ID PrestaShop') }}
                                </th>
                                <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                    {{ __('Name') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">

                        @foreach($items as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->id }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->prestashop_id }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->name }}
                            </td>










                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

