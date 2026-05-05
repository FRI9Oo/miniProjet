<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du temps — {{ $filiere->nom }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #1a1a2e;
        }
        .header h1 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .header p { font-size: 12px; color: #666; }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #1a1a2e;
            color: #fff;
            padding: 8px 6px;
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .04em;
        }
        td {
            border: 1px solid #dde2ea;
            padding: 5px;
            vertical-align: top;
            min-height: 60px;
            height: 70px;
        }
        td.time-col {
            background: #f7f8fa;
            text-align: center;
            font-size: 10px;
            font-weight: 600;
            color: #666;
            width: 70px;
            vertical-align: middle;
        }
        .cours-box {
            background: rgba(233,69,96,0.08);
            border-left: 3px solid #e94560;
            border-radius: 4px;
            padding: 4px 6px;
            height: 100%;
        }
        .cours-box .matiere { font-weight: 700; font-size: 11px; }
        .cours-box .meta { font-size: 10px; color: #555; margin-top: 2px; }
        .footer {
            margin-top: 16px;
            font-size: 10px;
            color: #999;
            display: flex;
            justify-content: space-between;
        }
        .btn-print {
            display: block;
            margin: 0 auto 16px;
            padding: 8px 20px;
            background: #1a1a2e;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }
        @media print {
            .btn-print { display: none; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>

<button class="btn-print" onclick="window.print()">
    🖨️ Imprimer / Enregistrer en PDF
</button>

<div class="header">
    <h1>Emploi du temps — {{ $filiere->nom }} ({{ $filiere->code }})</h1>
    <p>ENSIASDT &nbsp;|&nbsp; Semestre {{ $filiere->semestre }} &nbsp;|&nbsp;
       Généré le {{ now()->locale('fr')->isoFormat('D MMMM YYYY') }}
    </p>
</div>

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
            <td class="time-col">
                {{ substr($creneau->heure_debut,0,5) }}<br>
                {{ substr($creneau->heure_fin,0,5) }}
            </td>
            @foreach($jours as $jour)
                @php $cours = $grid[$jour][$creneau->heure_debut] ?? null; @endphp
                <td>
                    @if($cours)
                        <div class="cours-box">
                            <div class="matiere">{{ $cours->matiere->nom }}</div>
                            <div class="meta">
                                {{ $cours->enseignant->nom_complet }}<br>
                                Salle : {{ $cours->salle->code }}
                            </div>
                        </div>
                    @endif
                </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <span>{{ $filiere->nom }} — {{ $filiere->code }}</span>
    <span>ENSIASDT © {{ date('Y') }}</span>
</div>

</body>
</html>