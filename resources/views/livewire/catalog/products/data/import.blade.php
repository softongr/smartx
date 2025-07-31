<div>


<div class="max-w-lg mx-auto p-4 bg-white rounded-xl shadow">
@if (session()->has('success'))
    <div class="text-green-600 font-semibold mb-2">{{ session('success') }}</div>
@endif

@if (session()->has('error'))
    <div class="text-red-600 font-semibold mb-2">{{ session('error') }}</div>
@endif

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Ανέβασε JSON αρχείο:</label>
            <input type="file" wire:model="jsonFile" accept=".json,.txt"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            @error('jsonFile') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Εισαγωγή
        </button>
    </form>
</div></div>
