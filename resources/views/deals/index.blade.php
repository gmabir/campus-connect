<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Exclusive Campus Deals') }}
            </h2>
            
            @if(Auth::user()->role === 'cafe_owner')
                <a href="{{ route('deals.create') }}" class="bg-blue-600 text-black font-bold px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                    + Add New Deal
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($deals as $deal)
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-black mb-2">{{ $deal->title }}</h3>
                            
                            <p class="text-gray-700 mb-4">{{ $deal->description }}</p>
                        </div>
                        
                        <div>
                            <div class="bg-yellow-100 p-3 rounded text-center border border-yellow-300 mt-4">
                                <span class="text-xs text-gray-500 uppercase font-bold">Promo Code</span>
                                <div class="text-lg font-black text-black tracking-widest">
                                    {{ $deal->promo_code ?? 'NO CODE NEEDED' }}
                                </div>
                            </div>

                            @if(Auth::user()->role === 'cafe_owner')
                                <form action="{{ route('deals.destroy', $deal->id) }}" method="POST" class="mt-4 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure you want to delete this deal?')" class="text-red-600 text-sm font-bold hover:underline">
                                        Delete Deal
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($deals->isEmpty())
                <div class="text-center mt-10">
                    <p class="text-gray-500 text-lg">No deals available right now.</p>
                    @if(Auth::user()->role === 'cafe_owner')
                        <p class="text-sm text-blue-500 mt-2">Click the button above to add the first deal!</p>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>