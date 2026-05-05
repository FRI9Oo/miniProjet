<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Emploi du temps — {{ $filiere->code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 40px; color: #1a1a2e; }
        .print-btn { text-align: right; margin-bottom: 20px; }
        .print-btn button { padding: 10px 20px; background: #e94560; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #e94560; padding-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 14px; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1a1a2e; color: #fff; font-size: 12px; padding: 10px; text-align: center; }
        td { border: 1px solid #ddd; padding: 10px; font-size: 12px; vertical-align: top; height: 70px; }
        .horaire { background: #f7f8fa; text-align: center; font-weight: 600; width: 80px; }
        .cours-cell { background: #eeedfe; border-left: 3px solid #534ab7; border-radius: 4px; padding: 6px; }
        .matiere-name { font-weight: 700; font-size: 13px; color: #1a1a2e; }
        .cours-meta { font-size: 10px; color: #666; margin-top: 4px; }
        .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #eee; padding-top: 15px; }
        @media print {
            .print-btn { display: none; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="print-btn">
        <button onclick="window.print()">🖨️ Imprimer / Enregistrer PDF</button>
    </div>

    <div class="header">
        <h1>Emploi du temps — {{ $filiere->nom }} ({{ $filiere->code }})</h1>
        <p>Semestre {{ $filiere->semestre }} | Généré le {{ date('d/m/Y') }}</p>
    </div>

    @php $total = collect($grid)->flatten()->count(); @endphp

    @if($total > 0)
        <table>
            <thead>
                <tr>
                    <th>Horaire</th>
                    @foreach($jours as $jour)
                        <th>{{ $jour }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($creneaux as $creneau)
                <tr>
                    <td class="horaire">
                        {{ substr($creneau->heure_debut, 0, 5) }}<br>
                        <span style="font-weight:400;color:#999">{{ substr($creneau->heure_fin, 0, 5) }}</span>
                    </td>
                    @foreach($jours as $jour)
                        @php $cours = $grid[$jour][$creneau->heure_debut] ?? null; @endphp
                        <td>
                            @if($cours)
                                <div class="cours-cell">
                                    <div class="matiere-name">{{ $cours->matiere->nom }}</div>
                                    <div class="cours-meta">
                                        {{ $cours->enseignant->nom }} — {{ $cours->salle->code }}
                                    </div>
                                </div>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center;color:#999;padding:40px">Aucun cours planifié.</p>
    @endif

    <div class="footer">
        ENSIASDT — Gestion des Emplois du Temps | Généré automatiquement
    </div>
</body>
</html>