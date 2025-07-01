<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catégories de Panne</title>
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

        .truncate-description {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r to-indigo-800 text-white shadow-lg" style="background-color: #5e8899">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-tools mr-2"></i>
                        Gestion des Catégories de Panne
                    </h1>
                    <a href="{{ url()->previous() }}" class="bg-white text-indigo-800 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition" style="color: #5e8899">
                        <i class="fas fa-arrow-left mr-2" style="color: #5e8899"></i> Retour
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Add Category Button -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="relative w-1/3">
                    <input type="text" id="searchInput" placeholder="Rechercher par nom..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <button id="openModalBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center" style="background-color: #5e8899">
                    <i class="fas fa-plus-circle mr-2"></i> Ajouter une catégorie
                </button>
            </div>

            <!-- Add Category Modal -->
            <div id="addCategoryModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                            Ajouter une nouvelle catégorie
                        </h2>
                        <span class="close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('category-panes.store') }}" method="POST" class="grid grid-cols-1 gap-4">
                            @csrf
                            <div class="md:col-span-1">
                                <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">Titre de la catégorie</label>
                                <input type="text" id="titre" name="titre" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="md:col-span-1">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="description" name="description" rows="4" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-modal">
                                    Annuler
                                </button>
                                <button type="submit" id="submit-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Category Modal -->
            <div id="editCategoryModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-indigo-600 mr-2"></i>
                            Modifier la catégorie
                        </h2>
                        <span class="close-edit-modal close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="editCategoryForm" method="POST" class="grid grid-cols-1 gap-4">
                            @csrf
                            @method('PUT')
                            <div class="md:col-span-1">
                                <label for="edit_titre" class="block text-sm font-medium text-gray-700 mb-1">Titre de la catégorie</label>
                                <input type="text" id="edit_titre" name="titre" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="md:col-span-1">
                                <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="edit_description" name="description" rows="4" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-edit-modal">
                                    Annuler
                                </button>
                                <button type="submit" id="edit-submit-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Categories List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden animate-fade-in">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ul text-indigo-600 mr-2" style="color: #5e8899"></i>
                        Liste des catégories
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
                                    Titre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-tools text-indigo-500 mr-3" style="color: #5e8899"></i>
                                        <span class="font-medium text-gray-900">{{ $category->titre }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-600 truncate-description">
                                        {{ $category->description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('category-panes.toggle-visibility', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit">
                                            @if($category->is_visible)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full flex items-center">
                                                    <i class="fas fa-eye mr-1"></i> Visible
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full flex items-center">
                                                    <i class="fas fa-eye-slash mr-1"></i> Masquée
                                                </span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <!-- View Button -->
                                        <a href="{{ route('category-panes.show', $category->id) }}"
                                           class="text-blue-600 hover:text-blue-900 mr-3"
                                           title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <button onclick="openEditModal({{ $category->id }}, '{{ $category->titre }}', `{{ $category->description }}`)"
                                                class="text-yellow-600 hover:text-yellow-900 mr-3"
                                                title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('category-panes.destroy', $category->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900"
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Aucune catégorie de panne enregistrée pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

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
            const modal = document.getElementById('addCategoryModal');
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
                document.getElementById('titre').value = '';
                document.getElementById('description').value = '';
            }
        });

        // Fonction pour ouvrir le modal d'édition
        function openEditModal(id, titre, description) {
            const modal = document.getElementById('editCategoryModal');

            // Pré-remplir le formulaire
            document.getElementById('edit_titre').value = titre;
            document.getElementById('edit_description').value = description;

            // Mettre à jour l'action du formulaire
            document.getElementById('editCategoryForm').action = `/category-panes/${id}`;

            // Afficher le modal
            modal.style.display = 'flex';
        }

        // Fermer le modal d'édition
        document.querySelectorAll('.close-edit-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('editCategoryModal').style.display = 'none';
            });
        });

        // Fonction de recherche
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const categoryName = row.querySelector('td:first-child span').textContent.toLowerCase();
                if (categoryName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
