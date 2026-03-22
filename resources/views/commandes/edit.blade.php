@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier la Commande {{ $commande->reference }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('commandes.update', $commande) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-3">
            <div class="card-body">

                <div class="form-group mb-2">
                    <label for="client_id">Client</label>
                    <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $commande->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->prenom }} {{ $client->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="date_commande">Date de commande</label>
                    <input type="date" name="date_commande" id="date_commande"
                           class="form-control @error('date_commande') is-invalid @enderror"
                           value="{{ old('date_commande', $commande->date_commande->format('Y-m-d')) }}" required>
                    @error('date_commande')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="statut">Statut</label>
                    <select name="statut" id="statut" class="form-control @error('statut') is-invalid @enderror" required>
                        <option value="en_attente" {{ old('statut', $commande->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmee" {{ old('statut', $commande->statut) == 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                        <option value="livree" {{ old('statut', $commande->statut) == 'livree' ? 'selected' : '' }}>Livrée</option>
                        <option value="annulee" {{ old('statut', $commande->statut) == 'annulee' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Ajouter un produit à la commande</div>
            <div class="card-body">
                <form action="{{ route('commandes.add-products', $commande) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <select name="produit_id" class="form-control" required>
                            <option value="">Sélectionner un produit</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id }}">
                                    {{ $produit->nom }} - {{ number_format($produit->prix, 2) }} € (Stock: {{ $produit->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="quantite" class="form-control" placeholder="Quantité" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-success w-100">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
