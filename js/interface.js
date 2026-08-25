(() => {
"use strict";
/* Keep in sync with the --read…--collaborate tokens in css/interface.css and with
   $LEARNING_TYPES in view.php. Duplicated because exports and canvas work
   need literal values, not computed styles. */
const LEARNING_TYPES = [
  { id: "undefined", label: "Non défini", color: "#d1d5db" },
  { id: "read", label: "Lire / Regarder / Écouter", color: "#5bddd3" },
  { id: "investigate", label: "Investiguer", color: "#f19492" },
  { id: "practice", label: "Pratiquer", color: "#c498ec" },
  { id: "produce", label: "Produire", color: "#a2d681" },
  { id: "discuss", label: "Discuter", color: "#85b6f0" },
  { id: "collaborate", label: "Collaborer", color: "#e7b959" }
];

const fontAwesomeIcon = (classes) => `<i class="${classes}" aria-hidden="true"></i>`;

const ICONS = {
  undefined: fontAwesomeIcon("fa-regular fa-circle"),
  read: fontAwesomeIcon("fa-solid fa-book-open"),
  investigate: fontAwesomeIcon("fa-solid fa-magnifying-glass"),
  practice: fontAwesomeIcon("fa-solid fa-dumbbell"),
  produce: fontAwesomeIcon("fa-solid fa-pen-ruler"),
  discuss: fontAwesomeIcon("fa-solid fa-comments"),
  collaborate: fontAwesomeIcon("fa-solid fa-users"),
  whole: fontAwesomeIcon("fa-solid fa-users"),
  subgroups: fontAwesomeIcon("fa-solid fa-user-group"),
  individual: fontAwesomeIcon("fa-solid fa-user"),
  present: fontAwesomeIcon("fa-solid fa-user-check"),
  absent: fontAwesomeIcon("fa-solid fa-user-slash"),
  sync: fontAwesomeIcon("fa-regular fa-clock"),
  async: fontAwesomeIcon("fa-regular fa-calendar-days"),
  onsite: fontAwesomeIcon("fa-solid fa-school"),
  online: fontAwesomeIcon("fa-solid fa-desktop"),
  hybrid: fontAwesomeIcon("fa-solid fa-shuffle"),
  none: fontAwesomeIcon("fa-regular fa-circle"),
  diagnostic: fontAwesomeIcon("fa-solid fa-magnifying-glass"),
  formative: fontAwesomeIcon("fa-solid fa-pen-to-square"),
  summative: fontAwesomeIcon("fa-solid fa-graduation-cap"),
  certificative: fontAwesomeIcon("fa-solid fa-certificate")
};

const ACTIVITY_TYPE_OPTIONS = LEARNING_TYPES.map((type) => ({
  value: type.id,
  label: type.label,
  short: type.label.split(" ")[0],
  icon: ICONS[type.id]
}));
const GROUP_MODE_OPTIONS = [
  { value: "whole", label: "Groupe entier", short: "Entier", icon: ICONS.whole },
  { value: "subgroups", label: "Sous-groupes", short: "Sous-g.", icon: ICONS.subgroups },
  { value: "individual", label: "Individuel", short: "Indiv.", icon: ICONS.individual }
];
const TRAINER_OPTIONS = [
  { value: "present", label: "Présent", short: "Présent", icon: ICONS.present },
  { value: "absent", label: "Absent", short: "Absent", icon: ICONS.absent }
];
const SYNC_OPTIONS = [
  { value: "sync", label: "Synchrone", short: "Sync", icon: ICONS.sync },
  { value: "async", label: "Asynchrone", short: "Async", icon: ICONS.async }
];
const LOCATION_OPTIONS = [
  { value: "onsite", label: "Présentiel", short: "Prés.", icon: ICONS.onsite },
  { value: "online", label: "Distanciel", short: "Dist.", icon: ICONS.online },
  { value: "hybrid", label: "Hybride", short: "Hybrid.", icon: ICONS.hybrid }
];
const PARTITION_TYPE_OPTIONS = [
  { type: "locationMode",    labelKey: "partitionTypeLocation", options: LOCATION_OPTIONS },
  { type: "groupMode",       labelKey: "partitionTypeGroup",    options: GROUP_MODE_OPTIONS },
  { type: "syncMode",        labelKey: "partitionTypeSync",     options: SYNC_OPTIONS },
  { type: "teacherPresence", labelKey: "partitionTypePresence", options: TRAINER_OPTIONS },
];
const EVAL_OPTIONS = [
  { value: "none", label: "Aucune", short: "Aucune", icon: ICONS.none },
  { value: "diagnostic", label: "Diagnostique", short: "Diag.", icon: ICONS.diagnostic },
  { value: "formative", label: "Formative", short: "Form.", icon: ICONS.formative },
  { value: "summative", label: "Sommative", short: "Somm.", icon: ICONS.summative },
  { value: "certificative", label: "Certificative", short: "Certif.", icon: ICONS.certificative }
];

const AIAS_VERSION = "2.1";
const AIAS_LEVELS = [
  { level: 1, labelKey: "aiasLevel1Label", descriptionKey: "aiasLevel1Description" },
  { level: 2, labelKey: "aiasLevel2Label", descriptionKey: "aiasLevel2Description" },
  { level: 3, labelKey: "aiasLevel3Label", descriptionKey: "aiasLevel3Description" },
  { level: 4, labelKey: "aiasLevel4Label", descriptionKey: "aiasLevel4Description" },
  { level: 5, labelKey: "aiasLevel5Label", descriptionKey: "aiasLevel5Description" }
];
const AIAS_TRIGGER_ICON = "fa-wand-magic-sparkles";

function normalizeCatalogSlug(value) {
  return String(value ?? "")
    .trim()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-+|-+$/g, "") || "general";
}

const COMPETENCY_CATALOG_SOURCE = String.raw`# acquerir	Acquérir	Acquire
Utilisation de l'iPad		1	Verrouiller et déverrouiller l'iPad	Garder l'iPad dans son cartable tant que l'enseignant ne recquiert pas son utilisation | Mettre en veille la tablette quand on a terminé
Utilisation de l'iPad		2	Connaître et protéger ses identifiants	Connaître ses principaux identifiants | Protéger son mot de passe et ses données avec Touch ID | Activer l'enregistrement des mots de passe dans les réglages | Utiliser le gestionnaire de mots de passe
Utilisation de l'iPad		3	Connaître les principaux gestes multitâches	Passer d'une application à une autre avec les quatre doigts | Revenir sur l'écran d'accueil avec les quatre doigts | Annuler ou rétablir une action à l'aide de trois doigts | Faire l'équivalent d'un clic droit avec deux doigts ou d'un simple clic en appuyant sur la touche contrôle
Utilisation de l'iPad		4	Taper efficacement et rapidement	Développer sa maîtrise de la dactylographie avec Taptouche (taper au moins 40 mots par minute) | Utiliser les prédictions de texte | Créer des raccourcis
Utilisation de l'iPad		5	Prendre soin du matériel et savoir régler des problèmes de base	Ranger son iPad dans son cartable | Placer son cartable dans un endroit sûr | Nettoyer régulièrement sa tablette | Charger la batterie de l’iPad régulièrement pour limiter sa détérioration | Redémarrer son iPad en cas de blocage (bug)
Productivité et organisation	Safari	6	Faire une recherche avec Safari	Utiliser un moteur de recherche pour trouver des informations
Productivité et organisation		7	Connaître les sites essentiels	Utiliser les sites les plus courants (Pronote, site de l'Institut, dictionnaires en ligne, Geogebra, Quizlet…) | Consulter ses notes ainsi que le cahier de textes sur Pronote | Voir son emploi du temps sur Pronote
Productivité et organisation		8	Retrouver aisément et rapidement les sites les plus utilisés	Créer un marque-page, un favori ou une icône sur l'écran d'accueil pour retrouver facilement les sites dont on a besoin
Productivité et organisation		9	Lire sur l'iPad	Lire sur l'iPad en supprimant éventuellement les publicités | Lire sans distraction sur l'iPad en recourant au mode lecteur | Exporter une page web au format PDF pour souligner ou annoter des passages importants
Productivité et organisation	OneNote, Teams & OneDrive	10	Consulter ses cours sur OneNote	Trouver le « notebook » de la classe pour chaque matière | Consulter régulièrement l'application pour lire les documents et les corrections
Productivité et organisation		11	Trouver ou rendre un devoir sur Teams	Trouver un devoir sur Teams et savoir remettre son travail sur Teams (en sachant chercher sur son iPad ou sur Office 365 le travail effectué)
Productivité et organisation		12	Sauvegarder, organiser et retrouver des documents sur l'iPad ou OneDrive	Enregistrer ses documents dans le répertoire approprié (rangement par matière) | Nommer ses documents de façon à les retrouver facilement | Connaître la fonction d'historique d'un fichier permettant de retrouver un état antérieur d'un document
Productivité et organisation		13	Prendre des notes soit au clavier soit avec un stylet	Utiliser les applications permettant d'écrire ou de prendre des notes (OneNote, Notability, Word…) | Ajouter une section ou une page dans son carnet personnel (OneNote)
Communication et collaboration	Partager	14	Partager des documents avec ses enseignants ou d'autres élèves	Savoir partager via mail, Teams ou OneNote ses documents pour travailler à plusieurs ou simplement communiquer un travail
Communication et collaboration		15	Savoir travailler sur des documents en temps réel avec d’autres élèves	Inviter un élève ou un enseignant à collaborer | Collaborer et respecter le travail de chacun | Utiliser les commentaires pour suggérer des modifications
Communication et collaboration		16	Partager des documents avec les bons niveaux d’accès	Transmettre un document en attribuant les droits voulus (lecture, commentaire, édition)
Communication et collaboration		17	Joindre la personne à laquelle on souhaite s'adresser	Poser des questions ou répondre de manière claire et utile à son enseignant ou à d’autres élèves via Teams, en notifiant son correspondant (signe arobase suivi du nom)
Communication et collaboration		18	Réaliser une présentation pour faire un exposé en classe	Connaître les fonctions essentielles d'un logiciel de présentation (PowerPoint, Genially ou Canva…)
Communication et collaboration	Écrire des emails	19	Écrire un email	Structurer un email correctement, en incluant l'objet, une salutation appropriée, des formules de politesse, une signature.
Communication et collaboration		20	Inclure une pièce jointe	Joindre des fichiers à un email en s’assurant que les pièces jointes sont correctement nommées et ne dépassent pas la taille limite.
Communication et collaboration		21	Savoir répondre en fonction des situations	Répondre aux emails de manière appropriée (« Répondre à tous » si nécessaire uniquement, faire preuve de politesse et suivre les règles de communication).
Communication et collaboration		22	Envoyer un email	Envoyer un courrier avec le client mail Outlook (y compris transférer)
Créativité et expression		23	Connaître sommairement les applications courantes de bureautique	Connaître les principales fonctions du traitement de texte Word, du logiciel de présentation PowerPoint et du tableur Excel
Créativité et expression		24	Identifier l’application à utiliser pour la tâche correspondante	Savoir que Word permet d'écrire du texte, PowerPoint de faire une présentation…
Créativité et expression		25	Connaître les principales règles de formatage d’un texte	Connaître les principales possibilités de mise en forme du texte (mettre du texte en gras ou en italique, aligner un texte, etc.
Créativité et expression		26	Utiliser iMovie pour créer de courtes vidéos.	Être capable d'enregistrer un petit film | Faire quelques modifications (couper un passage, insérer un titre…)
Créativité et expression		27	Utiliser des applications comme Dictaphone ou GarageBand	Être en mesure d'effectuer un enregistrement (une lecture à voix haute, une récitation, un podcast ou un livre audio…)
Créativité et expression		28	Dessiner ou faire des croquis, des schémas….	Utiliser des applications comme Procreate ou FreeForm | Utiliser une application pour réaliser une carte mentale
Créativité et expression		29	Comprendre la notion de droit	Comprendre ce qu'on entend par droit d’auteur, droit d’image et images libres de droits | Définir ce qu'est la propriété intellectuelle
Créativité et expression		30	Citer ses sources, être attentif au droit d'image, droit d'auteur, utiliser des images libres de droits	Faire preuve d'honnêteté et donner la provenance des informations que l'on procure | Prendre conscience de ce qu'est le plagiat
# approfondir	Approfondir	Deepen
Utilisation de l'iPad		1	Personnaliser son environnement de travail	Créer et gérer des dossiers d'applications | Utiliser le mode concentration pour éviter les distractions | Éventuellement, couper, limiter ou sélectionner les notifications
Utilisation de l'iPad		2	Connaître et protéger ses identifiants	Activer l'authentification à deux facteurs quand cela est possible | Connaître les principaux paramètres de confidentialité (géolocalisation, accès aux données personnelles, utilisation des cookies…)
Utilisation de l'iPad		3	Maîtriser les gestes multitâches avancés	Connaître tous les gestes multitâches | Afficher deux applications à la fois grâce Split View et Slide Over | Glisser et déposer un ou plusieurs fichiers à la fois entre des applications | Utiliser Spotlight pour trouver une information ou ouvrir une application
Utilisation de l'iPad		4	Taper efficacement et rapidement	Atteindre une vitesse de frappe de 60 mots par minute | Utiliser les fonctionnalités de dictée vocale
Utilisation de l'iPad		5	Prendre soin du matériel et savoir régler des problèmes de base	Effectuer régulièrement des sauvegardes de ses données importantes | S'assurer que l'espace de stockage de l'iPad n'est pas saturé
Productivité et organisation	Safari	6	Faire une recherche avec Safari	Utiliser différents moteurs de recherche en fonction de ses besoins | Posséder quelques notions présidant au classement des résultats de recherche | Utiliser des opérateurs de recherche avancés | Évaluer la pertinence et la fiabilité des sources (faire la différence entre publicité, contenu sponsorisé ; identifier une information fiable)
Productivité et organisation		7	Organiser une veille informationnelle	Exploiter des flux RSS ou s'abonner à des newsletters pertinentes | Connaître des ressources fiables et être capable d'identifer des ressources dignes de confiance (identifier fake news et désinformation)
Productivité et organisation		8	Retrouver aisément et rapidement les sites les plus utilisés	Organiser ses favoris et ses ressources numériques
Productivité et organisation		9	Lire sur l'iPad	Lire et utiliser les fonctions offertes par l'ePub (annotations, dictionnaire intégré…)
Productivité et organisation	OneNote, Teams & OneDrive	10	Consulter ses cours sur OneNote	Utiliser le lecteur immersif pour faciliter la lecture | Ajouter une section ou une page
Productivité et organisation		11	Trouver ou rendre un devoir sur Teams	Utiliser les fonctions plus avancées de Teams (Calendrier, Réunion instantanée…) | Trouver et retrouver les devoirs passés ou en retard
Productivité et organisation		12	Sauvegarder et organiser et retrouver des documents sur l'iPad ou OneDrive	Dans l'application Fichiers, utiliser les tags pour repérer plus rapidement les fichiers importants | Utiliser les différents modes de vue (icônes, liste, colonnes…) | D'un appui long sur un fichier, connaître les principales fonctions (Lire les informations, Compresser, Dupliquer, Partager…)
Productivité et organisation		13	Prendre des notes soit au clavier soit avec un stylet	Structurer ses notes | Utiliser des codes couleurs | Insérer des images ou des enregistrements | Connaître l'étendue des outils (lasso, insertion de formes, utilisation de l'IA...) | Connaître d'autres applications de prises de notes comme Notes d'Apple ou Notability
Communication et collaboration	Partager	14	Partager des documents avec ses enseignants ou d'autres élèves	Au cas où un travail partagé aurait été altéré et des passages supprimés, savoir retrouver l'historique du fichier | Identifier qui est responsable de quelle modification
Communication et collaboration		15	Savoir travailler sur des documents en temps réel avec d’autres élèves	Définir des accès qui évoluent (lecture puis écriture) | Proposer plusieurs versions selon l'état du document (brouillon, révision, final) | Restreindre l'édition de certaines parties spécifiques d'un document
Communication et collaboration	Écrire des emails	16	Créer des favoris dans Outlook	Créer des favoris pour retrouver plus rapidement les destinataires les plus fréquents
Communication et collaboration		17	Créer des règles dans Outlook	Créer des règles permettant de retrouver plus facilement ses emails
Communication et collaboration		18	Créer une signature dans Outlook	Dans les réglages d'Outlook, insérer une signature automatiquement à la fin de son email
Communication et collaboration		19	S'organiser	Insérer des événements dans le calendrier avec des dates butoirs afin de ne pas oublier certaines tâches à réaliser | Inviter un ou une élève à participer à un événement lorsque l'on travaille sur un projet à plusieurs | Sauvegarder un email important dans OneNote
Données et programmation	Excel & calcul	20	Collecter des données simples	Collecter des données à l'aide d'un formulaire conçu avec Microsoft Forms | Créer un petit tableau de bord pour analyser des résultats (ses notes par exemple) ou pour rassembler des informations (par exemple, des dates sur un événement ou une bibliographie)
Données et programmation		21	Organiser et représenter visuellement des données	Utiliser le formatage conditionnel | Insérer un graphique simple (du type camembert ou barres)
Données et programmation		22	Procéder à des calculs simples	Connaître des formules simples comme calculer une moyenne ou compter des données
Données et programmation		23	Formater les données	Appliquer quelques règles de formatage simples pour rendre lisibles le tableur
Données et programmation		24	Utiliser la calculette	Savoir faire des calculs courants | Basculer de la calculette élémentaire à la calculette scientifique | Savoir faire des conversions | Résoudre des équations ou tracer des graphiques grâce à Notes mathématiques
Données et programmation	Scratch	25	Se familiariser avec l'interface	Savoir naviguer dans l’interface, ajouter des sprites, des arrière-plans et des blocs de code
Données et programmation		26	Comprendre la notion de bloc	Combiner les différents types de blocs pour créer des animations, des jeux simples, ou des histoires interactives.
Données et programmation		27	Connaître les bases de la programmation	Utiliser des instructions conditionnelles comme « si… alors » | Comprendre comment utiliser les boucles pour répéter une série d’instructions plusieurs fois | Comprendre le concept de variables pour stocker et manipuler des données
Créativité et expression		28	Connaître sommairement les applications courantes de bureautique	En plus de la suite Office 365 (Word, PowerPoint…), connaître les équivalents d'Apple et leurs particularités (Pages, Keynote…)
Créativité et expression		29	Créer des documents multimédias enrichis	Avec Canva, créer des documents riches incluant différents types de médias (texte, image, son…) | Les présenter oralement sans regarder ses notes en respectant un temps imparti
Créativité et expression		30	Traiter et modifier des images	Recadrer, redimensionner et ajuster les paramètres de base d'une image (luminosité, contraste…) | Appliquer des filtres et des effets simples
Créativité et expression		31	Utiliser iMovie pour faire du montage vidéo	Procéder à la réalisation de films plus longs et plus travaillés (insertion de titres ou de transitions) | Connaître les différents formats vidéos, savoir comment les compresser ou les partager notamment grâce à Microsoft Stream
Créativité et expression		32	Utiliser des applications comme Dictaphone ou GarageBand	Enregistrer et éditer un contenu audio | Partager ses productions, les accompagner d'une image ou d'une description en vue d'une publication
Créativité et expression		33	Dessiner ou faire des croquis, des schémas….	Perfectionner sa maîtrise de Procreate | Utiliser Notes et savoir insérer un graphique ainsi que les possibilités de calcul | Utiliser des applications de création de cartes mentales (comme Whimsical)
Créativité et expression		34	Utiliser l'intelligence artificielle	Poser des questions pertinentes dans un chatbot | Mesurer la pertinence des réponses apportées | Discerner biais, stéréotypes et autres hallucinations
Créativité et expression		35	Utiliser des IA multimodales	Utiliser l'IA pour générer du texte, des images ou des compositions musicales
# creer	Créer	Create
Productivité et organisation	Safari	1	Utiliser les fonctions avancées du navigateur	Utiliser les profils, les onglets groupés ; masquer les éléments indésirables ; afficher le lecteur ; utiliser la traduction, les extensions et le menu de partage (par exemple, envoyer une page web dans OneNote)
Productivité et organisation		2	Réaliser des recherches approfondies	Utiliser Google Scholar (faire une recherche par auteur, par date, etc. ; faire une recherche avancée ; recevoir des alertes... | Utiliser JSTOR (recherche avancée, utilisation d'opérateurs booléens, d'outils comme Text analyzer/Understanding series…)
Productivité et organisation		3	Faire des recherches complexes pour retrouver des informations	Utiliser un moteur de recherche inversée pour retrouver l'origine d'une image ou encore Wayback Machine pour trouver l'archive d'une page web
Productivité et organisation		4	Utiliser les fonctions avancées de Wikipédia	Consulter l'historique d'une page, les modifications, les discussions, les outils…
Productivité et organisation	OneNote, Teams & OneDrive	5	Trier ses cours sur OneNote	Archiver, classer et retrouver rapidement des documents dans OneDrive grâce à une arborescence logique et une nomenclature cohérente
Productivité et organisation		6	Utiliser Teams comme outil de gestion de projet	Créer un canal ou une équipe pour un projet, attribuer des rôles, suivre les contributions de chacun via le fil de discussion ou les commentaires de documents | Intégrer des ressources (planning, OneNote, calendrier partagé)
Productivité et organisation		7	Mettre en place un système de suivi personnel de ses tâches et projets	Créer et maintenir à jour une to-do list numérique dans OneNote (ou Outlook) | Créer des rappels (on pourra aussi utiliser l'application Rappels d'Apple)
Productivité et organisation		8	Animer une courte réunion ou une présentation en ligne via Teams	Organiser une visioconférence simple (invitation, ordre du jour, partage d’écran) pour réaliser un travail (exposé, projet collaboratif…) | Gérer les rôles (prise de parole, modération, gestion du temps), utiliser le chat ou les réactions (émojis)
Communication et collaboration		9	Être acteur d'une communication	Créer un guide ou une charte des bonnes pratiques notamment en participant à des campagnes d'information (sur l'écologie, sur le harcèlement, etc.) | Organiser un atelier de sensibilisation pour identifier et combattre le réchauffement climatique, les formes de harcèlement numérique ou de désinformation...
Communication et collaboration		10	Mobiliser toutes les compétences et applications permettant d'être acteur de cette communication	Animer un projet collaboratif numérique en utilisant Teams, Padlet, Trello, Notion… | Assurer l'organisation des ressources partagées et leur accès
Communication et collaboration		11	Réaliser une production multimédia collaborative avancée	Produire un contenu numérique complexe (site web collaboratif, web-documentaire, podcast collaboratif, etc.). Voir domaine Créativité et expression
Communication et collaboration		12	Être responsible dans ses usages du web	Se familiariser avec la notion d’identité numérique | Être attentif aux traces qu’on laisse sur le web et prendre conscience des enjeux et de la portée de ses écrits
Données et programmation	Excel & Word	13	Bâtir des documents Word enrichis	Inclure une table des matières | Inclure des citations correctement formatées (APA, MLA…)
Données et programmation		14	Analyser des données avec Excel	Recourir à des formules conditionnelles (SI, NB.SI...) et la validation de données | Créer des filtres (pour soi ou pour tout le monde) | Créer un graphique adapté au type de données | Ces compétences peuvent être exploitées pour réaliser un budget, suivre des données sportives ou scientifiques
Données et programmation		15	Réaliser des calculs dans Excel	Connaître et combiner plusieurs formules (comme SI + ET, OU + MOYENNE, etc.)
Données et programmation		16	Connaître quelques formules avancées	Maîtriser des formules avancées telles que INDEX, MATCH, IFS, VLOOKUP…
Données et programmation		17	Insérer des équations	Dans Word, savoir utiliser l'éditeur d'équation
Données et programmation	Programmation	18	Perfectionner sa maîtrise de Scratch	Réaliser un mini-jeu mettant en œuvre les compétences précédemment acquises (variables, conditions, boucles et événements multiples…) | Participer à différentes initiatives du type la Nuit du code, Algorea. Aller au fablab.
Données et programmation		19	S'initier à Python	Écrire un programme linéaire simple | Utiliser des variables, des conditions et des boucles | Insérer des commentaires pour faciliter la lecture du code
Données et programmation		20	Automatiser des tâches	Écrire des scripts simples pour automatiser des tâches répétitives (renommer des fichiers, trier automatiquement des dossiers, générer des listes). | Éventuellement, s'aider de l'IA pour générer ces scripts.
Créativité et expression		21	Participer au développement de l'encyclopédie Vikidia ou Wikipédia	Posséder un compte pour faire éventuellement de simples modifications | Rédiger pour l'encyclopédie (informer de façon neutre, objectif, fournir des références, connaître la syntaxe wiki) | Participer à un projet collaboratif (corriger ou modérer, répondre à une demande de modification)
Créativité et expression		22	Créer un podcast ou participer à la web radio	Utiliser des applications comme GarageBand ou SoundTrap pour procéder un montage complexe voire collaboratif | Dans GarageBand, savoir insérer des boucles, des bruitages ou de la musique | Publier sur une plateforme comme Spotify ou autre
Créativité et expression		23	Réaliser un site web	S'initier au développement web (HTML, CSS…) | Connaître des outils de type no-code | Créer des sites complexes avec Wordpress ou Wix
Créativité et expression		24	Proposer des animations complexes	Avec Procreate ou Procreate Dreams, proposer des animations complexes (des œuvres artistiques ou des tutoriels)
Créativité et expression		25	Utiliser l'intelligence artificielle pour créer un contenu riche et personnel	Générer des images, des documents sonores ou écrire du code pour proposer des projets complexes
Créativité et expression		26	Utiliser les applications courantes de bureautique pour créer un contenu riche	Des applications comme PowerPoint ou Keynote pourront être utilisées de façon à proposer des présentations interactives avec des animations et des transitions variées
Créativité et expression		27	Traiter et modifier des images	Savoir modifier des images et utiliser des fonctions avancées de logiciels de retouche d'images | Connaître et utiliser les calques, le lasso et tout type d'outils variés
Créativité et expression		28	Faire du montage vidéo	Utiliser un logiciel de montage en ligne comme Capcut pour des projets plus complexes que ceux produits avec iMovie | Réaliser des projets complexes du type booktube, reportage, web TV (utilisation d'un fond vert, prise de son, effets…)
Créativité et expression		29	Utiliser la réalité augmentée ou créer des activités recourant à la réalité augmentée	Utilisation de différentes apps comme Reality Composer, FoxAR, ARMaker, Adobe Aero…
Créativité et expression		30	Générer des objets exploitables en 3D ainsi que la réalité virtuelle	Réaliser un environnement immersif à partir d'une application accessible comme CoSpaces Edu | Concevoir ses propres objets 3D avec TinkerCAD ou SketchUp | Exporter un objet 3D au format standard (STL, OBJ) pour impression 3D ou visualisation`;

function toRomanNumeral(value) {
  const number = Number(value);
  if (!Number.isFinite(number) || number <= 0) return "";
  const numerals = [
    ["M", 1000],
    ["CM", 900],
    ["D", 500],
    ["CD", 400],
    ["C", 100],
    ["XC", 90],
    ["L", 50],
    ["XL", 40],
    ["X", 10],
    ["IX", 9],
    ["V", 5],
    ["IV", 4],
    ["I", 1]
  ];
  let remaining = Math.floor(number);
  let result = "";
  numerals.forEach(([symbol, amount]) => {
    while (remaining >= amount) {
      result += symbol;
      remaining -= amount;
    }
  });
  return result;
}

function parseCompetencyCatalog(source) {
  const data = [];
  const categories = {};
  const tabs = [];
  const badgeByLevel = { acquerir: "N1", approfondir: "N2", creer: "N3" };
  const legacyCodeByLevel = { acquerir: "A", approfondir: "P", creer: "C" };
  let currentLevel = null;
  let currentLevelSections = null;

  String(source ?? "").split("\n").forEach((rawLine, index) => {
    const line = String(rawLine ?? "").replace(/\r/g, "");
    if (!line.trim()) return;

    if (line.startsWith("# ")) {
      const [id = "", labelFr = "", labelEn = ""] = line.slice(2).split("\t");
      currentLevel = { id, labelFr, labelEn };
      currentLevelSections = [];
      tabs.push(currentLevel);
      return;
    }

    if (!currentLevel) return;
    const [sectionRaw = "", appRaw = "", numberRaw = "", labelRaw = "", ...descParts] = line.split("\t");
    const descRaw = descParts.join("\t");
    const section = sectionRaw.trim() || "Général";
    const category = `${currentLevel.id}:${normalizeCatalogSlug(section)}`;
    let sectionIndex = currentLevelSections.indexOf(section);
    if (sectionIndex === -1) {
      currentLevelSections.push(section);
      sectionIndex = currentLevelSections.length - 1;
    }
    const sectionNumber = sectionIndex + 1;
    const sectionRoman = toRomanNumeral(sectionNumber);
    const competencyNumber = Number(numberRaw);
    const label = labelRaw.trim();
    const description = descRaw.trim();
    if (!Number.isFinite(competencyNumber) || !label || !description) {
      console.warn("Invalid competency catalog row", {
        lineNumber: index + 1,
        level: currentLevel.id,
        row: line
      });
      return;
    }
    categories[category] ||= {
      fr: `${sectionRoman} - ${section}`,
      en: `${sectionRoman} - ${section}`,
      plainFr: section,
      plainEn: section,
      number: sectionNumber,
      roman: sectionRoman
    };
    const shortCode = `${currentLevel.labelFr}-${sectionRoman}-${competencyNumber}`;
    const legacyShortCode = `${legacyCodeByLevel[currentLevel.id] || currentLevel.id.charAt(0).toUpperCase()}${competencyNumber}`;

    data.push({
      id: `competency:${currentLevel.id}:${numberRaw.trim()}`,
      platform: currentLevel.id,
      category,
      sectionFr: section,
      sectionEn: section,
      appFr: appRaw.trim(),
      appEn: appRaw.trim(),
      levelLabelFr: currentLevel.labelFr,
      levelLabelEn: currentLevel.labelEn,
      levelBadge: badgeByLevel[currentLevel.id] || currentLevel.id,
      number: competencyNumber,
      sectionNumber,
      sectionRoman,
      shortCode,
      legacyShortCode,
      labelFr: label,
      labelEn: label,
      descFr: description,
      descEn: description
    });
  });

  return { data, categories, tabs };
}

const {
  data: SELECTABLE_TOOLS_DATA,
  categories: SELECTABLE_TOOL_CATEGORY_LABELS,
  tabs: TOOL_PICKER_TABS
} = parseCompetencyCatalog(COMPETENCY_CATALOG_SOURCE);

const SELECTABLE_TOOL_IDS_SET = new Set(SELECTABLE_TOOLS_DATA.map(tool => tool.id));
const COMPETENCY_REFERENCE_MAP = SELECTABLE_TOOLS_DATA.reduce((map, tool) => {
  [
    tool.id,
    tool.shortCode,
    tool.legacyShortCode,
    tool.labelFr,
    tool.labelEn
  ].forEach((value) => {
    const token = normalizeToken(value);
    if (token) map[token] = tool.id;
  });
  return map;
}, {});

const COMPETENCY_LEVEL_STYLES = {
  acquerir: {
    bg: "#e0f2fe",
    border: "#7dd3fc",
    text: "#075985",
    active: "#bae6fd"
  },
  approfondir: {
    bg: "#ede9fe",
    border: "#c4b5fd",
    text: "#5b21b6",
    active: "#ddd6fe"
  },
  creer: {
    bg: "#dcfce7",
    border: "#86efac",
    text: "#166534",
    active: "#bbf7d0"
  }
};

function getCompetencyStyle(level) {
  return COMPETENCY_LEVEL_STYLES[level] || COMPETENCY_LEVEL_STYLES.acquerir;
}

function applyCompetencyTheme(element, level) {
  if (!element) return;
  const theme = getCompetencyStyle(level);
  element.style.setProperty("--competency-bg", theme.bg);
  element.style.setProperty("--competency-border", theme.border);
  element.style.setProperty("--competency-text", theme.text);
  element.style.setProperty("--competency-active", theme.active);
}

function competencyTooltip(toolDef, lang) {
  if (!toolDef) return "";
  const label = formatCompetencyLabel(toolDef, lang);
  const details = lang === "en" ? toolDef.descEn : toolDef.descFr;
  return [label, details].filter(Boolean).join(" — ");
}

function formatCompetencyLabel(toolDef, lang = currentLang()) {
  if (!toolDef) return "";
  const label = lang === "en" ? toolDef.labelEn : toolDef.labelFr;
  return `${toolDef.number}. ${label}`;
}

let uid = 0;
const nextId = () => `id-${Date.now()}-${uid++}`;
const DEFAULT_DAY_HOURS = 7;

const BLOOM_TAXONOMY = {
  fr: [
    {
      id: "souvenir", label: "Se souvenir",
      verbs: ["Citer", "Définir", "Décrire", "Dupliquer", "Énumérer", "Identifier", "Lister", "Localiser", "Mémoriser", "Nommer", "Rappeler", "Reconnaître", "Reproduire", "Retrouver"]
    },
    {
      id: "comprendre", label: "Comprendre",
      verbs: ["Clarifier", "Classer", "Comparer", "Décrire", "Distinguer", "Exemplifier", "Expliquer", "Généraliser", "Illustrer", "Inférer", "Interpréter", "Paraphraser", "Reformuler", "Résumer", "Traduire"]
    },
    {
      id: "appliquer", label: "Appliquer",
      verbs: ["Appliquer", "Calculer", "Choisir", "Compléter", "Construire", "Démontrer", "Employer", "Exécuter", "Mettre en œuvre", "Modifier", "Pratiquer", "Produire", "Résoudre", "Utiliser"]
    },
    {
      id: "analyser", label: "Analyser",
      verbs: ["Analyser", "Attribuer", "Comparer", "Contraster", "Décomposer", "Déconstruire", "Différencier", "Discriminer", "Distinguer", "Examiner", "Expérimenter", "Inférer", "Organiser", "Questionner", "Structurer"]
    },
    {
      id: "evaluer", label: "Évaluer",
      verbs: ["Apprécier", "Argumenter", "Choisir", "Comparer", "Conclure", "Critiquer", "Décider", "Défendre", "Estimer", "Évaluer", "Juger", "Justifier", "Recommander", "Sélectionner"]
    },
    {
      id: "creer", label: "Créer",
      verbs: ["Assembler", "Combiner", "Composer", "Concevoir", "Construire", "Créer", "Développer", "Élaborer", "Formuler", "Générer", "Imaginer", "Inventer", "Organiser", "Planifier", "Produire"]
    }
  ],
  en: [
    {
      id: "remember", label: "Remember",
      verbs: ["Cite", "Define", "Describe", "Duplicate", "Enumerate", "Find out", "Identify", "Label", "List", "Locate", "Memorize", "Name", "Recall", "Recognize", "Reproduce", "Retrieve"]
    },
    {
      id: "understand", label: "Understand",
      verbs: ["Clarify", "Classify", "Compare", "Describe", "Distinguish", "Exemplify", "Explain", "Generalize", "Identify", "Illustrate", "Infer", "Interpret", "Paraphrase", "Summarize", "Translate"]
    },
    {
      id: "apply", label: "Apply",
      verbs: ["Apply", "Calculate", "Choose", "Complete", "Construct", "Demonstrate", "Execute", "Implement", "Modify", "Practice", "Produce", "Resolve", "Use"]
    },
    {
      id: "analyze", label: "Analyze",
      verbs: ["Analyze", "Attribute", "Compare", "Contrast", "Deconstruct", "Differentiate", "Discriminate", "Distinguish", "Examine", "Experiment", "Infer", "Organize", "Question", "Structure"]
    },
    {
      id: "evaluate", label: "Evaluate",
      verbs: ["Appreciate", "Argue", "Choose", "Compare", "Conclude", "Criticize", "Decide", "Defend", "Estimate", "Evaluate", "Judge", "Justify", "Recommend", "Select"]
    },
    {
      id: "create", label: "Create",
      verbs: ["Assemble", "Combine", "Compose", "Conceive", "Construct", "Create", "Design", "Develop", "Elaborate", "Formulate", "Generate", "Imagine", "Invent", "Organize", "Plan", "Produce"]
    }
  ]
};

/**
 * Returns a debounced version of fn that fires after `delay` ms of inactivity.
 * @param {Function} fn
 * @param {number} delay - milliseconds
 */
function debounce(fn, delay) {
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => fn(...args), delay);
  };
}
const DEFAULT_META = {
  name: "",
  uiLanguage: "fr",
  dayHours: DEFAULT_DAY_HOURS,
  learningDays: 0,
  learningHours: 0,
  learningMinutes: 0,
  modeDelivery: "",
  sizeClass: "",
  designers: "",
  trainers: "",
  description: "",
  command: "",
  personas: "",
  sliders: [],
  activeTab: "settings",
  boardLayout: "columns"
};

const defaultPartitionLineConfig = () => [
  { type: "locationMode", label: "Présentiel", value: "onsite", visible: true },
  { type: "locationMode", label: "Distanciel", value: "online", visible: true },
  { type: "locationMode", label: "Hybride", value: "hybrid", visible: true }
];

const defaultState = () => ({
  allNotesExpanded: false,
  intentionsCollapsed: false,
  topPanelCollapsed: true,
  meta: { ...DEFAULT_META, sliders: [] },
  sessions: [],
  partitionLineConfig: defaultPartitionLineConfig()
});

const board = document.getElementById("board");
const sessionTpl = document.getElementById("session-template");
const activityTpl = document.getElementById("activity-template");

const addSessionBtn = document.getElementById("add-session-btn");
const boardLayoutToggle = document.getElementById("board-layout-toggle");
const boardLayoutListBtn = document.getElementById("board-layout-list-btn");
const boardLayoutColumnsBtn = document.getElementById("board-layout-columns-btn");
const boardLayoutListText = document.getElementById("board-layout-list-text");
const boardLayoutColumnsText = document.getElementById("board-layout-columns-text");
const boardLayoutGridBtn  = document.getElementById("board-layout-grid-btn");
const boardLayoutGridText = document.getElementById("board-layout-grid-text");
const newDesignBtn = document.getElementById("new-design-btn");
const importDesignBtn = document.getElementById("import-design-btn");
const exportDesignBtn = document.getElementById("export-design-btn");
const infoBtn = document.getElementById("info-btn");
const saveBtn = document.getElementById("save-btn");
const importFileInput = document.getElementById("import-file-input");
const importModalBackdrop = document.getElementById("import-modal-backdrop");
const importModalCancelBtn = document.getElementById("import-modal-cancel-btn");
const importFileBtn = document.getElementById("import-file-btn");
const importModelsSearch = document.getElementById("import-models-search");
const importModelsFamily = document.getElementById("import-models-family");
const importModelsList = document.getElementById("import-models-list");
const importModelsStatus = document.getElementById("import-models-status");
const importModelsLink = document.getElementById("import-models-link");
const langSelect = document.getElementById("lang-select");
const languageButton = document.querySelector(".nav-language-toggle");
const srStatus = document.getElementById("sr-status");
const appTitle = document.getElementById("app-title");
const topPanel = document.getElementById("top-panel");
const topPanelBody = document.getElementById("top-panel-body");
const topPanelToggleBtn = document.getElementById("top-panel-toggle-btn");
const topTabSettings = document.getElementById("top-tab-settings");
const topTabAnalysis = document.getElementById("top-tab-analysis");
const topTabChronology = document.getElementById("top-tab-chronology");
const topTabSlider = document.querySelector(".top-tab-slider");
const timelineView = document.getElementById("timeline-view");
const analysisView = document.getElementById("analysis-view");
const chronologyView = document.getElementById("chronology-view");
const partitionConfigModalBackdrop = document.getElementById("partition-config-modal-backdrop");
let partitionConfigDraft = [];
const metaNameInput = document.getElementById("meta-name");
const metaLearningDaysInput = document.getElementById("meta-learning-days");
const metaLearningHoursInput = document.getElementById("meta-learning-hours");
const metaLearningMinutesInput = document.getElementById("meta-learning-minutes");
const metaDesignedDaysInput = document.getElementById("meta-designed-days");
const metaDesignedHoursInput = document.getElementById("meta-designed-hours");
const metaDesignedMinutesInput = document.getElementById("meta-designed-minutes");
const metaDeliverySelect = document.getElementById("meta-delivery");
const metaDayHoursInput = document.getElementById("meta-day-hours");
const metaSizeClassInput = document.getElementById("meta-size-class");
const metaDesignersInput = document.getElementById("meta-designers");
const metaTrainersInput = document.getElementById("meta-trainers");
const metaDescriptionInput = document.getElementById("meta-description");
const metaCommandInput = document.getElementById("meta-command");
const metaPersonasInput = document.getElementById("meta-personas");
const outcomesListEl = document.getElementById("outcomes-list");
const addOutcomeBtn = document.getElementById("add-outcome-btn");
const newDesignModalBackdrop = document.getElementById("new-design-modal-backdrop");
const newDesignModalMsg = document.getElementById("new-design-modal-msg");
const newDesignCancelBtn = document.getElementById("new-design-cancel-btn");
const newDesignConfirmBtn = document.getElementById("new-design-confirm-btn");
const bloomModalBackdrop = document.getElementById("bloom-modal-backdrop");
const bloomCategoryList = document.getElementById("bloom-category-list");
const bloomAddBtn = document.getElementById("bloom-add-btn");
const bloomCancelBtn = document.getElementById("bloom-cancel-btn");
const topPieWrap = document.getElementById("top-pie-wrap");
const topPie = document.getElementById("top-pie");
const topPieLabels = document.getElementById("top-pie-labels");
const topPieTooltip = document.getElementById("top-pie-tooltip");
const topLegend = document.getElementById("top-legend");
const analysisAlerts = document.getElementById("analysis-alerts");
const analysisLearningPieWrap = document.getElementById("analysis-learning-pie-wrap");
const analysisLearningPie = document.getElementById("analysis-learning-pie");
const analysisLearningLabels = document.getElementById("analysis-learning-labels");
const analysisLearningTooltip = document.getElementById("analysis-learning-tooltip");
const analysisLearningLegend = document.getElementById("analysis-learning-legend");
const analysisDeliveryPie = document.getElementById("analysis-delivery-pie");
const analysisDeliveryLegend = document.getElementById("analysis-delivery-legend");
const analysisTeacherPie = document.getElementById("analysis-teacher-pie");
const analysisTeacherLegend = document.getElementById("analysis-teacher-legend");
const analysisSyncPie = document.getElementById("analysis-sync-pie");
const analysisSyncLegend = document.getElementById("analysis-sync-legend");
const analysisEvalPie = document.getElementById("analysis-eval-pie");
const analysisEvalLegend = document.getElementById("analysis-eval-legend");
const analysisGroupBar = document.getElementById("analysis-group-bar");
const analysisGroupLegend = document.getElementById("analysis-group-legend");
const infoModalBackdrop = document.getElementById("info-modal-backdrop");
const infoModalCloseBtn = document.getElementById("info-modal-close-btn");
const exportScopeLabel = document.getElementById("export-scope-label");
const exportScopeFullInput = document.getElementById("export-scope-full-input");
const exportScopeStudentsInput = document.getElementById("export-scope-students-input");
const exportMomentsDetails = document.getElementById("export-moments-details");
const exportMomentsLabel = document.getElementById("export-moments-label");
const exportMomentsAllInput = document.getElementById("export-moments-all-input");
const exportMomentsAllLabel = document.getElementById("export-moments-all-label");
const exportMomentsList = document.getElementById("export-moments-list");
const exportMomentsSummary = document.getElementById("export-moments-summary");
const exportMomentsEmpty = document.getElementById("export-moments-empty");
const exportModalBackdrop = document.getElementById("export-modal-backdrop");
const exportFormatSelect = document.getElementById("export-format-select");
const exportFilenameInput = document.getElementById("export-filename-input");
const exportModalCancelBtn = document.getElementById("export-modal-cancel-btn");
const exportModalConfirmBtn = document.getElementById("export-modal-confirm-btn");
const exportPreviewDetails = document.getElementById("export-preview-details");
const exportPreviewLabel = document.getElementById("export-preview-label");
const exportResultText = document.getElementById("export-result-text");
const exportResultCopyBtn = document.getElementById("export-result-copy-btn");
const activityLinkModalBackdrop = document.getElementById("activity-link-modal-backdrop");
const activityLinkTitleInput = document.getElementById("activity-link-title-input");
const activityLinkUrlInput = document.getElementById("activity-link-url-input");
const activityLinkList = document.getElementById("activity-link-list");
const activityLinkError = document.getElementById("activity-link-modal-error");
const activityLinkCancelBtn = document.getElementById("activity-link-cancel-btn");
const activityLinkSaveBtn = document.getElementById("activity-link-save-btn");
const aiasModalBackdrop = document.getElementById("aias-modal-backdrop");
const aiasModalTitle = document.getElementById("aias-modal-title");
const aiasModalIntro = document.getElementById("aias-modal-intro");
const aiasModalStatusOptions = document.getElementById("aias-modal-status-options");
const aiasModalLevels = document.getElementById("aias-modal-levels");
const aiasModalAttributionPrefix = document.getElementById("aias-modal-attribution-prefix");
const aiasModalCloseBtn = document.getElementById("aias-modal-close-btn");

const LD_STORAGE_KEY_PREFIX = "ld_state_v2_";
const LD_LANGUAGE_STORAGE_KEY = "learningDesignerLang";
let activeStorageKey = null;
let storageScopeReady = false;
let activeActivityLinkTrigger = null;
let activeActivityLinkActivity = null;
let activeAiasTrigger = null;
let activeAiasActivity = null;

function preferredInterfaceLanguage(fallback = "fr") {
  const normalizedFallback = fallback === "en" ? "en" : "fr";
  try {
    const savedLanguage = localStorage.getItem(LD_LANGUAGE_STORAGE_KEY);
    if (savedLanguage === "fr" || savedLanguage === "en") return savedLanguage;
  } catch (_) {}
  return normalizedFallback;
}

let state = defaultState();
state.meta.uiLanguage = preferredInterfaceLanguage(state.meta.uiLanguage);
let dragState = null;
let activeModalBackdrop = null;
let previousFocusedElement = null;
let exportPreviewObjectUrl = "";
let exportScope = "full";
let exportSessionIds = null;

const I18N = {
  fr: {
    docTitle: "Interface de conception d’apprentissage - Prototype",
    skipLink: "Aller au contenu principal",
    appTitle: "Interface de conception d’apprentissage",
    tabSettings: "Paramètres",
    tabAnalysis: "Analyse",
    collapsePanel: "Replier le panneau",
    expandPanel: "Déplier le panneau",
    addMoment: "Ajouter un moment",
    addMomentCompact: "Ajouter",
    expandNotes: "Déplier les notes",
    collapseNotes: "Replier les notes",
    hideIntentions: "Masquer les intentions",
    showIntentions: "Afficher les intentions",
    new: "Nouveau",
    import: "Importer",
    export: "Exporter",
    save: "Enregistrer",
    share: "Partager",
    saved: "Enregistré",
    savedLocal: "Modifications mises à jour.",
    info: "Information",
    toolbarRegion: "Actions du design",
    analysisTitle: "Expérience d’apprentissage",
    metaNameLabel: "Titre",
    metaLearningLabel: "Temps d'apprentissage",
    metaDesignedLabel: "Temps conçu",
    metaDayLabel: "1 jour =",
    metaDescriptionLabel: "Description",
    metaCommandLabel: "Commande institutionnelle",
    metaDeliveryLabel: "Mode",
    metaSizeLabel: "Taille du groupe",
    metaDesignersLabel: "Concepteur(s)",
    metaTrainersLabel: "Enseignant(s)",
    metaPersonasLabel: "Objectifs",
    metaSlidersLabel: "Résultats",
    outcomesLabel: "Acquis d'apprentissage",
    addOutcome: "+ Acquis",
    outcomeTextPlaceholder: "Décrivez cet acquis...",
    deleteOutcome: "Supprimer l'acquis",
    changeVerb: "Modifier le verbe",
    bloomTitle: "Taxonomie de Bloom",
    bloomSubtitle: "Sélectionnez une catégorie ou un verbe d'action",
    bloomAdd: "Ajouter",
    bloomEdit: "Modifier",
    unitDays: "jours",
    unitHours: "heures",
    unitMinutes: "minutes",
    modeOnsite: "Présentiel",
    modeOnline: "Distanciel",
    modeHybrid: "Hybride",
    importTitle: "Importer un scénario",
    importModalDesc: "Partez d’un modèle prérempli, ou chargez un fichier exporté depuis cette application. Le design actuel sera remplacé.",
    importFromFileTitle: "Depuis mon ordinateur",
    importChooseFile: "Choisir un fichier…",
    importFileFormats: "LDJ, JSON, CSV, Excel, Markdown",
    importModelsTitle: "Bibliothèque de modèles",
    importModelsLink: "Voir la bibliothèque",
    importModelsSearchLabel: "Rechercher un modèle",
    importModelsSearchPlaceholder: "Rechercher un modèle…",
    importModelsFamilyLabel: "Famille de modèles",
    importModelsFamilyAll: "Toutes les familles",
    importModelsLoading: "Chargement des modèles…",
    importModelsCount: "{count} modèles disponibles.",
    importModelsCountOne: "1 modèle disponible.",
    importModelsNone: "Aucun modèle ne correspond à cette recherche.",
    importModelsError: "Bibliothèque de modèles indisponible. L’import de fichier reste possible.",
    importModelsUnitMoments: "moments",
    importModelsUnitActivities: "activités",
    importModelsToComplete: "À compléter :",
    importModelApplied: "Modèle chargé : {name}",
    importModelFailed: "Ce modèle n’a pas pu être chargé.",
    exportTitle: "Exporter le design",
    exportScopeTitle: "Contenu à exporter",
    exportScopeFull: "Export enseignant",
    exportScopeFullDescription: "Toutes les informations du scénario pédagogique.",
    exportScopeStudents: "Export élève",
    exportScopeStudentsDescription: "Les séances, les activités et les consignes adressées aux élèves.",
    exportMomentsTitle: "Moments à exporter",
    exportMomentsAll: "Tous les moments",
    exportMomentsEmpty: "Aucun moment à exporter.",
    exportMomentsSelection: (selected, total) => `${selected} sur ${total} sélectionné${selected === 1 ? "" : "s"}`,
    format: "Format",
    exportFilename: "Nom du fichier",
    exportPreviewCopy: "Le contenu exporté est lisible ci-dessous. Vous pouvez le copier ou télécharger le fichier.",
    exportPreviewTitle: "Prévisualisation",
    exportDownloadOnly: "Ce format est destiné au téléchargement. Le contenu brut n'est pas affiché ni copiable.",
    copy: "Copier",
    download: "Télécharger",
    cancel: "Annuler",
    validate: "Valider",
    close: "Fermer",
    boardRegion: "Séquences de séances",
    sessionNotes: "Notes",
    addLearningType: "+ Activité",
    sessionPrefix: "Séance",
    viewModeLabel: "Mode d'affichage des séances",
    viewList: "Liste",
    viewColumns: "Colonnes",
    sessionMoveHintColumns: "Alt+Flèche gauche/droite pour déplacer.",
    sessionMoveHintList: "Alt+Flèche haut/bas pour déplacer.",
    activityMoveHint: "Alt+Flèche haut/bas pour déplacer dans la séance.",
    sessionTitleLabel: "Titre de la séance",
    sessionObjectivesLabel: "Objectifs du moment",
    sessionActivitiesLabel: "Activités de la séance",
    activityLabel: "Activité",
    activityDurationLabel: "Durée en minutes de l'activité",
    activityDescriptionLabel: "Description de l'activité",
    activityInstructionsLabel: "Consignes pour les élèves",
    activityNotesLabel: "Notes de l'activité",
    sessionNotesLabel: "Notes de la séance",
    deleteSession: "Supprimer la séance",
    deleteActivity: "Supprimer l'activité",
    activityDeleted: "Activité supprimée.",
    activityAdded: "Activité ajoutée.",
    sessionDeleted: "Séance supprimée.",
    selectTools: "Sélectionner des compétences",
    toolPickerTitle: "Compétences numériques",
    toolPickerClose: "Fermer",
    toolsAriaLabel: "Compétences sélectionnées",
    removeToolAriaLabel: (name) => `Retirer ${name}`,
    toolCount: (n) => n === 1 ? "1 compétence" : `${n} compétences`,
    manageLinks: "Insérer un lien",
    activityLinksTitle: "Liens de l'activité",
    activityLinkTitleLabel: "Titre",
    activityLinkUrlLabel: "Lien",
    activityLinkAdd: "Ajouter",
    activityLinkEmpty: "Aucun lien ajouté pour cette activité.",
    activityLinkCount: (n) => n === 1 ? "1 lien" : `${n} liens`,
    removeLinkAriaLabel: (name) => `Retirer le lien ${name}`,
    activityLinkErrorRequired: "Renseignez un titre et un lien.",
    activityLinkErrorInvalid: "Le lien saisi n'est pas valide.",
    groupTitleType: "Type d'apprentissage",
    groupTitleGroup: "Groupe",
    groupTitleTrainer: "Enseignant",
    groupTitlePacing: "Rythme",
    groupTitleMode: "Modalité",
    groupTitleEvaluation: "Évaluation",
    aiasFieldLabel: "Place de l’IA dans la tâche · AIAS 2.1",
    aiasUndecided: "À définir",
    aiasNotApplicable: "Non pertinent",
    aiasPanelIntro: "Choisissez le rôle de l’IA dans cette tâche. Les niveaux décrivent des conceptions différentes, sans hiérarchie entre elles.",
    aiasLevelsAriaLabel: "Niveau AIAS de l’activité",
    aiasAttributionPrefix: "Basé sur",
    aiasLevelPrefix: "Niveau",
    aiasUpdated: "Place de l’IA mise à jour.",
    aiasLevel1Label: "Sans IA",
    aiasLevel1Description: "Tâche réalisée sans IA, dans un environnement contrôlé, pour évaluer les acquis propres de l’élève.",
    aiasLevel2Label: "Planification avec l’IA",
    aiasLevel2Description: "L’IA peut soutenir l’exploration, la recherche et la planification ; la réalisation reste autonome.",
    aiasLevel3Label: "Collaboration avec l’IA",
    aiasLevel3Description: "L’IA contribue au travail ; l’élève évalue, modifie et intègre ses productions.",
    aiasLevel4Label: "IA pleinement intégrée",
    aiasLevel4Description: "L’IA est pleinement intégrée ; l’élève la dirige avec esprit critique et expertise disciplinaire.",
    aiasLevel5Label: "Exploration de l’IA",
    aiasLevel5Description: "L’élève explore et co-conçoit des usages créatifs de l’IA pour produire des idées ou des solutions nouvelles.",
    newActivityDescription: "Nouvelle activité",
    sessionTitlePlaceholder: "Titre du moment",
    activityDescriptionPlaceholder: "Décrivez l'activité...",
    activityInstructionsPlaceholder: "Indiquez les consignes données aux élèves...",
    newDesignConfirm: "Créer un nouveau design et écraser le contenu actuel ?",
    newDesignModalTitle: "Nouveau design",
    newDesignModalMsg: "Vous allez créer un nouveau design vierge. Si vous n'avez pas enregistré le design actuel, il sera perdu.",
    newDesignModalConfirm: "Créer un nouveau design",
    importInvalid: "Fichier invalide. Importez un LDJ, JSON, CSV, Excel ou Markdown exporté depuis cette application.",
    commandPlaceholder: "Collez ici la commande institutionnelle déjà définie...",
    personasPlaceholder: "Décrivez les objectifs de la formation...",
    slidersPlaceholder: "Décrivez les résultats attendus...",
    sessionNotesPlaceholder: "Notes de la séance...",
    sessionObjectivesPlaceholder: "Objectifs du moment...",
    sessionIntentionsLabel: "Choix pédagogiques",
    sessionIntentionsPlaceholder: "Choix pédagogiques (ex. : pourquoi cet ordre d'activités ? quelle alternance de modalités ? quel rythme ?)",
    activityNotesPlaceholder: "Notes de l'activité...",
    durationMinutesSr: "Durée en minutes",
    fullscreen: "Plein écran",
    closeFullscreen: "Quitter le plein écran",
    markdownToolbarLabel: "Barre de formatage Markdown",
    mdBold: "Gras",
    mdItalic: "Italique",
    mdHeading: "Titre",
    mdList: "Liste à puces",
    mdOrderedList: "Liste numérotée",
    mdQuote: "Citation",
    mdLink: "Lien",
    mdPlaceholderBold: "texte en gras",
    mdPlaceholderItalic: "texte en italique",
    mdPlaceholderHeading: "Titre",
    mdPlaceholderList: "élément de liste",
    mdPlaceholderOrderedList: "élément de liste",
    mdPlaceholderQuote: "citation",
    mdPlaceholderLinkText: "texte du lien",
    mdPlaceholderLinkUrl: "https://",
    uiLanguage: "Langue de l’interface",
    moved: "Élément déplacé.",
    an01: "Un ou plusieurs graphiques peuvent être incorrects, car une ou plusieurs activités n’ont pas de durée valide.",
    an02: "Les graphiques ne peuvent pas être calculés, car aucune durée d’activité n’est définie.",
    an03: "Le graphe social peut être incorrect, car un ou plusieurs types d’apprentissage n’ont pas de taille de groupe définie.",
    an04: "Le graphique « Enseignant » peut être incorrect, car une ou plusieurs activités n’ont pas ce paramètre défini.",
    an05: "Le graphique « Rythme » peut être incorrect, car une ou plusieurs activités n’ont pas ce paramètre défini.",
    an06: "Le graphique « Modalité » peut être incorrect, car une ou plusieurs activités n’ont pas ce paramètre défini.",
    an07: "Le temps conçu dépasse le temps d’apprentissage déclaré.",
    an08: "Le temps d’apprentissage n’est pas défini, mais des activités ont une durée.",
    an09: "Aucun type d’apprentissage défini : précisez le type de chaque activité pour obtenir une analyse pertinente.",
    lt_undefined: "Non défini",
    lt_read: "Lire / Regarder / Écouter",
    lt_investigate: "Investiguer",
    lt_practice: "Pratiquer",
    lt_produce: "Produire",
    lt_discuss: "Discuter",
    lt_collaborate: "Collaborer",
    group_whole: "Groupe entier",
    group_subgroups: "Sous-groupes",
    group_individual: "Individuel",
    trainer_present: "Présent",
    trainer_absent: "Absent",
    teacherPresentLabel: "Enseignant présent",
    teacherAbsentLabel: "Enseignant absent",
    sync_sync: "Synchrone",
    sync_async: "Asynchrone",
    eval_none: "Aucune évaluation",
    eval_diagnostic: "Diagnostique",
    eval_formative: "Formative",
    eval_summative: "Sommative",
    eval_certificative: "Certificative",
    infoTitle: "À propos",
    footerHelp: "Aide",
    infoP1: "Cette application web monopage s’inspire de l’UCL Learning Designer :",
    infoP2: "(UCL Knowledge Lab, UCL Institute of Education, 2013-2026).",
    infoP3: "Traitement local par défaut : les données restent dans votre navigateur, sauf si vous vous connectez et enregistrez explicitement une production sur votre compte.",
    infoP4: "Yann Houry &amp; François Jourde (2026) • CC BY-SA<br />Code source : <a href=\"https://github.com/jourde\" target=\"_blank\" rel=\"noopener noreferrer\">https://github.com/jourde</a>",
    infoP5: "Les compétences numériques proposées dans l'application sont issues du référentiel interne fourni au format Excel.",
    noData: "Aucune donnée",
    learningDaysLabel: "Jours d'apprentissage",
    learningHoursLabel: "Heures d'apprentissage",
    learningMinutesLabel: "Minutes d'apprentissage",
    designedDaysLabel: "Jours conçus",
    designedHoursLabel: "Heures conçues",
    designedMinutesLabel: "Minutes conçues",
    tabChronology: "Chronologie",
    chronologyTitle: "Chronologie des activités",
    partitionLinesLabel: "Lignes affichées",
    partitionConfigure: "✎ Configurer",
    partitionConfigTitle: "Configurer les lignes",
    partitionConfigDesc: "Choisissez les lignes à afficher et leur ordre dans la partition.",
    partitionAddLineSection: "Ajouter une ligne",
    partitionAdd: "+ Ajouter",
    partitionMoveUp: "Monter",
    partitionMoveDown: "Descendre",
    partitionShowHide: "Afficher/masquer",
    partitionDeleteLine: "Supprimer cette ligne",
    partitionShowPrefix: "Afficher",
    partitionTypeLocation: "Localisation",
    partitionTypeGroup: "Mode groupe",
    partitionTypeSync: "Synchronicité",
    partitionTypePresence: "Présence enseignant",
    partitionTotal: "Total",
    partitionSession: "Session",
    viewGrid: "Grille",
    gridColType: "Type",
    gridColDuration: "Durée",
    gridColLocation: "Lieu",
    gridColGroup: "Groupe",
    gridColSync: "Sync",
    gridColTeacher: "Enseignant",
    gridColEval: "Évaluation",
    gridColAias: "AIAS",
    gridColDesc: "Description",
    gridColInstructions: "Consignes pour les élèves",
    gridColNotes: "Notes",
    gridAddActivity: "+ Activité",
    gridAddSession: "+ Ajouter une séance",
    gridSessionPrefix: "Séance"
  },
  en: {
    docTitle: "Learning Design Interface - Prototype",
    skipLink: "Skip to main content",
    appTitle: "Learning Design Interface",
    tabSettings: "Settings",
    tabAnalysis: "Analysis",
    collapsePanel: "Collapse panel",
    expandPanel: "Expand panel",
    addMoment: "Add moment",
    addMomentCompact: "Add",
    expandNotes: "Expand notes",
    collapseNotes: "Collapse notes",
    hideIntentions: "Hide intentions",
    showIntentions: "Show intentions",
    new: "New",
    import: "Import",
    export: "Export",
    save: "Save",
    share: "Share",
    saved: "Saved",
    savedLocal: "Changes updated.",
    info: "About",
    toolbarRegion: "Design actions",
    analysisTitle: "Learning Experience",
    metaNameLabel: "Title",
    metaLearningLabel: "Learning time",
    metaDesignedLabel: "Designed time",
    metaDayLabel: "1 day =",
    metaDescriptionLabel: "Description",
    metaCommandLabel: "Institutional brief",
    metaDeliveryLabel: "Mode",
    metaSizeLabel: "Group size",
    metaDesignersLabel: "Designer(s)",
    metaTrainersLabel: "Teacher(s)",
    metaPersonasLabel: "Objectives",
    metaSlidersLabel: "Results",
    outcomesLabel: "Learning Outcomes",
    addOutcome: "+ Outcome",
    outcomeTextPlaceholder: "Describe this outcome...",
    deleteOutcome: "Delete outcome",
    changeVerb: "Change verb",
    bloomTitle: "Bloom's Taxonomy",
    bloomSubtitle: "Select a category or an action verb",
    bloomAdd: "Add",
    bloomEdit: "Update",
    unitDays: "days",
    unitHours: "hours",
    unitMinutes: "minutes",
    modeOnsite: "Onsite",
    modeOnline: "Online",
    modeHybrid: "Hybrid",
    importTitle: "Import a scenario",
    importModalDesc: "Start from a pre-filled template, or load a file exported from this application. The current design will be replaced.",
    importFromFileTitle: "From my computer",
    importChooseFile: "Choose a file…",
    importFileFormats: "LDJ, JSON, CSV, Excel, Markdown",
    importModelsTitle: "Template library",
    importModelsLink: "Browse the library",
    importModelsSearchLabel: "Search for a template",
    importModelsSearchPlaceholder: "Search for a template…",
    importModelsFamilyLabel: "Template family",
    importModelsFamilyAll: "All families",
    importModelsLoading: "Loading templates…",
    importModelsCount: "{count} templates available.",
    importModelsCountOne: "1 template available.",
    importModelsNone: "No template matches this search.",
    importModelsError: "Template library unavailable. File import is still possible.",
    importModelsUnitMoments: "moments",
    importModelsUnitActivities: "activities",
    importModelsToComplete: "To complete:",
    importModelApplied: "Template loaded: {name}",
    importModelFailed: "This template could not be loaded.",
    exportTitle: "Export design",
    exportScopeTitle: "Content to export",
    exportScopeFull: "Full export",
    exportScopeFullDescription: "All the information in the learning design.",
    exportScopeStudents: "Student instructions only",
    exportScopeStudentsDescription: "Sessions, activities, and instructions addressed to students.",
    exportMomentsTitle: "Moments to export",
    exportMomentsAll: "All moments",
    exportMomentsEmpty: "No moments to export.",
    exportMomentsSelection: (selected, total) => `${selected} of ${total} selected`,
    format: "Format",
    exportFilename: "File name",
    exportPreviewCopy: "The exported content is shown below. You can copy it or download the file.",
    exportPreviewTitle: "Preview",
    exportDownloadOnly: "This format is meant to be downloaded. Raw content is not shown or copyable.",
    copy: "Copy",
    download: "Download",
    cancel: "Cancel",
    validate: "Validate",
    close: "Close",
    boardRegion: "Sequence board",
    sessionNotes: "Notes",
    addLearningType: "+ Activity",
    sessionPrefix: "Session",
    viewModeLabel: "Session view mode",
    viewList: "List",
    viewColumns: "Columns",
    sessionMoveHintColumns: "Alt+Left/Right Arrow to move.",
    sessionMoveHintList: "Alt+Up/Down Arrow to move.",
    activityMoveHint: "Alt+Up/Down Arrow to move within the session.",
    sessionTitleLabel: "Session title",
    sessionObjectivesLabel: "Moment objectives",
    sessionActivitiesLabel: "Activities for session",
    activityLabel: "Activity",
    activityDurationLabel: "Activity duration in minutes",
    activityDescriptionLabel: "Activity description",
    activityInstructionsLabel: "Instructions for students",
    activityNotesLabel: "Activity notes",
    sessionNotesLabel: "Session notes",
    deleteSession: "Delete session",
    deleteActivity: "Delete activity",
    activityDeleted: "Activity deleted.",
    activityAdded: "Activity added.",
    sessionDeleted: "Session deleted.",
    selectTools: "Select competencies",
    toolPickerTitle: "Digital competencies",
    toolPickerClose: "Close",
    toolsAriaLabel: "Selected competencies",
    removeToolAriaLabel: (name) => `Remove ${name}`,
    toolCount: (n) => n === 1 ? "1 competency" : `${n} competencies`,
    manageLinks: "Insert link",
    activityLinksTitle: "Activity links",
    activityLinkTitleLabel: "Title",
    activityLinkUrlLabel: "Link",
    activityLinkAdd: "Add",
    activityLinkEmpty: "No links added for this activity.",
    activityLinkCount: (n) => n === 1 ? "1 link" : `${n} links`,
    removeLinkAriaLabel: (name) => `Remove link ${name}`,
    activityLinkErrorRequired: "Enter both a title and a link.",
    activityLinkErrorInvalid: "The link entered is not valid.",
    groupTitleType: "Learning type",
    groupTitleGroup: "Group",
    groupTitleTrainer: "Teacher",
    groupTitlePacing: "Pacing",
    groupTitleMode: "Mode",
    groupTitleEvaluation: "Assessment",
    aiasFieldLabel: "Role of AI in the task · AIAS 2.1",
    aiasUndecided: "To be defined",
    aiasNotApplicable: "Not applicable",
    aiasPanelIntro: "Choose the role of AI in this task. The levels describe different task designs and are not a hierarchy.",
    aiasLevelsAriaLabel: "AIAS level for the activity",
    aiasAttributionPrefix: "Based on",
    aiasLevelPrefix: "Level",
    aiasUpdated: "Role of AI updated.",
    aiasLevel1Label: "No AI",
    aiasLevel1Description: "The task is completed without AI, in a controlled environment, to assess the student’s own learning.",
    aiasLevel2Label: "AI Planning",
    aiasLevel2Description: "AI may support exploration, research, and planning; the student completes the task independently.",
    aiasLevel3Label: "AI Collaboration",
    aiasLevel3Description: "AI contributes to the work; the student evaluates, modifies, and integrates its outputs.",
    aiasLevel4Label: "Full AI",
    aiasLevel4Description: "AI is fully integrated; the student directs it using critical thinking and subject expertise.",
    aiasLevel5Label: "AI Exploration",
    aiasLevel5Description: "The student explores and co-designs creative uses of AI to produce new ideas or solutions.",
    newActivityDescription: "New activity",
    sessionTitlePlaceholder: "Moment title",
    activityDescriptionPlaceholder: "Describe the activity...",
    activityInstructionsPlaceholder: "Enter the instructions given to students...",
    newDesignConfirm: "Create a new design and replace current content?",
    newDesignModalTitle: "New design",
    newDesignModalMsg: "You are about to create a blank new design. If you have not saved the current design, it will be lost.",
    newDesignModalConfirm: "Create a new design",
    importInvalid: "Invalid file. Import an LDJ, JSON, CSV, Excel or Markdown file exported by this application.",
    commandPlaceholder: "Paste the previously defined institutional brief here...",
    personasPlaceholder: "Describe the learning objectives...",
    slidersPlaceholder: "Describe the expected results...",
    sessionNotesPlaceholder: "Session notes...",
    sessionObjectivesPlaceholder: "Moment objectives...",
    sessionIntentionsLabel: "Pedagogical choices",
    sessionIntentionsPlaceholder: "Pedagogical choices (e.g.: why this order of activities? what alternation of modalities? what rhythm?)",
    activityNotesPlaceholder: "Activity notes...",
    durationMinutesSr: "Duration in minutes",
    fullscreen: "Fullscreen",
    closeFullscreen: "Exit fullscreen",
    markdownToolbarLabel: "Markdown formatting toolbar",
    mdBold: "Bold",
    mdItalic: "Italic",
    mdHeading: "Heading",
    mdList: "Bullet list",
    mdOrderedList: "Numbered list",
    mdQuote: "Quote",
    mdLink: "Link",
    mdPlaceholderBold: "bold text",
    mdPlaceholderItalic: "italic text",
    mdPlaceholderHeading: "Heading",
    mdPlaceholderList: "list item",
    mdPlaceholderOrderedList: "list item",
    mdPlaceholderQuote: "quote",
    mdPlaceholderLinkText: "link text",
    mdPlaceholderLinkUrl: "https://",
    uiLanguage: "Interface language",
    moved: "Item moved.",
    an01: "One or more graphs might not display correctly, because one or more activities do not have a valid duration.",
    an02: "Graphs cannot be computed, because no activity duration is set.",
    an03: "The social learning graph might not display correctly, because one or more learning types do not have group size set.",
    an04: "The “Teacher presence” graph might be inaccurate, because one or more activities are missing this setting.",
    an05: "The “Pacing” graph might be inaccurate, because one or more activities are missing this setting.",
    an06: "The “Delivery mode” graph might be inaccurate, because one or more activities are missing this setting.",
    an07: "Designed time exceeds declared learning time.",
    an08: "Learning time is not set, but activities have durations.",
    an09: "No learning type set: specify the type of each activity for a meaningful analysis.",
    lt_undefined: "Undefined",
    lt_read: "Read / Watch / Listen",
    lt_investigate: "Investigate",
    lt_practice: "Practice",
    lt_produce: "Produce",
    lt_discuss: "Discuss",
    lt_collaborate: "Collaborate",
    group_whole: "Whole class",
    group_subgroups: "Sub-groups",
    group_individual: "Individual",
    trainer_present: "Present",
    trainer_absent: "Absent",
    teacherPresentLabel: "Teacher present",
    teacherAbsentLabel: "Teacher absent",
    sync_sync: "Synchronous",
    sync_async: "Asynchronous",
    eval_none: "No assessment",
    eval_diagnostic: "Diagnostic",
    eval_formative: "Formative",
    eval_summative: "Summative",
    eval_certificative: "Certifying",
    infoTitle: "About",
    footerHelp: "Help",
    infoP1: "This single-page web app is inspired by the UCL Learning Designer:",
    infoP2: "(UCL Knowledge Lab, UCL Institute of Education, 2013-2026).",
    infoP3: "Local processing by default: data stays in your browser unless you sign in and explicitly save a design to your account.",
    infoP4: "Yann Houry &amp; François Jourde (2026) • CC BY-SA<br />Source code: <a href=\"https://github.com/jourde\" target=\"_blank\" rel=\"noopener noreferrer\">https://github.com/jourde</a>",
    infoP5: "The digital competencies offered in the app come from the internal reference workbook provided in Excel format.",
    noData: "No data",
    learningDaysLabel: "Learning days",
    learningHoursLabel: "Learning hours",
    learningMinutesLabel: "Learning minutes",
    designedDaysLabel: "Designed days",
    designedHoursLabel: "Designed hours",
    designedMinutesLabel: "Designed minutes",
    tabChronology: "Timeline",
    chronologyTitle: "Activity Timeline",
    partitionLinesLabel: "Displayed lines",
    partitionConfigure: "✎ Configure",
    partitionConfigTitle: "Configure lines",
    partitionConfigDesc: "Choose the lines to display and their order in the partition.",
    partitionAddLineSection: "Add a line",
    partitionAdd: "+ Add",
    partitionMoveUp: "Move up",
    partitionMoveDown: "Move down",
    partitionShowHide: "Show/hide",
    partitionDeleteLine: "Delete this line",
    partitionShowPrefix: "Show",
    partitionTypeLocation: "Location",
    partitionTypeGroup: "Group mode",
    partitionTypeSync: "Synchronicity",
    partitionTypePresence: "Teacher presence",
    partitionTotal: "Total",
    partitionSession: "Session",
    viewGrid: "Grid",
    gridColType: "Type",
    gridColDuration: "Duration",
    gridColLocation: "Location",
    gridColGroup: "Group",
    gridColSync: "Sync",
    gridColTeacher: "Teacher",
    gridColEval: "Assessment",
    gridColAias: "AIAS",
    gridColDesc: "Description",
    gridColInstructions: "Instructions for students",
    gridColNotes: "Notes",
    gridAddActivity: "+ Activity",
    gridAddSession: "+ Add a session",
    gridSessionPrefix: "Session"
  }
};

function currentLang() {
  return state?.meta?.uiLanguage === "en" ? "en" : "fr";
}

function t(key) {
  const lang = currentLang();
  return I18N[lang][key] || I18N.fr[key] || key;
}

function setButtonLabel(button, iconClass, text) {
  if (!button) return;
  button.innerHTML = `<span class="btn-label"><i class="${iconClass} btn-icon-inline" aria-hidden="true"></i>${escapeHtml(text)}</span>`;
}

function setSessionNotesButtonLabel(button, expanded) {
  if (!button) return;
  setButtonLabel(button, expanded ? "fa-solid fa-chevron-up" : "fa-solid fa-chevron-down", t("sessionNotes"));
}

const MARKDOWN_ACTIONS = [
  { id: "bold", text: "B", titleKey: "mdBold", code: "KeyB", shift: false, key: "B" },
  { id: "italic", text: "I", titleKey: "mdItalic", code: "KeyI", shift: false, key: "I" },
  { id: "heading", text: "H", titleKey: "mdHeading", code: "KeyH", shift: true, key: "H" },
  { id: "list", text: "-", titleKey: "mdList", code: "KeyL", shift: true, key: "L" },
  { id: "ordered-list", text: "1.", titleKey: "mdOrderedList", code: "Digit7", shift: true, key: "7" },
  { id: "quote", text: ">", titleKey: "mdQuote", code: "KeyQ", shift: true, key: "Q" },
  { id: "link", iconClass: "fa-solid fa-link", titleKey: "mdLink", code: "KeyK", shift: false, key: "K" }
];

function usesMacKeyboardShortcuts() {
  const platform = navigator.userAgentData?.platform || navigator.platform || "";
  return /Mac|iPhone|iPad|iPod/i.test(platform);
}

function markdownShortcutLabel(action) {
  const modifier = usesMacKeyboardShortcuts() ? "⌘" : "Ctrl+";
  const shift = action.shift ? (usesMacKeyboardShortcuts() ? "⇧" : "Shift+") : "";
  return `${modifier}${shift}${action.key}`;
}

function markdownAriaKeyShortcuts(action) {
  const suffix = `${action.shift ? "Shift+" : ""}${action.key}`;
  return `Meta+${suffix} Control+${suffix}`;
}

function markdownActionForKeyboardEvent(event) {
  if (event.isComposing || event.altKey || !(event.metaKey || event.ctrlKey)) return null;
  return MARKDOWN_ACTIONS.find((action) =>
    event.code === action.code && event.shiftKey === action.shift
  ) || null;
}

function handleMarkdownListEnter(textarea, event) {
  if (
    event.key !== "Enter" ||
    event.isComposing ||
    event.shiftKey ||
    event.altKey ||
    event.metaKey ||
    event.ctrlKey ||
    textarea.selectionStart !== textarea.selectionEnd
  ) return false;

  const value = textarea.value;
  const caret = textarea.selectionStart ?? value.length;
  const lineStart = value.lastIndexOf("\n", Math.max(0, caret - 1)) + 1;
  const nextLineBreak = value.indexOf("\n", caret);
  const lineEnd = nextLineBreak === -1 ? value.length : nextLineBreak;
  const currentLine = value.slice(lineStart, lineEnd);
  const beforeCaret = value.slice(lineStart, caret);
  const unordered = beforeCaret.match(/^(\s*)([-*])\s+(.*)$/);
  const ordered = beforeCaret.match(/^(\s*)(\d+)\.\s+(.*)$/);
  if (!unordered && !ordered) return false;

  event.preventDefault();
  const indent = (unordered || ordered)[1];
  const fullUnordered = currentLine.match(/^(\s*)([-*])\s*(.*)$/);
  const fullOrdered = currentLine.match(/^(\s*)(\d+)\.\s*(.*)$/);
  const fullMatch = unordered ? fullUnordered : fullOrdered;

  if (fullMatch && fullMatch[3].trim() === "") {
    const nextValue = `${value.slice(0, lineStart)}${indent}${value.slice(lineEnd)}`;
    const nextCaret = lineStart + indent.length;
    updateTextareaValue(textarea, nextValue, nextCaret);
    return true;
  }

  const marker = unordered ? unordered[2] : `${Number(ordered[2]) + 1}.`;
  const insertion = `\n${indent}${marker} `;
  const nextValue = `${value.slice(0, caret)}${insertion}${value.slice(caret)}`;
  updateTextareaValue(textarea, nextValue, caret + insertion.length);
  return true;
}

function getBoardLayout() {
  const v = state?.meta?.boardLayout;
  if (v === "list") return "list";
  if (v === "grid") return "grid";
  return "columns";
}

function setBoardLayout(layout) {
  const allowed = ["list", "columns", "grid"];
  const nextLayout = allowed.includes(layout) ? layout : "columns";
  if (getBoardLayout() === nextLayout) return;
  state.meta.boardLayout = nextLayout;
  saveState();
  render();
}

function defaultSessionTitle(index1Based) {
  return `${t("sessionPrefix")} ${index1Based}`;
}

function announce(message) {
  if (!message || !srStatus) return;
  srStatus.textContent = "";
  window.setTimeout(() => {
    srStatus.textContent = message;
  }, 10);
}

let noticeTimeoutId = 0;
function ensureNoticeHost() {
  let host = document.getElementById("app-notice-host");
  if (host) return host;
  host = document.createElement("div");
  host.id = "app-notice-host";
  host.className = "app-notice-host";
  host.setAttribute("aria-live", "polite");
  host.setAttribute("aria-atomic", "true");
  document.body.appendChild(host);
  return host;
}

function showNotice(message, kind = "info") {
  if (!message) return;
  announce(message);
  const host = ensureNoticeHost();
  const notice = document.createElement("div");
  notice.className = `app-notice app-notice-${kind}`;
  notice.textContent = message;
  host.replaceChildren(notice);
  window.clearTimeout(noticeTimeoutId);
  noticeTimeoutId = window.setTimeout(() => {
    if (host.firstChild === notice) {
      host.replaceChildren();
    }
  }, 4200);
}

function shortLabel(label) {
  return String(label || "")
    .split(/[ /-]+/)
    .filter(Boolean)[0] || String(label || "");
}

function ensureMarkdownToolbars(root = document) {
  root.querySelectorAll(".expandable-field").forEach((wrapper) => {
    if (wrapper.querySelector(".markdown-toolbar")) return;
    const textarea = wrapper.querySelector("textarea");
    if (!textarea) return;
    const toolbar = document.createElement("div");
    toolbar.className = "markdown-toolbar";
    toolbar.setAttribute("role", "toolbar");
    toolbar.setAttribute("aria-label", t("markdownToolbarLabel"));
    MARKDOWN_ACTIONS.forEach((action) => {
      const button = document.createElement("button");
      button.type = "button";
      button.className = "markdown-tool-btn";
      button.dataset.mdAction = action.id;
      if (action.iconClass) {
        const icon = document.createElement("i");
        icon.className = action.iconClass;
        icon.setAttribute("aria-hidden", "true");
        button.appendChild(icon);
      } else {
        button.textContent = action.text;
      }
      toolbar.appendChild(button);
    });
    wrapper.insertBefore(toolbar, textarea);
  });
}

function renderInlineMarkdown(value) {
  const lines = String(value || "").split("\n");
  const html = [];
  let listType = "";
  let paragraph = [];

  const inline = (text) => escapeHtml(text)
    .replace(/\*\*([^*\n]+)\*\*/g, "<strong>$1</strong>")
    .replace(/(^|[^*])\*([^*\n]+)\*/g, "$1<em>$2</em>")
    .replace(
      /\[([^\]\n]+)\]\(((?:https?:\/\/|mailto:)[^\s)<]+)\)/gi,
      '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>'
    );
  const closeParagraph = () => {
    if (!paragraph.length) return;
    html.push(`<p>${paragraph.map(inline).join("<br />")}</p>`);
    paragraph = [];
  };
  const closeList = () => {
    if (!listType) return;
    html.push(`</${listType}>`);
    listType = "";
  };
  const openList = (type) => {
    closeParagraph();
    if (listType === type) return;
    closeList();
    html.push(`<${type}>`);
    listType = type;
  };

  lines.forEach((line) => {
    const trimmed = line.trim();
    if (!trimmed) {
      closeParagraph();
      closeList();
      return;
    }

    const heading = trimmed.match(/^##\s+(.+)$/);
    if (heading) {
      closeParagraph();
      closeList();
      html.push(`<h2>${inline(heading[1])}</h2>`);
      return;
    }

    const unordered = trimmed.match(/^[-*]\s+(.+)$/);
    if (unordered) {
      openList("ul");
      html.push(`<li>${inline(unordered[1])}</li>`);
      return;
    }

    const ordered = trimmed.match(/^\d+\.\s+(.+)$/);
    if (ordered) {
      openList("ol");
      html.push(`<li>${inline(ordered[1])}</li>`);
      return;
    }

    const quote = trimmed.match(/^>\s?(.+)$/);
    if (quote) {
      closeParagraph();
      closeList();
      html.push(`<blockquote>${inline(quote[1])}</blockquote>`);
      return;
    }

    closeList();
    paragraph.push(line);
  });

  closeParagraph();
  closeList();
  return html.join("");
}

function refreshMarkdownPreview(wrapper) {
  const textarea = wrapper?.querySelector("textarea");
  const preview = wrapper?.querySelector(".markdown-preview");
  if (!textarea || !preview) return;
  const value = textarea.value || "";
  preview.innerHTML = renderInlineMarkdown(value);
  wrapper.classList.toggle("preview-active", value.trim() !== "");
}

function ensureMarkdownPreviews(root = document) {
  root.querySelectorAll(".expandable-field").forEach((wrapper) => {
    const textarea = wrapper.querySelector("textarea");
    if (!textarea) return;
    let preview = wrapper.querySelector(".markdown-preview");
    if (!preview) {
      preview = document.createElement("div");
      preview.className = "markdown-preview";
      preview.setAttribute("aria-hidden", "true");
      textarea.insertAdjacentElement("afterend", preview);
    }
    refreshMarkdownPreview(wrapper);
  });
}

const AUTO_RESIZE_SELECTOR = ".session-title, .session-objectives, .session-intentions, .activity-description, .activity-instructions, .session-notes-input, .panel-textarea, .outcome-text";

/* scrollHeight excludes the border, but these textareas are border-box, so
   assigning it directly left the last line clipped by the border width. */
function autoResizeTextarea(el) {
  el.style.height = "auto";
  const styles = getComputedStyle(el);
  const border =
    parseFloat(styles.borderTopWidth) + parseFloat(styles.borderBottomWidth);
  el.style.height = el.scrollHeight + border + "px";
}

function initAutoResizeTextareas(root = document) {
  root.querySelectorAll(AUTO_RESIZE_SELECTOR).forEach(autoResizeTextarea);
}

function migrateActivityNotesToSession(session) {
  if (!session || !Array.isArray(session.activities)) return;
  const migratedNotes = session.activities
    .map((activity, index) => {
      const note = toPlainTextareaValue(activity?.notes).trim();
      if (!note) return "";
      activity.notes = "";
      return `Activité ${index + 1}:\n${note}`;
    })
    .filter(Boolean);
  if (!migratedNotes.length) return;
  session.notes = [toPlainTextareaValue(session.notes).trim(), ...migratedNotes]
    .filter(Boolean)
    .join("\n\n");
}

function localizeExpandableFieldControls(root = document) {
  root.querySelectorAll(".markdown-toolbar").forEach((toolbar) => {
    toolbar.setAttribute("aria-label", t("markdownToolbarLabel"));
  });
  root.querySelectorAll(".markdown-tool-btn").forEach((button) => {
    const action = MARKDOWN_ACTIONS.find((item) => item.id === button.dataset.mdAction);
    if (!action) return;
    const label = t(action.titleKey);
    button.setAttribute("aria-label", label);
    button.setAttribute("title", `${label} (${markdownShortcutLabel(action)})`);
    button.setAttribute("aria-keyshortcuts", markdownAriaKeyShortcuts(action));
  });
  root.querySelectorAll(".expand-btn").forEach((button) => {
    const wrapper = button.closest(".expandable-field");
    const expanded = wrapper?.classList.contains("fullscreen");
    button.setAttribute("aria-label", expanded ? t("closeFullscreen") : t("fullscreen"));
    button.setAttribute("title", expanded ? t("closeFullscreen") : t("fullscreen"));
  });
}

function refreshLocalizedCatalogs() {
  LEARNING_TYPES.forEach((type) => {
    type.label = t(`lt_${type.id}`);
  });

  ACTIVITY_TYPE_OPTIONS.forEach((option) => {
    option.label = t(`lt_${option.value}`);
    option.short = shortLabel(option.label);
  });

  GROUP_MODE_OPTIONS.forEach((option) => {
    if (option.value === "whole") option.label = t("group_whole");
    if (option.value === "subgroups") option.label = t("group_subgroups");
    if (option.value === "individual") option.label = t("group_individual");
    option.short = shortLabel(option.label);
  });

  TRAINER_OPTIONS.forEach((option) => {
    if (option.value === "present") option.label = t("trainer_present");
    if (option.value === "absent") option.label = t("trainer_absent");
    option.short = shortLabel(option.label);
  });

  SYNC_OPTIONS.forEach((option) => {
    if (option.value === "sync") option.label = t("sync_sync");
    if (option.value === "async") option.label = t("sync_async");
    option.short = shortLabel(option.label);
  });

  LOCATION_OPTIONS.forEach((option) => {
    if (option.value === "onsite") option.label = t("modeOnsite");
    if (option.value === "online") option.label = t("modeOnline");
    if (option.value === "hybrid") option.label = t("modeHybrid");
    option.short = shortLabel(option.label);
  });

  EVAL_OPTIONS.forEach((option) => {
    if (option.value === "none") option.label = t("eval_none");
    if (option.value === "diagnostic") option.label = t("eval_diagnostic");
    if (option.value === "formative") option.label = t("eval_formative");
    if (option.value === "summative") option.label = t("eval_summative");
    if (option.value === "certificative") option.label = t("eval_certificative");
    option.short = shortLabel(option.label);
  });
}

function applyLocalizedUI() {
  refreshLocalizedCatalogs();
  document.documentElement.lang = currentLang();
  try {
    localStorage.setItem(LD_LANGUAGE_STORAGE_KEY, currentLang());
  } catch (_) {}
  document.title = t("docTitle");
  if (langSelect) langSelect.value = currentLang();
  if (languageButton) {
    const isEnglish = currentLang() === "en";
    languageButton.querySelector(".nav-language-label").textContent = isEnglish ? "EN" : "FR";
    const actionLabel = isEnglish ? "Switch to French" : "Passer en anglais";
    languageButton.setAttribute("aria-label", actionLabel);
    languageButton.setAttribute("title", actionLabel);
  }
  document.getElementById("skip-link").textContent = t("skipLink");
  document.querySelector(".toolbar").setAttribute("aria-label", t("toolbarRegion"));
  appTitle.textContent = t("appTitle");
  topTabSettings.textContent = t("tabSettings");
  topTabAnalysis.textContent = t("tabAnalysis");
  topTabChronology.textContent = t("tabChronology");
  document.getElementById("chronology-title").textContent = t("chronologyTitle");
  const partCfgTitle = document.getElementById("partition-config-modal-title");
  if (partCfgTitle) partCfgTitle.textContent = t("partitionConfigTitle");
  const partCfgDesc = document.getElementById("partition-config-modal-desc");
  if (partCfgDesc) partCfgDesc.textContent = t("partitionConfigDesc");
  const partAddSection = document.getElementById("partition-add-section-label");
  if (partAddSection) partAddSection.textContent = t("partitionAddLineSection");
  const partCfgCancel = document.getElementById("partition-config-cancel-btn");
  if (partCfgCancel) partCfgCancel.textContent = t("cancel");
  const partCfgSave = document.getElementById("partition-config-save-btn");
  if (partCfgSave) partCfgSave.textContent = t("validate");
  const partAddBtn = document.getElementById("partition-add-line-btn");
  if (partAddBtn) partAddBtn.textContent = t("partitionAdd");
  document.getElementById("new-design-modal-title").textContent = t("newDesignModalTitle");
  newDesignModalMsg.textContent = t("newDesignModalMsg");
  newDesignCancelBtn.textContent = t("cancel");
  newDesignConfirmBtn.textContent = t("newDesignModalConfirm");
  document.getElementById("analysis-title").textContent = t("analysisTitle");
  document.getElementById("label-meta-name").textContent = t("metaNameLabel");
  document.getElementById("label-meta-learning").textContent = t("metaLearningLabel");
  document.getElementById("label-meta-designed").textContent = t("metaDesignedLabel");
  document.getElementById("label-meta-day-hours").textContent = t("metaDayLabel");
  document.getElementById("label-meta-description").textContent = t("metaDescriptionLabel");
  document.getElementById("label-meta-command").textContent = t("metaCommandLabel");
  document.getElementById("label-meta-delivery").textContent = t("metaDeliveryLabel");
  document.getElementById("label-meta-size-class").textContent = t("metaSizeLabel");
  document.getElementById("label-meta-designers").textContent = t("metaDesignersLabel");
  document.getElementById("label-meta-trainers").textContent = t("metaTrainersLabel");
  document.getElementById("label-meta-personas").textContent = t("metaPersonasLabel");
  document.getElementById("label-meta-outcomes").textContent = t("outcomesLabel");
  document.getElementById("unit-learning-days").textContent = t("unitDays");
  document.getElementById("unit-learning-hours").textContent = t("unitHours");
  document.getElementById("unit-learning-minutes").textContent = t("unitMinutes");
  document.getElementById("unit-designed-days").textContent = t("unitDays");
  document.getElementById("unit-designed-hours").textContent = t("unitHours");
  document.getElementById("unit-designed-minutes").textContent = t("unitMinutes");
  document.getElementById("unit-day-hours").textContent = t("unitHours");
  document.getElementById("opt-meta-delivery-empty").textContent = "";
  document.getElementById("opt-meta-delivery-onsite").textContent = t("modeOnsite");
  document.getElementById("opt-meta-delivery-online").textContent = t("modeOnline");
  document.getElementById("opt-meta-delivery-hybrid").textContent = t("modeHybrid");
  const toggleLabel = state.topPanelCollapsed ? t("expandPanel") : t("collapsePanel");
  topPanelToggleBtn.setAttribute("aria-label", toggleLabel);
  topPanelToggleBtn.setAttribute("title", toggleLabel);
  updateResponsiveButtonLabels();
  boardLayoutToggle.setAttribute("aria-label", t("viewModeLabel"));
  boardLayoutListText.textContent = t("viewList");
  boardLayoutColumnsText.textContent = t("viewColumns");
  boardLayoutGridText.textContent = t("viewGrid");
  boardLayoutListBtn.title = t("viewList");
  boardLayoutColumnsBtn.title = t("viewColumns");
  boardLayoutGridBtn.title = t("viewGrid");
  boardLayoutListBtn.setAttribute("aria-label", t("viewList"));
  boardLayoutColumnsBtn.setAttribute("aria-label", t("viewColumns"));
  boardLayoutGridBtn.setAttribute("aria-label", t("viewGrid"));
  const activeLayout = getBoardLayout();
  boardLayoutListBtn.setAttribute("aria-pressed",    activeLayout === "list"    ? "true" : "false");
  boardLayoutColumnsBtn.setAttribute("aria-pressed", activeLayout === "columns" ? "true" : "false");
  boardLayoutGridBtn.setAttribute("aria-pressed",    activeLayout === "grid"    ? "true" : "false");
  setButtonLabel(newDesignBtn, "fa-regular fa-file", t("new"));
  setButtonLabel(importDesignBtn, "fa-solid fa-file-arrow-up", t("import"));
  setButtonLabel(exportDesignBtn, "fa-solid fa-file-export", t("export"));
  setButtonLabel(saveBtn, "fa-regular fa-floppy-disk", t("save"));
  [
    [addSessionBtn, t("addMoment")],
    [newDesignBtn, t("new")],
    [importDesignBtn, t("import")],
    [saveBtn, t("save")],
    [document.getElementById("publish-btn"), t("share")],
    [exportDesignBtn, t("export")]
  ].forEach(([button, label]) => {
    if (!button) return;
    button.setAttribute("aria-label", label);
    button.setAttribute("title", label);
  });
  infoBtn.setAttribute("aria-label", t("info"));
  infoBtn.setAttribute("title", t("info"));
  infoBtn.setAttribute("aria-haspopup", "dialog");
  const footerAboutBtn = document.getElementById("footer-about-btn");
  const footerHelpBtn = document.getElementById("footer-help-btn");
  if (footerAboutBtn) footerAboutBtn.textContent = t("infoTitle");
  if (footerHelpBtn) footerHelpBtn.textContent = t("footerHelp");
  importDesignBtn.setAttribute("aria-haspopup", "dialog");
  const importModalTitle = document.getElementById("import-modal-title");
  if (importModalTitle) importModalTitle.textContent = t("importTitle");
  const importModalDesc = document.getElementById("import-modal-desc");
  if (importModalDesc) importModalDesc.textContent = t("importModalDesc");
  const importFileSectionTitle = document.getElementById("import-file-section-title");
  if (importFileSectionTitle) importFileSectionTitle.textContent = t("importFromFileTitle");
  const importModelsSectionTitle = document.getElementById("import-models-section-title");
  if (importModelsSectionTitle) importModelsSectionTitle.textContent = t("importModelsTitle");
  const importFileFormats = document.getElementById("import-file-formats");
  if (importFileFormats) importFileFormats.textContent = t("importFileFormats");
  const importModelsSearchLabel = document.getElementById("import-models-search-label");
  if (importModelsSearchLabel) importModelsSearchLabel.textContent = t("importModelsSearchLabel");
  const importModelsFamilyLabel = document.getElementById("import-models-family-label");
  if (importModelsFamilyLabel) importModelsFamilyLabel.textContent = t("importModelsFamilyLabel");
  if (importModelsSearch) importModelsSearch.placeholder = t("importModelsSearchPlaceholder");
  if (importModelsLink) importModelsLink.textContent = t("importModelsLink");
  if (importModalCancelBtn) importModalCancelBtn.textContent = t("close");
  if (importFileBtn) setButtonLabel(importFileBtn, "fa-solid fa-folder-open", t("importChooseFile"));
  if (importModalBackdrop && !importModalBackdrop.classList.contains("hidden")) {
    renderModelFamilyOptions();
    renderModelList();
  }
  exportDesignBtn.setAttribute("aria-haspopup", "dialog");
  board.setAttribute("aria-label", t("boardRegion"));
  metaCommandInput.placeholder = t("commandPlaceholder");
  metaPersonasInput.placeholder = t("personasPlaceholder");
  metaLearningDaysInput.setAttribute("aria-label", t("learningDaysLabel"));
  metaLearningHoursInput.setAttribute("aria-label", t("learningHoursLabel"));
  metaLearningMinutesInput.setAttribute("aria-label", t("learningMinutesLabel"));
  metaDesignedDaysInput.setAttribute("aria-label", t("designedDaysLabel"));
  metaDesignedHoursInput.setAttribute("aria-label", t("designedHoursLabel"));
  metaDesignedMinutesInput.setAttribute("aria-label", t("designedMinutesLabel"));
  const exportScopeFullTitle = exportScopeFullInput?.closest(".export-scope-option")?.querySelector(".export-scope-option-title");
  const exportScopeStudentsTitle = exportScopeStudentsInput?.closest(".export-scope-option")?.querySelector(".export-scope-option-title");
  const exportScopeFullDescription = document.getElementById("export-scope-full-description");
  const exportScopeStudentsDescription = document.getElementById("export-scope-students-description");
  if (exportScopeLabel) exportScopeLabel.textContent = t("exportScopeTitle");
  if (exportScopeFullTitle) exportScopeFullTitle.textContent = t("exportScopeFull");
  if (exportScopeStudentsTitle) exportScopeStudentsTitle.textContent = t("exportScopeStudents");
  if (exportScopeFullDescription) exportScopeFullDescription.textContent = t("exportScopeFullDescription");
  if (exportScopeStudentsDescription) exportScopeStudentsDescription.textContent = t("exportScopeStudentsDescription");
  if (exportMomentsLabel) exportMomentsLabel.textContent = t("exportMomentsTitle");
  if (exportMomentsAllLabel) exportMomentsAllLabel.textContent = t("exportMomentsAll");
  if (exportMomentsEmpty) exportMomentsEmpty.textContent = t("exportMomentsEmpty");
  renderExportMoments();
  exportModalBackdrop.querySelector("#export-modal-title").textContent = t("exportTitle");
  exportModalBackdrop.querySelector("label[for='export-format-select']").textContent = t("format");
  exportModalBackdrop.querySelector("label[for='export-filename-input']").textContent = t("exportFilename");
  const exportPreviewCopy = document.getElementById("export-result-modal-copy");
  if (exportPreviewCopy) exportPreviewCopy.textContent = t("exportPreviewCopy");
  if (exportPreviewLabel) exportPreviewLabel.textContent = t("exportPreviewTitle");
  if (exportResultCopyBtn) exportResultCopyBtn.textContent = t("copy");
  exportModalCancelBtn.textContent = t("close");
  exportModalConfirmBtn.textContent = t("download");
  const activityLinkTitle = document.getElementById("activity-link-modal-title");
  if (activityLinkTitle) activityLinkTitle.textContent = t("activityLinksTitle");
  const activityLinkTitleLabel = document.getElementById("activity-link-title-label");
  if (activityLinkTitleLabel) activityLinkTitleLabel.textContent = t("activityLinkTitleLabel");
  const activityLinkUrlLabel = document.getElementById("activity-link-url-label");
  if (activityLinkUrlLabel) activityLinkUrlLabel.textContent = t("activityLinkUrlLabel");
  if (activityLinkTitleInput) activityLinkTitleInput.placeholder = t("activityLinkTitleLabel");
  if (activityLinkUrlInput) activityLinkUrlInput.placeholder = "https://…";
  if (activityLinkList) activityLinkList.dataset.empty = t("activityLinkEmpty");
  if (activityLinkCancelBtn) activityLinkCancelBtn.textContent = t("close");
  if (activityLinkSaveBtn) activityLinkSaveBtn.textContent = t("activityLinkAdd");
  if (aiasModalTitle) aiasModalTitle.textContent = t("aiasFieldLabel");
  if (aiasModalIntro) aiasModalIntro.textContent = t("aiasPanelIntro");
  if (aiasModalLevels) aiasModalLevels.setAttribute("aria-label", t("aiasLevelsAriaLabel"));
  if (aiasModalAttributionPrefix) aiasModalAttributionPrefix.textContent = t("aiasAttributionPrefix");
  if (aiasModalCloseBtn) aiasModalCloseBtn.textContent = t("close");
  document.getElementById("info-modal-title").textContent = t("infoTitle");
  document.getElementById("info-modal-p1").textContent = t("infoP1");
  document.getElementById("info-modal-p2").textContent = t("infoP2");
  document.getElementById("info-modal-p3").textContent = t("infoP3");
  document.getElementById("info-modal-p4").innerHTML = t("infoP4");
  document.getElementById("info-modal-p5").innerHTML = t("infoP5");
  infoModalCloseBtn.textContent = t("close");
  const langLabel = t("uiLanguage");
  document.querySelector("label[for='lang-select']").textContent = langLabel;
  if (langSelect) {
    langSelect.setAttribute("aria-label", langLabel);
    langSelect.dataset.tooltip = langLabel;
  }
  document.querySelector(".nav-language-switch")?.setAttribute("aria-label", langLabel);
  document.querySelectorAll(".duration-unit").forEach((unit) => {
    unit.textContent = "min";
  });
  document.querySelectorAll(".session-notes-input").forEach((input) => {
    input.placeholder = t("sessionNotesPlaceholder");
  });
  document.querySelectorAll(".session-objectives").forEach((input) => {
    input.placeholder = t("sessionObjectivesPlaceholder");
  });
  document.querySelectorAll(".session-intentions").forEach((input) => {
    input.placeholder = t("sessionIntentionsPlaceholder");
  });
  document.querySelectorAll(".activity-duration-sr-label").forEach((label) => {
    label.textContent = t("durationMinutesSr");
  });
  topPanel.querySelector(".top-tabs").setAttribute(
    "aria-label",
    currentLang() === "en" ? "Top panel views" : "Vues du panneau supérieur"
  );
  localizeExpandableFieldControls();
}

document.addEventListener("site-footer-ready", () => {
  const footerAboutBtn = document.getElementById("footer-about-btn");
  const footerHelpBtn = document.getElementById("footer-help-btn");
  if (footerAboutBtn) footerAboutBtn.textContent = t("infoTitle");
  if (footerHelpBtn) footerHelpBtn.textContent = t("footerHelp");
});

function updateResponsiveButtonLabels() {
  const compactToolbar = window.innerWidth <= 640;
  setButtonLabel(addSessionBtn, "fa-solid fa-plus", compactToolbar ? t("addMomentCompact") : t("addMoment"));
}

function hydrateState(parsed, fallback = defaultState()) {
  if (!parsed || !Array.isArray(parsed.sessions)) return fallback;
  const parsedMeta = parsed.meta || {};

  const hydrated = {
    allNotesExpanded: Boolean(parsed.allNotesExpanded),
    intentionsCollapsed: Boolean(parsed.intentionsCollapsed),
    topPanelCollapsed: Object.prototype.hasOwnProperty.call(parsed, "topPanelCollapsed")
      ? Boolean(parsed.topPanelCollapsed)
      : true,
    meta: {
      ...DEFAULT_META,
      ...parsedMeta,
      designers:
        typeof parsedMeta.designers === "string"
          ? parsedMeta.designers
          : typeof parsedMeta.author === "string"
            ? parsedMeta.author
            : "",
      trainers: typeof parsedMeta.trainers === "string" ? parsedMeta.trainers : "",
      sliders: Array.isArray(parsedMeta.sliders)
        ? parsedMeta.sliders
        : typeof parsedMeta.sliders === "string" && parsedMeta.sliders.trim()
          ? [{ id: nextId(), category: "", categoryLabel: "", verb: "", text: parsedMeta.sliders }]
          : []
    },
    partitionLineConfig: Array.isArray(parsed.partitionLineConfig)
      ? parsed.partitionLineConfig
      : defaultPartitionLineConfig(),
    sessions: parsed.sessions.map((session) => ({
      id: session?.id || nextId(),
      title: toPlainTextareaValue(session?.title).trim(),
      objectives: toPlainTextareaValue(session?.objectives),
      intentions: toPlainTextareaValue(session?.intentions),
      notes: toPlainTextareaValue(session?.notes),
      notesExpanded: Boolean(session?.notesExpanded),
      activities: Array.isArray(session?.activities)
        ? session.activities.map((activity) => {
            const normalized = {
              id: activity?.id || nextId(),
              type: activity?.type || "undefined",
              duration: Math.max(1, Number(activity?.duration) || 1),
              groupMode: activity?.groupMode,
              teacherPresence: activity?.teacherPresence,
              syncMode: activity?.syncMode,
              locationMode: activity?.locationMode,
              evaluationMode: activity?.evaluationMode,
              aias: normalizeAiasState(activity?.aias ?? activity?.aiasLevel),
              description: toPlainTextareaValue(activity?.description),
              instructions: toPlainTextareaValue(activity?.instructions),
              notes: toPlainTextareaValue(activity?.notes),
              tools: Array.isArray(activity?.tools) ? activity.tools : [],
              links: Array.isArray(activity?.links) ? activity.links : []
            };
            normalizeActivity(normalized);
            return normalized;
          })
        : []
    }))
  };

  hydrated.meta.dayHours = Math.max(1, Number(hydrated.meta.dayHours) || DEFAULT_DAY_HOURS);
  hydrated.sessions.forEach(migrateActivityNotesToSession);
  const normalizedLearning = normalizePedagogicalTime(
    hydrated.meta.learningDays,
    hydrated.meta.learningHours,
    hydrated.meta.learningMinutes,
    hydrated.meta.dayHours
  );
  hydrated.meta.learningDays = normalizedLearning.days;
  hydrated.meta.learningHours = normalizedLearning.hours;
  hydrated.meta.learningMinutes = normalizedLearning.minutes;
  hydrated.meta.sizeClass =
    String(hydrated.meta.sizeClass ?? "").trim() === ""
      ? ""
      : Math.max(1, Number(hydrated.meta.sizeClass) || 1);
  if (!["fr", "en"].includes(hydrated.meta.uiLanguage)) hydrated.meta.uiLanguage = "fr";

  if (hydrated.meta.modeDelivery === "classroom") hydrated.meta.modeDelivery = "onsite";
  if (hydrated.meta.modeDelivery === "blended") hydrated.meta.modeDelivery = "hybrid";
  if (!["", "onsite", "online", "hybrid"].includes(hydrated.meta.modeDelivery)) {
    hydrated.meta.modeDelivery = "";
  }
  if (hydrated.meta.activeTab === "timeline") hydrated.meta.activeTab = "settings";
  if (!["settings", "analysis", "chronology"].includes(hydrated.meta.activeTab)) {
    hydrated.meta.activeTab = "settings";
  }
  if (!["columns", "list", "grid"].includes(hydrated.meta.boardLayout)) {
    hydrated.meta.boardLayout = "columns";
  }

  return hydrated;
}

function createNewDesignState() {
  return {
    allNotesExpanded: false,
    intentionsCollapsed: false,
    topPanelCollapsed: true,
    meta: {
      ...DEFAULT_META,
      sliders: [],
      uiLanguage: preferredInterfaceLanguage(currentLang())
    },
    sessions: [],
    partitionLineConfig: defaultPartitionLineConfig()
  };
}

let localStateSaveTimer = 0;
let localStateSavePending = false;

function persistStateNow() {
  if (!localStateSavePending) return;
  window.clearTimeout(localStateSaveTimer);
  localStateSaveTimer = 0;
  localStateSavePending = false;
  if (!activeStorageKey) return;
  try {
    localStorage.setItem(activeStorageKey, JSON.stringify(state));
  } catch (_) {}
}

function initializeStorageScope(userId = null) {
  const numericUserId = Number(userId);
  const scope = Number.isInteger(numericUserId) && numericUserId > 0
    ? `user_${numericUserId}`
    : "guest";
  const nextStorageKey = `${LD_STORAGE_KEY_PREFIX}${scope}`;
  if (storageScopeReady && activeStorageKey === nextStorageKey) return;

  persistStateNow();
  activeStorageKey = nextStorageKey;
  storageScopeReady = true;

  let scopedState = createNewDesignState();
  try {
    const raw = localStorage.getItem(activeStorageKey);
    if (raw) scopedState = hydrateState(JSON.parse(raw), scopedState);
  } catch (_) {}
  scopedState.meta.uiLanguage = preferredInterfaceLanguage(scopedState.meta.uiLanguage);
  state = scopedState;
  render();
  void maybeApplyRequestedModel();
}

function saveState() {
  localStateSavePending = true;
  window.clearTimeout(localStateSaveTimer);
  localStateSaveTimer = window.setTimeout(persistStateNow, 300);
  window.dispatchEvent(new CustomEvent("ld:statechange"));
}

window.addEventListener("beforeunload", persistStateNow);
window.addEventListener("pagehide", persistStateNow);
document.addEventListener("visibilitychange", () => {
  if (document.visibilityState === "hidden") persistStateNow();
});

// --- Outcomes (Acquis d'apprentissage) ---

let bloomModalMode = "add";
let bloomEditOutcomeId = null;
let bloomSelectedCategory = null;
let bloomSelectedVerb = null;

function renderOutcomes() {
  if (!outcomesListEl) return;
  const outcomes = Array.isArray(state.meta.sliders) ? state.meta.sliders : [];
  outcomesListEl.innerHTML = "";
  outcomes.forEach((outcome) => {
    const item = document.createElement("div");
    item.className = "outcome-item";
    item.dataset.id = outcome.id;

    const header = document.createElement("div");
    header.className = "outcome-item-header";

    const verbBtn = document.createElement("button");
    verbBtn.className = "outcome-verb-btn";
    verbBtn.type = "button";
    verbBtn.title = t("changeVerb");
    verbBtn.setAttribute("aria-label", t("changeVerb"));
    const verbLabel = outcome.verb || outcome.categoryLabel || "—";
    verbBtn.innerHTML = `<span class="outcome-verb-text">${escapeHtml(verbLabel)}</span><span class="outcome-verb-edit" aria-hidden="true">✎</span>`;
    verbBtn.addEventListener("click", () => openBloomModal("edit", outcome.id));

    const deleteBtn = document.createElement("button");
    deleteBtn.className = "icon-btn delete-btn outcome-delete-btn";
    deleteBtn.type = "button";
    deleteBtn.setAttribute("aria-label", t("deleteOutcome"));
    deleteBtn.innerHTML = `<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12"></path><path d="M18 6l-12 12"></path></svg>`;
    deleteBtn.addEventListener("click", () => {
      state.meta.sliders = state.meta.sliders.filter((o) => o.id !== outcome.id);
      saveState();
      renderOutcomes();
    });

    header.appendChild(verbBtn);
    header.appendChild(deleteBtn);

    const textarea = document.createElement("textarea");
    textarea.className = "outcome-text panel-textarea";
    textarea.rows = 1;
    textarea.placeholder = t("outcomeTextPlaceholder");
    textarea.value = outcome.text || "";
    textarea.addEventListener("input", () => {
      const found = (Array.isArray(state.meta.sliders) ? state.meta.sliders : []).find((o) => o.id === outcome.id);
      if (found) found.text = textarea.value;
      saveState();
    });

    item.appendChild(header);
    item.appendChild(textarea);
    outcomesListEl.appendChild(item);
  });
}

function renderBloomModal() {
  if (!bloomCategoryList) return;
  bloomCategoryList.innerHTML = "";
  const taxonomy = BLOOM_TAXONOMY[currentLang()] || BLOOM_TAXONOMY.fr;

  taxonomy.forEach((cat) => {
    const details = document.createElement("details");
    details.className = "bloom-category";
    if (bloomSelectedCategory === cat.id) details.open = true;

    const summary = document.createElement("summary");
    summary.className = "bloom-category-summary";
    if (bloomSelectedCategory === cat.id && !bloomSelectedVerb) {
      summary.classList.add("selected");
    }
    summary.textContent = cat.label;
    summary.addEventListener("click", () => {
      bloomSelectedCategory = cat.id;
      bloomSelectedVerb = null;
      bloomCategoryList.querySelectorAll(".bloom-category-summary, .bloom-verb-item").forEach((el) => el.classList.remove("selected"));
      summary.classList.add("selected");
    });

    details.appendChild(summary);

    cat.verbs.forEach((verb) => {
      const verbItem = document.createElement("div");
      verbItem.className = "bloom-verb-item";
      if (bloomSelectedVerb === verb && bloomSelectedCategory === cat.id) {
        verbItem.classList.add("selected");
      }
      verbItem.textContent = verb;
      verbItem.addEventListener("click", () => {
        bloomSelectedCategory = cat.id;
        bloomSelectedVerb = verb;
        bloomCategoryList.querySelectorAll(".bloom-category-summary, .bloom-verb-item").forEach((el) => el.classList.remove("selected"));
        verbItem.classList.add("selected");
      });
      details.appendChild(verbItem);
    });

    bloomCategoryList.appendChild(details);
  });
}

function openBloomModal(mode, outcomeId = null) {
  bloomModalMode = mode;
  bloomEditOutcomeId = outcomeId;

  if (mode === "edit" && outcomeId) {
    const outcome = (Array.isArray(state.meta.sliders) ? state.meta.sliders : []).find((o) => o.id === outcomeId);
    bloomSelectedCategory = outcome?.category || null;
    bloomSelectedVerb = outcome?.verb || null;
  } else {
    bloomSelectedCategory = null;
    bloomSelectedVerb = null;
  }

  if (bloomAddBtn) bloomAddBtn.textContent = mode === "edit" ? t("bloomEdit") : t("bloomAdd");
  renderBloomModal();
  openModal(bloomModalBackdrop, "#bloom-cancel-btn");
}

function confirmBloom() {
  if (!bloomSelectedCategory) return;
  const taxonomy = BLOOM_TAXONOMY[currentLang()] || BLOOM_TAXONOMY.fr;
  const cat = taxonomy.find((c) => c.id === bloomSelectedCategory);
  const categoryLabel = cat?.label || "";

  if (bloomModalMode === "add") {
    if (!Array.isArray(state.meta.sliders)) state.meta.sliders = [];
    state.meta.sliders.push({
      id: nextId(),
      category: bloomSelectedCategory,
      categoryLabel,
      verb: bloomSelectedVerb || "",
      text: ""
    });
  } else if (bloomModalMode === "edit" && bloomEditOutcomeId) {
    const outcome = (Array.isArray(state.meta.sliders) ? state.meta.sliders : []).find((o) => o.id === bloomEditOutcomeId);
    if (outcome) {
      outcome.category = bloomSelectedCategory;
      outcome.categoryLabel = categoryLabel;
      outcome.verb = bloomSelectedVerb || "";
    }
  }

  saveState();
  closeModal(bloomModalBackdrop);
  renderOutcomes();
}

function setupFormAccessibility() {
  document.addEventListener(
    "invalid",
    (event) => {
      const field = event.target;
      if (!(field instanceof HTMLInputElement || field instanceof HTMLTextAreaElement || field instanceof HTMLSelectElement)) {
        return;
      }
      field.setAttribute("aria-invalid", "true");
      announce(field.validationMessage || "Valeur invalide");
    },
    true
  );

  document.addEventListener("input", (event) => {
    const field = event.target;
    if (!(field instanceof HTMLInputElement || field instanceof HTMLTextAreaElement || field instanceof HTMLSelectElement)) {
      return;
    }
    if (field.validity.valid) {
      field.removeAttribute("aria-invalid");
    }
    if (field instanceof HTMLTextAreaElement && field.matches(AUTO_RESIZE_SELECTOR)) {
      autoResizeTextarea(field);
    }
  });
}

function colorForType(typeId) {
  return LEARNING_TYPES.find((t) => t.id === typeId)?.color || "#999";
}

function getOption(options, value) {
  return options.find((opt) => opt.value === value) || options[0];
}

function setChoiceButton(button, options, value) {
  const option = getOption(options, value);
  const groupTitle = button.dataset.groupTitle || "";
  button.dataset.value = option.value;
  // Icon is static trusted SVG; label is set via textContent to prevent future injection.
  button.innerHTML = option.icon;
  const labelSpan = document.createElement("span");
  labelSpan.className = "choice-label";
  labelSpan.textContent = option.label;
  button.appendChild(labelSpan);
  const accessibleLabel = groupTitle ? `${groupTitle}: ${option.label}` : option.label;
  button.title = accessibleLabel;
  button.setAttribute("aria-label", accessibleLabel);
  button.setAttribute("aria-haspopup", "listbox");
  button.setAttribute("aria-expanded", "false");
}

let activeChoiceMenu = null;
let activeChoiceTrigger = null;
let activeChoiceItems = [];
let activeChoiceIndex = -1;

let activeToolPicker = null;
let activeToolPickerTrigger = null;
let activeToolPickerTab = TOOL_PICKER_TABS[0]?.id || "acquerir";

function focusChoiceItem(index) {
  if (!activeChoiceItems.length) return;
  const safeIndex = Math.max(0, Math.min(index, activeChoiceItems.length - 1));
  activeChoiceItems[safeIndex].focus();
  activeChoiceIndex = safeIndex;
}

function closeChoiceMenu(restoreFocus = false) {
  if (!activeChoiceMenu) return;
  activeChoiceMenu.remove();
  if (activeChoiceTrigger) {
    activeChoiceTrigger.classList.remove("open");
    activeChoiceTrigger.setAttribute("aria-expanded", "false");
    activeChoiceTrigger.removeAttribute("aria-controls");
    if (restoreFocus) activeChoiceTrigger.focus();
  }
  activeChoiceMenu = null;
  activeChoiceTrigger = null;
  activeChoiceItems = [];
  activeChoiceIndex = -1;
}


function closeToolPicker(restoreFocus = false) {
  if (!activeToolPicker) return;
  if (activeToolPicker._backdrop) activeToolPicker._backdrop.remove();
  activeToolPicker.remove();
  if (activeToolPickerTrigger) {
    activeToolPickerTrigger.setAttribute("aria-expanded", "false");
    if (restoreFocus) activeToolPickerTrigger.focus();
  }
  activeToolPicker = null;
  activeToolPickerTrigger = null;
}

function renderPickerBody(body, platform, activity) {
  body.innerHTML = "";
  const lang = currentLang();
  const categories = Object.keys(SELECTABLE_TOOL_CATEGORY_LABELS).filter(cat => cat.startsWith(platform));
  categories.forEach(categoryKey => {
    const categoryTitle = SELECTABLE_TOOL_CATEGORY_LABELS[categoryKey][lang];
    const tools = SELECTABLE_TOOLS_DATA.filter(tool => tool.category === categoryKey);
    if (categoryTitle) {
      const sectionTitle = document.createElement("div");
      sectionTitle.className = "tool-picker-section-title";
      sectionTitle.setAttribute("aria-hidden", "true");
      sectionTitle.textContent = categoryTitle;
      applyCompetencyTheme(sectionTitle, platform);
      body.appendChild(sectionTitle);
    }
    tools.forEach(tool => {
      const item = document.createElement("button");
      item.type = "button";
      item.className = "tool-picker-item";
      item.dataset.level = tool.platform;
      item.dataset.tooltip = competencyTooltip(tool, lang);
      applyCompetencyTheme(item, tool.platform);
      const isSelected = activity.tools.includes(tool.id);
      if (isSelected) item.classList.add("selected");
      const checkBox = document.createElement("span");
      checkBox.className = "tool-picker-item-check";
      checkBox.setAttribute("aria-hidden", "true");
      checkBox.textContent = isSelected ? "✓" : "";
      const nameEl = document.createElement("span");
      nameEl.className = "tool-picker-item-name";
      nameEl.textContent = formatCompetencyLabel(tool, lang);
      const textWrapper = document.createElement("span");
      textWrapper.className = "tool-picker-item-text";
      textWrapper.appendChild(nameEl);
      const appLabel = lang === "en" ? tool.appEn : tool.appFr;
      const desc = lang === "en" ? tool.descEn : tool.descFr;
      const helperText = [appLabel ? `${lang === "en" ? "App" : "App"}: ${appLabel}` : "", desc]
        .filter(Boolean)
        .join(" — ");
      if (helperText) {
        const descEl = document.createElement("span");
        descEl.className = "tool-picker-item-desc";
        descEl.textContent = `(${helperText})`;
        textWrapper.appendChild(descEl);
      }
      item.appendChild(checkBox);
      item.appendChild(textWrapper);
      item.addEventListener("click", () => {
        if (activity.tools.includes(tool.id)) {
          activity.tools = activity.tools.filter(id => id !== tool.id);
        } else {
          activity.tools = [...activity.tools, tool.id];
        }
        saveState();
        const nowSelected = activity.tools.includes(tool.id);
        item.classList.toggle("selected", nowSelected);
        checkBox.textContent = nowSelected ? "✓" : "";
        updateActivityToolsDisplay(activeToolPickerTrigger, activity);
      });
      body.appendChild(item);
    });
  });
}

function filterPickerItems(body, term) {
  body.querySelectorAll(".tool-picker-item").forEach(item => {
    const name = (item.querySelector(".tool-picker-item-name")?.textContent || "").toLowerCase();
    const desc = (item.querySelector(".tool-picker-item-desc")?.textContent || "").toLowerCase();
    item.style.display = (!term || name.includes(term) || desc.includes(term)) ? "" : "none";
  });
  body.querySelectorAll(".tool-picker-section-title").forEach(title => {
    let next = title.nextElementSibling;
    let hasVisible = false;
    while (next && !next.classList.contains("tool-picker-section-title")) {
      if (next.style.display !== "none") hasVisible = true;
      next = next.nextElementSibling;
    }
    title.style.display = hasVisible ? "" : "none";
  });
}

function switchPickerTab(platform, body, activity) {
  activeToolPickerTab = platform;
  activeToolPicker.querySelectorAll(".tool-picker-tab").forEach(tab => {
    const isActive = tab.dataset.platform === platform;
    tab.classList.toggle("active", isActive);
  });
  const searchInput = activeToolPicker.querySelector(".tool-picker-search-input");
  if (searchInput) searchInput.value = "";
  renderPickerBody(body, platform, activity);
}

function openToolPicker(trigger, activity) {
  if (activeToolPicker && activeToolPickerTrigger === trigger) {
    closeToolPicker(true);
    return;
  }
  closeToolPicker();
  closeChoiceMenu();
  if (!TOOL_PICKER_TABS.some((tab) => tab.id === activeToolPickerTab)) {
    activeToolPickerTab = TOOL_PICKER_TABS[0]?.id || "acquerir";
  }

  const panel = document.createElement("div");
  panel.className = "tool-picker";
  panel.setAttribute("role", "dialog");
  panel.setAttribute("aria-modal", "false");
  panel.setAttribute("aria-labelledby", "tool-picker-title");

  const header = document.createElement("div");
  header.className = "tool-picker-header";
  const titleEl = document.createElement("h2");
  titleEl.id = "tool-picker-title";
  titleEl.className = "modal-title";
  titleEl.textContent = t("toolPickerTitle");
  const closeBtn = document.createElement("button");
  closeBtn.type = "button";
  closeBtn.className = "tool-picker-close";
  closeBtn.textContent = "✕";
  closeBtn.setAttribute("aria-label", t("toolPickerClose"));
  closeBtn.addEventListener("click", () => closeToolPicker(true));
  header.appendChild(titleEl);
  header.appendChild(closeBtn);
  panel.appendChild(header);

  const tabsRow = document.createElement("div");
  tabsRow.className = "tool-picker-tabs";
  tabsRow.setAttribute("role", "tablist");
  const body = document.createElement("div");
  body.className = "tool-picker-body";

  const lang = currentLang();
  TOOL_PICKER_TABS.forEach(({ id, labelFr, labelEn }) => {
    const tab = document.createElement("button");
    tab.type = "button";
    tab.className = "tool-picker-tab" + (id === activeToolPickerTab ? " active" : "");
    tab.dataset.platform = id;
    tab.dataset.level = id;
    applyCompetencyTheme(tab, id);
    tab.textContent = lang === "en" ? labelEn : labelFr;
    tab.setAttribute("role", "tab");
    tab.addEventListener("click", () => switchPickerTab(id, body, activity));
    tabsRow.appendChild(tab);
  });

  panel.appendChild(tabsRow);

  const searchRow = document.createElement("div");
  searchRow.className = "tool-picker-search";
  const searchInput = document.createElement("input");
  searchInput.type = "search";
  searchInput.className = "tool-picker-search-input";
  searchInput.placeholder = lang === "en" ? "Search…" : "Rechercher…";
  searchInput.setAttribute("aria-label", lang === "en" ? "Search competencies" : "Rechercher des compétences");
  searchInput.addEventListener("input", () => {
    filterPickerItems(body, searchInput.value.trim().toLowerCase());
  });
  searchRow.appendChild(searchInput);
  panel.appendChild(searchRow);

  renderPickerBody(body, activeToolPickerTab, activity);
  panel.appendChild(body);

  panel.addEventListener("keydown", (event) => {
    if (event.key === "Escape") { closeToolPicker(true); return; }
    if (event.key === "ArrowDown" || event.key === "ArrowUp") {
      event.preventDefault();
      const items = Array.from(body.querySelectorAll(".tool-picker-item"));
      const idx = items.indexOf(document.activeElement);
      if (idx === -1) { items[0]?.focus(); return; }
      const next = event.key === "ArrowDown"
        ? (idx + 1) % items.length
        : (idx - 1 + items.length) % items.length;
      items[next].focus();
    }
    if (event.key === "Tab") {
      const focusables = Array.from(panel.querySelectorAll("button:not([disabled])"));
      if (!focusables.length) return;
      const first = focusables[0];
      const last = focusables[focusables.length - 1];
      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault(); last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault(); first.focus();
      }
    }
  });

  const backdrop = document.createElement("div");
  backdrop.className = "tool-picker-backdrop";
  backdrop.addEventListener("click", () => closeToolPicker(true));
  document.body.appendChild(backdrop);
  panel._backdrop = backdrop;
  document.body.appendChild(panel);
  panel.setAttribute("aria-modal", "true");
  activeToolPicker = panel;
  activeToolPickerTrigger = trigger;
  trigger.setAttribute("aria-expanded", "true");
  body.querySelector(".tool-picker-item")?.focus();
}

function updateActivityToolsDisplay(trigger, activity) {
  if (!trigger) return;
  const card = trigger.closest(".activity-card");
  if (!card) return;
  const count = activity.tools.length;
  trigger.dataset.count = count;
  trigger.classList.toggle("has-tools", count > 0);
  const label = t("selectTools");
  trigger.setAttribute("aria-label", label);
  trigger.title = label;
  const toolsRow = card.querySelector(".activity-tools");
  if (!toolsRow) return;
  toolsRow.classList.toggle("hidden", count === 0);
  toolsRow.setAttribute("aria-label", t("toolsAriaLabel"));
  toolsRow.innerHTML = "";
  const lang = currentLang();
  activity.tools.forEach(toolId => {
    const toolDef = SELECTABLE_TOOLS_DATA.find(td => td.id === toolId);
    if (!toolDef) return;
    const chip = document.createElement("span");
    chip.className = "tool-chip";
    chip.dataset.level = toolDef.platform;
    chip.dataset.tooltip = competencyTooltip(toolDef, lang);
    chip.setAttribute("role", "listitem");
    applyCompetencyTheme(chip, toolDef.platform);
    const nameEl = document.createElement("span");
    nameEl.className = "tool-chip-name";
    const label = lang === "en" ? toolDef.labelEn : toolDef.labelFr;
    nameEl.textContent = toolDef.shortCode;
    const removeBtn = document.createElement("button");
    removeBtn.type = "button";
    removeBtn.className = "tool-chip-remove";
    removeBtn.setAttribute("aria-label", t("removeToolAriaLabel")(label));
    removeBtn.textContent = "×";
    removeBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      activity.tools = activity.tools.filter(id => id !== toolId);
      saveState();
      updateActivityToolsDisplay(trigger, activity);
      if (activeToolPicker && activeToolPickerTrigger === trigger) {
        renderPickerBody(activeToolPicker.querySelector(".tool-picker-body"), activeToolPickerTab, activity);
      }
    });
    chip.appendChild(nameEl);
    chip.appendChild(removeBtn);
    toolsRow.appendChild(chip);
  });
}

function updateActivityLinksDisplay(trigger, activity) {
  if (!trigger) return;
  const card = trigger.closest(".activity-card");
  if (!card) return;
  const count = Array.isArray(activity.links) ? activity.links.length : 0;
  trigger.dataset.count = count;
  trigger.classList.toggle("has-links", count > 0);
  trigger.setAttribute("aria-label", count > 0
    ? `${t("manageLinks")} (${t("activityLinkCount")(count)})`
    : t("manageLinks"));
  const linksRow = card.querySelector(".activity-links");
  if (!linksRow) return;
  linksRow.classList.toggle("hidden", count === 0);
  linksRow.setAttribute("aria-label", t("activityLinksTitle"));
  linksRow.innerHTML = "";
  (activity.links || []).forEach((link) => {
    const chip = document.createElement("span");
    chip.className = "activity-link-chip";
    chip.setAttribute("role", "listitem");
    const anchor = document.createElement("a");
    anchor.className = "activity-link-chip-anchor";
    anchor.href = link.url;
    anchor.target = "_blank";
    anchor.rel = "noopener noreferrer";
    anchor.textContent = link.title;
    const removeBtn = document.createElement("button");
    removeBtn.type = "button";
    removeBtn.className = "activity-link-chip-remove";
    removeBtn.setAttribute("aria-label", t("removeLinkAriaLabel")(link.title));
    removeBtn.textContent = "×";
    removeBtn.addEventListener("click", (event) => {
      event.stopPropagation();
      activity.links = (activity.links || []).filter((item) => item.id !== link.id);
      saveState();
      updateActivityLinksDisplay(trigger, activity);
      if (activeActivityLinkActivity === activity) {
        renderActivityLinkList(activity);
      }
    });
    chip.appendChild(anchor);
    chip.appendChild(removeBtn);
    linksRow.appendChild(chip);
  });
}

function renderActivityLinkList(activity) {
  if (!activityLinkList) return;
  activityLinkList.innerHTML = "";
  activityLinkList.dataset.empty = t("activityLinkEmpty");
  (activity.links || []).forEach((link) => {
    const item = document.createElement("div");
    item.className = "activity-link-list-item";
    item.setAttribute("role", "listitem");
    const main = document.createElement("div");
    main.className = "activity-link-list-main";
    const anchor = document.createElement("a");
    anchor.className = "activity-link-list-title";
    anchor.href = link.url;
    anchor.target = "_blank";
    anchor.rel = "noopener noreferrer";
    anchor.textContent = link.title;
    const url = document.createElement("div");
    url.className = "activity-link-list-url";
    url.textContent = link.url;
    main.appendChild(anchor);
    main.appendChild(url);
    const removeBtn = document.createElement("button");
    removeBtn.type = "button";
    removeBtn.className = "btn btn-light";
    removeBtn.textContent = "×";
    removeBtn.setAttribute("aria-label", t("removeLinkAriaLabel")(link.title));
    removeBtn.addEventListener("click", () => {
      activity.links = (activity.links || []).filter((item) => item.id !== link.id);
      saveState();
      renderActivityLinkList(activity);
      updateActivityLinksDisplay(activeActivityLinkTrigger, activity);
    });
    item.appendChild(main);
    item.appendChild(removeBtn);
    activityLinkList.appendChild(item);
  });
}

function setActivityLinkError(message = "") {
  if (!activityLinkError) return;
  activityLinkError.textContent = message;
  activityLinkError.classList.toggle("hidden", !message);
}

function openActivityLinkModal(trigger, activity) {
  activeActivityLinkTrigger = trigger;
  activeActivityLinkActivity = activity;
  if (activityLinkTitleInput) activityLinkTitleInput.value = "";
  if (activityLinkUrlInput) activityLinkUrlInput.value = "";
  setActivityLinkError("");
  renderActivityLinkList(activity);
  if (trigger) trigger.setAttribute("aria-expanded", "true");
  openModal(activityLinkModalBackdrop, "#activity-link-title-input");
}

function closeActivityLinkModal() {
  if (activeActivityLinkTrigger) {
    activeActivityLinkTrigger.setAttribute("aria-expanded", "false");
  }
  setActivityLinkError("");
  closeModal(activityLinkModalBackdrop);
  activeActivityLinkTrigger = null;
  activeActivityLinkActivity = null;
}

function confirmActivityLink() {
  if (!activeActivityLinkActivity) return;
  const title = toPlainTextareaValue(activityLinkTitleInput?.value || "").trim();
  const url = normalizeExternalUrl(activityLinkUrlInput?.value || "");
  if (!title || !url) {
    setActivityLinkError(title || String(activityLinkUrlInput?.value || "").trim()
      ? t("activityLinkErrorInvalid")
      : t("activityLinkErrorRequired"));
    return;
  }
  activeActivityLinkActivity.links = [
    ...(Array.isArray(activeActivityLinkActivity.links) ? activeActivityLinkActivity.links : []),
    { id: nextId(), title, url }
  ];
  saveState();
  renderActivityLinkList(activeActivityLinkActivity);
  updateActivityLinksDisplay(activeActivityLinkTrigger, activeActivityLinkActivity);
  setActivityLinkError("");
  activityLinkTitleInput.value = "";
  activityLinkUrlInput.value = "";
  activityLinkTitleInput.focus();
}

function openChoiceMenu(trigger, options, currentValue, onSelect) {
  if (activeChoiceMenu && activeChoiceTrigger === trigger) {
    closeChoiceMenu(true);
    return;
  }
  closeChoiceMenu();
  const rect = trigger.getBoundingClientRect();
  const menu = document.createElement("div");
  const menuId = `choice-menu-${nextId()}`;
  menu.className = "choice-menu";
  menu.id = menuId;
  menu.setAttribute("role", "listbox");
  menu.setAttribute("aria-label", trigger.dataset.groupTitle || trigger.title || "Options");
  menu.style.left = `${rect.left}px`;
  menu.style.top = `${rect.bottom + 4}px`;
  const groupTitle = trigger.dataset.groupTitle || "";
  if (groupTitle) {
    const title = document.createElement("div");
    title.className = "choice-menu-title";
    title.textContent = groupTitle;
    menu.appendChild(title);
  }

  options.forEach((option) => {
    const item = document.createElement("button");
    item.type = "button";
    item.className = `choice-menu-item${option.value === currentValue ? " active" : ""}`;
    item.innerHTML = `${option.icon}<span>${option.label}</span>`;
    item.setAttribute("role", "option");
    item.setAttribute("tabindex", "-1");
    item.setAttribute("aria-selected", option.value === currentValue ? "true" : "false");
    item.addEventListener("click", () => {
      onSelect(option.value);
      closeChoiceMenu();
    });
    menu.appendChild(item);
  });

  document.body.appendChild(menu);
  activeChoiceMenu = menu;
  activeChoiceTrigger = trigger;
  activeChoiceItems = Array.from(menu.querySelectorAll(".choice-menu-item"));
  activeChoiceIndex = Math.max(0, options.findIndex((option) => option.value === currentValue));
  trigger.classList.add("open");
  trigger.setAttribute("aria-expanded", "true");
  trigger.setAttribute("aria-controls", menuId);

  const spaceBelow = window.innerHeight - rect.bottom - 12;
  const spaceAbove = rect.top - 12;
  const availableHeight = Math.max(spaceBelow, spaceAbove, 160);
  menu.style.maxHeight = `${Math.min(420, availableHeight)}px`;

  const menuRect = menu.getBoundingClientRect();
  let left = rect.left;
  let top = rect.bottom + 4;
  if (left + menuRect.width > window.innerWidth - 8) {
    left = window.innerWidth - menuRect.width - 8;
  }
  if (left < 8) left = 8;
  if (top + menuRect.height > window.innerHeight - 8 && spaceAbove > spaceBelow) {
    top = rect.top - menuRect.height - 4;
  }
  if (top < 8) top = 8;
  menu.style.left = `${left}px`;
  menu.style.top = `${top}px`;

  menu.addEventListener("keydown", (event) => {
    if (!activeChoiceMenu) return;
    if (event.key === "Escape") {
      event.preventDefault();
      closeChoiceMenu(true);
      return;
    }
    if (event.key === "ArrowDown") {
      event.preventDefault();
      focusChoiceItem(activeChoiceIndex + 1);
      return;
    }
    if (event.key === "ArrowUp") {
      event.preventDefault();
      focusChoiceItem(activeChoiceIndex - 1);
      return;
    }
    if (event.key === "Home") {
      event.preventDefault();
      focusChoiceItem(0);
      return;
    }
    if (event.key === "End") {
      event.preventDefault();
      focusChoiceItem(activeChoiceItems.length - 1);
      return;
    }
    if (event.key === "Tab") {
      closeChoiceMenu();
      return;
    }
    if (event.key === " " || event.key === "Enter") {
      const item = document.activeElement?.closest(".choice-menu-item");
      if (item) {
        event.preventDefault();
        item.click();
      }
    }
  });

  focusChoiceItem(activeChoiceIndex);
}

function normalizeActivity(activity) {
  activity.description = toPlainTextareaValue(activity.description);
  activity.instructions = toPlainTextareaValue(activity.instructions);
  activity.aias = normalizeAiasState(activity.aias ?? activity.aiasLevel);
  delete activity.aiasLevel;
  if (!Array.isArray(activity.links)) activity.links = [];
  activity.links = activity.links
    .map(normalizeActivityLinkEntry)
    .filter(Boolean);
  if (!Array.isArray(activity.tools)) activity.tools = [];
  activity.tools = activity.tools
    .map((reference) => {
      if (SELECTABLE_TOOL_IDS_SET.has(reference)) return reference;
      return COMPETENCY_REFERENCE_MAP[normalizeToken(reference)] || null;
    })
    .filter(Boolean)
    .filter((id, index, array) => array.indexOf(id) === index);
  const legacyGroupSize = Number(activity.groupSize || 0);
  if (!["whole", "subgroups", "individual"].includes(activity.groupMode)) {
    if (legacyGroupSize > 1 && legacyGroupSize < 15) {
      activity.groupMode = "subgroups";
    } else if (legacyGroupSize === 1) {
      activity.groupMode = "individual";
    } else {
      activity.groupMode = "whole";
    }
  }
  if (activity.teacherPresence !== "present" && activity.teacherPresence !== "absent") {
    activity.teacherPresence = "present";
  }
  if (activity.syncMode !== "sync" && activity.syncMode !== "async") {
    activity.syncMode = "sync";
  }
  if (activity.locationMode === "presentiel") activity.locationMode = "onsite";
  if (activity.locationMode === "distanciel") activity.locationMode = "online";
  if (!["online", "onsite", "hybrid"].includes(activity.locationMode)) {
    activity.locationMode = "onsite";
  }
  if (
    !["none", "diagnostic", "formative", "summative", "certificative"].includes(
      activity.evaluationMode
    )
  ) {
    activity.evaluationMode = "none";
  }
}

function defaultAiasState() {
  return {
    version: AIAS_VERSION,
    status: "undecided",
    level: null
  };
}

function normalizeAiasState(value) {
  if (typeof value === "number" || typeof value === "string") {
    const legacyLevel = Number(value);
    if (Number.isInteger(legacyLevel) && legacyLevel >= 1 && legacyLevel <= 5) {
      return { version: AIAS_VERSION, status: "specified", level: legacyLevel };
    }
    return defaultAiasState();
  }

  if (!value || typeof value !== "object" || Array.isArray(value)) {
    return defaultAiasState();
  }

  const level = Number(value.level);
  if (Number.isInteger(level) && level >= 1 && level <= 5) {
    return {
      version: String(value.version || AIAS_VERSION),
      status: "specified",
      level
    };
  }

  if (value.status === "not_applicable") {
    return {
      version: String(value.version || AIAS_VERSION),
      status: "not_applicable",
      level: null
    };
  }

  return defaultAiasState();
}

function aiasLevelDefinition(level) {
  return AIAS_LEVELS.find((item) => item.level === Number(level)) || null;
}

function aiasSummary(aias) {
  const normalized = normalizeAiasState(aias);
  if (normalized.status === "not_applicable") return `AIAS · ${t("aiasNotApplicable")}`;
  if (normalized.status !== "specified") return `AIAS · ${t("aiasUndecided")}`;
  const definition = aiasLevelDefinition(normalized.level);
  return definition
    ? `AIAS ${definition.level} · ${t(definition.labelKey)}`
    : t("aiasUndecided");
}

function applyAiasLevelClass(element, aias) {
  if (!element) return;
  element.classList.remove(
    "aias-level",
    ...AIAS_LEVELS.map((definition) => `aias-level-${definition.level}`)
  );
  const normalized = normalizeAiasState(aias);
  if (normalized.status === "specified") {
    element.classList.add("aias-level", `aias-level-${normalized.level}`);
  }
}

function parseAiasValue(value) {
  const raw = String(value || "").trim();
  if (!raw) return defaultAiasState();
  const normalized = normalizeToken(raw);
  if (["non pertinent", "not applicable", "n a", "na"].includes(normalized)) {
    return { version: AIAS_VERSION, status: "not_applicable", level: null };
  }
  const levelMatch = raw.match(/(?:AIAS|niveau|level)?\s*([1-5])\b/i);
  if (levelMatch) {
    return { version: AIAS_VERSION, status: "specified", level: Number(levelMatch[1]) };
  }
  return defaultAiasState();
}

function updateAiasTrigger(trigger, activity) {
  if (!trigger) return;
  activity.aias = normalizeAiasState(activity.aias);
  const summary = aiasSummary(activity.aias);
  applyAiasLevelClass(trigger, activity.aias);
  if (activity.aias.status === "specified") {
    const number = document.createElement("span");
    number.className = "aias-trigger-number";
    number.textContent = String(activity.aias.level);
    number.setAttribute("aria-hidden", "true");
    trigger.replaceChildren(number);
  } else {
    const icon = document.createElement("i");
    icon.className = `fa-solid ${AIAS_TRIGGER_ICON}`;
    icon.setAttribute("aria-hidden", "true");
    trigger.replaceChildren(icon);
  }
  trigger.title = summary;
  trigger.setAttribute("aria-label", `${t("aiasFieldLabel")}: ${summary}`);
}

function chooseAias(nextAias) {
  if (!activeAiasActivity) return;
  activeAiasActivity.aias = normalizeAiasState(nextAias);
  saveState();
  updateAiasTrigger(activeAiasTrigger, activeAiasActivity);
  announce(t("aiasUpdated"));
  closeAiasModal();
}

function renderAiasModal() {
  if (!activeAiasActivity || !aiasModalStatusOptions || !aiasModalLevels) return;
  activeAiasActivity.aias = normalizeAiasState(activeAiasActivity.aias);
  if (aiasModalTitle) aiasModalTitle.textContent = t("aiasFieldLabel");
  if (aiasModalIntro) aiasModalIntro.textContent = t("aiasPanelIntro");
  aiasModalLevels.setAttribute("aria-label", t("aiasLevelsAriaLabel"));
  aiasModalStatusOptions.replaceChildren();
  aiasModalLevels.replaceChildren();

  [
    { status: "undecided", labelKey: "aiasUndecided" },
    { status: "not_applicable", labelKey: "aiasNotApplicable" }
  ].forEach(({ status, labelKey }) => {
    const button = document.createElement("button");
    const selected = activeAiasActivity.aias.status === status;
    button.type = "button";
    button.className = "aias-status-btn";
    button.dataset.aiasStatus = status;
    button.textContent = t(labelKey);
    button.classList.toggle("selected", selected);
    button.setAttribute("aria-pressed", String(selected));
    button.addEventListener("click", () => chooseAias({
      version: AIAS_VERSION,
      status,
      level: null
    }));
    aiasModalStatusOptions.appendChild(button);
  });

  AIAS_LEVELS.forEach((definition) => {
    const selected = activeAiasActivity.aias.status === "specified"
      && activeAiasActivity.aias.level === definition.level;
    const button = document.createElement("button");
    button.type = "button";
    button.className = `aias-level-btn aias-level aias-level-${definition.level}`;
    button.dataset.aiasLevel = String(definition.level);
    button.setAttribute("role", "radio");
    button.setAttribute("aria-checked", String(selected));
    button.classList.toggle("selected", selected);

    const number = document.createElement("span");
    number.className = "aias-level-number";
    number.textContent = String(definition.level);
    const title = document.createElement("span");
    title.className = "aias-level-title";
    title.textContent = t(definition.labelKey);
    const description = document.createElement("span");
    description.className = "aias-level-description";
    description.textContent = t(definition.descriptionKey);

    button.append(number, title, description);
    button.addEventListener("click", () => chooseAias({
      version: AIAS_VERSION,
      status: "specified",
      level: definition.level
    }));
    aiasModalLevels.appendChild(button);
  });
}

function openAiasModal(trigger, activity) {
  activeAiasTrigger = trigger;
  activeAiasActivity = activity;
  renderAiasModal();
  trigger?.setAttribute("aria-expanded", "true");
  openModal(aiasModalBackdrop, ".selected, #aias-modal-close-btn");
}

function closeAiasModal() {
  activeAiasTrigger?.setAttribute("aria-expanded", "false");
  closeModal(aiasModalBackdrop);
  activeAiasTrigger = null;
  activeAiasActivity = null;
}

function normalizeActivityLinkEntry(link) {
  if (!link) return null;
  const title = toPlainTextareaValue(link.title || "").trim();
  const url = normalizeExternalUrl(link.url || "");
  if (!title || !url) return null;
  return {
    id: link.id || nextId(),
    title,
    url
  };
}

function normalizeExternalUrl(value) {
  const raw = String(value || "").trim();
  if (!raw) return "";
  const candidate = /^[a-z][a-z0-9+.-]*:/i.test(raw) ? raw : `https://${raw}`;
  try {
    const parsed = new URL(candidate);
    if (!["http:", "https:"].includes(parsed.protocol)) return "";
    return parsed.toString();
  } catch (_) {
    return "";
  }
}

function totalDesignedMinutes() {
  return state.sessions.reduce(
    (sessionAcc, session) =>
      sessionAcc + session.activities.reduce((activityAcc, activity) => activityAcc + Number(activity.duration || 0), 0),
    0
  );
}

function totalSessionMinutes(session) {
  return session.activities.reduce((acc, activity) => acc + Number(activity.duration || 0), 0);
}

function getDayHours() {
  return Math.max(1, Number(state.meta.dayHours) || DEFAULT_DAY_HOURS);
}

function normalizePedagogicalTime(days, hours, minutes, dayHours = DEFAULT_DAY_HOURS) {
  let d = Math.max(0, Number(days) || 0);
  let h = Math.max(0, Number(hours) || 0);
  let m = Math.max(0, Number(minutes) || 0);

  h += Math.floor(m / 60);
  m %= 60;
  d += Math.floor(h / dayHours);
  h %= dayHours;

  return { days: d, hours: h, minutes: m };
}

function splitMinutesToPedagogicalTime(totalMinutes, dayHours = DEFAULT_DAY_HOURS) {
  const safeMinutes = Math.max(0, Number(totalMinutes) || 0);
  const dayMinutes = dayHours * 60;
  const days = Math.floor(safeMinutes / dayMinutes);
  const remainder = safeMinutes % dayMinutes;
  const hours = Math.floor(remainder / 60);
  const minutes = remainder % 60;
  return { days, hours, minutes };
}

function setLearningTime(days, hours, minutes) {
  const normalized = normalizePedagogicalTime(days, hours, minutes, getDayHours());
  state.meta.learningDays = normalized.days;
  state.meta.learningHours = normalized.hours;
  state.meta.learningMinutes = normalized.minutes;
}

function buildAnalysisMetrics() {
  const metrics = {
    activities: [],
    overall: 0,
    byType: {},
    byLocation: {},
    byTeacher: {},
    bySync: {},
    byEvaluation: {},
    byGroup: {}
  };
  let overall = 0;
  state.sessions.forEach((session) => {
    session.activities.forEach((activity) => {
      const duration = Math.max(0, Number(activity.duration) || 0);
      const evaluationKey = activity.evaluationMode === "summative" || activity.evaluationMode === "certificative"
        ? "summative"
        : "formative";
      metrics.activities.push(activity);
      metrics.byType[activity.type] = (metrics.byType[activity.type] || 0) + duration;
      metrics.byLocation[activity.locationMode] = (metrics.byLocation[activity.locationMode] || 0) + duration;
      metrics.byTeacher[activity.teacherPresence] = (metrics.byTeacher[activity.teacherPresence] || 0) + duration;
      metrics.bySync[activity.syncMode] = (metrics.bySync[activity.syncMode] || 0) + duration;
      metrics.byEvaluation[evaluationKey] = (metrics.byEvaluation[evaluationKey] || 0) + duration;
      metrics.byGroup[activity.groupMode] = (metrics.byGroup[activity.groupMode] || 0) + duration;
      overall += duration;
    });
  });
  metrics.overall = overall;
  return metrics;
}

function buildSegments(definitions, totals) {
  const sum = definitions.reduce((acc, def) => acc + Number(totals[def.key] || 0), 0);
  let cursor = 0;
  const segments = definitions.map((def) => {
    const value = Number(totals[def.key] || 0);
    const pct = sum > 0 ? (value / sum) * 100 : 0;
    const start = cursor;
    cursor += pct;
    return { ...def, value, pct, start, end: cursor };
  });
  return { sum, segments };
}

function chartSummary(data, emptyLabel = t("noData")) {
  if (!data || data.sum <= 0) return emptyLabel;
  return data.segments
    .filter((segment) => segment.pct > 0)
    .map((segment) => `${segment.label} ${Math.round(segment.pct)}%`)
    .join(", ");
}

function renderConic(el, data) {
  el.setAttribute("role", "img");
  if (data.sum <= 0) {
    el.classList.add("is-empty");
    el.style.background = "";
    el.style.removeProperty("--undefined-end");
    el.setAttribute("aria-label", t("noData"));
    return;
  }
  el.classList.remove("is-empty");
  const parts = data.segments
    .filter((segment) => segment.pct > 0)
    .map((segment) => `${segment.color} ${segment.start}% ${segment.end}%`);
  el.style.background = `conic-gradient(${parts.join(", ")})`;
  const undefinedSegment = data.segments.find((segment) => segment.key === "undefined");
  el.style.setProperty("--undefined-end", `${undefinedSegment ? undefinedSegment.end : 0}%`);
  el.setAttribute("aria-label", chartSummary(data));
}

/* "Non défini" is an unfilled ring, not a coloured dot: at 8px a hatch would
   be illegible, but an outline still reads as "nothing chosen yet". */
function legendDot(key, color) {
  if (key === "undefined") return `<span class="legend-dot legend-dot--undefined"></span>`;
  return `<span class="legend-dot" style="background:${color}"></span>`;
}

function renderLegend(container, data, showPct = true) {
  container.innerHTML = data.segments
    .filter((segment) => segment.pct > 0)
    .map((segment) => {
      const pct = showPct ? ` ${Math.round(segment.pct)}%` : "";
      return `<span class="legend-item">${legendDot(segment.key, segment.color)}${segment.label}${pct}</span>`;
    })
    .join("");
}

const LEARNING_PIE_CODES = {
  read: "Acq",
  collaborate: "Col",
  discuss: "Dis",
  investigate: "Inq",
  practice: "Pra",
  produce: "Pro"
};

function learningPieCode(segmentKey) {
  return LEARNING_PIE_CODES[segmentKey] || "–";
}

function hidePieTooltip(tooltipEl) {
  if (!tooltipEl) return;
  tooltipEl.classList.add("hidden");
  tooltipEl.setAttribute("aria-hidden", "true");
}

function showPieTooltip(wrapEl, pieEl, tooltipEl, segment) {
  if (!wrapEl || !pieEl || !tooltipEl || !segment) return;
  tooltipEl.textContent = "";
  tooltipEl.classList.remove("tooltip-below");
  const nameEl = document.createElement("span");
  nameEl.className = "pie-tooltip-name";
  nameEl.textContent = segment.label;
  const pctEl = document.createElement("span");
  pctEl.className = "pie-tooltip-pct";
  pctEl.textContent = `${Math.round(segment.pct)}%`;
  tooltipEl.append(nameEl, pctEl);
  tooltipEl.classList.remove("hidden");
  tooltipEl.setAttribute("aria-hidden", "false");

  const wrapRect = wrapEl.getBoundingClientRect();
  const pieRect = pieEl.getBoundingClientRect();
  const centerX = pieRect.left - wrapRect.left + pieRect.width / 2;
  const centerY = pieRect.top - wrapRect.top + pieRect.height / 2;
  const radius = Math.min(pieRect.width, pieRect.height) / 2;
  const middlePct = (segment.start + segment.end) / 2;
  const angle = ((middlePct / 100) * (Math.PI * 2)) - (Math.PI / 2);
  const anchorRadius = radius * 0.68;
  const anchorX = centerX + (Math.cos(angle) * anchorRadius);
  const anchorY = centerY + (Math.sin(angle) * anchorRadius);
  const tooltipWidth = tooltipEl.offsetWidth || 130;
  const tooltipHeight = tooltipEl.offsetHeight || 66;
  const left = Math.max(8, Math.min(anchorX - (tooltipWidth / 2), wrapRect.width - tooltipWidth - 8));
  const topAbove = anchorY - tooltipHeight - 14;
  const topBelow = anchorY + 14;
  const shouldPlaceBelow = topAbove < 8 && topBelow <= wrapRect.height - tooltipHeight - 8;
  const top = shouldPlaceBelow
    ? Math.max(8, Math.min(topBelow, wrapRect.height - tooltipHeight - 8))
    : Math.max(8, Math.min(topAbove, wrapRect.height - tooltipHeight - 8));
  const arrowLeft = Math.max(14, Math.min(tooltipWidth - 14, anchorX - left));
  tooltipEl.style.left = `${left}px`;
  tooltipEl.style.top = `${top}px`;
  tooltipEl.style.setProperty("--pie-tooltip-arrow", `${arrowLeft}px`);
  tooltipEl.classList.toggle("tooltip-below", shouldPlaceBelow);
}

function segmentForPointer(data, pieEl, event) {
  if (!data || data.sum <= 0 || !pieEl) return null;
  const rect = pieEl.getBoundingClientRect();
  const radius = Math.min(rect.width, rect.height) / 2;
  const dx = event.clientX - (rect.left + rect.width / 2);
  const dy = event.clientY - (rect.top + rect.height / 2);
  if ((dx * dx) + (dy * dy) > radius * radius) return null;
  let angle = (Math.atan2(dy, dx) * 180) / Math.PI + 90;
  if (angle < 0) angle += 360;
  const pct = (angle / 360) * 100;
  const segments = data.segments.filter((segment) => segment.pct > 0);
  return segments.find((segment, index) => {
    if (index === segments.length - 1) return pct >= segment.start && pct <= segment.end;
    return pct >= segment.start && pct < segment.end;
  }) || null;
}

function renderPieOuterLabels(wrapEl, pieEl, labelsEl, tooltipEl, data, codeForSegment) {
  if (!wrapEl || !pieEl || !labelsEl || !tooltipEl) return;
  hidePieTooltip(tooltipEl);
  labelsEl.innerHTML = "";
  // Cancel previous listeners via AbortController instead of property assignment.
  if (pieEl._pieAbort) pieEl._pieAbort.abort();
  const pieAbort = new AbortController();
  pieEl._pieAbort = pieAbort;
  const { signal } = pieAbort;

  if (!data || data.sum <= 0) return;

  const segments = data.segments.filter((segment) => segment.pct > 0);
  const labelsRect = labelsEl.getBoundingClientRect();
  const pieRect = pieEl.getBoundingClientRect();
  const pieWidth = pieRect.width || pieEl.clientWidth || pieEl.offsetWidth || 180;
  const pieHeight = pieRect.height || pieEl.clientHeight || pieEl.offsetHeight || pieWidth;
  const labelsWidth = labelsRect.width || labelsEl.clientWidth || (pieWidth + 48);
  const labelsHeight = labelsRect.height || labelsEl.clientHeight || (pieHeight + 48);
  const centerX = pieRect.width
    ? pieRect.left - labelsRect.left + pieRect.width / 2
    : labelsWidth / 2;
  const centerY = pieRect.height
    ? pieRect.top - labelsRect.top + pieRect.height / 2
    : labelsHeight / 2;
  const pieRadius = Math.min(pieWidth, pieHeight) / 2;
  const compactLabels = labelsWidth <= pieWidth + 110 || window.innerWidth <= 520;
  const labelInset = compactLabels ? 8 : 16;
  const labelGap = compactLabels ? 10 : 16;
  const labelRingGap = compactLabels ? 8 : 18;
  const positionedLabels = [];

  segments.forEach((segment) => {
    const label = document.createElement("span");
    label.className = "pie-outer-label";
    label.textContent = codeForSegment(segment);
    label.setAttribute("aria-hidden", "true");
    label.title = `${segment.label} ${Math.round(segment.pct)}%`;
    const angle = (((segment.start + segment.end) / 2) / 100) * (Math.PI * 2) - (Math.PI / 2);
    const ux = Math.cos(angle);
    const uy = Math.sin(angle);
    let align = "center";
    if (ux > 0.35) align = "right";
    else if (ux < -0.35) align = "left";
    else if (uy < 0) align = "top";
    else align = "bottom";
    labelsEl.appendChild(label);
    const labelWidth = label.offsetWidth || 24;
    const labelHeight = label.offsetHeight || 12;
    const halfWidth = labelWidth / 2;
    const halfHeight = labelHeight / 2;
    const radialDistance = pieRadius + labelRingGap;
    const x = centerX + ux * radialDistance;
    const y = centerY + uy * radialDistance;
    positionedLabels.push({
      label,
      segment,
      align,
      ux,
      uy,
      x,
      y,
      labelWidth,
      labelHeight,
      halfWidth,
      halfHeight
    });
  });

  ["left", "right"].forEach((align) => {
    const sideLabels = positionedLabels
      .filter((item) => item.align === align)
      .sort((a, b) => a.y - b.y);

    sideLabels.forEach((item, index) => {
      if (index === 0) return;
      const previous = sideLabels[index - 1];
      if (item.y - previous.y < labelGap) {
        item.y = previous.y + labelGap;
      }
    });
  });

  ["top", "bottom"].forEach((align) => {
    const sideLabels = positionedLabels
      .filter((item) => item.align === align)
      .sort((a, b) => a.x - b.x);

    sideLabels.forEach((item, index) => {
      if (index === 0) return;
      const previous = sideLabels[index - 1];
      const minGap = Math.max(labelGap, (previous.halfWidth + item.halfWidth) + 6);
      if (item.x - previous.x < minGap) {
        item.x = previous.x + minGap;
      }
    });
  });

  positionedLabels.forEach(({ label, segment, x, y, align, halfWidth, halfHeight }) => {
    const safeX = Math.max(labelInset + halfWidth, Math.min(x, labelsWidth - labelInset - halfWidth));
    const safeY = Math.max(labelInset + halfHeight, Math.min(y, labelsHeight - labelInset - halfHeight));
    label.style.left = `${safeX}px`;
    label.style.top = `${safeY}px`;
    if (align === "right") label.style.transform = "translate(0, -50%)";
    else if (align === "left") label.style.transform = "translate(-100%, -50%)";
    else if (align === "top") label.style.transform = "translate(-50%, -100%)";
    else label.style.transform = "translate(-50%, 0)";
    label.addEventListener("mouseenter", () => {
      showPieTooltip(wrapEl, pieEl, tooltipEl, segment);
    });
    label.addEventListener("mousemove", () => {
      showPieTooltip(wrapEl, pieEl, tooltipEl, segment);
    });
    label.addEventListener("mouseleave", () => {
      hidePieTooltip(tooltipEl);
    });
  });

  pieEl.addEventListener("mousemove", (event) => {
    const segment = segmentForPointer(data, pieEl, event);
    if (!segment) {
      hidePieTooltip(tooltipEl);
      return;
    }
    showPieTooltip(wrapEl, pieEl, tooltipEl, segment);
  }, { signal });
  pieEl.addEventListener("mouseleave", () => {
    hidePieTooltip(tooltipEl);
  }, { signal });
}

function renderGroupBar(data) {
  analysisGroupBar.setAttribute("role", "img");
  if (data.sum <= 0) {
    analysisGroupBar.classList.add("is-empty");
    analysisGroupBar.style.background = "";
    analysisGroupBar.setAttribute("aria-label", t("noData"));
    return;
  }
  analysisGroupBar.classList.remove("is-empty");
  const parts = data.segments
    .filter((segment) => segment.pct > 0)
    .map((segment) => `${segment.color} ${segment.start}% ${segment.end}%`);
  analysisGroupBar.style.background = `linear-gradient(90deg, ${parts.join(", ")})`;
  analysisGroupBar.setAttribute("aria-label", chartSummary(data));
}

function totalDeclaredLearningMinutes() {
  const normalized = normalizePedagogicalTime(
    state.meta.learningDays,
    state.meta.learningHours,
    state.meta.learningMinutes,
    getDayHours()
  );
  return ((normalized.days * getDayHours() + normalized.hours) * 60) + normalized.minutes;
}

function getAnalysisAlerts(metrics) {
  const activities = metrics.activities;
  const designedMinutes = metrics.overall;
  const learningMinutes = totalDeclaredLearningMinutes();

  const hasInvalidDuration = activities.some((activity) => {
    const duration = Number(activity.duration);
    return !Number.isFinite(duration) || duration <= 0;
  });
  const hasInvalidGroupMode = activities.some(
    (activity) => !["whole", "subgroups", "individual"].includes(activity.groupMode)
  );
  const hasInvalidTrainerMode = activities.some(
    (activity) => !["present", "absent"].includes(activity.teacherPresence)
  );
  const hasInvalidSyncMode = activities.some(
    (activity) => !["sync", "async"].includes(activity.syncMode)
  );
  const hasInvalidLocationMode = activities.some(
    (activity) => !["onsite", "online", "hybrid"].includes(activity.locationMode)
  );

  const alerts = [];
  if (hasInvalidDuration) alerts.push({ id: "AN-01", level: "warning", message: t("an01") });
  if (designedMinutes <= 0) alerts.push({ id: "AN-02", level: "warning", message: t("an02") });
  if (hasInvalidGroupMode) alerts.push({ id: "AN-03", level: "warning", message: t("an03") });
  if (hasInvalidTrainerMode) alerts.push({ id: "AN-04", level: "warning", message: t("an04") });
  if (hasInvalidSyncMode) alerts.push({ id: "AN-05", level: "warning", message: t("an05") });
  if (hasInvalidLocationMode) alerts.push({ id: "AN-06", level: "warning", message: t("an06") });
  if (learningMinutes > 0 && designedMinutes > learningMinutes) {
    alerts.push({ id: "AN-07", level: "info", message: t("an07") });
  }
  if (learningMinutes === 0 && designedMinutes > 0) {
    alerts.push({ id: "AN-08", level: "info", message: t("an08") });
  }
  const hasOnlyUndefined =
    activities.length > 0 &&
    activities.every((activity) => !activity.type || activity.type === "undefined");
  if (hasOnlyUndefined) {
    alerts.push({ id: "AN-09", level: "info", message: t("an09") });
  }
  return alerts;
}

function renderAnalysisAlerts(metrics) {
  const alerts = getAnalysisAlerts(metrics);
  analysisAlerts.innerHTML = "";
  analysisAlerts.classList.toggle("hidden", alerts.length === 0);
  if (!alerts.length) return;

  alerts.forEach((alert) => {
    const item = document.createElement("p");
    item.className = `analysis-alert ${alert.level}`;
    item.textContent = alert.message;
    item.dataset.alertId = alert.id;
    analysisAlerts.appendChild(item);
  });
}

function renderAnalysisPanel() {
  const metrics = buildAnalysisMetrics();
  renderAnalysisAlerts(metrics);

  const learningDefs = LEARNING_TYPES.map((type) => ({
    key: type.id,
    label: type.label,
    color: type.color
  }));
  const learningData = buildSegments(learningDefs, metrics.byType);
  renderConic(analysisLearningPie, learningData);
  renderLegend(analysisLearningLegend, learningData, false);
  renderPieOuterLabels(
    analysisLearningPieWrap,
    analysisLearningPie,
    analysisLearningLabels,
    analysisLearningTooltip,
    learningData,
    (segment) => learningPieCode(segment.key)
  );

  const deliveryDefs = [
    { key: "onsite", label: t("modeOnsite"), color: "#37658b" },
    { key: "online", label: t("modeOnline"), color: "#bcc7d7" },
    { key: "hybrid", label: t("modeHybrid"), color: "#4e84c8" }
  ];
  const deliveryData = buildSegments(deliveryDefs, metrics.byLocation);
  renderConic(analysisDeliveryPie, deliveryData);
  renderLegend(analysisDeliveryLegend, deliveryData);

  const teacherDefs = [
    { key: "present", label: t("teacherPresentLabel"), color: "#7a6854" },
    { key: "absent", label: t("teacherAbsentLabel"), color: "#c5b59f" }
  ];
  const teacherData = buildSegments(teacherDefs, metrics.byTeacher);
  renderConic(analysisTeacherPie, teacherData);
  renderLegend(analysisTeacherLegend, teacherData);

  const syncDefs = [
    { key: "sync", label: t("sync_sync"), color: "#ac7f8d" },
    { key: "async", label: t("sync_async"), color: "#cbbec2" }
  ];
  const syncData = buildSegments(syncDefs, metrics.bySync);
  renderConic(analysisSyncPie, syncData);
  renderLegend(analysisSyncLegend, syncData);

  const evalDefs = [
    { key: "formative", label: t("eval_formative"), color: "#ccd5aa" },
    { key: "summative", label: t("eval_summative"), color: "#b2cf69" }
  ];
  const evalData = buildSegments(evalDefs, metrics.byEvaluation);
  renderConic(analysisEvalPie, evalData);
  renderLegend(analysisEvalLegend, evalData);

  const groupDefs = [
    { key: "whole", label: t("group_whole"), color: "#4f7d5a" },
    { key: "subgroups", label: t("group_subgroups"), color: "#6ab084" },
    { key: "individual", label: t("group_individual"), color: "#a8c8b1" }
  ];
  const groupData = buildSegments(groupDefs, metrics.byGroup);
  renderGroupBar(groupData);
  renderLegend(analysisGroupLegend, groupData);
}

function renderPartitionView() {
  if (state.topPanelCollapsed || state.meta.activeTab !== "chronology") return;
  const container = document.getElementById('chronology-container');
  if (!container) return;
  container.innerHTML = '';

  // Create and render partition controls panel
  const controlsDiv = document.createElement('div');
  controlsDiv.className = 'partition-controls';
  controlsDiv.innerHTML = `
    <span class="partition-controls-label">${t("partitionLinesLabel")} :</span>
    <button class="partition-config-btn" id="partition-edit-btn">${t("partitionConfigure")}</button>
  `;
  container.appendChild(controlsDiv);

  // Wire up the config button
  document.getElementById('partition-edit-btn')?.addEventListener('click', openPartitionConfigModal);

  // Render partition for each session
  state.sessions.forEach((session, sessionIndex) => {
    const sessionDiv = document.createElement('div');
    sessionDiv.className = 'partition-session';

    // Session header with title and total duration
    const header = document.createElement('div');
    header.className = 'partition-session-header';

    const title = document.createElement('div');
    title.className = 'partition-session-title';
    title.textContent = session.title || `${t("partitionSession")} ${sessionIndex + 1}`;

    const total = document.createElement('div');
    total.className = 'partition-session-total';
    const totalDuration = session.activities.reduce((sum, a) => sum + (Number(a.duration) || 0), 0);
    total.textContent = `${t("partitionTotal")}: ${totalDuration} min`;

    header.appendChild(title);
    header.appendChild(total);
    sessionDiv.appendChild(header);

    // Calculate cumulative durations and positions for all activities
    const activityPositions = [];
    let cumulativeDuration = 0;
    session.activities.forEach((activity) => {
      const duration = Number(activity.duration) || 0;
      const startPercent = totalDuration > 0 ? (cumulativeDuration / totalDuration) * 100 : 0;
      const widthPercent = totalDuration > 0 ? (duration / totalDuration) * 100 : 0;
      activityPositions.push({ activity, startPercent, widthPercent });
      cumulativeDuration += duration;
    });

    // Render partition lines (one per visible modalite config)
    state.partitionLineConfig.filter(line => line.visible).forEach((lineConfig) => {
      const lineDiv = document.createElement('div');
      lineDiv.className = 'partition-line';

      // Line label (modalite name)
      const label = document.createElement('div');
      label.className = 'partition-line-label';
      label.textContent = lineConfig.label;
      lineDiv.appendChild(label);

      // Track container for blocks (relative positioning)
      const track = document.createElement('div');
      track.className = 'partition-line-track';

      // Add activity blocks that match this line's modalite
      activityPositions.forEach(({ activity, startPercent, widthPercent }) => {
        // Check if activity matches this line configuration
        const matchesLine = (() => {
          if (lineConfig.type === 'locationMode') return activity.locationMode === lineConfig.value;
          if (lineConfig.type === 'groupMode') return activity.groupMode === lineConfig.value;
          if (lineConfig.type === 'syncMode') return activity.syncMode === lineConfig.value;
          if (lineConfig.type === 'teacherPresence') return activity.teacherPresence === lineConfig.value;
          return false;
        })();

        if (matchesLine && widthPercent > 0) {
          const block = document.createElement('div');
          block.className = 'partition-block';
          block.style.left = startPercent + '%';
          block.style.width = widthPercent + '%';
          block.style.backgroundColor = colorForType(activity.type);

          // Type label (abbreviated)
          const typeLabel = document.createElement('div');
          typeLabel.className = 'partition-block-label';
          const abbreviation = labelForType(activity.type).substring(0, 3).toUpperCase();
          typeLabel.textContent = abbreviation;

          // Duration label
          const durationLabel = document.createElement('div');
          durationLabel.className = 'partition-block-duration';
          durationLabel.textContent = `${activity.duration}m`;

          block.appendChild(typeLabel);
          block.appendChild(durationLabel);

          // Optional: Add hover tooltip with activity details
          block.title = `${labelForType(activity.type)} - ${activity.duration}m`;

          track.appendChild(block);
        }
      });

      if (track.children.length > 0) track.classList.add('has-blocks');
      lineDiv.appendChild(track);
      sessionDiv.appendChild(lineDiv);
    });

    // Percentage scale (0%, 25%, 50%, 75%, 100%)
    const scale = document.createElement('div');
    scale.className = 'partition-scale';
    [0, 25, 50, 75, 100].forEach(pct => {
      const mark = document.createElement('div');
      mark.className = 'partition-scale-mark';
      mark.textContent = pct + '%';
      scale.appendChild(mark);
    });
    sessionDiv.appendChild(scale);

    container.appendChild(sessionDiv);
  });
}

function renderTopPanel() {
  topPanel.classList.toggle("collapsed", state.topPanelCollapsed);
  const toggleLabel = state.topPanelCollapsed ? t("expandPanel") : t("collapsePanel");
  topPanelToggleBtn.setAttribute("aria-label", toggleLabel);
  topPanelToggleBtn.setAttribute("title", toggleLabel);
  topPanelToggleBtn.setAttribute("aria-expanded", state.topPanelCollapsed ? "false" : "true");

  const panelExpanded = !state.topPanelCollapsed;
  const settingsActive = state.meta.activeTab === "settings";
  const analysisActive = state.meta.activeTab === "analysis";
  const chronologyActive = state.meta.activeTab === "chronology";

  topPanelBody.toggleAttribute("inert", !panelExpanded);
  topPanelBody.setAttribute("aria-hidden", panelExpanded ? "false" : "true");

  if (panelExpanded && settingsActive) {
    metaNameInput.value = state.meta.name;
    metaLearningDaysInput.value = state.meta.learningDays;
    metaLearningHoursInput.value = state.meta.learningHours;
    metaLearningMinutesInput.value = state.meta.learningMinutes;
    metaDeliverySelect.value = state.meta.modeDelivery;
    metaDayHoursInput.value = getDayHours();
    metaSizeClassInput.value = state.meta.sizeClass;
    metaDesignersInput.value = state.meta.designers;
    metaTrainersInput.value = state.meta.trainers;
    metaDescriptionInput.value = state.meta.description;
    metaCommandInput.value = state.meta.command;
    metaPersonasInput.value = state.meta.personas;
    renderOutcomes();
  }

  topTabSettings.classList.toggle("active", panelExpanded && state.meta.activeTab === "settings");
  topTabAnalysis.classList.toggle("active", panelExpanded && state.meta.activeTab === "analysis");
  topTabChronology.classList.toggle("active", panelExpanded && state.meta.activeTab === "chronology");
  topTabSettings.setAttribute("aria-selected", state.meta.activeTab === "settings" ? "true" : "false");
  topTabAnalysis.setAttribute("aria-selected", state.meta.activeTab === "analysis" ? "true" : "false");
  topTabChronology.setAttribute("aria-selected", state.meta.activeTab === "chronology" ? "true" : "false");
  topTabSettings.tabIndex = state.meta.activeTab === "settings" ? 0 : -1;
  topTabAnalysis.tabIndex = state.meta.activeTab === "analysis" ? 0 : -1;
  topTabChronology.tabIndex = state.meta.activeTab === "chronology" ? 0 : -1;
  timelineView.classList.toggle("hidden", !settingsActive);
  analysisView.classList.toggle("hidden", !analysisActive);
  chronologyView.classList.toggle("hidden", !chronologyActive);
  timelineView.setAttribute("aria-hidden", panelExpanded && settingsActive ? "false" : "true");
  analysisView.setAttribute("aria-hidden", panelExpanded && analysisActive ? "false" : "true");
  chronologyView.setAttribute("aria-hidden", panelExpanded && chronologyActive ? "false" : "true");

  if (panelExpanded && settingsActive) {
    const designed = splitMinutesToPedagogicalTime(totalDesignedMinutes(), getDayHours());
    metaDesignedDaysInput.value = designed.days;
    metaDesignedHoursInput.value = designed.hours;
    metaDesignedMinutesInput.value = designed.minutes;

    const totals = {};
    LEARNING_TYPES.forEach((type) => {
      totals[type.id] = 0;
    });
    state.sessions.forEach((session) => {
      session.activities.forEach((activity) => {
        const duration = Number(activity.duration || 0);
        totals[activity.type] = (totals[activity.type] || 0) + duration;
      });
    });

    const topDefs = LEARNING_TYPES.map((type) => ({
      key: type.id,
      label: type.label,
      color: type.color
    }));
    const topData = buildSegments(topDefs, totals);
    renderConic(topPie, topData);
    renderPieOuterLabels(
      topPieWrap,
      topPie,
      topPieLabels,
      topPieTooltip,
      topData,
      (segment) => learningPieCode(segment.key)
    );

    topLegend.innerHTML = LEARNING_TYPES.map((type) => {
      const pct = topData.sum > 0 ? Math.round((totals[type.id] / topData.sum) * 100) : 0;
      return `<span class="legend-item">${legendDot(type.id, type.color)}${type.label} ${pct}%</span>`;
    }).join("");
  }

  if (panelExpanded && analysisActive) renderAnalysisPanel();
  updateTabSlider();
}

function updateTabSlider() {
  const panelExpanded = !state.topPanelCollapsed;
  const activeBtn =
    panelExpanded && state.meta.activeTab === "settings" ? topTabSettings :
    panelExpanded && state.meta.activeTab === "analysis"  ? topTabAnalysis :
    panelExpanded && state.meta.activeTab === "chronology" ? topTabChronology :
    null;

  if (!activeBtn || !topTabSlider) return;

  const container = topTabSlider.parentElement;
  const containerLeft = container.getBoundingClientRect().left;
  const btnRect = activeBtn.getBoundingClientRect();

  topTabSlider.style.left  = (btnRect.left - containerLeft) + "px";
  topTabSlider.style.width = btnRect.width + "px";
  topTabSlider.style.opacity = "1";
}

function labelForType(typeId) {
  return LEARNING_TYPES.find((type) => type.id === typeId)?.label || typeId;
}

function labelForGroupMode(groupMode) {
  if (groupMode === "whole") return t("group_whole");
  if (groupMode === "subgroups") return t("group_subgroups");
  return t("group_individual");
}

function labelForTrainerMode(mode) {
  return mode === "absent" ? t("trainer_absent") : t("trainer_present");
}

function slidersToString(sliders) {
  if (!Array.isArray(sliders)) return typeof sliders === "string" ? sliders : "";
  return sliders.map((o) => {
    const label = o.verb || o.categoryLabel || "";
    return label ? `${label}: ${o.text || ""}` : (o.text || "");
  }).filter(Boolean).join("\n");
}

function labelForSyncMode(mode) {
  return mode === "async" ? t("sync_async") : t("sync_sync");
}

function labelForLocationMode(mode) {
  if (!mode) return "-";
  if (mode === "online") return t("modeOnline");
  if (mode === "hybrid") return t("modeHybrid");
  return t("modeOnsite");
}

function labelForEvaluationMode(mode) {
  if (mode === "diagnostic") return t("eval_diagnostic");
  if (mode === "formative") return t("eval_formative");
  if (mode === "summative") return t("eval_summative");
  if (mode === "certificative") return t("eval_certificative");
  return t("eval_none");
}

function escapeHtml(value) {
  return String(value)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#39;");
}

function escapeHtmlWithBreaks(value) {
  return escapeHtml(value).replaceAll("\n", "<br />");
}

function escapeXml(value) {
  return String(value ?? "")
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&apos;");
}

function formatPedagogicalTime(days, hours, minutes) {
  return `${Math.max(0, Number(days) || 0)} j ${Math.max(0, Number(hours) || 0)} h ${Math.max(
    0,
    Number(minutes) || 0
  )} min`;
}

function markdownQuoteBlock(text) {
  return String(text)
    .split("\n")
    .map((line) => `> ${line}`)
    .join("\n");
}

function normalizeExportScope(scope = "full") {
  return String(scope).toLowerCase() === "students" ? "students" : "full";
}

function exportSessionKey(session) {
  return String(session?.id || "");
}

function getExportSessionEntries(sessionIds = null) {
  const selectedIds = sessionIds === null
    ? null
    : sessionIds instanceof Set
      ? sessionIds
      : new Set(Array.from(sessionIds || [], String));
  return state.sessions
    .map((session, sessionIndex) => ({ session, sessionIndex }))
    .filter(({ session }) => selectedIds === null || selectedIds.has(exportSessionKey(session)));
}

function totalExportDesignedMinutes(sessionIds = null) {
  return getExportSessionEntries(sessionIds).reduce(
    (sessionAcc, { session }) => sessionAcc + totalSessionMinutes(session),
    0
  );
}

function syncExportMomentsSelection() {
  const total = state.sessions.length;
  const selected = getExportSessionEntries(exportSessionIds).length;
  if (exportMomentsAllInput) {
    exportMomentsAllInput.disabled = total === 0;
    exportMomentsAllInput.checked = total > 0 && selected === total;
    exportMomentsAllInput.indeterminate = selected > 0 && selected < total;
  }
  if (exportMomentsSummary) {
    const selectionLabel = t("exportMomentsSelection");
    exportMomentsSummary.textContent = total === 0
      ? ""
      : typeof selectionLabel === "function"
        ? selectionLabel(selected, total)
        : `${selected}/${total}`;
  }
}

function renderExportMoments() {
  if (!exportMomentsList) return;
  const allIds = new Set(state.sessions.map(exportSessionKey));
  const selectedIds = exportSessionIds instanceof Set ? exportSessionIds : allIds;
  exportMomentsList.innerHTML = "";

  state.sessions.forEach((session, sessionIndex) => {
    const sessionId = exportSessionKey(session);
    const option = document.createElement("label");
    option.className = "export-moment-option";

    const input = document.createElement("input");
    input.type = "checkbox";
    input.value = sessionId;
    input.checked = selectedIds.has(sessionId);
    input.dataset.exportSessionId = sessionId;

    const number = document.createElement("span");
    number.className = "export-moment-number";
    number.textContent = `${sessionIndex + 1}.`;

    const title = document.createElement("span");
    title.className = "export-moment-title";
    title.textContent = session.title || defaultSessionTitle(sessionIndex + 1);

    input.addEventListener("change", () => {
      if (!(exportSessionIds instanceof Set)) exportSessionIds = new Set(allIds);
      if (input.checked) exportSessionIds.add(sessionId);
      else exportSessionIds.delete(sessionId);
      syncExportMomentsSelection();
      updateExportPreview(exportFormatSelect?.value || "markdown", exportScope);
    });

    option.append(input, number, title);
    exportMomentsList.appendChild(option);
  });

  exportMomentsList.classList.toggle("hidden", state.sessions.length === 0);
  exportMomentsEmpty?.classList.toggle("hidden", state.sessions.length > 0);
  syncExportMomentsSelection();
}

function buildStudentInstructionsData(sessionIds = null) {
  return {
    exportType: "student_instructions",
    title: state.meta.name || "Design Learning",
    sessions: getExportSessionEntries(sessionIds).map(({ session, sessionIndex }) => ({
      number: sessionIndex + 1,
      title: session.title || `Séance ${sessionIndex + 1}`,
      activities: session.activities.map((activity, activityIndex) => ({
        number: `${sessionIndex + 1}.${activityIndex + 1}`,
        instructions: activity.instructions || ""
      }))
    }))
  };
}

function buildStudentMarkdownExport(sessionIds = null) {
  const studentExport = buildStudentInstructionsData(sessionIds);
  const lines = [`# ${studentExport.title}`, "", "## Consignes pour les élèves", ""];
  studentExport.sessions.forEach((session) => {
    lines.push(`## ${session.number}. ${session.title}`);
    lines.push("");
    session.activities.forEach((activity) => {
      lines.push(`### Activité ${activity.number}`);
      lines.push(activity.instructions || "-");
      lines.push("");
    });
  });
  return lines.join("\n");
}

function buildMarkdownExport(scope = "full", sessionIds = null) {
  if (normalizeExportScope(scope) === "students") return buildStudentMarkdownExport(sessionIds);
  const designed = splitMinutesToPedagogicalTime(totalExportDesignedMinutes(sessionIds), getDayHours());
  const lines = [`# ${state.meta.name || "Design Learning"}`, "", "## Paramètres", ""];
  lines.push(`- Mode: ${labelForLocationMode(state.meta.modeDelivery)}`);
  lines.push(`- Taille du groupe: ${state.meta.sizeClass || "-"}`);
  lines.push(`- Concepteur(s): ${state.meta.designers || "-"}`);
  lines.push(`- Enseignant(s): ${state.meta.trainers || "-"}`);
  lines.push(
    `- Temps d'apprentissage: ${formatPedagogicalTime(
      state.meta.learningDays,
      state.meta.learningHours,
      state.meta.learningMinutes
    )}`
  );
  lines.push(
    `- Temps conçu: ${formatPedagogicalTime(designed.days, designed.hours, designed.minutes)}`
  );
  lines.push(`- 1 jour = ${getDayHours()} heures`);
  lines.push("");
  if (state.meta.description) {
    lines.push("### Description");
    lines.push(state.meta.description);
    lines.push("");
  }
  if (state.meta.command) {
    lines.push("### Commande institutionnelle");
    lines.push(state.meta.command);
    lines.push("");
  }
  if (state.meta.personas) {
    lines.push("### Objectifs");
    lines.push(state.meta.personas);
    lines.push("");
  }
  if (Array.isArray(state.meta.sliders) && state.meta.sliders.length) {
    lines.push("### Acquis d'apprentissage");
    state.meta.sliders.forEach((o) => {
      const label = o.verb || o.categoryLabel || "";
      lines.push(`- ${label}${label && o.text ? " : " : ""}${o.text || ""}`);
    });
    lines.push("");
  }
  lines.push("## Séances");
  lines.push("");

  getExportSessionEntries(sessionIds).forEach(({ session, sessionIndex }) => {
    lines.push(`## ${sessionIndex + 1}. ${session.title}`);
    if (session.objectives) {
      lines.push("> Objectifs:");
      lines.push(markdownQuoteBlock(session.objectives));
    }
    if (session.intentions) {
      lines.push("> Choix pédagogiques:");
      lines.push(markdownQuoteBlock(session.intentions));
    }
    if (session.notes) {
      lines.push("> Notes:");
      lines.push(markdownQuoteBlock(session.notes));
    }
    lines.push("");
    session.activities.forEach((activity, activityIndex) => {
      lines.push(`### ${sessionIndex + 1}.${activityIndex + 1} ${labelForType(activity.type)}`);
      lines.push(`- Durée: ${activity.duration} min`);
      lines.push(`- Groupe: ${labelForGroupMode(activity.groupMode)}`);
      lines.push(`- Enseignant: ${labelForTrainerMode(activity.teacherPresence)}`);
      lines.push(`- Rythme: ${labelForSyncMode(activity.syncMode)}`);
      lines.push(`- Modalité: ${labelForLocationMode(activity.locationMode)}`);
      lines.push(`- Évaluation: ${labelForEvaluationMode(activity.evaluationMode)}`);
      lines.push(`- AIAS: ${aiasSummary(activity.aias)}`);
      lines.push(`- Description: ${activity.description || "-"}`);
      lines.push(`- Consignes pour les élèves: ${activity.instructions || "-"}`);
      if (activity.links && activity.links.length) {
        const linkLabels = activity.links
          .map((link) => `${link.title} (${link.url})`)
          .join(", ");
        lines.push(`- Liens: ${linkLabels}`);
      }
      if (activity.tools && activity.tools.length) {
        const toolLabels = activity.tools
          .map(id => SELECTABLE_TOOLS_DATA.find(t => t.id === id))
          .filter(Boolean)
          .map(t => formatCompetencyLabel(t, "fr"))
          .join(", ");
        lines.push(`- Compétences: ${toolLabels}`);
      }
      lines.push("");
    });
  });
  return lines.join("\n");
}

function buildStudentHtmlExportDocument(sessionIds = null) {
  const studentExport = buildStudentInstructionsData(sessionIds);
  const sections = studentExport.sessions
    .map((session) => {
      const activities = session.activities
        .map((activity) => `
          <li>
            <h3>Activité ${escapeHtml(activity.number)}</h3>
            <div class="instructions">${escapeHtmlWithBreaks(activity.instructions || "-")}</div>
          </li>`)
        .join("");
      return `
      <section>
        <h2>${session.number}. ${escapeHtml(session.title)}</h2>
        <ol>${activities}</ol>
      </section>`;
    })
    .join("");

  return `<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Consignes élèves — ${escapeHtml(studentExport.title)}</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; line-height: 1.5; color: #1f2937; }
    h1, h2, h3 { margin-bottom: 8px; }
    section { margin-bottom: 24px; }
    ol { padding-left: 24px; }
    li { margin-bottom: 18px; }
    .instructions { white-space: normal; }
  </style>
</head>
<body>
  <h1>${escapeHtml(studentExport.title)}</h1>
  <h2>Consignes pour les élèves</h2>
  ${sections}
</body>
</html>`;
}

function buildHtmlExportDocument(scope = "full", sessionIds = null) {
  if (normalizeExportScope(scope) === "students") return buildStudentHtmlExportDocument(sessionIds);
  const designed = splitMinutesToPedagogicalTime(totalExportDesignedMinutes(sessionIds), getDayHours());
  const sections = getExportSessionEntries(sessionIds)
    .map(({ session, sessionIndex }) => {
      const activities = session.activities
        .map(
          (activity, activityIndex) => `
          <li>
            <h4>${sessionIndex + 1}.${activityIndex + 1} ${escapeHtml(labelForType(activity.type))}</h4>
            <p><strong>Durée:</strong> ${escapeHtml(activity.duration)} min</p>
            <p><strong>Groupe:</strong> ${escapeHtml(labelForGroupMode(activity.groupMode))}</p>
            <p><strong>Enseignant:</strong> ${escapeHtml(labelForTrainerMode(activity.teacherPresence))}</p>
            <p><strong>Rythme:</strong> ${escapeHtml(labelForSyncMode(activity.syncMode))}</p>
            <p><strong>Modalité:</strong> ${escapeHtml(labelForLocationMode(activity.locationMode))}</p>
            <p><strong>Évaluation:</strong> ${escapeHtml(labelForEvaluationMode(activity.evaluationMode))}</p>
            <p><strong>AIAS:</strong> ${escapeHtml(aiasSummary(activity.aias))}</p>
            <p><strong>Description:</strong> ${escapeHtmlWithBreaks(activity.description || "")}</p>
            <p><strong>Consignes pour les élèves:</strong> ${escapeHtmlWithBreaks(activity.instructions || "")}</p>
            ${activity.links && activity.links.length ? `<p><strong>Liens:</strong> ${activity.links.map((link) => `<a href="${escapeHtml(link.url)}" target="_blank" rel="noopener noreferrer">${escapeHtml(link.title)}</a>`).join(", ")}</p>` : ""}
            ${activity.tools && activity.tools.length ? `<p><strong>Compétences:</strong> ${escapeHtml(activity.tools.map(id => { const t = SELECTABLE_TOOLS_DATA.find(x => x.id === id); return t ? formatCompetencyLabel(t, "fr") : id; }).join(", "))}</p>` : ""}
          </li>
        `
        )
        .join("");
      return `
      <section>
        <h2>${sessionIndex + 1}. ${escapeHtml(session.title)}</h2>
        ${session.objectives ? `<p><strong>Objectifs:</strong><br />${escapeHtmlWithBreaks(session.objectives)}</p>` : ""}
        ${session.intentions ? `<p><strong>Choix pédagogiques:</strong><br />${escapeHtmlWithBreaks(session.intentions)}</p>` : ""}
        ${session.notes ? `<p><strong>Notes:</strong> ${escapeHtml(session.notes)}</p>` : ""}
        <ol>${activities}</ol>
      </section>
    `;
    })
    .join("");

  const metadata = `
  <section>
    <h2>Paramètres</h2>
    <p><strong>Mode:</strong> ${escapeHtml(labelForLocationMode(state.meta.modeDelivery))}</p>
    <p><strong>Taille du groupe:</strong> ${escapeHtml(state.meta.sizeClass || "-")}</p>
    <p><strong>Concepteur(s):</strong> ${escapeHtml(state.meta.designers || "-")}</p>
    <p><strong>Enseignant(s):</strong> ${escapeHtml(state.meta.trainers || "-")}</p>
    <p><strong>Temps d'apprentissage:</strong> ${escapeHtml(
      formatPedagogicalTime(
        state.meta.learningDays,
        state.meta.learningHours,
        state.meta.learningMinutes
      )
    )}</p>
    <p><strong>Temps conçu:</strong> ${escapeHtml(
      formatPedagogicalTime(designed.days, designed.hours, designed.minutes)
    )}</p>
    <p><strong>1 jour =</strong> ${escapeHtml(getDayHours())} heures</p>
    ${
      state.meta.description
        ? `<p><strong>Description:</strong><br />${escapeHtmlWithBreaks(state.meta.description)}</p>`
        : ""
    }
    ${
      state.meta.command
        ? `<p><strong>Commande institutionnelle:</strong><br />${escapeHtmlWithBreaks(
            state.meta.command
          )}</p>`
        : ""
    }
    ${
      state.meta.personas
        ? `<p><strong>Objectifs:</strong><br />${escapeHtmlWithBreaks(
            state.meta.personas
          )}</p>`
        : ""
    }
    ${
      Array.isArray(state.meta.sliders) && state.meta.sliders.length
        ? `<p><strong>Acquis d'apprentissage :</strong></p><ul>${state.meta.sliders.map((o) => {
            const label = o.verb || o.categoryLabel || "";
            return `<li>${label ? `<strong>${escapeHtml(label)}</strong> : ` : ""}${escapeHtmlWithBreaks(o.text || "")}</li>`;
          }).join("")}</ul>`
        : ""
    }
  </section>`;

  return `<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Export Learning Designer</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; line-height: 1.4; }
    h1, h2, h4 { margin-bottom: 8px; }
    section { margin-bottom: 24px; }
    p { margin: 3px 0; }
    ol { padding-left: 20px; }
    li { margin-bottom: 10px; }
  </style>
</head>
<body>
  <h1>${escapeHtml(state.meta.name || "Design Learning")}</h1>
  ${metadata}
  ${sections}
</body>
</html>`;
}

function createCrc32Table() {
  const table = new Uint32Array(256);
  for (let i = 0; i < 256; i += 1) {
    let c = i;
    for (let k = 0; k < 8; k += 1) {
      c = (c & 1) ? (0xedb88320 ^ (c >>> 1)) : (c >>> 1);
    }
    table[i] = c >>> 0;
  }
  return table;
}

const CRC32_TABLE = createCrc32Table();

function crc32(bytes) {
  let crc = 0xffffffff;
  bytes.forEach((byte) => {
    crc = CRC32_TABLE[(crc ^ byte) & 0xff] ^ (crc >>> 8);
  });
  return (crc ^ 0xffffffff) >>> 0;
}

function writeUint16(target, offset, value) {
  target[offset] = value & 0xff;
  target[offset + 1] = (value >>> 8) & 0xff;
}

function writeUint32(target, offset, value) {
  target[offset] = value & 0xff;
  target[offset + 1] = (value >>> 8) & 0xff;
  target[offset + 2] = (value >>> 16) & 0xff;
  target[offset + 3] = (value >>> 24) & 0xff;
}

function concatUint8Arrays(parts) {
  const totalLength = parts.reduce((sum, part) => sum + part.length, 0);
  const output = new Uint8Array(totalLength);
  let offset = 0;
  parts.forEach((part) => {
    output.set(part, offset);
    offset += part.length;
  });
  return output;
}

function createZipArchive(files) {
  const encoder = new TextEncoder();
  const localParts = [];
  const centralParts = [];
  let offset = 0;

  files.forEach((file) => {
    const nameBytes = encoder.encode(file.name);
    const dataBytes = typeof file.content === "string" ? encoder.encode(file.content) : file.content;
    const checksum = crc32(dataBytes);

    const localHeader = new Uint8Array(30 + nameBytes.length);
    writeUint32(localHeader, 0, 0x04034b50);
    writeUint16(localHeader, 4, 20);
    writeUint16(localHeader, 6, 0);
    writeUint16(localHeader, 8, 0);
    writeUint16(localHeader, 10, 0);
    writeUint16(localHeader, 12, 0);
    writeUint32(localHeader, 14, checksum);
    writeUint32(localHeader, 18, dataBytes.length);
    writeUint32(localHeader, 22, dataBytes.length);
    writeUint16(localHeader, 26, nameBytes.length);
    writeUint16(localHeader, 28, 0);
    localHeader.set(nameBytes, 30);
    localParts.push(localHeader, dataBytes);

    const centralHeader = new Uint8Array(46 + nameBytes.length);
    writeUint32(centralHeader, 0, 0x02014b50);
    writeUint16(centralHeader, 4, 20);
    writeUint16(centralHeader, 6, 20);
    writeUint16(centralHeader, 8, 0);
    writeUint16(centralHeader, 10, 0);
    writeUint16(centralHeader, 12, 0);
    writeUint16(centralHeader, 14, 0);
    writeUint32(centralHeader, 16, checksum);
    writeUint32(centralHeader, 20, dataBytes.length);
    writeUint32(centralHeader, 24, dataBytes.length);
    writeUint16(centralHeader, 28, nameBytes.length);
    writeUint16(centralHeader, 30, 0);
    writeUint16(centralHeader, 32, 0);
    writeUint16(centralHeader, 34, 0);
    writeUint16(centralHeader, 36, 0);
    writeUint32(centralHeader, 38, 0);
    writeUint32(centralHeader, 42, offset);
    centralHeader.set(nameBytes, 46);
    centralParts.push(centralHeader);

    offset += localHeader.length + dataBytes.length;
  });

  const centralDirectory = concatUint8Arrays(centralParts);
  const endRecord = new Uint8Array(22);
  writeUint32(endRecord, 0, 0x06054b50);
  writeUint16(endRecord, 8, files.length);
  writeUint16(endRecord, 10, files.length);
  writeUint32(endRecord, 12, centralDirectory.length);
  writeUint32(endRecord, 16, offset);
  writeUint16(endRecord, 20, 0);

  return concatUint8Arrays([...localParts, centralDirectory, endRecord]);
}

let wordListNumberingInstances = [];
let wordNextListNumberId = 1;

function resetWordNumbering() {
  wordListNumberingInstances = [];
  wordNextListNumberId = 1;
}

function registerWordList(ordered = false) {
  const numId = wordNextListNumberId;
  wordNextListNumberId += 1;
  wordListNumberingInstances.push({ numId, abstractNumId: ordered ? 1 : 0 });
  return numId;
}

function wordRun(value, options = {}) {
  const properties = [];
  if (options.bold) properties.push("<w:b/>");
  if (options.italic) properties.push("<w:i/>");
  if (options.hyperlink) {
    properties.push('<w:color w:val="0563C1"/>');
    properties.push('<w:u w:val="single"/>');
  }
  const runProperties = properties.length ? `<w:rPr>${properties.join("")}</w:rPr>` : "";
  return `<w:r>${runProperties}<w:t xml:space="preserve">${escapeXml(value)}</w:t></w:r>`;
}

function wordPlainTextRuns(value, options = {}) {
  return String(value ?? "")
    .split("\n")
    .map((line, index) => `${index ? "<w:r><w:br/></w:r>" : ""}${line ? wordRun(line, options) : ""}`)
    .join("");
}

function wordHyperlink(label, url, options = {}) {
  const safeUrl = String(url || "").replaceAll('"', "%22");
  const instruction = escapeXml(`HYPERLINK "${safeUrl}"`);
  return `<w:fldSimple w:instr="${instruction}">${wordPlainTextRuns(label, { ...options, hyperlink: true })}</w:fldSimple>`;
}

function wordInlineRuns(value, options = {}, depth = 0) {
  const source = String(value ?? "");
  if (!source || depth > 4) return wordPlainTextRuns(source, options);

  const tokenPattern = /\[([^\]\n]+)\]\(((?:https?:\/\/|mailto:)[^\s)<]+)\)|\*\*([^*\n]+)\*\*|\*([^*\n]+)\*/gi;
  const runs = [];
  let cursor = 0;
  let match;

  while ((match = tokenPattern.exec(source))) {
    if (match.index > cursor) runs.push(wordPlainTextRuns(source.slice(cursor, match.index), options));
    if (match[1] !== undefined) {
      runs.push(wordHyperlink(match[1], match[2], options));
    } else if (match[3] !== undefined) {
      runs.push(wordInlineRuns(match[3], { ...options, bold: true }, depth + 1));
    } else {
      runs.push(wordInlineRuns(match[4], { ...options, italic: true }, depth + 1));
    }
    cursor = tokenPattern.lastIndex;
  }

  if (!runs.length) return wordPlainTextRuns(source, options);
  if (cursor < source.length) runs.push(wordPlainTextRuns(source.slice(cursor), options));
  return runs.join("");
}

function wordParagraph(text, style = "", options = {}) {
  const properties = [];
  if (style) properties.push(`<w:pStyle w:val="${style}"/>`);
  if (options.spacingBefore || options.spacingAfter) {
    properties.push(
      `<w:spacing${options.spacingBefore ? ` w:before="${options.spacingBefore}"` : ""}${options.spacingAfter ? ` w:after="${options.spacingAfter}"` : ""}/>`
    );
  }
  if (options.numId) {
    properties.push(`<w:numPr><w:ilvl w:val="${Math.max(0, Math.min(8, Number(options.numLevel) || 0))}"/><w:numId w:val="${options.numId}"/></w:numPr>`);
  }
  if (options.indentLeft || options.indentRight) {
    properties.push(`<w:ind${options.indentLeft ? ` w:left="${options.indentLeft}"` : ""}${options.indentRight ? ` w:right="${options.indentRight}"` : ""}/>`);
  }
  if (options.align) properties.push(`<w:jc w:val="${options.align}"/>`);
  if (options.keepNext) properties.push("<w:keepNext/>");
  if (options.shading) properties.push(`<w:shd w:fill="${options.shading}"/>`);
  const paragraphProperties = properties.length ? `<w:pPr>${properties.join("")}</w:pPr>` : "";
  return `<w:p>${paragraphProperties}${wordInlineRuns(text, { bold: Boolean(options.bold), italic: Boolean(options.italic) })}</w:p>`;
}

function wordMarkdownBlocks(value, options = {}) {
  const defaultStyle = options.style || "BodyText";
  const tableMode = Boolean(options.tableMode);
  const lines = String(value ?? "").replace(/\r\n?/g, "\n").split("\n");
  const paragraphs = [];
  let paragraphLines = [];
  let activeList = null;

  const closeList = () => {
    activeList = null;
  };
  const flushParagraph = () => {
    if (!paragraphLines.length) return;
    paragraphs.push(wordParagraph(paragraphLines.join("\n"), defaultStyle));
    paragraphLines = [];
  };

  lines.forEach((line) => {
    const trimmed = line.trim();
    if (!trimmed) {
      flushParagraph();
      closeList();
      return;
    }

    const heading = trimmed.match(/^(#{1,6})\s+(.+)$/);
    if (heading) {
      flushParagraph();
      closeList();
      const headingStyle = tableMode
        ? "TableHeading"
        : heading[1].length === 1
          ? "Heading1"
          : heading[1].length === 2
            ? "Heading2"
            : "Heading3";
      paragraphs.push(wordParagraph(heading[2], headingStyle));
      return;
    }

    const unordered = line.match(/^(\s*)[-*+]\s+(.+)$/);
    const ordered = line.match(/^(\s*)\d+[.)]\s+(.+)$/);
    if (unordered || ordered) {
      flushParagraph();
      const isOrdered = Boolean(ordered);
      if (!activeList || activeList.ordered !== isOrdered) {
        activeList = { ordered: isOrdered, numId: registerWordList(isOrdered) };
      }
      const match = ordered || unordered;
      const indentation = match[1].replaceAll("\t", "  ").length;
      paragraphs.push(wordParagraph(match[2], tableMode ? "TableText" : "ListParagraph", {
        numId: activeList.numId,
        numLevel: Math.floor(indentation / 2)
      }));
      return;
    }

    const quote = trimmed.match(/^>\s?(.*)$/);
    if (quote) {
      flushParagraph();
      closeList();
      paragraphs.push(wordParagraph(quote[1], tableMode ? "TableQuote" : "Quote"));
      return;
    }

    closeList();
    paragraphLines.push(line);
  });

  flushParagraph();
  return paragraphs.length ? paragraphs.join("") : wordParagraph("", defaultStyle);
}

function wordSpacer(size = 160) {
  return `<w:p><w:pPr><w:spacing w:after="${size}"/></w:pPr></w:p>`;
}

function wordTableCell(content, options = {}) {
  const width = options.width || 4500;
  const shading = options.shading ? `<w:shd w:fill="${options.shading}"/>` : "";
  const text = Array.isArray(content) ? content.join("\n") : content;
  const cellContent = options.markdown
    ? wordMarkdownBlocks(text, { style: options.style || "TableText", tableMode: true })
    : wordParagraph(text, options.style || "TableText", { bold: Boolean(options.bold) });
  return `<w:tc><w:tcPr><w:tcW w:w="${width}" w:type="dxa"/>${shading}</w:tcPr>${cellContent}</w:tc>`;
}

function wordTable(rows, widths = []) {
  const tableRows = rows
    .map((row) => {
      const cells = row
        .map((cell, cellIndex) =>
          wordTableCell(cell.text ?? cell, {
            width: widths[cellIndex] || 4500,
            shading: cell.shading,
            bold: cell.bold,
            style: cell.style,
            markdown: cell.markdown
          })
        )
        .join("");
      return `<w:tr>${cells}</w:tr>`;
    })
    .join("");
  return `<w:tbl>
    <w:tblPr>
      <w:tblW w:w="0" w:type="auto"/>
      <w:tblBorders>
        <w:top w:val="single" w:sz="6" w:space="0" w:color="D8DEE9"/>
        <w:left w:val="single" w:sz="6" w:space="0" w:color="D8DEE9"/>
        <w:bottom w:val="single" w:sz="6" w:space="0" w:color="D8DEE9"/>
        <w:right w:val="single" w:sz="6" w:space="0" w:color="D8DEE9"/>
        <w:insideH w:val="single" w:sz="6" w:space="0" w:color="D8DEE9"/>
        <w:insideV w:val="single" w:sz="6" w:space="0" w:color="D8DEE9"/>
      </w:tblBorders>
      <w:tblCellMar>
        <w:top w:w="90" w:type="dxa"/>
        <w:left w:w="120" w:type="dxa"/>
        <w:bottom w:w="90" w:type="dxa"/>
        <w:right w:w="120" w:type="dxa"/>
      </w:tblCellMar>
    </w:tblPr>
    ${tableRows}
  </w:tbl>`;
}

function wordFieldTable(rows) {
  return wordTable(
    rows.map(([label, value]) => [
      { text: label, bold: true, shading: "EEF2F7" },
      { text: value || "-", markdown: true }
    ]),
    [3000, 6300]
  );
}

function buildStudentWordBody(sessionIds = null) {
  const body = [];
  const studentExport = buildStudentInstructionsData(sessionIds);
  body.push(wordParagraph(studentExport.title, "Title"));
  body.push(wordParagraph("Consignes pour les élèves", "Heading1"));
  studentExport.sessions.forEach((session) => {
    body.push(wordParagraph(`${session.number}. ${session.title}`, "Heading2"));
    session.activities.forEach((activity) => {
      body.push(wordParagraph(`Activité ${activity.number}`, "Heading3"));
      body.push(wordMarkdownBlocks(activity.instructions || "-", { style: "BodyText" }));
      body.push(wordSpacer(90));
    });
  });
  return body;
}

function buildFullWordBody(sessionIds = null) {
  const designed = splitMinutesToPedagogicalTime(totalExportDesignedMinutes(sessionIds), getDayHours());
  const body = [];
  body.push(wordParagraph(state.meta.name || "Design Learning", "Title"));
  body.push(wordParagraph("Paramètres", "Heading1"));
  body.push(wordFieldTable([
    ["Mode", labelForLocationMode(state.meta.modeDelivery)],
    ["Taille du groupe", state.meta.sizeClass || "-"],
    ["Concepteur(s)", state.meta.designers || "-"],
    ["Enseignant(s)", state.meta.trainers || "-"],
    [
      "Temps d'apprentissage",
      formatPedagogicalTime(
        state.meta.learningDays,
        state.meta.learningHours,
        state.meta.learningMinutes
      )
    ],
    ["Temps conçu", formatPedagogicalTime(designed.days, designed.hours, designed.minutes)],
    ["1 jour", `${getDayHours()} heures`]
  ]));
  body.push(wordSpacer(120));
  if (state.meta.description) {
    body.push(wordParagraph("Description", "Heading2"));
    body.push(wordMarkdownBlocks(state.meta.description, { style: "BodyText" }));
    body.push(wordSpacer(80));
  }
  if (state.meta.command) {
    body.push(wordParagraph("Commande institutionnelle", "Heading2"));
    body.push(wordMarkdownBlocks(state.meta.command, { style: "BodyText" }));
    body.push(wordSpacer(80));
  }
  if (state.meta.personas) {
    body.push(wordParagraph("Objectifs", "Heading2"));
    body.push(wordMarkdownBlocks(state.meta.personas, { style: "BodyText" }));
    body.push(wordSpacer(80));
  }
  if (Array.isArray(state.meta.sliders) && state.meta.sliders.length) {
    body.push(wordParagraph("Acquis d'apprentissage", "Heading2"));
    const outcomeListId = registerWordList(false);
    state.meta.sliders.forEach((outcome) => {
      const label = outcome.verb || outcome.categoryLabel || "";
      body.push(wordParagraph(`${label}${label && outcome.text ? " : " : ""}${outcome.text || ""}`, "ListParagraph", { numId: outcomeListId }));
    });
    body.push(wordSpacer(100));
  }
  body.push(wordParagraph("Séances", "Heading1"));

  getExportSessionEntries(sessionIds).forEach(({ session, sessionIndex }) => {
    body.push(wordParagraph(`${sessionIndex + 1}. ${session.title || defaultSessionTitle(sessionIndex + 1)}`, "Heading2"));
    const sessionRows = [];
    if (session.objectives) sessionRows.push(["Objectifs", session.objectives]);
    if (session.intentions) sessionRows.push(["Choix pédagogiques", session.intentions]);
    if (session.notes) sessionRows.push(["Notes", session.notes]);
    if (sessionRows.length) {
      body.push(wordFieldTable(sessionRows));
      body.push(wordSpacer(80));
    }
    session.activities.forEach((activity, activityIndex) => {
      const links = activity.links && activity.links.length
        ? activity.links.map((link) => `[${link.title}](${link.url})`).join("\n")
        : "";
      let toolLabels = "";
      if (activity.tools && activity.tools.length) {
        toolLabels = activity.tools
          .map((id) => SELECTABLE_TOOLS_DATA.find((tool) => tool.id === id))
          .filter(Boolean)
          .map((tool) => formatCompetencyLabel(tool, "fr"))
          .join(", ");
      }
      body.push(wordParagraph(`${sessionIndex + 1}.${activityIndex + 1} ${labelForType(activity.type)}`, "Heading3"));
      body.push(wordFieldTable([
        ["Durée", `${activity.duration} min`],
        ["Groupe", labelForGroupMode(activity.groupMode)],
        ["Enseignant", labelForTrainerMode(activity.teacherPresence)],
        ["Rythme", labelForSyncMode(activity.syncMode)],
        ["Modalité", labelForLocationMode(activity.locationMode)],
        ["Évaluation", labelForEvaluationMode(activity.evaluationMode)],
        ["AIAS", aiasSummary(activity.aias)],
        ["Description", activity.description || "-"],
        ["Consignes pour les élèves", activity.instructions || "-"],
        ["Liens", links || "-"],
        ["Compétences", toolLabels || "-"]
      ]));
      body.push(wordSpacer(activityIndex === session.activities.length - 1 ? 150 : 70));
    });
  });
  return body;
}

function buildWordExportDocument(scope = "full", sessionIds = null) {
  resetWordNumbering();
  const body = normalizeExportScope(scope) === "students"
    ? buildStudentWordBody(sessionIds)
    : buildFullWordBody(sessionIds);

  const documentXml = `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:body>
    ${body.join("\n    ")}
    <w:sectPr><w:pgSz w:w="11906" w:h="16838"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440"/></w:sectPr>
  </w:body>
</w:document>`;

  const stylesXml = `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:docDefaults>
    <w:rPrDefault><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial"/><w:sz w:val="21"/><w:color w:val="1F2937"/></w:rPr></w:rPrDefault>
    <w:pPrDefault><w:pPr><w:spacing w:after="120" w:line="276" w:lineRule="auto"/></w:pPr></w:pPrDefault>
  </w:docDefaults>
  <w:style w:type="paragraph" w:default="1" w:styleId="Normal"><w:name w:val="Normal"/><w:qFormat/></w:style>
  <w:style w:type="paragraph" w:styleId="Title"><w:name w:val="Title"/><w:basedOn w:val="Normal"/><w:next w:val="BodyText"/><w:qFormat/><w:pPr><w:spacing w:after="340"/></w:pPr><w:rPr><w:b/><w:color w:val="123B6D"/><w:sz w:val="36"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading1"><w:name w:val="heading 1"/><w:basedOn w:val="Normal"/><w:next w:val="BodyText"/><w:uiPriority w:val="9"/><w:qFormat/><w:pPr><w:keepNext/><w:spacing w:before="420" w:after="180"/><w:outlineLvl w:val="0"/></w:pPr><w:rPr><w:b/><w:color w:val="145BB4"/><w:sz w:val="30"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading2"><w:name w:val="heading 2"/><w:basedOn w:val="Normal"/><w:next w:val="BodyText"/><w:uiPriority w:val="9"/><w:qFormat/><w:pPr><w:keepNext/><w:spacing w:before="300" w:after="140"/><w:outlineLvl w:val="1"/></w:pPr><w:rPr><w:b/><w:color w:val="1F4D7A"/><w:sz w:val="25"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Heading3"><w:name w:val="heading 3"/><w:basedOn w:val="Normal"/><w:next w:val="BodyText"/><w:uiPriority w:val="9"/><w:qFormat/><w:pPr><w:keepNext/><w:spacing w:before="220" w:after="100"/><w:outlineLvl w:val="2"/></w:pPr><w:rPr><w:b/><w:color w:val="243B53"/><w:sz w:val="22"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="BodyText"><w:name w:val="Body Text"/><w:basedOn w:val="Normal"/><w:pPr><w:spacing w:after="140"/></w:pPr><w:rPr><w:sz w:val="21"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="TableText"><w:name w:val="Table Text"/><w:basedOn w:val="Normal"/><w:pPr><w:spacing w:after="0"/></w:pPr><w:rPr><w:sz w:val="19"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="TableHeading"><w:name w:val="Table Heading"/><w:basedOn w:val="TableText"/><w:next w:val="TableText"/><w:pPr><w:keepNext/><w:spacing w:before="100" w:after="50"/></w:pPr><w:rPr><w:b/><w:color w:val="1F4D7A"/><w:sz w:val="20"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="Quote"><w:name w:val="Quote"/><w:basedOn w:val="BodyText"/><w:pPr><w:spacing w:after="120"/><w:ind w:left="540" w:right="240"/><w:shd w:fill="F3F6FA"/></w:pPr><w:rPr><w:i/><w:color w:val="475569"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="TableQuote"><w:name w:val="Table Quote"/><w:basedOn w:val="TableText"/><w:pPr><w:spacing w:after="40"/><w:ind w:left="300" w:right="120"/><w:shd w:fill="F3F6FA"/></w:pPr><w:rPr><w:i/><w:color w:val="475569"/></w:rPr></w:style>
  <w:style w:type="paragraph" w:styleId="ListParagraph"><w:name w:val="List Paragraph"/><w:basedOn w:val="Normal"/><w:pPr><w:spacing w:after="90"/><w:ind w:left="720"/></w:pPr><w:rPr><w:sz w:val="21"/></w:rPr></w:style>
</w:styles>`;

  const numberingLevelXml = (level, ordered) => {
    const left = 720 + (level * 360);
    const bullets = ["•", "◦", "▪"];
    const levelText = ordered
      ? `${Array.from({ length: level + 1 }, (_, index) => `%${index + 1}`).join(".")}.`
      : bullets[level % bullets.length];
    return `<w:lvl w:ilvl="${level}">
      <w:start w:val="1"/>
      <w:numFmt w:val="${ordered ? "decimal" : "bullet"}"/>
      <w:lvlText w:val="${levelText}"/>
      <w:lvlJc w:val="left"/>
      <w:pPr><w:tabs><w:tab w:val="num" w:pos="${left}"/></w:tabs><w:ind w:left="${left}" w:hanging="360"/></w:pPr>
      ${ordered ? "" : '<w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial"/></w:rPr>'}
    </w:lvl>`;
  };
  const numberingXml = `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:numbering xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:abstractNum w:abstractNumId="0"><w:multiLevelType w:val="hybridMultilevel"/>${Array.from({ length: 9 }, (_, level) => numberingLevelXml(level, false)).join("")}</w:abstractNum>
  <w:abstractNum w:abstractNumId="1"><w:multiLevelType w:val="multilevel"/>${Array.from({ length: 9 }, (_, level) => numberingLevelXml(level, true)).join("")}</w:abstractNum>
  ${wordListNumberingInstances.map(({ numId, abstractNumId }) => {
    const restartOverrides = abstractNumId === 1
      ? Array.from({ length: 9 }, (_, level) => `<w:lvlOverride w:ilvl="${level}"><w:startOverride w:val="1"/></w:lvlOverride>`).join("")
      : "";
    return `<w:num w:numId="${numId}"><w:abstractNumId w:val="${abstractNumId}"/>${restartOverrides}</w:num>`;
  }).join("")}
</w:numbering>`;

  return createZipArchive([
    {
      name: "[Content_Types].xml",
      content: `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
  <Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>
  <Override PartName="/word/numbering.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.numbering+xml"/>
</Types>`
    },
    {
      name: "_rels/.rels",
      content: `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>`
    },
    {
      name: "word/_rels/document.xml.rels",
      content: `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/numbering" Target="numbering.xml"/>
</Relationships>`
    },
    { name: "word/document.xml", content: documentXml },
    { name: "word/styles.xml", content: stylesXml },
    { name: "word/numbering.xml", content: numberingXml }
  ]);
}

function buildStudentSpreadsheetRows(sessionIds = null) {
  const rows = [STUDENT_SPREADSHEET_COLUMNS.map((column) => column.label)];
  const studentExport = buildStudentInstructionsData(sessionIds);
  studentExport.sessions.forEach((session) => {
    if (!session.activities.length) {
      rows.push([studentExport.title, session.number, session.title, "", ""]);
      return;
    }
    session.activities.forEach((activity) => {
      rows.push([
        studentExport.title,
        session.number,
        session.title,
        activity.number,
        activity.instructions
      ]);
    });
  });
  return rows;
}

function buildSpreadsheetRows(scope = "full", sessionIds = null) {
  if (normalizeExportScope(scope) === "students") return buildStudentSpreadsheetRows(sessionIds);
  const designed = splitMinutesToPedagogicalTime(totalExportDesignedMinutes(sessionIds), getDayHours());
  const metaLearningTime = formatPedagogicalTime(
    state.meta.learningDays,
    state.meta.learningHours,
    state.meta.learningMinutes
  );
  const metaDesignedTime = formatPedagogicalTime(designed.days, designed.hours, designed.minutes);
  const rows = [];
  rows.push(SPREADSHEET_COLUMNS.map((column) => column.label));

  getExportSessionEntries(sessionIds).forEach(({ session, sessionIndex }) => {
    if (!session.activities.length) {
      rows.push(
        [
          sessionIndex + 1,
          session.title || "",
          session.objectives || "",
          session.intentions || "",
          session.notes || "",
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          state.meta.name || "",
          labelForLocationMode(state.meta.modeDelivery),
          state.meta.sizeClass || "",
          state.meta.designers || "",
          state.meta.trainers || "",
          metaLearningTime,
          metaDesignedTime,
          getDayHours(),
          state.meta.description || "",
          state.meta.command || "",
          state.meta.personas || "",
          slidersToString(state.meta.sliders)
        ]
      );
      return;
    }

    session.activities.forEach((activity, activityIndex) => {
      rows.push(
        [
          sessionIndex + 1,
          session.title || "",
          session.objectives || "",
          session.intentions || "",
          session.notes || "",
          activityIndex + 1,
          labelForType(activity.type),
          activity.duration,
          labelForGroupMode(activity.groupMode),
          labelForTrainerMode(activity.teacherPresence),
          labelForSyncMode(activity.syncMode),
          labelForLocationMode(activity.locationMode),
          labelForEvaluationMode(activity.evaluationMode),
          aiasSummary(activity.aias),
          activity.description || "",
          activity.instructions || "",
          activity.notes || "",
          (activity.tools || [])
            .map((id) => SELECTABLE_TOOLS_DATA.find((tool) => tool.id === id)?.shortCode || id)
            .join(";"),
          state.meta.name || "",
          labelForLocationMode(state.meta.modeDelivery),
          state.meta.sizeClass || "",
          state.meta.designers || "",
          state.meta.trainers || "",
          metaLearningTime,
          metaDesignedTime,
          getDayHours(),
          state.meta.description || "",
          state.meta.command || "",
          state.meta.personas || "",
          slidersToString(state.meta.sliders)
        ]
      );
    });
  });

  return rows;
}

const SPREADSHEET_COLUMNS = [
  { key: "session_index", label: "N° de séance", width: 12 },
  { key: "session_title", label: "Titre de la séance", width: 20 },
  { key: "session_objectives", label: "Objectifs de la séance", width: 34 },
  { key: "session_intentions", label: "Choix pédagogiques de la séance", width: 34 },
  { key: "session_notes", label: "Notes de la séance", width: 24 },
  { key: "activity_index", label: "N° d'activité", width: 12 },
  { key: "learning_type", label: "Type d'apprentissage", width: 18 },
  { key: "duration_minutes", label: "Durée (minutes)", width: 16 },
  { key: "group_size", label: "Organisation du groupe", width: 18 },
  { key: "trainer_presence", label: "Présence de l'enseignant", width: 20 },
  { key: "pacing", label: "Rythme", width: 14 },
  { key: "delivery_mode", label: "Modalité", width: 14 },
  { key: "assessment", label: "Évaluation", width: 18 },
  { key: "aias", label: "AIAS", width: 28 },
  { key: "activity_description", label: "Description de l'activité", width: 34 },
  { key: "activity_instructions", label: "Consignes pour les élèves", width: 34 },
  { key: "activity_notes", label: "Notes de l'activité", width: 24 },
  { key: "activity_competencies", label: "Compétences", width: 22 },
  { key: "design_title", label: "Titre du design", width: 22 },
  { key: "design_mode", label: "Mode du design", width: 16 },
  { key: "design_group_size", label: "Taille du groupe", width: 16 },
  { key: "design_designers", label: "Concepteur(s)", width: 18 },
  { key: "design_trainers", label: "Enseignant(s)", width: 18 },
  { key: "design_learning_time", label: "Temps d'apprentissage prévu", width: 22 },
  { key: "design_designed_time", label: "Temps conçu", width: 16 },
  { key: "design_day_hours", label: "Heures par jour", width: 14 },
  { key: "design_description", label: "Description du design", width: 30 },
  { key: "design_institutional_brief", label: "Commande institutionnelle", width: 30 },
  { key: "design_personas", label: "Personas", width: 26 },
  { key: "design_sliders", label: "Objectifs / curseurs", width: 26 }
];

const STUDENT_SPREADSHEET_COLUMNS = [
  { key: "design_title", label: "Titre du scénario", width: 28 },
  { key: "session_index", label: "N° de séance", width: 12 },
  { key: "session_title", label: "Titre de la séance", width: 24 },
  { key: "activity_index", label: "N° d’activité", width: 12 },
  { key: "activity_instructions", label: "Consignes pour les élèves", width: 60 }
];

function buildExcelExportDocument(scope = "full", sessionIds = null) {
  const normalizedScope = normalizeExportScope(scope);
  const columns = normalizedScope === "students" ? STUDENT_SPREADSHEET_COLUMNS : SPREADSHEET_COLUMNS;
  const rows = buildSpreadsheetRows(normalizedScope, sessionIds);
  const columnsXml = columns
    .map((column, index) => {
      const columnIndex = index + 1;
      return `<col min="${columnIndex}" max="${columnIndex}" width="${column.width}" customWidth="1"/>`;
    })
    .join("");
  const sheetRows = rows
    .map((row, rowIndex) => {
      const cells = row
        .map((cell, cellIndex) => {
          const reference = `${excelColumnName(cellIndex + 1)}${rowIndex + 1}`;
          return `<c r="${reference}" t="inlineStr"><is><t xml:space="preserve">${escapeXml(cell)}</t></is></c>`;
        })
        .join("");
      return `<row r="${rowIndex + 1}">${cells}</row>`;
    })
    .join("");

  const sheetXml = `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <sheetViews><sheetView workbookViewId="0"/></sheetViews>
  <sheetFormatPr defaultRowHeight="15"/>
  <cols>${columnsXml}</cols>
  <sheetData>${sheetRows}</sheetData>
</worksheet>`;

  const workbookXml = `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheets>
    <sheet name="${normalizedScope === "students" ? "Consignes élèves" : "Design"}" sheetId="1" r:id="rId1"/>
  </sheets>
</workbook>`;

  return createZipArchive([
    {
      name: "[Content_Types].xml",
      content: `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
</Types>`
    },
    {
      name: "_rels/.rels",
      content: `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>`
    },
    {
      name: "xl/_rels/workbook.xml.rels",
      content: `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
</Relationships>`
    },
    { name: "xl/workbook.xml", content: workbookXml },
    { name: "xl/worksheets/sheet1.xml", content: sheetXml }
  ]);
}

function excelColumnName(index) {
  let column = "";
  let value = Math.max(1, Number(index) || 1);
  while (value > 0) {
    value -= 1;
    column = String.fromCharCode(65 + (value % 26)) + column;
    value = Math.floor(value / 26);
  }
  return column;
}

function normalizeToken(value) {
  return String(value ?? "")
    .trim()
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "");
}

function parseCsvRows(text) {
  const source = String(text ?? "").replace(/^\uFEFF/, "");
  const rows = [];
  let row = [];
  let cell = "";
  let inQuotes = false;

  for (let index = 0; index < source.length; index += 1) {
    const char = source[index];
    if (inQuotes) {
      if (char === '"') {
        if (source[index + 1] === '"') {
          cell += '"';
          index += 1;
        } else {
          inQuotes = false;
        }
      } else {
        cell += char;
      }
      continue;
    }
    if (char === '"') {
      inQuotes = true;
      continue;
    }
    if (char === ",") {
      row.push(cell);
      cell = "";
      continue;
    }
    if (char === "\n") {
      row.push(cell);
      rows.push(row);
      row = [];
      cell = "";
      continue;
    }
    if (char === "\r") continue;
    cell += char;
  }

  if (cell.length > 0 || row.length > 0) {
    row.push(cell);
    rows.push(row);
  }
  return rows;
}

function buildLookup(entries) {
  const map = {};
  entries.forEach(([code, ...labels]) => {
    [code, ...labels].forEach((label) => {
      const token = normalizeToken(label);
      if (token) map[token] = code;
    });
  });
  return map;
}

function buildSpreadsheetHeaderIndex(headerRow) {
  const headerIndex = {};
  headerRow.forEach((header, index) => {
    const token = normalizeToken(header);
    if (!token) return;
    headerIndex[token] = index;
  });

  SPREADSHEET_COLUMNS.forEach(({ key, label }) => {
    [key, label].forEach((header) => {
      const token = normalizeToken(header);
      if (token && headerIndex[token] != null && headerIndex[key] == null) {
        headerIndex[key] = headerIndex[token];
      }
    });
  });

  return headerIndex;
}

const CSV_TYPE_LOOKUP = buildLookup([
  ["undefined", I18N.fr.lt_undefined, I18N.en.lt_undefined],
  ["read", I18N.fr.lt_read, I18N.en.lt_read],
  ["investigate", I18N.fr.lt_investigate, I18N.en.lt_investigate],
  ["practice", I18N.fr.lt_practice, I18N.en.lt_practice],
  ["produce", I18N.fr.lt_produce, I18N.en.lt_produce],
  ["discuss", I18N.fr.lt_discuss, I18N.en.lt_discuss],
  ["collaborate", I18N.fr.lt_collaborate, I18N.en.lt_collaborate]
]);

const CSV_GROUP_LOOKUP = buildLookup([
  ["whole", I18N.fr.group_whole, I18N.en.group_whole, "whole class"],
  ["subgroups", I18N.fr.group_subgroups, I18N.en.group_subgroups, "subgroups"],
  ["individual", I18N.fr.group_individual, I18N.en.group_individual]
]);

const CSV_TRAINER_LOOKUP = buildLookup([
  ["present", I18N.fr.trainer_present, I18N.en.trainer_present, I18N.fr.teacherPresentLabel, I18N.en.teacherPresentLabel],
  ["absent", I18N.fr.trainer_absent, I18N.en.trainer_absent, I18N.fr.teacherAbsentLabel, I18N.en.teacherAbsentLabel]
]);

const CSV_SYNC_LOOKUP = buildLookup([
  ["sync", I18N.fr.sync_sync, I18N.en.sync_sync, "synchronous"],
  ["async", I18N.fr.sync_async, I18N.en.sync_async, "asynchronous"]
]);

const CSV_LOCATION_LOOKUP = buildLookup([
  ["onsite", I18N.fr.modeOnsite, I18N.en.modeOnsite, "presentiel", "face to face", "classroom", "classroom-based"],
  ["online", I18N.fr.modeOnline, I18N.en.modeOnline, "distanciel", "distance"],
  ["hybrid", I18N.fr.modeHybrid, I18N.en.modeHybrid, "hybride", "blended"]
]);

const CSV_EVAL_LOOKUP = buildLookup([
  ["none", I18N.fr.eval_none, I18N.en.eval_none, "aucune evaluation", "none"],
  ["diagnostic", I18N.fr.eval_diagnostic, I18N.en.eval_diagnostic],
  ["formative", I18N.fr.eval_formative, I18N.en.eval_formative],
  ["summative", I18N.fr.eval_summative, I18N.en.eval_summative],
  ["certificative", I18N.fr.eval_certificative, I18N.en.eval_certificative, "certifying"]
]);

function lookupValue(raw, lookup, fallback) {
  return lookup[normalizeToken(raw)] || fallback;
}

function parseCsvInteger(value, fallback = 0) {
  const parsed = Number.parseInt(String(value ?? "").trim(), 10);
  if (!Number.isFinite(parsed)) return fallback;
  return parsed;
}

function parseCsvPedagogicalTime(value, dayHours = DEFAULT_DAY_HOURS) {
  const values = String(value ?? "")
    .match(/\d+/g)
    ?.map((part) => Number.parseInt(part, 10))
    .filter((num) => Number.isFinite(num)) || [];
  const days = values[0] ?? 0;
  const hours = values[1] ?? 0;
  const minutes = values[2] ?? 0;
  return normalizePedagogicalTime(days, hours, minutes, dayHours);
}

function parseLegacyLearningType(value) {
  return lookupValue(value, CSV_TYPE_LOOKUP, "read");
}

function parseLegacyEvaluationType(value) {
  return lookupValue(value, CSV_EVAL_LOOKUP, "none");
}

function parseLegacyGroupMode(groupSize, groupSizeSameAsSession, sessionGroupSize) {
  if (groupSizeSameAsSession) {
    return Number(sessionGroupSize) > 1 ? "whole" : "individual";
  }
  const size = Math.max(0, parseCsvInteger(groupSize, 0));
  if (size <= 1) return "individual";
  if (size < Math.max(2, Number(sessionGroupSize) || 15)) return "subgroups";
  return "whole";
}

function isLegacyLdjDocument(parsed) {
  return Boolean(
    parsed &&
    typeof parsed === "object" &&
    Array.isArray(parsed.activities) &&
    !Array.isArray(parsed.sessions)
  );
}

function buildStateFromLegacyLdj(parsed) {
  if (!isLegacyLdjDocument(parsed)) return null;

  const imported = createNewDesignState();
  const topic = toPlainTextareaValue(parsed.topic).trim();
  const description = toPlainTextareaValue(parsed.description).trim();
  const aims = toPlainTextareaValue(parsed.aims).trim();
  const outcomes = Array.isArray(parsed.outcomes)
    ? parsed.outcomes
        .map((item) => {
          const text = toPlainTextareaValue(item?.details).trim();
          const verb = toPlainTextareaValue(item?.verb).trim();
          return { id: nextId(), category: "", categoryLabel: "", verb, text };
        })
        .filter((o) => o.verb || o.text)
    : [];

  imported.meta.uiLanguage = currentLang();
  imported.meta.name = toPlainTextareaValue(parsed.name).trim();
  imported.meta.modeDelivery = lookupValue(parsed.modeOfDelivery, CSV_LOCATION_LOOKUP, "onsite");
  imported.meta.sizeClass = toPlainTextareaValue(parsed.groupSize).trim();
  imported.meta.designers = toPlainTextareaValue(parsed.author).trim();
  imported.meta.description = description;
  imported.meta.command = topic;
  imported.meta.personas = aims;
  imported.meta.sliders = outcomes;

  const learningTime = parseCsvPedagogicalTime(parsed.learningTime, imported.meta.dayHours);
  imported.meta.learningDays = learningTime.days;
  imported.meta.learningHours = learningTime.hours;
  imported.meta.learningMinutes = learningTime.minutes;

  imported.sessions = parsed.activities.map((legacySession, sessionIndex) => {
    const sessionGroupSize = parseCsvInteger(
      legacySession?.groupSize ?? parsed.groupSize,
      parseCsvInteger(parsed.groupSize, 0)
    );
    const session = {
      id: nextId(),
      title: toPlainTextareaValue(legacySession?.title).trim() || defaultSessionTitle(sessionIndex + 1),
      objectives: "",
      intentions: toPlainTextareaValue(legacySession?.teachingMethod).trim(),
      notes: toPlainTextareaValue(legacySession?.notes).trim(),
      notesExpanded: false,
      activities: []
    };

    const resources = Array.isArray(legacySession?.resources)
      ? legacySession.resources.map((value) => toPlainTextareaValue(value).trim()).filter(Boolean)
      : [];
    if (resources.length) {
      session.notes = [session.notes, resources.join("\n")].filter(Boolean).join("\n\n");
    }

    session.activities = Array.isArray(legacySession?.slas)
      ? legacySession.slas.map((legacyActivity) => {
          const activity = {
            id: nextId(),
            type: parseLegacyLearningType(legacyActivity?.type),
            duration: Math.max(1, parseCsvInteger(legacyActivity?.duration, 1)),
            groupMode: parseLegacyGroupMode(
              legacyActivity?.groupSize,
              String(legacyActivity?.groupSizeSameAsSession) === "true",
              sessionGroupSize
            ),
            teacherPresence: String(legacyActivity?.tutorAvailable) === "true" ? "present" : "absent",
            syncMode: String(legacyActivity?.syncActivity) === "true" ? "sync" : "async",
            locationMode: String(legacyActivity?.onlineActivity) === "true" ? "online" : "onsite",
            evaluationMode: parseLegacyEvaluationType(legacyActivity?.assessmentType),
            description: toPlainTextareaValue(legacyActivity?.description).trim(),
            instructions: toPlainTextareaValue(
              legacyActivity?.instructions ?? legacyActivity?.studentInstructions
            ).trim(),
            notes: "",
            tools: [],
            links: []
          };

          const activityResources = Array.isArray(legacyActivity?.resources)
            ? legacyActivity.resources.map((value) => toPlainTextareaValue(value).trim()).filter(Boolean)
            : [];
          if (activityResources.length) {
            activity.notes = activityResources.join("\n");
          }
          normalizeActivity(activity);
          return activity;
        })
      : [];

    return session;
  });

  return hydrateState(imported, null);
}

function buildStateFromCsv(csvText) {
  const rows = parseCsvRows(csvText);
  if (rows.length < 2) return null;

  const headerIndex = buildSpreadsheetHeaderIndex(rows[0]);
  if (headerIndex.session_index == null || headerIndex.session_title == null) return null;

  const dataRows = rows.slice(1).filter((row) => row.some((cell) => String(cell || "").trim() !== ""));
  if (!dataRows.length) return null;

  const imported = createNewDesignState();
  imported.meta.uiLanguage = currentLang();
  const sessions = [];
  const sessionsByIndex = new Map();
  let metaLoaded = false;

  dataRows.forEach((row, rowIndex) => {
    const read = (name) => {
      const index = headerIndex[name];
      if (index == null) return "";
      return String(row[index] ?? "");
    };

    if (!metaLoaded) {
      const dayHours = Math.max(1, parseCsvInteger(read("design_day_hours"), DEFAULT_DAY_HOURS));
      imported.meta.name = read("design_title");
      imported.meta.modeDelivery = lookupValue(read("design_mode"), CSV_LOCATION_LOOKUP, "onsite");
      imported.meta.sizeClass = read("design_group_size").trim();
      imported.meta.designers = read("design_designers");
      imported.meta.trainers = read("design_trainers");
      imported.meta.dayHours = dayHours;
      imported.meta.description = read("design_description");
      imported.meta.command = read("design_institutional_brief");
      imported.meta.personas = read("design_personas");
      imported.meta.sliders = read("design_sliders");

      const learningTime = parseCsvPedagogicalTime(read("design_learning_time"), dayHours);
      imported.meta.learningDays = learningTime.days;
      imported.meta.learningHours = learningTime.hours;
      imported.meta.learningMinutes = learningTime.minutes;
      metaLoaded = true;
    }

    const sessionOrder = parseCsvInteger(read("session_index"), rowIndex + 1);
    const sessionTitle = read("session_title").trim() || defaultSessionTitle(sessionOrder || sessions.length + 1);
    const sessionObjectives = read("session_objectives");
    const sessionIntentions = read("session_intentions");
    const sessionNotes = read("session_notes");
    const sessionKey = `${sessionOrder}`;
    let session = sessionsByIndex.get(sessionKey);
    if (!session) {
      session = {
        id: nextId(),
        title: sessionTitle,
        objectives: sessionObjectives,
        intentions: sessionIntentions,
        notes: sessionNotes,
        notesExpanded: false,
        activities: []
      };
      sessionsByIndex.set(sessionKey, session);
      sessions.push(session);
    } else {
      if (!session.title && sessionTitle) session.title = sessionTitle;
      if (!session.objectives && sessionObjectives) session.objectives = sessionObjectives;
      if (!session.intentions && sessionIntentions) session.intentions = sessionIntentions;
      if (!session.notes && sessionNotes) session.notes = sessionNotes;
    }

    const hasActivityData = [
      read("activity_index"),
      read("learning_type"),
      read("duration_minutes"),
      read("group_size"),
      read("trainer_presence"),
      read("pacing"),
      read("delivery_mode"),
      read("assessment"),
      read("aias"),
      read("activity_description"),
      read("activity_instructions"),
      read("activity_notes")
    ].some((value) => value.trim() !== "");
    if (!hasActivityData) return;

    const duration = Math.max(1, parseCsvInteger(read("duration_minutes"), 1));
    const activity = {
      id: nextId(),
      type: lookupValue(read("learning_type"), CSV_TYPE_LOOKUP, "read"),
      duration,
      groupMode: lookupValue(read("group_size"), CSV_GROUP_LOOKUP, "whole"),
      teacherPresence: lookupValue(read("trainer_presence"), CSV_TRAINER_LOOKUP, "present"),
      syncMode: lookupValue(read("pacing"), CSV_SYNC_LOOKUP, "sync"),
      locationMode: lookupValue(read("delivery_mode"), CSV_LOCATION_LOOKUP, "onsite"),
      evaluationMode: lookupValue(read("assessment"), CSV_EVAL_LOOKUP, "none"),
      aias: parseAiasValue(read("aias")),
      description: read("activity_description"),
      instructions: read("activity_instructions"),
      notes: read("activity_notes"),
      tools: (read("activity_competencies") || read("activity_tools")).split(";").map(s => s.trim()).filter(Boolean),
      _csvOrder: parseCsvInteger(read("activity_index"), session.activities.length + 1)
    };
    normalizeActivity(activity);
    session.activities.push(activity);
  });

  sessions.forEach((session) => {
    session.activities.sort((a, b) => a._csvOrder - b._csvOrder);
    session.activities.forEach((activity) => {
      delete activity._csvOrder;
    });
  });

  imported.sessions = sessions;
  return hydrateState(imported, null);
}

function cleanMarkdownExportValue(value) {
  const trimmed = String(value ?? "").trim();
  return trimmed === "-" ? "" : trimmed;
}

function parseMarkdownFieldLine(line) {
  const match = String(line || "").match(/^-\s*([^:]+):\s*(.*)$/);
  if (!match) return null;
  return {
    key: normalizeToken(match[1]),
    value: cleanMarkdownExportValue(match[2])
  };
}

function readMarkdownBlock(lines, startIndex) {
  const block = [];
  let index = startIndex;
  while (index < lines.length && !/^#{2,3}\s+/.test(lines[index])) {
    block.push(lines[index]);
    index += 1;
  }
  return {
    value: cleanMarkdownExportValue(block.join("\n").trim()),
    nextIndex: index
  };
}

function parseMarkdownLinks(value) {
  const links = [];
  const pattern = /([^(),]+?)\s*\((https?:\/\/[^)]+)\)/g;
  let match;
  while ((match = pattern.exec(String(value || ""))) !== null) {
    const title = match[1].trim();
    const url = match[2].trim();
    if (title && url) links.push({ id: nextId(), title, url });
  }
  return links;
}

function buildStateFromMarkdown(markdownText) {
  const lines = String(markdownText ?? "").replace(/^\uFEFF/, "").replace(/\r\n?/g, "\n").split("\n");
  const firstTitle = lines.find((line) => /^#\s+/.test(line));
  if (
    !firstTitle ||
    !lines.some((line) => /^##\s+Paramètres\s*$/i.test(line)) ||
    !lines.some((line) => /^##\s+Séances\s*$/i.test(line))
  ) {
    return null;
  }

  const imported = createNewDesignState();
  imported.meta.uiLanguage = currentLang();
  imported.meta.name = cleanMarkdownExportValue(firstTitle.replace(/^#\s+/, ""));

  let index = 0;
  let inSettings = false;
  let inSessions = false;
  let currentSession = null;
  let currentActivity = null;

  const pushCurrentActivity = () => {
    if (currentSession && currentActivity) {
      normalizeActivity(currentActivity);
      currentSession.activities.push(currentActivity);
    }
    currentActivity = null;
  };

  const pushCurrentSession = () => {
    pushCurrentActivity();
    if (currentSession) imported.sessions.push(currentSession);
    currentSession = null;
  };

  while (index < lines.length) {
    const line = lines[index];

    if (/^##\s+Paramètres\s*$/i.test(line)) {
      pushCurrentSession();
      inSettings = true;
      inSessions = false;
      index += 1;
      continue;
    }

    if (/^##\s+Séances\s*$/i.test(line)) {
      inSettings = false;
      inSessions = true;
      index += 1;
      continue;
    }

    if (inSettings) {
      const dayHoursMatch = line.match(/^-\s*1 jour\s*=\s*(\d+)/i);
      if (dayHoursMatch) {
        imported.meta.dayHours = Math.max(1, parseCsvInteger(dayHoursMatch[1], DEFAULT_DAY_HOURS));
        index += 1;
        continue;
      }

      const field = parseMarkdownFieldLine(line);
      if (field) {
        if (field.key === "mode") imported.meta.modeDelivery = lookupValue(field.value, CSV_LOCATION_LOOKUP, "");
        if (field.key === "taille du groupe") imported.meta.sizeClass = field.value;
        if (field.key === "concepteur(s)") imported.meta.designers = field.value;
        if (field.key === "enseignant(s)") imported.meta.trainers = field.value;
        if (field.key === "temps d'apprentissage") {
          const learningTime = parseCsvPedagogicalTime(field.value, imported.meta.dayHours);
          imported.meta.learningDays = learningTime.days;
          imported.meta.learningHours = learningTime.hours;
          imported.meta.learningMinutes = learningTime.minutes;
        }
        index += 1;
        continue;
      }

      const settingSection = line.match(/^###\s+(.+)$/);
      if (settingSection) {
        const title = normalizeToken(settingSection[1]);
        if (title === "description" || title === "commande institutionnelle" || title === "objectifs") {
          const block = readMarkdownBlock(lines, index + 1);
          if (title === "description") imported.meta.description = block.value;
          if (title === "commande institutionnelle") imported.meta.command = block.value;
          if (title === "objectifs") imported.meta.personas = block.value;
          index = block.nextIndex;
          continue;
        }
        if (title === "acquis d'apprentissage") {
          const outcomes = [];
          index += 1;
          while (index < lines.length && !/^#{2,3}\s+/.test(lines[index])) {
            const outcome = String(lines[index] || "").match(/^-\s*(.*)$/);
            if (outcome) {
              const text = outcome[1].trim();
              const parts = text.split(/\s+:\s+/);
              outcomes.push({
                id: nextId(),
                category: "",
                categoryLabel: "",
                verb: parts.length > 1 ? parts.shift().trim() : "",
                text: parts.join(" : ").trim() || text
              });
            }
            index += 1;
          }
          imported.meta.sliders = outcomes.filter((outcome) => outcome.verb || outcome.text);
          continue;
        }
      }
    }

    if (inSessions) {
      const sessionHeading = line.match(/^##\s+\d+\.\s*(.*)$/);
      if (sessionHeading) {
        pushCurrentSession();
        currentSession = {
          id: nextId(),
          title: cleanMarkdownExportValue(sessionHeading[1]) || defaultSessionTitle(imported.sessions.length + 1),
          objectives: "",
          intentions: "",
          notes: "",
          notesExpanded: false,
          activities: []
        };
        index += 1;
        continue;
      }

      const activityHeading = line.match(/^###\s+\d+\.\d+\s*(.*)$/);
      if (activityHeading && currentSession) {
        pushCurrentActivity();
        currentActivity = {
          id: nextId(),
          type: lookupValue(activityHeading[1], CSV_TYPE_LOOKUP, "undefined"),
          duration: 1,
          groupMode: "whole",
          teacherPresence: "present",
          syncMode: "sync",
          locationMode: "onsite",
          evaluationMode: "none",
          aias: defaultAiasState(),
          description: "",
          instructions: "",
          notes: "",
          tools: [],
          links: []
        };
        index += 1;
        continue;
      }

      if (currentSession && /^>\s*/.test(line)) {
        const label = normalizeToken(line.replace(/^>\s*/, "").replace(/:$/, ""));
        if (["objectifs", "choix pedagogiques", "notes"].includes(label)) {
          const quoteLines = [];
          index += 1;
          while (index < lines.length && /^>\s*/.test(lines[index])) {
            const nextQuoteLabel = normalizeToken(lines[index].replace(/^>\s*/, "").replace(/:$/, ""));
            if (["objectifs", "choix pedagogiques", "notes"].includes(nextQuoteLabel)) break;
            quoteLines.push(lines[index].replace(/^>\s?/, ""));
            index += 1;
          }
          const value = cleanMarkdownExportValue(quoteLines.join("\n"));
          if (label === "objectifs") currentSession.objectives = value;
          if (label === "choix pedagogiques") currentSession.intentions = value;
          if (label === "notes") currentSession.notes = value;
          continue;
        }
      }

      if (currentActivity) {
        const field = parseMarkdownFieldLine(line);
        if (field) {
          if (field.key === "duree") currentActivity.duration = Math.max(1, parseCsvInteger(field.value, 1));
          if (field.key === "groupe") currentActivity.groupMode = lookupValue(field.value, CSV_GROUP_LOOKUP, "whole");
          if (field.key === "enseignant") currentActivity.teacherPresence = lookupValue(field.value, CSV_TRAINER_LOOKUP, "present");
          if (field.key === "rythme") currentActivity.syncMode = lookupValue(field.value, CSV_SYNC_LOOKUP, "sync");
          if (field.key === "modalite") currentActivity.locationMode = lookupValue(field.value, CSV_LOCATION_LOOKUP, "onsite");
          if (field.key === "evaluation") currentActivity.evaluationMode = lookupValue(field.value, CSV_EVAL_LOOKUP, "none");
          if (field.key === "aias") currentActivity.aias = parseAiasValue(field.value);
          if (field.key === "description") {
            const descriptionLines = [field.value];
            index += 1;
            while (
              index < lines.length &&
              !/^- [^:]+:/.test(lines[index]) &&
              !/^#{2,3}\s+/.test(lines[index])
            ) {
              descriptionLines.push(lines[index]);
              index += 1;
            }
            currentActivity.description = cleanMarkdownExportValue(descriptionLines.join("\n"));
            continue;
          }
          if (["consignes", "consignes pour les eleves", "instructions", "instructions for students"].includes(field.key)) {
            const instructionLines = [field.value];
            index += 1;
            while (
              index < lines.length &&
              !/^- [^:]+:/.test(lines[index]) &&
              !/^#{2,3}\s+/.test(lines[index])
            ) {
              instructionLines.push(lines[index]);
              index += 1;
            }
            currentActivity.instructions = cleanMarkdownExportValue(instructionLines.join("\n"));
            continue;
          }
          if (field.key === "liens") currentActivity.links = parseMarkdownLinks(field.value);
          if (field.key === "competences") {
            currentActivity.tools = field.value.split(",").map((item) => item.trim()).filter(Boolean);
          }
          index += 1;
          continue;
        }
      }
    }

    index += 1;
  }

  pushCurrentSession();
  if (!imported.sessions.length) return null;
  return hydrateState(imported, null);
}

async function downloadBlob(content, type, filename) {
  const blob = new Blob([content], { type });
  if (typeof navigator !== "undefined" && typeof navigator.msSaveOrOpenBlob === "function") {
    navigator.msSaveOrOpenBlob(blob, filename);
    return;
  }

  const userAgent = typeof navigator !== "undefined" ? String(navigator.userAgent || "") : "";
  const isTouchDevice =
    typeof navigator !== "undefined" &&
    (Number(navigator.maxTouchPoints || 0) > 0 || /Android|iPhone|iPad|iPod/i.test(userAgent));
  const isSafariLike =
    /Safari/i.test(userAgent) &&
    !/Chrome|Chromium|CriOS|Edg|OPR|Firefox|FxiOS|Android/i.test(userAgent);

  if (
    isTouchDevice &&
    typeof File === "function" &&
    typeof navigator !== "undefined" &&
    typeof navigator.canShare === "function" &&
    typeof navigator.share === "function"
  ) {
    try {
      const file = new File([blob], filename, { type });
      if (navigator.canShare({ files: [file] })) {
        await navigator.share({ files: [file], title: filename });
        return;
      }
    } catch (error) {
      if (error?.name === "AbortError") return;
    }
  }

  if (isSafariLike && typeof FileReader !== "undefined") {
    const popup = window.open("", "_blank", "noopener");
    const reader = new FileReader();
    reader.onloadend = () => {
      const dataUrl = String(reader.result || "");
      if (!dataUrl) return;
      if (popup) {
        popup.location.replace(dataUrl);
      } else {
        window.location.href = dataUrl;
      }
    };
    reader.readAsDataURL(blob);
    return;
  }

  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = filename;
  a.rel = "noopener";
  a.style.display = "none";
  document.body.appendChild(a);
  a.click();
  a.remove();
  window.setTimeout(() => URL.revokeObjectURL(url), 1000);
}

function clearExportPreviewUrl() {
  if (!exportPreviewObjectUrl) return;
  URL.revokeObjectURL(exportPreviewObjectUrl);
  exportPreviewObjectUrl = "";
}

function isCopyableExportFormat(format = "json") {
  const chosen = String(format).toLowerCase();
  return chosen === "json" || chosen === "md" || chosen === "markdown" || chosen === "html";
}

function updateExportPreview(format = exportFormatSelect?.value || "json", scope = exportScope) {
  const normalizedScope = normalizeExportScope(scope);
  const { content, type } = getExportPayload(format, normalizedScope, exportSessionIds);
  const filename = getExportFilename(format, normalizedScope);
  const text = typeof content === "string" ? content : "";
  const isCopyable = isCopyableExportFormat(format);
  const exportPreviewCopy = document.getElementById("export-result-modal-copy");
  clearExportPreviewUrl();
  exportPreviewObjectUrl = URL.createObjectURL(new Blob([content], { type }));
  if (exportPreviewCopy) {
    exportPreviewCopy.textContent = isCopyable ? t("exportPreviewCopy") : t("exportDownloadOnly");
  }
  if (exportResultText) {
    exportResultText.value = isCopyable ? text : "";
  }
  if (exportPreviewDetails) {
    exportPreviewDetails.classList.toggle("hidden", !isCopyable);
  }
  if (exportResultCopyBtn) {
    exportResultCopyBtn.classList.toggle("hidden", !isCopyable);
  }
  return { content, type, filename };
}

function getFocusableElements(container) {
  return Array.from(
    container.querySelectorAll(
      "button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex='-1'])"
    )
  ).filter((el) => !el.closest(".hidden"));
}

function openModal(backdrop, firstSelector = "button, select, input, textarea") {
  previousFocusedElement = document.activeElement;
  activeModalBackdrop = backdrop;
  backdrop.classList.remove("hidden");
  backdrop.setAttribute("aria-hidden", "false");
  const firstTarget = backdrop.querySelector(firstSelector) || getFocusableElements(backdrop)[0];
  if (firstTarget) firstTarget.focus();
}

function closeModal(backdrop) {
  backdrop.classList.add("hidden");
  backdrop.setAttribute("aria-hidden", "true");
  if (activeModalBackdrop === backdrop) {
    activeModalBackdrop = null;
  }
  if (previousFocusedElement && typeof previousFocusedElement.focus === "function") {
    previousFocusedElement.focus();
  }
}

function openExportModal() {
  clearExportPreviewUrl();
  exportScope = "full";
  exportSessionIds = new Set(state.sessions.map(exportSessionKey));
  if (exportMomentsDetails) exportMomentsDetails.open = false;
  if (exportPreviewDetails) exportPreviewDetails.open = false;
  if (exportScopeFullInput) exportScopeFullInput.checked = true;
  if (exportScopeStudentsInput) exportScopeStudentsInput.checked = false;
  renderExportMoments();
  exportModalBackdrop.querySelector("#export-modal-title").textContent = t("exportTitle");
  exportFormatSelect.value = "markdown";
  if (exportFilenameInput) {
    exportFilenameInput.value = getDefaultExportName(exportFormatSelect.value, exportScope);
  }
  updateExportPreview(exportFormatSelect.value, exportScope);
  openModal(exportModalBackdrop, "#export-scope-full-input");
}

function closeExportModal() {
  clearExportPreviewUrl();
  closeModal(exportModalBackdrop);
}

function openImportPicker(format = "") {
  const normalized = String(format || "").toLowerCase();
  importFileInput.dataset.format = normalized;
  importFileInput.accept =
    normalized === "csv" ? ".csv,text/csv,text/plain"
    : normalized === "xlsx" ? ".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    : normalized === "ldj" ? ".ldj,.json,application/json,text/json,text/plain"
    : normalized === "markdown" || normalized === "md" ? ".md,.markdown,text/markdown,text/plain"
    : "";
  importFileInput.value = "";
  importFileInput.click();
}

// ── Modèles de scénarios ─────────────────────────────────────────────────────

const MODEL_CATALOG_URL = "models.php?format=json";

let modelCatalog = null;
let modelCatalogPromise = null;
let modelCatalogFailed = false;
let modelFilterQuery = "";
let modelFilterFamily = "";

function modelLabel(entry, field) {
  const suffix = currentLang() === "en" ? "En" : "Fr";
  return String(entry?.[field + suffix] ?? entry?.[field + "Fr"] ?? "");
}

function formatModelDuration(minutes) {
  const total = Math.max(0, Number(minutes) || 0);
  if (total < 60) return `${total} min`;
  const hours = Math.floor(total / 60);
  const rest = total % 60;
  return rest === 0 ? `${hours} h` : `${hours} h ${String(rest).padStart(2, "0")}`;
}

function loadModelCatalog() {
  if (modelCatalog) return Promise.resolve(modelCatalog);
  if (modelCatalogPromise) return modelCatalogPromise;

  modelCatalogPromise = fetch(MODEL_CATALOG_URL, { headers: { Accept: "application/json" } })
    .then((response) => {
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      return response.json();
    })
    .then((payload) => {
      if (!payload || !Array.isArray(payload.models)) throw new Error("Invalid catalog");
      modelCatalog = {
        families: Array.isArray(payload.families) ? payload.families : [],
        models: payload.models
      };
      modelCatalogFailed = false;
      return modelCatalog;
    })
    .catch((error) => {
      modelCatalogPromise = null;
      modelCatalogFailed = true;
      throw error;
    });

  return modelCatalogPromise;
}

function matchesModelFilter(entry) {
  if (modelFilterFamily && entry.family !== modelFilterFamily) return false;
  if (!modelFilterQuery) return true;
  const haystack = [
    modelLabel(entry, "title"),
    modelLabel(entry, "summary"),
    modelLabel(entry, "familyLabel"),
    entry.keywords || ""
  ].join(" ").toLowerCase();
  return modelFilterQuery
    .split(/\s+/)
    .filter(Boolean)
    .every((token) => haystack.includes(token));
}

function renderModelFamilyOptions() {
  if (!importModelsFamily) return;
  const previous = modelFilterFamily;
  importModelsFamily.textContent = "";

  const allOption = document.createElement("option");
  allOption.value = "";
  allOption.textContent = t("importModelsFamilyAll");
  importModelsFamily.appendChild(allOption);

  (modelCatalog?.families || []).forEach((family) => {
    const option = document.createElement("option");
    option.value = family.id;
    option.textContent = currentLang() === "en" ? family.labelEn : family.labelFr;
    importModelsFamily.appendChild(option);
  });

  importModelsFamily.value = previous;
  if (importModelsFamily.value !== previous) {
    modelFilterFamily = "";
    importModelsFamily.value = "";
  }
}

function buildModelCard(entry) {
  const card = document.createElement("button");
  card.type = "button";
  card.className = "import-model-card";
  card.dataset.modelId = entry.id;
  card.setAttribute("role", "listitem");

  const head = document.createElement("span");
  head.className = "import-model-head";
  const icon = document.createElement("i");
  icon.className = `${entry.icon || "fa-solid fa-shapes"} import-model-icon`;
  icon.setAttribute("aria-hidden", "true");
  const title = document.createElement("span");
  title.className = "import-model-title";
  title.textContent = modelLabel(entry, "title");
  head.append(icon, title);

  const chips = document.createElement("span");
  chips.className = "import-model-chips";
  [
    modelLabel(entry, "familyLabel"),
    formatModelDuration(entry.minutes),
    `${entry.momentCount} ${t("importModelsUnitMoments")}`,
    `${entry.activityCount} ${t("importModelsUnitActivities")}`
  ].forEach((label) => {
    const chip = document.createElement("span");
    chip.className = "import-model-chip";
    chip.textContent = label;
    chips.appendChild(chip);
  });

  const summary = document.createElement("span");
  summary.className = "import-model-summary";
  summary.textContent = modelLabel(entry, "summary");

  card.append(head, chips, summary);

  const types = document.createElement("span");
  types.className = "import-model-types";
  (entry.outline || []).forEach((moment) => {
    (moment.activities || []).forEach((activity) => {
      const dot = document.createElement("span");
      dot.className = `import-model-dot type-${activity.type}`;
      dot.title = currentLang() === "en" ? activity.typeLabelEn : activity.typeLabelFr;
      types.appendChild(dot);
    });
  });
  if (types.childElementCount) card.appendChild(types);

  if (Array.isArray(entry.placeholders) && entry.placeholders.length) {
    const todo = document.createElement("span");
    todo.className = "import-model-todo";
    todo.textContent = `${t("importModelsToComplete")} ${entry.placeholders.join(" · ")}`;
    card.appendChild(todo);
  }

  return card;
}

function renderModelList() {
  if (!importModelsList || !importModelsStatus) return;
  importModelsList.textContent = "";

  if (modelCatalogFailed) {
    importModelsStatus.textContent = t("importModelsError");
    importModelsStatus.classList.add("import-models-status-error");
    return;
  }
  if (!modelCatalog) {
    importModelsStatus.textContent = t("importModelsLoading");
    importModelsStatus.classList.remove("import-models-status-error");
    return;
  }

  importModelsStatus.classList.remove("import-models-status-error");
  const matches = modelCatalog.models.filter(matchesModelFilter);
  if (!matches.length) {
    importModelsStatus.textContent = t("importModelsNone");
    return;
  }
  importModelsStatus.textContent = matches.length === 1
    ? t("importModelsCountOne")
    : t("importModelsCount").replace("{count}", String(matches.length));

  matches.forEach((entry) => importModelsList.appendChild(buildModelCard(entry)));
}

async function applyModel(modelId) {
  const id = String(modelId || "");
  if (!id) return false;
  try {
    const response = await fetch(`${MODEL_CATALOG_URL}&model=${encodeURIComponent(id)}`, {
      headers: { Accept: "application/json" }
    });
    if (!response.ok) throw new Error(`HTTP ${response.status}`);
    const payload = await response.json();
    const hydrated = hydrateState(payload?.design, null);
    if (!hydrated) throw new Error("Invalid model");
    hydrated.meta.uiLanguage = preferredInterfaceLanguage(currentLang());
    delete hydrated.meta.remoteDesignId;
    delete hydrated.meta.remoteUpdatedAt;
    state = hydrated;
    saveState();
    render();
    window.learningDesignerClearRemoteDesignUrl?.();
    const name = modelLabel(payload?.model || {}, "title") || hydrated.meta.name;
    const message = t("importModelApplied").replace("{name}", name);
    showNotice(message, "success");
    announce(message);
    return true;
  } catch (_) {
    showNotice(t("importModelFailed"), "error");
    return false;
  }
}

function openImportModal() {
  modelFilterQuery = "";
  modelFilterFamily = "";
  if (importModelsSearch) importModelsSearch.value = "";
  renderModelFamilyOptions();
  renderModelList();
  openModal(importModalBackdrop, "#import-file-btn");

  if (!modelCatalog) {
    loadModelCatalog()
      .then(() => {
        renderModelFamilyOptions();
        renderModelList();
      })
      .catch(() => {
        renderModelList();
      });
  }
}

function closeImportModal() {
  closeModal(importModalBackdrop);
}

async function maybeApplyRequestedModel() {
  const params = new URLSearchParams(window.location.search);
  const requested = String(params.get("model") || "").trim();
  if (!requested) return;
  if (params.get("remote_design_id")) return;
  const applied = await applyModel(requested);
  if (applied) {
    params.delete("model");
    const query = params.toString();
    const url = `${window.location.pathname}${query ? `?${query}` : ""}${window.location.hash}`;
    window.history.replaceState({}, "", url);
  }
}

function openInfoModal() {
  openModal(infoModalBackdrop, "#info-modal-close-btn");
}

window.learningDesignerOpenInfo = openInfoModal;

function closeInfoModal() {
  closeModal(infoModalBackdrop);
}

function getStoredSelection(wrapper, textarea) {
  const fallback = textarea.value.length;
  const start = Number.parseInt(wrapper.dataset.selectionStart || "", 10);
  const end = Number.parseInt(wrapper.dataset.selectionEnd || "", 10);
  return {
    start: Number.isInteger(start) ? start : (textarea.selectionStart ?? fallback),
    end: Number.isInteger(end) ? end : (textarea.selectionEnd ?? fallback)
  };
}

function rememberSelection(textarea) {
  const selectionHost = textarea?.closest(".expandable-field") || textarea;
  if (!selectionHost) return;
  selectionHost.dataset.selectionStart = String(textarea.selectionStart ?? textarea.value.length);
  selectionHost.dataset.selectionEnd = String(textarea.selectionEnd ?? textarea.value.length);
}

function updateTextareaValue(textarea, value, selectionStart, selectionEnd = selectionStart) {
  textarea.value = value;
  textarea.focus();
  textarea.setSelectionRange(selectionStart, selectionEnd);
  rememberSelection(textarea);
  textarea.dispatchEvent(new Event("input", { bubbles: true }));
}

function replaceSelection(textarea, wrapper, replacement, selectionStart, selectionEnd) {
  const { start, end } = getStoredSelection(wrapper, textarea);
  const nextValue = `${textarea.value.slice(0, start)}${replacement}${textarea.value.slice(end)}`;
  updateTextareaValue(textarea, nextValue, selectionStart, selectionEnd);
}

function wrapSelection(textarea, wrapper, before, after, placeholder) {
  const { start, end } = getStoredSelection(wrapper, textarea);
  const selected = textarea.value.slice(start, end);
  const content = selected || placeholder;
  const replacement = `${before}${content}${after}`;
  replaceSelection(
    textarea,
    wrapper,
    replacement,
    start + before.length,
    start + before.length + content.length
  );
}

function prefixSelectionLines(textarea, wrapper, prefix, placeholder) {
  const { start, end } = getStoredSelection(wrapper, textarea);
  const selected = textarea.value.slice(start, end);
  const content = selected || placeholder;
  const replacement = String(content)
    .split("\n")
    .map((line) => `${prefix}${line}`)
    .join("\n");
  replaceSelection(textarea, wrapper, replacement, start, start + replacement.length);
}

function applyMarkdownAction(textarea, actionId) {
  const wrapper = textarea.closest(".expandable-field") || textarea;
  const placeholders = {
    bold: t("mdPlaceholderBold"),
    italic: t("mdPlaceholderItalic"),
    heading: t("mdPlaceholderHeading"),
    list: t("mdPlaceholderList"),
    orderedList: t("mdPlaceholderOrderedList"),
    quote: t("mdPlaceholderQuote"),
    linkText: t("mdPlaceholderLinkText"),
    linkUrl: t("mdPlaceholderLinkUrl")
  };
  if (actionId === "bold") {
    wrapSelection(textarea, wrapper, "**", "**", placeholders.bold);
    return;
  }
  if (actionId === "italic") {
    wrapSelection(textarea, wrapper, "*", "*", placeholders.italic);
    return;
  }
  if (actionId === "heading") {
    prefixSelectionLines(textarea, wrapper, "## ", placeholders.heading);
    return;
  }
  if (actionId === "list") {
    prefixSelectionLines(textarea, wrapper, "- ", placeholders.list);
    return;
  }
  if (actionId === "ordered-list") {
    const { start, end } = getStoredSelection(wrapper, textarea);
    const selected = textarea.value.slice(start, end);
    const content = selected || placeholders.orderedList;
    const replacement = String(content)
      .split("\n")
      .map((line, i) => `${i + 1}. ${line}`)
      .join("\n");
    replaceSelection(textarea, wrapper, replacement, start, start + replacement.length);
    return;
  }
  if (actionId === "quote") {
    prefixSelectionLines(textarea, wrapper, "> ", placeholders.quote);
    return;
  }
  if (actionId === "link") {
    const { start, end } = getStoredSelection(wrapper, textarea);
    const label = textarea.value.slice(start, end) || placeholders.linkText;
    const replacement = `[${label}](${placeholders.linkUrl})`;
    const urlStart = start + label.length + 3;
    replaceSelection(
      textarea,
      wrapper,
      replacement,
      urlStart,
      urlStart + placeholders.linkUrl.length
    );
  }
}

function setupExpandableFields() {
  ensureMarkdownToolbars();
  ensureMarkdownPreviews();
  document.addEventListener("click", (event) => {
    const btn = event.target.closest(".expand-btn");
    if (!btn) return;
    const wrapper = btn.closest(".expandable-field");
    if (!wrapper) return;
    const textarea = wrapper.querySelector("textarea");
    const isFullscreen = !wrapper.classList.contains("fullscreen");
    toggleExpandableFieldFullscreen(wrapper, isFullscreen);
    if (!isFullscreen) {
      wrapper.classList.remove("is-editing");
      refreshMarkdownPreview(wrapper);
    }
    if (textarea) autoResizeTextarea(textarea);
    btn.textContent = isFullscreen ? "✕" : "⤢";
    const label = isFullscreen ? t("closeFullscreen") : t("fullscreen");
    btn.setAttribute("aria-label", label);
    btn.setAttribute("title", label);
    localizeExpandableFieldControls(wrapper);
    announce(label);
  });

  document.addEventListener("mousedown", (event) => {
    if (event.target.closest(".markdown-tool-btn")) {
      event.preventDefault();
    }
  });

  document.addEventListener("click", (event) => {
    const button = event.target.closest(".markdown-tool-btn");
    if (!button) return;
    const wrapper = button.closest(".expandable-field");
    const textarea = wrapper?.querySelector("textarea");
    if (!textarea) return;
    applyMarkdownAction(textarea, button.dataset.mdAction || "");
  });

  document.addEventListener("keydown", (event) => {
    const textarea = event.target.closest(".expandable-field textarea, .grid-desc-input");
    if (!textarea) return;
    if (handleMarkdownListEnter(textarea, event)) return;
    const action = markdownActionForKeyboardEvent(event);
    if (!action) return;
    event.preventDefault();
    rememberSelection(textarea);
    applyMarkdownAction(textarea, action.id);
  });

  ["focusin", "input", "keyup", "mouseup"].forEach((eventName) => {
    document.addEventListener(eventName, (event) => {
      const textarea = event.target.closest(".expandable-field textarea");
      if (!textarea) return;
      rememberSelection(textarea);
      if (eventName === "focusin") {
        textarea.closest(".expandable-field")?.classList.add("is-editing");
      }
      if (eventName === "input") {
        refreshMarkdownPreview(textarea.closest(".expandable-field"));
      }
    });
  });

  document.addEventListener("focusout", (event) => {
    const textarea = event.target.closest(".expandable-field textarea");
    if (!textarea) return;
    const wrapper = textarea.closest(".expandable-field");
    window.setTimeout(() => {
      if (wrapper?.querySelector("textarea") !== document.activeElement) {
        wrapper?.classList.remove("is-editing");
        refreshMarkdownPreview(wrapper);
      }
    }, 0);
  });

  document.addEventListener("click", (event) => {
    const preview = event.target.closest(".markdown-preview");
    if (!preview) return;
    const textarea = preview.closest(".expandable-field")?.querySelector("textarea");
    if (textarea) textarea.focus();
  });
}

function toggleExpandableFieldFullscreen(wrapper, shouldOpen) {
  if (!wrapper) return;
  if (shouldOpen) {
    if (!wrapper.dataset.fullscreenPlaceholderId) {
      const placeholder = wrapper.cloneNode(true);
      placeholder.classList.add("expandable-field-placeholder");
      placeholder.setAttribute("aria-hidden", "true");
      placeholder.querySelectorAll("textarea").forEach((textarea, index) => {
        const sourceTextarea = wrapper.querySelectorAll("textarea")[index];
        textarea.value = sourceTextarea?.value || "";
        textarea.readOnly = true;
        textarea.tabIndex = -1;
      });
      placeholder.querySelectorAll("button").forEach((button) => {
        button.tabIndex = -1;
        button.disabled = true;
      });
      const placeholderId = `expandable-placeholder-${Date.now()}-${Math.random().toString(36).slice(2, 8)}`;
      placeholder.id = placeholderId;
      wrapper.dataset.fullscreenPlaceholderId = placeholderId;
      wrapper.parentNode?.insertBefore(placeholder, wrapper.nextSibling);
    }
    document.body.appendChild(wrapper);
    wrapper.classList.add("fullscreen");
    document.body.classList.add("fullscreen-editor-open");
    return;
  }

  const placeholder = document.getElementById(wrapper.dataset.fullscreenPlaceholderId || "");
  if (placeholder?.parentNode) {
    placeholder.parentNode.insertBefore(wrapper, placeholder);
    placeholder.remove();
  }
  delete wrapper.dataset.fullscreenPlaceholderId;
  wrapper.classList.remove("fullscreen");
  if (!document.querySelector(".expandable-field.fullscreen")) {
    document.body.classList.remove("fullscreen-editor-open");
  }
}

function restoreAllFullscreenExpandableFields() {
  document.querySelectorAll(".expandable-field.fullscreen").forEach((wrapper) => {
    toggleExpandableFieldFullscreen(wrapper, false);
    const btn = wrapper.querySelector(".expand-btn");
    const textarea = wrapper.querySelector("textarea");
    if (btn) {
      btn.textContent = "⤢";
      btn.setAttribute("aria-label", t("fullscreen"));
      btn.setAttribute("title", t("fullscreen"));
    }
    if (textarea) autoResizeTextarea(textarea);
    localizeExpandableFieldControls(wrapper);
  });
}

document.addEventListener("keydown", (event) => {
  const activeFullscreenField = document.querySelector(".expandable-field.fullscreen");
  if (activeFullscreenField && event.key === "Escape" && !activeModalBackdrop && !activeToolPicker && !activeChoiceMenu) {
    event.preventDefault();
    activeFullscreenField.querySelector(".expand-btn")?.click();
    return;
  }
  if (activeChoiceMenu && event.key === "Escape") {
    event.preventDefault();
    closeChoiceMenu(true);
    return;
  }
  if (activeToolPicker && event.key === "Escape") {
    event.preventDefault();
    closeToolPicker(true);
    return;
  }
  if (!activeModalBackdrop) return;
  if (event.key === "Escape") {
    event.preventDefault();
    if (activeModalBackdrop === exportModalBackdrop) closeExportModal();
    if (activeModalBackdrop === importModalBackdrop) closeImportModal();
    if (activeModalBackdrop === infoModalBackdrop) closeInfoModal();
    if (activeModalBackdrop === aiasModalBackdrop) closeAiasModal();
    return;
  }
  if (event.key !== "Tab") return;
  const focusables = getFocusableElements(activeModalBackdrop);
  if (!focusables.length) return;
  const first = focusables[0];
  const last = focusables[focusables.length - 1];
  if (event.shiftKey && document.activeElement === first) {
    event.preventDefault();
    last.focus();
  } else if (!event.shiftKey && document.activeElement === last) {
    event.preventDefault();
    first.focus();
  }
});

document.addEventListener("click", (event) => {
  if (activeToolPicker) {
    if (!activeToolPicker.contains(event.target) && !event.target.closest(".select-tools-btn")) {
      closeToolPicker();
    }
  }
  if (!activeChoiceMenu) return;
  if (activeChoiceMenu.contains(event.target)) return;
  if (event.target.closest(".choice-btn")) return;
  closeChoiceMenu();
});

const debouncedResizeLayoutRefresh = debounce(() => {
  updateResponsiveButtonLabels();
  renderTopPanel();
}, 120);

let topPanelRenderFrame = 0;
let partitionRenderFrame = 0;

function scheduleTopPanelRender() {
  if (topPanelRenderFrame) return;
  topPanelRenderFrame = window.requestAnimationFrame(() => {
    topPanelRenderFrame = 0;
    renderTopPanel();
  });
}

function schedulePartitionRender() {
  if (partitionRenderFrame) return;
  partitionRenderFrame = window.requestAnimationFrame(() => {
    partitionRenderFrame = 0;
    renderPartitionView();
  });
}

window.addEventListener("resize", closeChoiceMenu, { passive: true });
window.addEventListener("resize", debouncedResizeLayoutRefresh, { passive: true });
window.addEventListener("scroll", closeChoiceMenu, { capture: true, passive: true });

function stripGradientForSession(session) {
  if (!session.activities.length) return "linear-gradient(90deg, #cccccc, #bbbbbb)";
  const parts = [];
  const total = session.activities.length;
  for (let i = 0; i < total; i += 1) {
    const start = Math.round((i / total) * 100);
    const end = Math.round(((i + 1) / total) * 100);
    parts.push(`${colorForType(session.activities[i].type)} ${start}% ${end}%`);
  }
  return `linear-gradient(90deg, ${parts.join(", ")})`;
}

function isInteractiveTarget(target) {
  return Boolean(target.closest("textarea, input, select, button, option"));
}

function clearSessionDropIndicators() {
  board
    .querySelectorAll(".session-card.drop-before, .session-card.drop-after")
    .forEach((el) => el.classList.remove("drop-before", "drop-after"));
  delete board.dataset.dropSessionId;
  delete board.dataset.dropPosition;
}

function clearActivityDropIndicators() {
  board
    .querySelectorAll(".activity-card.drop-before, .activity-card.drop-after")
    .forEach((el) => el.classList.remove("drop-before", "drop-after"));
  board.querySelectorAll(".activities.drop-append").forEach((el) => el.classList.remove("drop-append"));
}

function clearDragIndicators() {
  clearSessionDropIndicators();
  clearActivityDropIndicators();
}

function moveSession(sourceId, targetId, position) {
  if (sourceId === targetId) return;
  const sourceIndex = state.sessions.findIndex((session) => session.id === sourceId);
  if (sourceIndex < 0) return;
  const [movingSession] = state.sessions.splice(sourceIndex, 1);
  if (!targetId) {
    state.sessions.push(movingSession);
    return;
  }
  const targetIndex = state.sessions.findIndex((session) => session.id === targetId);
  if (targetIndex < 0) {
    state.sessions.push(movingSession);
    return;
  }
  const insertIndex = position === "before" ? targetIndex : targetIndex + 1;
  state.sessions.splice(insertIndex, 0, movingSession);
}

function moveActivity(sourceSessionId, activityId, targetSessionId, targetActivityId, position) {
  const sourceSession = state.sessions.find((session) => session.id === sourceSessionId);
  const targetSession = state.sessions.find((session) => session.id === targetSessionId);
  if (!sourceSession || !targetSession) return;
  if (sourceSessionId === targetSessionId && targetActivityId === activityId) return;

  const sourceIndex = sourceSession.activities.findIndex((activity) => activity.id === activityId);
  if (sourceIndex < 0) return;

  const [movingActivity] = sourceSession.activities.splice(sourceIndex, 1);
  if (!targetActivityId || position === "append") {
    targetSession.activities.push(movingActivity);
    return;
  }

  const targetIndex = targetSession.activities.findIndex((activity) => activity.id === targetActivityId);
  if (targetIndex < 0) {
    targetSession.activities.push(movingActivity);
    return;
  }

  const insertIndex = position === "before" ? targetIndex : targetIndex + 1;
  targetSession.activities.splice(insertIndex, 0, movingActivity);
}

function moveSessionByOffset(sessionId, offset) {
  const index = state.sessions.findIndex((session) => session.id === sessionId);
  if (index < 0) return false;
  const targetIndex = index + offset;
  if (targetIndex < 0 || targetIndex >= state.sessions.length) return false;
  const [session] = state.sessions.splice(index, 1);
  state.sessions.splice(targetIndex, 0, session);
  return true;
}

function moveActivityByOffset(sessionId, activityId, offset) {
  const session = state.sessions.find((item) => item.id === sessionId);
  if (!session) return false;
  const index = session.activities.findIndex((activity) => activity.id === activityId);
  if (index < 0) return false;
  const targetIndex = index + offset;
  if (targetIndex < 0 || targetIndex >= session.activities.length) return false;
  const [activity] = session.activities.splice(index, 1);
  session.activities.splice(targetIndex, 0, activity);
  return true;
}

board.addEventListener("dragover", (event) => {
  if (getBoardLayout() === "grid") return;
  if (!dragState || dragState.type !== "session") return;
  event.preventDefault();
  clearSessionDropIndicators();
  const targetCard = event.target.closest(".session-card");
  if (!targetCard) return;
  const rect = targetCard.getBoundingClientRect();
  const isListLayout = getBoardLayout() === "list";
  const position = isListLayout
    ? event.clientY < rect.top + rect.height / 2 ? "before" : "after"
    : event.clientX < rect.left + rect.width / 2 ? "before" : "after";
  targetCard.classList.add(position === "before" ? "drop-before" : "drop-after");
  board.dataset.dropSessionId = targetCard.dataset.sessionId;
  board.dataset.dropPosition = position;
});

board.addEventListener("drop", (event) => {
  if (getBoardLayout() === "grid") return;
  if (!dragState || dragState.type !== "session") return;
  event.preventDefault();
  const targetId = board.dataset.dropSessionId || null;
  const position = board.dataset.dropPosition || "after";
  moveSession(dragState.sessionId, targetId, position);
  saveState();
  render();
});

// ─── Grid (tableur) view ────────────────────────────────────────────────────

function buildGridSelect(options, currentValue, className) {
  const sel = document.createElement("select");
  sel.className = className;
  options.forEach(({ value, label }) => {
    const opt = document.createElement("option");
    opt.value = value;
    opt.textContent = label;
    if (value === currentValue) opt.selected = true;
    sel.appendChild(opt);
  });
  return sel;
}

function toPlainTextareaValue(value) {
  if (typeof value === "string") return value;
  if (value == null) return "";
  if (Array.isArray(value)) {
    return value.map((item) => toPlainTextareaValue(item).trim()).filter(Boolean).join("\n");
  }
  if (typeof value === "object") {
    if (typeof value.text === "string") return value.text;
    const commonTextKeys = ["details", "description", "content", "notes", "label", "title", "value", "name"];
    for (const key of commonTextKeys) {
      if (typeof value[key] === "string" && value[key].trim()) return value[key];
    }
    try {
      return JSON.stringify(value);
    } catch {
      return "";
    }
  }
  return String(value);
}

function buildGridSessionRow(session, sIdx) {
  const tr = document.createElement("tr");
  tr.className = "grid-session-row";
  tr.dataset.sessionId = session.id;

  const td = document.createElement("td");
  td.setAttribute("colspan", "12");

  const totalDur = session.activities.reduce((s, a) => s + (Number(a.duration) || 0), 0);

  const lbl = document.createElement("span");
  lbl.className = "grid-session-label";
  lbl.textContent = `${t("gridSessionPrefix")} ${sIdx + 1}`;

  const titleInput = document.createElement("input");
  titleInput.type = "text";
  titleInput.className = "grid-session-title-input";
  titleInput.value = session.title;
  titleInput.placeholder = t("sessionTitlePlaceholder");
  titleInput.addEventListener("input", (e) => {
    session.title = e.target.value;
    saveState();
    schedulePartitionRender();
  });

  const totalSpan = document.createElement("span");
  totalSpan.className = "grid-session-total";
  totalSpan.textContent = `— ${totalDur} min`;

  td.appendChild(lbl);
  td.appendChild(titleInput);
  td.appendChild(totalSpan);
  tr.appendChild(td);
  return tr;
}

function updateGridSessionTotal(session) {
  const row = Array.from(board.querySelectorAll(".grid-session-row"))
    .find((candidate) => candidate.dataset.sessionId === session.id);
  const total = row?.querySelector(".grid-session-total");
  if (total) total.textContent = `— ${totalSessionMinutes(session)} min`;
}

function buildGridActivityRow(session, act, aIdx) {
  normalizeActivity(act);
  const tr = document.createElement("tr");
  tr.className = "grid-activity-row";
  tr.dataset.actId = act.id;

  const mkTd = () => document.createElement("td");

  // Col 1 — #
  const numTd = mkTd();
  numTd.textContent = String(aIdx + 1);
  numTd.style.borderLeftColor = colorForType(act.type);
  tr.appendChild(numTd);

  // Col 2 — Type
  const typeTd = mkTd();
  const typeCell = document.createElement("div");
  typeCell.className = "grid-type-cell";
  const dot = document.createElement("span");
  dot.className = "grid-type-dot";
  dot.style.background = colorForType(act.type);
  const typeSel = buildGridSelect(
    LEARNING_TYPES.map(lt => ({ value: lt.id, label: lt.label })),
    act.type, "grid-type-select"
  );
  typeSel.addEventListener("change", (e) => {
    act.type = e.target.value;
    dot.style.background = colorForType(act.type);
    numTd.style.borderLeftColor = colorForType(act.type);
    saveState();
    renderTopPanel();
    renderPartitionView();
  });
  typeCell.appendChild(dot);
  typeCell.appendChild(typeSel);
  typeTd.appendChild(typeCell);
  tr.appendChild(typeTd);

  // Col 3 — Duration
  const durTd = mkTd();
  const durWrap = document.createElement("div");
  durWrap.className = "grid-dur-wrap";
  const durInput = document.createElement("input");
  durInput.type = "number";
  durInput.className = "grid-dur-input";
  durInput.min = "1";
  durInput.value = String(act.duration);
  durInput.addEventListener("input", (e) => {
    act.duration = Math.max(1, Number(e.target.value) || 1);
    saveState();
    updateGridSessionTotal(session);
    scheduleTopPanelRender();
    schedulePartitionRender();
  });
  const durUnit = document.createElement("span");
  durUnit.className = "grid-dur-unit";
  durUnit.textContent = "min";
  durWrap.appendChild(durInput);
  durWrap.appendChild(durUnit);
  durTd.appendChild(durWrap);
  tr.appendChild(durTd);

  // Col 4–8 — Select fields
  const selectCols = [
    { opts: LOCATION_OPTIONS,  val: act.locationMode,    key: "locationMode" },
    { opts: GROUP_MODE_OPTIONS, val: act.groupMode,       key: "groupMode" },
    { opts: SYNC_OPTIONS,       val: act.syncMode,        key: "syncMode" },
    { opts: TRAINER_OPTIONS,    val: act.teacherPresence, key: "teacherPresence" },
    { opts: EVAL_OPTIONS,       val: act.evaluationMode,  key: "evaluationMode" },
  ];
  selectCols.forEach(({ opts, val, key }) => {
    const sTd = mkTd();
    const sel = buildGridSelect(
      opts.map(o => ({ value: o.value, label: o.label })),
      val, "grid-select"
    );
    sel.addEventListener("change", (e) => {
      act[key] = e.target.value;
      saveState();
      renderPartitionView();
    });
    sTd.appendChild(sel);
    tr.appendChild(sTd);
  });

  // Col 9 — AIAS
  const aiasTd = mkTd();
  const aiasOptions = [
    { value: "undecided", label: t("aiasUndecided") },
    { value: "not_applicable", label: t("aiasNotApplicable") },
    ...AIAS_LEVELS.map((definition) => ({
      value: `level_${definition.level}`,
      label: `AIAS ${definition.level} · ${t(definition.labelKey)}`
    }))
  ];
  const aiasValue = act.aias.status === "specified"
    ? `level_${act.aias.level}`
    : act.aias.status;
  const aiasSelect = buildGridSelect(aiasOptions, aiasValue, "grid-select grid-aias-select");
  applyAiasLevelClass(aiasSelect, act.aias);
  aiasSelect.addEventListener("change", (event) => {
    const selected = event.target.value;
    const levelMatch = selected.match(/^level_([1-5])$/);
    act.aias = levelMatch
      ? { version: AIAS_VERSION, status: "specified", level: Number(levelMatch[1]) }
      : { version: AIAS_VERSION, status: selected, level: null };
    applyAiasLevelClass(aiasSelect, act.aias);
    saveState();
  });
  aiasTd.appendChild(aiasSelect);
  tr.appendChild(aiasTd);

  // Col 10 — Description
  const descTd = mkTd();
  const descInput = document.createElement("textarea");
  descInput.className = "grid-desc-input";
  descInput.rows = 1;
  descInput.value = toPlainTextareaValue(act.description);
  descInput.placeholder = t("activityDescriptionPlaceholder") || "—";
  descInput.addEventListener("input", (e) => {
    act.description = e.target.value;
    saveState();
  });
  descTd.appendChild(descInput);
  tr.appendChild(descTd);

  // Col 11 — Instructions
  const instructionsTd = mkTd();
  const instructionsInput = document.createElement("textarea");
  instructionsInput.className = "grid-desc-input";
  instructionsInput.rows = 1;
  instructionsInput.value = toPlainTextareaValue(act.instructions);
  instructionsInput.placeholder = t("activityInstructionsPlaceholder") || "—";
  instructionsInput.addEventListener("input", (event) => {
    act.instructions = event.target.value;
    saveState();
  });
  instructionsTd.appendChild(instructionsInput);
  tr.appendChild(instructionsTd);

  // Col 12 — Actions ↑ ↓ ✕
  const actTd = mkTd();
  const btns = document.createElement("div");
  btns.className = "grid-action-btns";

  const mkBtn = (label, title, handler, extraClass) => {
    const b = document.createElement("button");
    b.type = "button";
    b.className = "grid-action-btn" + (extraClass ? " " + extraClass : "");
    b.textContent = label;
    b.title = title;
    b.addEventListener("click", handler);
    return b;
  };

  btns.appendChild(mkBtn("↑", t("partitionMoveUp"), () => {
    if (aIdx === 0) return;
    [session.activities[aIdx - 1], session.activities[aIdx]] =
      [session.activities[aIdx], session.activities[aIdx - 1]];
    saveState(); renderGridView(); renderTopPanel(); renderPartitionView();
  }));
  btns.appendChild(mkBtn("↓", t("partitionMoveDown"), () => {
    if (aIdx >= session.activities.length - 1) return;
    [session.activities[aIdx], session.activities[aIdx + 1]] =
      [session.activities[aIdx + 1], session.activities[aIdx]];
    saveState(); renderGridView(); renderTopPanel(); renderPartitionView();
  }));
  btns.appendChild(mkBtn("✕", t("deleteActivity") || "Supprimer", () => {
    session.activities.splice(aIdx, 1);
    saveState(); renderGridView(); renderTopPanel(); renderPartitionView();
  }, "del"));

  actTd.appendChild(btns);
  tr.appendChild(actTd);
  return tr;
}

function renderGridView() {
  board.innerHTML = "";

  const wrapper = document.createElement("div");
  wrapper.className = "grid-view-wrapper";

  const table = document.createElement("table");
  table.className = "grid-table";

  // Sticky header
  const thead = document.createElement("thead");
  const hRow = document.createElement("tr");
  [
    { cls: "grid-col-num",     label: "#" },
    { cls: "grid-col-type",    label: t("gridColType") },
    { cls: "grid-col-dur",     label: t("gridColDuration") },
    { cls: "grid-col-loc",     label: t("gridColLocation") },
    { cls: "grid-col-group",   label: t("gridColGroup") },
    { cls: "grid-col-sync",    label: t("gridColSync") },
    { cls: "grid-col-teacher", label: t("gridColTeacher") },
    { cls: "grid-col-eval",    label: t("gridColEval") },
    { cls: "grid-col-aias",    label: t("gridColAias") },
    { cls: "grid-col-desc",    label: t("gridColDesc") },
    { cls: "grid-col-instructions", label: t("gridColInstructions") },
    { cls: "grid-col-actions", label: "" },
  ].forEach(({ cls, label }) => {
    const th = document.createElement("th");
    th.className = cls;
    th.textContent = label;
    hRow.appendChild(th);
  });
  thead.appendChild(hRow);
  table.appendChild(thead);

  const tbody = document.createElement("tbody");

  state.sessions.forEach((session, sIdx) => {
    tbody.appendChild(buildGridSessionRow(session, sIdx));
    session.activities.forEach((act, aIdx) => {
      tbody.appendChild(buildGridActivityRow(session, act, aIdx));
    });

    // Add-activity row
    const addActRow = document.createElement("tr");
    addActRow.className = "grid-add-activity-row";
    const addActTd = document.createElement("td");
    addActTd.setAttribute("colspan", "12");
    const addActBtn = document.createElement("button");
    addActBtn.className = "grid-add-activity-btn";
    addActBtn.type = "button";
    addActBtn.textContent = t("gridAddActivity");
    addActBtn.addEventListener("click", () => {
      session.activities.push({
        id: nextId(), type: "undefined", duration: 10,
        groupMode: "whole", teacherPresence: "present",
        syncMode: "sync", locationMode: "onsite",
        evaluationMode: "none", aias: defaultAiasState(),
        description: "", instructions: "", notes: "", tools: [], links: []
      });
      saveState(); renderGridView(); renderTopPanel(); renderPartitionView();
    });
    addActTd.appendChild(addActBtn);
    addActRow.appendChild(addActTd);
    tbody.appendChild(addActRow);
  });

  // Add-session row
  const addSessRow = document.createElement("tr");
  addSessRow.className = "grid-add-session-row";
  const addSessTd = document.createElement("td");
  addSessTd.setAttribute("colspan", "12");
  const addSessBtn = document.createElement("button");
  addSessBtn.className = "grid-add-session-btn";
  addSessBtn.type = "button";
  addSessBtn.textContent = t("gridAddSession");
  addSessBtn.addEventListener("click", () => {
    state.sessions.push({
      id: nextId(), title: "", objectives: "", intentions: "", notes: "",
      notesExpanded: false, activities: []
    });
    saveState(); renderGridView(); renderTopPanel(); renderPartitionView();
  });
  addSessTd.appendChild(addSessBtn);
  addSessRow.appendChild(addSessTd);
  tbody.appendChild(addSessRow);

  table.appendChild(tbody);
  wrapper.appendChild(table);
  board.appendChild(wrapper);
}

// ─── End grid view ──────────────────────────────────────────────────────────

function render() {
  restoreAllFullscreenExpandableFields();
  closeChoiceMenu();
  closeToolPicker();
  if (activeActivityLinkActivity || !activityLinkModalBackdrop.classList.contains("hidden")) {
    closeActivityLinkModal();
  }
  if (activeAiasActivity || !aiasModalBackdrop.classList.contains("hidden")) {
    closeAiasModal();
  }
  applyLocalizedUI();
  renderTopPanel();
  renderPartitionView();
  const boardLayout = getBoardLayout();
  board.classList.toggle("layout-list",    boardLayout === "list");
  board.classList.toggle("layout-columns", boardLayout === "columns");
  board.classList.toggle("layout-grid",    boardLayout === "grid");
  board.classList.toggle("intentions-collapsed", Boolean(state.intentionsCollapsed));
  const toggleIntentionsBtn = document.getElementById("toggle-intentions-btn");
  if (toggleIntentionsBtn) {
    const intentionsVisible = !state.intentionsCollapsed;
    setButtonLabel(
      toggleIntentionsBtn,
      intentionsVisible ? "fa-solid fa-eye" : "fa-solid fa-eye-slash",
      intentionsVisible ? t("hideIntentions") : t("showIntentions")
    );
    const intentionsLabel = intentionsVisible ? t("hideIntentions") : t("showIntentions");
    toggleIntentionsBtn.setAttribute("aria-label", intentionsLabel);
    toggleIntentionsBtn.setAttribute("title", intentionsLabel);
  }

  if (boardLayout === "grid") {
    renderGridView();
    return;
  }

  const isListLayout = boardLayout === "list";
  const sessionMoveHint = isListLayout ? t("sessionMoveHintList") : t("sessionMoveHintColumns");
  board.innerHTML = "";
  state.sessions.forEach((session, sessionIndex) => {
    const frag = sessionTpl.content.cloneNode(true);
    const card = frag.querySelector(".session-card");
    const strip = frag.querySelector(".session-strip");
    const title = frag.querySelector(".session-title");
    const objectives = frag.querySelector(".session-objectives");
    const intentions = frag.querySelector(".session-intentions");
    const activitiesWrap = frag.querySelector(".activities");
    const totalDuration = frag.querySelector(".total-duration");
    const sessionNotes = frag.querySelector(".session-notes");
    const sessionNotesInput = frag.querySelector(".session-notes-input");
    const deleteSessionBtn = frag.querySelector(".delete-session-btn");

    card.dataset.sessionId = session.id;
    card.draggable = true;
    card.tabIndex = 0;
    card.setAttribute("role", "group");
    card.setAttribute(
      "aria-label",
      `${sessionIndex + 1}. ${session.title || defaultSessionTitle(sessionIndex + 1)}. ${sessionMoveHint}`
    );
    strip.style.background = stripGradientForSession(session);
    title.value = session.title;
    title.placeholder = t("sessionTitlePlaceholder");
    title.setAttribute("aria-label", `${t("sessionTitleLabel")} ${sessionIndex + 1}`);
    title.addEventListener("input", (e) => {
      session.title = e.target.value;
      saveState();
      schedulePartitionRender();
    });
    objectives.value = session.objectives || "";
    objectives.setAttribute("aria-label", `${t("sessionObjectivesLabel")} ${sessionIndex + 1}`);
    objectives.placeholder = t("sessionObjectivesPlaceholder");
    objectives.addEventListener("input", (e) => {
      session.objectives = e.target.value;
      saveState();
    });
    intentions.value = session.intentions || "";
    intentions.setAttribute("aria-label", `${t("sessionIntentionsLabel")} ${sessionIndex + 1}`);
    intentions.placeholder = t("sessionIntentionsPlaceholder");
    intentions.addEventListener("input", (e) => {
      session.intentions = e.target.value;
      saveState();
    });
    deleteSessionBtn.title = t("deleteSession");
    deleteSessionBtn.setAttribute("aria-label", deleteSessionBtn.title);
    card.addEventListener("dragstart", (event) => {
      if (isInteractiveTarget(event.target)) {
        event.preventDefault();
        return;
      }
      dragState = { type: "session", sessionId: session.id };
      card.classList.add("dragging");
      event.dataTransfer.effectAllowed = "move";
      event.dataTransfer.setData("text/plain", session.id);
    });
    card.addEventListener("dragend", () => {
      card.classList.remove("dragging");
      dragState = null;
      clearDragIndicators();
    });
    card.addEventListener("keydown", (event) => {
      if (
        isInteractiveTarget(event.target) ||
        !event.altKey ||
        event.shiftKey ||
        event.metaKey ||
        event.ctrlKey
      ) return;
      const wantsVerticalMove = isListLayout && (event.key === "ArrowUp" || event.key === "ArrowDown");
      const wantsHorizontalMove = !isListLayout && (event.key === "ArrowLeft" || event.key === "ArrowRight");
      if (wantsVerticalMove || wantsHorizontalMove) {
        event.preventDefault();
        const moveDelta = event.key === "ArrowLeft" || event.key === "ArrowUp" ? -1 : 1;
        const moved = moveSessionByOffset(session.id, moveDelta);
        if (moved) {
          saveState();
          render();
          announce(t("moved"));
        }
      }
    });

    totalDuration.textContent = String(totalSessionMinutes(session));
    activitiesWrap.dataset.sessionId = session.id;
    activitiesWrap.setAttribute("role", "group");
    activitiesWrap.setAttribute("aria-label", `${t("sessionActivitiesLabel")} ${sessionIndex + 1}`);
    activitiesWrap.addEventListener("dragover", (event) => {
      if (!dragState || dragState.type !== "activity") return;
      event.preventDefault();
      event.stopPropagation();
      clearActivityDropIndicators();

      const targetCard = event.target.closest(".activity-card");
      if (targetCard && targetCard.closest(".activities") === activitiesWrap) {
        const rect = targetCard.getBoundingClientRect();
        const position = event.clientY < rect.top + rect.height / 2 ? "before" : "after";
        targetCard.classList.add(position === "before" ? "drop-before" : "drop-after");
        activitiesWrap.dataset.dropActivityId = targetCard.dataset.activityId;
        activitiesWrap.dataset.dropPosition = position;
        return;
      }

      activitiesWrap.classList.add("drop-append");
      activitiesWrap.dataset.dropActivityId = "";
      activitiesWrap.dataset.dropPosition = "append";
    });
    activitiesWrap.addEventListener("drop", (event) => {
      if (!dragState || dragState.type !== "activity") return;
      event.preventDefault();
      event.stopPropagation();
      const targetSessionId = session.id;
      const targetActivityId = activitiesWrap.dataset.dropActivityId || null;
      const position = activitiesWrap.dataset.dropPosition || "append";
      moveActivity(
        dragState.sessionId,
        dragState.activityId,
        targetSessionId,
        targetActivityId,
        position
      );
      saveState();
      render();
    });

    session.activities.forEach((activity, activityIndex) => {
      normalizeActivity(activity);
      const activityFrag = activityTpl.content.cloneNode(true);
      const activityCard = activityFrag.querySelector(".activity-card");
      const typeBtn = activityFrag.querySelector(".activity-type-btn");
      const durationInput = activityFrag.querySelector(".activity-duration");
      const groupModeBtn = activityFrag.querySelector(".activity-group-mode-btn");
      const trainerModeBtn = activityFrag.querySelector(".activity-trainer-mode-btn");
      const syncModeBtn = activityFrag.querySelector(".activity-sync-mode-btn");
      const locationModeBtn = activityFrag.querySelector(".activity-location-mode-btn");
      const evaluationModeBtn = activityFrag.querySelector(".activity-evaluation-mode-btn");
      const activityAiasBtn = activityFrag.querySelector(".activity-aias-btn");
      const activityLinksBtn = activityFrag.querySelector(".activity-links-btn");
      const typeLabel = activityFrag.querySelector(".activity-type-label");
      const durationLabel = activityFrag.querySelector(".activity-duration-label");
      const groupLabel = activityFrag.querySelector(".activity-group-label");
      const trainerLabel = activityFrag.querySelector(".activity-trainer-label");
      const syncLabel = activityFrag.querySelector(".activity-sync-label");
      const locationLabel = activityFrag.querySelector(".activity-location-label");
      const evaluationLabel = activityFrag.querySelector(".activity-evaluation-label");
      const description = activityFrag.querySelector(".activity-description");
      const instructions = activityFrag.querySelector(".activity-instructions");
      const descriptionLabel = activityFrag.querySelector(".activity-description-label");
      const instructionsLabel = activityFrag.querySelector(".activity-instructions-label");
      const deleteActivityBtn = activityFrag.querySelector(".delete-activity-btn");
      const selectToolsBtn = activityFrag.querySelector(".select-tools-btn");

      activityCard.style.borderLeftColor = colorForType(activity.type);
      activityCard.style.setProperty('--card-type-color', colorForType(activity.type));
      activityCard.dataset.activityId = activity.id;
      activityCard.dataset.sessionId = session.id;
      activityCard.draggable = true;
      activityCard.tabIndex = 0;
      activityCard.setAttribute("role", "group");
      activityCard.setAttribute("aria-label", `${t("activityLabel")} ${activityIndex + 1}. ${t("activityMoveHint")}`);
      typeBtn.dataset.groupTitle = t("groupTitleType");
      groupModeBtn.dataset.groupTitle = t("groupTitleGroup");
      trainerModeBtn.dataset.groupTitle = t("groupTitleTrainer");
      syncModeBtn.dataset.groupTitle = t("groupTitlePacing");
      locationModeBtn.dataset.groupTitle = t("groupTitleMode");
      evaluationModeBtn.dataset.groupTitle = t("groupTitleEvaluation");
      setChoiceButton(typeBtn, ACTIVITY_TYPE_OPTIONS, activity.type);
      setChoiceButton(groupModeBtn, GROUP_MODE_OPTIONS, activity.groupMode);
      setChoiceButton(trainerModeBtn, TRAINER_OPTIONS, activity.teacherPresence);
      setChoiceButton(syncModeBtn, SYNC_OPTIONS, activity.syncMode);
      setChoiceButton(locationModeBtn, LOCATION_OPTIONS, activity.locationMode);
      setChoiceButton(evaluationModeBtn, EVAL_OPTIONS, activity.evaluationMode);
      updateAiasTrigger(activityAiasBtn, activity);
      if (typeLabel) typeLabel.textContent = t("groupTitleType");
      if (durationLabel) durationLabel.textContent = currentLang() === "en" ? "Duration" : "Durée";
      if (groupLabel) groupLabel.textContent = t("groupTitleGroup");
      if (trainerLabel) trainerLabel.textContent = t("groupTitleTrainer");
      if (syncLabel) syncLabel.textContent = t("groupTitlePacing");
      if (locationLabel) locationLabel.textContent = t("groupTitleMode");
      if (evaluationLabel) evaluationLabel.textContent = t("groupTitleEvaluation");
      durationInput.value = activity.duration;
      durationInput.setAttribute("inputmode", "numeric");
      durationInput.setAttribute("aria-label", `${t("activityDurationLabel")} ${activityIndex + 1}`);
      description.value = activity.description;
      description.placeholder = t("activityDescriptionPlaceholder");
      description.setAttribute("aria-label", `${t("activityDescriptionLabel")} ${activityIndex + 1}`);
      instructions.value = activity.instructions;
      instructions.placeholder = t("activityInstructionsPlaceholder");
      instructions.setAttribute("aria-label", `${t("activityInstructionsLabel")} ${activityIndex + 1}`);
      if (descriptionLabel) descriptionLabel.textContent = t("activityDescriptionLabel");
      if (instructionsLabel) instructionsLabel.textContent = t("activityInstructionsLabel");
      deleteActivityBtn.title = t("deleteActivity");
      deleteActivityBtn.setAttribute("aria-label", deleteActivityBtn.title);
      activityLinksBtn.title = t("manageLinks");
      activityLinksBtn.setAttribute("aria-haspopup", "dialog");
      activityLinksBtn.setAttribute("aria-expanded", "false");
      activityAiasBtn.addEventListener("click", () => openAiasModal(activityAiasBtn, activity));
      updateActivityToolsDisplay(selectToolsBtn, activity);
      updateActivityLinksDisplay(activityLinksBtn, activity);
      activityCard.addEventListener("dragstart", (event) => {
        if (isInteractiveTarget(event.target)) {
          event.preventDefault();
          return;
        }
        event.stopPropagation();
        dragState = { type: "activity", sessionId: session.id, activityId: activity.id };
        activityCard.classList.add("dragging");
        event.dataTransfer.effectAllowed = "move";
        event.dataTransfer.setData("text/plain", activity.id);
      });
      activityCard.addEventListener("dragend", (event) => {
        event.stopPropagation();
        activityCard.classList.remove("dragging");
        dragState = null;
        clearDragIndicators();
      });
      activityCard.addEventListener("keydown", (event) => {
        if (
          isInteractiveTarget(event.target) ||
          !event.altKey ||
          event.shiftKey ||
          event.metaKey ||
          event.ctrlKey
        ) return;
        if (event.key === "ArrowUp" || event.key === "ArrowDown") {
          event.preventDefault();
          const moved = moveActivityByOffset(session.id, activity.id, event.key === "ArrowUp" ? -1 : 1);
          if (moved) {
            saveState();
            render();
            announce(t("moved"));
          }
        }
      });

      const bindChoiceControl = (button, options, getValue, applyValue) => {
        const openMenu = () => {
          openChoiceMenu(button, options, getValue(), (nextValue) => {
            applyValue(nextValue);
          });
        };
        button.addEventListener("click", openMenu);
        button.addEventListener("keydown", (event) => {
          if (event.key === "Enter" || event.key === " " || event.key === "ArrowDown") {
            event.preventDefault();
            openMenu();
          }
          if (event.key === "Escape") {
            closeChoiceMenu(true);
          }
        });
      };

      bindChoiceControl(typeBtn, ACTIVITY_TYPE_OPTIONS, () => activity.type, (nextValue) => {
          activity.type = nextValue;
          saveState();
          render();
      });

      durationInput.addEventListener("input", (e) => {
        activity.duration = Math.max(1, Number(e.target.value) || 1);
        saveState();
        totalDuration.textContent = String(totalSessionMinutes(session));
        scheduleTopPanelRender();
        schedulePartitionRender();
      });

      bindChoiceControl(groupModeBtn, GROUP_MODE_OPTIONS, () => activity.groupMode, (nextValue) => {
          activity.groupMode = nextValue;
          saveState();
          renderTopPanel();
          setChoiceButton(groupModeBtn, GROUP_MODE_OPTIONS, activity.groupMode);
          renderPartitionView();
      });

      bindChoiceControl(trainerModeBtn, TRAINER_OPTIONS, () => activity.teacherPresence, (nextValue) => {
          activity.teacherPresence = nextValue;
          saveState();
          renderTopPanel();
          setChoiceButton(trainerModeBtn, TRAINER_OPTIONS, activity.teacherPresence);
          renderPartitionView();
      });

      bindChoiceControl(syncModeBtn, SYNC_OPTIONS, () => activity.syncMode, (nextValue) => {
          activity.syncMode = nextValue;
          saveState();
          renderTopPanel();
          setChoiceButton(syncModeBtn, SYNC_OPTIONS, activity.syncMode);
          renderPartitionView();
      });

      bindChoiceControl(
        locationModeBtn,
        LOCATION_OPTIONS,
        () => activity.locationMode,
        (nextValue) => {
          activity.locationMode = nextValue;
          saveState();
          renderTopPanel();
          setChoiceButton(locationModeBtn, LOCATION_OPTIONS, activity.locationMode);
          renderPartitionView();
        }
      );

      bindChoiceControl(
        evaluationModeBtn,
        EVAL_OPTIONS,
        () => activity.evaluationMode,
        (nextValue) => {
          activity.evaluationMode = nextValue;
          saveState();
          renderTopPanel();
          setChoiceButton(evaluationModeBtn, EVAL_OPTIONS, activity.evaluationMode);
        }
      );

      description.addEventListener("input", (e) => {
        activity.description = e.target.value;
        saveState();
      });

      instructions.addEventListener("input", (event) => {
        activity.instructions = event.target.value;
        saveState();
      });

      deleteActivityBtn.addEventListener("click", () => {
        session.activities = session.activities.filter((a) => a.id !== activity.id);
        saveState();
        render();
        announce(t("activityDeleted"));
      });

      selectToolsBtn.addEventListener("click", () => openToolPicker(selectToolsBtn, activity));
      selectToolsBtn.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " " || e.key === "ArrowDown") {
          e.preventDefault();
          openToolPicker(selectToolsBtn, activity);
        }
        if (e.key === "Escape") closeToolPicker(true);
      });
      activityLinksBtn.addEventListener("click", () => openActivityLinkModal(activityLinksBtn, activity));
      activityLinksBtn.addEventListener("keydown", (event) => {
        if (event.key === "Enter" || event.key === " " || event.key === "ArrowDown") {
          event.preventDefault();
          openActivityLinkModal(activityLinksBtn, activity);
        }
        if (event.key === "Escape") closeActivityLinkModal();
      });

      activitiesWrap.appendChild(activityFrag);
    });

    const addActivityBtn = frag.querySelector(".add-activity-btn");
    const toggleSessionNotesBtn = frag.querySelector(".toggle-session-notes-btn");
    setButtonLabel(addActivityBtn, "fa-solid fa-plus", t("addLearningType").replace(/^\+\s*/, ""));
    setSessionNotesButtonLabel(toggleSessionNotesBtn, session.notesExpanded);
    toggleSessionNotesBtn.setAttribute("aria-expanded", String(Boolean(session.notesExpanded)));
    addActivityBtn.addEventListener("click", () => {
      session.activities.push({
        id: nextId(),
        type: "undefined",
        duration: 10,
        groupMode: "whole",
        teacherPresence: "present",
        syncMode: "sync",
        locationMode: "onsite",
        evaluationMode: "none",
        aias: defaultAiasState(),
        description: "",
        instructions: "",
        notes: "",
        tools: [],
        links: []
      });
      saveState();
      render();
      announce(t("activityAdded"));
    });

    deleteSessionBtn.addEventListener("click", () => {
      state.sessions = state.sessions.filter((s) => s.id !== session.id);
      saveState();
      render();
      announce(t("sessionDeleted"));
    });

    toggleSessionNotesBtn.addEventListener("click", () => {
      session.notesExpanded = !session.notesExpanded;
      saveState();
      const isVisible = session.notesExpanded;
      sessionNotes.classList.toggle("hidden", !isVisible);
      setSessionNotesButtonLabel(toggleSessionNotesBtn, isVisible);
      toggleSessionNotesBtn.setAttribute("aria-expanded", String(Boolean(isVisible)));
      if (isVisible) {
        autoResizeTextarea(sessionNotesInput);
        requestAnimationFrame(() => {
          sessionNotesInput.focus();
          sessionNotesInput.scrollIntoView({ block: "nearest", behavior: "smooth" });
        });
      }
    });

    sessionNotesInput.value = session.notes || "";
    sessionNotesInput.setAttribute("aria-label", `${t("sessionNotesLabel")} ${sessionIndex + 1}`);
    sessionNotesInput.placeholder = t("sessionNotesPlaceholder");
    sessionNotesInput.addEventListener("input", (e) => {
      session.notes = e.target.value;
      saveState();
    });
    sessionNotes.classList.toggle("hidden", !session.notesExpanded);

    board.appendChild(frag);
  });

  ensureMarkdownToolbars(board);
  ensureMarkdownPreviews(board);
  localizeExpandableFieldControls(board);
  initAutoResizeTextareas();
}

function bindTopPanelEvents() {
  const tabButtons = [topTabSettings, topTabAnalysis];
  tabButtons.forEach((tab, index) => {
    tab.addEventListener("keydown", (event) => {
      if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(event.key)) return;
      event.preventDefault();
      let nextIndex = index;
      if (event.key === "ArrowLeft") nextIndex = (index - 1 + tabButtons.length) % tabButtons.length;
      if (event.key === "ArrowRight") nextIndex = (index + 1) % tabButtons.length;
      if (event.key === "Home") nextIndex = 0;
      if (event.key === "End") nextIndex = tabButtons.length - 1;
      tabButtons[nextIndex].focus();
      tabButtons[nextIndex].click();
    });
  });

  topPanelToggleBtn.addEventListener("click", () => {
    state.topPanelCollapsed = !state.topPanelCollapsed;
    saveState();
    renderTopPanel();
  });

  topTabSettings.addEventListener("click", () => {
    if (!state.topPanelCollapsed && state.meta.activeTab === "settings") {
      state.topPanelCollapsed = true;
    } else {
      state.meta.activeTab = "settings";
      state.topPanelCollapsed = false;
    }
    saveState();
    renderTopPanel();
  });

  topTabAnalysis.addEventListener("click", () => {
    if (!state.topPanelCollapsed && state.meta.activeTab === "analysis") {
      state.topPanelCollapsed = true;
    } else {
      state.meta.activeTab = "analysis";
      state.topPanelCollapsed = false;
    }
    saveState();
    renderTopPanel();
  });

  topTabChronology.addEventListener("click", () => {
    if (!state.topPanelCollapsed && state.meta.activeTab === "chronology") {
      state.topPanelCollapsed = true;
    } else {
      state.meta.activeTab = "chronology";
      state.topPanelCollapsed = false;
    }
    saveState();
    renderTopPanel();
    renderPartitionView();
  });

  metaNameInput.addEventListener("input", (event) => {
    state.meta.name = event.target.value;
    saveState();
  });
  const debouncedRenderTopPanel = debounce(renderTopPanel, 300);
  metaLearningDaysInput.addEventListener("input", (event) => {
    setLearningTime(event.target.value, state.meta.learningHours, state.meta.learningMinutes);
    saveState();
    debouncedRenderTopPanel();
  });
  metaLearningHoursInput.addEventListener("input", (event) => {
    setLearningTime(state.meta.learningDays, event.target.value, state.meta.learningMinutes);
    saveState();
    debouncedRenderTopPanel();
  });
  metaLearningMinutesInput.addEventListener("input", (event) => {
    setLearningTime(state.meta.learningDays, state.meta.learningHours, event.target.value);
    saveState();
    debouncedRenderTopPanel();
  });
  metaDeliverySelect.addEventListener("change", (event) => {
    state.meta.modeDelivery = event.target.value;
    saveState();
  });
  metaDayHoursInput.addEventListener("input", (event) => {
    state.meta.dayHours = Math.max(1, Number(event.target.value) || DEFAULT_DAY_HOURS);
    setLearningTime(state.meta.learningDays, state.meta.learningHours, state.meta.learningMinutes);
    saveState();
    renderTopPanel();
  });
  metaSizeClassInput.addEventListener("input", (event) => {
    const rawValue = String(event.target.value ?? "").trim();
    state.meta.sizeClass = rawValue === "" ? "" : Math.max(1, Number(rawValue) || 1);
    saveState();
  });
  metaDesignersInput.addEventListener("input", (event) => {
    state.meta.designers = event.target.value;
    saveState();
  });
  metaTrainersInput.addEventListener("input", (event) => {
    state.meta.trainers = event.target.value;
    saveState();
  });
  metaDescriptionInput.addEventListener("input", (event) => {
    state.meta.description = event.target.value;
    saveState();
  });
  metaCommandInput.addEventListener("input", (event) => {
    state.meta.command = event.target.value;
    saveState();
  });
  metaPersonasInput.addEventListener("input", (event) => {
    state.meta.personas = event.target.value;
    saveState();
  });
  addOutcomeBtn.addEventListener("click", () => openBloomModal("add"));
  bloomCancelBtn.addEventListener("click", () => closeModal(bloomModalBackdrop));
  bloomAddBtn.addEventListener("click", confirmBloom);
  bloomModalBackdrop.addEventListener("click", (e) => {
    if (e.target === bloomModalBackdrop) closeModal(bloomModalBackdrop);
  });
  activityLinkCancelBtn.addEventListener("click", closeActivityLinkModal);
  activityLinkSaveBtn.addEventListener("click", confirmActivityLink);
  activityLinkModalBackdrop.addEventListener("click", (event) => {
    if (event.target === activityLinkModalBackdrop) closeActivityLinkModal();
  });
  aiasModalCloseBtn.addEventListener("click", closeAiasModal);
  aiasModalBackdrop.addEventListener("click", (event) => {
    if (event.target === aiasModalBackdrop) closeAiasModal();
  });
  activityLinkTitleInput.addEventListener("input", () => setActivityLinkError(""));
  activityLinkUrlInput.addEventListener("input", () => setActivityLinkError(""));
  activityLinkUrlInput.addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      event.preventDefault();
      confirmActivityLink();
    }
  });
  langSelect.addEventListener("change", (event) => {
    state.meta.uiLanguage = event.target.value === "en" ? "en" : "fr";
    document.documentElement.lang = state.meta.uiLanguage;
    try {
      localStorage.setItem(LD_LANGUAGE_STORAGE_KEY, state.meta.uiLanguage);
    } catch (_) {}
    saveState();
    render();
  });
  if (languageButton) {
    languageButton.addEventListener("click", () => {
      const nextLang = langSelect.value === "en" ? "fr" : "en";
      const reduceMotion = window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;
      const applyLanguage = () => {
        langSelect.value = nextLang;
        langSelect.dispatchEvent(new Event("change", { bubbles: true }));
      };
      if (reduceMotion) {
        applyLanguage();
        return;
      }
      languageButton.classList.add("is-leaving");
      window.setTimeout(() => {
        applyLanguage();
        languageButton.classList.remove("is-leaving");
        languageButton.classList.add("is-entering");
        window.setTimeout(() => languageButton.classList.remove("is-entering"), 180);
      }, 90);
    });
  }
}

addSessionBtn.addEventListener("click", () => {
  state.sessions.push({
    id: nextId(),
    title: "",
    objectives: "",
    intentions: "",
    notes: "",
    notesExpanded: false,
    activities: []
  });
  saveState();
  render();
});

document.getElementById("toggle-intentions-btn")?.addEventListener("click", () => {
  state.intentionsCollapsed = !state.intentionsCollapsed;
  saveState();
  render();
});

boardLayoutListBtn.addEventListener("click", () => {
  setBoardLayout("list");
});

boardLayoutColumnsBtn.addEventListener("click", () => {
  setBoardLayout("columns");
});

boardLayoutGridBtn.addEventListener("click", () => {
  setBoardLayout("grid");
});

(function () {
  const layoutBtns = [boardLayoutListBtn, boardLayoutColumnsBtn, boardLayoutGridBtn];
  const layouts    = ["list", "columns", "grid"];
  layoutBtns.forEach((btn, i) => {
    btn.addEventListener("keydown", (event) => {
      if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(event.key)) return;
      event.preventDefault();
      let idx;
      if (event.key === "Home")           idx = 0;
      else if (event.key === "End")       idx = layoutBtns.length - 1;
      else if (event.key === "ArrowLeft") idx = (i - 1 + layoutBtns.length) % layoutBtns.length;
      else                                idx = (i + 1) % layoutBtns.length;
      layoutBtns[idx].focus();
      setBoardLayout(layouts[idx]);
    });
  });
})();

newDesignBtn.addEventListener("click", () => {
  openModal(newDesignModalBackdrop, "#new-design-cancel-btn");
});
newDesignCancelBtn.addEventListener("click", () => closeModal(newDesignModalBackdrop));
newDesignConfirmBtn.addEventListener("click", () => {
  closeModal(newDesignModalBackdrop);
  state = createNewDesignState();
  window.learningDesignerClearRemoteDesignUrl?.();
  saveState();
  render();
  announce(t("moved"));
});
newDesignModalBackdrop.addEventListener("click", (e) => {
  if (e.target === newDesignModalBackdrop) closeModal(newDesignModalBackdrop);
});

function getExportPayload(format = "json", scope = exportScope, sessionIds = exportSessionIds) {
  const chosen = String(format).toLowerCase();
  const normalizedScope = normalizeExportScope(scope);
  const filenamePrefix = normalizedScope === "students" ? "consignes-eleves" : "design";
  if (chosen === "excel" || chosen === "xls" || chosen === "xlsx") {
    return {
      content: buildExcelExportDocument(normalizedScope, sessionIds),
      type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
      filename: `${filenamePrefix}-learning-designer-fr.xlsx`
    };
  }
  if (chosen === "md" || chosen === "markdown") {
    return {
      content: buildMarkdownExport(normalizedScope, sessionIds),
      type: "text/markdown;charset=utf-8",
      filename: `${filenamePrefix}-learning-designer-fr.md`
    };
  }
  if (chosen === "html") {
    return {
      content: buildHtmlExportDocument(normalizedScope, sessionIds),
      type: "text/html;charset=utf-8",
      filename: `${filenamePrefix}-learning-designer-fr.html`
    };
  }
  if (chosen === "word" || chosen === "doc" || chosen === "docx") {
    return {
      content: buildWordExportDocument(normalizedScope, sessionIds),
      type: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      filename: `${filenamePrefix}-learning-designer-fr.docx`
    };
  }
  return {
    content: JSON.stringify(
      normalizedScope === "students"
        ? buildStudentInstructionsData(sessionIds)
        : {
            ...state,
            sessions: getExportSessionEntries(sessionIds).map(({ session }) => session)
          },
      null,
      2
    ),
    type: "application/json;charset=utf-8",
    filename: `${filenamePrefix}-learning-designer-fr.json`
  };
}

function getFilenameExtension(filename = "") {
  const match = String(filename).match(/(\.[^.]+)$/);
  return match ? match[1] : "";
}

function getDefaultExportName(format = "json", scope = exportScope) {
  const normalizedScope = normalizeExportScope(scope);
  const payload = getExportPayload(format, normalizedScope);
  const extension = getFilenameExtension(payload.filename);
  const title = String(state?.meta?.name || "").trim();
  if (title) return normalizedScope === "students" ? `${title} - consignes élèves` : title;
  return String(payload.filename || "").slice(0, -extension.length) || "export";
}

function sanitizeExportFilename(rawName, defaultFilename) {
  const extension = getFilenameExtension(defaultFilename) || ".txt";
  const fallbackBase = String(defaultFilename || `export${extension}`).slice(0, -extension.length) || "export";
  const cleaned = String(rawName || fallbackBase)
    .replace(/[\\/:*?"<>|]+/g, "-")
    .replace(/\s+/g, " ")
    .replace(/^\.+|\.+$/g, "")
    .trim();
  const baseName = (cleaned || fallbackBase).replace(/\.(json|md|markdown|html|doc|docx|xls|xlsx)$/i, "") || fallbackBase;
  if (baseName.toLowerCase().endsWith(extension.toLowerCase())) {
    return baseName;
  }
  return `${baseName}${extension}`;
}

function getExportFilename(format = "json", scope = exportScope) {
  const defaultFilename = getExportPayload(format, scope).filename;
  return sanitizeExportFilename(exportFilenameInput?.value, defaultFilename);
}

window.learningDesignerGetExportPayload = getExportPayload;

async function exportDesign(format = "json", scope = exportScope) {
  const { content, type, filename } = updateExportPreview(format, scope);
  try {
    await downloadBlob(content, type, filename);
  } catch (error) {
    console.error("Export failed", error);
    showNotice(currentLang() === "en" ? "Download blocked by browser. Use the export window." : "Téléchargement bloqué par le navigateur. Utilisez la fenêtre d’export.", "warning");
  }
}

window.learningDesignerOpenExport = () => {
  openExportModal();
};

window.learningDesignerRunExport = async () => {
  await exportDesign(exportFormatSelect?.value || "json", exportScope);
};

exportDesignBtn.addEventListener("click", () => {
  openExportModal();
});

[exportScopeFullInput, exportScopeStudentsInput].forEach((input) => {
  input?.addEventListener("change", () => {
    if (!input.checked) return;
    exportScope = normalizeExportScope(input.value);
    if (exportFilenameInput) {
      exportFilenameInput.value = getDefaultExportName(exportFormatSelect?.value || "markdown", exportScope);
    }
    updateExportPreview(exportFormatSelect?.value || "markdown", exportScope);
  });
});

exportMomentsAllInput?.addEventListener("change", () => {
  exportSessionIds = exportMomentsAllInput.checked
    ? new Set(state.sessions.map(exportSessionKey))
    : new Set();
  exportMomentsList?.querySelectorAll("input[type='checkbox']").forEach((input) => {
    input.checked = exportSessionIds.has(input.dataset.exportSessionId || "");
  });
  syncExportMomentsSelection();
  updateExportPreview(exportFormatSelect?.value || "markdown", exportScope);
});

infoBtn.addEventListener("click", () => {
  openInfoModal();
});

infoModalCloseBtn.addEventListener("click", () => {
  closeInfoModal();
});

infoModalBackdrop.addEventListener("click", (event) => {
  if (event.target === infoModalBackdrop) {
    closeInfoModal();
  }
});

exportModalCancelBtn.addEventListener("click", () => {
  closeExportModal();
});

exportModalConfirmBtn.addEventListener("click", async () => {
  await window.learningDesignerRunExport();
});

exportFormatSelect?.addEventListener("change", () => {
  if (exportFilenameInput) {
    exportFilenameInput.value = getDefaultExportName(exportFormatSelect.value, exportScope);
  }
  updateExportPreview(exportFormatSelect.value, exportScope);
});

exportFilenameInput?.addEventListener("input", () => {
  updateExportPreview(exportFormatSelect?.value || "json", exportScope);
});

exportModalBackdrop.addEventListener("click", (event) => {
  if (event.target === exportModalBackdrop) {
    closeExportModal();
  }
});

exportResultCopyBtn?.addEventListener("click", async () => {
  if (!isCopyableExportFormat(exportFormatSelect?.value || "json")) return;
  try {
    await navigator.clipboard.writeText(exportResultText.value);
    showNotice(currentLang() === "en" ? "Export copied." : "Export copié.", "success");
  } catch {
    exportResultText.focus();
    exportResultText.select();
  }
});

importDesignBtn.addEventListener("click", () => {
  openImportModal();
});

importModalCancelBtn?.addEventListener("click", () => {
  closeImportModal();
});

importFileBtn?.addEventListener("click", () => {
  openImportPicker();
});

importModalBackdrop?.addEventListener("click", (event) => {
  if (event.target === importModalBackdrop) closeImportModal();
});

importModelsSearch?.addEventListener("input", () => {
  modelFilterQuery = importModelsSearch.value.trim().toLowerCase();
  renderModelList();
});

importModelsFamily?.addEventListener("change", () => {
  modelFilterFamily = importModelsFamily.value;
  renderModelList();
});

importModelsList?.addEventListener("click", async (event) => {
  const card = event.target.closest(".import-model-card");
  if (!card) return;
  const applied = await applyModel(card.dataset.modelId);
  if (applied) closeImportModal();
});

let xlsxLibraryPromise = null;
function loadXlsxLibrary() {
  if (window.XLSX) return Promise.resolve(window.XLSX);
  if (xlsxLibraryPromise) return xlsxLibraryPromise;

  xlsxLibraryPromise = new Promise((resolve, reject) => {
    const script = document.createElement("script");
    script.src = "https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js";
    script.async = true;
    script.onload = () => {
      if (window.XLSX) {
        resolve(window.XLSX);
        return;
      }
      xlsxLibraryPromise = null;
      reject(new Error("XLSX unavailable"));
    };
    script.onerror = () => {
      xlsxLibraryPromise = null;
      script.remove();
      reject(new Error("XLSX loading failed"));
    };
    document.head.appendChild(script);
  });

  return xlsxLibraryPromise;
}

importFileInput.addEventListener("change", async (e) => {
  const file = e.target.files?.[0];
  if (!file) return;
  const MAX_IMPORT_SIZE = 5 * 1024 * 1024; // 5 MB
  if (file.size > MAX_IMPORT_SIZE) {
    alert(t("importInvalid"));
    importFileInput.value = "";
    return;
  }
  const forcedFormat = String(importFileInput.dataset.format || "").toLowerCase();
  const filename = String(file.name || "").toLowerCase();
  const selectedFormat =
    forcedFormat === "xlsx" || filename.endsWith(".xlsx") ? "xlsx"
    : forcedFormat === "csv" || filename.endsWith(".csv") ? "csv"
    : forcedFormat === "markdown" || forcedFormat === "md" || filename.endsWith(".md") || filename.endsWith(".markdown") ? "markdown"
    : forcedFormat === "ldj" || filename.endsWith(".ldj") ? "ldj"
    : "json";
  try {
    let hydrated = null;
    if (selectedFormat === "xlsx") {
      const xlsx = await loadXlsxLibrary();
      const buffer = await file.arrayBuffer();
      const workbook = xlsx.read(buffer, { type: "array" });
      const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
      const csvText = xlsx.utils.sheet_to_csv(firstSheet);
      hydrated = buildStateFromCsv(csvText);
    } else if (selectedFormat === "csv") {
      const text = await file.text();
      hydrated = buildStateFromCsv(text);
    } else if (selectedFormat === "markdown") {
      const text = await file.text();
      hydrated = buildStateFromMarkdown(text);
    } else {
      const text = await file.text();
      const parsed = JSON.parse(text);
      hydrated = isLegacyLdjDocument(parsed)
        ? buildStateFromLegacyLdj(parsed)
        : hydrateState(parsed, null);
    }
    if (!hydrated) {
      throw new Error("Format invalide");
    }
    hydrated.meta.uiLanguage = preferredInterfaceLanguage(currentLang());
    state = hydrated;
    saveState();
    render();
    if (activeModalBackdrop === importModalBackdrop) closeImportModal();
    announce(t("import"));
  } catch {
    alert(t("importInvalid"));
  } finally {
    importFileInput.value = "";
    importFileInput.accept = ".json,.ldj,.csv,.xlsx,.md,.markdown,application/json,text/csv,text/markdown";
    delete importFileInput.dataset.format;
  }
});

// ── Partition config modal ───────────────────────────────────────────────────

function openPartitionConfigModal() {
  partitionConfigDraft = state.partitionLineConfig.map(line => ({ ...line }));
  renderPartitionConfigList();
  renderPartitionAddTypeSelect();
  openModal(partitionConfigModalBackdrop, "#partition-config-cancel-btn");
}

function closePartitionConfigModal() {
  closeModal(partitionConfigModalBackdrop);
}

function renderPartitionConfigList() {
  const list = document.getElementById("partition-config-list");
  if (!list) return;
  list.innerHTML = "";

  partitionConfigDraft.forEach((line, index) => {
    const row = document.createElement("div");
    row.className = "partition-config-row";

    const upBtn = document.createElement("button");
    upBtn.type = "button";
    upBtn.textContent = "▲";
    upBtn.title = t("partitionMoveUp");
    upBtn.disabled = index === 0;
    upBtn.addEventListener("click", () => {
      [partitionConfigDraft[index - 1], partitionConfigDraft[index]] =
        [partitionConfigDraft[index], partitionConfigDraft[index - 1]];
      renderPartitionConfigList();
    });

    const downBtn = document.createElement("button");
    downBtn.type = "button";
    downBtn.textContent = "▼";
    downBtn.title = t("partitionMoveDown");
    downBtn.disabled = index === partitionConfigDraft.length - 1;
    downBtn.addEventListener("click", () => {
      [partitionConfigDraft[index], partitionConfigDraft[index + 1]] =
        [partitionConfigDraft[index + 1], partitionConfigDraft[index]];
      renderPartitionConfigList();
    });

    const label = document.createElement("span");
    label.className = "partition-config-row-label";
    label.textContent = line.label;

    const typeBadge = document.createElement("span");
    typeBadge.className = "partition-config-row-type";
    const typeOption = PARTITION_TYPE_OPTIONS.find(t => t.type === line.type);
    typeBadge.textContent = typeOption ? t(typeOption.labelKey) : line.type;

    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.checked = line.visible;
    checkbox.title = t("partitionShowHide");
    checkbox.setAttribute("aria-label", `${t("partitionShowPrefix")} ${line.label}`);
    checkbox.addEventListener("change", () => {
      partitionConfigDraft[index].visible = checkbox.checked;
    });

    const delBtn = document.createElement("button");
    delBtn.type = "button";
    delBtn.textContent = "✕";
    delBtn.className = "del";
    delBtn.title = t("partitionDeleteLine");
    delBtn.addEventListener("click", () => {
      partitionConfigDraft.splice(index, 1);
      renderPartitionConfigList();
    });

    const btnGroup = document.createElement("div");
    btnGroup.className = "partition-config-row-btns";
    btnGroup.append(upBtn, downBtn, checkbox, delBtn);

    row.append(label, typeBadge, btnGroup);
    list.appendChild(row);
  });
}

function renderPartitionAddTypeSelect() {
  const typeSelect = document.getElementById("partition-add-type");
  const valueSelect = document.getElementById("partition-add-value");
  if (!typeSelect || !valueSelect) return;

  typeSelect.innerHTML = PARTITION_TYPE_OPTIONS
    .map(opt => `<option value="${opt.type}">${t(opt.labelKey)}</option>`)
    .join("");

  updatePartitionAddValueSelect();

  // Remove previous listener to avoid stacking
  typeSelect.replaceWith(typeSelect.cloneNode(true));
  const freshTypeSelect = document.getElementById("partition-add-type");
  freshTypeSelect.addEventListener("change", updatePartitionAddValueSelect);
}

function updatePartitionAddValueSelect() {
  const typeSelect = document.getElementById("partition-add-type");
  const valueSelect = document.getElementById("partition-add-value");
  if (!typeSelect || !valueSelect) return;
  const selectedType = PARTITION_TYPE_OPTIONS.find(t => t.type === typeSelect.value);
  valueSelect.innerHTML = (selectedType ? selectedType.options : [])
    .map(opt => `<option value="${opt.value}">${opt.label}</option>`)
    .join("");
}

function addPartitionLine() {
  const typeSelect = document.getElementById("partition-add-type");
  const valueSelect = document.getElementById("partition-add-value");
  if (!typeSelect || !valueSelect) return;
  const selectedType = PARTITION_TYPE_OPTIONS.find(t => t.type === typeSelect.value);
  const selectedOption = (selectedType ? selectedType.options : []).find(opt => opt.value === valueSelect.value);
  if (!selectedOption) return;
  const exists = partitionConfigDraft.some(l => l.type === typeSelect.value && l.value === valueSelect.value);
  if (exists) return;
  partitionConfigDraft.push({
    type: typeSelect.value,
    label: selectedOption.label,
    value: selectedOption.value,
    visible: true
  });
  renderPartitionConfigList();
}

function savePartitionConfig() {
  state.partitionLineConfig = partitionConfigDraft.map(line => ({ ...line }));
  saveState();
  renderPartitionView();
  closePartitionConfigModal();
}

document.getElementById("partition-config-cancel-btn")?.addEventListener("click", closePartitionConfigModal);
document.getElementById("partition-config-save-btn")?.addEventListener("click", savePartitionConfig);
document.getElementById("partition-add-line-btn")?.addEventListener("click", addPartitionLine);
partitionConfigModalBackdrop?.addEventListener("click", (e) => {
  if (e.target === partitionConfigModalBackdrop) closePartitionConfigModal();
});

// ─────────────────────────────────────────────────────────────────────────────

setupExpandableFields();
setupFormAccessibility();
bindTopPanelEvents();
window.learningDesignerApp = {
  getState() {
    const snapshot = JSON.parse(JSON.stringify(state));
    snapshot.meta = snapshot.meta && typeof snapshot.meta === "object" ? snapshot.meta : {};
    snapshot.meta.designedMinutes = totalDesignedMinutes();
    return snapshot;
  },
  getCurrentLang() {
    return currentLang();
  },
  t,
  announce,
  showNotice,
  initializeStorageScope,
  saveLocal() {
    saveState();
  },
  updateMeta(patch) {
    if (!patch || typeof patch !== "object") return;
    Object.assign(state.meta, patch);
    saveState();
  },
  clearRemoteMeta() {
    delete state.meta.remoteDesignId;
    delete state.meta.remoteUpdatedAt;
    saveState();
  },
  loadDocument(documentState, remoteMeta = {}) {
    const interfaceLanguage = preferredInterfaceLanguage(currentLang());
    state = hydrateState(documentState, defaultState());
    Object.assign(state.meta, remoteMeta);
    state.meta.uiLanguage = interfaceLanguage;
    saveState();
    render();
  }
};
// ── Tooltip personnalisé ─────────────────────────────────────
(function initTooltip() {
  const tip = document.createElement("div");
  tip.id = "app-tooltip";
  tip.setAttribute("role", "tooltip");
  tip.setAttribute("aria-hidden", "true");
  document.body.appendChild(tip);

  let timer = null;
  let activeTarget = null;

  // Déplace title → data-tooltip pour éviter le doublon natif
  function hoistTitles(root) {
    (root.querySelectorAll ? root.querySelectorAll("[title]:not(abbr)") : [])
      .forEach((el) => {
        if (!el.dataset.tooltip) el.dataset.tooltip = el.getAttribute("title");
        el.removeAttribute("title");
      });
  }
  hoistTitles(document);

  // Surveille les nouveaux éléments (cartes d'activité, boutons de choix…)
  new MutationObserver((mutations) => {
    mutations.forEach((m) => {
      m.addedNodes.forEach((node) => {
        if (node.nodeType === 1) {
          if (node.getAttribute && node.getAttribute("title") && node.tagName !== "ABBR") {
            if (!node.dataset.tooltip) node.dataset.tooltip = node.getAttribute("title");
            node.removeAttribute("title");
          }
          hoistTitles(node);
        }
      });
      // Gère aussi les attributions dynamiques de title (setChoiceButton)
      if (
        m.type === "attributes" &&
        m.attributeName === "title" &&
        m.target.tagName !== "ABBR" &&
        m.target.getAttribute("title")
      ) {
        m.target.dataset.tooltip = m.target.getAttribute("title");
        m.target.removeAttribute("title");
      }
    });
  }).observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ["title"] });

  function nearestTip(el) {
    let node = el;
    while (node && node !== document.body) {
      if (node.dataset && node.dataset.tooltip) return node;
      node = node.parentElement;
    }
    return null;
  }

  function formatTipText(text) {
    const raw = String(text || "");
    if (currentLang() !== "fr") return raw;
    return raw.replace(/([^:\s])\s*:\s*(?!\/\/)/g, "$1\u00a0:\u00a0");
  }

  function place(target) {
    const rect = target.getBoundingClientRect();
    const tw = tip.offsetWidth;
    const th = tip.offsetHeight;
    const gap = 9;
    const vw = window.innerWidth;

    tip.classList.remove("tip-above", "tip-below");

    let top;
    if (rect.top - th - gap > 6) {
      top = rect.top - th - gap;
      tip.classList.add("tip-above");
    } else {
      top = rect.bottom + gap;
      tip.classList.add("tip-below");
    }

    let left = rect.left + rect.width / 2 - tw / 2;
    left = Math.max(6, Math.min(vw - tw - 6, left));

    // Décale la flèche si le tooltip est déporté
    const arrowPos = Math.max(14, Math.min(tw - 14, rect.left + rect.width / 2 - left));
    tip.style.setProperty("--tip-arrow", arrowPos + "px");
    tip.style.top = Math.round(top) + "px";
    tip.style.left = Math.round(left) + "px";
  }

  function show(target) {
    activeTarget = target;
    tip.textContent = formatTipText(target.dataset.tooltip);
    tip.setAttribute("aria-hidden", "false");
    // Positionne hors-écran le temps de mesurer
    tip.style.left = "-9999px";
    tip.style.top = "-9999px";
    tip.classList.add("tip-visible");
    requestAnimationFrame(() => { if (activeTarget === target) place(target); });
  }

  function hide() {
    clearTimeout(timer);
    activeTarget = null;
    tip.classList.remove("tip-visible", "tip-above", "tip-below");
    tip.setAttribute("aria-hidden", "true");
  }

  document.addEventListener("mouseover", (e) => {
    const target = nearestTip(e.target);
    if (!target || target === activeTarget) return;
    clearTimeout(timer);
    timer = setTimeout(() => show(target), 480);
  });

  document.addEventListener("mouseout", (e) => {
    if (!nearestTip(e.target)) return;
    clearTimeout(timer);
    hide();
  });

  document.addEventListener("click", hide, true);
  document.addEventListener("keydown", hide, true);
  document.addEventListener("scroll", () => {
    if (activeTarget) place(activeTarget);
  }, { passive: true, capture: true });
})();

// ── Effet ripple au clic ──────────────────────────────────────
(function initRipple() {
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(
      ".btn:not(.btn-primary), .icon-btn, .layout-toggle-btn"
    );
    if (!btn) return;

    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height) * 2.2;
    const x = e.clientX - rect.left - size / 2;
    const y = e.clientY - rect.top - size / 2;

    const ripple = document.createElement("span");
    ripple.className = "btn-ripple";
    ripple.style.cssText = `width:${size}px;height:${size}px;left:${x}px;top:${y}px`;
    btn.appendChild(ripple);
    ripple.addEventListener("animationend", () => ripple.remove(), { once: true });
  });
})();

render();
})();
