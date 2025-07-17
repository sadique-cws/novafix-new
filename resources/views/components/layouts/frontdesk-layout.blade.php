<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechCare - Service Center Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        danger: '#EF4444',
                        warning: '#F59E0B',
                        info: '#06B6D4'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header with Mobile Toggle -->
        <header class="bg-white shadow-sm">
            <div class="px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <img src="https://placehold.co/40x40" alt="TechCare logo - a stylized computer chip with wrench icon" class="h-10 w-10 rounded-full">
                    <h1 class="text-xl font-bold text-gray-800">TechCare Service Center</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
                    </button>
                    <div class="flex items-center space-x-2">
                        <img src="https://placehold.co/36x36" alt="Front desk administrator profile picture showing a professional headshot" class="h-9 w-9 rounded-full border-2 border-primary">
                        <span class="font-medium hidden sm:inline">John Doe</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar - Hidden on mobile by default -->
            <aside id="sidebar" class="bg-white shadow-sm w-64 py-4 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out z-40">
                <nav>
                    <ul class="space-y-1">
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-white bg-primary rounded-r-full">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-r-full">
                                <i class="fas fa-plus-circle mr-3"></i>
                                <span>New Service</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-r-full">
                                <i class="fas fa-tasks mr-3"></i>
                                <span>Service Queue</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-r-full">
                                <i class="fas fa-users mr-3"></i>
                                <span>Customers</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-r-full">
                                <i class="fas fa-box-open mr-3"></i>
                                <span>Inventory</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-r-full">
                                <i class="fas fa-file-invoice-dollar mr-3"></i>
                                <span>Invoices</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-r-full">
                                <i class="fas fa-chart-line mr-3"></i>
                                <span>Reports</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-r-full">
                                <i class="fas fa-cog mr-3"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

           {{ $slot }}
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');

            // Toggle sidebar on mobile
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                mobileOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            });

            // Close sidebar when clicking on overlay
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });

            // Close sidebar when clicking on a menu item (optional)
            const menuItems = document.querySelectorAll('#sidebar nav ul li a');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebar.classList.add('-translate-x-full');
                        mobileOverlay.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            });

            // Responsive adjustments
            function handleResize() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Run once on load
        });
    </script>
</body>
</html>
