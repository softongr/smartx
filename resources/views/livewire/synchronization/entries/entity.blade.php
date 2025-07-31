<div class="col-xl-3 col-md-6">
    <div class="card">
        <div class="p-5">
            @php
                $anyRunning = collect($batches)->contains(fn($b) => $b && $b->status === 'running');
            @endphp

            @php
                $batch = $batches[$type] ?? null;
                $progress = $this->getProgressFor($type);
                $count = $counts[$type] ?? 0;
                $latestDate = $latestSyncs[$type] ?? null;
            @endphp

            @php
                use Carbon\CarbonInterval;

                $s = $batch?->duration_seconds ?? 0;

                $durationText = CarbonInterval::seconds($s)
                    ->cascade()
                    ->locale(app()->getLocale()) // 'el' ή 'en'
                    ->forHumans([
                        'join' => true, // π.χ. "2 λεπτά και 3 δευτερόλεπτα"
                        'parts' => 2,   // max πόσα μέρη να δείξει
                        'short' => false
                    ]);
            @endphp

            @if((!$anyRunning || $batch?->status === 'running') && (!$batch || $batch->status !== 'running'))

            <span class="float-end">
                     <button class="btn rounded-full bg-dark/25 text-slate-900 hover:bg-dark hover:text-white"
                            wire:click="startSync('{{ $type }}')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                    </button>
                </span>
            @endif

            <div class="mb-2">


                @if($batch && $batch->status === 'running')
                    <div class="flex items-center justify-start gap-3">
                        <div class="animate-spin w-4 h-4 border-[3px] border-current border-t-transparent text-amber-500 rounded-full"
                             role="status" aria-label="loading">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span  class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-warning text-white rounded me-1">

                         {{ __('Running') }}
                    </span>
                    </div>




                @elseif($batch && $batch->status ==='completed')
                    <div class="flex items-center gap-2">
                        <span  class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-success text-white rounded me-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 class="size-3">
  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
</svg>

                            {{ __('Completed') }}
                        </span>

                    <span class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>

                     <small><i>{{ $durationText }}</i></small>
                  </span>
                    </div>

                @elseif($batch && $batch->status ==='failed')
                    <span  class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-danger text-white rounded me-1">
                      {{ __('Failed') }}
                    </span>

                @else

                @endif
            </div>

            <h6 class="text-muted text-sm uppercase">{{ __(Str::plural(ucfirst($type))) }}</h6>

            <h3 class="text-2xl" data-plugin="counterup">

                {{ $count }}

            </h3>

            @if($batch && $batch->status === 'completed')

                <div class="flex justify-between">
                    <small>
                        <b>{{ __('Latest Date') }}:</b>
                        <i>{{ optional($latestDate)?->format('d/m/Y H:i') }}</i>
                        @if($latestDate)
                            ({{ $latestDate->diffForHumans() }})
                        @endif
                    </small>



                </div>







            @endif


            @if($batch && $batch->status === 'running')
                <x-sync-progress :batch="$batch" :progress="$progress" :entity="__(Str::plural(ucfirst($type)))"/>
            @endif


            <hr class="mt-1">
            <div class="mt-2 flex gap-1">

                <small class="flex gap-2">
                    <b class="flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        <i>
                            {{ __('Name Job:') }}
                        </i>
                    </b>
                    <i>
                        <code>
                            php artisan sync:entity  {{ $type }}
                        </code>
                    </i>
                </small>






            </div>



        </div>

    </div>
</div>
