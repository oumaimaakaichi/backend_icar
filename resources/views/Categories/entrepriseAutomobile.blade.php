<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Entreprises Automobiles</title>
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

        /* Logo preview */
        .logo-preview {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border: 1px dashed #ccc;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .logo-preview img {
            max-width: 100%;
            max-height: 100%;
        }

        /* Search styles */
        .search-container {
            min-width: 250px;
            width: 100%;
            max-width: 400px;
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

        /* Select dropdown styles */
        .custom-select {
            position: relative;
        }

        .custom-select select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1em;
        }

        /* Responsive table */
        @media (max-width: 640px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        /* Badge for country */
        .country-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background-color: #e0e7ff;
            color: #4338ca;
        }

        /* Action buttons */
        .action-btn {
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        /* Add car modal */
        .add-car-modal {
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

        .add-car-modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
            animation: modalFadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r  to-indigo-800 text-white shadow-lg" style="background-color: #5e8899">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <h1 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-car mr-3"></i>
                       Automotive Business Management
                    </h1>
                    <a href="categorie" class="bg-white text-indigo-800 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition whitespace-nowrap" style="color: #5e8899">
                        <i class="fas fa-arrow-left mr-2" style="color: #5e8899"></i> Back
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Add Company Button and Search -->
            <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
                <div class="relative search-container">
                    <input type="text" id="searchInput" placeholder="Search..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <button id="clearSearch" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 hidden">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <button id="openModalBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center whitespace-nowrap" style="background-color: #5e8899">
                    <i class="fas fa-plus-circle mr-2"></i>Add a company
                </button>
            </div>

            <!-- Add Company Modal -->
            <div id="addCompanyModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                          Add a new company
                        </h2>
                        <span class="close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('entrepriseAutomobile.store') }}" method="POST" class="grid grid-cols-1 gap-4" enctype="multipart/form-data">
                            @csrf
                            <div class="md:col-span-1">
                                <label for="entreprise" class="block text-sm font-medium text-gray-700 mb-1">Name of company *</label>
                                <input type="text" id="entreprise" name="entreprise" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Entrez le nom de l'entreprise">
                            </div>

                            <div class="md:col-span-1 custom-select">
                                <label for="pays" class="block text-sm font-medium text-gray-700 mb-1">Country*</label>
                                <select id="pays" name="pays" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="" disabled selected>Select a country</option>
                                    <option value="France">France</option>
                                    <option value="Allemagne">Allemagne</option>
                                    <option value="Italie">Italie</option>
                                    <option value="Espagne">Espagne</option>
                                    <option value="États-Unis">États-Unis</option>
                                    <option value="Japon">Japon</option>
                                    <option value="Corée du Sud">Corée du Sud</option>
                                    <option value="Chine">Chine</option>
                                    <option value="Royaume-Uni">Royaume-Uni</option>
                                    <option value="Suède">Suède</option>
                                </select>
                            </div>

                            <div class="md:col-span-1">
                                <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                                <input type="file" id="logo" name="logo" accept="image/*"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG, SVG (max 2MB)</p>

                                <div class="mt-2 logo-preview hidden">
                                    <img id="logoPreview" src="#" alt="Aperçu du logo" class="hidden">
                                   &nbsp;&nbsp;&nbsp; <span class="text-gray-400 text-sm" id="noLogoText">No logo selected</span>
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

            <!-- Edit Company Modal -->
            <div id="editCompanyModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-indigo-600 mr-2"></i>
                         Edit company
                        </h2>
                        <span class="close-edit-modal close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="editCompanyForm" method="POST" class="grid grid-cols-1 gap-4" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="md:col-span-1">
                                <label for="edit_entreprise" class="block text-sm font-medium text-gray-700 mb-1">Company name*</label>
                                <input type="text" id="edit_entreprise" name="entreprise" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="md:col-span-1 custom-select">
                                <label for="edit_pays" class="block text-sm font-medium text-gray-700 mb-1">Pays*</label>
                                <select id="edit_pays" name="pays" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="" disabled>Select a country</option>
                                    <option value="France">France</option>
                                    <option value="Allemagne">Allemagne</option>
                                    <option value="Italie">Italie</option>
                                    <option value="Espagne">Espagne</option>
                                    <option value="États-Unis">États-Unis</option>
                                    <option value="Japon">Japon</option>
                                    <option value="Corée du Sud">Corée du Sud</option>
                                    <option value="Chine">Chine</option>
                                    <option value="Royaume-Uni">Royaume-Uni</option>
                                    <option value="Suède">Suède</option>
                                </select>
                            </div>

                            <div class="md:col-span-1">
                                <label for="edit_logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                                <input type="file" id="edit_logo" name="logo" accept="image/*"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Leave empty to keep the current logo</p>

                                <div class="mt-2 logo-preview">
                                    <img id="edit_logoPreview" src="#" alt="Aperçu du logo" class="hidden">
                                    <span class="text-gray-400 text-sm" id="edit_noLogoText">No logo available</span>
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

            <!-- Companies List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden animate-fade-in">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ul text-indigo-600 mr-2" style="color: #5e8899"></i>
                       List of automotive companies
                        <span class="ml-auto text-sm font-normal text-gray-500">{{ $entreprises->total() }} Companies</span>
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

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Logo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Company
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Country
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($entreprises as $entreprise)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($entreprise->logo)
                                        <img src="{{ $entreprise->logo_path }}" alt="{{ $entreprise->entreprise }}" class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-car text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900">{{ $entreprise->entreprise }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="country-badge">{{ $entreprise->pays }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('entrepriseAutomobile.show', $entreprise->id) }}"
                                            class="action-btn text-blue-600 hover:bg-blue-50"
                                            title="View details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Add Car Button -->
                                        <button onclick="openAddVoitureModal({{ $entreprise->id }})"
                                            class="action-btn text-green-600 hover:bg-green-50"
                                            title="add a car">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>

                                        <!-- Edit Button -->
                                        <button onclick="openEditModal({{ $entreprise->id }}, '{{ $entreprise->entreprise }}', '{{ $entreprise->pays }}', '{{ $entreprise->logo_path }}')"
                                            class="action-btn text-yellow-600 hover:bg-yellow-50"
                                            title="update">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('entrepriseAutomobile.destroy', $entreprise->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="action-btn text-red-600 hover:bg-red-50"
                                                    title="delete"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise? Toutes les voitures associées seront également supprimées.')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-car text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-lg">No ompany saved</p>
                                        <p class="text-sm text-gray-400 mt-2">Click on 'Add a company' to get started</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($entreprises->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $entreprises->links() }}
                </div>
                @endif
            </div>
        </main>

        <!-- Add Voiture Modal -->
        <div id="addVoitureModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                       Add a new car
                    </h2>
                    <span class="close-btn close-voiture-modal">&times;</span>
                </div>
                <form id="addVoitureForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="nom_voiture" class="block text-sm font-medium text-gray-700 mb-1">Car name*</label>
                            <input type="text" id="nom_voiture" name="nom_voiture" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Entrez le nom du modèle">
                        </div>
                        <div class="mb-4">
                            <label for="annee_voiture" class="block text-sm font-medium text-gray-700 mb-1">Release year</label>
                            <input type="number" id="annee_voiture" name="annee_voiture" min="1900" max="{{ date('Y') + 1 }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Entrez l'année de sortie">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-voiture-modal">
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

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation for success/error messages
            const messages = document.querySelectorAll('.bg-green-100, .bg-red-100');
            messages.forEach(message => {
                setTimeout(() => {
                    message.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => message.remove(), 500);
                }, 5000);
            });

            // Modal functionality
            const modals = {
                addCompany: document.getElementById('addCompanyModal'),
                editCompany: document.getElementById('editCompanyModal'),
                addVoiture: document.getElementById('addVoitureModal')
            };

            // Open add company modal
            document.getElementById('openModalBtn').addEventListener('click', function() {
                modals.addCompany.style.display = 'flex';
            });

            // Close modals
            document.querySelectorAll('.close-btn, .close-modal, .close-edit-modal, .close-voiture-modal').forEach(btn => {
                btn.addEventListener('click', function() {
                    const modalId = this.classList.contains('close-edit-modal') ? 'editCompany' :
                                   this.classList.contains('close-voiture-modal') ? 'addVoiture' : 'addCompany';
                    modals[modalId].style.display = 'none';

                    if (modalId === 'addCompany') {
                        resetForm();
                    }
                });
            });

            // Close modals when clicking outside
            window.addEventListener('click', function(event) {
                Object.keys(modals).forEach(key => {
                    if (event.target === modals[key]) {
                        modals[key].style.display = 'none';
                        if (key === 'addCompany') {
                            resetForm();
                        }
                    }
                });
            });

            // Logo preview for add form
            document.getElementById('logo').addEventListener('change', function(e) {
                const preview = document.getElementById('logoPreview');
                const noLogoText = document.getElementById('noLogoText');
                const logoPreviewContainer = document.querySelector('#addCompanyModal .logo-preview');

                handleLogoPreview(this, preview, noLogoText, logoPreviewContainer);
            });

            // Logo preview for edit form
            document.getElementById('edit_logo').addEventListener('change', function(e) {
                const preview = document.getElementById('edit_logoPreview');
                const noLogoText = document.getElementById('edit_noLogoText');
                const logoPreviewContainer = document.querySelector('#editCompanyModal .logo-preview');

                handleLogoPreview(this, preview, noLogoText, logoPreviewContainer);
            });

            function handleLogoPreview(input, previewElement, noLogoTextElement, containerElement) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];

                    // Check file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Le fichier est trop volumineux (max 2MB)');
                        input.value = '';
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
                    if (!validTypes.includes(file.type)) {
                        alert('Format de fichier non supporté. Utilisez JPG, PNG ou SVG.');
                        input.value = '';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                        previewElement.classList.remove('hidden');
                        noLogoTextElement.classList.add('hidden');
                        containerElement.classList.remove('hidden');
                    }

                    reader.readAsDataURL(file);
                }
            }

            // Reset form function
            function resetForm() {
                document.getElementById('entreprise').value = '';
                document.getElementById('pays').value = '';
                document.getElementById('logo').value = '';

                const preview = document.getElementById('logoPreview');
                const noLogoText = document.getElementById('noLogoText');
                const logoPreviewContainer = document.querySelector('#addCompanyModal .logo-preview');

                preview.src = '#';
                preview.classList.add('hidden');
                noLogoText.classList.remove('hidden');
                logoPreviewContainer.classList.add('hidden');
            }

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const clearSearchBtn = document.getElementById('clearSearch');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        if (row.querySelector('td:nth-child(2) span')) {
                            const companyName = row.querySelector('td:nth-child(2) span').textContent.toLowerCase();
                            const country = row.querySelector('td:nth-child(3) span').textContent.toLowerCase();

                            if (companyName.includes(searchTerm) || country.includes(searchTerm)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });

                    clearSearchBtn.style.display = this.value ? 'block' : 'none';
                });

                clearSearchBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    this.style.display = 'none';
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => row.style.display = '');
                });
            }
        });

        // Fonction pour ouvrir le modal d'édition
        function openEditModal(id, entreprise, pays, logoPath) {
            const modal = document.getElementById('editCompanyModal');

            // Pré-remplir le formulaire
            document.getElementById('edit_entreprise').value = entreprise;

            // Sélectionner le bon pays dans la liste déroulante
            const paysSelect = document.getElementById('edit_pays');
            for (let i = 0; i < paysSelect.options.length; i++) {
                if (paysSelect.options[i].value === pays) {
                    paysSelect.selectedIndex = i;
                    break;
                }
            }

            // Mettre à jour l'aperçu du logo
            const logoPreview = document.getElementById('edit_logoPreview');
            const noLogoText = document.getElementById('edit_noLogoText');
            const logoPreviewContainer = document.querySelector('#editCompanyModal .logo-preview');

            if (logoPath && logoPath !== '') {
                logoPreview.src = logoPath;
                logoPreview.classList.remove('hidden');
                noLogoText.classList.add('hidden');
                logoPreviewContainer.classList.remove('hidden');
            } else {
                logoPreview.classList.add('hidden');
                noLogoText.classList.remove('hidden');
                logoPreviewContainer.classList.remove('hidden');
            }

            // Mettre à jour l'action du formulaire
            document.getElementById('editCompanyForm').action = `/entrepriseAutomobile/${id}`;

            // Afficher le modal
            modal.style.display = 'flex';
        }

        // Fonction pour ouvrir le modal d'ajout de voiture
        function openAddVoitureModal(entrepriseId) {
            const modal = document.getElementById('addVoitureModal');

            // Mettre à jour l'action du formulaire avec l'ID de l'entreprise
            document.getElementById('addVoitureForm').action = `/entrepriseAutomobile/${entrepriseId}/add-voiture`;

            // Réinitialiser les champs
            document.getElementById('nom_voiture').value = '';
            document.getElementById('annee_voiture').value = '';

            // Afficher le modal
            modal.style.display = 'flex';
        }

        // Confirmation pour la suppression
        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this company? All associated cars will also be deleted.')) {
                event.preventDefault();
            }
        }

        // Attacher les gestionnaires d'événements de confirmation à tous les boutons de suppression
        document.querySelectorAll('form[action*="/entrepriseAutomobile/"] button[type="submit"]').forEach(button => {
            button.addEventListener('click', confirmDelete);
        });
    </script>
</body>
</html>
