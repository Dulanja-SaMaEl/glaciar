<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Glaciar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans antialiased text-glaciar-black py-10">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-black p-6 text-center">
            <h1 class="text-2xl font-extrabold text-white tracking-widest uppercase">Glaciar</h1>
            <p class="text-gray-400 text-xs mt-1 uppercase tracking-wide">Join the experience</p>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase">Full Name</label>
                    <input class="w-full px-3 py-3 border border-gray-300 rounded focus:outline-none focus:border-black"
                        type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase">Email Address</label>
                    <input class="w-full px-3 py-3 border border-gray-300 rounded focus:outline-none focus:border-black"
                        type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase">Password</label>
                    <input class="w-full px-3 py-3 border border-gray-300 rounded focus:outline-none focus:border-black"
                        type="password" name="password" required>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-xs font-bold mb-2 uppercase">Confirm Password</label>
                    <input class="w-full px-3 py-3 border border-gray-300 rounded focus:outline-none focus:border-black"
                        type="password" name="password_confirmation" required>
                </div>

                <button
                    class="w-full bg-black text-white font-bold py-3 px-4 rounded hover:bg-gray-800 transition-colors uppercase tracking-wider text-sm"
                    type="submit">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-bold text-black hover:underline">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>