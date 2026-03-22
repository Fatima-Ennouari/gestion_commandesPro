<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'client_id', 'date_commande', 'statut', 'total'];

    protected $casts = [
        'date_commande' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function details()
    {
        return $this->hasMany(DetailCommande::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'details_commandes')
                    ->withPivot('quantite', 'prix_unitaire', 'sous_total')
                    ->withTimestamps();
    }
}
