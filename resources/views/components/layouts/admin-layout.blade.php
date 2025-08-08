<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - Franchise Management System</title>
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
            transform: translateX(-280px);
            transition: transform 0.3s ease;
            z-index: 50;
            overflow-y: auto;
            background-color: white;
            border-right: 1px solid #e5e7eb;

            /* Hide scrollbar for Firefox */
            scrollbar-width: none;

            /* Hide scrollbar for IE/Edge */
            -ms-overflow-style: none;
        }

        /* Hide scrollbar for Chrome, Safari, and Opera */
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
                width: 22%;
            }

            .main-content {
                margin-left: 22%;
            }

            .sidebar-toggle {
                display: none;
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
            display: none;
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
    </style>
</head>

<body class="bg-gray-50">
    <!-- Mobile sidebar toggle -->
    <div class="sidebar-backdrop hidden" id="sidebarBackdrop"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-pink-500 flex items-center justify-center">
                    <span class="text-white font-semibold text-lg">NF</span>
                </div>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Super Admin</h1>
            </div>
            <button id="sidebarClose" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="p-4 overflow-y-auto custom-scrollbar"
            style="max-height: calc(100vh - 64px); scrollbar-width: none; -ms-overflow-style: none;">
            <ul>
                <li class="mb-1">
                    <a wire:navigate href="{{ route('admin.dashboard') }}"
                        class="flex items-center p-3 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Franchise Management -->
                <li class="mb-1 relative">
                    <a href="#" onclick="toggleDropdown(event, 'franchise-dropdown', 'franchise-chevron')"
                        class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-store mr-3 w-5 text-center"></i>
                            <span>Franchises</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs ml-2 dropdown-chevron" id="franchise-chevron"></i>
                    </a>
                    <ul id="franchise-dropdown" class="hidden pl-2 mt-1 ml-6 border-l-2 border-blue-100 space-y-1">
                        <li>
                            <a wire:navigate href="{{ route('admin.manage-franchises') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">All
                                Franchises</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin.add-franchise') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Add
                                New</a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('admin.franchise.performance') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Performance</a>
                        </li>
                    </ul>
                </li>

                <!-- Staff Management -->
                <li class="mb-1 relative">
                    <a wire:navigate href="{{route('admin.staff.management')}}"
                        class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-users-cog mr-3 w-5 text-center"></i>
                            <span>Staff Management</span>
                        </div>
                    </a>
                </li>

                <!-- Receptionists -->
                <li class="mb-1">
                    <a wire:navigate href="{{route('admin.receptionst.management')}}"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                        <span>Receptionists</span>
                    </a>
                </li>

                <!-- Customers -->
                <li class="mb-1">
                    <a href="#"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <i class="fas fa-users mr-3 w-5 text-center"></i>
                        <span>Customers</span>
                    </a>
                </li>

                <!-- Financial Management -->
                <li class="mb-1 relative">
                    <a href="#" onclick="toggleDropdown(event, 'finance-dropdown', 'finance-chevron')"
                        class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-money-bill-wave mr-3 w-5 text-center"></i>
                            <span>Financials</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs ml-2 dropdown-chevron" id="finance-chevron"></i>
                    </a>
                    <ul id="finance-dropdown" class="hidden pl-2 mt-1 ml-6 border-l-2 border-blue-100 space-y-1">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Payments</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Revenue</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Expenses</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Payouts</a>
                        </li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="mb-1 relative">
                    <a href="#" onclick="toggleDropdown(event, 'reports-dropdown', 'reports-chevron')"
                        class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-chart-bar mr-3 w-5 text-center"></i>
                            <span>Reports</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs ml-2 dropdown-chevron" id="reports-chevron"></i>
                    </a>
                    <ul id="reports-dropdown" class="hidden pl-2 mt-1 ml-6 border-l-2 border-blue-100 space-y-1">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Performance</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Growth</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Valuation</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Loss
                                Analysis</a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
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
            <span>Super Admin</span>
            <div class="flex items-center space-x-4">
                <button class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none relative">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <img src="https://placehold.co/40x40" alt="User profile"
                    class="rounded-full w-8 h-8 object-cover border-2 border-gray-200">
            </div>
        </div>

        <!-- Desktop header -->
        <header class="hidden md:block bg-white shadow-sm sticky top-0 z-20">
            <div class="flex items-center justify-between px-4 py-3 sm:px-6">
                <div class="flex-1 flex items-center justify-end space-x-4 sm:space-x-6">
                    <!-- Search bar -->
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-48 md:w-64 transition-all duration-200">
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
                            <img src="https://placehold.co/40x40" alt="User profile"
                                class="rounded-full w-8 h-8 object-cover border-2 border-gray-200">
                            <span class="font-medium text-gray-700 hidden md:inline whitespace-nowrap">Super
                                Admin</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500 dropdown-chevron"
                                id="profile-chevron"></i>
                        </button>

                        <div id="navbar-profile-dropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-100">
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
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarBackdrop.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarClose.addEventListener('click', toggleSidebar);
        sidebarBackdrop.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = sidebarToggle.contains(event.target);

            if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth < 768) {
                sidebar.classList.remove('active');
                sidebarBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });

        // Dropdown toggle function
        function toggleDropdown(event, dropdownId, chevronId = null) {
            event.preventDefault();
            event.stopPropagation();

            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');

            if (chevronId) {
                const chevron = document.getElementById(chevronId);
                chevron.classList.toggle('rotate');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('[id$="-dropdown"]');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target) && !event.target.closest('button[onclick*="' + dropdown
                        .id + '"]')) {
                    dropdown.classList.add('hidden');
                    const chevronId = dropdown.id.replace('-dropdown', '-chevron');
                    const chevron = document.getElementById(chevronId);
                    if (chevron) chevron.classList.remove('rotate');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.add('active');
                sidebarBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>
</body>

</html>
