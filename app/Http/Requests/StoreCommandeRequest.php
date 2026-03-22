<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommandeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id|integer',
            'date_commande' => 'required|date|date_format:Y-m-d',
            'produits' => 'required|array|min:1',
            'produits.*.id' => 'required|exists:produits,id|integer',
            'produits.*.quantite' => 'required|integer|min:1|max:999',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Le client est obligatoire.',
            'client_id.exists' => 'Le client sélectionné n\'existe pas.',
            'date_commande.required' => 'La date de commande est obligatoire.',
            'date_commande.date' => 'La date doit être une date valide.',
            'produits.required' => 'Au moins un produit est obligatoire.',
            'produits.array' => 'Les produits doivent être un tableau.',
            'produits.min' => 'Vous devez sélectionner au moins un produit.',
            'produits.*.id.required' => 'Chaque produit doit être spécifié.',
            'produits.*.id.exists' => 'Un des produits sélectionnés n\'existe pas.',
            'produits.*.quantite.required' => 'La quantité est obligatoire.',
            'produits.*.quantite.integer' => 'La quantité doit être un nombre entier.',
            'produits.*.quantite.min' => 'La quantité minale est 1.',
        ];
    }
}
