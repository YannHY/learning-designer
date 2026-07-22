<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$aiPrompt = <<<'PROMPT'
Tu dois créer un design pédagogique Learning Designer en utilisant le CLI `learning`.

Important :
Tu es peut-être dans un sandbox isolé. Si `learning` n’est pas disponible, installe une copie locale du CLI dans ton environnement :

mkdir -p .tools/bin
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/bin/learning -o .tools/bin/learning
chmod +x .tools/bin/learning
./.tools/bin/learning --help

Si raw.githubusercontent.com est bloqué, utilise web_fetch ou une autre méthode disponible pour récupérer :
https://github.com/YannHY/learning-designer/blob/main/bin/learning

Puis écris le fichier dans `.tools/bin/learning`, rends-le exécutable, et utilise toujours :

./.tools/bin/learning

Une fois `.tools/bin/learning` créé, ne dépends plus du réseau.

Mission :
Créer un fichier `design.json` complet, structuré, détaillé et importable dans Learning Designer.

Utilise le CLI autant que possible. N’écris pas le JSON à la main sauf si le CLI est impossible à utiliser après plusieurs tentatives documentées.

Commence par me poser les questions nécessaires en français, sans me surcharger.

Questions indispensables :
- sujet ou thème de la séance/séquence ;
- niveau et public cible ;
- durée totale ;
- modalité : présentiel, distanciel ou hybride ;
- taille du groupe ;
- objectifs d’enseignement : ce que je veux faire travailler, transmettre ou entraîner ;
- acquis d’apprentissage attendus : ce que les élèves devront être capables de faire à la fin ;
- contraintes matérielles, pédagogiques ou institutionnelles ;
- niveau de détail souhaité.

Questions complémentaires à poser seulement si c’est utile :
- niveau Bloom souhaité pour chaque acquis, si je le connais ;
- compétences numériques à mobiliser, si pertinent ;
- supports, œuvres, ressources ou outils déjà imposés.

Distingue bien :
- les objectifs d’enseignement, qui décrivent mon intention pédagogique ;
- les acquis d’apprentissage, qui décrivent ce que les élèves sauront faire à la fin.

Si je donne seulement des objectifs d’enseignement, transforme-les en acquis d’apprentissage observables, formulés avec des verbes d’action et reliés à la taxonomie de Bloom.

Si certaines informations manquent, fais des hypothèses raisonnables au lieu de bloquer, sauf si l’hypothèse serait risquée.

Cas particulier de la durée :
- si la durée est donnée en jours, demande ou propose explicitement une durée par séance avant de générer le design ;
- par défaut, pour le collège, interprète 1 jour comme 1 séance de 55 minutes, sauf indication contraire ;
- annonce clairement l’hypothèse retenue.

Avant d’exécuter les commandes de création complète, reformule brièvement :
- le sujet ;
- le public ;
- la durée totale convertie en minutes ;
- le nombre de moments prévu ;
- les objectifs d’enseignement ;
- les acquis Bloom proposés ;
- les principales compétences numériques, si elles sont mobilisées.

Ensuite utilise le CLI, pas une écriture manuelle du JSON.

Avant de créer toutes les activités, vérifie les commandes utiles :
- ./.tools/bin/learning --help
- ./.tools/bin/learning init --help
- ./.tools/bin/learning add-moment --help
- ./.tools/bin/learning add-activity --help
- ./.tools/bin/learning outcome --help
- ./.tools/bin/learning list types
- ./.tools/bin/learning list bloom
- ./.tools/bin/learning list competencies

Pour `add-activity`, utilise uniquement les valeurs contrôlées acceptées par le CLI.

Valeurs sûres :
- `--type` : `read`, `investigate`, `practice`, `produce`, `discuss`, `collaborate`
- `--group` : `individual`, `subgroups`, `whole`
- `--teacher` : `present`, `absent`
- `--evaluation` : `diagnostic`, `formative`, `summative`, `certificative`, `none`

Pour `--pacing` et `--mode`, vérifie avec le CLI ou utilise les valeurs produites par les exemples qui fonctionnent. En présentiel synchrone, `--pacing synchronous` et `--mode presentiel` sont acceptables si le CLI les valide.

Ne mets jamais de phrases longues dans les champs contrôlés comme `--group`, `--teacher`, `--evaluation`, `--type` ou `--pacing`.

Mets les consignes, critères, supports, rôle de l’enseignant, modalités de différenciation et détails pédagogiques dans :
- `--description`
- `--notes`
- `--objectives`
- `--intentions`

Commandes à utiliser obligatoirement autant que possible :
- ./.tools/bin/learning init
- ./.tools/bin/learning add-moment
- ./.tools/bin/learning add-activity
- ./.tools/bin/learning outcome
- ./.tools/bin/learning validate design.json
- ./.tools/bin/learning prompt design.json

Procédure recommandée :
1. Crée `design.json` avec `init`.
2. Ajoute les acquis Bloom avec `outcome`.
3. Ajoute un premier moment et une première activité complète pour tester les valeurs CLI.
4. Si la commande passe, ajoute le reste des moments et activités.
5. Si une commande échoue, explique pourquoi, corrige la valeur fautive, puis recommence.
6. Valide systématiquement avec `validate`.
7. Exécute `prompt design.json`.

Le design doit inclure :
- des moments clairement titrés ;
- des intentions pédagogiques explicites ;
- des activités variées ;
- des durées réalistes ;
- des modalités de groupe adaptées ;
- des évaluations diagnostiques, formatives ou sommatives selon les étapes ;
- des acquis Bloom reliés aux activités ;
- des compétences numériques quand c’est pertinent ;
- des descriptions suffisamment détaillées pour être exploitables par un enseignant.

Si je demande d’intégrer le numérique, propose des usages pédagogiquement utiles, par exemple :
- recherche documentaire guidée ;
- vérification ou sélection de sources ;
- carte collaborative ;
- rédaction numérique ;
- sauvegarde et organisation des fichiers ;
- relecture, correction et amélioration d’un texte ;
- production ou partage contrôlé.

Utilise les identifiants de compétences numériques acceptés par le CLI, par exemple :
- A1, A2
- P1, P6
- C14, C15

À la fin, restitue-moi :
- le chemin du fichier `design.json` ;
- le résultat de la validation CLI ;
- le nombre de moments ;
- le nombre d’activités ;
- les objectifs d’enseignement pris en compte ;
- les acquis Bloom créés ;
- les compétences numériques mobilisées ;
- la répartition des durées ;
- les hypothèses retenues ;
- le contenu ou le fichier `design.json`.

Publication :
Ne publie pas directement depuis ton sandbox sauf si je te donne explicitement un jeton CLI.
Pour publier depuis mon Mac, indique-moi simplement, si le fichier est sur le Bureau :

learning publish ~/Desktop/design.json

Ou, si le fichier reste dans le dossier courant :

learning publish design.json

Règles importantes :
- Travaille progressivement.
- Pose d’abord les questions nécessaires.
- N’écris pas le JSON à la main sauf si le CLI est impossible à utiliser après plusieurs tentatives.
- Vérifie les valeurs acceptées avant de générer beaucoup d’activités.
- Teste une première activité avant de produire toute la séquence.
- Si une commande échoue, explique pourquoi, corrige-la et recommence.
- Une fois `.tools/bin/learning` créé, ne dépends plus du réseau.
- Ne publie jamais sans autorisation explicite.
PROMPT;

$skillPrompt = <<<'PROMPT'
Lis et applique cette skill :
https://github.com/YannHY/learning-designer/blob/main/skills/learning-designer/SKILL.md

Ta mission : m’aider à créer un fichier design.json Learning Designer avec le CLI learning, le valider, puis me donner les commandes exactes pour le publier.
PROMPT;

$designReviewPrompt = <<<'PROMPT'
Tu es expert en learning design, en conception universelle de l’apprentissage (CUA/UDL) ainsi qu’en différenciation pédagogique.

L’enseignant va te soumettre la description d’une séquence pédagogique (ou un export du Learning Designer de l’UCL). Tu dois l’aider à l’analyser en lui posant des questions réflexives et en lui proposant des pistes d’amélioration concrètes.

Tu structures ton analyse autour des 11 axes suivants :

1. INCLUSIVITÉ GÉNÉRALE — Le design permet-il à tous les élèves de participer, quels que soient leur niveau ou leur profil ? Les consignes sont-elles claires et accessibles ? Y a-t-il des alternatives pour les élèves qui n’auraient pas suivi une séance précédente ?

