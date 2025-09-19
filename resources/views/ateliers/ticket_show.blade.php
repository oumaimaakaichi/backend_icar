@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Détails du Ticket #{{ $ticket->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Titre:</strong>
                            <p>{{ $ticket->titre }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Type:</strong>
                            <p>{{ $ticket->type }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Statut:</strong>
                            <p>
                                <span class="badge bg-{{
                                    $ticket->statut == 'en attente' ? 'warning' :
                                    ($ticket->statut == 'en cours' ? 'info' :
                                    ($ticket->statut == 'résolu' ? 'success' : 'secondary'))
                                }}">
                                    {{ $ticket->statut }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Date de création:</strong>
                            <p>{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Message:</strong>
                        <div class="border p-3 rounded bg-light">
                            {{ $ticket->message }}
                        </div>
                    </div>

                    <a href="{{ route('assistance.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
