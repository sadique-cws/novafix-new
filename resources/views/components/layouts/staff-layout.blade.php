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
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                        staff: {
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
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.08)',
                        'soft-md': '0 6px 30px -3px rgba(0, 0, 0, 0.1)',
                        'soft-lg': '0 10px 40px -5px rgba(0, 0, 0, 0.12)',
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 text-dark-800 font-poppins antialiased">
    <!-- Fixed Navbar -->
    <header class="fixed top-0 left-0  right-0 bg-white shadow-sm z-50 border-b border-gray-100">
        <div class="px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button id="mobile-menu-button" class="md:hidden text-dark-400 hover:text-dark-600 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center gap-3">
                    <div
                        class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-pink-500 flex items-center justify-center">
                        <span class="text-white font-semibold text-lg">NF</span>
                    </div>
                    <h1 class="text-xl hidden md:block md:text-2xl md font-semibold text-dark-800">NovaFix <span class="text-blue-500">Staff Panel</span></h1>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button
                    class="relative p-2 text-dark-400 hover:text-dark-600 focus:outline-none transition-colors group">
                    <i class="fas fa-bell text-xl"></i>
                    <span
                        class="absolute top-0 right-0 px-1.5 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full transform translate-x-1 -translate-y-1">3</span>
                    <div
                        class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-soft-lg py-2 z-50 hidden group-hover:block">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <h3 class="font-medium text-dark-700">Notifications</h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <a href="#"
                                class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100">
                                <div class="flex items-start">
                                    <div class="bg-primary-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-tasks text-primary-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-dark-700">New task assigned</p>
                                        <p class="text-xs text-dark-400 mt-1">Complete the diagnostics for ticket
                                            #TC-245</p>
                                        <p class="text-xs text-primary-500 mt-1">2 hours ago</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#"
                                class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100">
                                <div class="flex items-start">
                                    <div class="bg-secondary-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-check-circle text-secondary-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-dark-700">Task completed</p>
                                        <p class="text-xs text-dark-400 mt-1">Your submission for ticket #TC-198 was
                                            approved</p>
                                        <p class="text-xs text-primary-500 mt-1">5 hours ago</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start">
                                    <div class="bg-staff-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-user-tie text-staff-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-dark-700">New message</p>
                                        <p class="text-xs text-dark-400 mt-1">You have a new message from the admin</p>
                                        <p class="text-xs text-primary-500 mt-1">1 day ago</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="px-4 py-2 border-t border-gray-100 text-center">
                            <a href="#" class="text-sm text-primary-600 font-medium hover:text-primary-700">View
                                all notifications</a>
                        </div>
                    </div>
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-3 focus:outline-none group">
                        <div class="relative">
                            <img src="{{ auth()->user()->profile_photo_url ?? 'https://placehold.co/40x40' }}"
                                alt="User Profile" class="h-9 w-9 rounded-full border-2 border-staff-400 object-cover">
                            <span
                                class="absolute bottom-0 right-0 h-3 w-3 bg-green-500 rounded-full border-2 border-white"></span>
                        </div>
                        <div class="text-left hidden md:block">
                            <p class="font-medium text-dark-700 text-sm">{{ Auth::guard('staff')->user()->name }}</p>
                            <p class="text-xs text-dark-400">Technical Staff</p>
                        </div>
                        <i class="fas fa-chevron-down text-xs ml-1 text-dark-400 transition-transform duration-200"
                            :class="{ 'transform rotate-180': open }"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-soft-lg py-1 z-50 border border-gray-100">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-dark-700">{{ Auth::guard('staff')->user()->name }}</p>
                            <p class="text-xs text-dark-400 truncate">{{ Auth::guard('staff')->user()->email }}</p>
                        </div>
                        <a href="{{route('staff.profile')}}"
                            class="block px-4 py-2.5 text-sm text-dark-600 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-user-circle mr-3 text-dark-400 w-5 text-center"></i> My Profile
                        </a>
                        <a href="#"
                            class="block px-4 py-2.5 text-sm text-dark-600 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-cog mr-3 text-dark-400 w-5 text-center"></i> Settings
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                       
                            <a href="{{route('staff.logout')}}" 
                                class="w-full text-left flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </a >
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex pt-16">
        <!-- Fixed Sidebar (desktop) -->
        <aside id="sidebar"
            class="fixed top-16 left-0 bottom-0 bg-white w-64 shadow-sm py-4 z-40 border-r border-gray-100 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out">

            <nav class="h-[calc(100vh-8rem)] overflow-y-auto">
                <ul class="space-y-1 px-3">
                    <li>
                        <a wire:navigate href="{{ route('staff.dashboard') }}"
                            class="flex items-center px-4 py-2.5 hover:bg-gray-50 text-dark-500 rounded-lg transition duration-150 group">
                            <div
                                class="bg-primary-50 p-2 rounded-lg mr-3 group-hover:bg-primary-100 transition-colors">
                                <i class="fas fa-tachometer-alt text-primary-600 text-sm"></i>
                            </div>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('staff.assigned.task') }}"
                            class="flex items-center px-4 py-2.5 bg-gradient-to-r from-staff-50 to-primary-50 text-primary-700 font-medium rounded-lg border border-primary-100">
                            <div class="bg-white p-2 rounded-lg mr-3 shadow-xs">
                                <i class="fas fa-tasks text-staff-600 text-sm"></i>
                            </div>
                            <span class="font-medium">Assigned Tasks</span>
                            <span
                                class="ml-auto bg-primary-100 text-primary-800 text-xs font-medium px-2 py-0.5 rounded-full">3</span>
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('staff.completed.task') }}"
                            class="flex items-center px-4 py-2.5 hover:bg-gray-50 text-dark-500 rounded-lg transition duration-150 group">
                            <div
                                class="bg-secondary-50 p-2 rounded-lg mr-3 group-hover:bg-secondary-100 transition-colors">
                                <i class="fas fa-check-circle text-secondary-600 text-sm"></i>
                            </div>
                            <span class="font-medium">Completed Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href=""
                            class="flex items-center px-4 py-2.5 hover:bg-gray-50 text-dark-500 rounded-lg transition duration-150 group">
                            <div class="bg-dark-50 p-2 rounded-lg mr-3 group-hover:bg-dark-100 transition-colors">
                                <i class="fas fa-cog text-dark-600 text-sm"></i>
                            </div>
                            <span class="font-medium">Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100">
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <p class="text-xs text-dark-400">Need help?</p>
                    <a href="#" class="text-xs font-medium text-primary-600 hover:text-primary-700">Contact
                        Support</a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-[20%] min-h-[calc(100vh-4rem)] bg-gray-50">
            {{ $slot }}
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

    <!-- JS for Sidebar Toggle -->
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
