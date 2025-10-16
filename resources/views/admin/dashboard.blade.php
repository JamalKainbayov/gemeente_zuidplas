@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Titel</th>
                <th>Beschrijving</th>
                <th>Locatie</th>
                <th>Naam</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->id }}</td>
                    <td>{{ $complaint->title }}</td>
                    <td>{{ $complaint->description }}</td>
                    <td>{{ $complaint->location_name }}</td>
                    <td>{{ $complaint->guest_name }}</td>
                    <td>{{ $complaint->guest_email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
