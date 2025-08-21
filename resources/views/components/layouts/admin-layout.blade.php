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

            <nav class="p-4 overflow-y-auto" style="max-height: calc(100vh - 64px)">
                <ul>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.dashboard') }}"
                            class="flex items-center p-3 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Franchise Management -->
                    <li class="mb-1 relative">
                        <a href="#" @click="toggleDropdown('franchise')"
                            class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <div class="flex items-center">
                                <i class="fas fa-store mr-3 w-5 text-center"></i>
                                <span>Franchises</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs ml-2 transition-transform"
                                :class="openDropdowns.franchise ? 'rotate-180' : ''"></i>
                        </a>
                        <ul x-show="openDropdowns.franchise" x-transition
                            class="pl-2 mt-1 ml-6 border-l-2 border-blue-100 space-y-1">
                            <li>
                                <a wire:navigate href="{{ route('admin.manage-franchises') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">All
                                    Franchises</a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('admin.add-franchise') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded">Add New</a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('admin.franchise.performance') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded">Performance</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Staff Management -->
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.staff.management') }}"
                            class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-users-cog mr-3 w-5 text-center"></i>
                            <span>Staff Management</span>
                        </a>
                    </li>

                    <!-- Receptionists -->
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.receptionst.management') }}"
                            class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                            <span>Receptionists</span>
                        </a>
                    </li>

                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.solution') }}"
                            class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                            <span>Solution</span>
                        </a>
                    </li>

                    <!-- Customers -->
                    <li class="mb-1">
                        <a href="#" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-users mr-3 w-5 text-center"></i>
                            <span>Customers</span>
                        </a>
                    </li>

                    <li class="mb-1">
                        <a href="#" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-cog mr-3 w-5 text-center"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.logout') }}"
                            class="flex items-center p-3 gap-2 bg-red-500 rounded-lg hover:bg-red-600 text-white font-medium">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Logout</span>
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