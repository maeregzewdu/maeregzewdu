<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Maereg Zewdu</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Russo+One&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        h1, h2, h3, h4, h5, h6, a, button {
            font-family: 'Russo One', sans-serif;
        }
        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(245, 208, 97, 0.1), transparent 50%),
                        linear-gradient(45deg, #0F172A, #1E293B);
        }
        .gradient-text {
            background: linear-gradient(45deg, #F5D061, #FFB800, #F5D061);
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="bg-[#0F172A] text-white hero-gradient min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <img src="/images/logo/gold-logo.svg" alt="Maereg Zewdu Logo" class="w-[180px] mx-auto hover:opacity-90 transition-opacity mb-6">
                </a>
                <h1 class="text-3xl font-russo mb-2">Welcome Back</h1>
                <p class="text-gray-400">Login to access your dashboard</p>
            </div>
            
            <!-- Login Form -->
            <div class="glass-card rounded-2xl p-8 relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute -z-10 top-0 right-0 w-64 h-64 bg-[#F5D061]/5 rounded-full blur-[100px] animate-pulse-slow"></div>
                <div class="absolute -z-10 bottom-0 left-0 w-64 h-64 bg-[#F5D061]/5 rounded-full blur-[100px] animate-pulse-slow"></div>
                
                @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 mb-6">
                    <ul class="list-disc list-inside text-sm text-red-200">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-gray-200 mb-2 text-sm font-semibold">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            class="w-full bg-[#1A2332]/70 backdrop-blur-md border border-white/10 rounded-lg px-4 py-3.5 focus:border-[#F5D061]/50 focus:outline-none focus:ring-2 focus:ring-[#F5D061]/20 transition-all placeholder:text-gray-500 text-white"
                            placeholder="your@email.com">
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-gray-200 text-sm font-semibold">Password</label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#F5D061] hover:underline">Forgot Password?</a>
                            @endif
                        </div>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                            class="w-full bg-[#1A2332]/70 backdrop-blur-md border border-white/10 rounded-lg px-4 py-3.5 focus:border-[#F5D061]/50 focus:outline-none focus:ring-2 focus:ring-[#F5D061]/20 transition-all placeholder:text-gray-500 text-white"
                            placeholder="••••••••">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 bg-[#1A2332] border border-white/20 rounded focus:ring-[#F5D061] text-[#F5D061]">
                        <label for="remember" class="ml-2 text-sm text-gray-300">Remember me</label>
                    </div>
                    
                    <div>
                        <button type="submit"
                            class="w-full cursor-pointer bg-gradient-to-r from-[#F5D061] to-[#e9b730] text-black px-6 py-4 rounded-xl font-russo text-lg hover:from-[#e9b730] hover:to-[#F5D061] transition-all duration-300 shadow-lg shadow-[#F5D061]/20 flex items-center justify-center transform hover:-translate-y-1 hover:shadow-xl hover:shadow-[#F5D061]/30">
                            <span class="flex items-center">
                                Login
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Back to site link -->
            <div class="text-center mt-8">
                <a href="/" class="text-gray-300 hover:text-white text-sm flex items-center justify-center gap-1 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to home
                </a>
            </div>
        </div>
    </div>
    
    <!-- Add floating decoration element -->
    <div class="fixed -bottom-24 -right-24 w-96 h-96 bg-[#F5D061]/5 rounded-full blur-[120px] animate-pulse-slow"></div>
    <div class="fixed -top-24 -left-24 w-96 h-96 bg-[#F5D061]/5 rounded-full blur-[120px] animate-pulse-slow"></div>
</body>

</html> 