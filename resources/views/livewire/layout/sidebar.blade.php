<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: false);
        $this->dispatch('force-reload');
    }
}; ?>

<aside class="sm:block bg-[#111827]/95 backdrop-blur-xl border-r border-indigo-500/40 w-64 lg:w-64 md:w-16 sm:w-16 h-screen flex flex-col shadow-lg transition-all duration-300">
    <!-- Logo Area -->
    <div class="p-4 border-b border-indigo-500/40">        
        <a href="#" class="flex w-full justify-center items-center space-x-3" title="RCP">
        <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">schedule</span>
            <span class="text-xl font-semibold text-white">RCP System</span>
        <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">schedule</span>
        </a>
    </div>

    <!-- Navigation Area -->
    <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
    <div class="space-y-1">
        <a href="{{ route('users.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">person</span>
            <span class="text-xl font-semibold lg:block">Użytkownicy</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('roles.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">security</span>
            <span class="text-xl font-semibold lg:block">Role</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('positions.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">work</span>
            <span class="text-xl font-semibold lg:block">Stanowiska</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('work-time-regulations.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">schedule</span>
            <span class="text-xl font-semibold lg:block">Reg. czasu pracy</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('personels.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">person</span>
            <span class="text-xl font-semibold lg:block">Pracownicy</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('work-statuses.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">check_circle</span>
            <span class="text-xl font-semibold lg:block">Statusy obecności</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('work-sessions.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">schedule</span>
            <span class="text-xl font-semibold lg:block">Panel obecności</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('rcp-panel.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">dashboard</span>
            <span class="text-xl font-semibold lg:block">Panel RCP</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('personels.time-report') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">access_time</span>
            <span class="text-xl font-semibold lg:block">Mój czas pracy</span>
        </a>
    </div>
    <div class="space-y-1">
        <a href="{{ route('work-places.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">work</span>
            <span class="text-xl font-semibold lg:block">Miejsca pracy</span>
        </a>
    </div>
    @if(Auth::user()->role_id == 1)
    <div class="space-y-1">
        <a href="{{ route('dashboard.index') }}"
            class="flex items-center px-4 py-3 text-gray-200 rounded-lg hover:bg-indigo-600/30 transition-colors group">
            <span class="material-icons-round text-gray-300 group-hover:text-indigo-400 mr-3">admin_panel_settings</span>
            <span class="text-xl font-semibold lg:block">Panel Admin</span>
        </a>
    </div>
    @endif
       
    </nav>

    <div class="fixed bottom-0 left-0 w-full p-4 border-t border-indigo-500/40 bg-gray-900/80 backdrop-blur">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-600 to-indigo-500 flex items-center justify-center text-black lg:flex md:hidden sm:hidden">
                <span class="material-icons-round text-sm">person</span>
            </div>

            @auth
            <div class="lg:block">
                <p class="text-sm font-medium text-gray-300">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-300">{{ Auth::user()->email }}</p>
            </div>
            @endauth
        </div>

        @if (Auth::check())
        <button
            wire:click="logout"
            class="p-2 text-gray-300 hover:text-black rounded-lg hover:bg-indigo-600/30 transition-colors"
            title="Wyloguj">
            <span class="material-icons-round">logout</span>
        </button>
        @endif
    </div>
</div>

</aside>