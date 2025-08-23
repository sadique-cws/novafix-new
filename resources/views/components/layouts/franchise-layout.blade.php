<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novafix | Admin</title>
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

        :root {
            --primary-color: #1E40AF;
            --secondary-color: #3B82F6;
            --accent-color: #10B981;
            --background-color: #F9FAFB;
            --text-color: #111827;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
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
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">

                <h2 class="text-lg font-semibold md:text-2xl text-gray-800">Novafix | Admin</h2>
                <button @click="isMobileSidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Profile section -->


            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <a wire:navigate href="{{ route('franchise.dashboard') }}"
                    class="flex {{ request()->routeIs('franchise.dashboard') ? 'bg-[var(--secondary-color)] text-white' : 'hover:bg-[var(--secondary-color)] hover:text-white' }} items-center p-2 rounded hover:bg-[var(--secondary-color)] hover:text-white">
                    <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i> Dashboard
                </a>
                <a wire:navigate href="{{ route('franchise.manage.staff') }}"
                    class="flex {{ request()->routeIs('franchise.manage.staff') ? 'bg-[var(--secondary-color)] text-white' : 'hover:bg-[var(--secondary-color)] hover:text-white' }} items-center p-2 rounded hover:bg-[var(--secondary-color)] hover:text-white">
                    <i class="fas fa-users-cog mr-3 w-5 text-center"></i> Manage Staff
                </a>
                <a wire:navigate href="{{ route('franchise.manage.receptioners') }}"
                    class="flex items-center p-2 rounded hover:bg-[var(--secondary-color)] hover:text-white">
                    <i class="fas fa-user-tie mr-3 w-5 text-center"></i> Manage Receptionists
                </a>
                <a wire:navigate href="{{ route('franchise.manage.service') }}"
                    class="flex {{ request()->routeIs('franchise.manage.service') ? 'bg-[var(--secondary-color)] text-white' : 'hover:bg-[var(--secondary-color)] hover:text-white' }} items-center p-2 rounded hover:bg-[var(--secondary-color)] hover:text-white">
                    <i class="fas fa-tags mr-3 w-5 text-center"></i> Types
                </a>
                <a wire:navigate href="{{ route('franchise.manage.customer') }}"
                    class="flex {{ request()->routeIs('franchise.manage.customer') ? 'bg-[var(--secondary-color)] text-white' : 'hover:bg-[var(--secondary-color)] hover:text-white' }} items-center p-2 rounded hover:bg-[var(--secondary-color)] hover:text-white">
                    <i class="fas fa-users mr-3 w-5 text-center"></i> Customers
                </a>
                <a wire:navigate href="{{ route('franchise.manage.payments') }}"
                    class="flex items-center {{ request()->routeIs('franchise.manage.payments') ? 'bg-[var(--secondary-color)] text-white' : 'hover:bg-[var(--secondary-color)] hover:text-white' }} p-2 rounded hover:bg-[var(--secondary-color)] hover:text-white">
                    <i class="fas fa-file-invoice-dollar mr-3 w-5 text-center"></i> Manage Payment
                </a>
                <a href="#"
                    class="flex items-center p-2  rounded hover:bg-[var(--secondary-color)] hover:text-white">
                    <i class="fas fa-chart-line mr-3 w-5 text-center"></i> Reports
                </a>
                <a wire:navigate href="{{ route('franchise.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center p-2 text-red-600 hover:border border-red-600 rounded  cursor-pointer">
                    <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i> Logout
                </a>



            </nav>
             <div class="p-4 border-t border-b flex items-center space-x-3">
            <img src="https://cdn-icons-png.flaticon.com/512/700/700674.png" alt="User"
                 class="w-10 h-10 rounded-full border">
            <div>
                <p class="text-[var(--text-color)] font-medium">Franchise Profile</p>
                <a wire:navigate href="{{route('franchise.profile')}}" class="text-sm text-[var(--secondary-color)] hover:underline">View Profile</a>
            </div>
        </div>
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
                            <a href="{{route('franchise.profile')}}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
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
            <main class="">
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
                toggleDropdown(dropdown) {
                    this.openDropdowns[dropdown] = !this.openDropdowns[dropdown];

                    // Close other dropdowns
                    Object.keys(this.openDropdowns).forEach(key => {
                        if (key !== dropdown) {
                            this.openDropdowns[key] = false;
                        }
                    });
                }
            }
        }
    </script>
</body>

</html>
