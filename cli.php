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
            margin: 0;
            color: var(--text);
            font-size: clamp(32px, 5vw, 58px);
            line-height: 1.02;
            letter-spacing: 0;
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
            box-shadow: 0 8px 18px rgba(0,0,0,0.04);
        }
        .cli-section h2,
        .cli-section h3 {
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
            min-height: 112px;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel-2);
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
            background: #f6f8fa;
            color: var(--text);
            line-height: 1.55;
        }
        .cli-note i {
            color: var(--primary);
            margin-top: 3px;
        }
        .cli-details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 22px;
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
            background: #1a1f2e;
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
            background: rgba(30, 36, 54, 0.96);
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
            background: rgba(255, 255, 255, 0.06);
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
        <h1 class="cli-title"><span<?= cli_i18n_attrs('Créer avec l’IA', 'Create with AI') ?>>Créer avec l’IA</span></h1>
        <p class="cli-subtitle"<?= cli_i18n_attrs('Un CLI pour publier vos designs.', 'A CLI to publish your designs.') ?>>Un CLI pour publier vos designs.</p>
        <nav class="cli-anchor-list" aria-label="Ressources"<?= cli_i18n_attr_attrs('aria-label', 'Ressources', 'Resources') ?>>
            <a href="#detail"><span<?= cli_i18n_attrs('Guide', 'Guide') ?>>Guide</span></a>
            <a href="#prompt"><span<?= cli_i18n_attrs('Prompt IA', 'AI prompt') ?>>Prompt IA</span></a>
            <a href="skill.php"><span<?= cli_i18n_attrs('Créer une skill', 'Create a skill') ?>>Créer une skill</span></a>
            <a href="cli-reference.php"><span<?= cli_i18n_attrs('CLI détaillé', 'CLI details') ?>>CLI détaillé</span></a>
        </nav>
    </header>

    <section id="detail" class="cli-section">
        <h2><span<?= cli_i18n_attrs('Guide', 'Guide') ?>>Guide</span></h2>
        <div class="cli-details-grid">
            <div>
                <h3><span<?= cli_i18n_attrs('1. L’IA publie pour vous', '1. The AI publishes for you') ?>>1. L’IA publie pour vous</span></h3>
                <p class="cli-copy"<?= cli_i18n_attrs('Copiez le prompt proposé plus bas dans Claude Code ou Codex. L’IA crée le fichier <code>design.json</code>, puis peut publier le design si vous lui donnez explicitement l’autorisation et un jeton CLI créé dans votre profil.', 'Copy the prompt below into Claude Code or Codex. The AI creates the <code>design.json</code> file, then can publish the design if you explicitly give it permission and a CLI token created in your profile.', true) ?>>Copiez le prompt proposé plus bas dans Claude Code ou Codex. L’IA crée le fichier <code>design.json</code>, puis peut publier le design si vous lui donnez explicitement l’autorisation et un jeton CLI créé dans votre profil.</p>
                <p class="cli-copy"<?= cli_i18n_attrs('Dans ce cas, vous n’avez pas besoin d’installer le CLI dans votre terminal.', 'In this case, you do not need to install the CLI in your terminal.') ?>>Dans ce cas, vous n’avez pas besoin d’installer le CLI dans votre terminal.</p>
            </div>
            <div>
                <h3><span<?= cli_i18n_attrs('2. Vous publiez vous-même', '2. You publish yourself') ?>>2. Vous publiez vous-même</span></h3>
                <p class="cli-copy"<?= cli_i18n_attrs('Copiez le prompt pour que l’IA crée le fichier <code>design.json</code>, puis téléchargez ce fichier sur votre ordinateur. Pour publier vous-même, vous devez installer le CLI, créer un jeton dans votre profil, lancer <code>learning login</code>, puis <code>learning publish</code>.', 'Copy the prompt so the AI creates the <code>design.json</code> file, then download that file to your computer. To publish yourself, you must install the CLI, create a token in your profile, run <code>learning login</code>, then <code>learning publish</code>.', true) ?>>Copiez le prompt pour que l’IA crée le fichier <code>design.json</code>, puis téléchargez ce fichier sur votre ordinateur. Pour publier vous-même, vous devez installer le CLI, créer un jeton dans votre profil, lancer <code>learning login</code>, puis <code>learning publish</code>.</p>
                <p class="cli-copy"<?= cli_i18n_attrs('Les commandes d’installation et de publication sont expliquées dans la <a href="cli-reference.php">page CLI détaillé</a>.', 'The installation and publishing commands are explained on the <a href="cli-reference.php">CLI details page</a>.', true) ?>>Les commandes d’installation et de publication sont expliquées dans la <a href="cli-reference.php">page CLI détaillé</a>.</p>
            </div>
        </div>
    </section>

    <section id="prompt" class="cli-section">
        <h2><span<?= cli_i18n_attrs('Prompt à donner à Claude Code ou Codex', 'Prompt to give Claude Code or Codex') ?>>Prompt à donner à Claude Code ou Codex</span></h2>
        <p class="cli-copy"<?= cli_i18n_attrs('Copiez ce prompt dans Claude ou Codex. Il demande à l’IA d’utiliser le CLI, de poser les bonnes questions pédagogiques, puis de produire un fichier validé.', 'Copy this prompt into Claude or Codex. It asks the AI to use the CLI, ask the right pedagogical questions, then produce a validated file.') ?>>Copiez ce prompt dans Claude ou Codex. Il demande à l’IA d’utiliser le CLI, de poser les bonnes questions pédagogiques, puis de produire un fichier validé.</p>
        <div class="cli-prompt-wrap">
            <button class="cli-copy-btn" type="button" id="copy-prompt-btn" aria-label="Copier le prompt" title="Copier"<?= cli_i18n_attr_attrs('aria-label,title', 'Copier le prompt', 'Copy prompt') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <textarea class="cli-prompt" id="ai-prompt" readonly><?= cli_h($prompt) ?></textarea>
        </div>
    </section>

    <section id="after-ai" class="cli-section">
        <h2><span<?= cli_i18n_attrs('Après Claude ou Codex', 'After Claude or Codex') ?>>Après Claude ou Codex</span></h2>
        <p class="cli-copy"<?= cli_i18n_attrs('Demandez simplement à l’IA de publier le design qu’elle vient de créer. Pour cela, donnez-lui explicitement l’autorisation de publier et un jeton CLI créé dans votre profil.', 'Simply ask the AI to publish the design it just created. To do this, explicitly give it permission to publish and a CLI token created in your profile.') ?>>Demandez simplement à l’IA de publier le design qu’elle vient de créer. Pour cela, donnez-lui explicitement l’autorisation de publier et un jeton CLI créé dans votre profil.</p>
        <p class="cli-copy"<?= cli_i18n_attrs('Si vous préférez publier vous-même depuis votre ordinateur, suivez la <a href="cli-reference.php">page CLI détaillé</a>.', 'If you prefer to publish yourself from your computer, follow the <a href="cli-reference.php">CLI details page</a>.', true) ?>>Si vous préférez publier vous-même depuis votre ordinateur, suivez la <a href="cli-reference.php">page CLI détaillé</a>.</p>
    </section>
</main>
<?php render_site_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var promptTexts = {
        fr: <?= json_encode($prompt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
        en: <?= json_encode($promptEn, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
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

});
</script>
</body>
</html>
