<div>

    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Dashboard</i>
                    {{ __('Dashboard') }}

                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->

    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->
    @if($hasError)


        <div class="card overflow-hidden p-6"  wire:poll.500ms>
            <div class="flex ">
                <div class="bg-danger text-sm text-white rounded-md p-4" role="alert">
                    <span class="font-bold">{{ __('Error!') }}</span>
                    {{__('Please fill in all the required system fields to proceed.')}}
                </div>
                <a href="{{route('settings')}}">{{ __('Settings') }}</a>
            </div>
        </div>
    @endif

    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">


        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="p-5">
                                <span
                                    class="material-symbols-rounded float-end text-3xl text-default-400">Group</span>
                    <h6 class="text-muted text-sm uppercase">{{__('Business Customers')}}</h6>
                    <h3 class="text-2xl mb-3"><span></span></h3>
                    <span
                        class="inline-flex items-center gap-1.5 py-0.5 px-1.5 text-xs font-medium bg-danger text-white rounded me-1">
                                    {{$todayScrapeCount}} </span> <span class="text-muted">{{ __('Today') }}</span>
                </div>
            </div>
        </div>



    </div>






<div wire:poll.500ms>
    @include('livewire._partials.sync_running')
</div>

    <div class="card">
        <div class="card-header">
            <h5>Πρόσφατη Δραστηριότητα</h5>
        </div>
        <div class="card-body">
            @forelse($recentActivity as $log)
                <div class="mb-2">
                    <strong>{{ $log->user->name ?? 'System' }}</strong>
                    έκανε <strong>{{ strtoupper($log->action_type) }}</strong> στο
                    <em>{{ class_basename($log->model_type) }}</em>
                    (ID: {{ $log->model_id }})
                    <br>
                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p>Καμία δραστηριότητα.</p>
            @endforelse
        </div>
    </div>
</div>
