<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;

class ProduitSeeder extends Seeder
{
    public function run()
    {
        $produits = [
            ['nom' => 'Ordinateur Portable', 'description' => 'PC portable haute performance', 'prix' => 899.99, 'stock' => 10],
            ['nom' => 'Souris Sans Fil', 'description' => 'Souris ergonomique', 'prix' => 29.99, 'stock' => 50],
            ['nom' => 'Clavier Mécanique', 'description' => 'Clavier pour gaming', 'prix' => 89.99, 'stock' => 30],
            ['nom' => 'Écran 24"', 'description' => 'Écran Full HD', 'prix' => 199.99, 'stock' => 15],
            ['nom' => 'Disque Dur Externe', 'description' => '1 To de stockage', 'prix' => 69.99, 'stock' => 25],
        ];

        foreach ($produits as $produit) {
            Produit::create($produit);
        }
    }
}
