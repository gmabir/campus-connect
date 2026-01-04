<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    // 1) Show polls + results
    public function index()
    {
        $polls = Poll::latest()->get();

        // which polls current user already voted on
        $myVotes = PollVote::where('user_id', Auth::id())
            ->pluck('poll_id')
            ->toArray();

        // get options grouped by poll
        $options = PollOption::all()->groupBy('poll_id');

        // vote counts grouped by option
        $voteCounts = PollVote::selectRaw('option_id, COUNT(*) as total')
            ->groupBy('option_id')
            ->pluck('total', 'option_id');

        return view('polls.index', compact('polls', 'myVotes', 'options', 'voteCounts'));
    }

    // 2) Admin create form
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can create polls.');
        }

        return view('polls.create');
    }

    // 3) Store poll + options (Admin only)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'question' => 'required|string|max:255',
            'expires_on' => 'nullable|date',

            // we will send options[] from the form
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        $poll = Poll::create([
            'user_id' => Auth::id(),
            'question' => $request->question,
            'expires_on' => $request->expires_on,
            'is_active' => true,
        ]);

        foreach ($request->options as $opt) {
            PollOption::create([
                'poll_id' => $poll->id,
                'option_text' => $opt,
            ]);
        }

        return redirect()->route('polls.index')->with('success', 'Poll created!');
    }

    // 4) Vote (one vote per poll)
    public function vote(Request $request, $pollId)
    {
        $poll = Poll::findOrFail($pollId);

        if (!$poll->is_active) {
            return redirect()->back()->with('error', 'This poll is not active.');
        }

        // optional expiry check
        if ($poll->expires_on && now()->toDateString() > $poll->expires_on) {
            return redirect()->back()->with('error', 'This poll has expired.');
        }

        $request->validate([
            'option_id' => 'required|integer',
        ]);

        // already voted?
        $already = PollVote::where('poll_id', $poll->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($already) {
            return redirect()->back()->with('success', 'You already voted.');
        }

        // ensure option belongs to the poll
        $validOption = PollOption::where('id', $request->option_id)
            ->where('poll_id', $poll->id)
            ->exists();

        if (!$validOption) {
            abort(403, 'Invalid option.');
        }

        PollVote::create([
            'poll_id' => $poll->id,
            'option_id' => $request->option_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Vote submitted!');
    }

    // 5) Admin toggle active/inactive
    public function toggle($pollId)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $poll = Poll::findOrFail($pollId);
        $poll->is_active = !$poll->is_active;
        $poll->save();

        return redirect()->back()->with('success', 'Poll status updated.');
    }

    // 6) Admin delete poll (cascade deletes options + votes)
    public function destroy(Poll $poll)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $poll->delete();

        return redirect()->route('polls.index')->with('success', 'Poll deleted.');
    }
}
