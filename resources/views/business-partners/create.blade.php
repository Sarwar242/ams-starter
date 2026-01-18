@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Add New Partner / 新規取引先登録</h1>
                        <a href="{{ route('business-partners.index') }}"
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

                    <form method="POST" action="{{ route('business-partners.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-medium mb-2">Code / コード</label>
                                <input type="text" name="code" value="{{ old('code') }}"
                                       class="w-full border rounded px-4 py-2">
                            </div>


                            <div>
                                <label class="block text-sm font-medium mb-2">Company Name / 会社名 *</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="w-full border rounded px-4 py-2" required>
                            </div>

                            

                            <div>
                                <label class="block text-sm font-medium mb-2">Contact Person / 担当者</label>
                                <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                                       class="w-full border rounded px-4 py-2">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Phone / 電話</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       placeholder="e.g. 03-1234-5678 or 09012345678"
                                       class="w-full border rounded px-4 py-2">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Email / メール</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="w-full border rounded px-4 py-2">
                            </div>

                            <div class="flex items-center">
                                <input type="hidden" name="is_subcontractor" value="0">
                               <input type="checkbox" name="is_subcontractor" id="is_subcontractor" value="1"
       {{ old('is_subcontractor', $businessPartner->is_subcontractor ?? false) ? 'checked' : '' }}>
                                <label for="is_subcontractor" class="ml-2">Subcontractor / 外注可能</label>
                            </div>
                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                                Save / 保存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection