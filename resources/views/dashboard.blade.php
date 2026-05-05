@extends('layouts.app')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #e94560, #c73652)">
            <i class="bi bi-person-badge stat-icon"></i>
            <div class="stat-value">{{ $stats['enseignants'] }}</div>
            <div class="stat-label">Enseignants</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #0f9b72, #0a7a5a)">
            <i class="bi bi-building stat-icon"></i>
            <div class="stat-value">{{ $stats['salles'] }}</div>
            <div class="stat-label">Salles</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #3b5bdb, #2f4ac0)">
            <i class="bi bi-diagram-3 stat-icon"></i>
            <div class="stat-value">{{ $stats['filieres'] }}</div>
            <div class="stat-label">Filières</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706)">
            <i class="bi bi-calendar-check stat-icon"></i>
            <div class="stat-value">{{ $stats['cours'] }}</div>
            <div class="stat-label">Cours planifiés</div>
        </div>
    </div>
</div>
@if(auth()->user()->isAdmin())
{{-- Quick Actions --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('emplois.create') }}" class="card text-decoration-none p-3 text-center" 
           style="background:rgba(233,69,96,0.08);border:1px solid rgba(233,69,96,0.2);border-radius:12px;transition:.2s;"
           onmouseover="this.style.background='rgba(233,69,96,0.15)';this.style.borderColor='#e94560'"
           onmouseout="this.style.background='rgba(233,69,96,0.08)';this.style.borderColor='rgba(233,69,96,0.2)'">
            <i class="bi bi-plus-circle" style="font-size:22px;color:#e94560"></i>
            <div style="color:#e94560;font-weight:600;font-size:13px;margin-top:6px">Ajouter un cours</div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('enseignants.create') }}" class="card text-decoration-none p-3 text-center" 
           style="background:rgba(15,155,114,0.08);border:1px solid rgba(15,155,114,0.2);border-radius:12px;transition:.2s;"
           onmouseover="this.style.background='rgba(15,155,114,0.15)';this.style.borderColor='#0f9b72'"
           onmouseout="this.style.background='rgba(15,155,114,0.08)';this.style.borderColor='rgba(15,155,114,0.2)'">
            <i class="bi bi-person-plus" style="font-size:22px;color:#0f9b72"></i>
            <div style="color:#0f9b72;font-weight:600;font-size:13px;margin-top:6px">Ajouter enseignant</div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('etudiant.emploi') }}" class="card text-decoration-none p-3 text-center" 
           style="background:rgba(59,91,219,0.08);border:1px solid rgba(59,91,219,0.2);border-radius:12px;transition:.2s;"
           onmouseover="this.style.background='rgba(59,91,219,0.15)';this.style.borderColor='#3b5bdb'"
           onmouseout="this.style.background='rgba(59,91,219,0.08)';this.style.borderColor='rgba(59,91,219,0.2)'">
            <i class="bi bi-calendar-week" style="font-size:22px;color:#3b5bdb"></i>
            <div style="color:#3b5bdb;font-weight:600;font-size:13px;margin-top:6px">Voir plannings</div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('creneaux.create') }}" class="card text-decoration-none p-3 text-center" 
           style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:12px;transition:.2s;"
           onmouseover="this.style.background='rgba(245,158,11,0.15)';this.style.borderColor='#f59e0b'"
           onmouseout="this.style.background='rgba(245,158,11,0.08)';this.style.borderColor='rgba(245,158,11,0.2)'">
            <i class="bi bi-clock" style="font-size:22px;color:#f59e0b"></i>
            <div style="color:#f59e0b;font-weight:600;font-size:13px;margin-top:6px">Ajouter créneau</div>
        </a>
    </div>
</div>
@endif

{{-- Charts --}}
<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Cours par jour
            </div>
            <div class="card-body d-flex justify-content-center">
                <div style="width:100%;max-width:500px;">
                    <canvas id="coursJourChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pie-chart me-2"></i>Cours par filière
            </div>
            <div class="card-body d-flex justify-content-center">
                <div style="width:100%;max-width:280px;">
                    <canvas id="coursFiliereChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@if(auth()->user()->isAdmin())
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-activity me-2"></i>Activité récente
            </div>
            <div class="card-body p-0">
                @if($recentActivities->isEmpty())
                    <div class="text-center py-4" style="color:#9499C3;font-size:13px;">
                        Aucune activité pour le moment.
                    </div>
                @else
                <table class="table mb-0">
    <thead>
        <tr>
            <th style="width:70px">Action</th>
            <th>Matière</th>
            <th>Enseignant</th>
            <th>Filière</th>
            <th>Salle</th>
            <th>Horaire</th>
            <th style="width:100px">Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recentActivities as $activity)
        @php
            // Parse description: "Matière — Enseignant — Filière — Jour HH:MM-HH:MM — Salle"
            $parts = explode(' — ', $activity->description);
            $matiere = $parts[0] ?? '—';
            $enseignant = $parts[1] ?? '—';
            $filiere = $parts[2] ?? '—';
            $horaire = $parts[3] ?? '—';
            $salle = $parts[4] ?? '—';
        @endphp
        <tr>
            <td>
                @if($activity->action === 'created')
                    <span style="background:rgba(15,155,114,0.12);color:#0f9b72;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;">Ajout</span>
                @elseif($activity->action === 'updated')
                    <span style="background:rgba(245,158,11,0.12);color:#f59e0b;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;">Modif</span>
                @else
                    <span style="background:rgba(233,69,96,0.12);color:#e94560;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;">Suppr</span>
                @endif
            </td>
            <td style="color:#9499C3;font-weight:500;font-size:13px;">{{ $matiere }}</td>
            <td style="color:#9499C3;font-size:13px;">{{ $enseignant }}</td>
            <td>
                <span style="background:#eeedfe;color:#534ab7;padding:2px 8px;border-radius:8px;font-size:11px;font-weight:600">{{ $filiere }}</span>
            </td>
            <td style="color:#9499C3;font-size:13px;">{{ $salle }}</td>
            <td style="color:#9499C3;font-size:12px;">{{ $horaire }}</td>
            <td style="color:#9499C3;font-size:11px;">{{ $activity->created_at->diffForHumans() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const coursJour    = @json($coursParJour);
const coursFiliere = @json($coursParFiliere);

new Chart(document.getElementById('coursJourChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(coursJour),
        datasets: [{
            label: 'Cours',
            data: Object.values(coursJour),
            backgroundColor: 'rgba(233,69,96,0.15)',
            borderColor: '#e94560',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

new Chart(document.getElementById('coursFiliereChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(coursFiliere),
        datasets: [{
            data: Object.values(coursFiliere),
            backgroundColor: ['#e94560','#0f9b72','#3b5bdb','#f59e0b'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 15, boxWidth: 12 } } }
    }
});
</script>
@endpush