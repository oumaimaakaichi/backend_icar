<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Entreprise - {{ $entrepriseAutomobile->entreprise }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .company-card {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .company-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd1 0%, #6a4296 100%);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #4fd1c5 0%, #319795 100%);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #45bdb1 0%, #2c7d7b 100%);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #e55353 0%, #d43333 100%);
            transform: translateY(-1px);
        }

        .country-badge {
            background-color: #f0f7ff;
            color: #4a6ee0;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .car-item:hover {
            background-color: #f8fafc;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.75rem;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
        }

        .close-btn {
            font-size: 1.5rem;
            font-weight: bold;
            color: #64748b;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: #334155;
        }

        .logo-container {
            width: 120px;
            height: 120px;
            border-radius: 1rem;
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 1rem;
        }

        .empty-state {
            background-color: #f8fafc;
            border-radius: 0 0 0.75rem 0.75rem;
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
                        Company Details
                    </h1>
                    <div class="flex space-x-3">
                        <a href="{{ route('entrepriseAutomobile.index') }}" class="bg-white text-indigo-800 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition whitespace-nowrap" style="color: #5e8899">
                            <i class="fas fa-arrow-left mr-2" style="color: #5e8899"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8 animate-fade-in">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Company Details Card -->
            <div class="company-card bg-white rounded-xl overflow-hidden mb-8">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                        <!-- Logo -->
                        <div class="logo-container flex-shrink-0">
                            @if($entrepriseAutomobile->logo)
                                <img src="{{ $entrepriseAutomobile->logo_path }}" alt="{{ $entrepriseAutomobile->entreprise }}" class="logo-img">
                            @else
                                <div class="text-indigo-400 text-5xl">
                                    <i class="fas fa-car"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Company Info -->
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $entrepriseAutomobile->entreprise }}</h2>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-4">
                                <span class="country-badge">
                                    <i class="fas fa-globe mr-2"></i>{{ $entrepriseAutomobile->pays }}
                                </span>
                                <span class="text-gray-500 flex items-center">
                                    <i class="fas fa-car mr-2"></i> {{ count($entrepriseAutomobile->voitures ?? []) }} model(s)
                                </span>
                            </div>

                            <!-- Description -->
                            @if($entrepriseAutomobile->description)
                                <p class="text-gray-600 mb-6 max-w-2xl">
                                    {{ $entrepriseAutomobile->description }}
                                </p>
                            @endif

                            <!-- Actions -->
                            <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                                <button onclick="openAddCarModal()" class="btn-primary text-white px-4 py-2 rounded-lg flex items-center transition-transform">
                                    <i class="fas fa-plus-circle mr-2"></i> Add a model
                                </button>
                                <a href="{{ route('entrepriseAutomobile.edit', $entrepriseAutomobile->id) }}" class="btn-secondary text-white px-4 py-2 rounded-lg flex items-center transition-transform">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cars List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-ul text-indigo-600 mr-2"></i>
                        Models List
                    </h2>
                    <span class="ml-auto bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ count($entrepriseAutomobile->voitures ?? []) }}
                    </span>
                </div>

                @if(!empty($entrepriseAutomobile->voitures) && count($entrepriseAutomobile->voitures) > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($entrepriseAutomobile->voitures as $index => $voiture)
                            <div class="car-item px-6 py-4 flex justify-between items-center transition-colors">
                                <div class="flex items-center">
                                    <i class="fas fa-car-side text-indigo-400 mr-4"></i>
                                    <h3 class="font-medium text-gray-800">{{ $voiture }}</h3>
                                </div>
                                <div class="flex space-x-2">
                                    <form action="{{ route('entrepriseAutomobile.removeVoiture', ['entreprise' => $entrepriseAutomobile->id, 'index' => $index]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-danger text-white px-3 py-1 rounded-lg text-sm flex items-center transition-transform"
                                                onclick="return confirm('Are you sure you want to delete this model?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state p-8 text-center">
                        <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-car text-2xl text-indigo-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-500">No models registered</h3>
                        <p class="text-gray-400 mt-2">Start by adding your first model</p>
                        <button onclick="openAddCarModal()" class="mt-4 btn-primary text-white px-4 py-2 rounded-lg flex items-center mx-auto transition-transform">
                            <i class="fas fa-plus-circle mr-2"></i> Add a model
                        </button>
                    </div>
                @endif
            </div>
        </main>

        <!-- Add Car Modal -->
        <div id="addCarModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                        Add a new model
                    </h2>
                    <span class="close-btn" onclick="closeAddCarModal()">&times;</span>
                </div>
                <form action="{{ route('entrepriseAutomobile.addVoiture', $entrepriseAutomobile->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="nom_voiture" class="block text-sm font-medium text-gray-700 mb-2">Model name*</label>
                            <input type="text" id="nom_voiture" name="nom_voiture" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                   placeholder="Ex: Model S, Clio, 308...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 mr-2 hover:bg-gray-50 transition" onclick="closeAddCarModal()">
                            Cancel
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddCarModal() {
            document.getElementById('addCarModal').style.display = 'flex';
            document.getElementById('nom_voiture').focus();
        }

        function closeAddCarModal() {
            document.getElementById('addCarModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('addCarModal');
            if (event.target === modal) {
                closeAddCarModal();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('.bg-green-100, .bg-red-100');
            messages.forEach(message => {
                setTimeout(() => {
                    message.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => message.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>

</html>
