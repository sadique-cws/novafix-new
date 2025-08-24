<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novafix | Frontdesk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#6366f1',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-transition {
            transition: transform 0.3s ease;
        }

        .backdrop-transition {
            transition: opacity 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50" x-data="dashboard()">
    <!-- Mobile backdrop -->
    <div x-show="isMobileSidebarOpen" @click="isMobileSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 backdrop-transition lg:hidden"
        :class="isMobileSidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'">
    </div>

    <div class="flex gap-1">
        <!-- Sidebar -->
        <div class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 z-50 transform transition-transform duration-300"
            :class="isMobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            <a wire:navigate href="{{ route('frontdesk.dashboard') }}" class="pt-4 pb-2 px-4 border-b border-gray-200 flex items-center justify-start gap-2">
                <div class="py-1 px-2 rounded-lg bg-[#1E40AF] text-xl font-medium text-[#F9FAFB]">NF</div>
                <h2 class="text-lg font-medium md:text-xl text-[#111827]">Recepoinst</h2>
                <button @click="isMobileSidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </a>

            <!-- Navigation -->
            <nav class="px-3 mt-4">
                <ul class="space-y-1 text-sm">
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.dashboard') }}" 
                              class="flex items-center gap-3 px-3 py-2 mb-2 rounded {{ request()->routeIs('frontdesk.dashboard') ? 'bg-secondary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-400"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.servicerequest.create') }}" 
                          class="flex items-center gap-3 px-3 py-2 mb-2 rounded {{ request()->routeIs('frontdesk.servicerequest.create') ? 'bg-secondary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-plus-circle mr-3 text-gray-400"></i>
                            New Service Request
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.servicerequest.manage') }}" 
                         class="flex items-center gap-3 px-3 py-2 mb-2 rounded {{ request()->routeIs('frontdesk.servicerequest.manage') ? 'bg-secondary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-tasks mr-3 text-gray-400"></i>
                            Service Queue
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.servicerequest.completed') }}" 
                          class="flex items-center gap-3 px-3 py-2 mb-2 rounded {{ request()->routeIs('frontdesk.servicerequest.completed') ? 'bg-secondary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-check-circle mr-3 text-gray-400"></i>
                            Completed Services
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.manage.payments') }}" 
                         class="flex items-center gap-3 px-3 py-2 rounded {{ request()->routeIs('frontdesk.manage.payments') ? 'bg-secondary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-boxes mr-3 text-gray-400"></i>
                            Manage Payment
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.profile') }}" 
                          class="flex items-center gap-3 px-3 py-2 rounded {{ request()->routeIs('frontdesk.profile') ? 'bg-secondary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-user-circle mr-2 text-gray-400"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('frontdesk.logout') }}" class="sidebar-link flex items-center hover:text-red-500 px-4 py-3 text-white bg-red-600 rounded-lg transition duration-150">
                            <i class="fas fa-sign-out-alt mr-2 text-white"></i> Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main content -->
        <div class="min-h-screen w-full md:w-[calc(100%-16rem)] md:ml-64">
            <div class="lg:hidden flex items-center justify-between px-4 py-3 bg-white shadow-sm">
                <button @click="isMobileSidebarOpen = true" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <img src="https://www.pngmart.com/files/21/Admin-Profile-Vector-PNG-Clipart.png"
                                alt="User profile" class="rounded-full w-8 h-8 object-cover border-2 border-gray-200">
                            <i class="fas fa-chevron-down text-xs text-gray-500 transition-transform"
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-100">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                            <div class="border-t border-gray-100"></div>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-red-500 hover:text-red-600">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
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
        function dashboard() {
            return {
                isMobileSidebarOpen: false,
                openDropdowns: {
                    franchise: false,
                    solution: false,
                    finance: false,
                    reports: false
                },
                isMobile: window.innerWidth < 640,
                toggleDropdown(dropdown) {
                    this.openDropdowns[dropdown] = !this.openDropdowns[dropdown];
                    // Close other dropdowns
                    Object.keys(this.openDropdowns).forEach(key => {
                        if (key !== dropdown) {
                            this.openDropdowns[key] = false;
                        }
                    });
                },
                init() {
                    window.addEventListener('resize', () => {
                        this.isMobile = window.innerWidth < 640;
                    });
                }
            }
        }
    </script>
</body>

</html>