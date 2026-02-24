<aside 
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out shadow-lg"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-gradient-to-r from-indigo-600 to-indigo-700">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span class="text-base font-bold text-white block leading-tight">
                    SUBARU
                </span>
                <span class="text-xs text-indigo-100 block">Work System</span>
            </div>
        </div>
        <button @click="sidebarOpen = false" 
                class="lg:hidden p-1.5 rounded-md text-white/80 hover:text-white hover:bg-white/20 focus:outline-none transition-colors"
                aria-label="Close sidebar">uyh78
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Menu -->
    <nav class="px-3 py-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <div class="flex-1">
                <div class="font-medium">ダッシュボード</div>
                <div class="text-xs {{ request()->routeIs('dashboard') ? 'text-indigo-500' : 'text-gray-400' }}">Dashboard</div>
            </div>
        </a>

        <!-- Time Stamp Menu -->
        <div x-data="{ open: {{ request()->is('time-stamp*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                <div class="flex items-center gap-3 flex-1">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-left flex-1">
                        <div class="font-medium">打刻機能</div>
                        <div class="text-xs text-gray-400">Time Stamp</div>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                     :class="open ? 'rotate-180' : ''" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-1"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-1"
                 class="ml-8 mt-1 space-y-1 border-l-2 border-gray-100 pl-3">
                <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span class="font-medium">QRコード打刻</span>
                    <span class="block text-xs text-gray-400">QR Code Stamping</span>
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span class="font-medium">QRコード生成</span>
                    <span class="block text-xs text-gray-400">QR Code Generator</span>
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span class="font-medium">手動打刻</span>
                    <span class="block text-xs text-gray-400">Manual Stamping</span>
                </a>
            </div>
        </div>

        <!-- Work Schedule -->
        <div x-data="{ open: {{ request()->is('work-schedule*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                <div class="flex items-center gap-3 flex-1">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <div class="text-left flex-1">
                        <div class="font-medium">勤務表機能</div>
                        <div class="text-xs text-gray-400">Work Schedule</div>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                     :class="open ? 'rotate-180' : ''" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-1"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-1"
                 class="ml-8 mt-1 space-y-1 border-l-2 border-gray-100 pl-3">
                <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span class="font-medium">勤務表一覧</span>
                    <span class="block text-xs text-gray-400">Work List</span>
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span class="font-medium">打刻承認</span>
                    <span class="block text-xs text-gray-400">Stamp Approval</span>
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span class="font-medium">勤務表印刷</span>
                    <span class="block text-xs text-gray-400">Print Schedule</span>
                </a>
            </div>
        </div>

        <!-- Master Menu -->
        <div x-data="{ open: {{ request()->routeIs('departments.*') || request()->routeIs('business-partners.*') || request()->is('master*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('departments.*') || request()->routeIs('business-partners.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                <div class="flex items-center gap-3 flex-1">
                    <svg class="w-5 h-5 {{ request()->routeIs('departments.*') || request()->routeIs('business-partners.*') ? 'text-indigo-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <div class="text-left flex-1">
                        <div class="font-medium">マスタ管理</div>
                        <div class="text-xs {{ request()->routeIs('departments.*') || request()->routeIs('business-partners.*') ? 'text-indigo-500' : 'text-gray-400' }}">Master Management</div>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                     :class="open ? 'rotate-180' : ''" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-1"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-1"
                 class="ml-8 mt-1 space-y-1 border-l-2 border-gray-100 pl-3">
                <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span class="font-medium">会社マスタ</span>
                    <span class="block text-xs text-gray-400">Company Master</span>
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    <span class="font-medium">従業員マスタ</span>
                    <span class="block text-xs text-gray-400">Employee Master</span>
                </a>
                <a href="{{ route('departments.index') }}"
                   class="block px-3 py-2 rounded-md text-sm transition-colors {{ request()->routeIs('departments.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="font-medium">部署マスタ</span>
                    <span class="block text-xs {{ request()->routeIs('departments.*') ? 'text-indigo-600' : 'text-gray-400' }}">Department Master</span>
                </a>
                <a href="{{ route('business-partners.index') }}"
                   class="block px-3 py-2 rounded-md text-sm transition-colors {{ request()->routeIs('business-partners.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="font-medium">取引会社マスタ</span>
                    <span class="block text-xs {{ request()->routeIs('business-partners.*') ? 'text-indigo-600' : 'text-gray-400' }}">Business Partners</span>
                </a>
            </div>
        </div>

        <!-- Expenses -->
        <a href="#"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <div class="font-medium">経費機能</div>
                <div class="text-xs text-gray-400">Expense System</div>
            </div>
        </a>

    </nav>
</aside>
