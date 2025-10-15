@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Indienen van een klacht</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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
                <label>Locatie</label>
                <input type="text" name="location_name" required>
            </div>

            <div id="map" style="height: 400px;"></div>
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

    @section('scripts')
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            var map = L.map('map').setView([51.987, 4.613], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker;
            var oldLat = document.getElementById('latitude').value;
            var oldLng = document.getElementById('longitude').value;
            if (oldLat && oldLng) {
                marker = L.marker([oldLat, oldLng]).addTo(map);
                map.setView([oldLat, oldLng], 14);
            }

            map.on('click', function(e) {
                if (marker) map.removeLayer(marker);
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
        </script>
    @endsection
@endsection
