<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Post</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('posts.store') }}" method="POST" class="bg-white shadow rounded p-6">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2">
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1">Isi</label>
                <textarea name="body" rows="6" class="w-full border rounded px-3 py-2">{{ old('body') }}</textarea>
                @error('body') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('posts.index') }}" class="ml-2 text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>