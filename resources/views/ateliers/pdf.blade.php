<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $facture->numero }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .info-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 20px;
        }
        .info-box {
            width: 94%;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .info-title {
            font-weight: bold;
            margin-bottom: 15px;
            color: #3498db;
            font-size: 1.1em;
            border-bottom: 1px dashed #3498db;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .total {
            text-align: left;
            font-weight: bold;
            font-size: 1.2em;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            margin-bottom: 30px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9em;
            color: #7f8c8d;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }
        .invoice-number {
            background-color: #3498db;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 0.9em;
            margin-top: 10px;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
        }
        .status-paid {
            background-color: #2ecc71;
            color: white;
        }
        .status-pending {
            background-color: #f39c12;
            color: white;
        }
        .status-unpaid {
            background-color: #e74c3c;
            color: white;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Vous pouvez ajouter un logo ici -->
        <!-- <img src="chemin/vers/logo.png" class="logo" alt="Logo Atelier"> -->
        <h1>Facture</h1>
        <div class="invoice-number">N° {{ $facture->id }}</div>
        <p>Date: {{ $facture->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="info-container">
        <div class="info-box">
            <div class="info-title">Atelier</div>
            <p><strong>Nom:</strong> {{ $facture->atelier->nom_commercial ?? 'N/A' }}</p>
            <p><strong>Adresse:</strong> {{ $facture->atelier->ville }}</p>
            <p><strong>Email:</strong> {{ $facture->atelier->email }}</p>
            <p><strong>Téléphone:</strong> {{ $facture->atelier->phone ?? 'N/A' }}</p>
        </div>

        <div class="info-box">
            <div class="info-title">Client</div>
            <p><strong>Nom:</strong> {{ $facture->client->nom }} {{ $facture->client->prenom }}</p>
            <p><strong>Adresse:</strong> {{ $facture->client->adresse ?? 'N/A' }}</p>
            <p><strong>Téléphone:</strong> {{ $facture->client->phone ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $facture->client->email ?? 'N/A' }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Prix HT</th>
                <th>Remise</th>
                <th>Taxe</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $facture->type_service }}</td>
                <td>{{ number_format($facture->prix, 2, ',', ' ') }} €</td>
                <td>{{ number_format($facture->remise, 2, ',', ' ') }} €</td>
                <td>{{ number_format($facture->taxe, 2, ',', ' ') }} €</td>
                <td>{{ number_format($facture->montant_total, 2, ',', ' ') }} €</td>
            </tr>
        </tbody>
    </table>



    <div class="footer">
        <p>Merci pour votre confiance. Nous vous remercions pour votre fidélité.</p>
        <p><strong>{{ $facture->atelier->nom_commercial ?? 'Notre atelier' }}</strong></p>
        <p>Pour toute question concernant cette facture, veuillez nous contacter à {{ $facture->atelier->email ?? 'notre email' }}</p>
    </div>
</body>
</html>
