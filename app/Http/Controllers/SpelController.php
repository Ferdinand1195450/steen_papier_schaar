<?php

namespace App\Http\Controllers;

use App\Models\Ronde;
use App\Models\Spel;
use App\Models\User;
use App\Models\Zet;
use Illuminate\Http\Request;

class SpelController extends Controller
{
    public function landing()
    {
        $leaderboard = User::withCount(['spellen as gewonnen_spellen' => function ($query) {
            $query->whereColumn('spellen.winnaar_id', 'users.id');
        }])
            ->orderByDesc('gewonnen_spellen')
            ->take(10)
            ->get();

        return view('landing', compact('leaderboard'));
    }

    public function index()
    {
        $spellen = auth()->user()->spellen()->latest()->get();

        return view('spellen.index', compact('spellen'));
    }

    public function create()
    {
        $tegenstanders = User::where('id', '!=', auth()->id())->get();

        return view('spellen.create', compact('tegenstanders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tegenstander_id' => 'required|exists:users,id',
        ]);

        $spel = Spel::create([
            'status' => 'bezig',
            'gestart_op' => now(),
            'winnaar_id' => null,
        ]);

        $spel->spelers()->attach([
            auth()->id(),
            $request->tegenstander_id,
        ]);

        return redirect()->route('spellen.show', $spel);
    }

    public function show(Spel $spel)
    {
        if (!$spel->spelers->contains(auth()->id())) {
            abort(403);
        }

        $zetten = Zet::all();

        $rondes = $spel->rondes()
            ->with(['speler', 'zet'])
            ->orderBy('ronde_nummer')
            ->get();

        return view('spellen.show', compact('spel', 'zetten', 'rondes'));
    }

    public function play(Request $request, Spel $spel)
    {
        if (!$spel->spelers->contains(auth()->id())) {
            abort(403);
        }

        if ($spel->status === 'afgelopen') {
            return redirect()->route('spellen.show', $spel);
        }

        $request->validate([
            'zet_id' => 'required|exists:zetten,id',
        ]);

        $rondeNummer = 1;

        $bestaandeZet = Ronde::where('spel_id', $spel->id)
            ->where('speler_id', auth()->id())
            ->where('ronde_nummer', $rondeNummer)
            ->first();

        if ($bestaandeZet) {
            return redirect()->route('spellen.show', $spel);
        }

        Ronde::create([
            'spel_id' => $spel->id,
            'speler_id' => auth()->id(),
            'zet_id' => $request->zet_id,
            'ronde_nummer' => $rondeNummer,
            'ronde_uitkomst' => null,
        ]);

        $zettenDezeRonde = Ronde::where('spel_id', $spel->id)
            ->where('ronde_nummer', $rondeNummer)
            ->with(['speler', 'zet'])
            ->get();

        if ($zettenDezeRonde->count() === 2) {
            $this->bepaalWinnaar($spel, $zettenDezeRonde);
        }

        return redirect()->route('spellen.show', $spel);
    }

    private function bepaalWinnaar(Spel $spel, $rondes)
    {
        $ronde1 = $rondes[0];
        $ronde2 = $rondes[1];

        $keuze1 = $ronde1->zet->naam;
        $keuze2 = $ronde2->zet->naam;

        if ($keuze1 === $keuze2) {
            $ronde1->update(['ronde_uitkomst' => 'gelijkspel']);
            $ronde2->update(['ronde_uitkomst' => 'gelijkspel']);

            $spel->update([
                'status' => 'afgelopen',
                'winnaar_id' => null,
            ]);

            return;
        }

        $speler1Wint =
            ($keuze1 === 'steen' && $keuze2 === 'schaar') ||
            ($keuze1 === 'papier' && $keuze2 === 'steen') ||
            ($keuze1 === 'schaar' && $keuze2 === 'papier');

        if ($speler1Wint) {
            $winnaar = $ronde1->speler;
            $ronde1->update(['ronde_uitkomst' => 'gewonnen']);
            $ronde2->update(['ronde_uitkomst' => 'verloren']);
        } else {
            $winnaar = $ronde2->speler;
            $ronde1->update(['ronde_uitkomst' => 'verloren']);
            $ronde2->update(['ronde_uitkomst' => 'gewonnen']);
        }

        $spel->update([
            'status' => 'afgelopen',
            'winnaar_id' => $winnaar->id,
        ]);
    }
}