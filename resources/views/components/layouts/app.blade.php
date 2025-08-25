<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaFix - Electronic Repair Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        .hero-pattern {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3)), url('https://images.unsplash.com/photo-1468436139062-f60a71c5c892?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
        }
        
        .map-container {
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white  fixed w-full z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <div class="text-2xl font-bold text-blue-600"><span class="text-orange-500">Nova</span>Fix</div>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-700 hover:text-blue-600 py-2 transition">Home</a>
                <a href="#services" class="text-gray-700 hover:text-blue-600 py-2 transition">Services</a>
                <a href="{{route('track.service')}}" class="text-gray-700 hover:text-blue-600 py-2 transition">Track Status</a>
                <a href="#contact" class="text-gray-700 hover:text-blue-600 py-2 transition">Contact</a>
                <a wire:navigate href="{{route('user.service.request')}}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Request For Repair</a>
            </nav>
            <div class="md:hidden">
                <button id="menuToggle" class="text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white py-4 px-4 absolute w-full shadow-lg">
            <a href="#" class="block py-2 text-gray-700 hover:text-blue-600">Home</a>
            <a href="#services" class="block py-2 text-gray-700 hover:text-blue-600">Services</a>   
            <a href="#track-status" class="block py-2 text-gray-700 hover:text-blue-600">Track Status</a>
            <a href="#contact" class="block py-2 text-gray-700 hover:text-blue-600">Contact</a>
            <a href="#request-repair" class="block mt-2 bg-blue-600 text-white px-4 py-2 rounded-md text-center hover:bg-blue-700">Request For Repair</a>
        </div>
    </header>
    <main class="pt-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4"><span class="text-orange-500">Nova</span>Fix</h3>
                    <p class="text-gray-400 mb-4">Your trusted partner for all electronic repair needs. Quality service with guaranteed satisfaction.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Warranty Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms & Conditions</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Our Team</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Laptop Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Desktop Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Mobile Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Printer Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">TV Repair</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-phone text-orange-500 mt-1 mr-3"></i>
                            <span class="text-gray-400">+91 7856802002</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-envelope text-orange-500 mt-1 mr-3"></i>
                            <span class="text-gray-400">novafixteam@gmail.com</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-orange-500 mt-1 mr-3"></i>
                            <span class="text-gray-400">Zila School Road, Near BSNL tower, Purnea (Bihar) – 854301</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>Copyright © 2023 NovaFix. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu functionality
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking on links
        const mobileLinks = document.querySelectorAll('#mobileMenu a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    </script>
</body>
</html>