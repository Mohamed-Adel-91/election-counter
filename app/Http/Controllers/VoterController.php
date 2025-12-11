<?php

namespace App\Http\Controllers;

use App\Models\InvalidVote;
use App\Models\Voter;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    /**
     * Display the list of voters with totals.
     */
    public function index()
    {
        $voters = Voter::orderBy('number')->get();

        $totalVotes = Voter::sum('votes');
        $quarter = $totalVotes / 4;

        $invalid = InvalidVote::firstOrCreate([], ['count' => 0]);
        $invalidVotes = $invalid->count;

        return view('voters.index', [
            'voters' => $voters,
            'totalVotes' => $totalVotes,
            'quarter' => $quarter,
            'invalidVotes' => $invalidVotes,
        ]);
    }

    /**
     * Increment votes for the given voter.
     */
    public function increment(Request $request, Voter $voter)
    {
        $voter->increment('votes');

        return redirect()->route('voters.index');
    }

    /**
     * Increment invalid votes count.
     */
    public function incrementInvalid()
    {
        $invalid = InvalidVote::firstOrCreate([], ['count' => 0]);
        $invalid->count += 1;
        $invalid->save();

        return redirect()->route('voters.index');
    }

    /**
     * Reset invalid votes to zero.
     */
    public function resetInvalid()
    {
        $invalid = InvalidVote::firstOrCreate([], ['count' => 0]);
        $invalid->count = 0;
        $invalid->save();

        return redirect()->route('voters.index');
    }

    /**
     * Reset votes for all voters to zero.
     */
    public function reset(Request $request)
    {
        Voter::query()->update(['votes' => 0]);

        return redirect()->route('voters.index');
    }
}
