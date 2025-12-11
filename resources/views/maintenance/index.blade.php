<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campus Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
            <a href="{{ route('maintenance.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-700 hover:text-white">
                    + Report New Issue
                </a>

                <h3 class="mt-6 text-lg font-bold">My Reports History</h3>

                <table class="min-w-full mt-4 border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Area</th>
                            <th class="border px-4 py-2">Description</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myRequests as $request)
                            <tr>
                                <td class="border px-4 py-2">{{ $request->area }}</td>
                                <td class="border px-4 py-2">{{ $request->description }}</td>
                                <td class="border px-4 py-2">
                                    <span class="px-2 py-1 rounded text-sm {{ $request->status == 'Pending' ? 'bg-yellow-200' : 'bg-green-200' }}">
                                        {{ $request->status }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2">{{ $request->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>