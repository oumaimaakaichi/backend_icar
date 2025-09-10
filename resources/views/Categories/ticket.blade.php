<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
/* S'assurer que la carte d'édition a la même apparence */
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
        /* Ajoutez ceci à votre section de style */
.relative.w-1\/3 {
    min-width: 250px;
}

#searchTicketInput {
    transition: all 0.3s ease;
}

#searchTicketInput:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
}

#clearSearchTicket {
    cursor: pointer;
    transition: color 0.2s;
}

#clearSearchTicket:hover {
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
                        <i class="fas fa-ticket-alt"></i>
                        &nbsp;  Tickets management
                    </h1>
                    <a href="categorie" class="bg-white text-indigo-800 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition" style="color: #5e8899">
                        <i class="fas fa-arrow-left mr-2" style="color: #5e8899"></i> Back
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Add City Button -->
           <!-- Add Ticket Button and Search -->
<div class="flex justify-between mb-6">
    <div class="relative w-1/3">
        <input type="text" id="searchTicketInput" placeholder="Search..."
               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
    </div>
    <button id="openModalBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center" style="background-color: #5e8899">
        <i class="fas fa-plus-circle mr-2"></i> Add ticket
    </button>
</div>

            <!-- Add City Modal -->
            <div id="addCityModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                            Add new ticket
                        </h2>
                        <span class="close-btn">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('ticket.store') }}" method="POST" class="grid grid-cols-1 gap-4">
                            @csrf
                            <div class="md:col-span-1">
                                <label for="type_ticket" class="block text-sm font-medium text-gray-700 mb-1">Ticket name</label>
                                <input type="text" id="type_ticket" name="type_ticket" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>



                            <div class="modal-footer">
                                <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-100 transition close-modal">
                                    Cancel
                                </button>
                                <button type="submit" id="submit-btn"  class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<!-- Edit City Modal -->
<div id="editCityModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <i class="fas fa-edit text-indigo-600 mr-2"></i>
                Edit ticket
            </h2>
            <span class="close-edit-modal close-btn">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editCityForm" method="POST" class="grid grid-cols-1 gap-4">
                @csrf
                @method('PUT')
                <div class="md:col-span-1">
                    <label for="edit_type_ticket" class="block text-sm font-medium text-gray-700 mb-1">Ticket name</label>
                    <input type="text" id="edit_type_ticket" name="type_ticket" required
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
            <!-- Cities List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden animate-fade-in">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center" >
                        <i class="fas fa-list-ul text-indigo-600 mr-2" style="color: #5e8899"></i>
                        Tickets list
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
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-city text-indigo-500 mr-3" style="color: #5e8899"></i>
                                        <span class="font-medium text-gray-900">{{ $ticket->type_ticket }}</span>
                                    </div>
                                </td>
                                <td >
                                    <div >


                                        <!-- Edit Button -->
                                       <!-- Edit Button -->
<button onclick="openEditModal({{ $ticket->id }}, '{{ $ticket->type_ticket }}')"
    class="text-yellow-600 hover:text-yellow-900 ml-3"
    title="Edit">
<i class="fas fa-edit"></i>

</button>


                                        <!-- Delete Button -->
                                        <form action="{{ route('ticket.destroy', $ticket->id) }}" method="POST" class="inline ml-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900"
                                                    title="delete"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette ticket?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('ticket.toggle-visibility', $ticket->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" >
                                                @if($ticket->is_visible)
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
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Aucune ticket enregistrée pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
               <!-- Remove or comment out this section -->
@if($tickets->hasPages())
<div class="px-6 py-4 border-t border-gray-200">
    {{ $tickets->links() }}
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

            // Variables globales pour la carte et le marqueur
            let map = null;
            let marker = null;

            openModalBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
                // Petit délai pour permettre au modal d'être visible avant d'initialiser la carte
                setTimeout(initMap, 10);
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

            // Initialize map function


            // Reset form function
            function resetForm() {
                document.getElementById('type_ticket').value = '';

                const submitBtn = document.getElementById('submit-btn');
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                submitBtn.classList.add('bg-indigo-400');

                // Remove marker if exists

            }


        });
    </script>
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
                initMap(); // Initialize map when modal opens
            });

            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    modal.style.display = 'none';
                    resetForm(); // Reset form when modal closes
                });
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    resetForm(); // Reset form when clicking outside modal
                }
            });

            // Reset form function
            function resetForm() {
                document.getElementById('type_ticket').value = '';

                const submitBtn = document.getElementById('submit-btn');
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                submitBtn.classList.add('bg-indigo-400');


            }

            // Initialize map function

        });
    </script>

    <script>
        // Variables globales pour la carte d'édition
let editMap = null;
let editMarker = null;

// Fonction pour ouvrir le modal d'édition
function openEditModal(id, type_ticket) {
    const modal = document.getElementById('editCityModal');

    // Pré-remplir le formulaire
    document.getElementById('edit_type_ticket').value = type_ticket;

    // Mettre à jour l'action du formulaire
    document.getElementById('editCityForm').action = `/ticket/${id}`;

    // Afficher le modal
    modal.style.display = 'flex';


}



// Fermer le modal d'édition
document.querySelectorAll('.close-edit-modal').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('editCityModal').style.display = 'none';
    });
});
    </script>

<script>
    // Fonction de recherche pour les tickets
    document.getElementById('searchTicketInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const ticketName = row.querySelector('td:first-child span').textContent.toLowerCase();
            if (ticketName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Optionnel: Ajouter un bouton pour effacer la recherche
    const searchContainer = document.querySelector('.relative.w-1\/3');
    if (searchContainer) {
        const clearButton = document.createElement('button');
        clearButton.innerHTML = '<i class="fas fa-times"></i>';
        clearButton.className = 'absolute right-3 top-3 text-gray-400 hover:text-gray-600 hidden';
        clearButton.id = 'clearSearchTicket';
        searchContainer.appendChild(clearButton);

        document.getElementById('searchTicketInput').addEventListener('input', function() {
            clearButton.style.display = this.value ? '' : 'none';
        });

        clearButton.addEventListener('click', function() {
            document.getElementById('searchTicketInput').value = '';
            this.style.display = 'none';
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => row.style.display = '');
        });
    }
</script>
</body>
</html>
