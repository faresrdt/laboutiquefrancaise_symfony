# Projet La Boutique Française

Site e-commerce complet créé avec Symfony 5

# Why ?

Tout simplement pour m'exercer. J'ai découvert Symfony il y a peu et j’ai construit ce site pour montrer ce que je suis capable de réaliser.
C'est un premier projet et j'espère qu'il y en aura encore beaucoup d'autres.

# Prérequis

- PHP 7.4 ou supérieur
- Composer
- MySQL
- Node.js et Yarn (ou npm)
- Un serveur web local comme XAMPP, MAMP ou WampServer

# Installation

## Clonage du dépôt :

git clone https://github.com/faresrdt/laboutiquefrancaise_symfony.git
cd votre-projet

## Configuration de la Base de Données :

Copiez le fichier .env vers un nouveau fichier .env.local.
Modifiez la ligne DATABASE_URL dans le fichier .env.local pour correspondre à votre configuration de base de données locale.

DATABASE_URL=mysql://user:password@localhost:3306/db_name

## Création de la Base de Données et Importation de la Structure :

Copier ces lignes l'une après l'autre pour créer la base de donnée et importer la structure
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate


## Lancement du Serveur Local :

Placez votre projet dans le dossier "htdocs" (ou le dossier correspondant) de votre serveur web local.
Démarrez votre serveur web local et accédez à votre site via localhost/nom_de_votre_projet dans votre navigateur.

# Utilisation

Vous avez maintenant accès au site sur votre environnement local. Vous pouvez naviguer, créer une compte utilisateur et utiliser toutes les fonctionnalités qu'une boutique en ligne possède.
