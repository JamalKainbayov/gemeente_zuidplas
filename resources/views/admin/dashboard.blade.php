@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
            <tr>
                <th>Titel</th>
                <th>Beschrijving</th>
                <th>Locatie</th>
                <th>Ingediend door</th>
                <th>Status</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            @foreach($complaints as $c)
                <tr>
                    <td>{{ $c->title }}</td>
                    <td>{{ $c->description }}</td>
                    <td>{{ $c->location_name }}</td>
                    <td>{{ $c->guest_name ?? ($c->user->name ?? 'Gast') }}</td>
                    <td>{{ $c->solved ? 'Opgelost' : 'Open' }}</td>
                    <td>
                        @if(!$c->solved)
                            <form action="{{ route('admin.complaints.solve', $c) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit">Markeer als opgelost</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
