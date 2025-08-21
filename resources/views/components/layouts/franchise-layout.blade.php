<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Franchise Dashboard - Franchise Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            overflow-x: hidden;
        }

        /* Sidebar styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 50;
            overflow-y: auto;
            background-color: white;
            border-right: 1px solid #e5e7eb;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        /* Main content area */
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        /* Desktop styles */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
                width: 280px;
            }

            .main-content {
                margin-left: 280px;
            }
        }

        /* Mobile header */
        .mobile-header {
            position: sticky;
            top: 0;
            z-index: 40;
            background-color: white;
        }

        /* Cards */
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            border-left: 4px solid var(--primary-color);
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Dropdowns */
        .dropdown-chevron {
            transition: transform 0.2s;
        }

        .dropdown-chevron.rotate {
            transform: rotate(180deg);
        }

        /* Status badges */
        .status-badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-medium;
        }

        .status-active {
            @apply bg-green-100 text-green-800;
        }

        .status-inactive {
            @apply bg-red-100 text-red-800;
        }

        .status-pending {
            @apply bg-yellow-100 text-yellow-800;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Backdrop for mobile sidebar */
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* Mobile specific optimizations */
        @media (max-width: 767px) {
            .sidebar {
                width: 80%;
                max-width: 320px;
            }

            .main-content {
                width: 100%;
            }

            .mobile-search {
                display: block;
            }

            .desktop-search {
                display: none;
            }
        }

        @media (min-width: 768px) {
            .mobile-search {
                display: none;
            }

            .desktop-search {
                display: block;
            }
        }

        /* Better dropdown shadows */
        .dropdown-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Better input focus states */
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        /* Smooth transitions */
        .transition-slow {
            transition: all 0.4s ease;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Mobile sidebar toggle -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-pink-500 flex items-center justify-center">
                    <span class="text-white font-semibold text-lg">NF</span>
                </div>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Franchise Panel</h1>
            </div>
            <button id="sidebarClose" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>


        <nav class="p-4 sidebar-nav" style="max-height: calc(100vh - 64px);">
            <ul>
                <li class="mb-1">
                    <a wire:navigate href="{{ route('franchise.dashboard') }}"
                        class="flex items-center p-3 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Staff Section -->
               
                  
                 <li class="mb-1">
                    <a wire:navigate href="{{ route('franchise.manage.staff') }}"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                       <i class="fas fa-users-cog mr-3 w-5 text-center"></i>
                        <span>Manage Staff</span>
                    </a>
                </li>
                <li class="mb-1">
                    <a wire:navigate href="{{ route('franchise.manage.receptioners') }}"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                      <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                        <span>Manage Receptionists</span>
                    </a>
                </li>
                <!-- Receptionists Section -->
               

                <li class="mb-1">
                    <a wire:navigate href="{{ route('franchise.manage.service') }}"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fas fa-tags mr-3 w-5 text-center"></i>
                        <span>Types</span>
                    </a>
                </li>

                <li class="mb-1">
                    <a href="{{route('franchise.manage.customer')}}"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fas fa-users mr-3 w-5 text-center"></i>
                        <span>Customers</span>
                    </a>
                </li>

                <li class="mb-1">
                    <a href="{{ route('franchise.manage.payments') }}"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fas fa-file-invoice-dollar mr-3 w-5 text-center"></i>
                        <span>Manage Payment</span>
                    </a>
                </li>

                <li class="mb-1">
                    <a href="#"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fas fa-chart-line mr-3 w-5 text-center"></i>
                        <span>Reports</span>
                    </a>
                </li>

                <li class="mb-1">
                    <a href="#"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fas fa-cog mr-3 w-5 text-center"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main content -->
    <div class="main-content min-h-screen">
        <!-- Mobile header -->
        <div class="mobile-header md:hidden flex items-center justify-between px-4 py-3 bg-white shadow-sm">
            <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div class="relative mobile-search">
                <input type="text" placeholder="Search..."
                    class="pl-10 pr-4 py-1 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-48 transition-all duration-200 input-focus">
                <i class="fas fa-search absolute left-4 top-2 text-gray-400"></i>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none relative">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div class="relative">
                    <button onclick="toggleDropdown(event, 'navbar-profile-dropdown', 'profile-chevron')"
                        class="flex items-center space-x-2 focus:outline-none">
                        <img src="https://cdn-icons-png.flaticon.com/512/700/700674.png" alt="User profile"
                            class="rounded-full w-8 h-8 object-cover border-2 border-gray-200">
                        <i class="fas fa-chevron-down text-xs text-gray-500 dropdown-chevron" id="profile-chevron"></i>
                    </button>

                    <div id="navbar-profile-dropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-100 dropdown-shadow">
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">Profile</a>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">Settings</a>
                        <div class="border-t border-gray-100"></div>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-red-500 hover:text-red-600 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop header -->
        <header class="hidden md:block bg-white shadow-sm sticky top-0 z-20">
            <div class="flex items-center justify-between px-4 py-3 sm:px-6">
                <div class="flex-1 flex items-center justify-end space-x-4 sm:space-x-6">
                    <!-- Search bar -->
                    <div class="relative desktop-search">
                        <input type="text" placeholder="Search..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64 transition-all duration-200 input-focus">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <!-- Notification button -->
                    <div class="relative">
                        <button class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none relative">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>

                    <!-- User dropdown -->
                    <div class="relative">
                        <button onclick="toggleDropdown(event, 'navbar-profile-dropdown', 'profile-chevron')"
                            class="flex items-center space-x-2 focus:outline-none">
                            <img src="https://cdn-icons-png.flaticon.com/512/700/700674.png" alt="User profile"
                                class="rounded-full w-8 h-8 object-cover border-2 border-gray-200">
                            <span class="font-medium text-gray-700 whitespace-nowrap">Franchise Profile
                            </span>
                            <i class="fas fa-chevron-down text-xs text-gray-500 dropdown-chevron"
                                id="profile-chevron"></i>
                        </button>

                        <div id="navbar-profile-dropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-100 dropdown-shadow">
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">Profile</a>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">Settings</a>
                            <div class="border-t border-gray-100"></div>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-red-500 hover:text-red-600 transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content area -->
        <main class="p-4 sm:p-6">
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeSidebar();
            initializeDropdowns();
            setupEventListeners();
        });

        // Sidebar functionality
        function initializeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                sidebarBackdrop.classList.toggle('active');
                document.body.classList.toggle('overflow-hidden');

                // Update aria-expanded attribute
                if (sidebarToggle) {
                    const isExpanded = sidebar.classList.contains('active');
                    sidebarToggle.setAttribute('aria-expanded', isExpanded);
                }
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Close sidebar when clicking nav links on mobile
            document.querySelectorAll('#sidebar nav a').forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        toggleSidebar();
                    }
                });
            });

            // Handle window resize
            function handleResize() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.add('active');
                    sidebarBackdrop.classList.remove('active');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.remove('active');
                    sidebarBackdrop.classList.remove('active');
                }
            }

            handleResize();
            window.addEventListener('resize', handleResize);
        }

        // Dropdown functionality
        function initializeDropdowns() {
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                const dropdowns = document.querySelectorAll('[id$="-dropdown"]');
                dropdowns.forEach(dropdown => {
                    if (!dropdown.contains(event.target) &&
                        !event.target.closest(`[onclick*="${dropdown.id}"]`)) {
                        dropdown.classList.add('hidden');
                        const chevronId = dropdown.id.replace('-dropdown', '-chevron');
                        const chevron = document.getElementById(chevronId);
                        if (chevron) {
                            chevron.classList.remove('rotate');
                        }
                    }
                });
            });

            // Add touch event listeners for mobile
            document.addEventListener('touchstart', function(event) {
                const dropdowns = document.querySelectorAll('[id$="-dropdown"]');
                dropdowns.forEach(dropdown => {
                    if (!dropdown.contains(event.target) &&
                        !event.target.closest(`[onclick*="${dropdown.id}"]`)) {
                        dropdown.classList.add('hidden');
                        const chevronId = dropdown.id.replace('-dropdown', '-chevron');
                        const chevron = document.getElementById(chevronId);
                        if (chevron) {
                            chevron.classList.remove('rotate');
                        }
                    }
                });
            });
        }

        // Global toggleDropdown function
        function toggleDropdown(event, dropdownId, chevronId = null) {
            event.preventDefault();
            event.stopPropagation();

            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');

            if (chevronId) {
                const chevron = document.getElementById(chevronId);
                chevron.classList.toggle('rotate');
            }

            // Close other dropdowns on mobile
            if (window.innerWidth < 768) {
                document.querySelectorAll('[id$="-dropdown"]').forEach(dd => {
                    if (dd.id !== dropdownId && !dd.classList.contains('hidden')) {
                        dd.classList.add('hidden');
                        const otherChevronId = dd.id.replace('-dropdown', '-chevron');
                        const otherChevron = document.getElementById(otherChevronId);
                        if (otherChevron) {
                            otherChevron.classList.remove('rotate');
                        }
                    }
                });
            }
        }

        // Additional event listeners
        function setupEventListeners() {
            // Prevent default behavior for dropdown toggles
            document.querySelectorAll('[onclick^="toggleDropdown"]').forEach(button => {
                button.addEventListener('touchstart', function(e) {
                    e.preventDefault();
                });
            });
        }

        // Livewire integration
        document.addEventListener('livewire:init', () => {
            initializeSidebar();
            initializeDropdowns();

            document.addEventListener('livewire:navigated', () => {
                initializeSidebar();
                initializeDropdowns();
            });

            Livewire.hook('morph.updated', () => {
                initializeSidebar();
                initializeDropdowns();
            });
        });
    </script>
</body>

</html>
