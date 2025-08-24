<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaFix - Electronic Repair Services</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        
        .service-card {
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .stat-number {
            font-size: 3rem;
            background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .warranty-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #f59e0b;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transform: rotate(15deg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Mobile sidebar styles */
        .mobile-sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        .mobile-sidebar-hidden {
            transform: translateX(-100%);
        }
        
        .overlay {
            transition: opacity 0.3s ease-in-out;
        }
        
        .overlay-hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- Mobile overlay -->
    <div class="overlay overlay-hidden fixed inset-0 bg-black bg-opacity-50 z-40 md:!hidden" 
         :class="{ 'overlay-hidden': !mobileMenuOpen }"
         x-show="mobileMenuOpen"
         @click="mobileMenuOpen = false">
    </div>

    <!-- Mobile sidebar -->
    <div class="mobile-sidebar mobile-sidebar-hidden fixed left-0 top-0 h-full w-64 bg-white shadow-lg z-50 md:!hidden"
         :class="{ 'mobile-sidebar-hidden': !mobileMenuOpen }"
         x-show="mobileMenuOpen"
         @click.away="mobileMenuOpen = false">
        <div class="p-4 border-b">
            <div class="text-blue-800 font-bold text-2xl">
                <span class="text-orange-500">Nova</span>Fix
            </div>
        </div>
        <nav class="p-4 space-y-4">
            <a href="#" class="block text-blue-800 font-medium hover:text-orange-500" @click="mobileMenuOpen = false">Home</a>
            <a href="#services" class="block text-gray-600 font-medium hover:text-orange-500" @click="mobileMenuOpen = false">Services</a>
            <a href="#about" class="block text-gray-600 font-medium hover:text-orange-500" @click="mobileMenuOpen = false">Track Status</a>
            <a href="#training" class="block text-gray-600 font-medium hover:text-orange-500" @click="mobileMenuOpen = false">Training</a>
            <a href="#contact" class="block text-gray-600 font-medium hover:text-orange-500" @click="mobileMenuOpen = false">Contact</a>
            <a href="#contact" class="block text-gray-600 font-medium bg-blue-500 p-2 hover:text-orange-500" @click="mobileMenuOpen = false">Request For Service</a>
        </nav>
    </div>

    <!-- Header/Navigation -->
    <header class="bg-white shadow-md fixed w-full z-30">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <div class="text-blue-800 font-bold text-2xl">
                    <span class="text-orange-500">Nova</span>Fix
                </div>
            </div>
            
            <nav class="hidden md:flex space-x-10">
                <a href="#" class="text-blue-800 font-medium hover:text-orange-500">Home</a>
                <a href="#services" class="text-gray-600 font-medium hover:text-orange-500">Services</a>
                <a href="#about" class="text-gray-600 font-medium hover:text-orange-500">About Us</a>
                <a href="#training" class="text-gray-600 font-medium hover:text-orange-500">Training</a>
                <a href="#contact" class="text-gray-600 font-medium hover:text-orange-500">Contact</a>
            </nav>
            
            <div class="flex items-center space-x-4">
                <a href="tel:7856802002" class="bg-blue-800 text-white px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-700">
                    <i class="fas fa-phone-alt mr-2"></i>Call Now
                </a>
                <button class="md:hidden text-gray-600" @click="mobileMenuOpen = true">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <main class="">
        {{ $slot }}

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4"><span class="text-orange-500">Nova</span>Fix</h3>
                    <p class="text-gray-400">Your trusted partner for all electronic repair needs. Quality service with guaranteed satisfaction.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white">Services</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#training" class="text-gray-400 hover:text-white">Training</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Laptop Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Desktop Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Mobile Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Data Recovery</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Virus Removal</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Connect With Us</h4>
                    <div class="flex space-x-4 mb-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f text-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in text-lg"></i></a>
                    </div>
                    <p class="text-gray-400">Subscribe to our newsletter</p>
                    <div class="mt-2 flex">
                        <input type="email" placeholder="Your Email" class="px-4 py-2 rounded-l-lg w-full text-gray-800">
                        <button class="bg-orange-500 px-4 py-2 rounded-r-lg"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 NovaFix. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>