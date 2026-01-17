<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transform transition-transform duration-200 ease-in-out lg:translate-x-0"
>
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b">
        <span class="text-lg font-bold text-indigo-600">
            勤務管理  
            <span class="text-sm text-gray-500 block">Work System</span>
        </span>
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
            x
        </button>
    </div>

    <!-- Menu -->
    <nav class="px-2 py-4 space-y-1 text-sm">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-3 py-2 rounded-md hover:bg-indigo-50 text-gray-700">
            📊
            <span class="ml-2">
                ダッシュボード  
                <span class="block text-xs text-gray-400">Dashboard</span>
            </span>
        </a>

        <!-- Time Stamp Menu -->
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-md hover:bg-indigo-50 text-gray-700">
                ⏱
                <span class="ml-2 text-left flex-1">
                    打刻機能  
                    <span class="block text-xs text-gray-400">Time Stamp Functions</span>
                </span>
                <span x-text="open ? '▲' : '▼'"></span>
            </button>

            <div x-show="open" x-cloak class="ml-6 mt-2 space-y-1">
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-100">
                    QRコード打刻機能  
                    <span class="block text-xs text-gray-400">QR Code Stamping</span>
                </a>
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-100">
                    QRコード生成機能  
                    <span class="block text-xs text-gray-400">QR Code Generator</span>
                </a>
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-100">
                    手動打刻機能  
                    <span class="block text-xs text-gray-400">Manual Time Stamping</span>
                </a>
            </div>
        </div>

        <!-- Work Schedule -->
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-md hover:bg-indigo-50 text-gray-700">
                📋
                <span class="ml-2 text-left flex-1">
                    勤務表機能  
                    <span class="block text-xs text-gray-400">Work Schedule</span>
                </span>
                <span x-text="open ? '▲' : '▼'"></span>
            </button>

            <div x-show="open" x-cloak class="ml-6 mt-2 space-y-1">
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-100">
                    勤務表一覧機能  
                    <span class="block text-xs text-gray-400">Work List</span>
                </a>
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-100">
                    打刻承認機能  
                    <span class="block text-xs text-gray-400">Stamp Approval</span>
                </a>
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-100">
                    勤務表印刷機能  
                    <span class="block text-xs text-gray-400">Print Schedule</span>
                </a>
            </div>
        </div>

        <!-- Master Menu -->
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-3 py-2 rounded-md hover:bg-indigo-50 text-gray-700">
                🗂
                <span class="ml-2 text-left flex-1">
                    マスタ管理  
                    <span class="block text-xs text-gray-400">Master Management</span>
                </span>
                <span x-text="open ? '▲' : '▼'"></span>
            </button>

            <div x-show="open" x-cloak class="ml-6 mt-2 space-y-1">
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-100">
                    会社マスタ機能  
                    <span class="block text-xs text-gray-400">Company Master</span>
                </a>
                <a href="#" class="block px-2 py-1 rounded hover:bg-gray-100">
                    従業員マスタ機能  
                    <span class="block text-xs text-gray-400">Employee Master</span>
                </a>
                <a href="{{ route('business-partners.index') }}"
                   class="block px-2 py-1 rounded hover:bg-gray-100">
                    取引会社マスタ  
                    <span class="block text-xs text-gray-400">Trading Company Master</span>
                </a>
            </div>
        </div>

        <!-- Expenses -->
        <a href="#"
           class="flex items-center px-3 py-2 rounded-md hover:bg-indigo-50 text-gray-700">
            💰
            <span class="ml-2">
                経費機能  
                <span class="block text-xs text-gray-400">Expense System</span>
            </span>
        </a>

    </nav>
</aside>
