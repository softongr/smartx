

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
                                <th scope="col" class="px-2 py-2 text-end text-sm text-gray-500">
                                    {{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">

                        @foreach($items as $item)
                        <tr class="hover:bg-gray-100" wire:key="product-{{ $item->id }}">
                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->id }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->prestashop_id }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->name }}
                            </td>


                            <td class="px-2 py-2 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-3">

                                <div class="hs-tooltip">
                                    <a href="{{$item->link}}" target="_blank"
                                       class=" h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center" >
                                        <i class="material-symbols-rounded font-light text-2xl
                                                     transition-all group-hover:fill-1">Visibility</i>
                                    </a>
                                    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100
                                                 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                          role="tooltip">
                                                    {{ __('View Product') }}
                                                </span>
                                </div>

                                @if(!$item->monitor)
                                    <a href="{{route('product.shops.to-monitor',$item)}}"  target="_blank" class=" btn bg-primary/25 text-primary hover:bg-primary hover:text-white" >
                                        {{ __('Add to monitor') }}
                                    </a>
                                @else
                                    <a href="{{route('product.shops.to-monitor',$item)}}"
                                       target="_blank" class=" btn bg-warning/25 text-warning hover:bg-warning hover:text-white" >
                                        {{ __('Edit Monitor') }}
                                    </a>
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

