<!DOCTYPE html>
<html lang="en" class="font-poppins">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TechCare - Staff Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#3B82F6', // indigo-500
                        secondary: '#10B981', // emerald-500
                        danger: '#EF4444', // red-500
                        warning: '#F59E0B', // amber-500
                        info: '#06B6D4', // cyan-500
                        staff: '#8B5CF6', // violet-500 (for staff-specific accent)
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800 font-poppins">
    <!-- Fixed Navbar -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
        <div class="px-4 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <img src="https://placehold.co/40x40" alt="TechCare logo"
                    class="h-10 w-10 rounded-full border-2 border-staff">
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">NovaFix Staff Portal</h1>
            </div>
            <div class="flex items-center space-x-4">
                <button class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
                    <i class="fas fa-bell text-xl"></i>
                    <span
                        class="absolute -top-1 -right-1 px-1.5 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">3</span>
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                        <img src="{{ auth()->user()->profile_photo_url ?? 'https://placehold.co/36x36' }}"
                            alt="User Profile" class="h-9 w-9 rounded-full border-2 border-staff">
                        <span class="font-medium hidden sm:inline">{{Auth::guard('staff')->user()->name}}</span>
                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <form method="POST" action="">
                            @csrf
                            <button type="submit"
                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="flex pt-[72px] ">
        <!-- Fixed Sidebar (desktop) -->
        <aside id="sidebar"
            class="fixed md:relative z-40 bg-white w-64 shadow-md py-6 inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out">
            <nav>
                <ul class="space-y-1">
                    <li>
                        <a wire:navigate href="{{ route('staff.dashboard') }}"
                            class="flex items-center px-5 py-3 hover:bg-gray-100 text-gray-700 rounded-r-full transition duration-150">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{route('staff.assigned.task')}}"
                            class="flex items-center px-5 py-3 bg-staff text-white font-medium rounded-r-full">
                            <i class="fas fa-tasks mr-3"></i> Assigned Tasks
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href=""
                            class="flex items-center px-5 py-3 hover:bg-gray-100 text-gray-700 rounded-r-full transition duration-150">
                            <i class="fas fa-check-circle mr-3"></i> Completed Tasks
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href=""
                            class="flex items-center px-5 py-3 hover:bg-gray-100 text-gray-700 rounded-r-full transition duration-150">
                            <i class="fas fa-boxes mr-3"></i> Inventory
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href=""
                            class="flex items-center px-5 py-3 hover:bg-gray-100 text-gray-700 rounded-r-full transition duration-150">
                            <i class="fas fa-chart-bar mr-3"></i> Reports
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href=""
                            class="flex items-center px-5 py-3 hover:bg-gray-100 text-gray-700 rounded-r-full transition duration-150">
                            <i class="fas fa-cog mr-3"></i> Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
  {{ $slot }}
    
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

    <!-- JS for Sidebar Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');

            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                mobileOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            });

            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });

            document.querySelectorAll('#sidebar nav ul li a').forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebar.classList.add('-translate-x-full');
                        mobileOverlay.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });
    </script>
</body>

</html>