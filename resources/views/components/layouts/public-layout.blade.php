<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaFix - Software Repair Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#1E40AF',
                            700: '#1E3A8A',
                        },
                        dark: {
                            800: '#1E293B',
                            900: '#0F172A'
                        },
                        accent: {
                            500: '#10B981',
                            600: '#059669'
                        }
                    },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'pulse-slow': 'pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in': 'fadeIn 1s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'glow': 'glow 2s ease-in-out infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-12px)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        glow: {
                            '0%, 100%': { boxShadow: '0 0 5px rgba(16, 185, 129, 0.4)' },
                            '50%': { boxShadow: '0 0 20px rgba(16, 185, 129, 0.8)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .notification-slide {
            animation: slideIn 0.5s ease-out forwards;
        }
        .bg-hero-pattern {
            background-image: linear-gradient(to right bottom, rgba(30, 64, 175, 0.9), rgba(14, 165, 233, 0.7)), 
                            url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"%3E%3Cpath fill="none" stroke="%23ffffff33" stroke-width="15" d="M40 40 L160 160 M160 40 L40 160"/%3E%3C/svg%3E');
            background-size: cover, 50px;
        }
        @keyframes slideIn {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Mobile menu animation */
        @media (max-width: 767px) {
            .mobile-menu {
                transition: transform 0.3s ease-in-out;
            }
            .mobile-menu-hidden {
                transform: translateX(-100%);
            }
            .mobile-menu-visible {
                transform: translateX(0);
            }
            
            /* Hide left section on mobile */
            .left-section {
                display: none;
            }
            
            /* Center login form on mobile */
            .login-form {
                margin: 0 auto;
                width: 100%;
                max-width: 400px;
            }
            
            /* Adjust main content padding for mobile */
            main {
                padding: 1rem;
            }
            
            /* Adjust hero pattern for mobile */
            .bg-hero-pattern {
                padding: 2rem 0;
                background-size: cover;
            }
        }
    </style>
    @livewireStyles
</head>

<body class="bg-gray-100 min-h-screen flex flex-col overflow-x-hidden font-sans">
  
  
    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

    <!-- Main Content -->
    <main class="flex-grow p-4 md:p-10">
        <div class="bg-hero-pattern rounded-lg py-8 md:py-16">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <!-- Left Section - Hidden on mobile -->
                    <div class="left-section space-y-4 md:space-y-6 animate-slide-up order-2 md:order-1 mt-8 md:mt-0">
                        <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight">
                            Welcome to NovaFix
                        </h2>
                        <p class="text-base md:text-lg text-blue-100">
                            Your trusted software repair center. Streamline your workflow with our cutting-edge receptionist portal designed for efficiency and reliability.
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="#" class="inline-flex items-center justify-center px-4 py-2 md:px-6 md:py-3 bg-accent-500 text-white font-medium rounded-md hover:bg-accent-600 transition-all duration-300 hover:scale-105 text-sm md:text-base">
                                <i class="fas fa-cogs mr-2"></i> Explore Services
                            </a>
                            <a href="#" class="inline-flex items-center justify-center px-4 py-2 md:px-6 md:py-3 bg-transparent border border-white text-white font-medium rounded-md hover:bg-white hover:text-primary-700 transition-all duration-300 hover:scale-105 text-sm md:text-base">
                                <i class="fas fa-headset mr-2"></i> Contact Support
                            </a>
                        </div>
                    </div>

                    <!-- Login Form - Centered on mobile -->
                    <div class="login-form bg-white p-6 mt-10 md:p-8 rounded-xl shadow-2xl animation-float animate-glow order-1 md:order-2">
                        {{$slot}}
                    </div>
                </div>
            </div>
        </div>
    </main>

    @livewireScripts
    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileOverlay = document.getElementById('mobile-overlay');

        function toggleMobileMenu() {
            mobileMenu.classList.toggle('mobile-menu-hidden');
            mobileMenu.classList.toggle('mobile-menu-visible');
            mobileOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        mobileMenuButton.addEventListener('click', toggleMobileMenu);
        mobileMenuClose.addEventListener('click', toggleMobileMenu);
        mobileOverlay.addEventListener('click', toggleMobileMenu);

        // Close menu when clicking on links (for single page applications)
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', toggleMobileMenu);
        });

        // Header transparency on scroll
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (header) {
                if (window.scrollY > 50) {
                    header.classList.add('bg-dark-900', 'shadow-lg');
                    header.classList.remove('bg-transparent');
                } else {
                    header.classList.add('bg-transparent');
                    header.classList.remove('bg-dark-900', 'shadow-lg');
                }
            }
        });

        // Close notification banner
        const notification = document.querySelector('.notification-slide');
        if (notification) {
            notification.querySelector('button').addEventListener('click', () => {
                notification.style.transform = 'translateY(-100%)';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            });
        }

        // Livewire hook to reinitialize mobile menu after DOM updates
        if (window.livewire) {
            window.livewire.hook('message.processed', () => {
                // Reattach event listeners if needed
            });
        }
    </script>
</body>
</html>