2. ÉLÈVES À BESOINS PARTICULIERS — Le design prend-il en compte les élèves DYS ? Des aménagements sont-ils prévus pour les élèves TDAH ? Les élèves HPI disposent-ils de tâches d’approfondissement ou d’enrichissement ?

3. DIFFÉRENCIATION PÉDAGOGIQUE — Le design propose-t-il des niveaux de difficulté différents ? Y a-t-il une différenciation de contenu, de processus ou de production ? Les élèves fragiles bénéficient-ils d’un étayage explicite ?

4. MULTIMODALITÉ — Le design varie-t-il les canaux d’apprentissage (texte, audio, vidéo, manipulation) ? Un même contenu est-il proposé sous plusieurs formes ?

5. AUTONOMIE ET MÉTACOGNITION — Les élèves savent-ils ce qu’on attend d’eux et pourquoi ? Y a-t-il des moments où l’élève réfléchit à ses propres apprentissages ? Le design favorise-t-il la prise d’initiative ?

6. COLLABORATION ET INTERACTION — Le design prévoit-il des moments de travail en binôme ou en groupe ? Les élèves ont-ils l’occasion d’apprendre les uns des autres ?

7. FEEDBACK ET ÉVALUATION FORMATIVE — Les élèves reçoivent-ils des feedbacks réguliers ? Y a-t-il des moments d’auto-évaluation ou de co-évaluation ? Une remédiation est-elle prévue en cas de difficulté ?

8. MOTIVATION ET ENGAGEMENT — Les activités ont-elles du sens aux yeux des élèves ? Y a-t-il des éléments déclencheurs (accroche, défi, énigme) ? La variété des formats maintient-elle l’attention ?

9. CHARGE COGNITIVE — Les activités sont-elles progressives ? Le design évite-t-il de surcharger les élèves ? Les temps sont-ils adaptés à la complexité des tâches ?

10. PLACE DU NUMÉRIQUE — Les outils numériques apportent-ils une réelle plus-value ? Le design serait-il accessible sans équipement numérique ? L’usage du numérique favorise-t-il l’activité de l’élève ?

11. ÉQUILIBRE DU LEARNING DESIGN — Le design s’appuie-t-il sur les 6 types d’apprentissage du Conversational Framework de Diana Laurillard (Acquisition, Investigation, Discussion, Pratique, Collaboration, Production) ? L’un de ces types est-il sur- ou sous-représenté ? La répartition entre travail individuel, en groupe et en classe entière est-elle cohérente avec les objectifs ? Les durées prévues sont-elles réalistes au regard de la complexité des tâches ? Les objectifs d’apprentissage (Knowledge, Comprehension, Application, Production) sont-ils bien alignés avec les activités proposées ?

Pour chaque axe :
- porte un diagnostic honnête à partir de ce que l’enseignant t’a soumis ;
- identifie 1 ou 2 points forts si possible ;
- propose 2 à 3 pistes concrètes et réalistes d’amélioration ;
- termine par un conseil clé en une phrase.

Adopte un ton bienveillant, professionnel et encourageant. Évite le jargon inutile. Tes suggestions doivent être directement applicables en classe.
PROMPT;

$aiPromptEn = <<<'PROMPT'
You must create a Learning Designer teaching design using the `learning` CLI.

Important:
You may be working in an isolated sandbox. If `learning` is not available, install a local copy of the CLI in your environment:

mkdir -p .tools/bin
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/bin/learning -o .tools/bin/learning
chmod +x .tools/bin/learning
./.tools/bin/learning --help

If raw.githubusercontent.com is blocked, use web_fetch or another available method to retrieve:
https://github.com/YannHY/learning-designer/blob/main/bin/learning

Then write the file to `.tools/bin/learning`, make it executable, and always use:

./.tools/bin/learning

Once `.tools/bin/learning` has been created, do not rely on the network again.

Mission:
Create a complete, structured, detailed `design.json` file that can be imported into Learning Designer.

Use the CLI whenever possible. Do not write the JSON manually unless using the CLI remains impossible after several documented attempts.

Start by asking me the necessary questions in English without overwhelming me.

Essential questions:
- topic or subject of the lesson or sequence;
- level and target learners;
- total duration;
- delivery mode: in person, online, or hybrid;
- group size;
- teaching objectives: what I want learners to work on, understand, or practise;
- expected learning outcomes: what learners should be able to do at the end;
- material, pedagogical, or institutional constraints;
- desired level of detail.

Ask these additional questions only when useful:
- the desired Bloom level for each outcome, if I know it;
- digital competencies to be developed, when relevant;
- any required resources, works, materials, or tools.

Clearly distinguish between:
- teaching objectives, which describe my pedagogical intention;
- learning outcomes, which describe what learners will be able to do at the end.

If I provide only teaching objectives, turn them into observable learning outcomes using action verbs linked to Bloom’s taxonomy.

If information is missing, make reasonable assumptions instead of blocking, unless an assumption would be risky.

Duration rules:
- if the duration is given in days, ask for or explicitly suggest a duration per session before generating the design;
- by default, for lower secondary education, interpret one day as one 55-minute session unless stated otherwise;
- clearly state the assumption you use.

Before running all creation commands, briefly restate:
- the topic;
- the audience;
- the total duration converted to minutes;
- the planned number of moments;
- the teaching objectives;
- the proposed Bloom outcomes;
- the main digital competencies, when relevant.

Then use the CLI rather than writing the JSON manually.

Before creating all activities, inspect the useful commands:
- ./.tools/bin/learning --help
- ./.tools/bin/learning init --help
- ./.tools/bin/learning add-moment --help
- ./.tools/bin/learning add-activity --help
- ./.tools/bin/learning outcome --help
- ./.tools/bin/learning list types
- ./.tools/bin/learning list bloom
- ./.tools/bin/learning list competencies

For `add-activity`, use only controlled values accepted by the CLI.

Safe values:
- `--type`: `read`, `investigate`, `practice`, `produce`, `discuss`, `collaborate`
- `--group`: `individual`, `subgroups`, `whole`
- `--teacher`: `present`, `absent`
- `--evaluation`: `diagnostic`, `formative`, `summative`, `certificative`, `none`

For `--pacing` and `--mode`, check the CLI or use values from working examples. For synchronous in-person teaching, `--pacing synchronous` and `--mode presentiel` are acceptable if the CLI validates them.

Never put long sentences in controlled fields such as `--group`, `--teacher`, `--evaluation`, `--type`, or `--pacing`.

Put instructions, criteria, resources, the teacher’s role, differentiation, and pedagogical details in:
- `--description`
- `--notes`
- `--objectives`
- `--intentions`

Use these commands whenever possible:
- ./.tools/bin/learning init
- ./.tools/bin/learning add-moment
- ./.tools/bin/learning add-activity
- ./.tools/bin/learning outcome
- ./.tools/bin/learning validate design.json
- ./.tools/bin/learning prompt design.json

Recommended process:
1. Create `design.json` with `init`.
2. Add Bloom outcomes with `outcome`.
3. Add one moment and one complete activity to test the CLI values.
4. If the command succeeds, add the remaining moments and activities.
5. If a command fails, explain why, correct the invalid value, and try again.
6. Always run `validate`.
7. Run `prompt design.json`.

The design must include:
- clearly titled moments;
- explicit pedagogical intentions;
- varied activities;
- realistic durations;
- suitable group arrangements;
- diagnostic, formative, or summative assessment where appropriate;
- Bloom outcomes linked to activities;
- digital competencies when relevant;
- descriptions detailed enough for a teacher to use.

If I ask you to integrate digital technology, suggest pedagogically useful applications such as guided research, source checking, collaborative mapping, digital writing, file organisation, revision, and controlled sharing.

Use digital competency identifiers accepted by the CLI, for example:
- A1, A2
- P1, P6
- C14, C15

At the end, give me:
- the path to `design.json`;
- the CLI validation result;
- the number of moments and activities;
- the teaching objectives used;
- the Bloom outcomes created;
- the digital competencies developed;
- the duration breakdown;
- the assumptions made;
- the content or file `design.json`.

Publishing:
Do not publish directly from your sandbox unless I explicitly give you a CLI token.
To publish from my Mac, tell me to use `learning publish ~/Desktop/design.json` if the file is on the Desktop, or `learning publish design.json` if it remains in the current folder.

Important rules:
- Work progressively and ask the necessary questions first.
- Do not write JSON manually unless the CLI remains impossible to use after several attempts.
- Check accepted values before generating many activities.
- Test one activity before producing the whole sequence.
- If a command fails, explain why, correct it, and try again.
- Once `.tools/bin/learning` has been created, do not rely on the network.
- Never publish without explicit permission.
PROMPT;

