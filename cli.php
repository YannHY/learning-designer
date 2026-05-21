<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

function cli_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function cli_i18n_attrs(string $fr, string $en, bool $html = false): string
{
    $attrs = ' data-cli-i18n-fr="' . cli_h($fr) . '" data-cli-i18n-en="' . cli_h($en) . '"';
    if ($html) {
        $attrs .= ' data-cli-i18n-html="1"';
    }
    return $attrs;
}

function cli_i18n_attr_attrs(string $attr, string $fr, string $en): string
{
    return ' data-cli-i18n-attr="' . cli_h($attr) . '" data-cli-i18n-fr="' . cli_h($fr) . '" data-cli-i18n-en="' . cli_h($en) . '"';
}

$prompt = <<<'PROMPT'
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

$promptEn = <<<'PROMPT'
Create a Learning Designer teaching design by using the `learning` CLI.

Important:
You may be running in an isolated sandbox. If `learning` is not available, install a local copy of the CLI in your environment:

mkdir -p .tools/bin
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/bin/learning -o .tools/bin/learning
chmod +x .tools/bin/learning
./.tools/bin/learning --help

If raw.githubusercontent.com is blocked, use web_fetch or another available method to retrieve:
https://github.com/YannHY/learning-designer/blob/main/bin/learning

Then write the file to `.tools/bin/learning`, make it executable, and always use:

./.tools/bin/learning

Once `.tools/bin/learning` exists, do not depend on the network anymore.

Mission:
Create a complete, structured, detailed `design.json` file that can be imported into Learning Designer.

Use the CLI as much as possible. Do not write the JSON manually unless the CLI is impossible to use after several documented attempts.

Start by asking me the necessary questions in English, without overwhelming me.

Essential questions:
- topic or theme of the lesson/sequence;
- level and target audience;
- total duration;
- mode: onsite, remote, or hybrid;
- group size;
- teaching objectives: what I want students to work on, learn, or practice;
- expected learning outcomes: what students should be able to do at the end;
- material, pedagogical, or institutional constraints;
- desired level of detail.

Ask complementary questions only if useful:
- desired Bloom level for each outcome, if I know it;
- digital competencies to include, if relevant;
- required materials, works, resources, or tools.

Clearly distinguish:
- teaching objectives, which describe my pedagogical intention;
- learning outcomes, which describe what students will be able to do at the end.

If I only provide teaching objectives, turn them into observable learning outcomes using action verbs and Bloom's taxonomy.

If some information is missing, make reasonable assumptions instead of blocking, unless the assumption would be risky.

Special case for duration:
- if the duration is given in days, ask for or explicitly propose a duration per session before generating the design;
- by default, for lower secondary school, interpret 1 day as 1 session of 55 minutes unless stated otherwise;
- clearly state the assumption you used.

Before running the full creation commands, briefly restate:
- the topic;
- the audience;
- the total duration converted to minutes;
- the planned number of moments;
- the teaching objectives;
- the proposed Bloom outcomes;
- the main digital competencies, if used.

Then use the CLI rather than writing JSON manually.

Before creating all activities, check the useful commands:
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

For `--pacing` and `--mode`, check with the CLI or use values produced by working examples. For onsite synchronous learning, `--pacing synchronous` and `--mode presentiel` are acceptable if the CLI validates them.

Never put long sentences in controlled fields such as `--group`, `--teacher`, `--evaluation`, `--type`, or `--pacing`.

Put instructions, criteria, resources, teacher role, differentiation details, and pedagogical detail in:
- `--description`
- `--notes`
- `--objectives`
- `--intentions`

Commands to use whenever possible:
- ./.tools/bin/learning init
- ./.tools/bin/learning add-moment
- ./.tools/bin/learning add-activity
- ./.tools/bin/learning outcome
- ./.tools/bin/learning validate design.json
- ./.tools/bin/learning prompt design.json

Recommended procedure:
1. Create `design.json` with `init`.
2. Add Bloom outcomes with `outcome`.
3. Add a first moment and a first complete activity to test CLI values.
4. If the command works, add the remaining moments and activities.
5. If a command fails, explain why, fix the invalid value, and try again.
6. Always validate with `validate`.
7. Run `prompt design.json`.

