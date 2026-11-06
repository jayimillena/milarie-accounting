<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Accounting Hub') }}</title>

    <!-- Tailwind CSS CDN (or use your Vite build setup) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js (included automatically if using Livewire v3, or add script) -->
    @livewireStyles
</head>
<body class="h-full flex flex-col justify-between selection:bg-indigo-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Brand & Nav Links -->
                <div class="flex items-center space-x-8">
                    <div class="flex-shrink-0 flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white shadow">
                            S
                        </div>
                        <a href="{{ route('accounting.dashboard') }}" class="font-bold text-lg text-gray-900 tracking-tight">Accounting Hub</a>
                    </div>

                    <!-- Desktop Nav Links -->
                    <div class="hidden md:flex space-x-4 text-sm font-medium">
                        <a href="{{ route('accounting.dashboard') }}" class="{{ request()->routeIs('accounting.dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} py-2 transition">Dashboard</a>
                        <a href="{{ route('accounting.accounts.index') }}" class="{{ request()->routeIs('accounting.accounts.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} py-2 transition">Chart of Accounts</a>
                        <a href="{{ route('accounting.journal-entries.create') }}" class="{{ request()->routeIs('accounting.journal-entries.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} py-2 transition">Journal Entry</a>
                        <a href="{{ route('accounting.ledger') }}" class="{{ request()->routeIs('accounting.reports.financial-statements') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} py-2 transition">Account Ledger</a>
                        <a href="{{ route('accounting.reports.trial-balance') }}" class="{{ request()->routeIs('accounting.reports.trial-balance') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} py-2 transition">Trial Balance</a>
                        <a href="{{ route('accounting.reports.financial-statements') }}" class="{{ request()->routeIs('accounting.reports.financial-statements') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} py-2 transition">Financial Statements</a>
                    </div>
                </div>

                <!-- User Profile & Logout -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <span class="text-xs text-gray-500">Hello, <strong class="text-gray-800">{{ auth()->user()->name }}</strong></span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs px-3 py-1.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition">Logout</button>
                        </form>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" class="md:hidden bg-white border-b border-gray-200 px-4 pt-2 pb-4 space-y-2">
            <a href="{{ route('accounting.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Dashboard</a>
            <a href="{{ route('accounting.accounts.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Chart of Accounts</a>
            <a href="{{ route('accounting.journal-entries.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Journal Entry</a>
            <a href="{{ route('accounting.reports.trial-balance') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Trial Balance</a>
            <a href="{{ route('accounting.reports.financial-statements') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Financial Statements</a>
            @auth
                <div class="pt-4 border-t border-gray-200 flex justify-between items-center px-3">
                    <span class="text-xs text-gray-500">{{ auth()->user()->email }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs px-3 py-1 rounded bg-gray-100 text-gray-700">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500">
        <p>&copy; {{ date('Y') }} Salakot Agriventures & Accounting Platform. Built with Laravel Livewire & Tailwind CSS.</p>
    </footer>

    @livewireScripts
</body>
</html>