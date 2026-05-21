# Learning Designer

Application web de scénarisation pédagogique inspirée de l'[UCL Learning Designer](https://www.ucl.ac.uk/learning-designer/) (UCL Knowledge Lab, UCL Institute of Education, 2013–2026) et basé sur le travail de [François Jourde](https://github.com/jourde/learning-designer-revised).

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

Les activités peuvent être liées à un référentiel de compétences numériques structuré en trois domaines :

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

## CLI `learning`

Le projet fournit aussi un CLI bilingue FR/EN pour préparer un design depuis le terminal, puis le confier à Codex ou Claude Code.

Installation en une commande :

```bash
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/install.sh | sh
```

Le script ouvre un court dialogue d'installation : il vérifie les prérequis, propose un dossier déjà disponible dans le `PATH` (`/usr/local/bin`, `/opt/homebrew/bin` ou équivalent), puis installe `learning` afin que la commande soit utilisable immédiatement, sans modifier le profil shell.

Utilisation rapide :

```bash
learning init design.json --title "Atelier IA" --lang fr --duration 120 --mode hybride --group-size 24
learning add-moment design.json --title "Explorer" --objectives "Identifier les usages possibles"
learning add-activity design.json --type investigate --duration 30 --group sous-groupes --teacher present --pacing sync --mode onsite --evaluation formative --competencies A6,P34 --description "Comparer trois exemples d'usages de l'IA."
learning outcome design.json --bloom analyser --verb "Comparer" --text "Comparer des réponses générées par IA selon leur fiabilité."
learning prompt design.json
learning handoff design.json --dry-run
```

Commandes disponibles : `init`/`nouveau`, `add-moment`/`ajouter-moment`, `add-activity`/`ajouter-activite`, `outcome`/`acquis`, `prompt`/`codex-prompt`, `handoff`/`confier-codex`/`codex`, `validate`/`verifier`, `list`/`lister`.

Les activités acceptent les paramètres principaux de Learning Designer : type d'apprentissage, durée, groupe, présence enseignante, rythme, modalité, évaluation, description, notes, liens et compétences numériques (`A1`, `P6`, `C14` ou identifiants complets `competency:...`). Les acquis d'apprentissage peuvent être reliés à la taxonomie de Bloom en français ou en anglais.

### Publication en ligne

Pour publier un fichier JSON depuis le CLI vers une instance Learning Designer :

1. Se connecter au site, ouvrir le profil, puis créer un jeton dans la section `Publication depuis le CLI`.
2. Enregistrer le jeton localement :

```bash
learning login
```

3. Coller le jeton quand le CLI le demande, puis publier :

```bash
learning publish design.json
```

La commande renvoie l'URL publique du design publié. Pour mettre à jour une publication existante, utilisez l'identifiant renvoyé par la première publication :

```bash
learning publish design.json --design-id 123
```

Commandes utiles :

```bash
learning status
learning upgrade
```

## État actuel

Le projet est aujourd'hui à la fois :

- un outil de conception pédagogique
- un espace personnel de sauvegarde de scénarios
- un outil de publication et de consultation de designs partagés

Le `README` doit donc être lu comme celui d'une application web complète, et non plus comme celui d'un simple prototype front-end.

## Crédits

- Inspiré de l'UCL Learning Designer
- Développé par Yann Houry sur la base du travail de François Jourde
- Licence : CC BY-SA