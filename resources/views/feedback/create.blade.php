<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Give Feedback') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                
                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Feedback Type</label>
                        <select name="type" id="typeSelector" class="w-full border rounded px-3 py-2" onchange="toggleInputs()">
                            <option value="course">Course / Subject</option>
                            <option value="teacher">Teacher</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div id="teacherInput" class="mb-4 hidden">
                        <label class="block font-bold mb-2">Select Teacher</label>
                        <select name="teacher_id" class="w-full border rounded px-3 py-2">
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->name }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="customInput" class="mb-4">
                        <label class="block font-bold mb-2">Name of Course or Item</label>
                        <input type="text" name="custom_target" class="w-full border rounded px-3 py-2" placeholder="e.g. Mathematics 101">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Rating</label>
                        <select name="rating" class="w-full border rounded px-3 py-2">
                            <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="4">⭐⭐⭐⭐ Good</option>
                            <option value="3">⭐⭐⭐ Average</option>
                            <option value="2">⭐⭐ Poor</option>
                            <option value="1">⭐ Very Bad</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Message</label>
                        <textarea name="message" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-black font-bold px-6 py-2 rounded hover:text-white">
                        Post Feedback
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function toggleInputs() {
            var type = document.getElementById('typeSelector').value;
            if (type === 'teacher') {
                document.getElementById('teacherInput').classList.remove('hidden');
                document.getElementById('customInput').classList.add('hidden');
            } else {
                document.getElementById('teacherInput').classList.add('hidden');
                document.getElementById('customInput').classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>