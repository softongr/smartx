@props(['batch', 'entity', 'progress'])




<div class="flex w-full h-4 bg-gray-200 rounded-full overflow-hidden mt-2">
    <div class="flex flex-col justify-center overflow-hidden bg-primary text-xs text-white text-center" role="progressbar"
         style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ $progress }}%</div>
</div>

<div class="mb-2">
   <small><i>
           {{ $entity }}: {{ $batch->finished_jobs }} / {{ $batch->total_jobs }} {{ __('Jobs') }}
       </i></small>
</div>
