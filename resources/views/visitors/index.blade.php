<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visitor Management (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Check In New Visitor</h3>
                <form action="{{ route('visitors.store') }}" method="POST" class="flex gap-4 items-end">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold">Visitor Name</label>
                        <input type="text" name="visitor_name" class="border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold">Phone</label>
                        <input type="text" name="phone" class="border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold">Purpose</label>
                        <input type="text" name="purpose" class="border rounded px-3 py-2" required>
                    </div>
                    
                    <button type="submit" class="bg-blue-600 text-black font-bold px-6 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                        Check In
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daily Visitor Log</h3>
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Phone</th>
                            <th class="border px-4 py-2">Purpose</th>
                            <th class="border px-4 py-2">Entry Time</th>
                            <th class="border px-4 py-2">Exit Time</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitors as $visitor)
                            <tr>
                                <td class="border px-4 py-2">{{ $visitor->visitor_name }}</td>
                                <td class="border px-4 py-2">{{ $visitor->phone }}</td>
                                <td class="border px-4 py-2">{{ $visitor->purpose }}</td>
                                <td class="border px-4 py-2 text-green-600 font-bold">
                                    {{ \Carbon\Carbon::parse($visitor->entry_time)->format('h:i A') }}
                                </td>
                                <td class="border px-4 py-2 text-red-600">
                                    @if($visitor->exit_time)
                                        {{ \Carbon\Carbon::parse($visitor->exit_time)->format('h:i A') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border px-4 py-2">
                                    @if(!$visitor->exit_time)
                                        <form action="{{ route('visitors.checkout', $visitor->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                                Check Out
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 text-sm">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>