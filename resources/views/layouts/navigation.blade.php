<nav class="bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('todos.index') }}" class="flex items-center gap-2 group">
                    <span class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center shadow-md group-hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <span class="text-lg font-bold text-slate-800 tracking-tight">TodoApp</span>
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <a href="{{ route('todos.index') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-150">
                        My Tasks
                    </a>
                    <a href="{{ route('todos.create') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-150">
                        + New Task
                    </a>
                </div>
            </div>

            {{-- User dropdown — self-contained x-data scope --}}
            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    @keydown.escape="open = false"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    <span class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold text-xs uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </span>
                    <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.outside="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-slate-200 py-1 z-50 origin-top-right">

                    <div class="px-4 py-2 border-b border-slate-100">
                        <p class="text-xs text-slate-400 font-medium">Signed in as</p>
                        <p class="text-sm text-slate-700 font-semibold truncate">{{ Auth::user()->name }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                        </svg>
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 w-full px-4 py-2 text-sm text-slate-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</nav>