$skillPromptEn = <<<'PROMPT'
Read and apply this skill:
https://github.com/YannHY/learning-designer/blob/main/skills/learning-designer/SKILL.md

Your mission: help me create a Learning Designer design.json file with the learning CLI, validate it, and give me the exact commands required to publish it.
PROMPT;

$designReviewPromptEn = <<<'PROMPT'
You are an expert in learning design, Universal Design for Learning (UDL), and differentiated instruction.

The teacher will submit a description of a teaching sequence or an export from UCL Learning Designer. Help them analyse it by asking reflective questions and suggesting concrete improvements.

Structure your analysis around these 11 areas:

1. OVERALL INCLUSIVENESS — Can all learners participate, regardless of level or profile? Are instructions clear and accessible? Are alternatives available for learners who missed an earlier session?

2. LEARNERS WITH ADDITIONAL NEEDS — Does the design support learners with dyslexia or related learning differences? Are accommodations planned for learners with ADHD? Do highly able learners have extension or enrichment tasks?

3. DIFFERENTIATED INSTRUCTION — Does the design offer different levels of difficulty? Is content, process, or output differentiated? Do learners who need support receive explicit scaffolding?

4. MULTIMODALITY — Does the design vary learning channels such as text, audio, video, and hands-on work? Is the same content available in more than one form?

5. AUTONOMY AND METACOGNITION — Do learners know what is expected and why? Are there moments when they reflect on their own learning? Does the design encourage initiative?

6. COLLABORATION AND INTERACTION — Does the design include pair or group work? Can learners learn from one another?

7. FEEDBACK AND FORMATIVE ASSESSMENT — Do learners receive regular feedback? Are self-assessment and peer assessment included? Is remediation planned when difficulties arise?

8. MOTIVATION AND ENGAGEMENT — Are the activities meaningful to learners? Is there a hook, challenge, or puzzle? Does variety help sustain attention?

9. COGNITIVE LOAD — Do activities progress gradually? Does the design avoid overloading learners? Are timings appropriate for task complexity?

10. ROLE OF DIGITAL TECHNOLOGY — Do digital tools add genuine value? Would the design remain accessible without digital equipment? Does technology support active learning?

11. LEARNING DESIGN BALANCE — Does the design use the six learning types from Diana Laurillard’s Conversational Framework: Acquisition, Investigation, Discussion, Practice, Collaboration, and Production? Is any type over- or under-represented? Is the balance between individual, group, and whole-class work consistent with the objectives? Are planned durations realistic for the complexity of the tasks? Are the learning objectives (Knowledge, Comprehension, Application, Production) aligned with the proposed activities?

For each area:
- give an honest diagnosis based on the submitted material;
- identify one or two strengths where possible;
- suggest two or three concrete, realistic improvements;
- finish with one key recommendation in a single sentence.

Use a supportive, professional, and encouraging tone. Avoid unnecessary jargon. Your suggestions must be directly applicable in the classroom.
PROMPT;

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aide | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260722-mobile-tab-spacing">
    <link rel="stylesheet" href="account-ui.css?v=20260520-4">
    <link rel="stylesheet" href="account-pages.css?v=20260722-neutral-theme">
