<div>
    <!-- Hero Section -->
    <section class="hero-pattern pt-32 pb-20 text-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl mb-4 font-bold tracking-tight">All Electronic Services Under One Roof</h1>
                <p class="text-xl mb-8 text-gray-100 font-light">Expert repair services for all your electronic devices with warranty.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#services">
                        <x-ui.button variant="primary" size="lg" class="w-full sm:w-auto !bg-accent hover:!bg-green-600 !border-0 text-white font-semibold">
                            Our Services
                        </x-ui.button>
                    </a>
                    <a href="#contact">
                        <x-ui.button variant="outline" size="lg" class="w-full sm:w-auto !border-2 !border-white !text-white hover:!bg-white hover:!text-primary font-semibold">
                            Get Quote
                        </x-ui.button>
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('main.png') }}" alt="Electronic Repair Services"
                    class="w-full max-w-md drop-shadow-sm">
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl text-gray-900 font-semibold mb-4 tracking-tight">Services Provided</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">We offer comprehensive electronic repair services for all your devices with 6 months warranty</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Laptop Service -->
                <x-ui.card class="shadow-none border border-gray-200 hover:border-primary transition-colors text-center group py-4">
                    <div class="text-primary text-4xl mb-5 flex justify-center opacity-90 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Laptop Service</h3>
                    <div class="flex justify-center mb-5">
                        <img src="{{ asset('laptop.jpeg') }}" alt="Laptop Repair" class="h-32 object-contain mix-blend-multiply opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    <p class="text-gray-500 text-sm">Professional laptop repair services for all brands and models with 6 months warranty.</p>
                </x-ui.card>

                <!-- Desktop Service -->
                <x-ui.card class="shadow-none border border-gray-200 hover:border-primary transition-colors text-center group py-4">
                    <div class="text-primary text-4xl mb-5 flex justify-center opacity-90 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Desktop Service</h3>
                    <div class="flex justify-center mb-5">
                        <img src="{{ asset('desktop.jpeg') }}" alt="Desktop Repair" class="h-32 object-contain mix-blend-multiply opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    <p class="text-gray-500 text-sm">Comprehensive desktop computer repair and maintenance services with warranty.</p>
                </x-ui.card>

                <!-- Printer Service -->
                <x-ui.card class="shadow-none border border-gray-200 hover:border-primary transition-colors text-center group py-4">
                    <div class="text-primary text-4xl mb-5 flex justify-center opacity-90 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Printer Service</h3>
                    <div class="flex justify-center mb-5">
                        <img src="{{ asset('printer.jpeg') }}" alt="Printer Repair" class="h-32 object-contain mix-blend-multiply opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    <p class="text-gray-500 text-sm">Expert printer repair for all types of printers and brands with 6 months warranty.</p>
                </x-ui.card>

                <!-- Mobile Service -->
                <x-ui.card class="shadow-none border border-gray-200 hover:border-primary transition-colors text-center group py-4">
                    <div class="text-primary text-4xl mb-5 flex justify-center opacity-90 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Mobile Service</h3>
                    <div class="flex justify-center mb-5">
                        <img src="{{ asset('mobile.jpeg') }}" alt="Mobile Repair" class="h-32 object-contain mix-blend-multiply opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    <p class="text-gray-500 text-sm">Professional mobile phone repair services with genuine parts and warranty.</p>
                </x-ui.card>

                <!-- LCD TV Service -->
                <x-ui.card class="shadow-none border border-gray-200 hover:border-primary transition-colors text-center group py-4">
                    <div class="text-primary text-4xl mb-5 flex justify-center opacity-90 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-tv"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">LCD TV Service</h3>
                    <div class="flex justify-center mb-5">
                        <img src="{{ asset('lcd.jpeg') }}" alt="LCD TV Repair" class="h-32 object-contain mix-blend-multiply opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    <p class="text-gray-500 text-sm">Expert repair services for LCD, LED, and Smart TVs with warranty.</p>
                </x-ui.card>

                <!-- Tablet Service -->
                <x-ui.card class="shadow-none border border-gray-200 hover:border-primary transition-colors text-center group py-4">
                    <div class="text-primary text-4xl mb-5 flex justify-center opacity-90 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-tablet-alt"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Tablet Service</h3>
                    <div class="flex justify-center mb-5">
                        <img src="{{ asset('tab.jpeg') }}" alt="Tablet Repair" class="h-32 object-contain mix-blend-multiply opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    <p class="text-gray-500 text-sm">Comprehensive tablet repair services for all models with warranty.</p>
                </x-ui.card>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section class="py-24 bg-white border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl text-gray-900 font-semibold mb-8 tracking-tight">Our Experience</h2>
            
            <div class="text-gray-600 space-y-6 text-lg font-light leading-relaxed">
                <p>Welcome to our repair service! We understand that having something break down can be frustrating, and that's why we're here to help. Our team of experienced technicians is dedicated to providing high-quality repair services for a wide range of products and devices.</p>
                
                <p>We offer a variety of repair services, including electronics repair, appliance repair, and more. Whether you need a quick fix or a more complex repair, we have the skills and expertise to get the job done right.</p>
                
                <div class="mt-10 pt-4">
                    <a href="#contact">
                        <x-ui.button variant="primary" size="lg" class="px-10">Contact Us</x-ui.button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl text-gray-900 font-semibold mb-4 tracking-tight">Why Choose NovaFix?</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">We provide comprehensive electronic repair services with a focus on quality and customer satisfaction.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-ui.card class="shadow-none border border-gray-200">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">6 Months Warranty</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">We stand behind our work with a 6-month warranty on all repairs.</p>
                </x-ui.card>
                
                <x-ui.card class="shadow-none border border-gray-200">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Genuine Parts</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">We use only genuine parts for all repairs to ensure quality and longevity.</p>
                </x-ui.card>
                
                <x-ui.card class="shadow-none border border-gray-200">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Fair Pricing</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Transparent and competitive pricing for all our services with no hidden costs.</p>
                </x-ui.card>

                <x-ui.card class="shadow-none border border-gray-200">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Parts Exchange</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">We handle all parts exchanges with care and transparency.</p>
                </x-ui.card>
                
                <x-ui.card class="shadow-none border border-gray-200">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Live Tracking</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Track your repair status in real-time with our online tracking system.</p>
                </x-ui.card>
                
                <x-ui.card class="shadow-none border border-gray-200">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Chip Level Repair</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Expert chip-level repair services for all electronic devices.</p>
                </x-ui.card>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl text-gray-900 font-semibold mb-4 tracking-tight">Our Location</h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Visit our service center for expert electronic repairs.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 items-start">
                <div class="w-full lg:w-3/5">
                    <div class="h-96 md:h-[450px] w-full rounded-lg overflow-hidden border border-gray-200">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d150564.7646448244!2d87.43484368044666!3d25.7571809097498!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eff97483b0bacd%3A0x2b53bef0d8594e2d!2sBalaji%20Laptop%20Service!5e0!3m2!1sen!2sin!4v1756134819001!5m2!1sen!2sin"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <div class="w-full lg:w-2/5">
                    <x-ui.card class="shadow-none border border-gray-200 p-2">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Balaji Laptop Service</h3>
                        <p class="text-gray-500 text-sm mb-8 leading-relaxed">We are located at Zila School Road, near BSNL tower in Purnea, Bihar. Our expert technicians are ready to assist you with all your electronic repair needs.</p>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="text-primary text-lg mt-0.5 mr-4 w-5 text-center">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4 class="text-gray-900 font-medium">Address</h4>
                                    <p class="text-gray-500 text-sm mt-1">Zila School Road, Near BSNL tower,<br>Purnea (Bihar) – 854301</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="text-primary text-lg mt-0.5 mr-4 w-5 text-center">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h4 class="text-gray-900 font-medium">Phone</h4>
                                    <p class="text-gray-500 text-sm mt-1">+91 7856802002</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="text-primary text-lg mt-0.5 mr-4 w-5 text-center">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h4 class="text-gray-900 font-medium">Email</h4>
                                    <p class="text-gray-500 text-sm mt-1">novafixteam@gmail.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="text-primary text-lg mt-0.5 mr-4 w-5 text-center">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h4 class="text-gray-900 font-medium">Working Hours</h4>
                                    <p class="text-gray-500 text-sm mt-1">Monday to Saturday: 10:00 AM - 7:00 PM</p>
                                    <p class="text-gray-500 text-sm">Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </section>
</div>