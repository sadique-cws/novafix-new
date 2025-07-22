<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    @if($error)
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ $error }}
        </div>
    @endif

    <form wire:submit.prevent="login">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input wire:model="email" type="email" 
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Password</label>
            <input wire:model="password" type="password" 
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4 flex items-center">
            <input wire:model="remember" type="checkbox" id="remember" class="mr-2">
            <label for="remember">Remember me</label>
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
            Login
        </button>
    </form>
</div>

  