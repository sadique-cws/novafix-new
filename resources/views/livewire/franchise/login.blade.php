<div class="flex items-center justify-center ">
    <div class="login-card  w-[42vh] md:w-[170vh]  rounded-2xl overflow-hidden flex flex-col md:flex-row relative">
          <!-- Loading Overlay -->
        <div wire:loading.flex class="absolute inset-0 bg-white bg-opacity-90 z-50 items-center justify-center rounded-2xl">
            <div class="text-center">
                <svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700">Signing you in...</h3>
                <p class="text-gray-500 mt-2">Please wait while we authenticate your account</p>
            </div>
        </div>
        <!-- Left Side - Form -->
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-500 to-purple-600 items-center justify-center  relative overflow-hidden">
            <div class="illustration text-center">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/login-3305943-2757111.png" 
                     alt="Login Illustration" class="w-full max-w-md mx-auto">
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-center text-white">
                <h3 class="text-xl font-semibold mb-2">Join our community</h3>
                <p class="text-sm opacity-90">Discover the best tools and resources for your projects</p>
            </div>
            <!-- Decorative elements -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mt-16"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mb-32"></div>
        </div>
        <!-- Right Side - Illustration -->
         <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center">
            <div class="text-center md:text-left mb-8">
                <h1 class="text-2xl md:text-4xl text-center font-bold text-gray-800 mb-2">Welcome Franchise</h1>
                <p class="text-gray-600 text-center">Sign in to access your account</p>
            </div>
            <form wire:submit.prevent="login"  class="space-y-6">
                <!-- Email Field -->
                <div class="input-field">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" wire:model='email' autocomplete="email" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 sm:text-sm bg-white/90 transition-all duration-300 placeholder-gray-400"
                            placeholder="you@example.com">
                    </div>
                </div>
                <!-- Password Field -->
                <div class="input-field">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" wire:model='password' autocomplete="current-password" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 sm:text-sm bg-white/90 transition-all duration-300 placeholder-gray-400"
                            placeholder="••••••••">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                            <i class="fas fa-eye-slash text-gray-400 hover:text-gray-600" id="togglePassword"></i>
                        </div>
                    </div>
                </div>
                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-400 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a wire:navigate href="{{ route('frontdesk.password.request') }}"
                            class="font-medium text-indigo-500 hover:text-indigo-600 transition-colors duration-200">Forgot password?</a>
                    </div>
                </div>
                <!-- Login Button -->
                <div>
                    <button type="submit"
                        class="btn-login w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-md text-base font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                        </span>
                        <span wire:loading>
                            <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
                
                  <div class="relative" wire:loading.attr="disabled">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>
                
                <!-- Social Login -->
              
            </form>
            
            <!-- Sign Up Link -->
            <div class="mt-6 text-center text-sm text-gray-600">
                Don't have an account? <a href="#" class="font-medium text-indigo-500 hover:text-indigo-600 transition-colors duration-200">Sign up</a>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .login-card {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.85);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .login-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        
        .input-field {
            transition: all 0.3s ease;
        }
        
        .input-field:focus-within {
            transform: translateY(-2px);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: 200% auto;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .illustration {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        .social-btn {
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            transform: translateY(-3px) scale(1.05);
        }
    </style>
    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</div>