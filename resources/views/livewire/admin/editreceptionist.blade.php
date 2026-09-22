<div class="p-6 bg-white shadow rounded">
    <div class="flex justify-end mb-4">
        <a wire:navigate href="{{ route('admin.receptionst.management') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-2xs text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Receptionists
        </a>
    </div>

    @if (session()->has('success'))
        <div class="p-2 mb-3 text-green-700 bg-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label class="block font-semibold">Name</label>
            <input type="text" wire:model="name" class="w-full border rounded p-2">
            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Contact</label>
            <input type="text" maxlength="10" wire:model="contact" class="w-full border rounded p-2">
            @error('contact') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Email</label>
            <input type="email" wire:model="email" class="w-full border rounded p-2">
            @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Aadhar</label>
            <input type="text" wire:model="aadhar" class="w-full border rounded p-2">
            @error('aadhar') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">PAN</label>
            <input type="text" wire:model="pan" class="w-full border rounded p-2">
            @error('pan') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Address</label>
            <input type="text" wire:model="address" class="w-full border rounded p-2">
            @error('address') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Salary</label>
            <input type="text" wire:model="salary" class="w-full border rounded p-2">
            @error('salary') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Status</label>
            <select wire:model="status" class="w-full border rounded p-2">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            @error('status') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Update Receptionist
        </button>
    </form>
</div>
