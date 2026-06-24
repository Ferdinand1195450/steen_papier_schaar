<x-guest-layout>
    <div style="padding: 30px;">
        <h1>Steen Papier Schaar</h1>

        <p>
            Speel een simpel turnbased spel tegen een andere speler.
            Beide spelers kiezen steen, papier of schaar. Daarna bepaalt het systeem de winnaar.
        </p>

        @auth
            <a href="{{ route('spellen.index') }}">Naar mijn spellen</a>
        @else
            <a href="{{ route('login') }}">Inloggen</a>
            <a href="{{ route('register') }}">Registreren</a>
        @endauth

        <h2>Leaderboard</h2>

        <table border="1" cellpadding="8">
            <tr>
                <th>Speler</th>
                <th>Gewonnen spellen</th>
            </tr>

            @foreach ($leaderboard as $speler)
                <tr>
                    <td>{{ $speler->name }}</td>
                    <td>{{ $speler->gewonnen_spellen }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</x-guest-layout>