<form wire:submit.prevent="toShop" class="mt-6">
    <div class="grid lg:grid-cols-3 gap-6 mt-5">
    <button style="height: 80px;width: 100%;" type="submit" class="btn btn-lg bg-primary text-white gap-3 gap-3">
        <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Send</i>
        <span class="ml-2">
                        {{ __('Send Now') }}
                    </span><!-- ml-2 -->
    </button><!-- btn rounded-full  bg-primary text-white gap-3-->
    </div>
</form>
