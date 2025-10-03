<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5;
            color: #2d3748;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7fafc;
        }

        .receipt-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 50px;
            position: relative;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .receipt-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px dashed #e2e8f0;
            position: relative;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .subtitle {
            font-size: 16px;
            color: #718096;
            font-weight: 500;
        }

        .receipt-number {
            position: absolute;
            top: 0;
            right: 0;
            background: #667eea;
            color: white;
            padding: 8px 16px;
            border-radius: 0 0 0 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }

        .detail-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            border: 1px solid #edf2f7;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            font-size: 16px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f7fafc;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 14px;
            color: #718096;
            font-weight: 500;
        }

        .detail-value {
            font-size: 15px;
            color: #2d3748;
            font-weight: 600;
        }

        .payment-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 40px 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .payment-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .payment-table td {
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f7;
            font-size: 15px;
        }

        .payment-table tr:last-child td {
            border-bottom: none;
        }

        .total-row {
            background: #f8fafc;
            font-weight: 700;
        }

        .total-row td {
            font-size: 16px;
            color: #2d3748;
        }

        .amount {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            padding-top: 30px;
            border-top: 2px dashed #e2e8f0;
            color: #718096;
            font-size: 14px;
        }

        .thank-you {
            font-size: 20px;
            color: #667eea;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .watermark {
            position: absolute;
            opacity: 0.03;
            font-size: 140px;
            font-weight: 900;
            color: #667eea;
            transform: rotate(-45deg);
            z-index: 0;
            top: 35%;
            left: 5%;
            pointer-events: none;
            font-family: 'Courier New', monospace;
        }

        .stamp {
            position: absolute;
            right: 40px;
            bottom: 40px;
            opacity: 0.9;
            width: 100px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #48bb78;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .signature-area {
            margin-top: 40px;
            text-align: right;
        }

        .signature-line {
            width: 200px;
            border-bottom: 1px solid #cbd5e0;
            margin: 40px 0 10px auto;
            padding-bottom: 5px;
        }

        .signature-label {
            font-size: 12px;
            color: #718096;
            text-align: center;
        }

        @media print {
            body {
                padding: 0;
                background: white;
            }
            
            .receipt-container {
                box-shadow: none;
                border: none;
                padding: 30px;
            }
            
            .watermark {
                opacity: 0.1;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="watermark">PAID</div>

        <div class="header">
            <div class="receipt-number">Receipt #{{ $paiement->id }}</div>
            
            <div class="logo-container">
                <div class="logo">MS</div>
            </div>
            
            <div class="title">PAYMENT RECEIPT</div>
            <div class="subtitle">Official Payment Confirmation</div>
        </div>

        <div class="details-grid">
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-calendar-alt"></i>
                    Payment Information
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date & Time</span>
                    <span class="detail-value">{{ $paiement->date_paiement->format('M d, Y H:i') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value">{{ ucfirst($paiement->methode) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="status-badge">Paid</span>
                </div>
            </div>

            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    Client Information
                </div>
                <div class="detail-item">
                    <span class="detail-label">Client Name</span>
                    <span class="detail-value">{{ $client->prenom }} {{ $client->nom }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Vehicle</span>
                    <span class="detail-value">{{ $voiture->company }} {{ $voiture->model }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Serial Number</span>
                    <span class="detail-value">{{ $voiture->serie }}</span>
                </div>
            </div>
        </div>

        <table class="payment-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Vehicle Repair Service</td>
                    <td class="amount">{{ number_format($paiement->montant, 2, '.', ',') }} €</td>
                </tr>
                <tr>
                    <td>Labor & Parts</td>
                    <td class="amount">Included</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Total Amount</strong></td>
                    <td class="amount"><strong>{{ number_format($paiement->montant, 2, '.', ',') }} €</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="signature-area">
            <div class="signature-line"></div>
            <div class="signature-label">Authorized Signature</div>
        </div>

        <div class="footer">
            <div class="thank-you">Thank You for Your Business!</div>
            
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>contact@yourgarage.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+216 12 345 678</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Tunis, Tunisia</span>
                </div>
            </div>
            
            <p>This receipt serves as official proof of payment. Please retain for your records.</p>
            <p style="font-size: 12px; color: #a0aec0; margin-top: 10px;">
                Generated on {{ now()->format('M d, Y H:i') }} | Transaction ID: {{ strtoupper(uniqid()) }}
            </p>
        </div>

        <!-- Stamp image -->
        <img src="https://via.placeholder.com/100x100/667eea/ffffff?text=PAID" alt="Paid Stamp" class="stamp">
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>