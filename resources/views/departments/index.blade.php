@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl font-bold">Departments / 部署マスタ</h1>
                    @can('create', App\Models\Department::class)
                        <a href="{{ route('departments.create') }}"
                           class="bg-blue-600 text-white px-3 py-2 text-sm rounded hover:bg-blue-700">
                            Add New / 新規登録
                        </a>
                    @endcan
                </div>

                @if (session('success'))
                    <div class="mb-6 p-3 bg-green-100 border border-green-400 text-green-700 rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search + Per page -->
                <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search name, description..." class="border rounded px-3 py-1.5 text-sm w-56">
                    </div>

                    <div class="flex items-center gap-2 text-sm">
                        <label>Show:</label>
                        <select name="per_page" onchange="this.form.submit()" class="border rounded px-2 py-1.5 text-sm">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-gray-600 text-white px-3 py-1.5 text-sm rounded hover:bg-gray-700">
                        Search
                    </button>
                </form>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($departments as $department)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap font-medium">{{ $department->name }}</td>
                                <td class="px-4 py-3">{{ $department->description ?? '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-right space-x-2">
                                    @can('update', $department)
                                        <a href="{{ route('departments.edit', $department) }}"
                                           class="text-blue-600 hover:underline">Edit</a>
                                    @endcan

                                    @can('delete', $department)
                                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                    class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                                    No departments found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 text-sm">
                    {{ $departments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
