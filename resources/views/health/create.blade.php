<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Request Appointment</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('health.store') }}" class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Date</label>
                <input type="date" name="appointment_date" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Time</label>
                <input name="appointment_time" placeholder="e.g. 11:00 AM" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Reason (optional)</label>
                <input name="reason" class="w-full border rounded p-2" />
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Submit Request</button>
                <a href="{{ route('health.index') }}" class="px-4 py-2 bg-gray-300 rounded">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
