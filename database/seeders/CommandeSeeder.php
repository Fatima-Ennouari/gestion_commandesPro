<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;
use App\Models\DetailCommande;
use Illuminate\Support\Str;

class CommandeSeeder extends Seeder
{
    public function run()
    {
        $clients = Client::all();
        $produits = Produit::all();

        if ($clients->isEmpty() || $produits->isEmpty()) {
            echo "Veuillez d'abord exécuter ClientSeeder et ProduitSeeder\n";
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $client = $clients->random();
            $commande = Commande::create([
                'reference' => 'CMD-' . Str::random(8),
                'client_id' => $client->id,
                'date_commande' => now()->subDays(rand(1, 30)),
                'statut' => ['en_attente', 'confirmee', 'livree', 'annulee'][array_rand(['en_attente', 'confirmee', 'livree', 'annulee'])],
                'total' => 0,
            ]);

            // Ajouter 2 à 5 produits à chaque commande
            $nombreProduits = rand(2, 5);
            $total = 0;
            $produitsSelectionnes = $produits->random($nombreProduits);

            foreach ($produitsSelectionnes as $produit) {
                $quantite = rand(1, 10);
                $sousTotal = $produit->prix * $quantite;

                DetailCommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $produit->id,
                    'quantite' => $quantite,
                    'prix_unitaire' => $produit->prix,
                    'sous_total' => $sousTotal,
                ]);

                $total += $sousTotal;
            }

            // Mise à jour du total de la commande
            $commande->update(['total' => $total]);
        }
    }
}
