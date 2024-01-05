## API

| url | Verb HTTP | Controller | Method | constraint | title | content | comment |
|---|---|---|---|---|---|---|---|
| /api/vegetable | GET | Api\Vegetable | list | | | Données des fruits et légumes | |
| /api/vegetable/{id} | GET | Api\Vegetable | show | id = \d+ | | données d'un fruit/légume | [id] : vegetable's identifer (integer only) |
| /api/recipe | GET | Api\Recipe | list | | | Données des recettes | |
| /api/recipe/{id} | GET | Api\Recipe | show | id = \d+ | | données d'une recette | [id] : recipe's identifer (integer only) |
| /api/member/{id} | GET | Api\Member | show | id = \d+ | Profil | member's profil | [id] : member's identifer (integer only) |
| /api/member/{id} | PUT | Api\Member | update | id = \d+ | | modifier un member | [id] : member's identifer (integer only) |
| /api/member | POST | Api\Member | create | | | Ajouter un member| |
| /api/member/{id} | DELETE | Api\Member | delete | id = \d+ | | Suppression d'un member | [id] : member's identifer (integer only) |
| /api/login_check | POST | Api\Login | login | | | Connexion | |
| /api/logout | POST | Api\Login | login | | | Deconnexion| |
| /api/favorite | GET | Api\Favorite | list |  |  | Afficher la liste des favoris | |
| /api/favorite/delete/{id} | DELETE | Api\Favorite | delete | id = \d+ |  | Supprimer le favoris | |
| /api/favorite/add/{id} | POST | Api\Favorite | add | id = \d+ |  | Supprimer le favoris | |
| /api/user | POST | Api\User | suscribe  |  |  | s'inscrire à la newsletter |
| /api/user/{id} | DELETE | Api\User | unsuscribe | id = \d+  |  | se désinscrire de la newsletter | |

## FrontOffice

| url | Verb HTTP | title | content | comment |
|---|---|---|---|---|
| / | GET | Accueil | 
| /fruits-legumes | GET | Fruits et légumes | Liste des fruits et légumes | |
| /fruits-legumes/{id} | GET | [titre du fruit/légume] | Description d'un fruit ou légume | [id] : vegetable's identifer (integer only) |
| /recettes | GET | Recettes | Liste des recettes| |
| /recette/{id} | GET | [titre de la recette] | Description d'une recette | [id] : recipe's identifer (integer only) |
| /page/contact | GET | Contact | contact | |
| /page/cgu | GET | CGU | Termes et conditions | |
| /page/mentions-legales | GET | Mentions légales| Mentions légales | |
| /page/qui-sommes-nous | GET | Qui sommes-nous ? | L'équipe | |
| /profil/{id} | GET | Profil | Profil du user | [id] : user's identifer (integer only) |
| /profil/favoris | GET | Favoris | Les favoris | |
| /connexion | GET | Connexion | Connexion au site| |
| /inscription | GET | S'inscrire | Inscription au site | |

## BackOffice

| url | Verb HTTP | Controller | Method | constraint | content | comment | 
|---|---|---|---|---|---|---|
| /back/ | GET | Back\Main | home | | backoffice homepage | |
| /back/vegetable/ | GET | Back\Vegetable | index | | Liste des fruits et légumes | |
| /back/vegetable/{id} | GET | Back\Vegetable | show | id = \d+ | données d'un fruit/légume | [id] : vegetable's identifer (integer only) |
| /back/vegetable/update/{id} | GET/POST | Back\Vegetable | update | id = \d+ | modifier un fruit/légume | [id] : vegetable's identifer (integer only) |
| /back/vegetable/create | GET/POST | Back\Vegetable | create | | Ajout d'un fruit/légume | |
| /back/vegetable/delete/{id} | POST | Back\Vegetable | delete | id = \d+ | Suppression d'un fruit/légume | [id] : vegetable's identifer (integer only) |
| /back/recipe/ | GET | Back\Recipe | index | | Liste des recettes | |
| /back/recipe/{id} | GET | Back\Recipe | show | id = \d+ | données d'une recette | [id] : recipe's identifer (integer only) |
| /back/recipe/{id}/update | GET/POST | Back\Recipe | update | id = \d+ | modifier une recette | [id] : recipe's identifer (integer only) |
| /back/recipe/create | GET/POST | Back\Recipe | create | | Ajout d'une recette | |
| /back/recipe/{id} | POST | Back\Recipe | delete | id = \d+ | Suppression d'une recette | [id] : recipe's identifer (integer only) |
| /back/ingredient/ | GET | Back\Ingredient | index | | Liste des ingrédients | |
| /back/ingredient/{id}/update | GET/POST | Back\Ingredient | update | id = \d+ | modifier une recette | [id] : ingredient's identifer (integer only) |
| /back/ingredient/create | GET/POST | Back\Ingredient | create | | Ajout d'une recette | |
| /back/ingredient/{id} | POST | Back\Ingredient | delete | id = \d+ | Suppression d'une recette | [id] : ingredient's identifer (integer only) |
| /back/member| GET | Back\Member | index | | Liste des membres | [id] : member's identifer (integer only) |
| /back/member/update/{id} | GET/POST | Back\Member | update | id = \d+ | modifier un member | [id] : member's identifer (integer only) |
| /back/member/{id} | POST | Back\Member | delete | id = \d+ | Suppression d'un member | [id] : user's identifer (integer only) |
| /back/user | GET | Back\User | index  | | affiche la liste des users newsletter | |
| /back/user/create | GET/POST | Back\User | create  | | creation d'un user newsletter | |
| /back/user/{id}/update | GET/POST | Back\User | update |  id = \d+ | modifier une inscritpion newsletter| [id] : user's identifer (integer only)|
| /back/user/{id} | POST | Back\User | delete |  id = \d+ | supprimer une inscritpion newsletter| [id] : user's identifer (integer only)|
| /back/content/ | GET | Back\Content | index | | Afficher la liste des quantités et des ingrédients liée à une recette | |
| /back/content/create | GET/POST | Back\Content | create | | Ajouter une quantité liée à un ingrédient et à une recette | |
| /back/content/{id}/update | GET/POST | Back\Content | update | id = \d+ | Modifier une quantité liée à un ingrédient et à une recette | [id] : user's identifer (integer only)|
| /back/content/{id} | POST | Back\Content | delete | id = \d+ | Supprimer une quantité liée à un ingrédient et à une recette | [id] : user's identifer (integer only)|
| /back/login | | Back\Security | login | | Authentification au backoffice | |
| /back/logout | | Back\Security | logout | | Deconnexion du backoffice | |