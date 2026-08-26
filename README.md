# Learning Designer

Application web de scénarisation pédagogique inspirée de l'[UCL Learning Designer](https://www.ucl.ac.uk/learning-designer/) et basée sur le travail de [François Jourde](https://github.com/jourde/learning-designer-revised).

Elle permet de structurer une séquence en moments et activités, d'en analyser l'équilibre, puis de la sauvegarder, l'exporter ou la partager. Les designs peuvent aussi être créés et publiés avec une IA grâce au CLI `learning`.

## Documentation

- [Aide complète](./help.php) : prise en main, activités, analyses, sauvegarde, partage, import/export, Markdown, IA et CLI
- [Modèles de scénarios](./models.php) : 28 scénarios génériques préremplis, répartis en huit familles
- [Prompts pédagogiques](./prompts.php) : prompts prêts à copier pour enrichir un scénario avec une IA
- [Comprendre le learning design](./learning-design.php) : principes et cadre pédagogique

## Fonctionnalités

- conception de moments, d'activités et d'acquis d'apprentissage reliés à la taxonomie de Bloom ;
- six types d'apprentissage, compétences numériques, consignes pour les élèves et niveaux AIAS 2.1 ;
- vues liste, colonnes et grille, graphiques d'analyse et chronologie ;
- bibliothèque de 28 modèles prêts à adapter, directement accessible depuis la fenêtre d'import ;
- import de fichiers LDJ, JSON, CSV, Excel et Markdown ;
- export en Markdown, HTML, JSON, Excel et Word, en version enseignant ou élève, avec sélection des moments ;
- comptes, sauvegarde en ligne, publication par lien et catalogue public sous licence Creative Commons ;
- mise en forme Markdown légère avec aperçu, raccourcis clavier et liens nommés dans les activités ;
- interface bilingue français/anglais et thèmes clair/sombre ;
- bibliothèque de cinq prompts pédagogiques avec copie en un clic ;
- création, validation et publication depuis le terminal avec le CLI `learning`.

## Modèles de scénarios

La page [Modèles de scénarios](./models.php) rassemble 28 scénarios génériques répartis en huit familles : entrer dans un apprentissage, comprendre, argumenter, s'entraîner, produire, évaluer, organiser et travailler avec l'IA.

Chaque modèle fournit une structure complète avec moments, activités, durées, types d'apprentissage, modalités, acquis Bloom, consignes et niveaux AIAS. Il peut être chargé directement depuis la fenêtre **Importer** du concepteur ou téléchargé au format JSON. Les jalons entre crochets, comme `[MATIÈRE]` ou `[NOTION 1]`, sont ensuite à remplacer par le contenu de la discipline.

## Enrichissement avec une IA

Une fois le scénario pédagogique généré, il peut être exporté, notamment au format Markdown, puis transmis à Claude, ChatGPT, Gemini ou une autre IA afin de l'enrichir, de l'améliorer, de le compléter ou de l'adapter.

La page [Prompts pédagogiques](./prompts.php) propose actuellement :

- un prompt de révision d'un plan de cours basé sur la conception universelle de l'apprentissage (CUA), proposé par François Jourde ;
- un prompt d'enrichissement par la différenciation pédagogique, proposé par Yann Houry ;
- un prompt d'analyse et d'enrichissement selon le modèle SAMR ;
- un prompt d'analyse de la charge de travail et de planification dans le calendrier ;
- un prompt de génération d'une fiche d'activité destinée aux élèves.

Les quatre prompts d'analyse et d'adaptation sont disponibles en français et en anglais. Le bouton de copie utilise automatiquement la langue active de l'interface. Le prompt de génération d'une fiche élève est actuellement proposé en français.

## Installation locale

Le projet ne nécessite pas d'étape de compilation. PHP avec PDO SQLite suffit pour le lancer :

```bash
git clone https://github.com/YannHY/learning-designer.git
cd learning-designer
php -S localhost:8000
```

Ouvrez ensuite [http://localhost:8000](http://localhost:8000). La base SQLite locale et ses tables sont créées automatiquement. Pour activer les comptes, ouvrez `setup_admin.php` et créez le premier administrateur.

### Configuration d'un déploiement

La configuration peut être fournie par variables d'environnement ou à partir du gabarit [app-config.php](./app-config.php). Les principales variables reconnues sont :

- `APP_DB_DSN`, `APP_DB_USER` et `APP_DB_PASS` pour utiliser MySQL ou une autre base PDO ;
- `APP_DB_SQLITE_PATH` pour choisir l'emplacement de la base SQLite ;
- `APP_BASE_URL` pour définir l'URL publique de l'application ;
- `APP_MAIL_FROM` et `APP_MAIL_FROM_NAME` pour l'expéditeur des emails de vérification et de réinitialisation du mot de passe. L'envoi utilise la fonction `mail()` de PHP, qui doit être activée sur l'hébergement.

Conservez les secrets dans un fichier local non versionné, par exemple `learning-design-secret.php`, ou dans des variables d'environnement.

## Fichiers principaux

- [index.php](./index.php) : page d’accueil ;
- [designer.html](./designer.html) : interface de conception ;
- [css](./css) : feuilles de style de l’application ;
- [js](./js) : scripts JavaScript de l’application ;
- [interface.js](./js/interface.js) et [interface.css](./css/interface.css) : logique et styles principaux de l’interface de conception ;
- [help.php](./help.php) : documentation utilisateur ;
- [models.php](./models.php) : bibliothèque et API JSON des modèles de scénarios ;
- [prompts.php](./prompts.php) : bibliothèque de prompts pédagogiques ;
- [share.php](./share.php) : catalogue public des designs partagés ;
- [view.php](./view.php) : consultation en lecture seule d'un design publié ;
- [lib/bootstrap.php](./lib/bootstrap.php) : configuration, base de données et fonctions PHP communes ;
- [bin/learning](./bin/learning) : CLI de création et de publication.

## Crédits et licence

Développé par Yann Houry sur la base du travail de François Jourde et inspiré de l'UCL Learning Designer. Le projet est distribué sous licence [CC BY-SA](./LICENSE).
