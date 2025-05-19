<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Services</title>
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
            max-width: 600px;
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

        /* Search styles */
        .relative.w-1\/3 {
            min-width: 250px;
        }

        #searchInput {
            transition: all 0.3s ease;
        }

        #searchInput:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        #clearSearch {
            cursor: pointer;
            transition: color 0.2s;
        }

        #clearSearch:hover {
            color: #4b5563 !important;
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
                        <i class="fas fa-concierge-bell mr-3" style="color: white"></i>
                        Gestion des Services
                    </h1>
                    <a href="categorie" class="bg-white text-indigo-800 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition" style="color: #5e8899">
                        <i class="fas fa-arrow-left mr-2" style="color: #5e8899"></i> Retour
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">

            <!-- Add Service Button and Search -->
            <div class="flex justify-between mb-6">
                <div class="relative w-1/3">
                    <input type="text" id="searchInput" placeholder="Rechercher un service..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button id="openModalBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center" style="background-color: #5e8899">
                    <i class="fas fa-plus-circle mr-2"></i> Ajouter un service
                </button>
            </div>

            <!-- Add Service Modal -->
            <div id="addServiceModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                            Ajouter un nouveau service
                        </h2>
                        <span class="close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('service.store') }}" method="POST" class="grid grid-cols-1 gap-4">
                            @csrf
                            <div class="md:col-span-1">
                                <label for="nomService" class="block text-sm font-medium text-gray-700 mb-1">Nom du service</label>
                                <input type="text" id="nomService" name="nomService" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="md:col-span-1">
                                <label for="payeFabrication" class="block text-sm font-medium text-gray-700 mb-1">Pays de fabrication</label>
                                <input type="text" id="payeFabrication" name="payeFabrication" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="md:col-span-1">
                                <label for="prix" class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                                <input type="number" step="0.01" id="prix" name="prix" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="md:col-span-1">
                                <label for="rival" class="block text-sm font-medium text-gray-700 mb-1">Rival (%)</label>
                                <input type="number" id="rival" name="rival" min="0" max="100" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-modal">
                                    Annuler
                                </button>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Service Modal -->
           <!-- Edit Service Modal -->
<div id="editServiceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <i class="fas fa-edit text-indigo-600 mr-2"></i>
                Modifier le service
            </h2>
            <span class="close-edit-modal close-btn">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editServiceForm" method="POST" class="grid grid-cols-1 gap-4">
                @csrf
                @method('PUT')
                <div class="md:col-span-1">
                    <label for="edit_nomService" class="block text-sm font-medium text-gray-700 mb-1">Nom du service</label>
                    <input type="text" id="edit_nomService" name="nomService" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-1">
                    <label for="edit_payeFabrication" class="block text-sm font-medium text-gray-700 mb-1">Pays de fabrication</label>
                    <input type="text" id="edit_payeFabrication" name="payeFabrication" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-1">
                    <label for="edit_prix" class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                    <input type="number" step="0.01" id="edit_prix" name="prix" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-1">
                    <label for="edit_rival" class="block text-sm font-medium text-gray-700 mb-1">Rival (%)</label>
                    <input type="number" id="edit_rival" name="rival" min="0" max="100" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="modal-footer">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-edit-modal">
                        Annuler
                    </button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

            <!-- Services List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden animate-fade-in">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ul text-indigo-600 mr-2" style="color: #5e8899"></i>
                        Liste des services
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
                                    Nom
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pays
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prix
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($services as $service)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-concierge-bell text-indigo-500 mr-3" style="color: #5e8899"></i>
                                        <span class="font-medium text-gray-900">{{ $service->nomService }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-600">{{ $service->payeFabrication }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-medium">{{ $service->prix ? number_format($service->prix, 2) . ' €' : '-' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <!-- View Button -->


                                        <!-- Edit Button -->
                                        <button onclick="openEditModal({{ $service->id }}, '{{ $service->nomService }}', '{{ $service->payeFabrication }}', '{{ $service->prix }}', '{{ $service->rival }}')"
                                            class="text-yellow-600 hover:text-yellow-900 ml-3"
                                            title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('service.destroy', $service->id) }}" method="POST" class="inline ml-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900"
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('service.toggle-visibility', $service->id) }}" method="POST" class="inline ml-3">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit">
                                                @if($service->isVisible)
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full flex items-center">
                                                        <i class="fas fa-eye mr-1"></i> Visible
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full flex items-center">
                                                        <i class="fas fa-eye-slash mr-1"></i> Masqué
                                                    </span>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Aucun service enregistré pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($services->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $services->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
<script>
    function openEditModal(id, nomService, payeFabrication, prix, rival) {
    const modal = document.getElementById('editServiceModal');

    // Pré-remplir le formulaire
    document.getElementById('edit_nomService').value = nomService;
    document.getElementById('edit_payeFabrication').value = payeFabrication;
    document.getElementById('edit_prix').value = prix;
    document.getElementById('edit_rival').value = rival;

    // Mettre à jour l'action du formulaire
    document.getElementById('editServiceForm').action = `/service/${id}`;

    // Afficher le modal
    modal.style.display = 'flex';
}

// Fermer le modal d'édition
document.querySelectorAll('.close-edit-modal').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('editServiceModal').style.display = 'none';
    });
});
</script>
    <!-- Scripts -->
    <script>
        // Animation for success message
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.bg-green-100');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => successMessage.remove(), 500);
                }, 3000);
            }

            // Modal functionality
            const modal = document.getElementById('addServiceModal');
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

            // Fonction pour ouvrir le modal d'édition
           // Fonction pour ouvrir le modal d'édition



            // Fonction de recherche
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const serviceName = row.querySelector('td:first-child span').textContent.toLowerCase();
                    if (serviceName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Optionnel: Ajouter un bouton pour effacer la recherche
         // To this:
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
    </script>
</body>
</html>
