@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <div class="row mb-4">
            <div class="col">
                <h1 class="display-5 fw-bold text-primary mb-2">
                    <i class="bi bi-building me-2" aria-hidden="true"></i>Dashboard — Gemeente Zuidplas
                </h1>
                <p class="text-muted mb-0">Overzicht en beheer van meldingen en klachten — uitsluitend voor bevoegde medewerkers</p>
            </div>
            <div class="col-auto">
                <div class="badge bg-primary fs-6 px-3 py-2">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    {{ $complaints->count() }} Klachten
                </div>
            </div>
        </div>

        <div class="alert alert-info mb-3 shadow-sm" role="note">
            <i class="bi bi-info-circle-fill me-2"></i>
            Handelingen (verwijderen / markeren als opgelost) worden gelogd. Gebruik met verantwoordelijkheidszin.
        </div>

        <div class="row mb-3 g-3 align-items-center">
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="card shadow-sm metric-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <i class="bi bi-hourglass-split fs-3 text-warning"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">In behandeling</div>
                                    <div class="fs-4 fw-bold">{{ $complaints->where('status', '!=', 'resolved')->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card shadow-sm metric-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Opgelost</div>
                                    <div class="fs-4 fw-bold">{{ $complaints->where('status', 'resolved')->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-md-end">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input id="complaintSearch" type="text" class="form-control" placeholder="Zoeken op titel, locatie of indiener">
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient text-white py-3">
                <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Overzicht Klachten</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="fw-semibold ps-4">ID</th>
                            <th class="fw-semibold">Titel</th>
                            <th class="fw-semibold">Beschrijving</th>
                            <th class="fw-semibold">Locatie</th>
                            <th class="fw-semibold">Coördinaten</th>
                            <th class="fw-semibold">Ingediend Door</th>
                            <th class="fw-semibold">Datum</th>
                            <th class="fw-semibold text-center">Status</th>
                            <th class="fw-semibold text-center pe-4">Acties</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($complaints as $complaint)
                            <tr class="complaint-row">
                                <td class="ps-4">
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">#{{ $complaint->id }}</span>
                                </td>
                                <td class="fw-medium text-dark">
                                    {{ Str::limit($complaint->title, 30) }}
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($complaint->description, 60) }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                        <span class="text-truncate" style="max-width: 150px;">{{ $complaint->location_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted font-monospace">
                                        {{ number_format($complaint->latitude, 6) }},<br>
                                        {{ number_format($complaint->longitude, 6) }}
                                    </small>
                                </td>
                                <td>
                                    @if($complaint->guest_name || $complaint->guest_email)
                                        <div>
                                            <i class="bi bi-person-circle me-1"></i>
                                            <strong>{{ $complaint->guest_name ?? 'Anoniem' }}</strong>
                                        </div>
                                        @if($complaint->guest_email)
                                            <small class="text-muted d-block">
                                                <i class="bi bi-envelope me-1"></i>{{ $complaint->guest_email }}
                                            </small>
                                        @endif
                                    @else
                                        <span class="text-muted"><i class="bi bi-person-x me-1"></i>Anoniem</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ $complaint->created_at->format('d-m-Y') }}<br>
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $complaint->created_at->format('H:i') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    @if($complaint->status === 'resolved')
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="bi bi-check-circle-fill me-1"></i>Opgelost
                                        </span>
                                    @else
                                        <span class="badge bg-warning rounded-pill px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i>In behandeling
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('admin.complaint.resolve', $complaint) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn btn-sm btn-success"
                                                    @if($complaint->status === 'resolved') disabled @endif
                                                    title="Markeer als opgelost"
                                                    aria-label="Markeer klacht #{{ $complaint->id }} als opgelost">
                                                <i class="bi bi-check-lg" aria-hidden="true"></i>
                                            </button>
                                        </form>

                                        <!-- replaced modal button with direct Google Maps link -->
                                        <a href="https://www.google.com/maps?q={{ $complaint->latitude }},{{ $complaint->longitude }}"
                                           target="_blank"
                                           class="btn btn-sm btn-info text-white"
                                           title="Open in Google Maps"
                                           aria-label="Open locatie van klacht #{{ $complaint->id }} in Google Maps (nieuw tabblad)">
                                            <i class="bi bi-map"></i>
                                        </a>

                                        <form action="{{ route('admin.complaint.destroy', $complaint) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Weet je zeker dat je deze klacht wilt verwijderen?')"
                                                    title="Verwijderen"
                                                    aria-label="Verwijder klacht #{{ $complaint->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- removed Map Modal for admin to avoid loading maps -->
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox display-1 d-block mb-3 opacity-50"></i>
                                        <h4>Geen klachten gevonden</h4>
                                        <p class="mb-0">Er zijn momenteel geen klachten ingediend</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient {
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
        }

        .container-fluid {
            max-width: 1400px;
        }

        .card {
            border-radius: 1rem;
            overflow: hidden;
            border: none;
        }

        .card-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .table-responsive {
            border-radius: 0 0 1rem 1rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table > thead > tr > th {
            padding: 1rem 0.75rem;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #495057;
        }

        .table > tbody > tr > td {
            padding: 1.25rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .complaint-row {
            transition: all 0.2s ease;
            cursor: default;
            animation: fadeIn 0.3s ease;
        }

        .complaint-row:hover {
            background-color: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .badge {
            font-weight: 600;
            letter-spacing: 0.3px;
            padding: 0.5em 0.85em;
        }

        .badge.bg-secondary {
            background-color: #6c757d !important;
        }

        .badge.bg-success {
            background-color: #198754 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .btn-group .btn {
            transition: all 0.2s ease;
            padding: 0.5rem 0.75rem;
        }

        .btn-group .btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-group .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .modal-content {
            border-radius: 1rem;
            overflow: hidden;
            border: none;
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.175);
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 0;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
            padding: 1rem 1.5rem;
        }

        .text-truncate {
            display: inline-block;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .bi {
            vertical-align: middle;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .font-monospace {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            line-height: 1.6;
        }

        /* slight spacing for metric cards on dashboard */
        .metric-card .card-body { padding: 1rem; }
        /* improve table small-screen readability */
        @media (max-width: 768px) {
            .text-truncate { max-width: 120px; }
            .card-body { padding: 0.5rem; }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1200px) {
            .table > thead > tr > th,
            .table > tbody > tr > td {
                padding: 1rem 0.5rem;
                font-size: 0.875rem;
            }

            .text-truncate {
                max-width: 150px;
            }
        }

        @media (max-width: 992px) {
            .table-responsive {
                overflow-x: auto;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .card-body {
                padding: 0;
            }

            .btn-group .btn {
                padding: 0.375rem 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // small client-side filter for the complaints table (kept)
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('complaintSearch');
            if (!input) return;
            input.addEventListener('input', function () {
                const q = input.value.trim().toLowerCase();
                const rows = document.querySelectorAll('tbody tr.complaint-row');
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = q === '' || text.includes(q) ? '' : 'none';
                });
            });
        });
    </script>
@endpush
