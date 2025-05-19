@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Pièces recommandées pour la demande #{{ $pieceRecommandee->demande_id }}</h2>

    <ul class="list-group">
        @foreach($pieceRecommandee->pieces as $piece)
            <li class="list-group-item">
                <strong>Pièce :</strong> {{ $piece['idPiece'] }} <br>
                <strong>Prix Original :</strong> {{ $piece['prixOriginal'] }} FCFA<br>
                <strong>Prix Commercial :</strong> {{ $piece['prixCommercial'] }} FCFA<br>
                <strong>Main d'œuvre :</strong> {{ $piece['prix_main_oeuvre'] }} FCFA
            </li>
        @endforeach
    </ul>
</div>
@endsection
