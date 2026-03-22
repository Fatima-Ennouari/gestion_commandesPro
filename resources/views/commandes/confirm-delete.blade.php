@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h4>Confirmer la suppression</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Êtes-vous sûr de vouloir supprimer cette commande ?</p>

                    <div class="alert alert-warning mb-3">
                        <strong>Référence :</strong> {{ $commande->reference }}<br>
                        <strong>Client :</strong> {{ $commande->client->prenom }} {{ $commande->client->nom }}<br>
                        <strong>Total :</strong> {{ number_format($commande->total, 2) }} €<br>
                        <strong>Statut :</strong>
                        @switch($commande->statut)
                            @case('en_attente')
                                <span class="badge badge-warning">En attente</span>
                                @break
                            @case('confirmee')
                                <span class="badge badge-info">Confirmée</span>
                                @break
                            @case('livree')
                                <span class="badge badge-success">Livrée</span>
                                @break
                            @case('annulee')
                                <span class="badge badge-danger">Annulée</span>
                                @break
                        @endswitch
                    </div>

                    <p class="text-danger">
                        <strong>⚠️ Attention :</strong> La suppression de cette commande restaurera le stock des produits. Cette action est irréversible.
                    </p>

                    <div class="card mb-3">
                        <div class="card-header">Détails des produits</div>
                        <div class="card-body">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commande->details as $detail)
                                    <tr>
                                        <td>{{ $detail->produit->nom }}</td>
                                        <td>{{ $detail->quantite }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <form action="{{ route('commandes.destroy', $commande) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer définitivement
                            </button>
                        </form>
                        <a href="{{ route('commandes.show', $commande) }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
