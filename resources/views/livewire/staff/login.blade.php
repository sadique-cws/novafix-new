<div>
    <div class="w-full md:w-4/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-user-shield text-purple-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Staff Portal</h1>
                <p class="text-gray-600 mt-2">Sign in to access your dashboard</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Login Form -->
                <form wire:submit.prevent="login">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input wire:model="email" type="email"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Password</label>
                        <input wire:model="password" type="password"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
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

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Need help?</span>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-500">
                            <i class="fas fa-headset mr-1"></i> Contact support
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-sm text-gray-500">
                <p>© 2023 Service Center. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>


</div>
