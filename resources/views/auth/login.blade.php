<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Glaciar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 h-screen flex items-center justify-center font-sans antialiased text-glaciar-black">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <!-- Minimal Header -->
        <div class="bg-black p-8 text-center">
            <h1 class="text-3xl font-extrabold text-white tracking-widest uppercase">Glaciar</h1>
            <p class="text-gray-400 text-xs mt-2 uppercase tracking-wide">Pure. Simple. Delivered.</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            <h2 class="text-xl font-bold mb-6 text-center">Sign In</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wider"
                        for="email">Email</label>
                    <input
                        class="w-full px-3 py-3 border border-gray-300 rounded focus:outline-none focus:border-black transition-colors"
                        id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com"
                        required autofocus>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wider"
                        for="password">Password</label>
                    <input
                        class="w-full px-3 py-3 border border-gray-300 rounded focus:outline-none focus:border-black transition-colors"
                        id="password" type="password" name="password" placeholder="••••••••" required>
                </div>

                <!-- Button -->
                <button
                    class="w-full bg-black text-white font-bold py-3 px-4 rounded hover:bg-gray-800 transition-colors uppercase tracking-wider text-sm"
                    type="submit">
                    Sign In
                </button>
            </form>

            <div class="mt-6 flex justify-between text-sm text-gray-500">
                <a href="{{ route('register') }}" class="hover:text-black underline">Create Account</a>
                <a href="#" class="hover:text-black">Forgot Password?</a>
            </div>
        </div>
    </div>
</body>

</html>