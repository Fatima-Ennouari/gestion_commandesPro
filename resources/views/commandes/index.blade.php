@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-3">
        <div class="col">
            <h2>Liste des Commandes</h2>
        </div>
        <div class="col text-right">
            <a href="{{ route('commandes.create') }}" class="btn btn-primary">
                Nouvelle Commande
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commandes as $commande)
                <tr>
                    <td>{{ $commande->reference }}</td>
                    <td>{{ $commande->client->prenom }} {{ $commande->client->nom }}</td>
                    <td>{{ $commande->date_commande->format('d/m/Y') }}</td>
                    <td>{{ number_format($commande->total, 2) }} €</td>
                    <td>
                        @switch($commande->statut)
                            @case('en_attente')
                                <span class="badge bg-warning text-dark">En attente</span>
                                @break
                            @case('confirmee')
                                <span class="badge bg-info text-dark">Confirmée</span>
                                @break
                            @case('livree')
                                <span class="badge bg-success">Livrée</span>
                                @break
                            @case('annulee')
                                <span class="badge bg-danger">Annulée</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-info">
                            Voir
                        </a>
                        <a href="{{ route('commandes.edit', $commande) }}" class="btn btn-sm btn-warning">
                            Modifier
                        </a>
                        <a href="{{ route('commandes.confirm-delete', $commande) }}" class="btn btn-sm btn-danger">
                            Supprimer
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $commandes->links() }}
    </div>
</div>
@endsection
