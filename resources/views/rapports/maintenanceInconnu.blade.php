<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Maintenance Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #27ae60;
            --warning: #f39c12;
            --gray: #95a5a6;
            --light-gray: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 30px;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--secondary), var(--accent));
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            font-weight: 800;
            opacity: 0.03;
            color: var(--dark);
            pointer-events: none;
            z-index: 0;
            font-family: 'Montserrat', sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 25px;
            border-bottom: 2px solid var(--light);
            position: relative;
            z-index: 1;
        }

        .title {
            font-family: 'Montserrat', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
            letter-spacing: 1.5px;
        }

        .subtitle {
            font-size: 18px;
            color: var(--gray);
            font-weight: 500;
        }

        .report-id {
            background: var(--light);
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 15px;
            font-size: 14px;
            font-weight: 500;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .info-card {
            background: var(--light-gray);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-left: 5px solid var(--secondary);
        }

        .info-card.technician {
            border-left-color: var(--secondary);
        }

        .info-card.client {
            border-left-color: var(--accent);
        }

        .info-card.vehicle {
            border-left-color: var(--success);
        }

        .card-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary);
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 10px;
            font-size: 20px;
        }

        .info-item {
            margin-bottom: 12px;
            display: flex;
        }

        .info-label {
            font-weight: 600;
            min-width: 120px;
            color: var(--dark);
        }

        .info-value {
            color: #555;
        }

        .highlight {
            background-color: rgba(52, 152, 219, 0.1);
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 600;
            color: var(--secondary);
        }

        .section {
            margin-bottom: 35px;
            position: relative;
            z-index: 1;
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            margin-bottom: 0px;
            color: var(--primary);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary);
            font-size: 22px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 12px;
            color: var(--secondary);
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 5px;
        }

        .detail-item {
            padding: 15px;
            background: var(--light-gray);
            border-radius: 8px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .detail-value {
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        table th {
            background-color: var(--primary);
            color: white;
            text-align: left;
            padding: 16px 20px;
            font-weight: 600;
            font-family: 'Montserrat', sans-serif;
        }

        table td {
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f7fd;
        }

        .total-row {
            font-weight: 700;
            background-color: #e8f4fc !important;
            font-size: 16px;
        }

        .description-box {
            border: 1px solid #e1e1e1;
            padding: 25px;
            background-color: var(--light-gray);
            border-radius: 10px;
            font-size: 15px;
            line-height: 1.6;
            min-height: 150px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .signature-container {
            margin-top: 80px;
            text-align: right;
        }

        .signature-area {
            display: inline-block;
            text-align: center;
            margin-top: 30px;
        }

        .signature-line {
            border-top: 2px dashed var(--gray);
            width: 300px;
            display: block;
            margin-bottom: 10px;
            padding-top: 15px;
        }

        .signature-name {
            font-family: 'Brush Script MT', cursive;
            font-size: 28px;
            color: var(--primary);
            margin-top: -5px;
        }

        .signature-label {
            font-size: 14px;
            color: var(--gray);
            margin-top: 5px;
            font-style: italic;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 14px;
            border-top: 1px solid #e1e1e1;
            padding-top: 25px;
            color: var(--gray);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-completed {
            background-color: var(--success);
            color: white;
        }

        .status-pending {
            background-color: var(--warning);
            color: white;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 32px;
            font-weight: 800;
            color: var(--secondary);
            letter-spacing: 3px;
            display: inline-block;
            padding: 10px 20px;
            border: 3px solid var(--secondary);
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 20px;
            }

            .watermark {
                opacity: 0.1;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 25px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="watermark">VEHICLE MAINTENANCE REPORT</div>

        <div class="logo-container">
            <div class="logo">ICAR</div>
        </div>

        <div class="header">
            <h1 class="title">Vehicle Maintenance Report</h1>
            <div class="subtitle">Generated on: {{ $date }}</div>
        </div>

        <div class="info-grid">
            <div class="info-card technician">
                <h2 class="card-title"> Technician Information </h2>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span class="info-value highlight">{{ $rapport->technicien->nom }} {{ $rapport->technicien->prenom }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $rapport->technicien->phone ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $rapport->technicien->email ?? 'Not specified' }}</span>
                </div>
            </div>

            <div class="info-card client">
                <h2 class="card-title"> Client Information </h2>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span class="info-value highlight">{{ $rapport->demande->client->nom ?? 'Not specified' }} {{ $rapport->demande->client->prenom ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $rapport->demande->client->phone ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $rapport->demande->client->email ?? 'Not specified' }}</span>
                </div>
            </div>

            <div class="info-card vehicle">
                <h2 class="card-title"> Vehicle Information </h2>
                <div class="info-item">
                    <span class="info-label">Make & Model:</span>
                    <span class="info-value">{{ $rapport->demande->voiture->company ?? 'Not specified' }} {{ $rapport->demande->voiture->model ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Serial Number:</span>
                    <span class="info-value">{{ $rapport->demande->voiture->serie ?? 'Not specified' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Year:</span>
                    <span class="info-value">{{ $rapport->demande->voiture->date_fabrication ?? 'Not specified' }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title"> Intervention Details </h2>
            <div class="details-grid">
                <div class="detail-item">
                    <div class="detail-label">Date</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($rapport->demande->date_maintenance)->format('d/m/Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Time</div>
                    <div class="detail-value">{{ $rapport->demande->heure_maintenance ?? 'Not specified' }}</div>
                </div>
            </div>
        </div>

        @if(!empty($rapport->demande->pieces_selectionnees))
        <div class="section">
            <h2 class="section-title"> Parts Used </h2>
            <table>
                <thead>
                    <tr>
                        <th>Part Name</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Price (€)</th>
                        <th>Total (€)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCost = 0;
                    @endphp
                    @foreach($rapport->demande->pieces_selectionnees as $piece)
                        @php
                            $pieceCatalogue = $catalogues[$piece['piece_id']] ?? null;
                            $nomPiece = $pieceCatalogue->nom_piece ?? $piece['nom_piece'] ?? 'Not specified';
                            $prixPiece = $piece['prix'] ?? $pieceCatalogue->prix ?? 0;
                            $quantity = $piece['quantity'] ?? 1;
                            $pieceTotal = $prixPiece * $quantity;
                            $totalCost += $pieceTotal;
                        @endphp
                        <tr>
                            <td>{{ $nomPiece }}</td>
                            <td>{{ $piece['type'] ?? 'Not specified' }}</td>
                            <td>{{ $quantity }}</td>
                            <td>{{ number_format($prixPiece, 2) }}</td>
                            <td>{{ number_format($pieceTotal, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="4" style="text-align: right;">Parts Total:</td>
                        <td>{{ number_format($totalCost, 2) }} €</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="4" style="text-align: right;">Labor Cost:</td>
                        <td>{{ number_format(($rapport->demande->prix_total ?? 0) - $totalCost, 2) }} €</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
                        <td><strong>{{ number_format(($rapport->demande->prix_total ?? 0), 2) }} €</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        <div class="section">
            <h2 class="section-title"> Work Description </h2>
            <div class="description-box">
                {!! nl2br(e($rapport->description ?? 'No description provided.')) !!}
            </div>
        </div>

        <div class="signature-container">
            <div class="signature-area">
                <div class="signature-line"></div>
                <div class="signature-name">{{ $rapport->technicien->nom }} {{ $rapport->technicien->prenom }}</div>
                <div class="signature-label">Certified Technician</div>
            </div>
        </div>

        <div class="footer">
            <p>CARMASTERS Automobile Services • 123 Maintenance Street, 75001 Paris, France</p>
            <p>Phone: +33 1 23 45 67 89 • Email: contact@carmasters.fr • Website: www.carmasters.fr</p>
        </div>
    </div>
</body>
</html>
