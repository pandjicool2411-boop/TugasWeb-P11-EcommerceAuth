<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Post</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @can('create', App\Models\Post::class)
            <a href="{{ route('posts.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded mb-4">+ Tambah Post</a>
        @endcan

        @foreach ($posts as $post)
            <div class="bg-white shadow rounded p-5 mb-4">
                <h3 class="text-lg font-semibold">
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600">{{ $post->title }}</a>
                </h3>
                <p class="text-sm text-gray-500">oleh {{ $post->user->name }} ({{ $post->user->role }})</p>

                <div class="mt-3 flex gap-3">
                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}" class="text-yellow-600">Edit</a>
                    @endcan

                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Hapus</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach

        {{ $posts->links() }}
    </div>
</x-app-layout>