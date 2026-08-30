// Catalogue des compétences numériques, au format TSV.
//
// Ce fichier ne contient que cette constante, et c'est volontaire : view.php et
// competencies.php en extraient le TSV côté serveur. Tant qu'il vivait au
// milieu des 8 000 lignes de interface.js, chaque affichage d'un design public
// lisait 356 Ko pour en extraire 22 Ko, et renommer la constante vidait
// silencieusement les libellés de compétences des pages publiques.
//
// À charger avant interface.js : c'est un script classique, donc la constante
// est visible depuis les scripts suivants. Voir app_competency_catalog_source()
// dans lib/bootstrap.php pour le pendant PHP.
//
// Format : une ligne « # id<TAB>libellé FR<TAB>libellé EN » ouvre un niveau,
// puis chaque ligne décrit une compétence :
//   section<TAB>application<TAB>numéro<TAB>libellé FR<TAB>description FR
// La constante COMPETENCY_CATALOG_EN_SOURCE, indexée par niveau et numéro,
// fournit les deux colonnes anglaises ajoutées par les lecteurs JS et PHP.

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

const COMPETENCY_CATALOG_EN_SOURCE = String.raw`# acquerir
1	Lock and unlock the iPad	Keep the iPad in the schoolbag until the teacher asks students to use it | Put the tablet to sleep when finished
2	Know and protect login credentials	Know the main login credentials | Protect passwords and data with Touch ID | Enable password saving in Settings | Use the password manager
3	Know the main multitasking gestures	Switch from one app to another with four fingers | Return to the Home Screen with four fingers | Undo or redo an action with three fingers | Perform the equivalent of a right-click with two fingers, or a standard click while holding the Control key
4	Type efficiently and quickly	Improve touch-typing skills with Taptouche (type at least 40 words per minute) | Use text predictions | Create shortcuts
5	Take care of equipment and solve basic problems	Store the iPad in the schoolbag | Put the schoolbag in a safe place | Clean the tablet regularly | Charge the iPad battery regularly to limit deterioration | Restart the iPad if it freezes or encounters a bug
6	Search with Safari	Use a search engine to find information
7	Know the essential websites	Use the most common websites (Pronote, the Institut website, online dictionaries, GeoGebra, Quizlet…) | Check grades and the homework diary on Pronote | View the timetable on Pronote
8	Quickly and easily access the most frequently used websites	Create a bookmark, favourite, or Home Screen icon to quickly access the websites needed
9	Read on the iPad	Read on the iPad, removing advertisements where appropriate | Read without distractions by using Reader mode | Export a web page as a PDF to highlight or annotate important passages
10	View course materials in OneNote	Find the class notebook for each subject | Check the app regularly to read documents and corrections
11	Find or submit an assignment in Teams	Find an assignment in Teams and submit work in Teams, knowing how to locate the completed work on the iPad or in Office 365
12	Save, organise, and retrieve documents on the iPad or in OneDrive	Save documents in the appropriate folder, organised by subject | Name documents so they can be found easily | Know how to use file version history to retrieve an earlier version of a document
13	Take notes with a keyboard or stylus	Use writing or note-taking apps (OneNote, Notability, Word…) | Add a section or page to a personal notebook in OneNote
14	Share documents with teachers or other students	Share documents by email, Teams, or OneNote to collaborate or simply submit work
15	Collaborate on documents in real time with other students	Invite a student or teacher to collaborate | Collaborate while respecting everyone's work | Use comments to suggest changes
16	Share documents with the appropriate permission levels	Share a document with the required permissions (view, comment, edit)
17	Reach the intended recipient	Ask questions or reply clearly and helpfully to a teacher or other students in Teams, notifying the recipient with an at-sign followed by their name
18	Create a presentation for the class	Know the essential features of presentation software such as PowerPoint, Genially, or Canva
19	Write an email	Structure an email correctly, including a subject line, an appropriate greeting, polite closing phrases, and a signature
20	Attach a file	Attach files to an email, making sure that attachments are named correctly and do not exceed the size limit
21	Respond appropriately to the situation	Reply to emails appropriately, using Reply All only when necessary, being polite, and following communication rules
22	Send an email	Send a message with the Outlook email client, including forwarding messages
23	Be familiar with common office applications	Know the main features of the Word word processor, PowerPoint presentation software, and Excel spreadsheet software
24	Choose the appropriate application for a task	Know that Word is used to write text, PowerPoint to create a presentation, and so on
25	Know the main rules for formatting text	Know the main text-formatting options, such as bold, italics, and text alignment
26	Use iMovie to create short videos	Record a short film | Make basic edits, such as trimming a clip or inserting a title
27	Use applications such as Voice Memos or GarageBand	Make a recording, such as a read-aloud, recitation, podcast, or audiobook
28	Draw or create sketches and diagrams	Use applications such as Procreate or Freeform | Use an application to create a mind map
29	Understand the concept of rights	Understand copyright, image rights, and royalty-free images | Define intellectual property
30	Cite sources, respect image rights and copyright, and use royalty-free images	Act honestly and identify the source of information provided | Understand what plagiarism is
# approfondir
1	Personalise the working environment	Create and manage app folders | Use Focus mode to avoid distractions | Where appropriate, disable, limit, or select notifications
2	Know and protect login credentials	Enable two-factor authentication whenever possible | Know the main privacy settings, including location services, access to personal data, and the use of cookies
3	Master advanced multitasking gestures	Know all multitasking gestures | Display two apps at once with Split View and Slide Over | Drag and drop one or more files between apps | Use Spotlight to find information or open an app
4	Type efficiently and quickly	Reach a typing speed of 60 words per minute | Use voice dictation features
5	Take care of equipment and solve basic problems	Regularly back up important data | Make sure the iPad's storage space is not full
6	Search with Safari	Use different search engines according to the task | Understand some of the principles that determine search-result rankings | Use advanced search operators | Assess the relevance and reliability of sources by distinguishing advertising from sponsored content and identifying trustworthy information
7	Organise information monitoring	Use RSS feeds or subscribe to relevant newsletters | Know reliable resources and identify trustworthy sources, including fake news and disinformation
8	Quickly and easily access the most frequently used websites	Organise favourites and digital resources
9	Read on the iPad	Read and use ePub features such as annotations and the built-in dictionary
10	View course materials in OneNote	Use Immersive Reader to support reading | Add a section or page
11	Find or submit an assignment in Teams	Use more advanced Teams features such as Calendar and Meet Now | Find past or overdue assignments
12	Save, organise, and retrieve documents on the iPad or in OneDrive	Use tags in the Files app to identify important files more quickly | Use the different view modes, including icons, list, and columns | Long-press a file to access key actions such as Get Info, Compress, Duplicate, and Share
13	Take notes with a keyboard or stylus	Structure notes | Use colour coding | Insert images or recordings | Know the range of available tools, including the lasso, shape insertion, and AI features | Know other note-taking apps such as Apple Notes or Notability
14	Share documents with teachers or other students	If shared work has been altered and passages deleted, use file history to recover them | Identify who made each change
15	Collaborate on documents in real time with other students	Set permissions that change over time, from viewing to editing | Provide different versions according to the document's status: draft, review, and final | Restrict editing in specific parts of a document
16	Create favourites in Outlook	Create favourites to find frequent recipients more quickly
17	Create rules in Outlook	Create rules to find and organise emails more easily
18	Create a signature in Outlook	Configure Outlook to insert a signature automatically at the end of an email
19	Stay organised	Add calendar events with deadlines so that tasks are not forgotten | Invite another student to an event when working on a group project | Save an important email to OneNote
20	Collect simple data	Collect data with a form created in Microsoft Forms | Create a small dashboard to analyse results, such as grades, or to collect information, such as dates relating to an event or a bibliography
21	Organise and visually represent data	Use conditional formatting | Insert a simple chart, such as a pie chart or bar chart
22	Perform simple calculations	Know simple formulas, such as calculating an average or counting data
23	Format data	Apply basic formatting rules to make a spreadsheet easy to read
24	Use the Calculator	Perform common calculations | Switch from the basic to the scientific calculator | Carry out conversions | Solve equations or plot graphs with Math Notes
25	Become familiar with the interface	Navigate the interface and add sprites, backdrops, and code blocks
26	Understand the concept of a block	Combine different types of blocks to create animations, simple games, or interactive stories
27	Know the basics of programming	Use conditional instructions such as if… then | Use loops to repeat a series of instructions | Understand variables as a way to store and manipulate data
28	Be familiar with common office applications	In addition to the Office 365 suite, including Word and PowerPoint, know the Apple equivalents and their distinctive features, such as Pages and Keynote
29	Create enriched multimedia documents	Use Canva to create rich documents that include different media types, such as text, images, and sound | Present them orally without reading notes and within a set time
30	Process and edit images	Crop and resize an image and adjust basic settings such as brightness and contrast | Apply simple filters and effects
31	Use iMovie for video editing	Create longer and more polished films, including titles and transitions | Know the different video formats and how to compress or share them, particularly through Microsoft Stream
32	Use applications such as Voice Memos or GarageBand	Record and edit audio content | Share productions and add an image or description in preparation for publication
33	Draw or create sketches and diagrams	Develop greater proficiency with Procreate | Use Notes, insert a graph, and use its calculation features | Use mind-mapping applications such as Whimsical
34	Use artificial intelligence	Ask relevant questions in a chatbot | Assess the relevance of the answers | Identify bias, stereotypes, and hallucinations
35	Use multimodal AI systems	Use AI to generate text, images, or musical compositions
# creer
1	Use advanced browser features	Use profiles and tab groups; hide unwanted elements; display Reader; use translation, extensions, and the Share menu, for example to send a web page to OneNote
2	Conduct in-depth research	Use Google Scholar to search by author or date, perform advanced searches, and receive alerts | Use JSTOR for advanced searches, Boolean operators, and tools such as Text Analyzer and the Understanding Series
3	Conduct complex searches to find information	Use a reverse search engine to find the origin of an image, or the Wayback Machine to find an archived web page
4	Use Wikipedia's advanced features	View a page's history, edits, discussions, tools, and more
5	Organise course materials in OneNote	Archive, organise, and quickly retrieve documents in OneDrive by using a logical folder structure and consistent naming conventions
6	Use Teams as a project-management tool	Create a channel or team for a project, assign roles, and track everyone's contributions through the discussion feed or document comments | Integrate resources such as a schedule, OneNote, and a shared calendar
7	Set up a personal system for tracking tasks and projects	Create and maintain a digital to-do list in OneNote or Outlook | Create reminders, possibly using Apple's Reminders app
8	Lead a short online meeting or presentation in Teams	Organise a simple video conference, including the invitation, agenda, and screen sharing, for a presentation or collaborative project | Manage roles such as speaking, moderating, and timekeeping, and use chat or emoji reactions
9	Take an active role in communication	Create a guide or good-practice charter, for example by contributing to awareness campaigns about environmental issues or bullying | Organise an awareness workshop to identify and combat climate change, cyberbullying, or disinformation
10	Apply the full range of skills and applications needed to communicate actively	Lead a collaborative digital project using Teams, Padlet, Trello, Notion, or similar tools | Organise shared resources and manage access to them
11	Create an advanced collaborative multimedia production	Produce complex digital content, such as a collaborative website, web documentary, or collaborative podcast. See the Creativity and expression domain
12	Use the web responsibly	Become familiar with the concept of digital identity | Pay attention to the traces left online and understand the implications and reach of written contributions
13	Build enriched Word documents	Include a table of contents | Include correctly formatted citations using styles such as APA or MLA
14	Analyse data with Excel	Use conditional formulas such as IF and COUNTIF and apply data validation | Create filters for personal or shared use | Create a chart suited to the type of data | Apply these skills to tasks such as creating a budget or tracking sports or scientific data
15	Perform calculations in Excel	Know and combine several formulas, such as IF with AND, or OR with AVERAGE
16	Know some advanced formulas	Master advanced formulas such as INDEX, MATCH, IFS, and VLOOKUP
17	Insert equations	Use the equation editor in Word
18	Develop greater proficiency with Scratch	Create a mini-game that applies previously acquired skills such as variables, conditions, loops, and multiple events | Take part in initiatives such as Nuit du Code or Algorea, or visit the fab lab
19	Get started with Python	Write a simple linear program | Use variables, conditions, and loops | Insert comments to make code easier to read
20	Automate tasks	Write simple scripts to automate repetitive tasks such as renaming files, sorting folders automatically, or generating lists | Where appropriate, use AI to help generate these scripts
21	Contribute to the development of Vikidia or Wikipedia	Have an account and make simple edits where appropriate | Write for the encyclopaedia by using a neutral and objective tone, providing references, and knowing wiki syntax | Contribute to a collaborative project by correcting or moderating content and responding to edit requests
22	Create a podcast or contribute to web radio	Use applications such as GarageBand or Soundtrap for complex or collaborative editing | In GarageBand, insert loops, sound effects, or music | Publish on a platform such as Spotify
23	Create a website	Learn the basics of web development, including HTML and CSS | Know no-code tools | Create complex websites with WordPress or Wix
24	Create complex animations	Use Procreate or Procreate Dreams to create complex animations, such as artworks or tutorials
25	Use artificial intelligence to create rich, personal content	Generate images or audio documents, or write code, to produce complex projects
26	Use common office applications to create rich content	Use applications such as PowerPoint or Keynote to create interactive presentations with a variety of animations and transitions
27	Process and edit images	Edit images and use advanced image-editing software features | Know how to use layers, the lasso, and a range of other tools
28	Edit video	Use online editing software such as CapCut for projects that are more complex than those produced with iMovie | Create complex projects such as booktubes, reports, or web TV productions using green screens, sound recording, effects, and more
29	Use augmented reality or create augmented-reality activities	Use applications such as Reality Composer, FoxAR, ARMaker, and Adobe Aero
30	Create usable 3D objects and virtual-reality experiences	Create an immersive environment with an accessible application such as CoSpaces Edu | Design original 3D objects with Tinkercad or SketchUp | Export a 3D object in a standard format such as STL or OBJ for 3D printing or visualisation`;
