<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Forfaits</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
        }

        .close-btn {
            cursor: pointer;
            font-size: 1.5rem;
            color: #6b7280;
        }

        .close-btn:hover {
            color: #374151;
        }

        /* Services list in modal */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .service-item {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .service-item:hover {
            background-color: #f9fafb;
        }

        .service-info {
            flex-grow: 1;
        }

        .service-name {
            font-weight: 500;
            color: #111827;
        }

        .service-price {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .service-checkbox {
            margin-left: 1rem;
        }

        /* Custom checkbox */
        .custom-checkbox {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            position: relative;
            cursor: pointer;
        }

        .custom-checkbox.checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .custom-checkbox.checked::after {
            content: "✓";
            position: absolute;
            color: white;
            font-size: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Forfait services list */
        .forfait-services {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .service-badge {
            background-color: #e0e7ff;
            color: #4f46e5;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
        }

        .service-badge i {
            margin-right: 0.25rem;
            font-size: 0.6rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r  to-indigo-800 text-white shadow-lg" style="background-color: #5e8899">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-boxes mr-3"></i>
                       Package Management
                    </h1>
                    <a href="categorie" class="bg-white text-indigo-800 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition" style="color: #5e8899">
                        <i class="fas fa-arrow-left mr-2" style="color: #5e8899"></i> back
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">

            <!-- Add Forfait Button and Search -->
            <div class="flex justify-between mb-6">
                <div class="relative w-1/3">
                    <input type="text" id="searchInput" placeholder="Search..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button id="openModalBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center" style="background-color: #5e8899">
                    <i class="fas fa-plus-circle mr-2"></i> Add package
                </button>
            </div>

            <!-- Add Forfait Modal -->
            <div id="addForfaitModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                            Add new package
                        </h2>
                        <span class="close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('forfait.store') }}" method="POST" id="forfaitForm">
                            @csrf
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="nomForfait" class="block text-sm font-medium text-gray-700 mb-1">Package name</label>
                                    <input type="text" id="nomForfait" name="nomForfait" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div>
                                    <label for="prixForfait" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <input type="number" step="0.01" id="prixForfait" name="prixForfait" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div>
                                    <label for="rival" class="block text-sm font-medium text-gray-700 mb-1">Rival (%)</label>
                                    <input type="number" id="rival" name="rival" min="0" max="100" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Services Included</label>
                                    <div class="services-grid" id="servicesContainer">
                                       @foreach($servicePannes as $service)
    <div class="service-item">
        <div class="service-info">
            <div class="service-name">{{ $service->titre }}</div>
            <div class="service-price">{{ number_format($service->prix, 2) }} €</div>
        </div>
        <div class="service-checkbox">
            <input type="checkbox" name="service_pannes[]" value="{{ $service->id }}"
                   id="service_{{ $service->id }}" class="hidden service-checkbox-input"
                   data-price="{{ $service->prix }}">
            <label for="service_{{ $service->id }}" class="custom-checkbox"></label>
        </div>
    </div>
@endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-modal">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Forfait Modal -->
            <div id="editForfaitModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-indigo-600 mr-2"></i>
                            Edit package
                        </h2>
                        <span class="close-edit-modal close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="editForfaitForm" method="POST" class="grid grid-cols-1 gap-6">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="edit_nomForfait" class="block text-sm font-medium text-gray-700 mb-1">Package name</label>
                                <input type="text" id="edit_nomForfait" name="nomForfait" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="edit_prixForfait" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                <input type="number" step="0.01" id="edit_prixForfait" name="prixForfait" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="edit_rival" class="block text-sm font-medium text-gray-700 mb-1">Rival (%)</label>
                                <input type="number" id="edit_rival" name="rival" min="0" max="100" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Services included</label>
                                <div class="services-grid" id="editServicesContainer">
                                   @foreach($servicePannes as $service)
    <div class="service-item">
        <div class="service-info">
            <div class="service-name">{{ $service->titre }}</div>
            <div class="service-price">{{ number_format($service->prix, 2) }} €</div>
        </div>
        <div class="service-checkbox">
            <input type="checkbox" name="service_pannes[]" value="{{ $service->id }}"
                   id="edit_service_{{ $service->id }}" class="hidden edit-service-checkbox-input"
                   data-price="{{ $service->prix }}">
            <label for="edit_service_{{ $service->id }}" class="custom-checkbox"></label>
        </div>
    </div>
@endforeach
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-edit-modal">
                                    Cancel
                                </button>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Forfaits List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden animate-fade-in">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ul text-indigo-600 mr-2" style="color: #5e8899"></i>
                        Packags list
                    </h2>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rival
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Services
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($forfaits as $forfait)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-box text-indigo-500 mr-3" style="color: #5e8899"></i>
                                        <span class="font-medium text-gray-900">{{ $forfait->nomForfait }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-medium">{{ number_format($forfait->prixForfait, 2) }} €</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                        {{ $forfait->rival }}%
                                    </span>
                                </td>
                            <td class="px-6 py-4">
    <div class="forfait-services">
        @foreach($forfait->servicePannes as $service)
            <span class="service-badge">
                <i class="fas fa-check-circle"></i>
                {{ $service->titre }} ({{ number_format($service->pivot->prix, 2) }}€)
            </span>
        @endforeach
    </div>
</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <!-- Edit Button -->
                                        <button onclick="openEditModal({{ $forfait->id }}, '{{ $forfait->nomForfait }}', '{{ $forfait->prixForfait }}', '{{ $forfait->rival }}', [{{ $forfait->servicePannes->pluck('id')->implode(',') }}])"
    class="text-yellow-600 hover:text-yellow-900 ml-3"
    title="Edit">
    <i class="fas fa-edit"></i>
</button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('forfait.destroy', $forfait->id) }}" method="POST" class="inline ml-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900"
                                                    title="delete"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce forfait?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Aucun forfait enregistré pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($forfaits->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $forfaits->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation for success message
            const successMessage = document.querySelector('.bg-green-100');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => successMessage.remove(), 500);
                }, 3000);
            }

            // Modal functionality
            const modal = document.getElementById('addForfaitModal');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtns = document.querySelectorAll('.close-btn, .close-modal');

            openModalBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
            });

            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Custom checkbox functionality
            document.querySelectorAll('.service-checkbox-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const label = document.querySelector(`label[for="${this.id}"]`);
                    if (this.checked) {
                        label.classList.add('checked');
                    } else {
                        label.classList.remove('checked');
                    }
                });
            });

            // Edit modal functionality
            const editModal = document.getElementById('editForfaitModal');
            const closeEditModalBtns = document.querySelectorAll('.close-edit-modal');

            closeEditModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    editModal.style.display = 'none';
                });
            });

            // Fonction de recherche
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const forfaitName = row.querySelector('td:first-child span').textContent.toLowerCase();
                    if (forfaitName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Clear search button
            const searchContainer = document.querySelector('.relative.w-1\\/3');
            if (searchContainer) {
                const clearButton = document.createElement('button');
                clearButton.innerHTML = '<i class="fas fa-times"></i>';
                clearButton.className = 'absolute right-3 top-3 text-gray-400 hover:text-gray-600 hidden';
                clearButton.id = 'clearSearch';
                searchContainer.appendChild(clearButton);

                document.getElementById('searchInput').addEventListener('input', function() {
                    clearButton.style.display = this.value ? '' : 'none';
                });

                clearButton.addEventListener('click', function() {
                    document.getElementById('searchInput').value = '';
                    this.style.display = 'none';
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => row.style.display = '');
                });
            }
        });

        // Fonction pour ouvrir le modal d'édition
        function openEditModal(id, nomForfait, prixForfait, rival, serviceIds) {
    const modal = document.getElementById('editForfaitModal');

    // Pré-remplir le formulaire
    document.getElementById('edit_nomForfait').value = nomForfait;
    document.getElementById('edit_prixForfait').value = prixForfait;
    document.getElementById('edit_rival').value = rival;

    // Mettre à jour l'action du formulaire
    document.getElementById('editForfaitForm').action = `/forfait/${id}`;

    // Cocher les cases des services inclus
    document.querySelectorAll('.edit-service-checkbox-input').forEach(checkbox => {
        checkbox.checked = serviceIds.includes(parseInt(checkbox.value));
        const label = document.querySelector(`label[for="${checkbox.id}"]`); // Fixed this line
        if (checkbox.checked) {
            label.classList.add('checked');
        } else {
            label.classList.remove('checked');
        }
    });

    // Afficher le modal
    modal.style.display = 'flex';
}
    </script>
</body>
</html>
