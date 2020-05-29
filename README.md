# wild-series

**Lien de la vidéo pour la quête 11 de symfony
https://www.loom.com/share/66b2187d89b3420588fbbf56a26fcdc3

**Créer nouveau projet Symfony

symfony new --full <name_project> --version=lts

**Installation de Webpack

Documentation Webpack/Symfony
Installer Encore dans les applications Symfony

composer require symfony/webpack-encore-bundle

    Remarque : dans toute cette quête, tu utiliseras yarn, car c’est l’outil recommandé par Symfony dans la documentation officielle, mais note que tu peux aussi utiliser un outil équivalent qui s’appelle npm. Les deux sont équivalents (mais si tu commences un projet avec l’un, il ne faut plus que tu en changes en cours de route, au risque d’avoir des conflits) et nécessitent également d’installer nodejs. Si tu n’as pas déjà ces outils sur ton poste, il faudra donc les installer avant de continuer.

**Installation de nodejs via la doc ubuntu

yarn install

**Installer Encore dans les applications non Symfony

yarn add @symfony/webpack-encore --dev

Liens assets dans twig

Pour intégrer ces fichiers générés par Encore dans Symfony, il faut ajouter les chemins dans le HTML du fichier base.html.twig.

{% block stylesheets %}
        {{ encore_entry_link_tags('app') }}
{% endblock %}

{% block javascripts %}
           {{ encore_entry_script_tags('app') }}
{% endblock %}

Installation du SCSS dans ton projet

Décoche la suivante dans le fichier webpack.config.js

.enableSassLoader()

**installation de Bootstrap

Guide installation Bootstrap (Symfony)
Bootstrap CSS

yarn add bootstrap --dev

Importe Bootstrap dans le fichier scss

@import "~bootstrap/scss/bootstrap";

Bootstrap JS

yarn add jquery popper.js --dev

**Dans le fichier Javascript

// app.js

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

**Installation de Fontawesome

yarn add @fortawesome/fontawesome-free

Importe Font awesome dans ton fichier SCSS

$fa-font-path: '~@fortawesome/fontawesome-free/webfonts';
@import '~@fortawesome/fontawesome-free/scss/fontawesome';
@import '~@fortawesome/fontawesome-free/scss/solid';
@import '~@fortawesome/fontawesome-free/scss/regular';
@import '~@fortawesome/fontawesome-free/scss/brands';

**Relancer le build Webpack

yarn encore dev --watch
