@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nouvelle Commande</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('commandes.store') }}" method="POST">
        @csrf

        <div class="card mb-3">
            <div class="card-body">

                <div class="form-group mb-2">
                    <label for="client_id">Client</label>
                    <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
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
                           value="{{ old('date_commande', date('Y-m-d')) }}" required>
                    @error('date_commande')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <label>Produits</label>
                @error('produits')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                @php $produitsList = old('produits', [[]]); @endphp

                @foreach($produitsList as $list => $item)
                <div class="row mb-2">
                    <div class="col-md-6">
                        <select name="produits[{{ $list }}][id]" class="form-control" required>
                            <option value="">Sélectionner un produit</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id }}" {{ ($item['id'] ?? '') == $produit->id ? 'selected' : '' }}>
                                    {{ $produit->nom }} - {{ number_format($produit->prix, 2) }} € (Stock: {{ $produit->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="produits[{{ $list }}][quantite]"
                               class="form-control @error('produits.'.$list.'.quantite') is-invalid @enderror"
                               placeholder="Quantité" min="1"
                               value="{{ $item['quantite'] ?? '' }}" required>
                        @error('produits.'.$list.'.quantite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Créer la commande</button>
            <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
