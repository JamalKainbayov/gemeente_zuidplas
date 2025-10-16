@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Indienen van een klacht</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('complaint.store') }}" method="POST">
            @csrf
            <div>
                <label>Titel</label>
                <input type="text" name="title" required>
            </div>

            <div>
                <label>Beschrijving</label>
                <textarea name="description" required></textarea>
            </div>

            <div>
                <label>Locatie naam</label>
                <input type="text" name="location_name" required>
            </div>

            <div>
                <label>Klik op de kaart om de locatie te kiezen (binnen Zuidplas)</label>
                <div id="map" style="height: 400px; border-radius: 8px;"></div>
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div>
                <label>Naam (optioneel)</label>
                <input type="text" name="guest_name">
            </div>

            <div>
                <label>Email (optioneel)</label>
                <input type="email" name="guest_email">
            </div>

            <button type="submit">Verstuur</button>
        </form>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>

    <script>
        var map = L.map('map').setView([51.987, 4.613], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;


        var zuidplasPolygon = turf.polygon([[
            [4.55, 51.95],
            [4.70, 51.95],
            [4.70, 52.00],
            [4.55, 52.00],
            [4.55, 51.95]
        ]]);

        L.geoJSON(zuidplasPolygon, {
            color: 'blue',
            weight: 2,
            fillOpacity: 0.1
        }).addTo(map);

        map.on('click', function(e) {
            var point = turf.point([e.latlng.lng, e.latlng.lat]);
            if (turf.booleanPointInPolygon(point, zuidplasPolygon)) {
                if (marker) map.removeLayer(marker);
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            } else {
                alert('❌ Je kunt alleen een pin plaatsen binnen gemeente Zuidplas!');
            }
        });
    </script>
@endsection
