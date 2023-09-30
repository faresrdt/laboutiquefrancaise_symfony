# Projet La Boutique Française

Site e-commerce complet créé avec Symfony 5, offrant une expérience utilisateur intuitive pour naviguer, sélectionner des produits, les ajouter au panier et finaliser l'achat. Le back-office réalisé avec EasyAdmin 3 permet une gestion efficace des produits, des catégories et des commandes.

# Pourquoi ?

Ce projet est né d'une simple ambition : m'exercer et peaufiner mes compétences. Ayant découvert Symfony récemment, l'élaboration de ce site e-commerce m'a permis de plonger dans les profondeurs de ce framework robuste et d'en explorer les diverses fonctionnalités. À travers la construction de "La Boutique Française", j'ai pu mettre en pratique les concepts appris, et ainsi, créer un produit fonctionnel de bout en bout.

Ce site est une représentation concrète de ce que je suis désormais capable de réaliser avec Symfony, couplé à d'autres technologies comme HTML, CSS, JavaScript, PHP et MySQL. Il symbolise non seulement le commencement de mon parcours avec Symfony, mais également un point de départ prometteur pour une série de projets futurs.

# Pré-requis

- PHP 7.4 ou supérieur
- Composer
- MySQL
- Node.js et Yarn (ou npm)
- Un serveur web local comme XAMPP, MAMP ou WampServer

# Technologie Utilisée

**- Front-end :** HTML, CSS, JavaScript.
**- Back-end :** Symfony 5, PHP.
**- Base de données :** MySQL.
**- Administration :** EasyAdmin 3.
**- Gestion des dépendances :** Composer pour PHP, Yarn pour JavaScript.
**- Versioning :** Git et GitHub.

# Installation

## Clonage du dépôt :

```bash
git clone https://github.com/faresrdt/laboutiquefrancaise_symfony.git
cd votre-projet
```

## Configuration de la Base de Données :

Copiez le fichier .env vers un nouveau fichier .env.local.
Modifiez la ligne DATABASE_URL dans le fichier .env.local pour correspondre à votre configuration de base de données locale.

```bash
DATABASE_URL=mysql://user:password@localhost:3306/db_name
```
## Création de la Base de Données et Importation de la Structure :

Copier ces lignes l'une après l'autre pour créer la base de donnée et importer la structure
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## Lancement du Serveur Local :

Placez votre projet dans le dossier "htdocs" (ou le dossier correspondant) de votre serveur web local.
Démarrez votre serveur web local et accédez à votre site via localhost/nom_de_votre_projet dans votre navigateur.

# Utilisation

Vous avez maintenant accès au site sur votre environnement local. Vous pouvez naviguer, créer une compte utilisateur et utiliser toutes les fonctionnalités qu'une boutique en ligne possède.
