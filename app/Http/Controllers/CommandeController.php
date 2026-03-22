<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;
use App\Models\DetailCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Liste des commandes (10 par page)
    public function index()
    {
        $commandes = Commande::with('client', 'details.produit')
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);

        return view('commandes.index', compact('commandes'));
    }

    // Formulaire création
    public function create()
    {
        $clients = Client::all();
        $produits = Produit::where('stock', '>', 0)->get();

        return view('commandes.create', compact('clients', 'produits'));
    }

    // Enregistrer une commande
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_commande' => 'required|date',
            'produits' => 'required|array|min:1',
            'produits.*.id' => 'required|exists:produits,id',
            'produits.*.quantite' => 'required|integer|min:1',
        ]);

        $commande = new Commande();
        $commande->reference = 'CMD-' . time();
        $commande->client_id = $request->client_id;
        $commande->date_commande = $request->date_commande;
        $commande->statut = 'en_attente';
        $commande->total = 0;
        $commande->save();

        $total = 0;

        foreach ($request->produits as $produitData) {
            $produit = Produit::find($produitData['id']);
            if ($produit->stock < $produitData['quantite']) {
                return back()->with('error', 'Stock insuffisant pour ' . $produit->nom);
            }

            $sousTotal = $produit->prix * $produitData['quantite'];

            $detail = new DetailCommande();
            $detail->commande_id = $commande->id;
            $detail->produit_id = $produit->id;
            $detail->quantite = $produitData['quantite'];
            $detail->prix_unitaire = $produit->prix;
            $detail->sous_total = $sousTotal;
            $detail->save();

            $produit->stock -= $produitData['quantite'];
            $produit->save();

            $total += $sousTotal;
        }

        $commande->total = $total;
        $commande->save();

        return redirect()->route('commandes.index')->with('success', 'Commande créée avec succès.');
    }

    // Afficher une commande
    public function show(Commande $commande)
    {
        $commande->load('client', 'details.produit');
        return view('commandes.show', compact('commande'));
    }

    // Formulaire modification
    public function edit(Commande $commande)
    {
        $clients = Client::all();
        $produits = Produit::all();
        $commande->load('details');

        return view('commandes.edit', compact('commande', 'clients', 'produits'));
    }

    // Mettre à jour
    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_commande' => 'required|date',
            'statut' => 'required|in:en_attente,confirmee,livree,annulee',
        ]);

        $commande->update($request->only(['client_id','date_commande','statut']));
        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès.');
    }

    // Supprimer
    public function destroy(Commande $commande)
    {
        // Restaurer le stock
        foreach ($commande->details as $detail) {
            $produit = $detail->produit;
            $produit->stock += $detail->quantite;
            $produit->save();
        }

        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès.');
    }

    // Confirmation avant suppression
    public function confirmDelete(Commande $commande)
    {
        return view('commandes.confirm-delete', compact('commande'));
    }

    // Ajouter un produit à une commande existante
    public function addProducts(Request $request, Commande $commande)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $produit = Produit::find($request->produit_id);
        if ($produit->stock < $request->quantite) {
            return back()->with('error', 'Stock insuffisant');
        }

        $sousTotal = $produit->prix * $request->quantite;

        $detail = new DetailCommande();
        $detail->commande_id = $commande->id;
        $detail->produit_id = $produit->id;
        $detail->quantite = $request->quantite;
        $detail->prix_unitaire = $produit->prix;
        $detail->sous_total = $sousTotal;
        $detail->save();

        $produit->stock -= $request->quantite;
        $produit->save();

        $commande->total += $sousTotal;
        $commande->save();

        return redirect()->route('commandes.show', $commande)->with('success', 'Produit ajouté à la commande.');
    }

    // Statistiques simples
    public function statistiques()
    {
        $commandesParClient = Client::withCount('commandes')->orderBy('commandes_count', 'desc')->get();
        $caParProduit = Produit::withSum('detailsCommandes as ca', 'sous_total')->orderBy('ca','desc')->get();
        $commandesParStatut = Commande::select('statut', DB::raw('count(*) as total'))->groupBy('statut')->get();
        $caTotal = Commande::sum('total');
        $totalCommandes = Commande::count();

        return view('commandes.statistiques', compact(
            'commandesParClient','caParProduit','commandesParStatut','caTotal','totalCommandes'
        ));
    }
}
