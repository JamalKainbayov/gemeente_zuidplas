@extends('layouts.app')

@section('content')
    <h2>Ingediende klachten</h2>

    @if (session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Onderwerp</th>
            <th>Status</th>
            <th>Actie</th>
        </tr>
        @foreach($complaints as $complaint)
            <tr>
                <td>{{ $complaint->id }}</td>
                <td>{{ $complaint->name }}</td>
                <td>{{ $complaint->subject }}</td>
                <td>{{ $complaint->status }}</td>
                <td>
                    <a href="{{ route('complaints.show', $complaint->id) }}">Bekijken</a>
                </td>
            </tr>
        @endforeach
    </table>

    <a href="{{ route('complaints.create') }}">Nieuwe klacht indienen</a>
@endsection
