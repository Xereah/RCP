<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('work-sessions.index', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
    <!-- Animated Manufacturing Background Elements -->
    <div class="absolute inset-0">
        <!-- Gear animations -->
        <div class="absolute top-20 left-10 w-16 h-16 opacity-20">
            <div class="w-full h-full border-4 border-green-500 rounded-full animate-spin-slow"
                style="animation-duration: 8s;">
                <div class="absolute inset-2 border-2 border-green-400 rounded-full">
                    <div class="absolute inset-1 bg-green-500 rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-32 right-16 w-12 h-12 opacity-20">
            <div class="w-full h-full border-3 border-blue-500 rounded-full animate-spin-slow"
                style="animation-duration: 6s; animation-direction: reverse;">
                <div class="absolute inset-1 border-2 border-blue-400 rounded-full">
                    <div class="absolute inset-1 bg-blue-500 rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="absolute top-1/3 right-1/4 w-20 h-20 opacity-15">
            <div class="w-full h-full border-4 border-emerald-500 rounded-full animate-spin-slow"
                style="animation-duration: 10s;">
                <div class="absolute inset-2 border-2 border-emerald-400 rounded-full">
                    <div class="absolute inset-1 bg-emerald-500 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Grid pattern overlay -->
        <div class="absolute inset-0 opacity-10"
            style="background-image: linear-gradient(rgba(249,115,22,.3) 1px, transparent 1px), linear-gradient(90deg, rgba(249,115,22,.3) 1px, transparent 1px); background-size: 50px 50px;">
        </div>

        <!-- Subtle circuit pattern -->
        <div class="absolute top-0 left-0 w-full h-full opacity-15">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0,20 Q20,20 20,40 T60,40 Q80,40 80,60 T100,60" stroke="currentColor" stroke-width="0.5"
                    fill="none" class="text-green-400" />
                <path d="M0,60 Q20,60 20,80 T60,80 Q80,80 80,20 T100,20" stroke="currentColor" stroke-width="0.5"
                    fill="none" class="text-blue-400" />
            </svg>
        </div>

        <!-- Gradient orbs -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-green-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
        <!-- Login Card -->
        <div class="w-full max-w-md">
            <!-- Company Logo/Header -->
            <div class="text-center mb-8 animate-fade-in">
                <div class="flex items-center justify-center gap-4">
                    <!-- Ikona -->
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 rounded-2xl shadow-lg shadow-green-600/50">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                        </svg>
                    </div>

                    <!-- Tekst -->
                    <div class="text-left">
                        <h1 class="text-3xl font-bold text-white mb-1">{{ $appname }}</h1>
                        <h2 class="text-xl font-semibold text-green-400 mb-1">RCP Panel</h2>
                        <p class="text-slate-300 text-sm">Rejestracja Czasu Pracy</p>
                    </div>
                </div>
            </div>


            <!-- Login Form Card -->
            <div
                class="bg-slate-800/90 backdrop-blur-md rounded-2xl p-8 shadow-2xl border border-slate-700/50 animate-slide-up">
                <form wire:submit="login" class="space-y-6">
                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-slate-200">
                            Adres e-mail
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <input wire:model="form.email" id="email" type="email" required autofocus
                                autocomplete="username"
                                class="block w-full pl-10 pr-3 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                placeholder="your.email@company.com" />
                        </div>
                        @error('form.email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-slate-200">
                            Hasło
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input wire:model="form.password" id="password" type="password" required
                                autocomplete="current-password"
                                class="block w-full pl-10 pr-3 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                placeholder="Enter your password" />
                        </div>
                        @error('form.password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input wire:model="form.remember" id="remember" type="checkbox"
                                class="h-4 w-4 text-green-500 focus:ring-green-500 border-slate-600 rounded bg-slate-700" />
                            <label for="remember" class="ml-2 block text-sm text-slate-300">
                                Zapamiętaj mnie
                            </label>
                        </div>
                        <a href="#" class="text-sm text-green-400 hover:text-green-300 transition-colors">
                            Zapomniałem hasła?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 focus:ring-offset-slate-800 transition-all duration-200 transform hover:scale-[1.02] shadow-lg shadow-green-500/30 hover:shadow-xl hover:shadow-green-500/40">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Zaloguj się do systemu
                    </button>
                </form>

                <!-- Additional Info -->
                <div class="mt-8 pt-6 border-t border-slate-700">
                    <div class="text-center">
                        <p class="text-xs text-slate-400 mb-2">
                            Wersja aplikacji: <span class="text-green-400 font-medium">{{ $appversion }}</span>
                        </p>
                        <div class="flex items-center justify-center space-x-4 text-xs text-slate-500">
                            <span>Środowisko produkcyjne</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-6 text-center">
                <p class="text-xs text-slate-400">
                    © {{ date('Y') }} WBG Łódź Wszelkie prawa zastrzeżone.
                </p>
            </div>
        </div>
    </div>

    <!-- Floating Action Indicators -->
    <div class="absolute bottom-6 left-6 flex space-x-2">
        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse shadow-lg shadow-green-500/50"></div>
        <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse shadow-lg shadow-blue-500/50" style="animation-delay: 0.5s;"></div>
        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse shadow-lg shadow-emerald-500/50" style="animation-delay: 1s;"></div>
    </div>

    <style>
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-spin-slow {
        animation: spin-slow linear infinite;
    }

    .animate-fade-in {
        animation: fade-in 0.8s ease-out;
    }

    .animate-slide-up {
        animation: slide-up 0.6s ease-out 0.2s both;
    }
    </style>
</div>