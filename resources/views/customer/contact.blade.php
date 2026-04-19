@extends('layouts.customer')

@section('content')
    <div class="bg-glaciar-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-4xl font-extrabold text-glaciar-black mb-4">Contact Us</h1>
                <p class="text-xl text-glaciar-gray-600">
                    Have a question about our water, looking to set up a corporate account, or need help with a delivery? We're here for you.
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 max-w-5xl mx-auto">
                
                <!-- Contact Info -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-glaciar-gray-100">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-glaciar-black mb-2">Phone</h3>
                        <p class="text-glaciar-gray-600 mb-4">+94 11 234 5678</p>
                        <p class="text-sm text-glaciar-gray-500">Mon-Fri from 8am to 6pm</p>
                    </div>
                    
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-glaciar-gray-100">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-glaciar-black mb-2">Email</h3>
                        <p class="text-glaciar-gray-600 mb-4">hello@glaciarwater.com</p>
                        <p class="text-sm text-glaciar-gray-500">We aim to reply within 24 hours</p>
                    </div>
                    
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-glaciar-gray-100">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-glaciar-black mb-2">Headquarters</h3>
                        <p class="text-glaciar-gray-600">123 Aqua Way<br>Colombo 03<br>Sri Lanka</p>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-glaciar-gray-100">
                        <h2 class="text-2xl font-bold text-glaciar-black mb-8">Send us a message</h2>
                        
                        <form action="#" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-glaciar-gray-700">First name</label>
                                    <input type="text" name="first_name" id="first_name" class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-glaciar-gray-700">Last name</label>
                                    <input type="text" name="last_name" id="last_name" class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                                </div>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-glaciar-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-medium text-glaciar-gray-700">Subject</label>
                                <select id="subject" name="subject" class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black">
                                    <option>General Inquiry</option>
                                    <option>New Delivery Setup</option>
                                    <option>Existing Order Issue</option>
                                    <option>Corporate Account</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-glaciar-gray-700">Message</label>
                                <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-md border-glaciar-gray-300 shadow-sm focus:border-glaciar-black focus:ring-glaciar-black"></textarea>
                            </div>
                            
                            <div>
                                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-glaciar-black hover:bg-glaciar-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
