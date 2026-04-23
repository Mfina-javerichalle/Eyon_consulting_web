<!--  1. Lancer le projet
bashphp artisan serve
# → démarre le serveur local sur http://localhost:8000
# → obligatoire pour tester en local avec XAMPP

 2. Base de données — Migrations
bashphp artisan migrate
# → exécute toutes les migrations en attente
# → crée les tables dans MySQL

php artisan migrate:fresh
# → supprime TOUTES les tables et les recrée
# →  efface toutes les données !

php artisan migrate:fresh --seed
# → supprime tout + recrée les tables + exécute les seeders
# → commande la plus utilisée en développement 

php artisan migrate:rollback
# → annule la dernière migration
# → utile si tu as fait une erreur

php artisan migrate:status
# → affiche la liste des migrations et leur état
# → (exécutée ou pas encore)

php artisan make:migration create_services_table
# → crée un nouveau fichier de migration
# → pour créer une nouvelle table

php artisan make:migration add_telephone_to_users_table
# → crée une migration pour modifier une table existante

 3. Base de données — Seeders
bashphp artisan db:seed
# → exécute DatabaseSeeder.php
# → remplit la BDD avec toutes les données de test

php artisan db:seed --class=ServiceSeeder
# → exécute SEULEMENT le ServiceSeeder
# → utile pour ajouter juste un type de données

php artisan make:seeder ServiceSeeder
# → crée un nouveau fichier Seeder

 4. Créer des fichiers
bashphp artisan make:model Service
# → crée app/Models/Service.php

php artisan make:model Service -m
# → crée le Model ET sa migration en même temps
# → -m = migration  très pratique

php artisan make:model Service -mfs
# → crée le Model + Migration + Factory + Seeder
# → tout en une seule commande 

php artisan make:controller AdminController
# → crée app/Http/Controllers/AdminController.php

php artisan make:controller AdminController --resource
# → crée un controller avec les 7 méthodes CRUD déjà écrites :
# → index, create, store, show, edit, update, destroy

php artisan make:middleware AdminMiddleware
# → crée app/Http/Middleware/AdminMiddleware.php

php artisan make:request StoreServiceRequest
# → crée un fichier de validation de formulaire

php artisan make:factory DossierFactory
# → crée database/factories/DossierFactory.php

php artisan make:seeder ServiceSeeder
# → crée database/seeders/ServiceSeeder.php

php artisan make:mail ResetPasswordMail
# → crée un fichier pour envoyer un email

 5. Routes
bashphp artisan route:list
# → affiche TOUTES les routes de ton projet
# → avec leur URL, méthode HTTP, Controller et middleware
# → très utile pour déboguer 

php artisan route:list --name=admin
# → filtre et affiche seulement les routes admin

php artisan route:list --name=client
# → filtre et affiche seulement les routes client

 6. Vider les caches — très important en production
bashphp artisan cache:clear
# → vide le cache général de l'application

php artisan config:clear
# → vide le cache de configuration (.env)
# → obligatoire après avoir modifié le .env 

php artisan view:clear
# → vide le cache des vues Blade
# → obligatoire si les vues ne se mettent pas à jour 

php artisan route:clear
# → vide le cache des routes

php artisan optimize:clear
# → vide TOUS les caches en une seule commande
# → équivalent de toutes les commandes clear ci-dessus 

 7. Storage — fichiers uploadés
bashphp artisan storage:link
# → crée le lien symbolique public/storage → storage/app/public
# → obligatoire pour que les fichiers uploadés soient accessibles
# → à faire UNE SEULE FOIS après installation 

 8. Clé de l'application
bashphp artisan key:generate
# → génère une nouvelle clé APP_KEY dans le .env
# → obligatoire après un git clone sur une nouvelle machine 

 9. Composer — gestion des dépendances PHP
bashcomposer install
# → installe toutes les dépendances du projet (vendor/)
# → obligatoire après un git clone 

composer update
# → met à jour toutes les dépendances

composer require nom/package
# → installe un nouveau package Laravel

 10. Séquence complète — installation du projet
bash# Sur une nouvelle machine ou après git clone :

git clone https://github.com/Mfina-javerichalle/Eyon_consulting_web



 11. Séquence complète — mise à jour en production (o2switch)
bash# Sur le serveur o2switch via SSH :

cd /home/mfja3413/elyon

git pull
# → récupère les dernières modifications GitHub

php artisan migrate
# → exécute les nouvelles migrations

php artisan optimize:clear
# → vide tous les caches

# → site mis à jour 

 Résumé — les plus importantes à retenir
COMMANDE                          QUAND L'UTILISER
─────────────────────────────     ──────────────────────────────
php artisan serve                 → lancer le projet en local
php artisan migrate               → après avoir créé une migration
php artisan migrate:fresh --seed  → reset complet en développement
php artisan db:seed               → remplir la BDD de données test
php artisan route:list            → voir toutes les routes
php artisan optimize:clear        → vider tous les caches
php artisan storage:link          → une fois après installation
php artisan key:generate          → une fois après git clone
php artisan make:model -mfs       → créer un nouveau Model complet
php artisan make:controller       → créer un nouveau Controller


git add .                           # 2. tout ajouter
git commit -m "message clair"       # 3. sauvegarder
git push                            # 4. envoyer sur GitHub




/* ══════════════════════════════════════════════
   CONVERSION DES DATES UTC → HEURE LOCALE
   But : corriger le décalage horaire entre
   la BDD (UTC) et l'utilisateur (son pays)
══════════════════════════════════════════════ */
function convertirDates() {

    // Sélectionne tous les éléments HTML qui ont
    // la classe "msg-time" dans la page
    // (= tous les divs qui affichent une heure de message)
    document.querySelectorAll('.msg-time').forEach(el => {

        // Lit l'attribut data-utc de l'élément
        // Exemple de valeur : "2026-04-23T09:00:00.000000Z"
        // C'est la date stockée en UTC dans MySQL
        const utc = el.getAttribute('data-utc');

        // Sécurité : si l'attribut est vide ou absent,
        // on arrête là pour éviter une erreur JavaScript
        if (!utc) return;

        // Crée un objet Date JavaScript à partir de la
        // chaîne UTC — JS comprend automatiquement
        // que le "Z" à la fin signifie UTC
        const date = new Date(utc);

        // Remplace le texte affiché dans le div
        // par la date convertie dans le fuseau
        // horaire LOCAL du navigateur de l'utilisateur
        // 'fr-FR' = format français (jour/mois/année)
        el.textContent = date.toLocaleString('fr-FR', {
            day:    '2-digit', // ex: 23
            month:  '2-digit', // ex: 04
            year:   'numeric', // ex: 2026
            hour:   '2-digit', // ex: 10
            minute: '2-digit'  // ex: 00
            // Résultat final : "23/04/2026, 10:00"
        });
    });
}

/* ══════════════════════════════════════════════
   ATTENDRE QUE LA PAGE SOIT ENTIÈREMENT CHARGÉE
   avant d'exécuter les fonctions
   (sinon JS cherche des éléments qui n'existent
   pas encore et ça provoque des erreurs)
══════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {

    // Scroll automatique vers le bas du chat
    // pour voir le dernier message
    scrollChat();

    // Conversion de toutes les dates UTC
    // en heure locale de l'utilisateur
    convertirDates();
});




 {{-- APRÈS --}}
<span class="msg-time" data-utc="{{ optional($message->created_at)->toISOString() }}">
    {{ optional($message->created_at)->format('d/m/Y à H:i') }}
</span>

-->

