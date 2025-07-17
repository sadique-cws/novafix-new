<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Receptionist</h2>

    @if(session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">  
            <!-- Personal Information -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input wire:model="name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 border py-1 px-2  shadow-sm p">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input wire:model="contact" type="text" id="contact" class="mt-1 block w-full rounded-md border-gray-300 py-1 px-2 border shadow-sm p">
                @error('contact') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input wire:model="email" type="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 py-1 px-2 border shadow-sm p">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="aadhar" class="block text-sm font-medium text-gray-700">Aadhar Number</label>
                <input wire:model="aadhar" type="text" id="aadhar" class="mt-1 block w-full rounded-md border-gray-300 py-1 px-2 border shadow-sm p">
                @error('aadhar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="pan" class="block text-sm font-medium text-gray-700">PAN Number</label>
                <input wire:model="pan" type="text" id="pan" class="mt-1 block w-full rounded-md border-gray-300 py-1 px-2 border shadow-sm p">
                @error('pan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                <input wire:model="salary" type="number" id="salary" class="mt-1 block w-full rounded-md border-gray-300 py-1 px-2 border shadow-sm p">
                @error('salary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Password Fields -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input wire:model="password" type="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 py-1 px-2 border shadow-sm p">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input wire:model="password_confirmation" type="password" id="password_confirmation" class="mt-1 block w-full rounded-md border border-gray-300 py-1 px-2  shadow-sm p">
            </div>

            <!-- Address -->
            <div class="col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea wire:model="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 border shadow-sm  py-1 px-2"></textarea>
                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2   focus:ring-blue-500 focus:ring-offset-2">
                Add Receptionist
            </button>
        </div>
    </form>
</div>