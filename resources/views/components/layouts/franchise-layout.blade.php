<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Center Franchise Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
        }

        .sidebar {
            transition: all 0.3s ease;
            transform: translateX(-100%);
            z-index: 50;
        }

        .sidebar.active {
            transform: translateX(0);
        }

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

        .chart-container {
            height: 300px;
        }

        .dropdown-chevron {
            transition: transform 0.2s;
        }

        .dropdown-chevron.rotate {
            transform: rotate(180deg);
        }

        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
            }
        }

        /* Better mobile menu toggle */
        .mobile-menu-button {
            display: block;
        }

        @media (min-width: 768px) {
            .mobile-menu-button {
                display: none;
            }
        }

        /* Smooth transitions */
        .transition-slow {
            transition: all 0.4s ease;
        }

        /* Better dropdown shadows */
        .dropdown-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Better input focus states */
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile sidebar toggle -->
        <div class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 hidden transition-opacity duration-300" id="sidebarBackdrop"></div>

        <!-- Sidebar -->
        <div class="sidebar bg-white w-[22%] fixed md:relative h-full border-r border-gray-200" id="sidebar">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-pink-500 flex items-center justify-center">
                        <span class="text-white font-semibold text-lg">NF</span>
                    </div>
                    <h1 class="text-xl md:text-2xl font-semibold text-dark-800">Franchise Dashboard</h1>
                </div>
                <button id="sidebarClose" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="p-4 overflow-y-auto" style="max-height: calc(100vh - 64px);">
                <ul>
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.dashboard') }}"
                            class="flex items-center p-3 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Staff Section -->
                    <li class="mb-1 relative">
                        <a href="#" onclick="toggleDropdown(event, 'staff-dropdown', 'staff-chevron')"
                            class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-users-cog mr-3 w-5 text-center"></i>
                                <span>Staff</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs ml-2 dropdown-chevron" id="staff-chevron"></i>
                        </a>
                        <ul id="staff-dropdown"
                            class="hidden pl-2 mt-1 ml-6 border-l-2 border-blue-100 space-y-1">
                            <li>
                                <a wire:navigate href="{{ route('franchise.add.staff') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Add Staff</a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('franchise.manage.staff') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Manage Staff</a>
                            </li>
                        </ul>
                    </li>

                    <li class="mb-1 relative">
                        <a href="#" onclick="toggleDropdown(event, 'receptioners-dropdown', 'receptioners-chevron')"
                            class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-store mr-3 w-5 text-center"></i>
                                <span>Receptioners</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs ml-2 dropdown-chevron" id="receptioners-chevron"></i>
                        </a>
                        <ul id="receptioners-dropdown"
                            class="hidden pl-2 mt-1 ml-6 border-l-2 border-blue-100 space-y-1">
                            <li>
                                <a wire:navigate href="{{ route('franchise.add.receptioners') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Add Receptioners</a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('franchise.manage.receptioners') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 rounded transition-colors">Manage Receptioners</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="mb-1">
                        <a wire:navigate href="{{ route('franchise.manage.service') }}"
                            class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-tags mr-3 w-5 text-center"></i>
                            <span>Types</span>
                        </a>
                    </li>
                    
                    <li class="mb-1">
                        <a href="#"
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
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top navigation -->
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 py-3 sm:px-6">
                    <!-- Mobile menu button -->
                    <button id="sidebarToggle" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="flex flex-1 items-center justify-end space-x-4 sm:space-x-6">
                        <!-- Search bar - hidden on mobile, shown on tablet and up -->
                        <div class="relative hidden sm:block">
                            <input type="text" placeholder="Search payments..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-48 md:w-64 transition-all duration-200 input-focus">
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
                                <img src="{{ Auth::guard('franchise')->user()->profile_photo_url ?? 'https://placehold.co/40x40' }}"
                                    alt="User profile" class="rounded-full w-8 h-8 object-cover border-2 border-gray-200">
                                <span class="font-medium text-gray-700 hidden md:inline whitespace-nowrap">
                                    {{ Auth::guard('franchise')->user()->franchise_name }}
                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 dropdown-chevron" id="profile-chevron"></i>
                            </button>
                            
                            <div id="navbar-profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 dropdown-shadow border border-gray-100">
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">Profile</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">Settings</a>
                                <div class="border-t border-gray-100"></div>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-red-500 hover:text-red-600 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile search bar - shown only on mobile -->
                <div class="px-4 py-2 border-t border-gray-100 sm:hidden">
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full input-focus">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                if (!dropdown.contains(event.target) && !event.target.closest('button[onclick*="'+dropdown.id+'"]')) {
                    dropdown.classList.add('hidden');
                    const chevronId = dropdown.id.replace('-dropdown', '-chevron');
                    const chevron = document.getElementById(chevronId);
                    if (chevron) chevron.classList.remove('rotate');
                }
            });
        });

        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
            if (revenueCtx) {
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        datasets: [{
                            label: 'Revenue ($)',
                            data: [12000, 19000, 15000, 23000, 30000, 36000, 42000],
                            backgroundColor: 'rgba(67, 97, 238, 0.1)',
                            borderColor: 'rgba(67, 97, 238, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Performance Chart
            const performanceCtx = document.getElementById('performanceChart')?.getContext('2d');
            if (performanceCtx) {
                new Chart(performanceCtx, {
                    type: 'bar',
                    data: {
                        labels: ['New York', 'Chicago', 'Los Angeles', 'Houston', 'Miami'],
                        datasets: [{
                            label: 'Revenue ($)',
                            data: [32000, 28000, 41000, 25000, 38000],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)',
                                'rgba(255, 99, 132, 0.7)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
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