</head>
<body class="help-page">
<?php render_site_nav('help'); ?>
<main class="help-shell" id="main-content">
    <header class="help-hero">
        <p class="help-kicker">Documentation</p>
        <h1 class="help-title">Concevoir, analyser et partager un design</h1>
        <p class="help-lead">Ce guide explique comment concevoir, importer, exporter et publier un design, avec ou sans IA.</p>
        <div class="help-quick-links" aria-label="Accès rapides">
            <a class="help-quick-link" href="#premiers-pas"><i class="fa-solid fa-rocket" aria-hidden="true"></i>Commencer</a>
            <a class="help-quick-link" href="#import-export"><i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i>Importer et exporter</a>
            <a class="help-quick-link" href="#markdown"><i class="fa-brands fa-markdown" aria-hidden="true"></i>Format Markdown</a>
            <a class="help-quick-link" href="#cli"><i class="fa-solid fa-terminal" aria-hidden="true"></i>IA et CLI</a>
        </div>
    </header>

    <button class="help-mobile-menu" id="help-menu-toggle" type="button" aria-expanded="false" aria-controls="help-sidebar">
        <span><i class="fa-solid fa-list" aria-hidden="true"></i> Sur cette page</span>
        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
    </button>

    <div class="help-layout">
        <aside class="help-sidebar" id="help-sidebar" aria-label="Sommaire de l’aide">
            <p class="help-sidebar-title">
                <span>Sur cette page</span>
                <span class="help-progress" aria-hidden="true"><span class="help-progress-bar" id="help-progress-bar"></span></span>
            </p>
            <nav class="help-toc" id="help-toc"></nav>
        </aside>

        <div class="help-content">
            <article class="help-section" id="premiers-pas">
                <p class="help-eyebrow"><i class="fa-solid fa-rocket" aria-hidden="true"></i> Prise en main</p>
                <h2>Comprendre le learning design</h2>
                <p>Le <em>learning design</em> consiste à organiser ce que les apprenants vont faire pour atteindre les acquis visés.</p>
                <div class="help-callout">
                    <i class="fa-solid fa-compass" aria-hidden="true"></i>
                    <p><strong>Question de départ : que doivent faire les apprenants pour atteindre les acquis visés&nbsp;?</strong>Le design rend cette succession d’activités explicite.</p>
                </div>
                <div class="help-grid three">
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-person-chalkboard" aria-hidden="true"></i></span>Concevoir l’activité</strong>
                        <span>Préciser ce que font les apprenants, avec quelles ressources, dans quelle organisation et pendant combien de temps.</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-shapes" aria-hidden="true"></i></span>Varier les apprentissages</strong>
                        <span>Combiner acquisition, investigation, pratique, production, discussion et collaboration selon les besoins du scénario.</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i></span>Observer et ajuster</strong>
                        <span>Comparer l’intention initiale avec ce qui se passe réellement, puis redessiner la séquence à partir des retours.</span>
                    </div>
                </div>
                <p class="help-spaced">Les types d’apprentissage ne constituent pas une répartition idéale à reproduire mécaniquement. Ils forment un vocabulaire commun pour décrire l’expérience proposée et vérifier qu’elle ne repose pas uniquement sur la transmission. La section <a href="#types-apprentissage">Les six types d’apprentissage</a> les présente en détail.</p>

                <h3 id="learning-designer-scenario-visible">Learning Designer : rendre le scénario visible</h3>
                <p>Le Learning Designer original a été développé à l’University College London par l’équipe de Diana Laurillard pour aider les enseignants à concevoir des activités pédagogiques, à analyser leur équilibre et à partager leurs projets. L’application présentée ici s’inscrit dans cette filiation : elle transforme un scénario pédagogique en une structure lisible, analysable et réutilisable.</p>
                <p>L’outil rend vos choix explicites afin que vous puissiez les interroger : le temps prévu correspond-il au temps effectivement scénarisé&nbsp;? Quelle place est accordée à chaque type d’apprentissage&nbsp;? Les élèves pratiquent-ils, discutent-ils et produisent-ils, ou restent-ils surtout en situation d’acquisition&nbsp;? Les modalités de groupe, le rythme, la présence enseignante et les évaluations sont-ils cohérents avec les acquis visés&nbsp;?</p>
                <div class="help-grid">
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-pen-ruler" aria-hidden="true"></i></span>Un outil de conception</strong>
                        <span>Il documente le contexte, les objectifs d’enseignement, les acquis attendus, les moments du parcours et les activités d’enseignement et d’apprentissage (<em>Teaching and Learning Activities</em>, ou TLA).</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-chart-pie" aria-hidden="true"></i></span>Un outil d’analyse</strong>
                        <span>Il calcule les durées et visualise la proportion des types d’apprentissage ainsi que les principales dimensions du scénario.</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-sliders" aria-hidden="true"></i></span>Un outil d’ajustement</strong>
                        <span>Il aide à repérer un déséquilibre ou un oubli afin que le concepteur décide des modifications pédagogiques pertinentes.</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-share-nodes" aria-hidden="true"></i></span>Un outil de partage</strong>
                        <span>Il permet d’enregistrer, d’exporter, de publier et de réutiliser un design pour le discuter ou l’adapter avec d’autres enseignants.</span>
                    </div>
                </div>

                <h3 id="creer-premier-design">Créer un premier design, étape par étape</h3>
                <ol>
                    <li><strong>Décrire le contexte.</strong> Renseignez le titre, la description, la commande institutionnelle, les objectifs d’enseignement, les concepteurs, les enseignants, la taille du groupe, la modalité et le temps d’apprentissage prévu. La durée peut être exprimée en jours, heures et minutes ; le nombre d’heures correspondant à une journée est configurable.</li>
                    <li><strong>Formuler les acquis attendus.</strong> Indiquez ce que les apprenants devront être capables de faire à la fin. Reliez si nécessaire chaque acquis à un niveau de la taxonomie révisée de Bloom et choisissez un verbe d’action observable.</li>
                    <li><strong>Structurer le parcours en moments.</strong> Un moment correspond à une phase cohérente de la séance ou de la séquence : lancement, exploration, entraînement, mise en commun, production ou évaluation.</li>
                    <li><strong>Ajouter les activités.</strong> Pour chacune, précisez le type d’apprentissage, la durée, l’organisation du groupe, la présence de l’enseignant, le rythme, la modalité, l’évaluation, les consignes et les ressources.</li>
                    <li><strong>Visualiser puis ajuster.</strong> Comparez le temps d’apprentissage prévu avec la somme des activités et observez les graphiques de répartition. Ces indicateurs éclairent votre décision ; ils ne remplacent pas votre jugement pédagogique.</li>
                </ol>
                <div class="help-callout">
                    <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                    <p><strong>Objectifs et acquis ne désignent pas la même chose.</strong> Les objectifs expriment ce que l’enseignant veut faire travailler, transmettre ou entraîner. Les acquis décrivent ce que les apprenants seront capables de faire à la fin, idéalement avec un verbe d’action observable.</p>
                </div>
                <p>Pour une présentation plus développée du cadre pédagogique, consultez également <a href="learning-design.php">Comprendre le learning design</a>.</p>
            </article>

            <article class="help-section" id="moments-activites">
                <p class="help-eyebrow"><i class="fa-solid fa-layer-group" aria-hidden="true"></i> Scénarisation</p>
                <h2>Organiser les moments et les activités</h2>
                <p>Chaque moment correspond à une phase cohérente de la séance ou de la séquence : lancement, exploration, mise en commun, entraînement, production, évaluation, etc. Un moment possède un titre, des objectifs, des choix pédagogiques et des notes. Les moments et les activités peuvent être réordonnés.</p>
                <h3>Paramètres disponibles pour une activité</h3>
                <div class="help-table-wrap">
                    <table class="help-table">
                        <thead><tr><th>Champ</th><th>Possibilités</th><th>Usage</th></tr></thead>
                        <tbody>
                            <tr><td>Type d’apprentissage</td><td>Lire, investiguer, pratiquer, produire, discuter, collaborer</td><td>Détermine la catégorie utilisée dans les graphiques d’analyse.</td></tr>
                            <tr><td>Durée</td><td>Nombre de minutes</td><td>Alimente le temps conçu, la chronologie et toutes les répartitions.</td></tr>
                            <tr><td>Groupe</td><td>Individuel, sous-groupes, groupe entier</td><td>Précise l’organisation sociale de l’activité.</td></tr>
                            <tr><td>Enseignant</td><td>Présent ou absent</td><td>Indique si l’activité nécessite la présence de l’enseignant.</td></tr>
                            <tr><td>Rythme</td><td>Synchrone ou asynchrone</td><td>Permet de distinguer les activités simultanées des activités réalisées au rythme de chacun.</td></tr>
                            <tr><td>Modalité</td><td>Présentiel, distanciel ou hybride</td><td>Décrit le lieu et le mode de participation.</td></tr>
                            <tr><td>Évaluation</td><td>Aucune, diagnostique, formative, sommative, certificative</td><td>Rend explicite la fonction évaluative de l’activité.</td></tr>
                            <tr><td>Contenu</td><td>Description, notes et liens</td><td>Documente les consignes, supports, critères, rôle de l’enseignant et ressources.</td></tr>
                            <tr><td>Compétences</td><td>Une ou plusieurs compétences numériques</td><td>Relie l’activité au référentiel numérique intégré.</td></tr>
                        </tbody>
                    </table>
                </div>
                <p>Les descriptions et les notes acceptent une mise en forme Markdown légère. Une barre d’outils et un aperçu permettent de structurer plus facilement le texte. Des liens nommés peuvent être ajoutés à chaque activité pour associer consignes, documents, vidéos ou outils.</p>
            </article>

            <article class="help-section" id="types-apprentissage">
                <p class="help-eyebrow"><i class="fa-solid fa-shapes" aria-hidden="true"></i> Cadre pédagogique</p>
                <h2>Les six types d’apprentissage</h2>
                <p>Learning Designer s’appuie sur les six types d’apprentissage associés au Cadre conversationnel de Diana Laurillard. Une séquence n’a pas besoin de les utiliser à parts égales, mais leur combinaison aide à varier l’expérience de l’apprenant.</p>
                <div class="help-types">
                    <div class="help-type help-type-read"><span class="help-type-dot"></span><div><strong>Lire / Regarder / Écouter</strong><span>Acquérir des informations par un exposé, un texte, une vidéo ou un enregistrement.</span></div></div>
                    <div class="help-type help-type-investigate"><span class="help-type-dot"></span><div><strong>Investiguer</strong><span>Rechercher, sélectionner, comparer et évaluer des informations ou des données.</span></div></div>
                    <div class="help-type help-type-practice"><span class="help-type-dot"></span><div><strong>Pratiquer</strong><span>Essayer, recevoir un retour, corriger son approche et recommencer.</span></div></div>
                    <div class="help-type help-type-produce"><span class="help-type-dot"></span><div><strong>Produire</strong><span>Créer un texte, une présentation, un modèle ou toute autre production évaluée.</span></div></div>
                    <div class="help-type help-type-discuss"><span class="help-type-dot"></span><div><strong>Discuter</strong><span>Formuler un point de vue, tenir compte des autres et défendre une position.</span></div></div>
                    <div class="help-type help-type-collaborate"><span class="help-type-dot"></span><div><strong>Collaborer</strong><span>Construire ensemble une réponse ou une production avec une responsabilité partagée.</span></div></div>
                </div>
                <p class="help-spaced">Le panneau d’analyse calcule la part de temps consacrée à chaque type. Cette visualisation sert d’indicateur de conception : elle aide à repérer une séquence très transmissive, un manque de pratique ou l’absence d’une production finale, sans imposer de répartition idéale.</p>
            </article>

            <article class="help-section" id="acquis-competences">
                <p class="help-eyebrow"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i> Résultats attendus</p>
                <h2>Formuler les acquis et suivre les compétences</h2>
                <h3 id="taxonomie-bloom">Taxonomie révisée de Bloom</h3>
                <p>Les acquis d’apprentissage peuvent être formulés à partir de la taxonomie révisée d’Anderson et Krathwohl. Choisissez un niveau cognitif, un verbe d’action, puis précisez le résultat attendu.</p>
                <div class="help-grid three">
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-brain" aria-hidden="true"></i></span>Se souvenir</strong><span>Citer, définir, identifier, lister, reconnaître.</span></div>
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-puzzle-piece" aria-hidden="true"></i></span>Comprendre</strong><span>Expliquer, illustrer, interpréter, résumer.</span></div>
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-pencil" aria-hidden="true"></i></span>Appliquer</strong><span>Démontrer, exécuter, résoudre, utiliser.</span></div>
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-chart-line" aria-hidden="true"></i></span>Analyser</strong><span>Comparer, décomposer, différencier, examiner.</span></div>
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-lightbulb" aria-hidden="true"></i></span>Évaluer</strong><span>Critiquer, défendre, justifier, recommander.</span></div>
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-hammer" aria-hidden="true"></i></span>Créer</strong><span>Concevoir, élaborer, formuler, produire.</span></div>
                </div>
                <p class="help-spaced">La page <a href="bloom.php">Taxonomie de Bloom</a> donne accès au tableau complet des verbes. Dans l’éditeur, chaque acquis reste modifiable et peut être supprimé.</p>
                <h3 id="competences-numeriques">Référentiel de compétences numériques</h3>
                <p>Le site intègre le référentiel de compétences numériques utilisé à l’Institut Florimont. Il rassemble 95 compétences organisées selon trois niveaux progressifs. Chaque activité peut être reliée à une ou plusieurs compétences, ce qui rend la progression numérique visible dans le scénario.</p>
                <div class="help-grid three">
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-seedling" aria-hidden="true"></i></span>Acquérir</strong><span>Bases de la vie numérique scolaire : appareil, recherche, organisation, communication et premiers usages créatifs.</span></div>
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-trowel" aria-hidden="true"></i></span>Approfondir</strong><span>Veille, collaboration, données simples, programmation visuelle, IA et création multimédia plus autonome.</span></div>
                    <div class="help-card"><strong><span class="help-card-icon"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i></span>Créer</strong><span>Projets avancés : données, Python, sites web, podcasts, 3D, réalité augmentée et productions collaboratives.</span></div>
                </div>
                <p class="help-spaced">La page <a href="competencies.php">Compétences numériques</a> présente l’ensemble du référentiel. Lorsque vous êtes connecté, elle peut signaler les compétences déjà mobilisées dans vos designs enregistrés.</p>
            </article>

            <article class="help-section" id="vues-analyses">
                <p class="help-eyebrow"><i class="fa-solid fa-chart-column" aria-hidden="true"></i> Lecture du scénario</p>
                <h2>Afficher et analyser le scénario</h2>
                <h3>Analyser l’expérience d’apprentissage</h3>
                <p>Dans le panneau supérieur de l’éditeur, juste sous la barre de navigation, cliquez sur l’onglet <strong>Analyse</strong>, à côté de <strong>Paramètres</strong> et <strong>Chronologie</strong>. Si le panneau est replié, ce clic le déploie. La vue <strong>Expérience d’apprentissage</strong> synthétise alors le scénario sous forme de graphiques. Elle compare notamment :</p>
                <ul>
                    <li>les six types d’apprentissage ;</li>
                    <li>le travail individuel, en sous-groupes et en groupe entier ;</li>
                    <li>la présence ou l’absence de l’enseignant ;</li>
                    <li>le rythme synchrone ou asynchrone ;</li>
                    <li>les modalités présentielle, distancielle et hybride ;</li>
                    <li>les formes d’évaluation.</li>
                </ul>
                <p>Les avertissements affichés dans cette vue signalent les données manquantes ou incohérentes — par exemple une activité sans durée ou sans type — qui pourraient fausser les graphiques.</p>
                <h3>Consulter la chronologie des activités</h3>
                <p>Dans ce même panneau supérieur, cliquez sur l’onglet <strong>Chronologie</strong>. Chaque activité y est positionnée selon sa durée et son ordre afin de donner une autre lecture de la séquence.</p>
                <h3>Choisir l’affichage du scénario</h3>
                <p>Plus bas dans l’éditeur, la barre d’outils située au-dessus du scénario permet de choisir <strong>Liste</strong> pour une lecture linéaire, <strong>Colonnes</strong> pour comparer les moments ou <strong>Grille</strong> pour obtenir une vue plus compacte. Ces trois boutons modifient uniquement la présentation des moments et des activités.</p>
            </article>

            <article class="help-section" id="sauvegarde-partage">
                <p class="help-eyebrow"><i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i> Compte et publication</p>
                <h2>Sauvegarder, publier et réutiliser</h2>
                <h3 id="sauvegarde-sans-compte">Sans compte</h3>
                <p>Vous pouvez concevoir et exporter un design sans vous connecter. Les modifications restent disponibles dans la page tant qu’elle est ouverte. Aucune donnée n’est envoyée au serveur sans action explicite de votre part.</p>
                <h3 id="sauvegarde-avec-compte">Avec un compte</h3>
                <p>Le bouton <strong>Enregistrer</strong> associe le design à votre compte. Vous pouvez ensuite le retrouver, le rouvrir, le renommer ou le supprimer depuis la page de vos designs.</p>
                <h3 id="publier-lien">Publier un lien consultable</h3>
                <p>Un design enregistré peut être publié pour générer une page de lecture partageable. Cette page présente les paramètres, les moments, les activités, les durées, les liens et les compétences numériques, mais ne permet pas aux visiteurs de modifier l’original.</p>
                <ul>
                    <li>Vous pouvez révoquer le lien de publication.</li>
                    <li>Vous pouvez choisir de rendre le design visible dans la galerie publique des designs partagés.</li>
                    <li>Une personne connectée peut importer un design partagé dans son propre compte afin de l’adapter.</li>
                </ul>
                <div class="help-callout">
                    <i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
                    <p><strong>Partager ne signifie pas forcément envoyer du Markdown.</strong> Vous pouvez transmettre un lien de publication, partager un fichier Word ou Excel, fournir une page HTML, ou échanger le fichier JSON natif selon le besoin du destinataire.</p>
                </div>
            </article>

            <article class="help-section" id="import-export">
                <p class="help-eyebrow"><i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i> Formats d’échange</p>
                <h2>Importer et exporter dans plusieurs formats</h2>
                <h3 id="formats-export">Formats d’export</h3>
                <div class="help-table-wrap">
                    <table class="help-table">
                        <thead><tr><th>Format</th><th>À choisir pour…</th><th>À savoir</th></tr></thead>
                        <tbody>
                            <tr><td><span class="help-format-badge">Markdown</span></td><td>Éditer un document lisible en texte brut, le versionner ou le transmettre à une IA.</td><td>Peut être réimporté si la structure et les libellés sont conservés.</td></tr>
                            <tr><td><span class="help-format-badge">HTML</span></td><td>Partager une page autonome lisible dans un navigateur.</td><td>Pratique pour consultation ou archivage web.</td></tr>
                            <tr><td><span class="help-format-badge">JSON</span></td><td>Conserver toutes les données structurées ou travailler avec le CLI.</td><td>C’est le format le plus fidèle pour l’échange technique et la réimportation.</td></tr>
                            <tr><td><span class="help-format-badge">Excel</span></td><td>Analyser, filtrer ou retravailler les activités dans un tableur.</td><td>Le fichier téléchargé utilise le format <code>.xlsx</code>.</td></tr>
                            <tr><td><span class="help-format-badge">Word</span></td><td>Relire, annoter, imprimer ou diffuser un document bureautique.</td><td>Le fichier téléchargé utilise le format <code>.docx</code>.</td></tr>
                        </tbody>
                    </table>
                </div>
                <p>Pour exporter, cliquez sur <strong>Exporter</strong>, choisissez le format et le nom du fichier, puis prévisualisez le contenu lorsqu’il s’agit d’un format textuel. Vous pouvez le copier ou le télécharger.</p>
                <h3 id="formats-import">Formats d’import</h3>
                <p>Le bouton <strong>Importer</strong> accepte les formats suivants :</p>
                <ul>
                    <li><strong>LDJ</strong>, le format du Learning Designer de l’University College London (UCL) ;</li>
                    <li><strong>JSON</strong>, pour restaurer les données structurées ;</li>
                    <li><strong>CSV</strong>, pour importer des données tabulaires ;</li>
                    <li><strong>Excel</strong> au format <code>.xlsx</code> ;</li>
                    <li><strong>Markdown</strong> au format <code>.md</code> ou <code>.markdown</code>.</li>
                </ul>
                <div class="help-callout warning">
                    <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                    <p>L’import remplace le design en cours. Enregistrez-le sur votre compte ou exportez-le avant d’importer un autre fichier si vous souhaitez le conserver.</p>
                </div>
            </article>

            <article class="help-section" id="markdown">
                <p class="help-eyebrow"><i class="fa-brands fa-markdown" aria-hidden="true"></i> Format éditable</p>
                <h2>Importer un design en Markdown</h2>
                <p>Le plus sûr est de partir d’un fichier Markdown exporté depuis Learning Designer, puis de le modifier sans changer sa structure. Le fichier doit contenir les sections <code>## Paramètres</code> et <code>## Séances</code>, qui permettent à l’application de reconnaître le document.</p>
                <h3 id="markdown-structure">Structure attendue</h3>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier l’exemple Markdown" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code"># Titre du design

