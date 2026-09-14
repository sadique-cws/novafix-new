<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novafix | Franchise</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: transform 0.3s ease; }
        .backdrop-transition { transition: opacity 0.3s ease; }
    </style>
    @livewireStyles
</head>

<body class="bg-gray-50" x-data="dashboard()">
    <!-- Mobile backdrop -->
    <div x-show="isMobileSidebarOpen" @click="isMobileSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 backdrop-transition lg:hidden" x-cloak
        :class="isMobileSidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'">
    </div>

    <div class="flex gap-1">
        <!-- Sidebar -->
        <div class="fixed top-0 left-0 h-screen w-64 bg-gray-900 border-r border-gray-800 z-50 transform transition-transform duration-300 flex flex-col"
            :class="isMobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            
            <div class="pt-4 pb-4 px-4 border-b border-gray-800 flex items-center justify-start gap-3">
                <div class="py-1 px-2 rounded-lg bg-[#1E40AF] text-xl font-medium text-[#F9FAFB]">NF</div>
                <h2 class="text-base font-medium md:text-lg text-white truncate max-w-[150px]">{{Auth::guard('franchise')->user()->franchise_name ?? 'Franchise'}}</h2>
                <button @click="isMobileSidebarOpen = false" class="lg:hidden ml-auto text-gray-500 hover:text-gray-300">
                    <i class="fas text-lg fa-times"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 overflow-y-auto flex-1">
                <ul>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.dashboard') }}" 
                              class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('franchise.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.manage.staff') }}" 
                              class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('franchise.manage.staff', 'franchise.add.staff') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                            <i class="fas fa-users-cog mr-3 w-5 text-center"></i>
                            <span>Manage Staff</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.manage.receptioners') }}" 
                              class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('franchise.manage.receptioners', 'franchise.add.receptioners') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                            <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                            <span>Receptionists</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.manage.service') }}" 
                              class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('franchise.manage.service') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                            <i class="fas fa-tags mr-3 w-5 text-center"></i>
                            <span>Types</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.manage.customer') }}" 
                              class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('franchise.manage.customer', 'franchise.view.customer') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                            <i class="fas fa-users mr-3 w-5 text-center"></i>
                            <span>Customers</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.repair-requests') }}" 
                              class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('franchise.repair-requests') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                            <i class="fas fa-clipboard-list mr-3 w-5 text-center"></i>
                            <span>User Service Requests</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.manage.payments') }}" 
                              class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('franchise.manage.payments') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                            <i class="fas fa-file-invoice-dollar mr-3 w-5 text-center"></i>
                            <span>Manage Payments</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="#" 
                              class="flex items-center font-medium p-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                            <i class="fas fa-chart-line mr-3 w-5 text-center"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('franchise.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 gap-3 bg-red-600/10 text-red-500 rounded-lg hover:bg-red-600 hover:text-white transition-colors font-medium text-left">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main content -->
        <div class="min-h-screen w-full md:w-[calc(100%-16rem)] md:ml-64">
            <!-- Top Navbar -->
            <div class="sticky top-0 z-40 flex items-center justify-between px-6 py-4 bg-gray-900 shadow-md border-b border-gray-800">
                <!-- Mobile Menu Button (Hidden on Desktop) -->
                <button @click="isMobileSidebarOpen = true" class="lg:hidden text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Spacer for desktop -->
                <div class="hidden lg:block">
                    <h1 class="text-white font-medium text-lg capitalize">
                        {{ str_replace(['franchise.', '.'], ['', ' '], request()->route()->getName() ?? 'Dashboard') }}
                    </h1>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="text-gray-400 hover:text-white transition-colors relative">
                        <i class="far fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                        </span>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="flex items-center space-x-3 focus:outline-none">
                            <span class="hidden md:block text-sm font-medium text-gray-300">{{Auth::guard('franchise')->user()->franchise_name ?? 'Franchise'}}</span>
                            <img src="https://ui-avatars.com/api/?name=Franchise&background=1E40AF&color=fff" alt="User profile" class="w-9 h-9 rounded-full object-cover border-2 border-gray-700">
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open" x-transition x-cloak
                            class="absolute right-0 mt-3 w-48 bg-white border border-gray-200 rounded-lg shadow-xl py-2 z-50">
                            <a href="{{ route('franchise.profile') }}" wire:navigate class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary transition-colors">
                                <i class="fas fa-user mr-3 text-gray-400"></i> Profile
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary transition-colors">
                                <i class="fas fa-cog mr-3 text-gray-400"></i> Settings
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('franchise.logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                    <i class="fas fa-sign-out-alt mr-3"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <main class="p-2 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            window.dashboard = function() {
                return {
                    isMobileSidebarOpen: false,
                    isMobile: window.innerWidth < 640,
                    init() {
                        window.addEventListener('resize', () => {
                            this.isMobile = window.innerWidth < 640;
                        });
                        // Watch for Livewire navigation to close mobile sidebar
                        document.addEventListener('livewire:navigated', () => {
                            this.isMobileSidebarOpen = false;
                        });
                    }
                }
            }
        });
    </script>
    @livewireScripts
</body>

</html>