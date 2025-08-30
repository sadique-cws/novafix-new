<div class="p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Edit Receptionist</h2>

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
