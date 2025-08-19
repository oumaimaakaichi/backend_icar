<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #f9f9f9;
        }

        .receipt-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .receipt-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, #4a6bff, #00c6ff);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px dashed #ddd;
        }

        .logo {
            width: 120px;
            margin-bottom: 15px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .receipt-number {
            font-size: 16px;
            color: #7f8c8d;
        }

        .details {
            margin: 30px 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .detail-card {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .detail-label {
            font-weight: 600;
            color: #4a6bff;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .detail-value {
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background: linear-gradient(90deg, #4a6bff, #00c6ff);
            color: white;
            padding: 12px 15px;
            text-align: left;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .total-row {
            font-weight: bold;
            background-color: #f8fafc;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
            color: #7f8c8d;
            font-size: 14px;
        }

        .thank-you {
            font-size: 18px;
            color: #4a6bff;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .watermark {
            position: absolute;
            opacity: 0.05;
            font-size: 120px;
            font-weight: bold;
            color: #4a6bff;
            transform: rotate(-30deg);
            z-index: 0;
            top: 30%;
            left: 10%;
            pointer-events: none;
        }

        .stamp {
            position: absolute;
            right: 40px;
            bottom: 40px;
            opacity: 0.8;
            width: 120px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="watermark">PAIEMENT</div>

        <div class="header">
            <!-- Remplacez par le chemin de votre logo -->
            <img src="https://via.placeholder.com/120x60?text=LOGO" alt="Logo" class="logo">
            <div class="title">REÇU DE PAIEMENT</div>
            <div class="receipt-number">N° {{ $paiement->id }}</div>
        </div>

        <div class="details">
            <div class="detail-card">
                <div class="detail-label">Date</div>
                <div class="detail-value">{{ $paiement->date_paiement->format('d/m/Y H:i') }}</div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Méthode de paiement</div>
                <div class="detail-value">{{ ucfirst($paiement->methode) }}</div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Client</div>
                <div class="detail-value">{{ $client->prenom }} {{ $client->nom }}</div>
            </div>

            <div class="detail-card">
                <div class="detail-label">Véhicule</div>
                <div class="detail-value">{{ $voiture->company }} {{ $voiture->model }} ({{ $voiture->serie }})</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Réparation véhicule</td>
                    <td>{{ number_format($paiement->montant, 2, ',', ' ') }} DT</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td><strong>{{ number_format($paiement->montant, 2, ',', ' ') }} DT</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <div class="thank-you">Merci pour votre confiance !</div>
            <p>Service après-vente: contact@votreatelier.com | Tél: +216 00 000 000</p>
            <p>Ce reçu est valable comme justificatif de paiement</p>
        </div>

        <!-- Remplacez par le chemin de votre tampon -->
        <img src="https://www.bing.com/images/search?view=detailV2&ccid=6f84tZhJ&id=0DA260ACC7C852C0E4D32AA7D54901B3EA18F1BF&thid=OIP.6f84tZhJAKFWOO_8wsARFwAAAA&mediaurl=https%3A%2F%2Fth.bing.com%2Fth%2Fid%2FR.e9ff38b5984900a15638effcc2c01117%3Frik%3Dv%252fEY6rMBSdWnKg%26riu%3Dhttp%253a%252f%252fwww.photos.tampons.ws%252ftampon%252fr40-dateur.jpg%26ehk%3DgBs9J6EVfGq%252fa4PbGyyHg1jpHE0IdV%252bzJJm5A9QMLMk%253d%26risl%3D%26pid%3DImgRaw%26r%3D0&exph=300&expw=300&q=Tampon+d%27entreprise+PNG&form=IRPRST&ck=DD7572ED513A0748718DFE5E29212112&selectedindex=30&itb=0&cw=1375&ch=707&ajaxhist=0&ajaxserp=0&cit=ccid_hIh9O%2FV3*cp_16A9A14FBA7230799111D6D540D22989*mid_4E8ED94CA25C411165A6AC950D880FA655221687*thid_OIP.hIh9O!_V3m9ejy99VA7lwjgAAAA&vt=2" alt="Stamp" class="stamp">
   <br/>
   <br/>
    </div>
</body>
</html>
