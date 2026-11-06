<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Accounting & Gaming Platform') }}</title>

    <!-- Tailwind CSS CDN (or use your Vite build setup) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full text-slate-100 flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- Header / Navigation -->
    <header class="w-full border-b border-slate-800 bg-slate-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/30">
                    S
                </div>
                <span class="font-bold text-lg tracking-tight text-white">Salakot & Accounting Hub</span>
            </div>

            <nav class="hidden md:flex items-center space-x-6 text-sm font-medium text-slate-300">
                @auth
                    <a href="{{ route('accounting.accounts.index') }}" class="hover:text-indigo-400 transition">Chart of Accounts</a>
                    <a href="{{ route('accounting.journal-entries.create') }}" class="hover:text-indigo-400 transition">Journal Entry</a>
                    <a href="{{ route('accounting.reports.trial-balance') }}" class="hover:text-indigo-400 transition">Trial Balance</a>
                    <a href="{{ route('accounting.reports.financial-statements') }}" class="hover:text-indigo-400 transition">Financial Statements</a>
                @endauth
            </nav>

            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-xs text-slate-400 hidden sm:inline">Logged in as <strong class="text-slate-200">{{ auth()->user()->name }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs px-3 py-1.5 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('google.login') }}" class="inline-flex items-center px-4 py-2 border border-slate-700 text-sm font-medium rounded-lg text-slate-200 bg-slate-900 hover:bg-slate-800 shadow-sm transition">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M23.745 12.27c-.07-.7-.63-1.27-1.34-1.27H12v4.5h6.58c-.3 1.55-1.63 4.5-6.58 4.5-3.96 0-7.2-3.24-7.2-7.2s3.24-7.2 7.2-7.2c1.92 0 3.61.73 4.88 1.92l3.39-3.39C18.25 2.1 15.31 1 12 1 5.92 1 1 5.92 1 12s4.92 11 11 11c6.35 0 10.55-4.47 10.55-10.73 0-.37-.03-.7-.1-1zm-11.74 8.73c-4.83 0-8.73-3.9-8.73-8.73S7.17 3.27 12 3.27c2.34 0 4.38.86 5.93 2.27l-3.3 3.3c-.8-.68-1.89-1.07-2.63-1.07-2.48 0-4.5 2.02-4.5 4.5s2.02 4.5 4.5 4.5c2.25 0 3.75-1.25 4.15-3H12v-4.5h9.46c.11.59.18 1.25.18 1.97 0 5.48-3.69 9.28-9.18 9.28z"/>
                        </svg>
                        Sign in with Google
                    </a href>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                Financial Clarity & <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Precision Bookkeeping</span>
            </h1>
            <p class="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10">
                Manage your chart of accounts, record double-entry journal postings, verify trial balances, and generate instant financial reports effortlessly.
            </p>

            @auth
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('accounting.journal-entries.create') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl shadow-lg shadow-indigo-600/30 transition">
                        + New Journal Entry
                    </a>
                    <a href="{{ route('accounting.reports.financial-statements') }}" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold rounded-xl border border-slate-700 transition">
                        View Financial Statements
                    </a>
                </div>
            @else
                <div class="flex justify-center">
                    <a href="{{ route('google.login') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl shadow-xl shadow-indigo-600/30 flex items-center space-x-3 transition">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#ffffff" d="M23.745 12.27c-.07-.7-.63-1.27-1.34-1.27H12v4.5h6.58c-.3 1.55-1.63 4.5-6.58 4.5-3.96 0-7.2-3.24-7.2-7.2s3.24-7.2 7.2-7.2c1.92 0 3.61.73 4.88 1.92l3.39-3.39C18.25 2.1 15.31 1 12 1 5.92 1 1 5.92 1 12s4.92 11 11 11c6.35 0 10.55-4.47 10.55-10.73 0-.37-.03-.7-.1-1zm-11.74 8.73c-4.83 0-8.73-3.9-8.73-8.73S7.17 3.27 12 3.27c2.34 0 4.38.86 5.93 2.27l-3.3 3.3c-.8-.68-1.89-1.07-2.63-1.07-2.48 0-4.5 2.02-4.5 4.5s2.02 4.5 4.5 4.5c2.25 0 3.75-1.25 4.15-3H12v-4.5h9.46c.11.59.18 1.25.18 1.97 0 5.48-3.69 9.28-9.18 9.28z"/>
                        </svg>
                        <span>Get Started with Google</span>
                    </a>
                </div>
            @endauth
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-800 py-6 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Salakot Agriventures Philippines Corporation & Milarie Accounting Software. All rights reserved.</p>
    </footer>

</body>
</html>