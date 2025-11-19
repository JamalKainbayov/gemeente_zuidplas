@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Klacht Indienen</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white py-4">
                        <h2 class="mb-0"><i class="bi bi-pencil-square me-2" aria-hidden="true"></i>Melding indienen — Gemeente Zuidplas</h2>
                        <p class="mb-0 small opacity-75">Gebruik dit formulier om een openbare klacht of melding bij de gemeente door te geven.</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form action="{{ Route::has('complaint.store') ? route('complaint.store') : url('/complaints') }}" method="POST" id="complaintForm">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="title" class="form-label fw-semibold">Titel <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                               id="title" name="title" value="{{ old('title') }}"
                                               placeholder="Korte omschrijving van de klacht" required>
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label fw-semibold">Beschrijving <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description" rows="5"
                                                  placeholder="Gedetailleerde beschrijving van de klacht" required>{{ old('description') }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="location_name" class="form-label fw-semibold">Locatie in Zuidplas <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                            <input type="text" class="form-control @error('location_name') is-invalid @enderror"
                                                   id="location_name" name="location_name" value="{{ old('location_name') }}"
                                                   placeholder="Klik op de kaart om een locatie te selecteren" required readonly>
                                        </div>
                                        @error('location_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        <div id="map" class="border rounded shadow-sm mb-2" style="height: 500px;"></div>
                                        <small class="text-muted d-block">
                                            <i class="bi bi-info-circle"></i> Klik op de kaart binnen gemeente Zuidplas om de exacte locatie van de klacht te selecteren
                                        </small>
                                        <div id="location-error" class="alert alert-warning d-none mt-2">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Let op: Selecteer alleen een locatie binnen gemeente Zuidplas
                                        </div>
                                    </div>

                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label for="guest_name" class="form-label fw-semibold">Naam</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                                <input type="text" class="form-control @error('guest_name') is-invalid @enderror"
                                                       id="guest_name" name="guest_name" value="{{ old('guest_name') }}"
                                                       placeholder="Uw naam (optioneel)">
                                            </div>
                                            @error('guest_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="guest_email" class="form-label fw-semibold">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                                <input type="email" class="form-control @error('guest_email') is-invalid @enderror"
                                                       id="guest_email" name="guest_email" value="{{ old('guest_email') }}"
                                                       placeholder="uw@email.nl (optioneel)">
                                            </div>
                                            @error('guest_email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled aria-label="Verstuur melding">
                                            <i class="bi bi-send-fill me-2" aria-hidden="true"></i>Verstuur melding
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-2">Hulp nodig?</h6>
                                        <p class="small mb-2">Bel 14 0182 (lokaal tarief) of stuur een e-mail naar <a href="mailto:gemeente@zuidplas.nl">gemeente@zuidplas.nl</a>.</p>
                                        <p class="small mb-0"><strong>Openingstijden:</strong><br>Ma–Vr 09:00–16:00</p>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body small">
                                        <strong>Privacy</strong>
                                        <p class="mb-0">Uw gegevens worden gebruikt om deze melding te behandelen. Lees onze <a href="#">privacyverklaring</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="map" class="border rounded shadow-sm mb-2" style="height: 500px;"></div>
                        <small class="text-muted d-block">
                            <i class="bi bi-info-circle"></i> Klik op de kaart binnen gemeente Zuidplas om de exacte locatie van de klacht te selecteren
                        </small>
                        <div id="location-error" class="alert alert-warning d-none mt-2">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Let op: Selecteer alleen een locatie binnen gemeente Zuidplas
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .breadcrumb {
            background: transparent;
            padding-left: 0;
            padding-right: 0;
            margin-bottom: 0.75rem;
            --bs-breadcrumb-divider: "›";
        }
        .card-header.bg-primary {
            background: linear-gradient(90deg, #0d6efd 0%, #0b5ed7 100%);
        }

        /* Kaart container styling */
        #map {
            height: 500px;
            border: 2px solid #dee2e6;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            position: relative;
            z-index: 1;
        }

        /* Leaflet controls styling */
        .leaflet-control-zoom {
            border: none !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important;
        }

        .leaflet-control-zoom a {
            background-color: #fff !important;
            color: #0d6efd !important;
            border: none !important;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .leaflet-control-zoom a:hover {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        /* Custom marker animatie */
        .custom-marker {
            animation: markerPulse 2s infinite;
        }

        @keyframes markerPulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        /* Gemeente label styling */
        .gemeente-label {
            z-index: 1000;
            pointer-events: none;
        }

        /* Card styling improvements */
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 3px solid rgba(255, 255, 255, 0.2);
        }

        /* Form improvements */
        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
            background-color: #e7f1ff;
        }

        /* Button styling */
        #submitBtn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        #submitBtn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        }

        #submitBtn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Alert styling */
        .alert {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        #location-error {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Label styling */
        .form-label {
            margin-bottom: 0.5rem;
            color: #495057;
            font-size: 0.95rem;
        }

        /* Required field indicator */
        .text-danger {
            font-weight: bold;
        }

        /* Placeholder styling */
        ::placeholder {
            color: #adb5bd !important;
            opacity: 1;
        }

        /* Map boundary rectangle hover effect */
        .leaflet-interactive:hover {
            stroke-width: 3 !important;
        }

        /* Bootstrap icons in input groups */
        .input-group-text i {
            color: #6c757d;
            transition: color 0.3s ease;
        }

        .input-group:focus-within .input-group-text i {
            color: #0d6efd;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            #map {
                height: 400px;
            }

            .card-header h2 {
                font-size: 1.5rem;
            }

            .gemeente-label div {
                font-size: 0.85rem;
                padding: 3px 8px !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const zuidplasBounds = {
            north: 52.0650,
            south: 51.9500,
            east: 4.6800,
            west: 4.5500
        };

        let map = L.map('map', {
            center: [52.0070, 4.6170],
            zoom: 13,
            dragging: false,
            touchZoom: true,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            boxZoom: false,
            keyboard: false,
            zoomControl: true,
            maxBounds: [
                [zuidplasBounds.south - 0.01, zuidplasBounds.west - 0.01],
                [zuidplasBounds.north + 0.01, zuidplasBounds.east + 0.01]
            ],
            maxBoundsViscosity: 1.0
        });

        let marker = null;
        let selectedLocation = false;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            minZoom: 11,
            maxZoom: 18
        }).addTo(map);

        const boundaryRectangle = L.rectangle([
            [zuidplasBounds.south, zuidplasBounds.west],
            [zuidplasBounds.north, zuidplasBounds.east]
        ], {
            color: '#0d6efd',
            weight: 2,
            fillOpacity: 0.05,
            dashArray: '5, 10'
        }).addTo(map);

        L.marker([52.0270, 4.6000], {
            icon: L.divIcon({
                className: 'gemeente-label',
                html: '<div style="background: rgba(13, 110, 253, 0.9); color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; white-space: nowrap;">Gemeente Zuidplas</div>',
                iconSize: [150, 30]
            })
        }).addTo(map);

        function isWithinZuidplas(lat, lng) {
            return lat >= zuidplasBounds.south &&
                lat <= zuidplasBounds.north &&
                lng >= zuidplasBounds.west &&
                lng <= zuidplasBounds.east;
        }

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            if (!isWithinZuidplas(lat, lng)) {
                document.getElementById('location-error').classList.remove('d-none');
                setTimeout(() => {
                    document.getElementById('location-error').classList.add('d-none');
                }, 3000);
                return;
            }

            document.getElementById('location-error').classList.add('d-none');
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            selectedLocation = true;
            document.getElementById('submitBtn').disabled = false;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng], {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: '<div style="background-color: #dc3545; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                })
            }).addTo(map);

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    const address = data.address;
                    let locationName = '';

                    if (address.road) locationName += address.road;
                    if (address.house_number) locationName += ' ' + address.house_number;
                    if (address.village || address.town || address.city) {
                        locationName += ', ' + (address.village || address.town || address.city);
                    }

                    document.getElementById('location_name').value = locationName || data.display_name;
                })
                .catch(error => {
                    document.getElementById('location_name').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                });
        });

        document.getElementById('complaintForm').addEventListener('submit', function(e) {
            if (!selectedLocation) {
                e.preventDefault();
                alert('Selecteer eerst een locatie op de kaart binnen gemeente Zuidplas');
            }
        });
    </script>
@endpush
