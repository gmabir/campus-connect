<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Faculty and Course Review') }}
            </h2>
            <a href="{{ route('feedback.create') }}" class="bg-blue-600 text-black font-bold px-4 py-2 rounded hover:text-white transition">
                + Give Review
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($feedbacks->isEmpty())
                <div class="text-center p-10 bg-white rounded-lg shadow">
                    <p class="text-gray-500">No review submitted yet.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @foreach($feedbacks as $feedback)
                    <div class="bg-white p-6 rounded-lg shadow border-l-4 {{ ($feedback->rating ?? 0) >= 4 ? 'border-green-500' : 'border-yellow-500' }}">
                        
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="bg-gray-200 text-gray-700 text-xs font-bold px-2 py-1 rounded uppercase">
                                    {{ $feedback->type ?? 'General' }}
                                </span>
                                <span class="ml-2 font-bold text-lg text-black">
                                    {{ $feedback->target_name ?? 'Campus Service' }}
                                </span>
                            </div>
                            <div class="text-yellow-500 text-lg">
                                {{-- Added a safeguard for the rating loop --}}
                                {{ str_repeat('★', max(0, min(5, $feedback->rating ?? 0))) }}
                            </div>
                        </div>

                        <p class="text-gray-800 mt-2">"{{ $feedback->message }}"</p>

                        <div class="mt-4 pt-4 border-t flex justify-between items-center">
                            
                            <div class="text-sm text-gray-500 italic">
                                Posted by: 
                                @if(Auth::user()->role === 'admin')
                                    {{-- FIXED: Added ?? null checks to prevent crashing on deleted users --}}
                                    <span class="font-bold text-red-600">
                                        {{ $feedback->user->name ?? 'Deleted User' }} 
                                        ({{ $feedback->user->email ?? 'N/A' }})
                                    </span>
                                @else
                                    <span class="font-bold text-gray-600">Anonymous Student</span>
                                @endif
                            </div>

                            {{-- FIXED: Added null check for user_id --}}
                            @if(Auth::id() === ($feedback->user_id ?? 0) || Auth::user()->role === 'admin')
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