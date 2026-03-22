# Gestion Commandes

Application web de gestion de commandes développée avec Laravel 10 et Bootstrap 5.

## Fonctionnalités

- Authentification (inscription / connexion) via Laravel Breeze
- Gestion des commandes (créer, afficher, modifier, supprimer)
- Gestion du stock produits (décrémentation automatique à la commande)
- Ajout de produits à une commande existante
- Confirmation avant suppression
- Statistiques : commandes par client, chiffre d'affaires par produit, répartition par statut
- Pagination Bootstrap 5

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | PHP 8.2 / Laravel 10 |
| Frontend | Bootstrap 5 (CDN) |
| Base de données | MySQL (XAMPP) |
| Auth | Laravel Breeze (Blade) |

## Structure de la base de données

```
clients
  id, nom, prenom, email, telephone, adresse

produits
  id, nom, description, prix, stock

commandes
  id, reference, client_id, date_commande, statut, total

details_commandes
  id, commande_id, produit_id, quantite, prix_unitaire, sous_total
```

Statuts possibles : `en_attente`, `confirmee`, `livree`, `annulee`

## Installation

### Prérequis
- XAMPP (PHP 8.2+, MySQL)
- Composer
- Node.js & npm
`



## Routes principales

| Méthode | URL | Description |
|---|---|---|
| GET | /commandes | Liste des commandes |
| GET | /commandes/create | Formulaire création |
| POST | /commandes | Enregistrer commande |
| GET | /commandes/{id} | Détail commande |
| GET | /commandes/{id}/edit | Formulaire modification |
| PUT | /commandes/{id} | Mettre à jour |
| DELETE | /commandes/{id} | Supprimer |
| GET | /commandes/{id}/confirm-delete | Confirmation suppression |
| POST | /commandes/{id}/add-products | Ajouter un produit |
| GET | /statistiques | Page statistiques |


# Page de connexion
![Page de Connexion](public/images/login.png)

Interface d'authentification avec email et mot de passe

Option "Se souvenir de moi"

Lien d'inscription pour les nouveaux utilisateurs

# Liste des commandes
![Liste des Commandes](public/images/liste_commande.png)

Tableau paginé des commandes (10 par page)

Affichage des références, clients, dates, totaux et statuts

Badges colorés selon le statut

Actions (Voir, Modifier, Supprimer)

Pagination Bootstrap 5

# Création de commande
![Création de Commande](public/images/new_commande.png)

Formulaire de création avec sélection client

Date de commande pré-remplie

Sélection des produits avec contrôle des stocks

Calcul automatique du total

# Détails de commande
![Détails de Commande](public/images/details.png)

Informations client complètes

Détails de la commande

Liste détaillée des produits avec quantités et prix

Calcul des sous-totaux et du total

Bouton de retour

# Statistiques
![Statistiques](public/images/statistiques.png)

KPIs principaux (total commandes, CA, clients, produits)

Répartition par statut avec pourcentages

Top 10 clients par chiffre d'affaires

Top 10 produits avec part du CA total

Visualisation des performances

## Données de test générées
Les seeders créent automatiquement :

10 clients

5 produits

19 commandes avec différents statuts

Gestion automatique des stocks

Chiffre d'affaires total : ~98,426.74 €

## Statistiques disponibles
Total commandes : 19 commandes

Chiffre d'affaires total : 98,426.74 €

Nombre de clients : 10 clients

Nombre de produits : 5 produits

Répartition par statut : graphique en pourcentages

Top clients : classement par CA

Top produits : classement avec part du CA total

##  Interface utilisateur
Design responsive (Bootstrap 5)

Navigation intuitive

Messages de confirmation/succès/erreur

Badges colorés pour les statuts

Formatage des prix et dates

Pagination élégante

##  Sécurité
Routes protégées par authentification

Validation des formulaires

Protection CSRF

Gestion des transactions pour l'intégrité des données

Contrôle des stocks avant validation
## Performances
Requêtes optimisées avec Eloquent

Pagination pour les longues listes

Chargement des relations avec with()

Cache des données statiques

## Auteurs
Aymane El asri
