@if($atelier)
<div class="atelier-info mb-4">
    <h5>{{ $atelier->nom_commercial }}</h5>
    <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> {{ $atelier->ville }}</p>
    <p class="mb-0"><i class="fas fa-phone me-2"></i> {{ $atelier->num_contact }}</p>
</div>

<div class="row">
    @php
        $days = [
            'lundi' => 'Lundi',
            'mardi' => 'Mardi',
            'mercredi' => 'Mercredi',
            'jeudi' => 'Jeudi',
            'vendredi' => 'Vendredi',
            'samedi' => 'Samedi',
            'dimanche' => 'Dimanche'
        ];

        $availability = $atelier->availability ?? [];
    @endphp

    @foreach($days as $key => $day)
    <div class="col-md-6 mb-3">
        <div class="day-card border" data-day="{{ $key }}">
            <div class="day-header d-flex justify-content-between align-items-center">
                <span>{{ $day }}</span>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSlotModal" data-day="{{ $key }}">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            @if(!empty($availability[$key]))
                @foreach($availability[$key] as $slot)
                <div class="slot-item" data-slot="{{ $slot }}">
                    <span class="slot-time">{{ str_replace('-', ' - ', $slot) }}</span>
                    <button class="btn btn-sm btn-outline-danger delete-slot" data-day="{{ $key }}" data-slot="{{ $slot }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                @endforeach
            @else
                <div class="no-slots">Aucun créneau défini</div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@else
<div class="alert alert-warning">Aucun atelier sélectionné</div>
@endif
