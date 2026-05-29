<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizApp - Uji Pengetahuanmu</title>
    <meta name="description" content="Aplikasi Quiz interaktif dan modern. Uji pengetahuanmu sekarang!">
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,0.2) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,0.2) 0, transparent 50%);
            color: #f8fafc;
            min-height: 100vh;
        }
        .glass-panel {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 1);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(71, 85, 105, 0.5);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.8);
        }
    </style>
</head>
<body class="antialiased selection:bg-indigo-500 selection:text-white flex flex-col">
    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center font-bold text-xl shadow-lg shadow-indigo-500/20 text-white">Q</div>
                    <a href="{{ route('home') }}" class="font-bold text-2xl tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300 hover:opacity-80 transition-opacity">QuizApp</a>
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('quiz.setup.page') }}" class="text-sm font-semibold text-slate-300 hover:text-white hover:underline underline-offset-8 decoration-2 decoration-indigo-500 transition-all duration-300">Mainkan Quiz</a>
                    <a href="{{ route('history.index') }}" class="text-sm font-semibold text-slate-300 hover:text-white hover:underline underline-offset-8 decoration-2 decoration-purple-500 transition-all duration-300">Riwayat</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow flex flex-col justify-center">
        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm font-medium flex items-center gap-3 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-auto py-6 text-center text-slate-500 text-sm font-medium border-t border-white/5">
        &copy; {{ date('Y') }} QuizApp.
    </footer>
</body>
</html>
