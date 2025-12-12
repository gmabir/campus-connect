<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Community Feedback') }}
            </h2>
            <a href="{{ route('feedback.create') }}" class="bg-blue-600 text-black font-bold px-4 py-2 rounded hover:text-white">
                + Give Feedback
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @foreach($feedbacks as $feedback)
                    <div class="bg-white p-6 rounded-lg shadow border-l-4 {{ $feedback->rating >= 4 ? 'border-green-500' : 'border-yellow-500' }}">
                        
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="bg-gray-200 text-gray-700 text-xs font-bold px-2 py-1 rounded uppercase">
                                    {{ $feedback->type }}
                                </span>
                                <span class="ml-2 font-bold text-lg text-black">
                                    {{ $feedback->target_name }}
                                </span>
                            </div>
                            <div class="text-yellow-500 text-lg">
                                {{ str_repeat('★', $feedback->rating) }}
                            </div>
                        </div>

                        <p class="text-gray-800 mt-2">"{{ $feedback->message }}"</p>

                        <div class="mt-4 pt-4 border-t flex justify-between items-center">
                            
                            <div class="text-sm text-gray-500 italic">
                                Posted by: 
                                @if(Auth::user()->role === 'admin')
                                    <span class="font-bold text-red-600">{{ $feedback->user->name }} ({{ $feedback->user->email }})</span>
                                @else
                                    <span class="font-bold text-gray-600">Anonymous Student</span>
                                @endif
                            </div>

                            @if(Auth::id() === $feedback->user_id || Auth::user()->role === 'admin')
                                <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this feedback?')" class="text-red-500 font-bold text-sm hover:underline">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>