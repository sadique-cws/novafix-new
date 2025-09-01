
  
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #111827;
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
        
        .training-card {
            transition: all 0.3s ease;
            border: 1px solid #E5E7EB;
        }
        
        .training-card:hover {
            border-color: #3B82F6;
            transform: translateY(-5px);
        }
        
        .device-icon {
            transition: all 0.3s ease;
            filter: grayscale(70%);
        }
        
        .device-icon:hover {
            filter: grayscale(0%);
            transform: scale(1.1);
        }
    </style>
<div class="bg-background">
    <!-- IT Repair Training Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl text-gray-800 mb-4 section-title">IT Repair Training Program</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Looking to start a career in IT repairing service? Our comprehensive training program will provide you with the skills and knowledge needed to succeed</p>
            </div>

            <div class="flex flex-col lg:flex-row items-center justify-between gap-10 mb-16">
                <div class="lg:w-1/2">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl text-gray-800 mb-6">Advanced Chip Level Training In</h1>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 mb-8">
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('laptop.jpeg') }}" alt="Laptop Training" class="h-16 device-icon mb-2">
                            <span class="text-sm text-gray-600">Laptop</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('desktop.jpeg') }}" alt="Desktop Training" class="h-16 device-icon mb-2">
                            <span class="text-sm text-gray-600">Desktop</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('printer.jpeg') }}" alt="Printer Training" class="h-16 device-icon mb-2">
                            <span class="text-sm text-gray-600">Printer</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('mobile.jpeg') }}" alt="Mobile Training" class="h-16 device-icon mb-2">
                            <span class="text-sm text-gray-600">Mobile</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('lcd.jpeg') }}" alt="LCD Training" class="h-16 device-icon mb-2">
                            <span class="text-sm text-gray-600">LCD TV</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('tab.jpeg') }}" alt="Tablet Training" class="h-16 device-icon mb-2">
                            <span class="text-sm text-gray-600">Tablet</span>
                        </div>
                    </div>
                    
                    <a href="#enroll" class="bg-primary text-white px-6 py-3 rounded-md hover:bg-blue-800 transition inline-block">Enroll Now</a>
                </div>
                
                <div class="lg:w-1/2 flex justify-center">
                    <img src="{{ asset('itRepair.jpeg') }}" alt="IT Repair Training" class="rounded-lg w-full max-w-md">
                </div>
            </div>
            
            <!-- Training Modules -->
            <div class="bg-gray-50 p-8 rounded-lg border border-gray-200 mb-16">
                <h3 class="text-2xl text-gray-800 mb-6 text-center">Training Modules</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="training-card bg-white p-6 rounded-lg">
                        <div class="text-primary text-2xl mb-3">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4 class="text-lg text-gray-800 mb-2">Basic Electronics</h4>
                        <p class="text-gray-600">Learn the fundamentals of electronics that form the foundation of all device repair.</p>
                    </div>
                    
                    <div class="training-card bg-white p-6 rounded-lg">
                        <div class="text-primary text-2xl mb-3">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4 class="text-lg text-gray-800 mb-2">Practical Use Of Tools</h4>
                        <p class="text-gray-600">Hands-on training with professional repair tools and equipment.</p>
                    </div>
                    
                    <div class="training-card bg-white p-6 rounded-lg">
                        <div class="text-primary text-2xl mb-3">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h4 class="text-lg text-gray-800 mb-2">Chip Level Training</h4>
                        <p class="text-gray-600">Advanced training in micro-level component repair and replacement.</p>
                    </div>
                    
                    <div class="training-card bg-white p-6 rounded-lg">
                        <div class="text-primary text-2xl mb-3">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h4 class="text-lg text-gray-800 mb-2">Parts & Technology</h4>
                        <p class="text-gray-600">Understanding different components and evolving technology in devices.</p>
                    </div>
                    
                    <div class="training-card bg-white p-6 rounded-lg">
                        <div class="text-primary text-2xl mb-3">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <h4 class="text-lg text-gray-800 mb-2">Hardware Training</h4>
                        <p class="text-gray-600">Comprehensive hardware troubleshooting and repair techniques.</p>
                    </div>
                    
                    <div class="training-card bg-white p-6 rounded-lg">
                        <div class="text-primary text-2xl mb-3">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4 class="text-lg text-gray-800 mb-2">Software Installation</h4>
                        <p class="text-gray-600">OS installation, driver setup, and software troubleshooting.</p>
                    </div>
                    
                    <div class="training-card bg-white p-6 rounded-lg">
                        <div class="text-primary text-2xl mb-3">
                            <i class="fas fa-search"></i>
                        </div>
                        <h4 class="text-lg text-gray-800 mb-2">Fault Finding</h4>
                        <p class="text-gray-600">Systematic approaches to diagnose and identify device issues.</p>
                    </div>
                    
                    <div class="training-card bg-white p-6 rounded-lg">
                        <div class="text-primary text-2xl mb-3">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <h4 class="text-lg text-gray-800 mb-2">Repair Techniques</h4>
                        <p class="text-gray-600">Professional repair methodologies for various device problems.</p>
                    </div>
                </div>
            </div>
            
            <!-- Why Choose Our Training -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl text-gray-800 mb-4 section-title">Why Choose Our Training?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We provide comprehensive IT repair training with a focus on practical skills and career development</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                <div class="training-card bg-white p-6 rounded-lg">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="text-xl text-gray-800 mb-2">Expert Instructors</h3>
                    <p class="text-gray-600">Learn from industry professionals with years of practical experience.</p>
                </div>
                
                <div class="training-card bg-white p-6 rounded-lg">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="text-xl text-gray-800 mb-2">Hands-on Practice</h3>
                    <p class="text-gray-600">Get practical experience with real devices and repair scenarios.</p>
                </div>
                
                <div class="training-card bg-white p-6 rounded-lg">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="text-xl text-gray-800 mb-2">Certification</h3>
                    <p class="text-gray-600">Receive a recognized certification upon completion of the course.</p>
                </div>
                
                <div class="training-card bg-white p-6 rounded-lg">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="text-xl text-gray-800 mb-2">Career Support</h3>
                    <p class="text-gray-600">Get assistance with job placement and starting your own repair business.</p>
                </div>
                
                <div class="training-card bg-white p-6 rounded-lg">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="text-xl text-gray-800 mb-2">Modern Equipment</h3>
                    <p class="text-gray-600">Train with the latest tools and diagnostic equipment used in the industry.</p>
                </div>
                
                <div class="training-card bg-white p-6 rounded-lg">
                    <div class="text-primary text-3xl mb-4">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="text-xl text-gray-800 mb-2">Workshop Access</h3>
                    <p class="text-gray-600">Access to our fully-equipped workshop even after course completion.</p>
                </div>
            </div>
            
            <!-- Final CTA -->
            <div class="bg-primary text-white p-8 rounded-lg text-center">
                <h2 class="text-2xl md:text-3xl mb-4">We Provide The Best Service & Training</h2>
                <p class="mb-6 max-w-2xl mx-auto">Join our advanced chip level training program and become part of a community of IT repairing service experts who are passionate about delivering top quality repair services.</p>
                <a href="#enroll" class="bg-white text-primary px-8 py-3 rounded-md hover:bg-gray-100 transition inline-block">Start Your IT Career Today</a>
            </div>
        </div>
    </section>
    
