<!DOCTYPE html>
<html lang="en" class="font-poppins">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NovaFix - Service Center Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            border-left: 3px solid #3B82F6;
            color: #3B82F6;
            font-weight: 500;
        }

        .sidebar-link:hover:not(.active) {
            background-color: rgba(243, 244, 246, 0.5);
            transform: translateX(5px);
            transition: all 0.2s ease;
        }

        #sidebar {
            transition: transform 0.3s ease-in-out;
        }

        /* Ensure smooth transitions for buttons */
        button,
        a {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-poppins antialiased" x-data="{ sidebarOpen: false, profileOpen: false }">
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden" x-cloak></div>

    <div class="flex pt-0">
        <!-- Fixed Sidebar -->
        <aside id="sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 bottom-0 bg-white w-64 shadow-sm py-4 border-r border-gray-100 md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto z-40">
            <div class="px-4 py-4 flex items-center justify-between border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-pink-500 flex items-center justify-center">
                        <span class="text-white font-semibold text-lg">NF</span>
                    </div>
                    <h1 class="font-semibold text-dark-800"><span class="text-blue-600">NovaFix</span> Desk</h1>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-blue-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <nav class="px-3 mt-4">
                <ul class="space-y-1">
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.dashboard') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150 {{ request()->routeIs('frontdesk.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-500"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.servicerequest.create') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150 {{ request()->routeIs('frontdesk.servicerequest.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle mr-3 text-gray-500"></i>
                            <span>New Service Request</span>
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.servicerequest.manage') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150 {{ request()->routeIs('frontdesk.servicerequest.manage') ? 'active' : '' }}">
                            <i class="fas fa-tasks mr-3 text-gray-500"></i>
                            <span>Service Queue</span>
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.servicerequest.completed') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150 {{ request()->routeIs('frontdesk.servicerequest.completed') ? 'active' : '' }}">
                            <i class="fas fa-check-circle mr-3 text-gray-500"></i>
                            <span>Completed Services</span>
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.manage.payments') }}"
                            class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150 {{ request()->routeIs('frontdesk.manage.payments') ? 'active' : '' }}">
                            <i class="fas fa-boxes mr-3 text-gray-500"></i>
                            <span>Manage Payment</span>
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('frontdesk.profile') }}" class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150">
                            <i class="fas fa-user-circle mr-2 text-gray-500"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('frontdesk.logout') }}" class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150">
                            <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i> Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 transition-all duration-300 min-h-screen">
            <div class="md:hidden fixed top-4 left-4 z-50">
                <button @click="sidebarOpen = true" class="p-2 rounded-md text-gray-500 hover:text-blue-600 focus:outline-none bg-white shadow-sm">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <!-- Page Content -->
            <div class="p-4 md:p-6">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>