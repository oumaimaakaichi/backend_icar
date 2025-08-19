<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Disponibilités</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            color: #1e293b;
            display: flex;
        }

        .container {
            flex: 1;
            padding: 2rem;
            margin-left: 280px; /* Ajustez selon la largeur de votre sidebar */
        }

        .main-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .header {
            background: #ffffff;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header p {
            color: #64748b;
            margin-top: 0.5rem;
            font-size: 0.95rem;
        }

        .content {
            padding: 1.5rem 2rem;
        }

        .notification {
            background: #f0fdf4;
            color: #166534;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: 1px solid #bbf7d0;
            display: none;
        }

        .days-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .day-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .day-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .day-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .day-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
        }

        .add-btn {
            background: #f1f5f9;
            color: #334155;
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-btn:hover {
            background: #e2e8f0;
        }

        .slots-container {
            padding: 1rem;
            min-height: 80px;
        }

        .slot-item {
            margin-bottom: 0.75rem;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .time-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #f8fafc;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .time-input {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 0.5rem;
            font-size: 0.9rem;
            background: white;
            font-family: inherit;
            flex: 1;
            max-width: 100px;
        }

        .time-input:focus {
            outline: none;
            border-color: #94a3b8;
        }

        .separator {
            color: #64748b;
            font-size: 0.9rem;
        }

        .remove-btn {
            background: #fee2e2;
            color: #b91c1c;
            border: none;
            padding: 0.5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-btn:hover {
            background: #fecaca;
        }

        .empty-state {
            text-align: center;
            color: #94a3b8;
            font-size: 0.9rem;
            padding: 1.5rem 0;
        }

        .save-section {
            text-align: right;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .save-btn {
            background: #1e293b;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .save-btn:hover {
            background: #0f172a;
        }

        .save-btn:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
        }

        @media (max-width: 1024px) {
            .container {
                margin-left: 0;
                padding: 1rem;
            }

            .days-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .time-group {
                flex-wrap: wrap;
            }

            .time-input {
                max-width: none;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="container-fluid py-4" style="margin-top: 50px">
        <div class="main-card">
            <div class="header">
                <h2><i class="fas fa-clock"></i> Availability Management</h2>
<p>Set up your time slots for each day of the week</p>

            </div>

            <div class="content">
               <div class="notification" id="successAlert">
    <i class="fas fa-check-circle"></i>
    <span>Changes saved successfully!</span>
</div>

<form id="availabilityForm">
    <div class="days-grid">
        @php
            $days = [
                'lundi' => 'Monday',
                'mardi' => 'Tuesday',
                'mercredi' => 'Wednesday',
                'jeudi' => 'Thursday',
                'vendredi' => 'Friday',
                'samedi' => 'Saturday',
                'dimanche' => 'Sunday'
            ];
        @endphp

        @foreach($days as $dayKey => $dayName)
            <div class="day-card">
                <div class="day-header">
                    <h3>{{ $dayName }}</h3>
                    <button type="button" class="add-btn" data-day="{{ $dayKey }}">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
                <div class="slots-container" id="{{ $dayKey }}-slots">
                    @if(isset($availability[$dayKey]) && count($availability[$dayKey]) > 0)
                        @foreach($availability[$dayKey] as $slot)
                            <div class="slot-item">
                                <div class="time-group">
                                    <input type="time" class="time-input" value="{{ $slot['start'] }}">
                                    <span class="separator">to</span>
                                    <input type="time" class="time-input" value="{{ $slot['end'] }}">
                                    <button type="button" class="remove-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            {{ $dayKey === 'dimanche' ? 'Closed' : 'No slots defined' }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="save-section">
        <button type="submit" class="save-btn">
            <i class="fas fa-save"></i>
            Save Update
        </button>
    </div>
</form>

            </div>
        </div>
    </div>
<script>
   document.getElementById('availabilityForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const saveBtn = document.querySelector('.save-btn');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
    saveBtn.disabled = true;

    // Préparer les données à envoyer
    const availabilityData = {};
    const days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

    days.forEach(day => {
        const container = document.getElementById(`${day}-slots`);
        const timeGroups = container.querySelectorAll('.time-group');
        availabilityData[day] = [];

        timeGroups.forEach(group => {
            const inputs = group.querySelectorAll('.time-input');
            if (inputs[0].value && inputs[1].value) {
                availabilityData[day].push({
                    start: inputs[0].value,
                    end: inputs[1].value
                });
            }
        });
    });

    try {
        const response = await fetch("{{ route('atelier.availability.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(availabilityData)
        });

        const result = await response.json();

        if (response.ok) {
            // Mettre à jour l'affichage avec les nouvelles données
            updateAvailabilityDisplay(result.availability);

            // Afficher notification
            const alert = document.getElementById('successAlert');
            alert.style.display = 'flex';
            setTimeout(() => { alert.style.display = 'none'; }, 3000);
        } else {
            throw new Error(result.message || 'Erreur serveur');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Erreur: ' + error.message);
    } finally {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    }
});

// Fonction pour mettre à jour l'affichage
function updateAvailabilityDisplay(availability) {
    const days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

    days.forEach(day => {
        const container = document.getElementById(`${day}-slots`);
        container.innerHTML = ''; // Vider le conteneur

        if (availability[day] && availability[day].length > 0) {
            availability[day].forEach(slot => {
                const slotHtml = `
                    <div class="slot-item">
                        <div class="time-group">
                            <input type="time" class="time-input" value="${slot.start}">
                            <span class="separator">à</span>
                            <input type="time" class="time-input" value="${slot.end}">
                            <button type="button" class="remove-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', slotHtml);
            });
        } else {
            container.innerHTML = `
                <div class="empty-state">
                    ${day === 'dimanche' ? 'Fermé' : 'Aucun créneau défini'}
                </div>
            `;
        }
    });
}
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter un créneau horaire
            function addTimeSlot(day) {
                const container = document.getElementById(`${day}-slots`);
                const emptyState = container.querySelector('.empty-state');

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

            // Supprimer un créneau horaire
            function removeTimeSlot(slotItem) {
                const container = slotItem.parentElement;
                slotItem.style.animation = 'fadeIn 0.2s ease-out reverse';

                setTimeout(() => {
                    slotItem.remove();

                    // Afficher l'état vide si plus de créneaux
                    if (container.children.length === 0) {
                        const day = container.id.replace('-slots', '');
                        const isSunday = day === 'dimanche';
                        container.innerHTML = `
                            <div class="empty-state">
                                ${isSunday ? 'Fermé' : 'Aucun créneau défini'}
                            </div>
                        `;
                    }
                }, 200);
            }

            // Gestion des événements
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

            // Soumission du formulaire
            document.getElementById('availabilityForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const saveBtn = document.querySelector('.save-btn');
                const originalText = saveBtn.innerHTML;

                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
                saveBtn.disabled = true;

                // Simulation d'enregistrement (remplacer par un appel AJAX réel)
                setTimeout(() => {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;

                    // Afficher la notification
                    const alert = document.getElementById('successAlert');
                    alert.style.display = 'flex';

                    // Masquer après 3 secondes
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 3000);
                }, 1500);
            });

            // Validation des heures
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('time-input')) {
                    const timeGroup = e.target.closest('.time-group');
                    const startInput = timeGroup.querySelector('.time-input:first-of-type');
                    const endInput = timeGroup.querySelector('.time-input:last-of-type');

                    if (startInput.value && endInput.value && startInput.value >= endInput.value) {
                        startInput.style.borderColor = '#ef4444';
                        endInput.style.borderColor = '#ef4444';

                        setTimeout(() => {
                            startInput.style.borderColor = '#e2e8f0';
                            endInput.style.borderColor = '#e2e8f0';
                        }, 2000);
                    }
                }
            });
        });
    </script>
</body>
</html>
