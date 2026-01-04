<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Campus Health Center</h2>
            <a href="{{ route('health.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Book Appointment</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-3">Date</th>
                            <th class="p-3">Reason</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $app)
                        <tr class="border-t">
                            <td class="p-3">{{ $app->appointment_date }}</td>
                            <td class="p-3">{{ $app->reason }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs {{ $app->status == 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="p-3 flex gap-2">
                                @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('health.updateStatus', $app->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs rounded border-gray-300">
                                            <option value="Pending" {{ $app->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Confirmed" {{ $app->status == 'Confirmed' ? 'selected' : '' }}>Confirm</option>
                                        </select>
                                    </form>
                                @endif
                                <form action="{{ route('health.destroy', $app->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 text-xs font-bold">Cancel</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>