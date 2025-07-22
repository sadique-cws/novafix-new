<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @livewireStyles
    <style>
        :root {
            --sidebar-width: 280px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(241, 245, 249, 0.5);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.5);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(2, 132, 199, 0.7);
        }

        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Active menu item indicator */
        .active-menu-item {
            position: relative;
            background-color: rgba(14, 165, 233, 0.1);
            color: rgb(2, 132, 199);
        }

        .active-menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: rgb(2, 132, 199);
            border-radius: 0 4px 4px 0;
        }

        /* Pulse animation for notifications */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <!-- Main Layout -->
    <div x-data="{ sidebarOpen: window.innerWidth > 1024, mobileSidebarOpen: false }" @resize.window="sidebarOpen = window.innerWidth > 1024"
        class="flex h-screen overflow-hidden">

        <!-- Sidebar Backdrop (mobile) -->
        <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false"
            class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <aside x-show="sidebarOpen || mobileSidebarOpen" @keydown.escape="mobileSidebarOpen = false"
            class="fixed inset-y-0 left-0 z-30 w-72 bg-white shadow-xl transform transition-all duration-300 ease-in-out"
            :class="{ '-translate-x-full': !sidebarOpen && !mobileSidebarOpen }"
            x-transition:enter="transform transition-transform ease-in-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition-transform ease-in-out duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

            <div class="flex flex-col h-full pb-4">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-primary-600 to-secondary-500 shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-800">NovaFix</span>
                    </div>
                    <button @click="mobileSidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar Content -->
                <div class="flex-1 overflow-y-auto overflow-x-hidden pt-4 px-4">
                    <!-- User Profile -->


                    <!-- Navigation -->
                    <nav class="space-y-1">
                        <!-- Dashboard -->
                        <a wire:navigate href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group"
                            :class="route().current('admin.dashboard') ? 'active-menu-item' :
                                'text-gray-600 hover:bg-gray-100 hover:text-gray-900'">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0"
                                :class="route().current('admin.dashboard') ? 'text-primary-600' :
                                    'text-gray-500 group-hover:text-primary-600'"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Franchises Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="sidebar-item w-full flex items-center text-gray-600 justify-between py-4 px-5 rounded-xl hover:bg-indigo-50 hover:text-indigo-700 bg-opacity-50 transition-all duration-200  shadow-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-building text-xl mr-4 text-indigo-500"></i>
                                    <span>Franchises</span>
                                </div>
                                <i class="fas fa-chevron-down text-base transform transition-transform"
                                    :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95" class="ml-10 mt-2 space-y-2">
                                <a wire:navigate href="{{ route('admin.add-franchise') }}"
                                    class="block py-2 px-4 rounded-lg hover:bg-indigo-100 text-gray-600 hover:text-indigo-700 transition-colors duration-200 font-medium">
                                    Add Franchise
                                </a>
                                <a wire:navigate href="{{ route('admin.manage-franchises') }}"
                                    class="block py-2 px-4 rounded-lg hover:bg-indigo-100 text-gray-600 hover:text-indigo-700 transition-colors duration-200 font-medium">
                                    Manage Franchises
                                </a>
                            </div>
                        </div>
                        <!-- Staff Management -->
                        <a wire:navigate href="#"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-500 group-hover:text-primary-600"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Manage Staff
                            <span
                                class="ml-auto inline-block py-0.5 px-2 text-xs rounded-full bg-primary-100 text-primary-800">3
                                New</span>
                        </a>

                        <!-- Receptionist Management -->
                        <a wire:navigate href="#"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-500 group-hover:text-primary-600"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Manage Receptionist
                        </a>

                        <!-- User Requests -->
                        <a wire:navigate href="#"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-500 group-hover:text-primary-600"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            User Requests
                            <span
                                class="ml-auto inline-flex items-center justify-center h-5 w-5 rounded-full bg-red-100 text-red-800 text-xs font-medium animate-pulse">5</span>
                        </a>

                        <!-- Manage Payments -->
                        <a wire:navigate href="#"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-500 group-hover:text-primary-600"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Manage Payments
                        </a>

                        <!-- Manage Growth -->
                        <a wire:navigate href="#"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-500 group-hover:text-primary-600"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Manage Growth
                        </a>
                    </nav>
                </div>

                <!-- Sidebar Footer -->
                <div class="px-4 pt-4 border-t border-gray-100">
                    <a href="#" wire:click="logout"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 group text-gray-600 hover:bg-red-50 hover:text-red-600">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0 text-red-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden" :class="{ 'lg:ml-72': sidebarOpen }">

            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile menu button -->
                    <button @click="mobileSidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Search and controls -->
                    <div class="flex-1 flex justify-between items-center lg:justify-end space-x-4">
                        <div class="relative max-w-xs w-full lg:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                placeholder="Search..." type="search">
                        </div>

                        <div class="flex items-center space-x-4">
                            <button
                                class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                            </button>

                            <!-- User dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://t3.ftcdn.net/jpg/07/24/59/76/360_F_724597608_pmo5BsVumFcFyHJKlASG2Y2KpkkfiYUU.jpg"
                                        alt="User Avatar">
                                    <span
                                        class="hidden lg:inline-flex text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                                    <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-20">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your
                                        Profile</a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                    <a href="#" wire:click="logout"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto focus:outline-none bg-gray-50">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    <!-- Page header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            @yield('title', 'Dashboard')
                        </h1>
                        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                        clip-rule="evenodd" />
                                </svg>
                                Last updated {{ now()->format('M d, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="space-y-6">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
    <script>
        // Auto-close mobile sidebar when clicking a link
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarLinks = document.querySelectorAll('aside a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        Alpine.store('mobileSidebarOpen', false);
                    }
                });
            });

            // Highlight active menu items
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('aside a[href]');

            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active-menu-item');
                }
            });
        });
    </script>
</body>

</html>
