# Learning Designer

Application web de scénarisation pédagogique inspirée de l'UCL Learning Designer.

Le projet permet de concevoir des séquences d'apprentissage structurées en moments et activités, de les analyser visuellement, de les enrichir avec des compétences numériques, puis de les exporter, sauvegarder et partager.

- Dépôt : [https://github.com/YannHY/learning-designer](https://github.com/YannHY/learning-designer)
- Guide d'utilisation : [guide-fr.md](./guide-fr.md)

## Fonctionnalités principales

- création de scénarios composés de moments, objectifs, choix pédagogiques et activités
- typage des activités selon les catégories d'apprentissage
- paramétrage de la durée, du groupe, de la synchronicité, de la modalité et de l'évaluation
- association de compétences numériques via un sélecteur dédié
- formulation d'acquis d'apprentissage à partir de la taxonomie révisée de Bloom
- vues multiples : liste, colonnes, grille
- panneau d'analyse avec graphiques de répartition
- partition chronologique configurable
- export en JSON/LDJ, CSV, HTML, Markdown et feuille de calcul
- mode plein écran pour certains champs d'édition
- interface bilingue FR / EN
- thème clair / sombre

## Compétences numériques

L'application n'utilise plus un catalogue Moodle / H5P.

Les activités peuvent maintenant être liées à un référentiel de compétences numériques structuré en trois domaines :

- `Acquérir`
- `Approfondir`
- `Créer`

Chaque compétence est affichée avec un code court du type `A1`, `P6` ou `C14`, avec une couleur propre à son domaine et une infobulle détaillée au survol.

## Sauvegarde, comptes et partage

L'application peut fonctionner :

- en mode local dans le navigateur pour un usage ponctuel
- en mode connecté sur un hébergement PHP/MySQL pour sauvegarder les productions

Quand le backend PHP est activé, le projet prend en charge :

- création du premier administrateur via `setup_admin.php`
- inscription via `signup.php`
- connexion / déconnexion via `login.php` et `logout.php`
- gestion du profil utilisateur via `profile.php`
- administration des comptes via `admin.php`
- sauvegarde, chargement et suppression des productions
- publication d'un design via un lien partageable avec `publish_design.php`
- consultation d'une version publiée via `view.php`

## Structure du projet

- [index.html](/Users/rene/Documents/claude/learning-designer/index.html) : interface principale
- [interface.js](/Users/rene/Documents/claude/learning-designer/interface.js) : logique applicative côté client
- [interface.css](/Users/rene/Documents/claude/learning-designer/interface.css) : styles principaux
- [about.php](/Users/rene/Documents/claude/learning-designer/about.php) : page de présentation
- [view.php](/Users/rene/Documents/claude/learning-designer/view.php) : vue publique d'un design publié
- [save_design.php](/Users/rene/Documents/claude/learning-designer/save_design.php), [get_design.php](/Users/rene/Documents/claude/learning-designer/get_design.php), [list_designs.php](/Users/rene/Documents/claude/learning-designer/list_designs.php), [delete_design.php](/Users/rene/Documents/claude/learning-designer/delete_design.php) : API de persistance
- [lib/bootstrap.php](/Users/rene/Documents/claude/learning-designer/lib/bootstrap.php) : bootstrap PHP et fonctions communes

## Installation

### Utilisation statique

Pour tester l'interface seule, il suffit de servir le dossier avec un serveur web statique.

Exemple :

```bash
php -S localhost:8000
```

Puis ouvrir `http://localhost:8000/index.html`.

### Utilisation avec backend PHP/MySQL

1. Déployer le projet sur un hébergement PHP.
2. Configurer les accès applicatifs et base de données.
3. Ouvrir `setup_admin.php` lors du premier démarrage.

### Configuration

Le fichier [app-config.php](/Users/rene/Documents/claude/learning-designer/app-config.php) sert de gabarit.  
Les secrets réels doivent être définis dans un fichier local non versionné, typiquement `learning-design-secret.php`.

Variables attendues :

- `APP_DB_DSN`
- `APP_DB_USER`
- `APP_DB_PASS`
- `APP_BASE_URL`

Les tables nécessaires sont créées automatiquement au premier accès.

## État actuel

Le projet est aujourd'hui à la fois :

- un outil de conception pédagogique
- un espace personnel de sauvegarde de scénarios
- un outil de publication et de consultation de designs partagés

Le `README` doit donc être lu comme celui d'une application web complète, et non plus comme celui d'un simple prototype front-end.

## Crédits

- Inspiré de l'UCL Learning Designer
- Développé par Yann Houry et François Jourde
- Licence : CC BY-SA
