<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Disponibilités</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .header {
            background: linear-gradient(135deg, #6f86a2 0%, #6f86a2 100%);
            color: white;
            padding: 32px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .atelier-info {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 24px 32px;
            border-bottom: 1px solid #e2e8f0;
        }

        .atelier-info h2 {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .atelier-info p {
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
        }

        .content {
            padding: 32px;
        }

        .success-alert {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .days-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .day-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
        }

        .day-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .day-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .day-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            flex-grow: 1;
        }

        .add-btn {
            background: linear-gradient(135deg, #6f86a2 0%, #6f86a2 100%);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
        }

        .slots-container {
            padding: 20px 24px;
            min-height: 80px;
        }

        .slot-item {
            margin-bottom: 16px;
            animation: slideInSlot 0.4s ease-out;
        }

        @keyframes slideInSlot {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .time-group {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8fafc;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .time-group:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .time-input {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            font-weight: 500;
        }

        .time-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .separator {
            color: #64748b;
            font-weight: 600;
            font-size: 1rem;
        }

        .remove-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .remove-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        }

        .empty-state {
            text-align: center;
            color: #94a3b8;
            font-style: italic;
            padding: 20px;
        }

        .save-section {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .save-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .save-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.4);
        }

        @media (max-width: 768px) {
            .days-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }

            .content {
                padding: 20px;
            }

            .time-group {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
</head>
<body>
      @include('Sidebar.sidebarAtelier')
    <div class="container" style="margin-top: 60px">
        <div class="main-card">
            <div class="header">
                <h1><i class="fas fa-clock"></i> Gestion des Disponibilités</h1>
                <p>Configurez vos créneaux horaires pour chaque jour de la semaine</p>
            </div>

            <div class="atelier-info">
                <h2><i class="fas fa-building"></i> Atelier Mécanique Pro</h2>
                <p><i class="fas fa-map-marker-alt"></i> Tunis, Tunisie</p>
            </div>

            <div class="content">
                <div class="success-alert" style="display: none;" id="successAlert">
                    <i class="fas fa-check-circle"></i>
                    <span>Modifications enregistrées avec succès!</span>
                </div>

                <form id="availabilityForm">
                  <div class="days-grid">
    @foreach(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $day)
        <div class="day-card">
            <div class="day-header">
                <h3>{{ ucfirst($day) }}</h3>
                <button type="button" class="add-btn" data-day="{{ $day }}">
                    <i class="fas fa-plus"></i> Ajouter
                </button>
            </div>
            <div class="slots-container" id="{{ $day }}-slots">
                @if(isset($availability[$day]) && count($availability[$day]) > 0)
                    @foreach($availability[$day] as $slot)
                        <div class="slot-item">
                            <div class="time-group">
                                <input type="time" class="time-input" value="{{ $slot['start'] }}">
                                <span class="separator">à</span>
                                <input type="time" class="time-input" value="{{ $slot['end'] }}">
                                <button type="button" class="remove-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        {{ $day === 'dimanche' ? 'Fermé' : 'Aucun créneau défini' }}
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

                    <div class="save-section">
                        <button type="submit" class="save-btn">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes au chargement
            const cards = document.querySelectorAll('.day-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            function addTimeSlot(day) {
                const container = document.getElementById(`${day}-slots`);
                const emptyState = container.querySelector('.empty-state');

                // Supprimer l'état vide s'il existe
                if (emptyState) {
                    emptyState.remove();
                }

                const slotHtml = `
                    <div class="slot-item">
                        <div class="time-group">
                            <input type="time" class="time-input" value="08:00">
                            <span class="separator">à</span>
                            <input type="time" class="time-input" value="12:00">
                            <button type="button" class="remove-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;

                container.insertAdjacentHTML('beforeend', slotHtml);
            }

            function removeTimeSlot(slotItem) {
                const container = slotItem.parentElement;
                slotItem.style.animation = 'slideInSlot 0.3s ease-out reverse';

                setTimeout(() => {
                    slotItem.remove();

                    // Si plus de créneaux, afficher l'état vide
                    if (container.children.length === 0) {
                        container.innerHTML = '<div class="empty-state">Aucun créneau défini</div>';
                    }
                }, 300);
            }

            // Déléguation des événements
            document.addEventListener('click', function(e) {
                // Bouton Ajouter
                if (e.target.closest('.add-btn')) {
                    e.preventDefault();
                    const day = e.target.closest('.add-btn').dataset.day;
                    addTimeSlot(day);
                }

                // Bouton Supprimer
                if (e.target.closest('.remove-btn')) {
                    e.preventDefault();
                    const slotItem = e.target.closest('.slot-item');
                    removeTimeSlot(slotItem);
                }
            });

            // Gestion du formulaire
            document.getElementById('availabilityForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Animation de chargement
                const saveBtn = document.querySelector('.save-btn');
                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
                saveBtn.disabled = true;

                // Simuler l'enregistrement
                setTimeout(() => {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;

                    // Afficher l'alerte de succès
                    const alert = document.getElementById('successAlert');
                    alert.style.display = 'flex';

                    // Masquer l'alerte après 3 secondes
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 3000);
                }, 1500);
            });

            // Validation des heures
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('time-input')) {
                    const timeGroup = e.target.closest('.time-group');
                    const startTime = timeGroup.querySelector('.time-input:first-of-type').value;
                    const endTime = timeGroup.querySelector('.time-input:last-of-type').value;

                    if (startTime && endTime && startTime >= endTime) {
                        e.target.style.borderColor = '#ef4444';
                        setTimeout(() => {
                            e.target.style.borderColor = '#e2e8f0';
                        }, 2000);
                    }
                }
            });
        });
    </script>
</body>
</html>
