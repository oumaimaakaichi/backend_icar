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
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-content {
            flex: 1;
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

        .max-requests-btn {
            background: #1e293b;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .max-requests-btn:hover {
            background: #0f172a;
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

        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .popup {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 450px;
            padding: 0;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .popup-overlay.active .popup {
            transform: translateY(0);
        }

        .popup-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .popup-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .close-btn {
            background: none;
            border: none;
            color: #64748b;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .close-btn:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .popup-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .popup-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            font-size: 0.95rem;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-primary {
            background: #1e293b;
            color: white;
        }

        .btn-primary:hover {
            background: #0f172a;
        }

        .current-value {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #64748b;
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

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
            }

            .max-requests-btn {
                align-self: flex-start;
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

    <div class="container-fluid py-4" style="margin-top: 80px ; margin-right:100px">
        <div class="main-card" style="margin-right: 80px">
            <div class="header">
                <div class="header-content">
                    <h2><i class="fas fa-clock"></i> Availability Management</h2>
                    <p>Set up your time slots for each day of the week</p>
                </div>
                <button type="button" class="max-requests-btn" id="maxRequestsBtn">
                    <i class="fas fa-sliders-h"></i> Max Requests Per Day
                </button>
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

    <!-- Popup for Max Requests Per Day -->
    <div class="popup-overlay" id="maxRequestsPopup">
        <div class="popup">
            <div class="popup-header">
                <h3><i class="fas fa-sliders-h"></i> Max Requests Per Day</h3>
                <button type="button" class="close-btn" id="closePopup">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="popup-body">
                <div class="form-group">
                    <label for="maxRequests">Maximum requests per day</label>
                    <input type="number" id="maxRequests" class="form-control" min="1" max="50" required>
                    <div class="current-value" id="currentValue">Current value: <span id="currentValueSpan">Loading...</span></div>
                </div>
            </div>
            <div class="popup-footer">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveMaxRequestsBtn">Save</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Popup functionality
            const maxRequestsBtn = document.getElementById('maxRequestsBtn');
            const maxRequestsPopup = document.getElementById('maxRequestsPopup');
            const closePopup = document.getElementById('closePopup');
            const cancelBtn = document.getElementById('cancelBtn');
            const saveMaxRequestsBtn = document.getElementById('saveMaxRequestsBtn');
            const maxRequestsInput = document.getElementById('maxRequests');
            const currentValueSpan = document.getElementById('currentValueSpan');

            // Open popup
            maxRequestsBtn.addEventListener('click', function() {
                loadCurrentMaxRequests();
                maxRequestsPopup.classList.add('active');
            });

            // Close popup
            function closeMaxRequestsPopup() {
                maxRequestsPopup.classList.remove('active');
            }

            closePopup.addEventListener('click', closeMaxRequestsPopup);
            cancelBtn.addEventListener('click', closeMaxRequestsPopup);

            // Load current max requests value
            async function loadCurrentMaxRequests() {
                try {
                    const response = await fetch("{{ route('atelier.max-demandes.get') }}", {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        currentValueSpan.textContent = result.nbr_max_demande_par_jour;
                        maxRequestsInput.value = result.nbr_max_demande_par_jour;
                    } else {
                        throw new Error(result.message || 'Error loading current value');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    currentValueSpan.textContent = 'Error';
                }
            }

            // Save max requests
            saveMaxRequestsBtn.addEventListener('click', async function() {
                const value = parseInt(maxRequestsInput.value);

                if (isNaN(value) || value < 1 || value > 50) {
                    alert('Please enter a valid number between 1 and 50');
                    return;
                }

                saveMaxRequestsBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                saveMaxRequestsBtn.disabled = true;

                try {
                    const response = await fetch("{{ route('atelier.max-demandes.set') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            nbr_max_demande_par_jour: value
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        currentValueSpan.textContent = value;
                        closeMaxRequestsPopup();

                        // Show success notification
                        const alert = document.getElementById('successAlert');
                        alert.querySelector('span').textContent = 'Maximum requests per day updated successfully!';
                        alert.style.display = 'flex';
                        setTimeout(() => { alert.style.display = 'none'; }, 3000);
                    } else {
                        throw new Error(result.message || 'Error saving value');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                } finally {
                    saveMaxRequestsBtn.innerHTML = 'Save';
                    saveMaxRequestsBtn.disabled = false;
                }
            });

            // Add time slot
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
                            <span class="separator">to</span>
                            <input type="time" class="time-input" value="12:00">
                            <button type="button" class="remove-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;

                container.insertAdjacentHTML('beforeend', slotHtml);
            }

            // Remove time slot
            function removeTimeSlot(slotItem) {
                const container = slotItem.parentElement;
                slotItem.style.animation = 'fadeIn 0.2s ease-out reverse';

                setTimeout(() => {
                    slotItem.remove();

                    // Show empty state if no more slots
                    if (container.children.length === 0) {
                        const day = container.id.replace('-slots', '');
                        const isSunday = day === 'dimanche';
                        container.innerHTML = `
                            <div class="empty-state">
                                ${isSunday ? 'Closed' : 'No slots defined'}
                            </div>
                        `;
                    }
                }, 200);
            }

            // Event handlers
            document.addEventListener('click', function(e) {
                // Add button
                if (e.target.closest('.add-btn')) {
                    e.preventDefault();
                    const day = e.target.closest('.add-btn').dataset.day;
                    addTimeSlot(day);
                }

                // Remove button
                if (e.target.closest('.remove-btn')) {
                    e.preventDefault();
                    const slotItem = e.target.closest('.slot-item');
                    removeTimeSlot(slotItem);
                }
            });

            // Form submission
            document.getElementById('availabilityForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const saveBtn = document.querySelector('.save-btn');
                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                saveBtn.disabled = true;

                // Prepare data to send
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
                        // Update display with new data
                        updateAvailabilityDisplay(result.availability);

                        // Show notification
                        const alert = document.getElementById('successAlert');
                        alert.querySelector('span').textContent = 'Changes saved successfully!';
                        alert.style.display = 'flex';
                        setTimeout(() => { alert.style.display = 'none'; }, 3000);
                    } else {
                        throw new Error(result.message || 'Server error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                } finally {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                }
            });

            // Time validation
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

        // Function to update availability display
        function updateAvailabilityDisplay(availability) {
            const days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

            days.forEach(day => {
                const container = document.getElementById(`${day}-slots`);
                container.innerHTML = ''; // Clear container

                if (availability[day] && availability[day].length > 0) {
                    availability[day].forEach(slot => {
                        const slotHtml = `
                            <div class="slot-item">
                                <div class="time-group">
                                    <input type="time" class="time-input" value="${slot.start}">
                                    <span class="separator">to</span>
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
                            ${day === 'dimanche' ? 'Closed' : 'No slots defined'}
                        </div>
                    `;
                }
            });
        }
    </script>
</body>
</html>
