# Importer un design en Markdown

Cette aide explique comment importer dans Learning Designer un fichier Markdown compatible avec l'application.

Le plus simple est de partir d'un fichier Markdown exporte depuis Learning Designer, puis de le modifier en gardant la meme structure.

## Structure attendue

Un fichier Markdown importable doit contenir ces grandes parties :

```markdown
# Titre du design

## Paramètres

- Mode: Hybride
- Taille du groupe: 24
- Concepteur(s): Nom
- Enseignant(s): Nom
- Temps d'apprentissage: 1 j 2 h 30 min
- Temps conçu: 0 j 1 h 30 min
- 1 jour = 7 heures

### Description
Description generale du design.

### Commande institutionnelle
Contexte ou demande de depart.

### Objectifs
Objectifs generaux de la formation.

### Acquis d'apprentissage
- Comparer : comparer deux solutions

## Séances

## 1. Premiere seance
> Objectifs:
> Objectifs de la seance
> Choix pédagogiques:
> Intentions pedagogiques
> Notes:
> Notes de la seance

### 1.1 Investiguer
- Durée: 30 min
- Groupe: Sous-groupes
- Enseignant: Présent
- Rythme: Synchrone
- Modalité: Présentiel
- Évaluation: Formative
- Description: Description de l'activite
- Liens: Exemple (https://example.com)
- Compétences: A6 - Exemple de competence
```

## Regles importantes

Conservez les titres `## Paramètres` et `## Séances`. Ils servent a reconnaitre le fichier.

Chaque seance doit commencer par un titre de ce type :

```markdown
## 1. Titre de la seance
```

Chaque activite doit commencer par un titre de ce type :

```markdown
### 1.1 Type d'activite
```

Les types d'activite reconnus sont :

- `Non défini`
- `Lire / Regarder / Écouter`
- `Investiguer`
- `Pratiquer`
- `Produire`
- `Discuter`
- `Collaborer`

## Valeurs reconnues

Pour les champs des activites, utilisez de preference les valeurs affichees par l'application.

Groupes :

- `Groupe entier`
- `Sous-groupes`
- `Individuel`

Presence enseignante :

- `Présent`
- `Absent`

Rythme :

- `Synchrone`
- `Asynchrone`

Modalite :

- `Présentiel`
- `Distanciel`
- `Hybride`

Evaluation :

- `Aucune`
- `Diagnostique`
- `Formative`
- `Sommative`
- `Certificative`

## Ce qui peut etre modifie

Vous pouvez modifier directement :

- le titre du design
- les parametres
- la description
- la commande institutionnelle
- les objectifs
- les acquis d'apprentissage
- les titres de seances
- les objectifs, intentions et notes de seances
- les activites et leurs champs

## Ce qu'il vaut mieux eviter

Evitez de changer les libelles fixes comme :

- `## Paramètres`
- `## Séances`
- `- Durée:`
- `- Groupe:`
- `- Enseignant:`
- `- Rythme:`
- `- Modalité:`
- `- Évaluation:`
- `- Description:`

Si ces libelles changent trop, Learning Designer risque de ne plus reconnaitre certaines informations.

## Import dans le site

1. Ouvrir Learning Designer.
2. Cliquer sur `Importer`.
3. Choisir un fichier `.md` ou `.markdown`.
4. Verifier le design importe dans l'interface.

Si l'import echoue, exportez un design Markdown depuis Learning Designer et comparez la structure avec votre fichier.
