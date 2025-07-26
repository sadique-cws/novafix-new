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
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        },
                        accent: {
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 14px -2px rgba(0, 0, 0, 0.08)',
                        'soft-lg': '0 8px 20px -4px rgba(0, 0, 0, 0.1)',
                        'card': '0 2px 8px rgba(0, 0, 0, 0.1)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        pulse: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.7' },
                        },
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(241, 245, 249, 0.3);
            border-radius: 12px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.6);
            border-radius: 12px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(2, 132, 199, 0.8);
        }

        /* Glassmorphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Card hover effect */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.15);
        }

        /* Active menu item */
        .active-menu-item {
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-weight: 600;
            border-radius: 8px;
        }

        .active-menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 8px;
            bottom: 8px;
            width: 4px;
            background: linear-gradient(180deg, #0ea5e9, #7dd3fc);
            border-radius: 0 4px 4px 0;
        }

        /* Gradient background */
        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 50%, #bae6fd 100%);
        }

        /* Sidebar transition */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Dropdown transition */
        .dropdown-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Shine effect */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -100%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: all 0.8s;
        }

        .shine-effect:hover::after {
            left: 100%;
        }

        /* Custom focus styles */
        .custom-focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div x-data="{ sidebarOpen: window.innerWidth > 1024, mobileSidebarOpen: false }" @resize.window="sidebarOpen = window.innerWidth > 1024"
         class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop (mobile) -->
        <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black bg-opacity-60 lg:hidden"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <aside x-show="sidebarOpen || mobileSidebarOpen" @click.away="mobileSidebarOpen = false"
               class="fixed inset-y-0 left-0 z-50 w-72 sidebar-transition transform lg:translate-x-0"
               :class="{ '-translate-x-full': !mobileSidebarOpen && window.innerWidth < 1024 }"
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full">
            <div class="flex flex-col h-full bg-gradient-to-b from-primary-900 to-primary-800 glass-effect shadow-2xl">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-primary-700/50">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-lg bg-white/90 flex items-center justify-center shine-effect">
                            <span class="text-2xl font-extrabold text-primary-600">NF</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white tracking-tight">FranchisePro</h2>
                            <p class="text-xs text-primary-200/80">Admin Dashboard</p>
                        </div>
                    </div>
                    <button @click="mobileSidebarOpen = false" class="lg:hidden text-primary-300 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Sidebar Content -->
                <div class="flex-1 overflow-y-auto py-6 px-4">
                    <!-- User Profile -->
                    <div class="flex items-center px-4 py-4 mb-6 rounded-xl bg-primary-700/30 glass-effect shine-effect animate-slide-up">
                        <img class="w-12 h-12 rounded-full border-2 border-primary-400/50" 
                             src="https://t3.ftcdn.net/jpg/07/24/59/76/360_F_724597608_pmo5BsVumFcFyHJKlASG2Y2KpkkfiYUU.jpg" 
                             alt="User Avatar">
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-primary-200/80">Super Admin</p>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <ul class="space-y-2">
                        <li>
                            <a href="/dashboard" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>

                        <li x-data="{ open: false }">
                            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Franchise Management
                                </div>
                                <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            <ul x-show="open" x-collapse class="pl-6 mt-2 space-y-2 dropdown-transition">
                                <li>
                                    <a href="/franchises" class="flex items-center px-4 py-2 text-sm rounded-lg text-primary-200 hover:bg-primary-700/50 hover:text-white transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Manage Franchises
                                    </a>
                                </li>
                                <li>
                                    <a href="/franchises/add" class="flex items-center px-4 py-2 text-sm rounded-lg text-primary-200 hover:bg-primary-700/50 hover:text-white transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add New Franchise
                                    </a>
                                </li>
                                <li>
                                    <a href="/franchises/types" class="flex items-center px-4 py-2 text-sm rounded-lg text-primary-200 hover:bg-primary-700/50 hover:text-white transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        Franchise Types
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="/staff" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Manage Staff
                            </a>
                        </li>

                        <li>
                            <a href="/receptionists" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                                Manage Receptionists
                            </a>
                        </li>

                        <li>
                            <a href="/user-requests" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                User Requests
                                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-accent-500 rounded-full animate-pulse-slow">3</span>
                            </a>
                        </li>

                        <li>
                            <a href="/payments" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Manage Payments
                            </a>
                        </li>

                        <li>
                            <a href="/growth" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                Growth Analytics
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Sidebar Footer -->
                <div class="px-4 py-4 border-t border-primary-700/50">
                    <a href="/settings" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                    <a href="/logout" class="flex items-center px-3 py-2 mt-2 text-sm font-medium rounded-lg text-primary-100 hover:bg-primary-700/50 ">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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
                <div class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
                    <!-- Mobile menu button -->
                    <button @click="mobileSidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Search and controls -->
                    <div class="flex-1 flex justify-between items-center lg:justify-end space-x-4">
                        <div class="relative max-w-xs w-full lg:w-80">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-all custom-focus" placeholder="Search..." type="search">
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="p-1.5 rounded-full text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 relative transition-colors custom-focus">
                                    <span class="sr-only">View notifications</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="absolute top-0 right-0 h-2.5 w-2.5 rounded-full bg-accent-500 border-2 border-white animate-pulse-slow"></span>
                                </button>

                                <div x-show="open" @click.away="open = false" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="origin-top-right absolute right-0 mt-3 w-96 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-20 glass-effect">
                                    <div class="px-4 py-3">
                                        <p class="text-sm font-semibold text-gray-900">Notifications</p>
                                    </div>
                                    <div class="py-2">
                                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900">New franchise application</p>
                                                    <p class="text-xs text-gray-500">5 min ago</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                        <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900">Payment received</p>
                                                    <p class="text-xs text-gray-500">2 hours ago</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="py-2">
                                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 text-center font-medium rounded-lg">
                                            View all notifications
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- User dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none rounded-lg p-1 hover:bg-gray-100 transition-colors custom-focus">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-9 w-9 rounded-full border-2 border-primary-200/50" src="https://t3.ftcdn.net/jpg/07/24/59/76/360_F_724597608_pmo5BsVumFcFyHJKlASG2Y2KpkkfiYUU.jpg" alt="User Avatar">
                                    <span class="hidden lg:inline-flex text-sm font-semibold text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                                    <svg class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="origin-top-right absolute right-0 mt-3 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-20 glass-effect">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Your Profile</a>
                                        <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Settings</a>
                                        <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Sign out</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto focus:outline-none gradient-bg">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="space-y-8 animate-slide-up">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
    <script>
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

            // Smooth scroll for main content
            document.querySelector('main').style.scrollBehavior = 'smooth';
        });
    </script>
</body>
</html>