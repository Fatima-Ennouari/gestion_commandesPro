@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-3">
        <div class="col">
            <h2>Détails de la commande {{ $commande->reference }}</h2>
        </div>
        <div class="col text-right">
            <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Informations client</div>
                <div class="card-body">
                    <p><strong>Nom:</strong> {{ $commande->client->prenom }} {{ $commande->client->nom }}</p>
                    <p><strong>Email:</strong> {{ $commande->client->email }}</p>
                    <p><strong>Téléphone:</strong> {{ $commande->client->telephone ?? 'Non renseigné' }}</p>
                    <p><strong>Adresse:</strong> {{ $commande->client->adresse ?? 'Non renseignée' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Informations commande</div>
                <div class="card-body">
                    <p><strong>Référence:</strong> {{ $commande->reference }}</p>
                    <p><strong>Date:</strong> {{ $commande->date_commande->format('d/m/Y') }}</p>
                    <p><strong>Statut:</strong>
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
                    </p>
                    <p><strong>Total:</strong> {{ number_format($commande->total, 2) }} €</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Détails des produits</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->details as $detail)
                    <tr>
                        <td>{{ $detail->produit->nom }}</td>
                        <td>{{ $detail->quantite }}</td>
                        <td>{{ number_format($detail->prix_unitaire, 2) }} €</td>
                        <td>{{ number_format($detail->sous_total, 2) }} €</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <th>{{ number_format($commande->total, 2) }} €</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @if($commande->statut != 'livree' && $commande->statut != 'annulee')
    <div class="card">
        <div class="card-header">Ajouter un produit</div>
        <div class="card-body">
            <form action="{{ route('commandes.add-products', $commande) }}" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <label for="produit_id">Produit</label>
                    <select name="produit_id" id="produit_id" class="form-control" required>
                        <option value="">Sélectionner un produit</option>
                        @foreach(\App\Models\Produit::where('stock', '>', 0)->get() as $produit)
                            <option value="{{ $produit->id }}">
                                {{ $produit->nom }} - {{ number_format($produit->prix, 2) }} € (Stock: {{ $produit->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="quantite">Quantité</label>
                    <input type="number" name="quantite" id="quantite" class="form-control" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
