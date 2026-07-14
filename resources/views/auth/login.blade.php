<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Glaciar Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-blob {
            animation: blob 10s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        .input-floating:focus-within label,
        .input-floating input:not(:placeholder-shown) + label {
            transform: translateY(-120%) scale(0.85);
            color: #3b82f6;
        }
        .stagger-1 { animation-delay: 100ms; }
        .stagger-2 { animation-delay: 200ms; }
        .stagger-3 { animation-delay: 300ms; }
        .stagger-4 { animation-delay: 400ms; }
        .stagger-5 { animation-delay: 500ms; }
        
        /* Smooth gradient for the button */
        .btn-gradient {
            background-size: 200% 200%;
            background-image: linear-gradient(to right, #0f172a, #1e293b, #0f172a);
            transition: background-position 0.5s ease;
        }
        .btn-gradient:hover {
            background-position: 100% 0;
        }
    </style>
</head>
<body class="relative bg-slate-50 h-screen flex items-center justify-center font-sans antialiased overflow-hidden selection:bg-glaciar-accent selection:text-white">

    <!-- Background Animated Blobs -->
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-blue-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-[400px] h-[400px] bg-cyan-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-[600px] h-[600px] bg-sky-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Glassmorphic Card -->
    <div class="relative z-10 w-full max-w-md px-6 animate-slide-up opacity-0">
        <div class="backdrop-blur-2xl bg-white/70 border border-white/60 p-10 rounded-[2rem] shadow-[0_8px_40px_rgba(0,0,0,0.06)] relative overflow-hidden group">
            
            <!-- Subtle card shine effect -->
            <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/40 to-transparent group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none z-0"></div>

            <!-- Logo Section -->
            <div class="relative z-10 text-center mb-10 animate-slide-up opacity-0 stagger-1">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-glaciar-accent to-cyan-400 shadow-[0_0_30px_rgba(59,130,246,0.4)] mb-6 text-white transform transition-transform duration-500 hover:scale-105 hover:rotate-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S12 3 12 3s-4.5 4.97-4.5 9 2.015 9 4.5 9zm0 0c1.38 0 2.5-1.79 2.5-4s-1.12-4-2.5-4-2.5 1.79-2.5 4 1.12 4 2.5 4z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-glaciar-black tracking-tight">GLACIAR</h1>
                <p class="text-glaciar-gray-500 text-sm mt-1 tracking-widest uppercase font-medium">Enterprise Admin</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="relative z-10 space-y-6">
                @csrf

                <!-- Email Input -->
                <div class="relative input-floating animate-slide-up opacity-0 stagger-2">
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder=" "
                        class="block w-full px-5 py-4 bg-white/60 border border-gray-200 rounded-xl text-glaciar-black focus:outline-none focus:ring-2 focus:ring-glaciar-accent/30 focus:border-glaciar-accent transition-all duration-300 shadow-sm backdrop-blur-md peer"
                        required autofocus>
                    <label for="email" class="absolute left-5 top-4 text-gray-400 text-sm transition-all duration-300 pointer-events-none origin-left font-medium">Email Address</label>
                    @error('email') <p class="text-red-500 text-xs mt-2 absolute -bottom-5 left-0">{{ $message }}</p> @enderror
                </div>

                <!-- Password Input -->
                <div class="relative input-floating animate-slide-up opacity-0 stagger-3">
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder=" "
                        class="block w-full px-5 py-4 bg-white/60 border border-gray-200 rounded-xl text-glaciar-black focus:outline-none focus:ring-2 focus:ring-glaciar-accent/30 focus:border-glaciar-accent transition-all duration-300 shadow-sm backdrop-blur-md peer"
                        required>
                    <label for="password" class="absolute left-5 top-4 text-gray-400 text-sm transition-all duration-300 pointer-events-none origin-left font-medium">Password</label>
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between animate-slide-up opacity-0 stagger-4 pt-2">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="w-4 h-4 text-glaciar-accent bg-white border-gray-300 rounded focus:ring-glaciar-accent focus:ring-offset-1 transition-colors cursor-pointer" name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none font-medium hover:text-glaciar-black transition-colors">Remember me</label>
                    </div>
                    <a href="#" class="text-sm font-semibold text-glaciar-accent hover:text-glaciar-accent-dark transition-colors">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <div class="animate-slide-up opacity-0 stagger-5 pt-4">
                    <button type="submit" class="group relative w-full flex justify-center py-4 px-4 btn-gradient text-white font-bold rounded-xl shadow-[0_10px_20px_-10px_rgba(15,23,42,0.5)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-glaciar-black transition-all duration-300 overflow-hidden transform hover:-translate-y-0.5">
                        <span class="relative flex items-center gap-2 tracking-wide text-sm uppercase">
                            Sign In to Dashboard
                            <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </button>
                </div>
            </form>

            <div class="relative z-10 mt-8 text-center animate-slide-up opacity-0 stagger-5">
                <p class="text-sm text-gray-500 font-medium">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-glaciar-accent hover:text-glaciar-accent-dark transition-colors ml-1">Register here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>