<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bus Schedules') }}
            </h2>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('transport.create') }}" class="bg-blue-600 text-black font-bold px-4 py-2 rounded hover:text-white transition">
                    + Add New Route
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border p-3 text-black">Route Name</th>
                            <th class="border p-3 text-black">Timings</th>
                            <th class="border p-3 text-black">Stops</th>
                            @if(Auth::user()->role === 'admin')
                                <th class="border p-3 text-black">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($routes as $route)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3 font-bold">{{ $route->route_name }}</td>
                                <td class="border p-3 text-blue-600 font-bold">{{ $route->schedule_time }}</td>
                                <td class="border p-3 text-gray-600">{{ $route->stops_list }}</td>
                                
                                @if(Auth::user()->role === 'admin')
                                    <td class="border p-3">
                                        <form action="{{ route('transport.destroy', $route->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Delete this route?')" class="text-red-600 font-bold hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($routes->isEmpty())
                    <p class="text-center text-gray-500 mt-6">No bus schedules available.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>