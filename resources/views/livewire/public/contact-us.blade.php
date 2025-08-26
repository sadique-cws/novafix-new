
<div class="bg-gray-50 min-h-screen">
   

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <!-- Page Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-primary mb-4">Get in Touch With Us</h1>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                Have questions or want to learn more about our services? We're here to help and would love to hear from you.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-dark mb-6">Send us a Message</h2>
                
                @if(session()->has('success'))
                    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-start">
                        <div class="mr-3 mt-1">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="save" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition">
                            @error('name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2 font-medium">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition">
                            @error('phone') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Company</label>
                        <input type="text" wire:model="company" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" wire:model="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        @error('email') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Subject <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        @error('subject') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2 font-medium">Message <span class="text-red-500">*</span></label>
                        <textarea wire:model="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"></textarea>
                        @error('message') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                 =  <div>
                        <label class="block text-gray-700 mb-2 font-medium">How Did You Here About Us <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="about_us" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        @error('about_us') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary text-white rounded-lg font-medium hover:bg-secondary transition duration-300 flex items-center justify-center">
                        <span>Send Message</span>
                        <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-dark mb-6">Contact Information</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-primary/10 p-3 rounded-full mr-4">
                                <i class="fas fa-phone text-primary text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-dark">Services Helpline</h4>
                                <p class="text-gray-600 mt-1">+91 7856802002</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-primary/10 p-3 rounded-full mr-4">
                                <i class="fas fa-graduation-cap text-primary text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-dark">Training Inquiry</h4>
                                <p class="text-gray-600 mt-1">+91 7856802002</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-primary/10 p-3 rounded-full mr-4">
                                <i class="fas fa-envelope text-primary text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-dark">Email Us</h4>
                                <p class="text-gray-600 mt-1">info@companyname.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-primary/10 p-3 rounded-full mr-4">
                                <i class="fas fa-map-marker-alt text-primary text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-dark">Visit Us</h4>
                                <p class="text-gray-600 mt-1">
                                    Zila School Road, Near BSNL Tower,<br>
                                    Purnea (Bihar) - 854301
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h4 class="font-medium text-dark mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-gray-100 p-3 rounded-full text-gray-600 hover:bg-primary hover:text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="bg-gray-100 p-3 rounded-full text-gray-600 hover:bg-primary hover:text-white transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="bg-gray-100 p-3 rounded-full text-gray-600 hover:bg-primary hover:text-white transition">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="bg-gray-100 p-3 rounded-full text-gray-600 hover:bg-primary hover:text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-accent/10 rounded-2xl p-8 border border-accent/20">
                    <div class="flex items-start">
                        <div class="bg-accent/20 p-3 rounded-full mr-4">
                            <i class="fas fa-lightbulb text-accent text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-dark">Looking for customized solutions?</h3>
                            <p class="text-gray-600 mt-2">
                                We understand that every business has unique needs. Contact us for tailored services and training programs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Map Section -->
    <section class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="h-96 w-full bg-gray-200 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-3"></i>
                    <p class="text-gray-500">Interactive Map Would Appear Here</p>
                </div>
            </div>
        </div>
    </section>
</div>

    
