<x-app-layout>
    <div style="padding: 30px;">
        <h1>Mijn spellen</h1>

        <a href="{{ route('spellen.create') }}">Nieuw spel starten</a>

        <br><br>

        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Winnaar</th>
                <th>Actie</th>
            </tr>

            @foreach ($spellen as $spel)
                <tr>
                    <td>{{ $spel->id }}</td>
                    <td>{{ $spel->status }}</td>
                    <td>
                        @if ($spel->winnaar)
                            {{ $spel->winnaar->name }}
                        @else
                            Geen winnaar
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('spellen.show', $spel) }}">Bekijken</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>