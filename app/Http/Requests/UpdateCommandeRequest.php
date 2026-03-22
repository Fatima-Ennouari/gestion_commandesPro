<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommandeRequest extends FormRequest
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
            'statut' => 'required|in:en_attente,confirmee,livree,annulee',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Le client est obligatoire.',
            'client_id.exists' => 'Le client sélectionné n\'existe pas.',
            'date_commande.required' => 'La date de commande est obligatoire.',
            'date_commande.date' => 'La date doit être une date valide.',
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut sélectionné n\'est pas valide.',
        ];
    }
}
