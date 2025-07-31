

<div>
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Level') }}
                        </th>

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Message') }}
                        </th>

                        <th scope="col" class="px-2 py-2 text-end text-sm text-gray-500">
                            {{ __('Context') }}</th>


                        <th scope="col" class="px-2 py-2 text-end text-sm text-gray-500">
                            {{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                    @foreach($items as $item)
                        <tr class="hover:bg-gray-100">

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->level }}
                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">

                                {{ $item->message }}
                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-3">

                                <code>
                                    {{ json_encode($item->context,true) }}
                                </code>


                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800" style="text-align: right">

                                {{ optional($item->created_at)?->format('d/m/Y H:i') }}
                            </td>




                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

