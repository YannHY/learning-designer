# Aide — Interface de conception d'apprentissage

> Application web monopage inspirée de l'[UCL Learning Designer](https://www.ucl.ac.uk/learning-designer/).
> **Toutes les données restent dans votre navigateur** : rien n'est transmis en ligne.

---

## Vue d'ensemble

L'interface se compose de trois zones :

1. **Le panneau supérieur** (repliable) — paramètres, analyse et chronologie du design
2. **La barre d'outils** — actions principales (ajouter, enregistrer, importer, exporter…)
3. **Le tableau de séances** — cœur du design, organisé en cartes

---

## Panneau supérieur

Cliquez sur **Replier / Déplier le panneau** (en haut à droite du panneau) pour l'afficher ou le masquer.

Le panneau contient trois onglets.

### Onglet Paramètres

Renseignez ici les métadonnées globales de votre design :

| Champ | Rôle |
|---|---|
| **Titre** | Nom du design |
| **Temps d'apprentissage** | Durée totale visée (jours / heures / min) |
| **Temps conçu** | Calculé automatiquement à partir des activités |
| **1 jour =** | Nombre d'heures d'une journée (par défaut : 7 h) |
| **Description** | Présentation libre du design |
| **Commande institutionnelle** | Collez ici le cahier des charges existant |
| **Mode** | Présentiel, distanciel ou hybride |
| **Taille du groupe** | Effectif de la formation |
| **Concepteur(s) / Formateur(s)** | Noms des personnes concernées |
| **Personas** | Collez ici les profils d'apprenants déjà définis |
| **Curseurs** | Collez ici les paramètres de positionnement pédagogique |

Un **graphique circulaire** s'affiche en temps réel à droite, montrant la répartition des types d'apprentissage de l'ensemble du design.

### Onglet Analyse

Tableaux de bord automatiques avec des graphiques circulaires pour :

- la répartition des **types d'apprentissage**
- le **mode de diffusion** (présentiel / distanciel / hybride)
- la **présence du formateur**
- le **mode synchrone / asynchrone**
- le **type d'évaluation**
- la répartition par **mode de groupement**

Des alertes s'affichent si des déséquilibres pédagogiques sont détectés.

### Onglet Chronologie

Représentation visuelle en **partition musicale** : chaque séance est affichée sous forme d'une ligne temporelle proportionnelle à la durée des activités.

Cliquez sur **Configurer les lignes** pour choisir quelles modalités afficher (lieu, groupement, synchronicité, présence du formateur).

---

## Barre d'outils

### Côté gauche

| Bouton / contrôle | Action |
|---|---|
| **+ Ajouter un moment** | Crée une nouvelle séance |
| **Déplier les notes** | Affiche ou masque toutes les notes de séances et d'activités |
| Icônes de mise en page | Bascule entre **liste**, **colonnes** et **grille** |

### Côté droit

| Bouton / contrôle | Action |
|---|---|
| **Nouveau** | Crée un design vierge (efface le design en cours) |
| **Importer** | Importe un fichier JSON, CSV ou Excel (.xlsx) |
| **Enregistrer** | Sauvegarde manuelle dans le stockage local du navigateur |
| **Exporter** | Exporte le design dans le format de votre choix |
| **FR / EN** | Bascule la langue de l'interface |

> **Autosauvegarde locale** : le design est sauvegardé automatiquement toutes les 10 secondes. L'indicateur d'état confirme l'enregistrement.

---

## Formats d'export et d'import

**Export** : JSON · Markdown · Word · HTML · Excel

**Import** : JSON · CSV · Excel (.xlsx)

---

## Gérer les séances

Chaque **carte de séance** contient :

- un **titre** (champ texte en haut)
- les **objectifs** du moment
- les **choix pédagogiques** (justifications de l'ordre des activités, de l'alternance des modalités, etc.)
- une zone d'**activités**
- un **pied de carte** avec la durée totale et un bouton Notes

**Ajouter une séance** : bouton **+ Ajouter un moment** dans la barre d'outils.

**Supprimer une séance** : icône × en haut à droite de la carte.

**Réorganiser les séances** : glissez-déposez les cartes dans le tableau.

---

## Gérer les activités

Cliquez sur **+ Ajouter type d'apprentissage** en bas d'une séance pour ajouter une activité.

Chaque activité dispose d'une **barre d'outils** avec six paramètres :

| Paramètre | Options |
|---|---|
| **Type d'apprentissage** | Lire/Regarder/Écouter · Investiguer · Pratiquer · Produire · Discuter · Collaborer |
| **Durée** | Saisie en minutes (champ numérique) |
| **Groupement** | Groupe entier · Sous-groupes · Individuel |
| **Présence du formateur** | Présent · Absent |
| **Synchronicité** | Synchrone · Asynchrone |
| **Lieu** | Présentiel · Distanciel · Hybride |
| **Évaluation** | Aucune · Diagnostique · Formative · Sommative · Certificative |

Cliquez sur l'icône **🔧 Outils** pour associer à l'activité un ou plusieurs outils numériques (Moodle, H5P, etc.).

Le champ **description** (zone de texte) est extensible en plein écran via le bouton ⤢.

**Réorganiser les activités** : glissez-déposez les cartes d'activité au sein d'une séance ou d'une séance à une autre.

**Supprimer une activité** : icône × à droite de la barre d'outils de l'activité.

---

## Types d'apprentissage et leurs couleurs

| Couleur | Type |
|---|---|
| 🩵 Turquoise | Lire / Regarder / Écouter |
| 🩷 Saumon | Investiguer |
| 🪻 Mauve | Pratiquer |
| 🟢 Vert | Produire |
| 🔵 Bleu | Discuter |
| 🟡 Jaune | Collaborer |

---

## Catalogue d'outils numériques

L'interface propose un catalogue intégré couvrant notamment :

- **Moodle** : ressources (Fichier, Page, Livre, URL…) et activités (Forum, Devoir, Test, Leçon, Atelier, Base de données, Glossaire, Wiki, Sondage, Feedback…)
- **H5P** : Vidéo interactive, Présentation de cours, Scénario ramifié, et de nombreux autres types de contenus interactifs

---

## Raccourcis et astuces

- **Plein écran** : le bouton ⤢ en haut à droite d'un champ de texte l'ouvre en plein écran avec une barre d'outils Markdown.
- **Notes de séance** : cliquez sur le bouton **Notes** en bas d'une carte de séance pour afficher ou masquer le champ de notes.
- **Notes d'activité** : les notes d'activité sont masquées par défaut ; utilisez **Déplier les notes** dans la barre d'outils pour toutes les afficher.
- **Langue** : le sélecteur FR / EN en haut à droite bascule instantanément l'interface sans perte de données.

---

## À propos

Cette application s'inspire de l'UCL Learning Designer (UCL Knowledge Lab, 2013–2026).
Développée par François Jourde (2026) — licence CC BY-SA.
Code source : [github.com/jourde/learning-designer](https://github.com/jourde/learning-designer)
