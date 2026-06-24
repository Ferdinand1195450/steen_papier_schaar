<x-app-layout>
    <div style="padding: 30px;">
        <h1>Spel #{{ $spel->id }}</h1>

        <p>Status: {{ $spel->status }}</p>

        <h2>Spelers</h2>

        <ul>
            @foreach ($spel->spelers as $speler)
                <li>{{ $speler->name }}</li>
            @endforeach
        </ul>

        @if ($spel->status === 'afgelopen')
            <h2>Uitslag</h2>

            @if ($spel->winnaar)
                <p>Winnaar: {{ $spel->winnaar->name }}</p>
            @else
                <p>Het is gelijkspel.</p>
            @endif
        @else
            <h2>Kies je zet</h2>

            <form method="POST" action="{{ route('spellen.play', $spel) }}">
                @csrf

                @foreach ($zetten as $zet)
                    <button type="submit" name="zet_id" value="{{ $zet->id }}">
                        {{ ucfirst($zet->naam) }}
                    </button>
                @endforeach
            </form>
        @endif

        <h2>Rondes</h2>

        <table border="1" cellpadding="8">
            <tr>
                <th>Ronde</th>
                <th>Speler</th>
                <th>Zet</th>
                <th>Uitkomst</th>
            </tr>

            @foreach ($rondes as $ronde)
                <tr>
                    <td>{{ $ronde->ronde_nummer }}</td>
                    <td>{{ $ronde->speler->name }}</td>
                    <td>{{ $ronde->zet->naam }}</td>
                    <td>{{ $ronde->ronde_uitkomst ?? 'Nog niet bekend' }}</td>
                </tr>
            @endforeach
        </table>

        <br>

        <a href="{{ route('spellen.index') }}">Terug naar mijn spellen</a>
    </div>
</x-app-layout>