@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Edit Department / 部署編集</h1>
                        <a href="{{ route('departments.index') }}"
                           class="text-blue-600 hover:underline">← Back to List</a>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('departments.update', $department) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">

                            <div>
                                <label class="block text-sm font-medium mb-2">Department Name / 部署名 *</label>
                                <input type="text" name="name" value="{{ old('name', $department->name) }}"
                                       class="w-full border rounded px-4 py-2" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Description / 説明</label>
                                <textarea name="description" rows="4"
                                          class="w-full border rounded px-4 py-2">{{ old('description', $department->description) }}</textarea>
                            </div>

                        </div>

                        <div class="mt-8 text-right">
                            <button class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
                                Update / 更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
