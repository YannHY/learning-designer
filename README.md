# Learning Designer

Application web de scénarisation pédagogique inspirée de l'[UCL Learning Designer](https://www.ucl.ac.uk/learning-designer/) et basée sur le travail de [François Jourde](https://github.com/jourde/learning-designer-revised).

Elle permet de structurer une séquence en moments et activités, d'en analyser l'équilibre, puis de la sauvegarder, l'exporter ou la partager. Les designs peuvent aussi être créés et publiés avec une IA grâce au CLI `learning`.

## Documentation

- [Aide complète](./help.php) : prise en main, activités, analyses, sauvegarde, partage, import/export, Markdown, IA et CLI
- [Comprendre le learning design](./learning-design.php) : principes et cadre pédagogique
- [Référence du CLI](./cli-reference.php) : commandes du CLI `learning`

## Fonctionnalités

- conception de moments, d'activités et d'acquis d'apprentissage reliés à la taxonomie de Bloom ;
- six types d'apprentissage, compétences numériques et paramètres pédagogiques détaillés ;
- vues liste, colonnes et grille, graphiques d'analyse et chronologie ;
- import et export en plusieurs formats, dont JSON, LDJ, Markdown, Excel et Word ;
- comptes, sauvegarde en ligne et publication par lien ;
- interface bilingue français/anglais et thèmes clair/sombre ;
- création, validation et publication depuis le terminal avec le CLI `learning`.

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
- `APP_BASE_URL` pour définir l'URL publique de l'application.

Conservez les secrets dans un fichier local non versionné, par exemple `learning-design-secret.php`, ou dans des variables d'environnement.

## Fichiers principaux

- [index.html](./index.html) : interface de conception ;
- [interface.js](./interface.js) et [interface.css](./interface.css) : logique et styles de l'application ;
- [help.php](./help.php) : documentation utilisateur ;
- [lib/bootstrap.php](./lib/bootstrap.php) : configuration, base de données et fonctions PHP communes ;
- [bin/learning](./bin/learning) : CLI de création et de publication.

## Crédits et licence

Développé par Yann Houry sur la base du travail de François Jourde et inspiré de l'UCL Learning Designer. Le projet est distribué sous licence [CC BY-SA](./LICENSE).
