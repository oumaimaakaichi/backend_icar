<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Report</title>
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
            border-bottom: 2px solid #3498db;
        }
        .title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .subtitle {
            font-size: 16px;
            color: #7f8c8d;
            font-weight: 500;
        }
        .info {
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
            padding-bottom: 8px;
            border-bottom: 2px solid #3498db;
            font-size: 18px;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 14px;
            border-top: 1px solid #e1e1e1;
            padding-top: 20px;
            color: #7f8c8d;
        }
        .two-columns {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            gap: 20px;
        }
        .column {
            flex: 1;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-left: 4px solid #3498db;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table th {
            background-color: #2c3e50;
            color: white;
            text-align: left;
            padding: 12px 15px;
            font-weight: 600;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f7fd;
        }
        .description-box {
            border: 1px solid #e1e1e1;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.6;
            min-height: 120px;
        }
        .signature-container {
            margin-top: 80px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px dashed #7f8c8d;
            width: 300px;
            display: inline-block;
            margin-bottom: 5px;
        }
        .signature-name {
            font-family: 'Brush Script MT', cursive;
            font-size: 24px;
            color: #2c3e50;
            margin-top: -5px;
        }
        .signature-label {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 2px;
            font-style: italic;
        }
        .highlight {
            background-color: #e3f2fd;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-completed {
            background-color: #4CAF50;
            color: white;
        }
        .status-pending {
            background-color: #FF9800;
            color: white;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #3498db;
            letter-spacing: 2px;
        }
        .total-row {
            font-weight: 700;
            background-color: #e8f4fc !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <div class="logo">MAINTENANCE PRO</div>
        </div>

        <div class="header">
            <div class="title">Maintenance Report</div>
            <div class="subtitle">Generated on: {{ $date }}</div>
        </div>

        <div class="two-columns">
            <div class="column">
                <div class="section">
                    <div class="section-title">Technician</div>
                    <div><strong>Name:</strong> <span class="highlight">{{ $rapport->technicien->nom }} {{ $rapport->technicien->prenom }}</span></div>
                    <div><strong>Phone:</strong> {{ $rapport->technicien->phone ?? 'Not specified' }}</div>
                    <div><strong>Email:</strong> {{ $rapport->technicien->email ?? 'Not specified' }}</div>
                </div>
            </div>

            <div class="column">
                <div class="section">
                    <div class="section-title">Client</div>
                    <div><strong>Name:</strong> <span class="highlight">{{ $rapport->demande->client->nom ?? 'Not specified' }} {{ $rapport->demande->client->prenom ?? 'Not specified' }}</span></div>
                    <div><strong>Phone:</strong> {{ $rapport->demande->client->phone ?? 'Not specified' }}</div>
                    <div><strong>Email:</strong> {{ $rapport->demande->client->email ?? 'Not specified' }}</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Request Details</div>
            <div class="two-columns">
                <div>
                    <div><strong>Service:</strong> {{ $rapport->demande->servicePanne->titre ?? 'Not specified' }}</div>
                    <div><strong>Category:</strong> {{ $rapport->demande->servicePanne->categoryPane->titre ?? 'Not specified' }}</div>
                </div>
                <div>
                    <div><strong>Location Type:</strong>
                        @php
                            $locationType = $rapport->demande->type_emplacement ?? '';
                            if($locationType == 'en_travail') {
                                echo 'At work';
                            } elseif($locationType == 'fixe') {
                                echo 'Fixed location';
                            } elseif($locationType == 'maison') {
                                echo 'At home';
                            } elseif($locationType == 'parking') {
                                echo 'Parking';
                            } elseif($locationType == 'quartier_général_privé') {
                                echo 'Private headquarters';
                            } else {
                                echo 'Not specified';
                            }
                        @endphp
                    </div>
                      </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Intervention</div>
            <div class="two-columns">
                <div>
                    <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($rapport->demande->date_maintenance)->format('d/m/Y') }}</div>
                    <div><strong>Time:</strong> {{ $rapport->demande->heure_maintenance }}</div>
                </div>

            </div>
        </div>

        @if(!empty($rapport->demande->pieces_choisies))
        <div class="section">
            <div class="section-title">Parts Used</div>
            <table>
                <thead>
                    <tr>
                        <th>Part</th>
                        <th>Type</th>
                        <th>Price (€)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapport->demande->pieces_choisies as $piece)
                        @php
                            $pieceCatalogue = $catalogues[$piece['piece_id']] ?? null;
                            $nomPiece = $pieceCatalogue->nom_piece ?? $piece['nom_piece'] ?? 'Part not specified';
                            $prixPiece = $piece['prix'] ?? $pieceCatalogue->prix ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $nomPiece }}</td>
                            <td>{{ $piece['type'] ?? 'Not specified' }}</td>
                            <td>{{ number_format($prixPiece, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right;">Total:</td>
                        <td>{{ number_format(array_sum(array_column($rapport->demande->pieces_choisies, 'prix')), 2) }} €</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        <div class="section">
            <div class="section-title">Work Description</div>
            <div class="description-box">
                {!! nl2br(e($rapport->description)) !!}
            </div>
        </div>



        <div class="footer">
            <div style="margin-bottom: 30px;">
                <div>Done at __________________________________</div>
                <div>On {{ \Carbon\Carbon::parse($rapport->demande->date_maintenance)->format('d/m/Y') }}</div>
            </div>
            <div class="signature-container">
                <div>Technician signature:</div>
                <div class="signature-line"></div>
                <div class="signature-name">{{ $rapport->technicien->nom }} {{ $rapport->technicien->prenom }}</div>
                <div class="signature-label">Certified Technician</div>
            </div>
        </div>
    </div>
</body>
</html>
