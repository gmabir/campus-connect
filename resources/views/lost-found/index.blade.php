<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lost & Found') }}
            </h2>
            <a href="{{ route('lost-found.create') }}" class="bg-red-600 text-black font-bold px-4 py-2 rounded hover:text-white transition">
                + Report Lost Item
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="bg-white p-6 rounded-lg shadow border border-gray-200 relative">
                        
                        <span class="absolute top-4 right-4 px-2 py-1 rounded text-xs font-bold uppercase {{ $item->status == 'Lost' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $item->status }}
                        </span>

                        <h3 class="text-xl font-bold text-black">{{ $item->item_name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $item->description }}</p>
                        
                        <div class="mt-4 border-t pt-4">
                            <p class="text-sm font-bold text-gray-500">Contact Finder:</p>
                            <p class="text-lg font-bold text-blue-600">{{ $item->contact_phone }}</p>
                        </div>

                        @if(Auth::id() === $item->user_id)
                            <div class="mt-4 flex gap-2">
                                @if($item->status == 'Lost')
                                    <form action="{{ route('lost-found.markFound', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-green-500 text-black text-xs font-bold px-3 py-1 rounded hover:bg-green-400">
                                            Mark Found
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('lost-found.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-gray-300 text-black text-xs font-bold px-3 py-1 rounded hover:bg-gray-400">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>