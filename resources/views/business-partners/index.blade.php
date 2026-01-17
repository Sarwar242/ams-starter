@extends('layouts.app')

@section('content')
<div>
    <div class="w-[90%]">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Business Partners / 取引会社マスタ</h1>
                    <a href="{{ route('business-partners.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Add New / 新規登録
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search + Per page -->
                <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search name, code, contact..." class="border rounded px-4 py-2 w-64">
                    </div>

                    <div class="flex items-center gap-2">
                        <label>Show:</label>
                        <select name="per_page" onchange="this.form.submit()" class="border rounded px-3 py-2">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Search
                    </button>
                </form>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Subcontractor</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($partners as $partner)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $partner->code ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $partner->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $partner->contact_person ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $partner->phone ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $partner->email ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    {{ $partner->is_subcontractor ? 'Yes / 〇' : 'No / ×' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right space-x-3">
                                    <a href="{{ route('business-partners.edit', $partner) }}"
                                       class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('business-partners.destroy', $partner) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    No partners found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $partners->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection