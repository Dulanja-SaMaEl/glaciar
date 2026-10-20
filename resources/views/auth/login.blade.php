<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — GLACIAR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-glaciar-obsidian text-white min-h-screen flex items-center justify-center font-sans antialiased p-6 relative overflow-hidden">

    <!-- Ambient background glow -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-glaciar-ice/10 rounded-full blur-[140px]"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-3 group">
                <svg class="w-7 h-7 text-cyan-400 group-hover:text-cyan-300 transition-colors" viewBox="0 0 32 22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 20L11 5L19 20" />
                    <path d="M15 20L21 9L29 20" />
                </svg>
                <span class="text-2xl font-black tracking-widest text-white uppercase group-hover:text-cyan-300 transition-colors">GLACIAR</span>
            </a>
            <p class="text-xs font-mono uppercase tracking-widest text-slate-400">
                Client Access Portal
            </p>
        </div>

        <!-- Auth Card -->
        <div class="bg-white/[0.04] backdrop-blur-xl border border-white/10 p-8 sm:p-10 rounded-3xl shadow-2xl">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-mono uppercase tracking-wider text-slate-300 mb-1.5 font-semibold">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3.5 text-xs text-white placeholder-slate-500 font-mono focus:outline-none focus:border-glaciar-ice focus:ring-1 focus:ring-glaciar-ice transition-colors"
                           placeholder="name@example.com">
                    @error('email') <p class="text-red-400 text-[11px] mt-1.5 font-mono">{{ $message }}</p> @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-mono uppercase tracking-wider text-slate-300 font-semibold">Password</label>
                    </div>
                    <input id="password" type="password" name="password" required
                           class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3.5 text-xs text-white placeholder-slate-500 font-mono focus:outline-none focus:border-glaciar-ice focus:ring-1 focus:ring-glaciar-ice transition-colors"
                           placeholder="••••••••">
                    @error('password') <p class="text-red-400 text-[11px] mt-1.5 font-mono">{{ $message }}</p> @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-400">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded bg-white/5 border-white/20 text-glaciar-ice focus:ring-glaciar-ice">
                        <span>Remember credentials</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-4 px-6 bg-white hover:bg-glaciar-ice text-glaciar-obsidian font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 shadow-xl mt-4">
                    Sign In
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/10 text-center text-xs text-slate-400">
                <span>New to Glaciar?</span>
                <a href="{{ route('register') }}" class="font-bold text-glaciar-ice hover:underline ml-1">Create Account</a>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-xs font-mono text-slate-500 hover:text-slate-300 transition-colors uppercase tracking-wider">
                &larr; Return to Homepage
            </a>
        </div>

    </div>
</body>
</html>
