

    <div>
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('id') }}
                            </th>


                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Type') }}
                            </th>

                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Status') }}
                            </th>

                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Job') }}
                            </th>


                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Total') }}
                            </th>

                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Duration seconds') }}
                            </th>


                            <th scope="col" class="px-2 py-2 text-start text-sm text-gray-500">
                                {{ __('Triggered') }}
                            </th>

                            <th scope="col" class="px-2 py-2 text-end text-sm text-gray-500">
                                {{ __('Created') }}</th>
                            @if(isEnableLogSync())
                                <th scope="col" class="px-2 py-2 text-end text-sm text-gray-500">
                                    {{ __('Actions') }}</th>

                            @endif

                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">

                        @foreach($items as $item)

                            @php


                                $s = $item?->duration_seconds ?? 0;

                                $durationText = \Carbon\CarbonInterval::seconds($s)
                                    ->cascade()
                                    ->locale(app()->getLocale()) // 'el' ή 'en'
                                    ->forHumans([
                                        'join' => true, // π.χ. "2 λεπτά και 3 δευτερόλεπτα"
                                        'parts' => 2,   // max πόσα μέρη να δείξει
                                        'short' => false
                                    ]);
                            @endphp

                        <tr class="hover:bg-gray-100">

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->id }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->type }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                @switch($item->status)
                                    @case('completed')
                                        <span  class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-success text-white rounded me-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 class="size-3">
  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
</svg>

                            {{ __('Completed') }}
                        </span>
                                        @break

                                    @case('pending')
                                        <div class="flex items-center justify-start gap-3">
                                            <div class="animate-spin w-4 h-4 border-[3px] border-current border-t-transparent text-amber-500 rounded-full"
                                                 role="status" aria-label="loading">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <span  class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-warning text-white rounded me-1">

                         {{ __('Running') }}
                    </span>
                                        </div>
                                        @break

                                    @case('running')
                                        <div class="flex items-center justify-start gap-3">
                                            <div class="animate-spin w-4 h-4 border-[3px] border-current border-t-transparent text-amber-500 rounded-full"
                                                 role="status" aria-label="loading">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <span  class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-warning text-white rounded me-1">

                         {{ __('Running') }}
                    </span>
                                        </div>

                                        @break

                                    @default
                                        <span  class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-danger text-white rounded me-1">
                      {{ __('Failed') }}
                    </span>
                                @endswitch
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->total_jobs }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->total_items }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $durationText }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800">
                                {{ $item->triggered_by }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-800 " style="text-align: right">


                                {{ optional($item->created_at)?->format('d/m/Y H:i') }}
                            </td>
                            @if(isEnableLogSync())
                                <td class="px-2 py-2 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-3">

                                <div class="hs-tooltip">
                                        <a href="{{ route('synchronization.log.view', $item) }}"
                                           data-fc-placement="bottom" class=" h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center" >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>

                                        </a>
                                        <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                              role="tooltip">
                                                        {{ __('Mapping') }}
                                                    </span>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

