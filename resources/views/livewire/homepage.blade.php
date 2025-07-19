<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 h-[600px]">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 h-full flex items-center">
            <div class="text-white space-y-6">
                <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                    Your Trusted Partner<br>
                    <span class="text-orange-400">For Electronic Repairs</span>
                </h1>
                <p class="text-xl max-w-2xl">Professional repair services for laptops, desktops, and mobile devices with guaranteed satisfaction.</p>
                <div class="flex gap-4">
                    <a href="#services" class="bg-orange-500 hover:bg-orange-600 px-8 py-3 rounded-full font-semibold transition">
                        Our Services
                    </a>
                    <a href="#contact" class="bg-white text-gray-800 hover:bg-gray-100 px-8 py-3 rounded-full font-semibold transition">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div id="services" class="py-20 max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Our Services</h2>
            <div class="w-24 h-1 bg-orange-500 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group hover:-translate-y-2 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-pink-100 rounded-lg flex items-center justify-center mb-6">
                            <img src="{{ asset('images/laptop.png') }}" alt="Laptop" class="w-10 h-10">
                        </div>
                        <h3 class="text-xl font-bold mb-4">Laptop Repair</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li>• Hardware Repairs</li>
                            <li>• Software Issues</li>
                            <li>• Screen Replacement</li>
                            <li>• Battery Service</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="group hover:-translate-y-2 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <img src="{{ asset('images/desktop.png') }}" alt="Desktop" class="w-10 h-10">
                        </div>
                        <h3 class="text-xl font-bold mb-4">Desktop Repair</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li>• Hardware Upgrades</li>
                            <li>• OS Installation</li>
                            <li>• Virus Removal</li>
                            <li>• Data Recovery</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="group hover:-translate-y-2 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                            <img src="{{ asset('images/mobile.png') }}" alt="Mobile" class="w-10 h-10">
                        </div>
                        <h3 class="text-xl font-bold mb-4">Mobile Repair</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li>• Screen Repairs</li>
                            <li>• Battery Replacement</li>
                            <li>• Water Damage</li>
                            <li>• Camera Issues</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-orange-500">5000+</div>
                    <div class="text-gray-600 mt-2">Repairs Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-orange-500">98%</div>
                    <div class="text-gray-600 mt-2">Satisfied Customers</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-orange-500">50+</div>
                    <div class="text-gray-600 mt-2">Expert Technicians</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-orange-500">24/7</div>
                    <div class="text-gray-600 mt-2">Support Available</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Experience Section -->
    <div class="py-12">
        <h2 class="text-2xl font-semibold mb-4">Services Experience</h2>
        <p class="text-gray-600">Welcome to our repair service! We understand that having something break down can be frustrating, and that's why we're here to help. Our team of experienced technicians is dedicated to providing high-quality repairs and easy fix a wide range of products and devices.</p>
    </div>

    <!-- Benefits Section -->
    <div class="py-12">
        <h2 class="text-2xl font-semibold mb-8">Services Benefits</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            <div class="p-4 bg-cyan-100 rounded-lg text-center">
                <p>6 Months warranty of service</p>
            </div>
            <div class="p-4 bg-yellow-100 rounded-lg text-center">
                <p>We use genuine parts for repair</p>
            </div>
            <div class="p-4 bg-green-100 rounded-lg text-center">
                <p>Service charges for repairing</p>
            </div>
        </div>
    </div>

    <!-- Training Section -->
    <div class="py-12">
        <h2 class="text-2xl font-semibold mb-4">Do you wish to learn IT repairing?</h2>
        <div class="bg-gray-100 p-6 rounded-lg">
            <img src="{{ asset('images/training.jpg') }}" alt="Training" class="w-full h-64 object-cover rounded-lg">
            <p class="mt-4">Take your IT skills to the next level with our expert-led training courses designed to help you become more proficient in IT repairing services.</p>
            <button class="mt-4 bg-orange-500 text-white px-6 py-2 rounded-lg">Learn More</button>
        </div>
    </div>
</div>
