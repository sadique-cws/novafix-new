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
            <div class="pt-4 pb-2 px-4 border-b border-gray-200 flex items-center justify-start gap-2">
                <div class="py-1 px-2 rounded-lg bg-[#1E40AF] text-xl font-medium text-[#F9FAFB]">NF</div>
                <h2 class="text-lg font-medium md:text-xl text-[#111827]">Super Admin</h2>
                <button @click="isMobileSidebarOpen = false" class="lg:hidden ml-10 text-gray-500 hover:text-gray-700">
                    <i class="fas text-lg fa-times"></i>
                </button>
            </div>

            <nav class="p-4 overflow-y-auto" style="max-height: calc(100vh - 64px)" x-data="dashboard()">
                <ul>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.dashboard') }}"
                            class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-100' }}">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Franchise Management -->
                    <li class="mb-1 relative">
                        <a href="#" @click="toggleDropdown('franchise')"
                            class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <div class="flex font-medium items-center">
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
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors font-medium {{ request()->routeIs('admin.manage-franchises') ? 'bg-blue-50 text-blue-600' : '' }}">All
                                    Franchises</a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('admin.add-franchise') }}"
                                    class="block font-medium px-4 py-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin.add-franchise') ? 'bg-blue-50 text-blue-600' : '' }}">Add
                                    New</a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('admin.franchise.performance') }}"
                                    class="block font-medium px-4 py-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin.franchise.performance') ? 'bg-blue-50 text-blue-600' : '' }}">Performance</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Staff Management -->
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.staff.management') }}"
                            class="flex font-medium items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 {{ request()->routeIs('admin.staff.management') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-users-cog mr-3 w-5 text-center"></i>
                            <span>Staff Management</span>
                        </a>
                    </li>

                    <!-- Receptionists -->
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.receptionst.management') }}"
                            class="flex font-medium items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 {{ request()->routeIs('admin.receptionst.management') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                            <span>Receptionists</span>
                        </a>
                    </li>

                    <!-- Solution (Conditional: Link for md/lg, Dropdown for sm) -->
                    <li class="mb-1">
                        <div x-show="!isMobile" class="md:block hidden">
                            <a wire:navigate href="{{ route('admin.solution') }}"
                                class="flex font-medium items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 {{ request()->routeIs('admin.solution') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                                <span>Solution</span>
                            </a>
                        </div>
                        <div x-show="isMobile" class="sm:block md:hidden">
                            <a href="#" @click="toggleDropdown('solution')"
                                class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                                <div class="flex font-medium items-center">
                                    <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                                    <span>Solution</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs ml-2 transition-transform"
                                    :class="openDropdowns.solution ? 'rotate-180' : ''"></i>
                            </a>
                            <ul x-show="openDropdowns.solution" x-transition
                                class="pl-2 mt-1 ml-6 border-l-2 border-blue-100 space-y-1">
                                 <li>
                                    <a wire:navigate href="{{ route('admin.solution') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors font-medium {{ request()->routeIs('admin.solution') ? 'bg-blue-50 text-blue-600' : '' }}">Admin Diagnosis</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.manage-devices') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors font-medium {{ request()->routeIs('admin.solution.manage-devices') ? 'bg-blue-50 text-blue-600' : '' }}">Devices</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.manage-brands') }}"
                                        class="block font-medium px-4 py-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin.solution.manage-brands') ? 'bg-blue-50 text-blue-600' : '' }}">Brands</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.manage-models') }}"
                                        class="block font-medium px-4 py-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin.solution.manage-models') ? 'bg-blue-50 text-blue-600' : '' }}">Models</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.manage-problems') }}"
                                        class="block font-medium px-4 py-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin.solution.manage-problems') ? 'bg-blue-50 text-blue-600' : '' }}">Problems</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.staff-answers') }}"
                                        class="block font-medium px-4 py-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin.solution.staff-answers') ? 'bg-blue-50 text-blue-600' : '' }}">Staff
                                        Answers</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Customers -->
                    <li class="mb-1">
                        <a href="{{ route('admin.user-enquiries') }}" wire:navigate
                            class="font-medium flex items-center p-3 text-gray-700 rounded-lg {{ request()->routeIs('admin.user-enquiries') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-users mr-3 w-5 text-center"></i>
                            <span>User Enquiry</span>
                        </a>
                    </li>

                    <!-- staff enquiry -->
                    <li class="mb-1">
                        <a href="{{ route('admin.staff-enquiries') }}" wire:navigate
                            class="font-medium flex gap-3 items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 {{ request()->routeIs('admin.staff-enquiries') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fa-solid fa-user-secret"></i>
                            <span>Staff Enquiries</span>
                        </a>
                    </li>

                    <!-- Settings -->
                    <li class="mb-1">
                        <a href="{{ route('admin.setting') }}" wire:navigate
                            class="font-medium flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 {{ request()->routeIs('admin.setting') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-cog mr-3 w-5 text-center"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <!-- Logout -->
                    <li class="mb-1">
                        <a href="{{ route('admin.logout') }}"
                            class="flex items-center p-3 gap-2 bg-red-600 rounded-lg hover:bg-red-700 text-white font-medium">
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
                            <a href="{{ route('admin.setting') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                            <div class="border-t border-gray-100"></div>
                            <a href="{{ route('admin.logout') }}"
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