The design should include:
- clearly titled moments;
- explicit pedagogical intentions;
- varied activities;
- realistic durations;
- suitable group modalities;
- diagnostic, formative, or summative assessment when appropriate;
- Bloom outcomes linked to activities;
- digital competencies when relevant;
- descriptions detailed enough for a teacher to use.

If I ask you to include digital technology, suggest pedagogically useful uses such as:
- guided documentary research;
- source checking or selection;
- collaborative mapping;
- digital writing;
- saving and organizing files;
- reviewing, correcting, and improving text;
- controlled production or sharing.

Use digital competency identifiers accepted by the CLI, for example:
- A1, A2
- P1, P6
- C14, C15

At the end, give me:
- the path to the `design.json` file;
- the CLI validation result;
- the number of moments;
- the number of activities;
- the teaching objectives used;
- the Bloom outcomes created;
- the digital competencies used;
- the duration distribution;
- the assumptions made;
- the content or file `design.json`.

Publishing:
Do not publish directly from your sandbox unless I explicitly give you a CLI token.
To publish from my Mac, simply tell me, if the file is on the Desktop:

learning publish ~/Desktop/design.json

Or, if the file remains in the current folder:

learning publish design.json

Important rules:
- Work progressively.
- Ask the necessary questions first.
- Do not write JSON manually unless the CLI is impossible to use after several attempts.
- Check accepted values before generating many activities.
- Test a first activity before producing the whole sequence.
- If a command fails, explain why, fix it, and try again.
- Once `.tools/bin/learning` exists, do not depend on the network.
- Never publish without explicit authorization.
PROMPT;

$skillPrompt = <<<'PROMPT'
Lis et applique cette skill :
https://github.com/YannHY/learning-designer/blob/main/skills/learning-designer/SKILL.md

Ta mission : m’aider à créer un fichier design.json Learning Designer avec le CLI learning, le valider, puis me donner les commandes exactes pour le publier.
PROMPT;

$skillPromptEn = <<<'PROMPT'
Read and apply this skill:
https://github.com/YannHY/learning-designer/blob/main/skills/learning-designer/SKILL.md