## Paramètres

- Mode: Hybride
- Taille du groupe: 24
- Concepteur(s): Nom
- Enseignant(s): Nom
- Temps d'apprentissage: 1 j 2 h 30 min
- Temps conçu: 0 j 1 h 30 min
- 1 jour = 7 heures

### Description
Description générale du design.

### Commande institutionnelle
Contexte ou demande de départ.

### Objectifs
Objectifs généraux de la formation.

### Acquis d'apprentissage
- Comparer : comparer deux solutions

## Séances

## 1. Première séance
&gt; Objectifs:
&gt; Objectifs de la séance
&gt; Choix pédagogiques:
&gt; Intentions pédagogiques
&gt; Notes:
&gt; Notes de la séance

### 1.1 Investiguer
- Durée: 30 min
- Groupe: Sous-groupes
- Enseignant: Présent
- Rythme: Synchrone
- Modalité: Présentiel
- Évaluation: Formative
- Description: Description de l'activité
- Liens: Exemple (https://example.com)
- Compétences: A6 - Exemple de compétence</pre>
                </div>
                <h3 id="markdown-numerotation">Règles de numérotation</h3>
                <p>Chaque moment doit commencer par un titre de niveau 2 numéroté, et chaque activité par un titre de niveau 3 :</p>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier la règle de numérotation" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">## 1. Titre du moment
### 1.1 Type d'activité</pre>
                </div>
                <h3 id="markdown-valeurs">Valeurs reconnues</h3>
                <div class="help-table-wrap">
                    <table class="help-table">
                        <thead><tr><th>Champ</th><th>Valeurs conseillées</th></tr></thead>
                        <tbody>
                            <tr><td>Type</td><td><code>Non défini</code>, <code>Lire / Regarder / Écouter</code>, <code>Investiguer</code>, <code>Pratiquer</code>, <code>Produire</code>, <code>Discuter</code>, <code>Collaborer</code></td></tr>
                            <tr><td>Groupe</td><td><code>Groupe entier</code>, <code>Sous-groupes</code>, <code>Individuel</code></td></tr>
                            <tr><td>Enseignant</td><td><code>Présent</code>, <code>Absent</code></td></tr>
                            <tr><td>Rythme</td><td><code>Synchrone</code>, <code>Asynchrone</code></td></tr>
                            <tr><td>Modalité</td><td><code>Présentiel</code>, <code>Distanciel</code>, <code>Hybride</code></td></tr>
                            <tr><td>Évaluation</td><td><code>Aucune</code>, <code>Diagnostique</code>, <code>Formative</code>, <code>Sommative</code>, <code>Certificative</code></td></tr>
                        </tbody>
                    </table>
                </div>
                <h3 id="markdown-modifications">Ce que vous pouvez modifier</h3>
                <p>Vous pouvez modifier le titre, les paramètres, la description, la commande institutionnelle, les objectifs, les acquis d’apprentissage, les titres et contenus des moments, ainsi que les activités et tous leurs champs.</p>
                <h3 id="markdown-libelles">Libellés à conserver</h3>
                <p>Évitez de changer les libellés fixes <code>## Paramètres</code>, <code>## Séances</code>, <code>- Durée:</code>, <code>- Groupe:</code>, <code>- Enseignant:</code>, <code>- Rythme:</code>, <code>- Modalité:</code>, <code>- Évaluation:</code> et <code>- Description:</code>. S’ils changent trop, certaines informations risquent de ne plus être reconnues.</p>
                <h3 id="markdown-import">Procédure d’import</h3>
                <ol>
                    <li>Ouvrez Learning Designer.</li>
                    <li>Cliquez sur <strong>Importer</strong>.</li>
                    <li>Choisissez <strong>Markdown</strong>, puis un fichier <code>.md</code> ou <code>.markdown</code>.</li>
                    <li>Vérifiez les paramètres, les moments, les activités et les durées dans l’interface.</li>
                </ol>
                <p>Si l’import échoue, exportez un design simple en Markdown depuis l’application et comparez sa structure avec votre fichier.</p>
            </article>

            <article class="help-section" id="cli">
                <h2>Créer avec l’IA</h2>
                <p>Un CLI pour publier vos designs.</p>

                <h3 id="ia-guide">Guide</h3>
                <div class="help-grid">
                    <div class="help-card">
                        <strong>1. L’IA publie pour vous</strong>
                        <span>Copiez le prompt proposé plus bas dans Claude Code ou Codex. L’IA crée le fichier <code>design.json</code>, puis peut publier le design si vous lui donnez explicitement l’autorisation et un jeton CLI créé dans votre profil.</span>
                        <span>Dans ce cas, vous n’avez pas besoin d’installer le CLI dans votre terminal.</span>
                    </div>
                    <div class="help-card">
                        <strong>2. Vous publiez vous-même</strong>
                        <span>Copiez le prompt pour que l’IA crée le fichier <code>design.json</code>, puis téléchargez ce fichier sur votre ordinateur. Pour publier vous-même, vous devez installer le CLI, créer un jeton dans votre profil, lancer <code>learning login</code>, puis <code>learning publish</code>.</span>
                        <span>Les commandes d’installation et de publication sont expliquées dans l’onglet CLI détaillé.</span>
                    </div>
                </div>

                <h4>Prompt à donner à Claude Code ou Codex</h4>
                <p>Copiez ce prompt dans Claude ou Codex. Il demande à l’IA d’utiliser le CLI, de poser les bonnes questions pédagogiques, puis de produire un fichier validé.</p>
                <div class="help-prompt-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier le prompt" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <textarea class="help-prompt" data-help-prompt="ai" readonly><?= h($aiPrompt) ?></textarea>
                </div>

                <h4>À la fin</h4>
                <p>Demandez simplement à l’IA de publier le design qu’elle vient de créer. Pour cela, donnez-lui explicitement l’autorisation de publier et un jeton CLI créé dans votre profil.</p>
                <p>Si vous préférez publier vous-même depuis votre ordinateur, ouvrez l’onglet CLI détaillé.</p>

                <h3 id="skill-claude">Créer une skill Claude</h3>
                <p>Une skill permet de donner à Claude Code une méthode réutilisable. Pour Learning Designer, elle lui explique comment créer un design avec le CLI, le valider, puis préparer la publication.</p>

                <h4>Installer la skill publiée</h4>
                <p>C’est la méthode la plus simple : elle crée le bon dossier Claude Code et télécharge le fichier <code>SKILL.md</code> déjà prêt.</p>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">mkdir -p .claude/skills/learning-design
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/skills/learning-designer/SKILL.md -o .claude/skills/learning-design/SKILL.md</pre>
                </div>
                <p>Relancez Claude Code si la commande slash n’apparaît pas tout de suite, puis lancez la skill avec :</p>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">/learning-design</pre>
                </div>

                <h4>Créer la skill manuellement</h4>
                <div class="help-grid three">
                    <div class="help-card">
                        <strong>1. Créer le dossier</strong>
                        <span>Dans votre projet, créez <code>.claude/skills/learning-design</code>.</span>
                    </div>
                    <div class="help-card">
                        <strong>2. Ajouter SKILL.md</strong>
                        <span>Le fichier doit s’appeler <code>SKILL.md</code>, au singulier.</span>
                    </div>
                    <div class="help-card">
                        <strong>3. Lancer la skill</strong>
                        <span>Dans Claude Code, tapez <code>/learning-design</code>.</span>
                    </div>
                </div>
                <p>Depuis la racine de votre projet :</p>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">mkdir -p .claude/skills/learning-design
code .claude/skills/learning-design/SKILL.md</pre>
                </div>
                <p>Dans <code>SKILL.md</code>, commencez par ce modèle, puis ajoutez les consignes complètes de votre méthode.</p>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier le modèle" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">---
description: Crée un fichier design.json Learning Designer avec le CLI learning, pose les questions pédagogiques utiles, valide le fichier et prépare les commandes de publication.
---

# Learning Designer

Collez ici les consignes complètes que Claude doit suivre.</pre>
                </div>
                <div class="help-callout">
                    <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                    <p>Le chemin attendu par Claude Code est <code>.claude/skills/learning-design/SKILL.md</code>. Le dossier <code>skills</code> et le nom <code>SKILL.md</code> sont importants.</p>
                </div>

                <h4>Usage ponctuel sans installation</h4>
                <p>Si vous ne voulez pas installer de skill locale, copiez simplement ce prompt dans Claude ou Codex. L’IA ira lire la méthode publiée.</p>
                <div class="help-prompt-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier le prompt" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <textarea class="help-prompt help-prompt-compact" data-help-prompt="skill" readonly><?= h($skillPrompt) ?></textarea>
                </div>

                <h3 id="cli-detaille">CLI détaillé</h3>
                <p>La commande <code>learning</code> sert à créer, compléter, valider et publier un fichier <code>design.json</code> Learning Designer depuis le terminal. Cette page est utile si vous voulez publier manuellement ou comprendre ce que l’IA exécute dans son environnement.</p>

                <h4>Installer</h4>
                <p>L’installation locale est nécessaire seulement si vous voulez utiliser le CLI depuis votre ordinateur, par exemple pour publier vous-même. Si l’IA crée le design dans son sandbox, elle peut installer sa propre copie temporaire.</p>
                <div class="help-details-grid">
                    <div>
                        <strong>1. Lancer l’installateur</strong>
                        <p>Le script vérifie les prérequis, propose un dossier déjà disponible dans le <code>PATH</code>, puis installe la commande <code>learning</code>. Il peut vous demander de confirmer l’emplacement ou d’utiliser <code>sudo</code> selon votre système.</p>
                    </div>
                    <div>
                        <strong>2. Vérifier la commande</strong>
                        <p><code>learning status</code> confirme la version installée et indique si un jeton de publication est déjà configuré.</p>
                    </div>
                    <div>
                        <strong>3. Créer un jeton</strong>
                        <p>Connectez-vous au site, ouvrez votre profil, puis créez un jeton dans la section <strong>Publication depuis le CLI</strong>. Copiez-le tout de suite : il ne sera affiché qu’une seule fois.</p>
                    </div>
                    <div>
                        <strong>4. Connecter le CLI</strong>
                        <p><code>learning login</code> enregistre le jeton sur votre ordinateur pour les publications suivantes. Vous pouvez ensuite publier avec <code>learning publish</code>.</p>
                    </div>
                </div>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/install.sh | sh
learning status
learning login</pre>
                </div>

                <h4>Créer un design</h4>
                <div class="help-details-grid">
                    <div>
                        <strong>1. Initialiser le fichier</strong>
                        <p><code>init</code> crée le fichier JSON de départ avec le titre, la langue, la durée, la modalité et les informations générales.</p>
                        <div class="help-code-wrap">
                            <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                            <pre class="help-code">learning init design.json --title "Atelier IA" --lang fr --duration 120 --mode hybride --group-size 24</pre>
                        </div>
                    </div>
                    <div>
                        <strong>2. Ajouter des moments</strong>
                        <p>Un moment correspond à une grande phase de la séance ou de la séquence.</p>
                        <div class="help-code-wrap">
                            <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                            <pre class="help-code">learning add-moment design.json --title "Explorer" --objectives "Identifier les usages possibles"</pre>
                        </div>
                    </div>
                    <div>
                        <strong>3. Ajouter des activités</strong>
                        <p>Une activité précise le type d’apprentissage, la durée, le groupe, la présence enseignante, le rythme, la modalité, l’évaluation et les compétences numériques.</p>
                        <div class="help-code-wrap">
                            <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                            <pre class="help-code">learning add-activity design.json --type investigate --duration 30 --group subgroups --teacher present --pacing sync --mode onsite --evaluation formative --competencies A6,P34 --description "Comparer trois exemples d'usages de l'IA."</pre>
                        </div>
                    </div>
                    <div>
                        <strong>4. Ajouter des acquis Bloom</strong>
                        <p><code>outcome</code> ajoute un acquis d’apprentissage relié à la taxonomie de Bloom.</p>
                        <div class="help-code-wrap">
                            <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                            <pre class="help-code">learning outcome design.json --bloom analyser --verb "Comparer" --text "Comparer des réponses générées par IA selon leur fiabilité."</pre>
                        </div>
                    </div>
                    <div>
                        <strong>5. Valider et préparer le relais</strong>
                        <p><code>validate</code> vérifie le fichier. <code>prompt</code> produit un prompt de relais utile pour demander à Claude Code ou Codex de continuer le travail.</p>
                        <div class="help-code-wrap">
                            <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                            <pre class="help-code">learning validate design.json
learning prompt design.json</pre>
                        </div>
                    </div>
                </div>

                <h4>Publier</h4>
                <p>Pour publier depuis votre ordinateur, créez d’abord un jeton dans votre profil, section <strong>Publication depuis le CLI</strong>. Ensuite, connectez le CLI et publiez le fichier.</p>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">learning login
learning publish design.json</pre>
                </div>
                <p>Pour mettre à jour une publication existante, gardez l’identifiant renvoyé lors de la première publication.</p>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">learning publish design.json --design-id 123</pre>
                </div>
                <div class="help-callout warning">
                    <i class="fa-solid fa-key" aria-hidden="true"></i>
                    <p>Le jeton CLI est personnel. Il permet de publier sur votre compte : ne le transmettez à l’IA que si vous voulez explicitement qu’elle publie à votre place.</p>
                </div>

                <h4>Commandes utiles</h4>
                <div class="help-code-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="help-code">learning --help
learning list types
learning list bloom
learning list competencies
learning status
learning upgrade</pre>
                </div>
            </article>
            <article class="help-section" id="enrichir-design-ia">
                <p class="help-eyebrow"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Réflexion pédagogique</p>
                <h2>Interroger et enrichir son design avec l’IA</h2>
                <h3 id="analyser-design-ia">Analyser son design</h3>
                <p>Une IA peut vous aider à questionner votre séquence, repérer ses points forts et envisager des améliorations directement applicables en classe. Son analyse nourrit votre réflexion : vous restez maître des choix pédagogiques et de leur adaptation à vos élèves.</p>

                <div class="help-grid three">
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-file-export" aria-hidden="true"></i></span>1. Préparer le design</strong>
                        <span>Exportez votre design au format JSON depuis Learning Designer, ou préparez une description précise de votre séquence.</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-robot" aria-hidden="true"></i></span>2. Configurer l’IA</strong>
                        <span>Créez un Gem dans Gemini ou un projet dans ChatGPT ou Claude, puis copiez le prompt ci-dessous dans ses instructions.</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-comments" aria-hidden="true"></i></span>3. Engager le dialogue</strong>
                        <span>Joignez l’export ou collez votre description. Répondez aux questions réflexives, puis retenez et adaptez les pistes pertinentes.</span>
                    </div>
                </div>

                <h4>Prompt d’analyse du design</h4>
                <p>Copiez ce prompt dans les instructions de votre Gem ou de votre projet. Vous pourrez ensuite lui soumettre autant de designs que vous le souhaitez.</p>
                <div class="help-prompt-wrap">
                    <button class="help-copy-btn" type="button" aria-label="Copier le prompt d’analyse du design" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <textarea class="help-prompt" data-help-prompt="review" readonly><?= h($designReviewPrompt) ?></textarea>
                </div>

                <div class="help-callout">
                    <i class="fa-solid fa-lightbulb" aria-hidden="true"></i>
                    <p><strong>Pour aller plus loin :</strong> demandez à l’IA de prioriser trois améliorations réalistes pour votre prochaine séance, puis de vous aider à reformuler concrètement les activités concernées.</p>
                </div>

                <h3 id="creer-contenus-ia">Créer les contenus nécessaires au scénario</h3>
                <p>Le design décrit les activités à mener ; l’IA peut ensuite vous aider à fabriquer les ressources dont vous avez besoin pour les mettre en œuvre : consignes, fiches élèves, textes adaptés, études de cas, exercices, quiz, corrigés, grilles d’évaluation, supports de présentation ou variantes différenciées.</p>

                <div class="help-grid three">
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-crosshairs" aria-hidden="true"></i></span>1. Cibler une activité</strong>
                        <span>Partagez le scénario complet ou l’activité concernée afin que l’IA comprenne le public, les acquis visés, la durée et le contexte.</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-file-circle-plus" aria-hidden="true"></i></span>2. Définir le livrable</strong>
                        <span>Précisez le contenu attendu, son format, son niveau de détail et ses contraintes. L’IA peut aussi vous aider à choisir le support pertinent.</span>
                    </div>
                    <div class="help-card">
                        <strong><span class="help-card-icon"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i></span>3. Relire et adapter</strong>
                        <span>Vérifiez les informations, les sources, le niveau de difficulté et l’accessibilité, puis ajustez la proposition à votre classe.</span>
                    </div>
                </div>

                <div class="help-callout warning">
                    <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                    <p><strong>Avant d’utiliser un contenu en classe :</strong> relisez-le, contrôlez les faits et les sources, vérifiez les droits d’usage et ne transmettez aucune donnée personnelle ou sensible concernant vos élèves.</p>
                </div>
            </article>
        </div>
    </div>
</main>
<?php render_site_footer(); ?>
<script>
window.helpPromptTranslations = <?= json_encode([
    'en' => [
        'ai' => $aiPromptEn,
        'skill' => $skillPromptEn,
        'review' => $designReviewPromptEn,
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>
<script src="help-i18n.js?v=20260722-3"></script>
<script>
var initialHelpLanguage = 'fr';
try {
    initialHelpLanguage = localStorage.getItem('learningDesignerLang') || 'fr';
} catch (error) {
    initialHelpLanguage = 'fr';
}
if (window.HelpPageI18n) {
    window.HelpPageI18n.apply(initialHelpLanguage, window.helpPromptTranslations);
}

document.addEventListener('DOMContentLoaded', function () {
    var isEnglish = initialHelpLanguage === 'en';
    var sections = Array.from(document.querySelectorAll('.help-section[id]'));
    var toc = document.getElementById('help-toc');
    var sidebar = document.getElementById('help-sidebar');
    var toggle = document.getElementById('help-menu-toggle');
    var progressBar = document.getElementById('help-progress-bar');

    function closeMobileSidebar() {
        if (!window.matchMedia('(max-width: 1000px)').matches) return;
        sidebar.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
    }

    function navigateTo(target) {
        closeMobileSidebar();
        if (window.history && window.history.pushState) {
            window.history.pushState(null, '', '#' + target.id);
        }
        window.requestAnimationFrame(function () {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    function setSubmenuExpanded(group, expanded) {
        var button = group.querySelector('.help-toc-toggle');
        var submenu = group.querySelector('.help-toc-submenu');
        if (!button || !submenu) return;
        button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        submenu.hidden = !expanded;
    }

    sections.forEach(function (section, index) {
        var sectionNumber = String(index + 1).padStart(2, '0');
        var sectionHeading = section.querySelector(':scope > h2');
        var sectionTitle = sectionHeading ? sectionHeading.textContent.trim() : '';
        if (sectionHeading) {
            var headingIndex = document.createElement('span');
            headingIndex.className = 'help-heading-index';
            headingIndex.setAttribute('aria-hidden', 'true');
            headingIndex.textContent = sectionNumber + '.';
            sectionHeading.prepend(headingIndex);
        }

        var group = document.createElement('div');
        group.className = 'help-toc-group';
        group.dataset.sectionId = section.id;

        var link = document.createElement('a');
        link.className = 'help-toc-link';
        link.href = '#' + section.id;
        link.dataset.sectionId = section.id;
        link.innerHTML = '<span class="help-toc-index">' + sectionNumber + '</span><span>' + sectionTitle + '</span>';
        link.addEventListener('click', function (event) {
            event.preventDefault();
            navigateTo(section);
        });

        var subsections = Array.from(section.querySelectorAll(':scope > h3[id]'));
        if (subsections.length > 1) {
            var row = document.createElement('div');
            row.className = 'help-toc-row';
            row.appendChild(link);

            var submenuId = 'help-toc-submenu-' + section.id;
            var submenuToggle = document.createElement('button');
            submenuToggle.className = 'help-toc-toggle';
            submenuToggle.type = 'button';
            submenuToggle.setAttribute('aria-expanded', 'false');
            submenuToggle.setAttribute('aria-controls', submenuId);
            submenuToggle.setAttribute('aria-label', (isEnglish ? 'Show subsections for ' : 'Afficher les sous-sections de ') + sectionTitle);
            submenuToggle.innerHTML = '<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';
            submenuToggle.addEventListener('click', function () {
                setSubmenuExpanded(group, submenuToggle.getAttribute('aria-expanded') !== 'true');
            });
            row.appendChild(submenuToggle);
            group.appendChild(row);

            var submenu = document.createElement('div');
            submenu.className = 'help-toc-submenu';
            submenu.id = submenuId;
            submenu.hidden = true;
            subsections.forEach(function (subsection) {
                var sublink = document.createElement('a');
                sublink.className = 'help-toc-sublink';
                sublink.href = '#' + subsection.id;
                sublink.dataset.sectionId = section.id;
                sublink.dataset.subsectionId = subsection.id;
                sublink.textContent = subsection.textContent.trim();
                sublink.addEventListener('click', function (event) {
                    event.preventDefault();
                    navigateTo(subsection);
                });
                submenu.appendChild(sublink);
            });
            group.appendChild(submenu);
        } else {
            group.appendChild(link);
        }
        toc.appendChild(group);
    });

    var tocLinks = Array.from(toc.querySelectorAll('.help-toc-link'));
    var tocSublinks = Array.from(toc.querySelectorAll('.help-toc-sublink'));
    function setActiveSection(id, subsectionId) {
        tocLinks.forEach(function (link) {
            var active = link.dataset.sectionId === id;
            link.classList.toggle('is-active', active);
            if (active && !subsectionId) link.setAttribute('aria-current', 'location');
            else link.removeAttribute('aria-current');
        });
        tocSublinks.forEach(function (link) {
            var active = link.dataset.subsectionId === subsectionId;
            link.classList.toggle('is-active', active);
            if (active) link.setAttribute('aria-current', 'location');
            else link.removeAttribute('aria-current');
        });
        var index = sections.findIndex(function (section) { return section.id === id; });
        if (index >= 0) progressBar.style.width = (((index + 1) / sections.length) * 100) + '%';
    }

    var scrollUpdatePending = false;
    function updateActiveFromScroll() {
        var current = sections[0];
        sections.forEach(function (section) {
            if (section.getBoundingClientRect().top <= 145) current = section;
        });
        var currentSubsection = null;
        Array.from(current.querySelectorAll(':scope > h3[id]')).forEach(function (subsection) {
            if (subsection.getBoundingClientRect().top <= 145) currentSubsection = subsection;
        });
        setActiveSection(current.id, currentSubsection ? currentSubsection.id : '');
        scrollUpdatePending = false;
    }
    function requestScrollUpdate() {
        if (scrollUpdatePending) return;
        scrollUpdatePending = true;
        window.requestAnimationFrame(updateActiveFromScroll);
    }
    window.addEventListener('scroll', requestScrollUpdate, { passive: true });
    window.addEventListener('resize', requestScrollUpdate);

    function getHashTarget() {
        var targetId = window.location.hash.slice(1);
        if (!targetId) return null;
        try {
            targetId = decodeURIComponent(targetId);
        } catch (error) {
            return null;
        }
        if (targetId === 'bonnes-pratiques') {
            targetId = 'enrichir-design-ia';
            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, '', '#enrichir-design-ia');
            }
        }
        return document.getElementById(targetId);
    }

    function expandSubmenuForHash() {
        var target = getHashTarget();
        if (!target || target.tagName !== 'H3') return;
        var section = target.closest('.help-section');
        var group = section ? toc.querySelector('.help-toc-group[data-section-id="' + section.id + '"]') : null;
        if (group) setSubmenuExpanded(group, true);
    }

    function alignAndActivateHashTarget() {
        var target = getHashTarget();
        if (!target) return;
        target.scrollIntoView({ behavior: 'instant', block: 'start' });

        var section = target.classList.contains('help-section') ? target : target.closest('.help-section');
        if (!section) return;
        setActiveSection(section.id, target.tagName === 'H3' ? target.id : '');
    }

    function syncHashNavigation() {
        expandSubmenuForHash();
        window.requestAnimationFrame(alignAndActivateHashTarget);
    }

    window.addEventListener('popstate', syncHashNavigation);
    window.addEventListener('hashchange', syncHashNavigation);
    window.addEventListener('load', syncHashNavigation);
    expandSubmenuForHash();
    updateActiveFromScroll();

    toggle.addEventListener('click', function () {
        var open = sidebar.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    async function copyText(text, button) {
        try {
            await navigator.clipboard.writeText(text);
        } catch (error) {
            var temporary = document.createElement('textarea');
            temporary.value = text;
            temporary.setAttribute('readonly', '');
            temporary.style.position = 'fixed';
            temporary.style.top = '-1000px';
            document.body.appendChild(temporary);
            temporary.select();
            document.execCommand('copy');
            temporary.remove();
        }
        var original = button.innerHTML;
        button.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i>';
        button.setAttribute('title', isEnglish ? 'Copied' : 'Copié');
        window.setTimeout(function () {
            button.innerHTML = original;
            button.setAttribute('title', isEnglish ? 'Copy' : 'Copier');
        }, 1300);
    }

    document.querySelectorAll('.help-copy-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var container = button.parentElement;
            var source = container.querySelector('.help-code, .help-prompt');
            if (!source) return;
            copyText(('value' in source ? source.value : source.textContent).trim(), button);
        });
    });

    var helpLangSelect = document.getElementById('lang-select');
    if (helpLangSelect) {
        helpLangSelect.addEventListener('change', function () {
            window.setTimeout(function () { window.location.reload(); }, 0);
        });
    }

});
</script>
</body>
</html>
