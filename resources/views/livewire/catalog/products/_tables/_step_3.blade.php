

<div>
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>



                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Platform Ready') }}
                        </th>
                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('A/A') }}
                        </th>

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Name') }}
                        </th>

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">

                            {{ __('Wholesale Price') }}

                        </th>

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">

                            {{ __('Price') }}

                        </th>

                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Safety Price') }}
                        </th>


                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Total Orders') }}
                        </th>


                        <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                            {{ __('Updated At') }}
                        </th>

                        <th scope="col" class="px-2 py-2 text-end text-sm text-gray-500">
                            {{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                    @foreach($items as $item)

                        @php
                            $rowClasses = 'hover:bg-gray-100';
                            if ($item->status === 'platform') {
                                $rowClasses .= ' bg-green-100';
                            }
                        @endphp

                        <tr class="{{ $rowClasses }}">

                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">


                                <input
                                    type="checkbox"
                                    class="form-switch"
                                    role="switch"
                                    @checked($item->status === 'platform')
                                    wire:click="setAsPlatform({{ $item->id }})"
                                />

                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">

                                {{ $item->id }}
                            </td>



                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->name ?? '-' }}
                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->wholesale_price  ?? '-' }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->price  ?? '-' }}
                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->safety_price ?? '-' }}
                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->average_orders ??  '-' }}
                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : '-' }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-3">
                                @if($item->status !== 'platform')
                                <div class="hs-tooltip">
                                    <a href="{{ route('product.parser', $item) }}" data-fc-placement="bottom" class=" h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                                        </svg>

                                    </a>
                                    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                          role="tooltip">
                                                    {{ __('Settings') }}
                                        </span>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

