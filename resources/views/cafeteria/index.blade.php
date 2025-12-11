<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cafeteria Menu') }}
            </h2>
            @if(Auth::user()->role === 'cafe_owner')
                <a href="{{ route('cafeteria.create') }}" class="bg-blue-600 text-black font-bold px-4 py-2 rounded hover:text-white transition">
                    + Add Food Item
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                @foreach($items as $item)
                    <div class="bg-white p-4 rounded-lg shadow border flex flex-col items-center">
                        <div class="h-32 w-full bg-gray-200 rounded mb-4 flex items-center justify-center text-gray-500">
                            🍔 Food Img
                        </div>
                        
                        <h3 class="font-bold text-lg text-black">{{ $item->name }}</h3>
                        <p class="text-gray-500 text-sm mb-2">{{ $item->category }}</p>
                        <p class="text-green-600 font-bold text-xl">${{ $item->price }}</p>

                        <button class="mt-3 w-full bg-orange-500 text-black font-bold py-1 rounded hover:bg-orange-600">
                            Add to Cart
                        </button>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>