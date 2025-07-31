<x-app-layout>


    <div class="flex items-center justify-between flex-wrap gap-2 mb-6">
        <div>
            <h4 class="text-slate-900 text-lg font-medium mb-2">
                <div class="flex justify-start items-center gap-2">
                    <i class="material-symbols-rounded font-light text-2xl transition-all group-hover:fill-1">Person</i>
                    {{ __('Profile') }}
                </div> <!-- flex justify-start items-center gap-2-->
            </h4><!-- text-slate-900 text-lg font-medium mb-2-->
        </div><!-- DIV -->
    </div> <!-- flex items-center justify-between flex-wrap gap-2 mb-6-->



    <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">

        <div class="card">
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card">
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

    </div>
</x-app-layout>
