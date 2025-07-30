<div>
      <form wire:submit.prevent="login" class="space-y-6">
      <h3 class="text-2xl font-semibold text-gray-800 text-center">Staff Portal</h3>
      <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
              Email Address
          </label>
          <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-envelope text-gray-400"></i>
              </div>
              <input id="email" wire:model="email" type="email" autocomplete="email" required
                  class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 sm:text-sm transition-all duration-300"
                  placeholder="you@example.com">
          </div>
      </div>

      <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
              Password
          </label>
          <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-lock text-gray-400"></i>
              </div>
              <input id="password" wire:model="password" type="password" autocomplete="current-password" required
                  class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 sm:text-sm transition-all duration-300"
                  placeholder="••••••••">
          </div>
          @error('password')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
      </div>

      <div class="flex items-center justify-between">
          <div class="flex items-center">
              <input wire:model="remember" id="remember" type="checkbox"
                  class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-gray-300 rounded">
              <label for="remember" class="ml-2 block text-sm text-gray-700">
                  Remember me
              </label>
          </div>

          <div class="text-sm">
              <a href="#" class="font-medium text-accent-600 hover:text-accent-500">
                  Forgot password?
              </a>
          </div>
      </div>

      <div>
          <button type="submit"
              class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-accent-500 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition-all duration-300 hover:scale-[1.02]">
              <i class="fas fa-sign-in-alt mr-2"></i>
              Sign In
          </button>
      </div>
  </form>

</div>