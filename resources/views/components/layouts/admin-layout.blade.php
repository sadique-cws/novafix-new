<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novafix | Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                        secondary: '#3B82F6',
                        accent: '#10B981',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --color-primary: #4f46e5;
            --color-secondary: #6366f1;
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-danger: #ef4444;
        }

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
    @livewireStyles
</head>

<body class="bg-gray-50" x-data="dashboard()">
    <!-- Mobile backdrop -->
    <div x-show="isMobileSidebarOpen" @click="isMobileSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 backdrop-transition lg:hidden"
        :class="isMobileSidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'">
    </div>

    <div class="flex gap-1">
        <!-- Sidebar -->
        <div class="fixed top-0 left-0 h-screen w-64 bg-gray-900 border-r border-gray-800 z-50 transform transition-transform duration-300 flex flex-col"
            :class="isMobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            <div class="pt-4 pb-4 px-4 border-b border-gray-800 flex items-center justify-start gap-3">
                <div class="py-1 px-2 rounded-lg bg-[#1E40AF] text-xl font-medium text-[#F9FAFB]">NF</div>
                <h2 class="text-lg font-medium md:text-xl text-white">Super Admin</h2>
                <button @click="isMobileSidebarOpen = false" class="lg:hidden ml-10 text-gray-500 hover:text-gray-300">
                    <i class="fas text-lg fa-times"></i>
                </button>
            </div>

            <nav class="p-4 overflow-y-auto flex-1">
                <ul>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.dashboard') }}"
                            class="flex items-center font-medium p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white transition-colors' }}">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Franchise Management -->
                    <li class="mb-1 relative">
                        <a href="#" @click="toggleDropdown('franchise')"
                            class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.manage-franchises', 'admin.add-franchise', 'admin.franchise.performance') ? 'bg-gray-800 text-white' : 'text-gray-300' }}">
                            <div class="flex font-medium items-center">
                                <i class="fas fa-store mr-3 w-5 text-center"></i>
                                <span>Franchises</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs ml-2 transition-transform"
                                :class="openDropdowns.franchise ? 'rotate-180' : ''"></i>
                        </a>
                        <ul x-show="openDropdowns.franchise" x-transition
                            class="pl-2 mt-1 ml-6 border-l-2 border-gray-700 space-y-1">
                            <li>
                                <a wire:navigate href="{{ route('admin.manage-franchises') }}"
                                    class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded font-medium {{ request()->routeIs('admin.manage-franchises') ? 'bg-gray-800 text-white' : '' }}">All
                                    Franchises</a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('admin.add-franchise') }}"
                                    class="block font-medium px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded {{ request()->routeIs('admin.add-franchise') ? 'bg-gray-800 text-white' : '' }}">Add
                                    New</a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('admin.franchise.performance') }}"
                                    class="block font-medium px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded {{ request()->routeIs('admin.franchise.performance') ? 'bg-gray-800 text-white' : '' }}">Performance</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Staff Management -->
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.staff.management') }}"
                            class="flex font-medium items-center p-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.staff.management') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-users-cog mr-3 w-5 text-center"></i>
                            <span>Staff Management</span>
                        </a>
                    </li>

                    <!-- Receptionists -->
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('admin.receptionst.management') }}"
                            class="flex font-medium items-center p-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.receptionst.management') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                            <span>Receptionists</span>
                        </a>
                    </li>

                    <!-- Solution (Conditional: Link for md/lg, Dropdown for sm) -->
                    <li class="mb-1">
                        <div x-show="!isMobile" class="md:block hidden">
                            <a wire:navigate href="{{ route('admin.solution') }}"
                                class="flex font-medium items-center p-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.solution') ? 'bg-gray-800 text-white' : '' }}">
                                <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                                <span>Solution</span>
                            </a>
                        </div>
                        <div x-show="isMobile" class="sm:block md:hidden">
                            <a href="#" @click="toggleDropdown('solution')"
                                class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.solution*') ? 'bg-gray-800 text-white' : 'text-gray-300' }}">
                                <div class="flex font-medium items-center">
                                    <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                                    <span>Solution</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs ml-2 transition-transform"
                                    :class="openDropdowns.solution ? 'rotate-180' : ''"></i>
                            </a>
                            <ul x-show="openDropdowns.solution" x-transition
                                class="pl-2 mt-1 ml-6 border-l-2 border-gray-700 space-y-1">
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded font-medium {{ request()->routeIs('admin.solution') ? 'bg-gray-800 text-white' : '' }}">Admin
                                        Diagnosis</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.manage-devices') }}"
                                        class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded font-medium {{ request()->routeIs('admin.solution.manage-devices') ? 'bg-gray-800 text-white' : '' }}">Devices</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.manage-brands') }}"
                                        class="block font-medium px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded {{ request()->routeIs('admin.solution.manage-brands') ? 'bg-gray-800 text-white' : '' }}">Brands</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.manage-models') }}"
                                        class="block font-medium px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded {{ request()->routeIs('admin.solution.manage-models') ? 'bg-gray-800 text-white' : '' }}">Models</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.manage-problems') }}"
                                        class="block font-medium px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded {{ request()->routeIs('admin.solution.manage-problems') ? 'bg-gray-800 text-white' : '' }}">Problems</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.staff-answers') }}"
                                        class="block font-medium px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded {{ request()->routeIs('admin.solution.staff-answers') ? 'bg-gray-800 text-white' : '' }}">Staff
                                        Answers</a>
                                </li>
                                <li>
                                    <a wire:navigate href="{{ route('admin.solution.tree-explorer') }}"
                                        class="block font-medium px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors rounded {{ request()->routeIs('admin.solution.tree-explorer') ? 'bg-gray-800 text-white' : '' }}">Tree
                                        Explorer</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Customers -->
                    <li class="mb-1">
                        <a href="{{ route('admin.user-enquiries') }}" wire:navigate
                            class="font-medium flex items-center p-3 text-gray-300 rounded-lg {{ request()->routeIs('admin.user-enquiries') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-users mr-3 w-5 text-center"></i>
                            <span>User Enquiry</span>
                        </a>
                    </li>

                    <!-- staff enquiry -->
                    <li class="mb-1">
                        <a href="{{ route('admin.staff-enquiries') }}" wire:navigate
                            class="font-medium flex gap-3 items-center p-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.staff-enquiries') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fa-solid fa-user-secret"></i>
                            <span>Staff Enquiries</span>
                        </a>
                    </li>

                    <!-- Settings -->
                    <li class="mb-1">
                        <a href="{{ route('admin.setting') }}" wire:navigate
                            class="font-medium flex items-center p-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors {{ request()->routeIs('admin.setting') ? 'bg-gray-800 text-white' : '' }}">
                            <i class="fas fa-cog mr-3 w-5 text-center"></i>
                            <span>Settings</span>
                        </a>
                    </li>

                </ul>

            </nav>
            <div class="p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center p-3 gap-3 bg-red-600/10 text-red-500 rounded-lg hover:bg-red-600 hover:text-white transition-colors font-medium text-left">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- Main content -->
        <div class="min-h-screen w-full md:w-[calc(100%-16rem)] md:ml-64">
            <div
                class="sticky top-0 z-40 flex items-center justify-between px-6 py-4 bg-gray-900 shadow-md border-b border-gray-800">
                <!-- Mobile Menu Button (Hidden on Desktop) -->
                <button @click="isMobileSidebarOpen = true"
                    class="lg:hidden text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Spacer for desktop (keeps dropdown aligned to right) -->
                <div class="hidden lg:block">
                    <h1 class="text-white font-medium text-lg capitalize">
                        {{ str_replace(['admin.', '.'], ['', ' '], request()->route()->getName() ?? 'Dashboard') }}
                    </h1>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Notifications (Optional extra element for better look) -->
                    <button class="text-gray-400 hover:text-white transition-colors relative">
                        <i class="far fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-3 w-3">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                        </span>
                    </button>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                            <span class="hidden md:block text-sm font-medium text-gray-300">Admin User</span>
                            <img src="https://www.pngmart.com/files/21/Admin-Profile-Vector-PNG-Clipart.png"
                                alt="User profile" class="rounded-full w-9 h-9 object-cover border-2 border-gray-700">
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform"
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-3 w-48 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-200">
                            <a href="{{ route('admin.setting') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-primary transition-colors">
                                <i class="fas fa-cog mr-3 text-gray-400"></i> Settings
                            </a>
                            <div class="my-1 border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
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
            window.dashboard = function () {
                const path = window.location.pathname;
                const isFranchise = path.includes('/admin/manage-franchises') || path.includes('/admin/add-franchise') || path.includes('/admin/Franchise-performance');
                const isSolution = path.includes('/admin/solution');
                
                return {
                    isMobileSidebarOpen: false,
                    openDropdowns: {
                        franchise: isFranchise,
                        solution: isSolution,
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
                        
                        document.addEventListener('livewire:navigated', () => {
                            const currentPath = window.location.pathname;
                            if (currentPath.includes('/admin/manage-franchises') || currentPath.includes('/admin/add-franchise') || currentPath.includes('/admin/Franchise-performance')) {
                                this.openDropdowns.franchise = true;
                            } else {
                                this.openDropdowns.franchise = false;
                            }
                            
                            if (currentPath.includes('/admin/solution')) {
                                this.openDropdowns.solution = true;
                            } else {
                                this.openDropdowns.solution = false;
                            }
                        });
                    }
                }
            }
        });
    </script>
    @livewireScripts
</body>

</html>