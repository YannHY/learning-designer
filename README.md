# Learning Designer

Learning Designer est une application libre pour concevoir, analyser et partager des scénarios pédagogiques.

Elle aide à passer d'une intention pédagogique à une séquence exploitable : organiser les étapes, préciser les activités et les consignes, formuler les acquis d'apprentissage, estimer les durées et vérifier l'équilibre des modalités proposées aux élèves.

Le projet est inspiré de l'[UCL Learning Designer](https://www.ucl.ac.uk/learning-designer/) et s'appuie sur le travail de [François Jourde](https://github.com/jourde/learning-designer-revised).

## Ce que Learning Designer apporte

- **Concevoir avec un cadre pédagogique commun** : chaque scénario est structuré en moments et activités, reliés à des types d'apprentissage, des modalités, des compétences numériques, des niveaux AIAS et des acquis issus de la taxonomie de Bloom.
- **Partir d'un modèle plutôt que d'une page blanche** : 28 scénarios génériques, répartis en huit familles, sont prêts à être adaptés à une discipline et à un contexte.
- **Relire un scénario sous plusieurs angles** : la répartition du temps et des types d'apprentissage aide à repérer les déséquilibres, les enchaînements trop denses ou les modalités trop peu variées.
- **Partager et réutiliser les productions** : un design peut être sauvegardé dans un compte, publié par lien, consulté en lecture seule et proposé dans le catalogue public sous licence Creative Commons.
- **Travailler avec les outils déjà utilisés** : les imports et exports permettent de poursuivre le travail dans un tableur, un traitement de texte, une plateforme web ou un autre outil compatible.
- **Concevoir avec une IA sans perdre la structure pédagogique** : une Skill réutilisable, une bibliothèque de prompts et le CLI `learning` accompagnent la création, la validation et la publication des scénarios.

## Documentation

- [Aide complète](./help.php) : prise en main, conception, sauvegarde, partage et import/export
- [Créer avec une IA, la Skill et le CLI](./help.php#cli) : trois manières d'utiliser un agent pour produire un scénario structuré
- [Skill Learning Designer](./skills/learning-designer/SKILL.md) : méthode réutilisable par un agent compatible
- [Modèles de scénarios](./models.php) : bibliothèque de scénarios génériques préremplis
- [Bibliothèque de prompts](./prompts.php) : prompts prêts à copier pour analyser, adapter ou prolonger un scénario
- [Comprendre le learning design](./learning-design.php) : principes et cadre pédagogique

## Concevoir avec une IA

Learning Designer propose trois niveaux d'intégration, selon le besoin :

1. **Les prompts** servent à enrichir ponctuellement un scénario : différenciation, conception universelle de l'apprentissage, modèle SAMR, charge de travail ou création d'une fiche destinée aux élèves.
2. **La Skill Learning Designer** donne à un agent une méthode de travail complète : recueillir les choix pédagogiques, construire le scénario avec le CLI, le valider, puis préparer sa publication.
3. **Le CLI `learning`** permet de créer et modifier un design depuis le terminal, de contrôler sa structure, de transmettre le travail à Codex et de le publier ou le mettre à jour sur le site.

La Skill ne se contente donc pas de générer du texte libre : elle guide l'agent vers le format attendu par l'application et impose une validation avant publication.

### Installer le CLI

```bash
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/install.sh | sh
learning status
```

Quelques commandes utiles :

```bash
learning init mon-scenario.json
learning add-moment mon-scenario.json --title "Découvrir"
learning validate mon-scenario.json
learning handoff mon-scenario.json
learning login
learning publish mon-scenario.json
```

Les instructions d'installation et d'utilisation de la Skill sont détaillées dans la section [Créer avec l'IA](./help.php#cli) de l'aide.

## Modèles de scénarios

La page [Modèles de scénarios](./models.php) regroupe des structures pour entrer dans un apprentissage, comprendre, argumenter, s'entraîner, produire, évaluer, organiser une séquence ou travailler avec l'IA.

Chaque modèle contient déjà des moments, des activités, des durées, des modalités, des acquis et des consignes. Il peut être chargé directement dans le concepteur ou téléchargé au format JSON. Les jalons entre crochets, comme `[MATIÈRE]` ou `[NOTION 1]`, indiquent les éléments à contextualiser.

## Importer, exporter et publier

Learning Designer accepte les scénarios issus de son ancien format LDJ ainsi que des fichiers JSON, CSV, Excel et Markdown.

Un scénario peut être exporté en Markdown, HTML, JSON, Excel ou Word. L'export peut produire une version enseignant ou élève et se limiter aux moments sélectionnés. La publication en ligne crée une page de consultation partageable ; les auteurs qui le souhaitent peuvent également rendre leur design visible dans le catalogue public.

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

## Repères dans le dépôt

- [designer.html](./designer.html) et [interface.js](./js/interface.js) : concepteur de scénarios ;
- [models.php](./models.php) : bibliothèque et API JSON des modèles ;
- [prompts.php](./prompts.php) : bibliothèque de prompts pédagogiques ;
- [share.php](./share.php) et [view.php](./view.php) : catalogue public et consultation des designs publiés ;
- [skills/learning-designer](./skills/learning-designer) : Skill et configuration de l'agent ;
- [bin/learning](./bin/learning) : CLI de création, de validation et de publication ;
- [lib/bootstrap.php](./lib/bootstrap.php) : configuration, base de données et fonctions PHP communes.

## Crédits et licence

Développé par Yann Houry sur la base du travail de François Jourde et inspiré de l'UCL Learning Designer. Le projet est distribué sous licence [CC BY-SA](./LICENSE).
