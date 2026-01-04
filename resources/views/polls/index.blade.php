<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Community Polls</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('polls.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                Create Poll
            </a>
        @endif

        <div class="space-y-4">
            @forelse($polls as $poll)
                @php
                    $pollOptions = $options[$poll->id] ?? collect();
                    $voted = in_array($poll->id, $myVotes);
                    $expired = $poll->expires_on && now()->toDateString() > $poll->expires_on;
                @endphp

                <div class="bg-white p-5 rounded shadow">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-lg font-bold">{{ $poll->question }}</div>
                            <div class="text-sm text-gray-600">
                                Status: <b>{{ $poll->is_active ? 'Active' : 'Closed' }}</b>
                                @if($poll->expires_on) | Expires: {{ $poll->expires_on }} @endif
                            </div>
                        </div>

                        @if(auth()->user()->role === 'admin')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('polls.toggle', $poll->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1 bg-gray-800 text-white rounded">
                                        {{ $poll->is_active ? 'Close' : 'Open' }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('polls.destroy', $poll->id) }}"
                                      onsubmit="return confirm('Delete this poll?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    {{-- Voting --}}
                    <div class="mt-4">
                        @if(!$voted && $poll->is_active && !$expired)
                            <form method="POST" action="{{ route('polls.vote', $poll->id) }}" class="space-y-2">
                                @csrf
                                @foreach($pollOptions as $opt)
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="option_id" value="{{ $opt->id }}" required>
                                        <span>{{ $opt->option_text }}</span>
                                    </label>
                                @endforeach
                                <button class="mt-2 px-4 py-2 bg-green-600 text-white rounded">Submit Vote</button>
                            </form>
                        @else
                            <div class="text-sm text-gray-700 mb-2">
                                @if($voted) You already voted. @endif
                                @if($expired) This poll has expired. @endif
                                @if(!$poll->is_active) This poll is closed. @endif
                            </div>
                        @endif
                    </div>

                    {{-- Results --}}
                    <div class="mt-4">
                        <div class="font-semibold mb-2">Results</div>
                        <ul class="space-y-1">
                            @foreach($pollOptions as $opt)
                                @php $count = $voteCounts[$opt->id] ?? 0; @endphp
                                <li class="flex items-center justify-between border rounded p-2">
                                    <span>{{ $opt->option_text }}</span>
                                    <span class="font-bold">{{ $count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded shadow text-center text-gray-600">
                    No polls created yet.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