Your mission: help me create a Learning Designer design.json file with the learning CLI, validate it, then give me the exact commands to publish it.
PROMPT;
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLI | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260520-2">
    <link rel="stylesheet" href="account-ui.css?v=20260520-4">
    <link rel="stylesheet" href="account-pages.css?v=20260521-width">
    <style>
        body.cli-page {
            background: #fff;
        }
        .cli-shell {
            width: min(var(--content-shell-width, 1180px), calc(100vw - var(--content-shell-gutter, 36px)));
            margin: 0 auto;
            padding: 28px 0 56px;
        }
        .cli-hero {
            display: grid;
            gap: 14px;
            margin-bottom: 26px;
        }
        .cli-title {
            display: flex;
            align-items: center;
            gap: 18px;
            margin: 0;
            color: var(--text);
            font-size: clamp(32px, 5vw, 58px);
            line-height: 1.02;
            letter-spacing: 0;
        }
        .cli-title i {
            flex: 0 0 auto;
            font-size: 0.5em;
            line-height: 1;
        }
        .cli-subtitle {
            max-width: 1040px;
            margin: 0;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.65;
        }
        .cli-section {
            margin-top: 24px;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            box-shadow: 0 12px 28px rgba(0,0,0,0.06);
        }
        .cli-section h2,
        .cli-section h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 14px;
            color: var(--text);
            letter-spacing: 0;
        }
        .cli-section h2 {
            font-size: 24px;
        }
        .cli-section h3 {
            font-size: 18px;
        }
        .cli-section h3:not(:first-child) {
            margin-top: 22px;
        }
        .cli-copy {
            color: var(--muted);
            line-height: 1.65;
        }
        .cli-steps {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-top: 18px;
        }
        .cli-step {
            min-height: 150px;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel-2);
        }
        .cli-step i {
            display: inline-grid;
            place-items: center;
            width: 34px;
            height: 34px;
            margin-bottom: 12px;
            border-radius: 8px;
            background: rgba(56, 139, 253, 0.12);
            color: var(--primary);
        }
        .cli-step strong {
            display: block;
            margin-bottom: 6px;
            color: var(--text);
            font-size: 15px;
        }
        .cli-step span {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.45;
        }
        .cli-code {
            overflow-x: auto;
            margin: 14px 0 18px;
            padding: 16px;
            border-radius: 8px;
            background: #0b1020;
            color: #e5edf8;
            font: 13px/1.55 ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            white-space: pre;
        }
        .cli-copy-wrap {
            position: relative;
        }
        .cli-copy-wrap .cli-code {
            padding-right: 54px;
        }
        .cli-copy-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            display: inline-grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 8px;
            background: rgba(255,255,255,0.08);
            color: #e5edf8;
            cursor: pointer;
        }
        .cli-copy-btn:hover,
        .cli-copy-btn:focus-visible {
            background: rgba(255,255,255,0.16);
            outline: none;
        }
        .cli-note {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin: 16px 0;
            padding: 14px;
            border-radius: 8px;
            background: #eef6ff;
            color: #17324d;
            line-height: 1.55;
        }
        .cli-note i {
            color: var(--primary);
            margin-top: 3px;
        }
        .cli-details-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }
        .cli-prompt {
            min-height: 440px;
            width: 100%;
            box-sizing: border-box;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #0b1020;
            color: #e5edf8;
            font: 13px/1.55 ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            resize: vertical;
        }
        .cli-prompt-compact {
            height: 150px;
            min-height: 150px;
        }
        .cli-prompt-wrap {
            position: relative;
            margin-top: 12px;
        }
        .cli-prompt-wrap .cli-copy-btn {
            top: 10px;
            right: 10px;
            z-index: 1;
        }
        .cli-prompt-wrap .cli-prompt {
            padding-right: 54px;
        }
        .cli-anchor-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 18px 0 0;
        }
        .cli-anchor-list a,
        .cli-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 38px;
            padding: 0 14px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            color: var(--text);
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }
        .cli-button {
            cursor: pointer;
        }
        .cli-anchor-list a:hover,
        .cli-button:hover {
            border-color: rgba(56, 139, 253, 0.35);
            color: var(--primary);
        }
        [data-theme="dark"] body.cli-page {
            background:
                radial-gradient(circle at top left, rgba(56, 139, 253, 0.10), transparent 28%),
                linear-gradient(180deg, #1f2537 0%, #1a1f2e 100%);
        }
        [data-theme="dark"] .cli-title,
        [data-theme="dark"] .cli-title span,
        [data-theme="dark"] .cli-section h2,
        [data-theme="dark"] .cli-section h3,
        [data-theme="dark"] .cli-step strong,
        [data-theme="dark"] .cli-anchor-list a,
        [data-theme="dark"] .cli-button {
            color: #f3f6ff;
        }
        [data-theme="dark"] .cli-section {
            background: linear-gradient(180deg, rgba(36, 43, 64, 0.96), rgba(30, 36, 54, 0.96));
            border-color: rgba(103, 116, 145, 0.45);
        }
        [data-theme="dark"] .cli-step,
        [data-theme="dark"] .cli-anchor-list a,
        [data-theme="dark"] .cli-button {
            background: rgba(26, 31, 46, 0.78);
            border-color: rgba(103, 116, 145, 0.38);
        }
        [data-theme="dark"] .cli-subtitle,
        [data-theme="dark"] .cli-copy,
        [data-theme="dark"] .cli-step span {
            color: var(--text-body);
        }
        [data-theme="dark"] .cli-note {
            background: rgba(140, 198, 255, 0.12);
            color: var(--text-body);
        }
        @media (max-width: 900px) {
            .cli-steps,
            .cli-details-grid {
                grid-template-columns: 1fr;
            }
            .cli-shell {
                padding-top: 24px;
            }
        }
    </style>
</head>
<body class="cli-page">
<?php render_site_nav('cli'); ?>
<main class="cli-shell">
    <header class="cli-hero">
        <h1 class="cli-title"><i class="fa-solid fa-code" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Créer avec l’IA', 'Create with AI') ?>>Créer avec l’IA</span></h1>
        <p class="cli-subtitle"<?= cli_i18n_attrs('Installez la commande, demandez à Claude ou Codex de préparer le fichier, puis publiez le design en ligne avec une seule ligne.', 'Install the command, ask Claude or Codex to prepare the file, then publish the design online with one line.') ?>>Installez la commande, demandez à Claude ou Codex de préparer le fichier, puis publiez le design en ligne avec une seule ligne.</p>
        <nav class="cli-anchor-list" aria-label="Sections de la page"<?= cli_i18n_attr_attrs('aria-label', 'Sections de la page', 'Page sections') ?>>
            <a href="#express"><i class="fa-solid fa-bolt" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Version courte', 'Short version') ?>>Version courte</span></a>
            <a href="#detail"><i class="fa-solid fa-list-check" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Guide détaillé', 'Detailed guide') ?>>Guide détaillé</span></a>
            <a href="#skill"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Skill Claude', 'Claude skill') ?>>Skill Claude</span></a>
            <a href="#prompt"><i class="fa-solid fa-message" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Prompt IA', 'AI prompt') ?>>Prompt IA</span></a>
        </nav>
    </header>

    <section id="express" class="cli-section">
        <h2><i class="fa-solid fa-bolt" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Version courte', 'Short version') ?>>Version courte</span></h2>
        <p class="cli-copy"<?= cli_i18n_attrs('Pour un usage normal, il suffit de suivre ces quatre étapes.', 'For normal use, these four steps are enough.') ?>>Pour un usage normal, il suffit de suivre ces quatre étapes.</p>
        <div class="cli-steps">
            <div class="cli-step">
                <i class="fa-solid fa-download" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('1. Installer', '1. Install') ?>>1. Installer</strong>
                <span<?= cli_i18n_attrs('À faire une seule fois sur votre ordinateur.', 'Do this once on your computer.') ?>>À faire une seule fois sur votre ordinateur.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-key" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('2. Connecter', '2. Connect') ?>>2. Connecter</strong>
                <span<?= cli_i18n_attrs('Créer un jeton dans le profil, puis le coller dans le terminal.', 'Create a token in your profile, then paste it into the terminal.') ?>>Créer un jeton dans le profil, puis le coller dans le terminal.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-robot" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('3. Créer', '3. Create') ?>>3. Créer</strong>
                <span<?= cli_i18n_attrs('Dans Claude ou Codex, coller le prompt fourni plus bas pour obtenir un fichier <code>design.json</code>.', 'In Claude or Codex, paste the prompt below to obtain a <code>design.json</code> file.', true) ?>>Dans Claude ou Codex, coller le prompt fourni plus bas pour obtenir un fichier <code>design.json</code>.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('4. Publier', '4. Publish') ?>>4. Publier</strong>
                <span<?= cli_i18n_attrs('Une commande publie le design et renvoie le lien public.', 'One command publishes the design and returns the public link.') ?>>Une commande publie le design et renvoie le lien public.</span>
            </div>
        </div>
        <div class="cli-copy-wrap">
            <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-code">curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/install.sh | sh
learning login
learning publish ~/Desktop/design.json</pre>
        </div>
        <div class="cli-note">
            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
            <div<?= cli_i18n_attrs('Le jeton CLI est personnel. Il ne faut pas le donner à une IA sauf si vous voulez explicitement qu’elle publie à votre place.', 'Your CLI token is personal. Do not give it to an AI unless you explicitly want it to publish on your behalf.') ?>>Le jeton CLI est personnel. Il ne faut pas le donner à une IA sauf si vous voulez explicitement qu’elle publie à votre place.</div>
        </div>
    </section>

    <section id="detail" class="cli-section">
        <h2><i class="fa-solid fa-list-check" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Guide détaillé', 'Detailed guide') ?>>Guide détaillé</span></h2>
        <div class="cli-details-grid">
            <div>
                <h3><i class="fa-solid fa-download" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Installer ou mettre à jour', 'Install or update') ?>>Installer ou mettre à jour</span></h3>
                <p class="cli-copy"<?= cli_i18n_attrs('La commande suivante installe <code>learning</code>. Si elle est déjà installée, utilisez ensuite <code>learning upgrade</code> pour la mettre à jour.', 'The following command installs <code>learning</code>. If it is already installed, then use <code>learning upgrade</code> to update it.', true) ?>>La commande suivante installe <code>learning</code>. Si elle est déjà installée, utilisez ensuite <code>learning upgrade</code> pour la mettre à jour.</p>
                <div class="cli-copy-wrap">
                    <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-code">curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/install.sh | sh
learning upgrade
learning status</pre>
                </div>
            </div>
            <div>
                <h3><i class="fa-solid fa-key" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Créer le jeton', 'Create the token') ?>>Créer le jeton</span></h3>
                <p class="cli-copy"<?= cli_i18n_attrs('Dans votre profil, créez un jeton dans la section <strong>Publication depuis le CLI</strong>. Copiez-le tout de suite : il ne sera affiché qu’une seule fois.', 'In your profile, create a token in the <strong>CLI publishing</strong> section. Copy it immediately: it will only be shown once.', true) ?>>Dans votre profil, créez un jeton dans la section <strong>Publication depuis le CLI</strong>. Copiez-le tout de suite : il ne sera affiché qu’une seule fois.</p>
                <div class="cli-copy-wrap">
                    <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-code">learning login</pre>
                </div>
            </div>
            <div>
                <h3><i class="fa-solid fa-file-code" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Vérifier le fichier', 'Check the file') ?>>Vérifier le fichier</span></h3>
                <p class="cli-copy"<?= cli_i18n_attrs('Quand Claude ou Codex vous donne <code>design.json</code>, vérifiez-le avant la publication.', 'When Claude or Codex gives you <code>design.json</code>, check it before publishing.', true) ?>>Quand Claude ou Codex vous donne <code>design.json</code>, vérifiez-le avant la publication.</p>
                <div class="cli-copy-wrap">
                    <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-code">learning validate ~/Desktop/design.json</pre>
                </div>
            </div>
            <div>
                <h3><i class="fa-solid fa-globe" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Publier', 'Publish') ?>>Publier</span></h3>
                <p class="cli-copy"<?= cli_i18n_attrs('La publication renvoie une URL publique. Gardez aussi le <strong>Design ID</strong> si vous voulez mettre à jour la même publication plus tard.', 'Publishing returns a public URL. Also keep the <strong>Design ID</strong> if you want to update the same publication later.', true) ?>>La publication renvoie une URL publique. Gardez aussi le <strong>Design ID</strong> si vous voulez mettre à jour la même publication plus tard.</p>
                <div class="cli-copy-wrap">
                    <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-code">learning publish ~/Desktop/design.json
learning publish ~/Desktop/design.json --design-id 123</pre>
                </div>
            </div>
        </div>
    </section>

    <section id="skill" class="cli-section">
        <h2><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Skill Claude', 'Claude skill') ?>>Skill Claude</span></h2>
        <p class="cli-copy"<?= cli_i18n_attrs('Dans Claude Code, vous pouvez installer cette méthode comme une skill locale. Claude pourra ensuite la charger automatiquement quand elle est pertinente, ou vous pourrez la lancer manuellement avec une commande slash.', 'In Claude Code, you can install this method as a local skill. Claude can then load it automatically when relevant, or you can launch it manually with a slash command.') ?>>Dans Claude Code, vous pouvez installer cette méthode comme une skill locale. Claude pourra ensuite la charger automatiquement quand elle est pertinente, ou vous pourrez la lancer manuellement avec une commande slash.</p>
        <h3><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Méthode 1 : créer la skill avec le prompt', 'Method 1: create the skill with the prompt') ?>>Méthode 1 : créer la skill avec le prompt</span></h3>
        <div class="cli-steps">
            <div class="cli-step">
                <i class="fa-solid fa-folder-plus" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('1. Créer le dossier', '1. Create the folder') ?>>1. Créer le dossier</strong>
                <span<?= cli_i18n_attrs('Dans votre projet, créez <code>.claude/skills/learning-design</code>. Le dossier <code>skills</code> est important pour Claude Code.', 'In your project, create <code>.claude/skills/learning-design</code>. The <code>skills</code> folder matters for Claude Code.', true) ?>>Dans votre projet, créez <code>.claude/skills/learning-design</code>. Le dossier <code>skills</code> est important pour Claude Code.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('2. Créer SKILL.md', '2. Create SKILL.md') ?>>2. Créer SKILL.md</strong>
                <span<?= cli_i18n_attrs('Créez le fichier <code>SKILL.md</code>, au singulier, ajoutez le frontmatter, puis collez dessous le contenu de la section <strong>Prompt à donner à Claude ou Codex</strong>.', 'Create the <code>SKILL.md</code> file, singular, add the frontmatter, then paste the content from the <strong>Prompt to give Claude or Codex</strong> section below it.', true) ?>>Créez le fichier <code>SKILL.md</code>, au singulier, ajoutez le frontmatter, puis collez dessous le contenu de la section <strong>Prompt à donner à Claude ou Codex</strong>.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-terminal" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('3. Lancer la skill', '3. Run the skill') ?>>3. Lancer la skill</strong>
                <span<?= cli_i18n_attrs('Dans Claude Code, tapez <code>/learning-design</code>, puis décrivez la séance ou la séquence à créer.', 'In Claude Code, type <code>/learning-design</code>, then describe the lesson or sequence you want to create.', true) ?>>Dans Claude Code, tapez <code>/learning-design</code>, puis décrivez la séance ou la séquence à créer.</span>
            </div>
        </div>
        <p class="cli-copy"<?= cli_i18n_attrs('Exemple de création depuis la racine de votre projet :', 'Example creation from your project root:') ?>>Exemple de création depuis la racine de votre projet :</p>
        <div class="cli-copy-wrap">
            <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-code">mkdir -p .claude/skills/learning-design
code .claude/skills/learning-design/SKILL.md</pre>
        </div>
        <p class="cli-copy"<?= cli_i18n_attrs('Dans <code>SKILL.md</code>, commencez par ces lignes, puis ajoutez le prompt complet juste après :', 'In <code>SKILL.md</code>, start with these lines, then add the full prompt right after:', true) ?>>Dans <code>SKILL.md</code>, commencez par ces lignes, puis ajoutez le prompt complet juste après :</p>
        <div class="cli-copy-wrap">
            <button class="cli-copy-btn" type="button" aria-label="Copier le modèle" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier le modèle', 'Copy template') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-code">---
description: Crée un fichier design.json Learning Designer avec le CLI learning, pose les questions pédagogiques utiles, valide le fichier et prépare les commandes de publication.
---

# Learning Designer

Collez ici le prompt complet de la section "Prompt à donner à Claude ou Codex".</pre>
        </div>
        <h3><i class="fa-solid fa-download" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Méthode 2 : installer la skill publiée', 'Method 2: install the published skill') ?>>Méthode 2 : installer la skill publiée</span></h3>
        <p class="cli-copy"<?= cli_i18n_attrs('Si vous voulez éviter le copier-coller, vous pouvez créer la skill locale directement depuis la version publiée sur GitHub.', 'If you want to avoid copy-paste, you can create the local skill directly from the version published on GitHub.') ?>>Si vous voulez éviter le copier-coller, vous pouvez créer la skill locale directement depuis la version publiée sur GitHub.</p>
        <div class="cli-copy-wrap">
            <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-code">mkdir -p .claude/skills/learning-design
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/skills/learning-designer/SKILL.md -o .claude/skills/learning-design/SKILL.md</pre>
        </div>
        <p class="cli-copy"<?= cli_i18n_attrs('Relancez Claude Code si la commande slash n’apparaît pas tout de suite, puis lancez la skill avec :', 'Restart Claude Code if the slash command does not appear immediately, then launch the skill with:') ?>>Relancez Claude Code si la commande slash n’apparaît pas tout de suite, puis lancez la skill avec :</p>
        <div class="cli-copy-wrap">
            <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-code">/learning-design</pre>
        </div>
        <div class="cli-note">
            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
            <div<?= cli_i18n_attrs('Si vous aviez prévu <code>.claude/learning-design/SKILLS.md</code>, adaptez plutôt vers <code>.claude/skills/learning-design/SKILL.md</code> : c’est le format reconnu par Claude Code pour créer aussi la commande slash <code>/learning-design</code>.', 'If you planned to use <code>.claude/learning-design/SKILLS.md</code>, use <code>.claude/skills/learning-design/SKILL.md</code> instead: this is the format recognized by Claude Code and it also creates the <code>/learning-design</code> slash command.', true) ?>>Si vous aviez prévu <code>.claude/learning-design/SKILLS.md</code>, adaptez plutôt vers <code>.claude/skills/learning-design/SKILL.md</code> : c’est le format reconnu par Claude Code pour créer aussi la commande slash <code>/learning-design</code>.</div>
        </div>
        <p class="cli-copy"<?= cli_i18n_attrs('Pour Claude Cowork ou pour un usage ponctuel sans installation locale, copiez simplement ce prompt. Claude ira lire la skill publiée et suivra la méthode complète.', 'For Claude Cowork, or for one-off use without local installation, simply copy this prompt. Claude will read the published skill and follow the full method.') ?>>Pour Claude Cowork ou pour un usage ponctuel sans installation locale, copiez simplement ce prompt. Claude ira lire la skill publiée et suivra la méthode complète.</p>
        <div class="cli-prompt-wrap">
            <button class="cli-copy-btn" type="button" id="copy-skill-prompt-btn" aria-label="Copier le prompt de skill" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier le prompt de skill', 'Copy skill prompt') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <textarea class="cli-prompt cli-prompt-compact" id="skill-prompt" readonly><?= cli_h($skillPrompt) ?></textarea>
        </div>
    </section>

    <section id="prompt" class="cli-section">
        <h2><i class="fa-solid fa-message" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Prompt à donner à Claude ou Codex', 'Prompt to give Claude or Codex') ?>>Prompt à donner à Claude ou Codex</span></h2>
        <p class="cli-copy"<?= cli_i18n_attrs('Copiez ce prompt dans Claude ou Codex. Il demande à l’IA d’utiliser le CLI, de poser les bonnes questions pédagogiques, puis de produire un fichier validé.', 'Copy this prompt into Claude or Codex. It asks the AI to use the CLI, ask the right pedagogical questions, then produce a validated file.') ?>>Copiez ce prompt dans Claude ou Codex. Il demande à l’IA d’utiliser le CLI, de poser les bonnes questions pédagogiques, puis de produire un fichier validé.</p>
        <div class="cli-prompt-wrap">
            <button class="cli-copy-btn" type="button" id="copy-prompt-btn" aria-label="Copier le prompt" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier le prompt', 'Copy prompt') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <textarea class="cli-prompt" id="ai-prompt" readonly><?= cli_h($prompt) ?></textarea>
        </div>
    </section>

    <section id="after-ai" class="cli-section">
        <h2><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> <span<?= cli_i18n_attrs('Après Claude ou Codex', 'After Claude or Codex') ?>>Après Claude ou Codex</span></h2>
        <p class="cli-copy"<?= cli_i18n_attrs('Quand l’IA a terminé, elle doit fournir un fichier <code>design.json</code>. Téléchargez ce fichier ou copiez-le sur votre ordinateur, par exemple sur le Bureau. Ensuite, ouvrez le Terminal et lancez les commandes suivantes.', 'When the AI has finished, it should provide a <code>design.json</code> file. Download it or copy it to your computer, for example to the Desktop. Then open Terminal and run the following commands.', true) ?>>Quand l’IA a terminé, elle doit fournir un fichier <code>design.json</code>. Téléchargez ce fichier ou copiez-le sur votre ordinateur, par exemple sur le Bureau. Ensuite, ouvrez le Terminal et lancez les commandes suivantes.</p>
        <div class="cli-steps">
            <div class="cli-step">
                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('1. Trouver le fichier', '1. Find the file') ?>>1. Trouver le fichier</strong>
                <span<?= cli_i18n_attrs('Placez <code>design.json</code> dans un endroit simple, par exemple le Bureau.', 'Put <code>design.json</code> somewhere simple, for example on the Desktop.', true) ?>>Placez <code>design.json</code> dans un endroit simple, par exemple le Bureau.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-terminal" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('2. Ouvrir le Terminal', '2. Open Terminal') ?>>2. Ouvrir le Terminal</strong>
                <span<?= cli_i18n_attrs('Les commandes se tapent dans le Terminal de votre ordinateur.', 'The commands are typed in your computer Terminal.') ?>>Les commandes se tapent dans le Terminal de votre ordinateur.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-check" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('3. Vérifier', '3. Validate') ?>>3. Vérifier</strong>
                <span<?= cli_i18n_attrs('La validation doit répondre <code>OK</code>.', 'Validation should return <code>OK</code>.', true) ?>>La validation doit répondre <code>OK</code>.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-globe" aria-hidden="true"></i>
                <strong<?= cli_i18n_attrs('4. Publier', '4. Publish') ?>>4. Publier</strong>
                <span<?= cli_i18n_attrs('La publication renvoie un lien public à partager.', 'Publishing returns a public link to share.') ?>>La publication renvoie un lien public à partager.</span>
            </div>
        </div>
        <div class="cli-copy-wrap">
            <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-code">learning validate ~/Desktop/design.json
learning publish ~/Desktop/design.json</pre>
        </div>
        <div class="cli-note">
            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
            <div<?= cli_i18n_attrs('Si le fichier n’est pas sur le Bureau, remplacez <code>~/Desktop/design.json</code> par son chemin exact.', 'If the file is not on the Desktop, replace <code>~/Desktop/design.json</code> with its exact path.', true) ?>>Si le fichier n’est pas sur le Bureau, remplacez <code>~/Desktop/design.json</code> par son chemin exact.</div>
        </div>
    </section>
</main>
<?php render_site_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var promptTexts = {
        fr: <?= json_encode($prompt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
        en: <?= json_encode($promptEn, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
    };
    var skillPromptTexts = {
        fr: <?= json_encode($skillPrompt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
        en: <?= json_encode($skillPromptEn, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
    };

    function applyCliLanguage(lang) {
        lang = lang === 'en' ? 'en' : 'fr';
        document.documentElement.lang = lang;
        document.title = 'CLI | Learning Designer';
        document.querySelectorAll('[data-cli-i18n-en]').forEach(function (el) {
            var value = lang === 'en' ? el.dataset.cliI18nEn : el.dataset.cliI18nFr;
            if (!value) return;
            var attrList = (el.dataset.cliI18nAttr || '').split(',').map(function (attr) {
                return attr.trim();
            }).filter(Boolean);
            if (attrList.length) {
                attrList.forEach(function (attr) {
                    el.setAttribute(attr, value);
                });
            } else if (el.dataset.cliI18nHtml === '1') {
                el.innerHTML = value;
            } else {
                el.textContent = value;
            }
        });

        var aiPrompt = document.getElementById('ai-prompt');
        if (aiPrompt) aiPrompt.value = promptTexts[lang];
        var skillPrompt = document.getElementById('skill-prompt');
        if (skillPrompt) skillPrompt.value = skillPromptTexts[lang];
    }

    var cliLang = 'fr';
    try {
        cliLang = localStorage.getItem('learningDesignerLang') || 'fr';
    } catch (error) {
        cliLang = 'fr';
    }
    applyCliLanguage(cliLang);

    var langSelect = document.getElementById('lang-select');
    if (langSelect) {
        langSelect.addEventListener('change', function () {
            applyCliLanguage(langSelect.value);
        });
    }

    async function copyText(text, button) {
        try {
            await navigator.clipboard.writeText(text);
        } catch (error) {
            var temp = document.createElement('textarea');
            temp.value = text;
            temp.setAttribute('readonly', '');
            temp.style.position = 'fixed';
            temp.style.top = '-1000px';
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            temp.remove();
        }
        var original = button.innerHTML;
        button.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i>';
        window.setTimeout(function () {
            button.innerHTML = original;
        }, 1300);
    }

    document.querySelectorAll('.cli-copy-wrap .cli-copy-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var code = button.parentElement.querySelector('.cli-code');
            if (code) copyText(code.textContent.trim(), button);
        });
    });

    var promptButton = document.getElementById('copy-prompt-btn');
    var textarea = document.getElementById('ai-prompt');
    if (promptButton && textarea) {
        promptButton.addEventListener('click', function () {
            copyText(textarea.value, promptButton);
        });
    }

    var skillPromptButton = document.getElementById('copy-skill-prompt-btn');
    var skillTextarea = document.getElementById('skill-prompt');
    if (skillPromptButton && skillTextarea) {
        skillPromptButton.addEventListener('click', function () {
            copyText(skillTextarea.value, skillPromptButton);
        });
    }
});
</script>
</body>
</html>
