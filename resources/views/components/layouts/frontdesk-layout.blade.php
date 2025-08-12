<!DOCTYPE html>
<html lang="en" class="font-poppins">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NovaFix - Service Center Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .notification-dot {
            box-shadow: 0 0 0 2px white;
        }

        #sidebar {
            transition: transform 0.3s ease-in-out;
        }

        /* Ensure smooth transitions for buttons */
        button,
        a {
            transition: all 0.2s ease-in-out;
        }

        /* Optimize title for mobile */
        .title-text {
            font-size: 1.25rem;
            /* 20px */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (min-width: 640px) {
            .title-text {
                font-size: 1.5rem;
                /* 24px */
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-poppins antialiased">
    <!-- Fixed Navbar -->
    <header class="fixed top-0 left-0 right-0 py-1 bg-white shadow-sm z-50 border-b border-gray-100">
        <div class="px-4 sm:px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3 sm:gap-4">
                <button id="mobile-menu-button" aria-label="Toggle Menu"
                    class="md:hidden text-gray-500 hover:text-blue-600 focus:outline-none transform hover:scale-110">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center gap-2 sm:gap-3">
                    <div
                        class="h-9 w-9 sm:h-10 sm:w-10 rounded-lg bg-gradient-to-br from-blue-500 to-pink-500 flex items-center justify-center">
                        <span class="text-white font-semibold text-base sm:text-lg">NF</span>
                    </div>
                    <h1 class="title-text font-semibold text-dark-800"><span class="text-blue-600">Receptioners</span>
                    </h1>
                </div>
            </div>

            <div class="flex items-center space-x-3 sm:space-x-5">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="relative p-1 text-gray-500 hover:text-blue-600 focus:outline-none transform hover:scale-110">
                        <i class="fas fa-bell text-lg sm:text-xl"></i>
                        <span
                            class="absolute top-0 right-0 h-2.5 w-2.5 sm:h-3 sm:w-3 bg-red-500 rounded-full notification-dot"></span>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50 transform origin-top-right transition-all duration-200 ease-in-out">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <h3 class="font-medium text-gray-800 text-sm sm:text-base">Notifications (3)</h3>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition">
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                                        <i class="fas fa-tools text-sm sm:text-base"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">New service request</p>
                                        <p class="text-xs text-gray-500 mt-1">Customer: John Doe - iPhone 13</p>
                                        <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="px-4 py-2 text-center border-t border-gray-100">
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">View all
                                notifications</a>
                        </div>
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-1 sm:gap-2 focus:outline-none transform hover:scale-105">
                        <img src="https://cdn-icons-png.flaticon.com/512/3374/3374559.png" alt="User Profile"
                            class="h-8 w-8 sm:h-9 sm:w-9 rounded-full border border-black shadow-sm">
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::guard('frontdesk')->user()->name }}
                            </p>
                            <p class="text-xs text-gray-500">Front Desk</p>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-md py-1 z-50 border border-gray-100 transform origin-top-right transition-all duration-200 ease-in-out">
                        <a wire:navigate href="{{ route('frontdesk.profile') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition flex items-center">
                            <i class="fas fa-user-circle mr-2 text-gray-500"></i> Profile
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition flex items-center">
                            <i class="fas fa-cog mr-2 text-gray-500"></i> Settings
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('frontdesk.logout') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition flex items-center">
                            <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex pt-14 sm:pt-20">
        <!-- Fixed Sidebar -->
        <aside id="sidebar"
            class="fixed top-16 sm:top-20 left-0 bottom-0 bg-white w-60 sm:w-64 shadow-sm py-4 border-r border-gray-100 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto z-40">
            <nav class="px-3">
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
                </ul>

                <div class="mt-8 px-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Support</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="#"
                                class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150">
                                <i class="fas fa-question-circle mr-3 text-gray-500"></i>
                                <span>Help Center</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition duration-150">
                                <i class="fas fa-cog mr-3 text-gray-500"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 transition-all duration-300 ">
            <!-- Page Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>
<script>
    document.addEventListener('livewire:init', () => {  
        // Initialize sidebar functionality
        function initSidebar() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');

            if (!mobileMenuButton || !sidebar || !mobileOverlay) {
                console.error('Mobile menu elements not found');
                return;
            }

            function toggleSidebar(e) {
                if (e) e.stopPropagation();
                sidebar.classList.toggle('-translate-x-full');
                mobileOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
                mobileMenuButton.setAttribute('aria-expanded', sidebar.classList.contains('-translate-x-full') ? 'false' : 'true');
            }

            // Clone and replace elements to prevent duplicate event listeners
            const newButton = mobileMenuButton.cloneNode(true);
            mobileMenuButton.replaceWith(newButton);

            // Add event listeners to the new button
            newButton.addEventListener('click', toggleSidebar);
            mobileOverlay.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking nav links on mobile
            document.querySelectorAll('#sidebar nav a').forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        toggleSidebar();
                    }
                });
            });

            // Handle responsive behavior
            function handleResize() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    newButton.setAttribute('aria-expanded', 'true');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                    newButton.setAttribute('aria-expanded', 'false');
                }
            }

            // Initialize and set up resize listener
            handleResize();
            window.addEventListener('resize', handleResize);
        }

        // Run initialization
        initSidebar();

        // Reinitialize after Livewire navigation
        document.addEventListener('livewire:navigated', initSidebar);
        
        // Also reinitialize after DOM updates
        Livewire.hook('morph.updated', () => {
            initSidebar();
        });
    });
</script>
</body>

</html>
