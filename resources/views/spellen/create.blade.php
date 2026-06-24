<x-app-layout>
    <div style="padding: 30px;">
        <h1>Nieuw spel starten</h1>

        <form method="POST" action="{{ route('spellen.store') }}">
            @csrf

            <label>Kies tegenstander:</label>

            <select name="tegenstander_id" required>
                @foreach ($tegenstanders as $tegenstander)
                    <option value="{{ $tegenstander->id }}">
                        {{ $tegenstander->name }} - {{ $tegenstander->email }}
                    </option>
                @endforeach
            </select>

            <br><br>

            <button type="submit">Start spel</button>
        </form>
    </div>
</x-app-layout>