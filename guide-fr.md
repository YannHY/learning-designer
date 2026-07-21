# Guide d'utilisation — Learning Designer

> Application web de scénarisation pédagogique inspirée de l'[UCL Learning Designer](https://www.ucl.ac.uk/learning-designer/).
> Le projet peut fonctionner en local dans le navigateur ou en mode connecté avec sauvegarde sur serveur.

---

## Vue d'ensemble

L'interface s'organise autour de trois zones :

1. **Le panneau supérieur** : paramètres, analyses et chronologie
2. **La barre d'actions** : création, import, export, sauvegarde, partage
3. **L'espace de conception** : moments, activités et notes

---

## Panneau supérieur

Le panneau supérieur peut être replié ou déplié.

Il contient trois onglets.

### Paramètres

Vous y renseignez les informations globales du design :

- **Titre**
- **Temps d'apprentissage** visé
- **Temps conçu** calculé automatiquement
- **1 jour =** nombre d'heures d'une journée pédagogique
- **Description**
- **Commande institutionnelle**
- **Mode** : présentiel, distanciel, hybride
- **Taille du groupe**
- **Concepteur(s)** et **Enseignant(s)**
- **Objectifs**
- **Acquis d'apprentissage**

Les acquis d'apprentissage peuvent être formulés à partir de la **taxonomie révisée de Bloom**, via un sélecteur de catégories et de verbes d'action.

### Analyse

L'onglet **Analyse** affiche plusieurs visualisations automatiques selon les données saisies :

- répartition des **types d'apprentissage**
- répartition par **modalité**
- répartition par **mode de groupement**
- présence ou absence de l’**enseignant**
- répartition **synchrone / asynchrone**
- répartition des **modes d'évaluation**

Des messages d'alerte peuvent apparaître si certaines données sont absentes ou incohérentes.

### Chronologie

L'onglet **Chronologie** représente les séances sous forme de lignes temporelles proportionnelles à la durée des activités.

Vous pouvez :

- afficher ou masquer certaines lignes
- changer leur ordre
- choisir quelles dimensions représenter

Cette vue sert à visualiser rapidement le rythme d'ensemble du scénario.

---

## Barre d'actions

### À gauche

- **+ Ajouter un moment** : crée une nouvelle séance
- **Déplier les notes** : affiche ou masque toutes les notes
- **Icônes de vue** : bascule entre **liste**, **colonnes** et **grille**

### À droite

- **Nouveau** : crée un design vierge
- **Importer** : importe un fichier pris en charge
- **Enregistrer** : sauvegarde le design
- **Exporter** : ouvre la fenêtre d'export
- **Partager** : publie un design et génère un lien public quand le backend est actif
- **FR / EN** : change la langue de l'interface
- **Thème** : bascule entre mode clair et sombre

### Sauvegarde

Deux logiques coexistent :

- une **persistance locale** dans le navigateur pour retrouver l'état en cours
- une **sauvegarde serveur** si vous êtes connecté à un compte

Autrement dit, l'application n'est plus limitée à un simple stockage local.

---

## Import et export

### Import

L'application peut importer :

- `JSON`
- `LDJ`
- `CSV`
- `XLSX`
- `Markdown`

Les imports `CSV`, `XLSX` et `Markdown` servent notamment à réhydrater des exports issus de l'application.

### Export

L'application peut exporter :

- `JSON`
- `Markdown`
- `HTML`

L'export ouvre aussi une fenêtre contenant le contenu exporté, ce qui permet de le copier même si le téléchargement est bloqué par le navigateur.

---

## Travailler avec les moments

Chaque **moment** contient :

- un **titre**
- des **objectifs**
- des **choix pédagogiques**
- une liste d'**activités**
- des **notes**

Vous pouvez :

- ajouter un moment
- le supprimer
- le déplacer par glisser-déposer

---

## Travailler avec les activités

Chaque activité comporte plusieurs paramètres :

- **Type d'apprentissage**
- **Durée**
- **Mode de groupement**
- **Présence de l’enseignant**
- **Synchronicité**
- **Modalité**
- **Évaluation**
- **Description**
- **Notes**

Les activités peuvent être :

- ajoutées à un moment
- déplacées dans le même moment ou vers un autre
- supprimées

Le champ **description** peut être ouvert en **plein écran**.  
Une petite barre d'outils Markdown est disponible pour certains champs texte.

---

## Compétences numériques

L'ancienne logique de sélection d'outils Moodle / H5P a été remplacée.

Chaque activité peut maintenant être associée à une ou plusieurs **compétences numériques** issues d'un référentiel structuré en trois domaines :

- **Acquérir**
- **Approfondir**
- **Créer**

### Comment cela fonctionne

1. Cliquez sur l'icône de compétence de l'activité.
2. Choisissez un domaine.
3. Recherchez ou sélectionnez une compétence.

### Affichage

- les compétences sont repérées par un code court, par exemple `A1`, `P7`, `C14`
- les tags affichés dans l'activité montrent uniquement ce code
- la couleur du tag dépend du domaine
- une **infobulle au survol** donne le détail de la compétence

---

## Types d'apprentissage

Les activités peuvent être classées dans les catégories suivantes :

- **Lire / Regarder / Écouter**
- **Investiguer**
- **Pratiquer**
- **Produire**
- **Discuter**
- **Collaborer**
- **Non défini**

Ces catégories alimentent les graphiques d'analyse et la coloration de certaines vues.

---

## Vues disponibles

### Vue liste

Affichage vertical classique des moments et activités.

### Vue colonnes

Affichage en colonnes pour comparer plus facilement plusieurs moments côte à côte.

### Vue grille

Affichage tabulaire synthétique des activités et de leurs paramètres.

---

## Comptes, sauvegardes et partage

Quand le backend PHP/MySQL est actif, vous pouvez :

- créer un compte
- vous connecter
- sauvegarder plusieurs productions
- retrouver vos designs dans votre espace
- publier un design via un lien partageable
- consulter une version publiée en lecture seule

Des pages dédiées existent aussi pour :

- le **profil**
- la **liste des designs**
- l'**administration**

---

## Conseils pratiques

- utilisez les **objectifs** et **choix pédagogiques** pour documenter les intentions de chaque moment
- complétez les paramètres d'activité le plus tôt possible pour obtenir des analyses utiles
- servez-vous de la **chronologie** pour vérifier l'alternance des modalités
- utilisez les **compétences numériques** comme repères explicites de progression
- basculez en **plein écran** pour rédiger les contenus longs plus confortablement

---

## À propos

Learning Designer est inspiré de l'UCL Learning Designer et a évolué vers une application web plus complète, avec :

- scénarisation pédagogique
- analyses visuelles
- compétences numériques
- sauvegarde par compte
- partage public de designs

Code source : [https://github.com/YannHY/learning-designer](https://github.com/YannHY/learning-designer)
