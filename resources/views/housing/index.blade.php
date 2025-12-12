<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student Housing Board') }}
            </h2>
            <a href="{{ route('housing.create') }}" class="bg-blue-600 text-black font-bold px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                + Post New Ad
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($listings as $listing)
                    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-blue-500 relative">
                        
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-black">{{ $listing->title }}</h3>
                            <span class="bg-green-100 text-green-800 text-sm font-bold px-2 py-1 rounded">
                                ${{ $listing->rent_amount }}/mo
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-500 mb-2">📍 {{ $listing->location }}</p>
                        <p class="text-gray-800 mb-4">{{ $listing->description }}</p>
                        
                        <div class="border-t pt-4 flex justify-between items-center">
                            <span class="font-bold text-blue-700">📞 {{ $listing->contact_phone }}</span>

                            @if(Auth::id() === $listing->user_id)
                                <form action="{{ route('housing.destroy', $listing->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete your ad?')" class="text-red-600 text-sm font-bold hover:underline">
                                        Delete My Ad
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($listings->isEmpty())
                <div class="text-center mt-10 text-gray-500">
                    <p class="text-lg">No housing ads yet.</p>
                    <p class="text-sm">Be the first to post!</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>