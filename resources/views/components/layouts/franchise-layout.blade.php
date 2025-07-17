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
            transition: all 0.3s;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .stat-card {
            border-left: 4px solid var(--primary-color);
        }

        .chart-container {
            height: 300px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile sidebar toggle -->
        <div class="fixed inset-0 z-10 bg-gray-900 bg-opacity-50 hidden" id="sidebarBackdrop"></div>

        <!-- Sidebar -->
        <div class="sidebar bg-white w-64 fixed md:relative z-20 h-full border-r border-gray-200" id="sidebar">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://placehold.co/40x40"
                        alt="Company logo with circular blue background and white text SC for Service Center"
                        class="mr-3">
                    <span class="text-xl font-semibold text-gray-800">Franchise Dashboard</span>
                </div>
                <button id="sidebarClose" class="md:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="p-4">
                <ul>
                    <li class="mb-1">
                        <a href="#"
                            class="flex items-center p-3 text-gray-700 rounded-lg bg-blue-50 text-blue-600">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-1 relative">
                        <a href="#" onclick="toggleDropdown(event, 'receptioners-dropdown')"
                            class="flex items-center justify-between p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <div class="flex items-center">
                                <i class="fas fa-store mr-3"></i>
                                <span>Receptioners</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs ml-2 transition-transform"
                                id="receptioners-chevron"></i>
                        </a>
                        <ul id="receptioners-dropdown"
                            class="hidden absolute left-0 right-0 mt-1 ml-4 bg-white border m-2 shadow-md rounded-lg py-1 z-10 w-56">
                            <li>
                                <a href="{{route('franchise.add.receptioners')}}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Add Receptioners</a>
                            </li>
                            <li>
                                <a href="{{route('franchise.manage.receptioners')}}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Manage
                                    Receptioners</a>
                            </li>
                        </ul>
                    </li>
                    <li class="mb-1">
                        <a href="#" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-users mr-3"></i>
                            <span>Customers</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="#" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-wrench mr-3"></i>
                            <span>Services</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="#" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-file-invoice-dollar mr-3"></i>
                            <span>Invoices</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="#" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-chart-line mr-3"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="#" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-blue-50">
                            <i class="fas fa-cog mr-3"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>

             <div class="mt-8 pt-4 border-t border-gray-200">
    @auth('franchise')
        <div class="flex items-center">
            <img src="{{ Auth::guard('franchise')->user()->profile_photo_url ?? 'https://placehold.co/40x40' }}" 
                 alt="User profile picture"
                 class="rounded-full mr-3 w-10 h-10">
            <div>
                <h4 class="font-medium text-gray-800">
                    {{ Auth::guard('franchise')->user()->franchise_name }}
                </h4>
                <p class="text-sm text-gray-500">
                    {{ Auth::guard('franchise')->user()->email }}
                </p>
            </div>
        </div>
        
        <!-- Logout Form -->
        <form method="POST" action="{{ route('franchise.logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full mt-4 px-4 py-2 bg-gray-100 rounded-lg text-gray-700 hover:bg-gray-200">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    @else
        <div class="text-center py-4">
            <p class="text-gray-500">Not logged in</p>
            <a href="{{ route('franchise.login') }}" class="text-blue-500 hover:underline">Login</a>
        </div>
    @endauth
</div>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 overflow-auto">
            <!-- Top navigation -->
            <header class="bg-white shadow-sm z-10 sticky top-0">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="mr-4 text-gray-500 hover:text-gray-700 md:hidden">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-2xl font-semibold text-gray-800">Dashboard Overview</h1>
                    </div>

                    <div class="flex items-center">
                        <div class="relative mr-4">
                            <input type="text" placeholder="Search..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <div class="relative mr-4">
                            <button class="p-2 text-gray-500 hover:text-gray-700 relative">
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.add('active');
            sidebarBackdrop.classList.remove('hidden');
        });

        sidebarClose.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarBackdrop.classList.add('hidden');
        });

        sidebarBackdrop.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarBackdrop.classList.add('hidden');
        });

        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
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

            // Performance Chart
            const performanceCtx = document.getElementById('performanceChart').getContext('2d');
            const performanceChart = new Chart(performanceCtx, {
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
        });
         function toggleDropdown(event, dropdownId) {
        event.preventDefault();
        const dropdown = document.getElementById(dropdownId);
        const chevron = document.getElementById('receptioners-chevron');
        
        dropdown.classList.toggle('hidden');
        chevron.classList.toggle('rotate-180');
    }
    </script>
</body>

</html>
