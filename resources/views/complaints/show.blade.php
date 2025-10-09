@extends('layouts.app')

@section('content')
    <h2>Klacht #{{ $complaint->id }}</h2>

    <p><strong>Naam:</strong> {{ $complaint->name }}</p>
    <p><strong>Email:</strong> {{ $complaint->email }}</p>
    <p><strong>Onderwerp:</strong> {{ $complaint->subject }}</p>
    <p><strong>Beschrijving:</strong><br>{{ $complaint->description }}</p>
    <p><strong>Status:</strong> {{ $complaint->status }}</p>

    <a href="{{ route('complaints.index') }}">Terug naar overzicht</a>
@endsection
