<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea name="content" class="w-full border-gray-300 rounded-lg" placeholder="Share something with the campus..."></textarea>
                    <button class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-bold">Post to Connect</button>
                </form>
            </div>

            @foreach($posts as $post)
                <div class="bg-white p-6 rounded-lg shadow mb-4">
                    <div class="flex items-center mb-4">
                        <div class="font-bold text-blue-600">{{ $post->user->name }}</div>
                        <div class="text-xs text-gray-400 ml-2">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                    <p class="text-gray-800">{{ $post->content }}</p>

                    <div class="mt-4 border-t pt-4">
                        @foreach($post->comments as $comment)
                            <div class="bg-gray-50 p-2 rounded mb-2 text-sm">
                                <strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}
                            </div>
                        @endforeach

                        <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="mt-2 flex">
                            @csrf
                            <input type="text" name="comment" class="flex-1 border-gray-300 rounded-l-lg text-sm" placeholder="Write a suggestion...">
                            <button class="bg-gray-800 text-white px-3 rounded-r-lg text-sm">Reply</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>