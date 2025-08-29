<!DOCTYPE html>
<html lang="en" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaFix - Electronic Repair Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                        secondary: '#3B82F6',
                        background: '#F9FAFB',
                        text: '#111827',
                        accent: '#10B981',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            color: #111827;
        }
        
        .hero-pattern {
            background: linear-gradient(to right, rgba(30, 64, 175, 0.85), rgba(30, 64, 175, 0.7)), url('https://images.unsplash.com/photo-1468436139062-f60a71c5c892?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .service-card {
            transition: transform 0.3s ease;
            border: 1px solid #E5E7EB;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            border-color: #3B82F6;
        }
        
        .map-container {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .nav-link {
            position: relative;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #3B82F6;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }

        .section-title {
            position: relative;
            display: inline-block;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background: #3B82F6;
            left: 25%;
            bottom: -10px;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-background">
    <!-- Header -->
    <header class="bg-white shadow-sm fixed w-full z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <a wire:navigate href="{{route('homepage')}}" class="text-4xl font-bold text-gray-800">NovaFix</a>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a wire:navigate href="{{route('homepage')}}" class="nav-link text-gray-700 hover:text-primary py-2 transition">Home</a>
                <a wire:navigate href="{{route('learn')}}" class="nav-link text-gray-700 hover:text-primary py-2 transition">Learn</a>
                <a href="{{route('track.service')}}" class="nav-link text-gray-700 hover:text-primary py-2 transition">Track Status</a>
                <a wire:navigate href="{{route('contact')}}" class="nav-link text-gray-700 hover:text-primary py-2 transition">Contact</a>
                <a wire:navigate href="{{route('user.service.request')}}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-800 transition">Request For Repair</a>
            </nav>
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white py-4 px-4 absolute w-full shadow-lg">
            <a wire:navigate href="{{route('homepage')}}" class="block py-2 text-gray-700 hover:text-primary">Home</a>
            <a wire:navigate href="{{route('learn')}}" class="block py-2 text-gray-700 hover:text-primary">Learn</a>
            <a href="#track" class="block py-2 text-gray-700 hover:text-primary">Track Status</a>
            <a wire:navigate href="{{route('contact')}}" class="block py-2 text-gray-700 hover:text-primary">Contact</a>
            <a href="{{route('user.service.request')}}" class="block mt-2 bg-primary text-white px-4 py-2 rounded-md text-center hover:bg-blue-800">Request For Repair</a>
        </div>
    </header>
    
    <main class="pt-10">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl mb-4"><span class="text-accent">Nova</span>Fix</h3>
                    <p class="text-gray-400 mb-4">Your trusted partner for all electronic repair needs. Quality service with guaranteed satisfaction.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg text-gray-200 mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Warranty Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms & Conditions</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Our Team</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg text-gray-200 mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Laptop Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Desktop Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Mobile Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Printer Repair</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">TV Repair</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg text-gray-200 mb-4">Contact Info</h4>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-phone text-accent mt-1 mr-3"></i>
                            <span class="text-gray-400">+91 7856802002</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-envelope text-accent mt-1 mr-3"></i>
                            <span class="text-gray-400">novafixteam@gmail.com</span>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-accent mt-1 mr-3"></i>
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
   
</body>
</html>