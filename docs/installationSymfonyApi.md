# Instalation Symfony back SeasOnly

- installation : 
Cloner le projet avec la clé SSH

## Se rendre sur la branche correspondante

```bash
git checkout feature/RecipeController
```

## Installation des dépendances

```bash
composer install
```

## Créer un fichier .env.local à la racine du projet

C'est le fichier qui contient les variables d'environnement pour notre application. Il est utilisé pour stocker des configurations spécifiques à l'environnement (par exemple, les informations de la base de donnée).

Mettre la ligne de code ci-dessous dans le fichier .env.local

```env
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
```

- Remplacer le premier "app" par le username de votre bdd

- Le "!ChangeMe!" par le password de votre bdd

- Le deuxième "app" par "seasonly"

- Et le "8" après serverVersion= par "mariadb-10.3.2"

## Lancer la commande de création de la database

```bash
php bin/console doctrine:database:create
```

## Lancer la commande de migration

```bash
bin/console doctrine:migrations:migrate
```

## lancer la commande de création de fake data (fixtures)

```bash
php bin/console doctrine:fixtures:load
```

## Lancer un serveur en local

```bash
php -S localhost:8000
```
