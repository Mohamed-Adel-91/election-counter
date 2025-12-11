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

        $totalVotes = $voters->sum('votes');
        $quarter = $totalVotes / 4;

        $invalid = InvalidVote::first();
        $invalidVotes = $invalid ? $invalid->count : 0;

        $topVoters = $voters->sortByDesc('votes')->take(4);

        return view('voters.index', [
            'voters' => $voters,
            'totalVotes' => $totalVotes,
            'quarter' => $quarter,
            'invalidVotes' => $invalidVotes,
            'topVoters' => $topVoters,
        ]);
    }

    public function increment(Request $request, Voter $voter)
    {
        $voter->increment('votes');

        return $this->respondStats($request, $voter->id);
    }

    public function reset(Request $request)
    {
        Voter::query()->update(['votes' => 0]);

        return $this->respondStats($request);
    }

    public function incrementInvalid(Request $request)
    {
        $invalid = InvalidVote::firstOrCreate([], ['count' => 0]);
        $invalid->increment('count');

        return $this->respondStats($request);
    }

    public function resetInvalid(Request $request)
    {
        $invalid = InvalidVote::first();
        if ($invalid) {
            $invalid->update(['count' => 0]);
        }

        return $this->respondStats($request);
    }

    /**
     * Return JSON stats for AJAX requests or redirect back otherwise.
     */
    protected function respondStats(Request $request, $updatedVoterId = null)
    {
        if ($request->ajax()) {
            $voters = Voter::orderBy('number')->get();

            $totalVotes = $voters->sum('votes');
            $quarter = $totalVotes / 4;

            $invalid = InvalidVote::first();
            $invalidVotes = $invalid ? $invalid->count : 0;

            $topVoters = $voters->sortByDesc('votes')->take(4)->values();

            return response()->json([
                'success' => true,
                'updatedVoterId' => $updatedVoterId,
                'voters' => $voters->map(fn($v) => [
                    'id' => $v->id,
                    'number' => $v->number,
                    'name' => $v->name,
                    'votes' => $v->votes,
                ]),
                'totalVotes' => $totalVotes,
                'quarter' => $quarter,
                'invalidVotes' => $invalidVotes,
                'totalParticipants' => $quarter + $invalidVotes,
                'percentValid' => ($quarter / 9872) * 100,
                'percentInvalid' => ($invalidVotes / 9872) * 100,
                'percentTotal' => (($quarter + $invalidVotes) / 9872) * 100,
                'topVoters' => $topVoters->map(fn($v) => [
                    'name' => $v->name,
                    'votes' => $v->votes,
                ]),
            ]);
        }

        return redirect()->route('voters.index');
    }
}
