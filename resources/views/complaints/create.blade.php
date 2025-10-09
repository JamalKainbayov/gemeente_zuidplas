@extends('layouts.app')

@section('content')
    <h2>Klacht indienen</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('complaints.store') }}">
        @csrf

        <label>Naam:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Onderwerp:</label>
        <input type="text" name="subject" required>

        <label>Beschrijving:</label>
        <textarea name="description" required></textarea>

        <button type="submit">Verstuur klacht</button>
    </form>
@endsection
