<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Resource Requests') }}
            </h2>
            @if(Auth::user()->role === 'teacher')
                <a href="{{ route('resources.create') }}" class="bg-blue-600 text-black font-bold px-4 py-2 rounded hover:text-white transition">
                    + Request New Item
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <table class="min-w-full border text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-3 text-black">Item</th>
                            <th class="border p-3 text-black">Qty</th>
                            <th class="border p-3 text-black">Needed By</th>
                            <th class="border p-3 text-black">Status</th>
                            @if(Auth::user()->role === 'admin')
                                <th class="border p-3 text-black">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3 font-bold">{{ $req->item_needed }}</td>
                                <td class="border p-3">{{ $req->quantity }}</td>
                                <td class="border p-3">{{ $req->needed_date }}</td>
                                <td class="border p-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $req->status == 'Pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                        {{ $req->status == 'Approved' ? 'bg-green-200 text-green-800' : '' }}
                                        {{ $req->status == 'Denied' ? 'bg-red-200 text-red-800' : '' }}">
                                        {{ $req->status }}
                                    </span>
                                </td>
                                
                                @if(Auth::user()->role === 'admin')
                                    <td class="border p-3 flex gap-2">
                                        <form action="{{ route('resources.updateStatus', $req->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Approved">
                                            <button class="text-green-600 font-bold hover:underline text-sm">Approve</button>
                                        </form>

                                        <form action="{{ route('resources.updateStatus', $req->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Denied">
                                            <button class="text-red-600 font-bold hover:underline text-sm">Deny</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($requests->isEmpty())
                    <p class="text-gray-500 text-center mt-4">No requests found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>