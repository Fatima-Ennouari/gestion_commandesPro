@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Statistiques des Commandes</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Commandes</h5>
                    <h2 class="text-primary">{{ $totalCommandes }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Chiffre d'Affaires Total</h5>
                    <h2 class="text-success">{{ number_format($caTotal, 2) }} €</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Nombre de Clients</h5>
                    <h2 class="text-info">{{ $commandesParClient->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Nombre de Produits</h5>
                    <h2 class="text-warning">{{ $caParProduit->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Commandes par Statut</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Statut</th>
                                <th>Nombre</th>
                                <th>Pourcentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalStatut = $commandesParStatut->sum('total');
                            @endphp
                            @foreach($commandesParStatut as $stat)
                            <tr>
                                <td>
                                    @switch($stat->statut)
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
                                </td>
                                <td>{{ $stat->total }}</td>
                                <td>
                                    {{ round(($stat->total / max($totalStatut, 1)) * 100, 2) }}%
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Top 10 : Chiffre d'Affaires par Client</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Nombre Commandes</th>
                                <th>Total CA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commandesParClient->take(10) as $client)
                            <tr>
                                <td>
                                    <strong>{{ $client->prenom }} {{ $client->nom }}</strong>
                                </td>
                                <td>{{ $client->commandes_count }}</td>
                                <td>
                                    @php
                                        $caClient = $client->commandes->sum('total');
                                    @endphp
                                    {{ number_format($caClient, 2) }} €
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Aucun client</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Top 10 : Chiffre d'Affaires par Produit</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix Unitaire</th>
                                <th>CA Réalisé</th>
                                <th>Pourcentage du CA Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($caParProduit->take(10) as $produit)
                            <tr>
                                <td>
                                    <strong>{{ $produit->nom }}</strong>
                                </td>
                                <td>{{ number_format($produit->prix, 2) }} €</td>
                                <td>{{ number_format($produit->ca ?? 0, 2) }} €</td>
                                <td>
                                    {{ round((($produit->ca ?? 0) / max($caTotal, 1)) * 100, 2) }}%
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun produit vendu</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('commandes.index') }}" class="btn btn-secondary">Retour aux commandes</a>
    </div>
</div>
@endsection
