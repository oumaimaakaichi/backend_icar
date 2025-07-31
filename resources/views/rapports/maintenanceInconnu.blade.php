<!DOCTYPE html>
<html>
<head>
    <title>Rapport de Maintenance</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fafafa;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e1e1e1;
        }
        .title {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 16px;
            color: #7f8c8d;
        }
        .info {
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
            padding-bottom: 5px;
            border-bottom: 2px solid #3498db;
            font-size: 18px;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 14px;
            border-top: 1px solid #e1e1e1;
            padding-top: 15px;
            color: #7f8c8d;
        }
        .two-columns {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .column {
            width: 48%;
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 14px;
        }
        table th {
            background-color: #3498db;
            color: white;
            text-align: left;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .description-box {
            border: 1px solid #e1e1e1;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 14px;
            line-height: 1.5;
        }
        .signature-container {
            margin-top: 60px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #7f8c8d;
            width: 250px;
            display: inline-block;
            margin-bottom: 5px;
        }
        .signature-name {
            font-family: 'Brush Script MT', cursive;
            font-size: 22px;
            color: #3498db;
            margin-top: -10px;
        }
        .signature-label {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: -5px;
        }
        .signature-line {
            border-top: 1px dashed #7f8c8d;
            width: 250px;
            display: inline-block;
            margin-top: 50px;
        }
        .highlight {
            background-color: #e3f2fd;
            padding: 2px 5px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">Rapport de Maintenance </div>
            <div class="subtitle">Généré le: {{ $date }}</div>
        </div>

        <div class="two-columns">
            <div class="column">
                <div class="section">
                    <div class="section-title">Technicien</div>
                    <div><strong>Nom:</strong> <span class="highlight">{{ $rapport->technicien->nom }}{{ $rapport->technicien->prenom }}</span></div>
                <div><strong>Téléphone:</strong> {{ $rapport->technicien->phone ?? 'Non spécifié' }}</div>

                </div>
            </div>

            <div class="column">
                <div class="section">
                    <div class="section-title">Client</div>
                    <div><strong>Nom:</strong> <span class="highlight">{{ $rapport->demande->client->nom ?? 'Non spécifié' }} {{ $rapport->demande->client->prenom ?? 'Non spécifié' }}</span></div>
                    <div><strong>Téléphone:</strong> {{ $rapport->demande->client->phone ?? 'Non spécifié' }}</div>
                </div>
            </div>
        </div>



        <div class="section">
            <div class="section-title">Intervention</div>
            <div class="two-columns">
                <div>
                    <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($rapport->demande->date_maintenance)->format('d/m/Y') }}</div>
                    <div><strong>Heure:</strong> {{ $rapport->demande->heure_maintenance }}</div>
                </div>
                <div>
                    <div><strong>Type d'emplacement:</strong> {{ $rapport->demande->type_emplacement }}</div>
                    <div><strong>Statut:</strong>
                        <span style="background-color:
                            @if($rapport->demande->status == 'Terminé') #2ecc71
                            @elseif($rapport->demande->status == 'En cours') #f39c12
                            @else #e74c3c
                            @endif;
                            color: white;
                            padding: 2px 8px;
                            border-radius: 3px;
                            font-size: 13px;">
                            {{ $rapport->demande->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($rapport->demande->pieces_selectionnees))
        <div class="section" style="margin-top: 50px">
            <div class="section-title">Pièces utilisées</div>
            <table>
                <thead>
                    <tr>
                        <th>Pièce</th>
                        <th>Type</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapport->demande->pieces_selectionnees as $piece)
                        @php
                            $pieceCatalogue = $catalogues[$piece['piece_id']] ?? null;
                            $nomPiece = $pieceCatalogue->nom_piece ?? $piece['nom_piece'] ?? 'Pièce non spécifiée';
                            $prixPiece = $piece['prix'] ?? $pieceCatalogue->prix ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $nomPiece }}</td>
                            <td>{{ $piece['type'] ?? 'Non spécifié' }}</td>
                            <td>{{ number_format($prixPiece, 2) }} €</td>
                        </tr>
                    @endforeach
                    <tr style="font-weight: 600;">
                        <td colspan="2" style="text-align: right;">Total:</td>
                        <td>{{ number_format(array_sum(array_column($rapport->demande->pieces_choisies, 'prix')), 2) }} €</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        <div class="section">
            <div class="section-title">Description des travaux</div>
            <div class="description-box">
                {!! nl2br(e($rapport->description)) !!}
            </div>
        </div>

        <div class="footer">
            <div style="margin-bottom: 30px;">
                <div>Fait à __________________________________</div>
                <div>Le {{ \Carbon\Carbon::parse($rapport->demande->date_maintenance)->format('d/m/Y') }}</div>
            </div>
            <div class="signature-container">
                 <div>Signature du technicien:</div>
                <div class="signature-line"> </div>
                <div class="signature-name">{{ $rapport->technicien->nom }}{{ $rapport->technicien->prenom }}</div>
                <div class="signature-label">Technicien certifié</div>
            </div>
        </div>
    </div>
</body>
</html>
