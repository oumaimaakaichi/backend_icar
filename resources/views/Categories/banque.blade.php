<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des banques</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --primary-color: #5e8899;
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

        /* Style pour la carte */
        #map {
            height: 300px;
            width: 100%;
            margin-bottom: 20px;
        }

        .leaflet-top.leaflet-left {
            top: 10px;
            left: 10px;
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

        #edit_map {
            height: 400px;
            width: 100%;
            border-radius: 0.5rem;
            margin-top: 1rem;
            z-index: 1;
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

        /* Search bar styles */
        .search-container {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f9fafb;
        }

        .search-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background-color: white;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        /* Status badge styles */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .status-visible {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-hidden {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Action buttons */
        .action-btn {
            transition: all 0.2s;
            padding: 0.5rem;
            border-radius: 0.375rem;
        }

        .edit-btn {
            color: #d97706;
        }

        .edit-btn:hover {
            color: #92400e;
            background-color: #fef3c7;
        }

        .delete-btn {
            color: #dc2626;
        }

        .delete-btn:hover {
            color: #991b1b;
            background-color: #fee2e2;
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
                        <i class="fas fa-university"></i>
                        &nbsp;  Bank Management
                    </h1>
                    <a href="categorie" class="bg-white text-indigo-800 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Search and Add Bank Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <!-- Search Bar -->
                <div class="w-full md:w-1/2">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="Search by name ...">
                    </div>
                </div>

                <!-- Add Bank Button -->
                <div class="w-full md:w-auto">
                    <button id="openModalBtn" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center" style="background-color: #5e8899">
                        <i class="fas fa-plus-circle mr-2"></i> Add bank
                    </button>
                </div>
            </div>

            <!-- Add Bank Modal -->
            <div id="addCityModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                            Add new Bank
                        </h2>
                        <span class="close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('banque.store') }}" method="POST" class="grid grid-cols-1 gap-4">
                            @csrf
                            <div class="md:col-span-1">
                                <label for="nom_banque" class="block text-sm font-medium text-gray-700 mb-1">Bank name</label>
                                <input type="text" id="nom_banque" name="nom_banque" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-modal">
                                    Cancel
                                </button>
                                <button type="submit" id="submit-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Bank Modal -->
            <div id="editCityModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-indigo-600 mr-2"></i>
                            Update bank
                        </h2>
                        <span class="close-edit-modal close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="editCityForm" method="POST" class="grid grid-cols-1 gap-4">
                            @csrf
                            @method('PUT')
                            <div class="md:col-span-1">
                                <label for="edit_nom_banque" class="block text-sm font-medium text-gray-700 mb-1">Bank name</label>
                                <input type="text" id="edit_nom_banque" name="nom_banque" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-edit-modal">
                                    Cancel
                                </button>
                                <button type="submit" id="edit-submit-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Banks List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden animate-fade-in">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ul text-indigo-600 mr-2" style="color: #5e8899"></i>
                         Bank List
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
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="banksTableBody">
                            @forelse($banques as $banque)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-university text-indigo-500 mr-3" style="color: #5e8899"></i>
                                        <span class="font-medium text-gray-900">{{ $banque->nom_banque }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('banque.toggle-visibility', $banque->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="focus:outline-none">
                                            @if($banque->is_visible)
                                                <span class="status-badge status-visible">
                                                    <i class="fas fa-eye mr-1"></i> Visible
                                                </span>
                                            @else
                                                <span class="status-badge status-hidden">
                                                    <i class="fas fa-eye-slash mr-1"></i> Masquée
                                                </span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-4">
                                        <!-- Edit Button -->
                                        <button onclick="openEditModal({{ $banque->id }}, '{{ $banque->nom_banque }}')"
                                                class="action-btn edit-btn"
                                                title="update">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('banque.destroy', $banque->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="action-btn delete-btn"
                                                    title="Delete"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette banque?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Aucune banque enregistrée pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($banques->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $banques->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
            const modal = document.getElementById('addCityModal');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtns = document.querySelectorAll('.close-btn, .close-modal');

            openModalBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
            });

            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    modal.style.display = 'none';
                    resetForm();
                });
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    resetForm();
                }
            });

            // Reset form function
            function resetForm() {
                document.getElementById('nom_banque').value = '';
            }

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const banksTableBody = document.getElementById('banksTableBody');
            const bankRows = banksTableBody.getElementsByTagName('tr');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                for (let row of bankRows) {
                    const bankName = row.querySelector('td:first-child span').textContent.toLowerCase();
                    if (bankName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        // Fonction pour ouvrir le modal d'édition
        function openEditModal(id, nom_banque) {
            const modal = document.getElementById('editCityModal');

            // Pré-remplir le formulaire
            document.getElementById('edit_nom_banque').value = nom_banque;

            // Mettre à jour l'action du formulaire
            document.getElementById('editCityForm').action = `/banque/${id}`;

            // Afficher le modal
            modal.style.display = 'flex';
        }

        // Fermer le modal d'édition
        document.querySelectorAll('.close-edit-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('editCityModal').style.display = 'none';
            });
        });

        // Close edit modal when clicking outside
        window.addEventListener('click', function(event) {
            const editModal = document.getElementById('editCityModal');
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>
