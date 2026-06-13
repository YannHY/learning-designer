<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>À propos | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260520-2">
    <link rel="stylesheet" href="account-ui.css?v=20260520-4">
    <link rel="stylesheet" href="account-pages.css?v=20260521-width">
    <style>
        .about-shell {
            width: min(var(--content-shell-width, 1180px), calc(100vw - var(--content-shell-gutter, 36px)));
            margin: 32px auto 64px;
        }
        .about-card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 42px 46px 48px;
        }
        .about-kicker {
            margin: 0 0 8px;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 12px;
            font-weight: 700;
        }
        .about-title {
            margin: 0 0 6px;
            font-size: clamp(24px, 4vw, 32px);
            color: var(--text);
        }
        .about-subtitle {
            margin: 0 0 42px;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
        }
        .about-section {
            margin-bottom: 46px;
        }
        .about-section h2 {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--primary);
            margin: 0 0 16px;
        }
        .about-section p {
            margin: 0 0 14px;
            color: var(--muted);
            line-height: 1.72;
            font-size: 14px;
        }
        .about-section p:last-child {
            margin-bottom: 0;
        }
        #about-competencies-tracking {
            margin-top: 22px;
        }
        .about-section a {
            color: inherit;
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .feature-item {
            background: #f4f7fc;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 16px 17px;
            font-size: 13px;
            color: var(--text);
            line-height: 1.48;
        }
        .capability-item {
            display: grid;
            grid-template-columns: 26px minmax(0, 1fr);
            gap: 8px 10px;
            align-items: center;
        }
        .capability-icon {
            width: 26px;
            height: 26px;
            display: inline-grid;
            place-items: center;
            border-radius: 8px;
            background: rgba(20, 91, 180, 0.10);
            color: var(--primary);
            font-size: 13px;
        }
        .capability-item > div {
            display: contents;
        }
        .feature-item.capability-item strong {
            grid-column: 2;
            grid-row: 1;
            align-self: center;
            margin-bottom: 0;
            line-height: 1.25;
        }
        .feature-item.capability-item span {
            grid-column: 1 / -1;
            grid-row: 2;
        }
        .feature-item strong {
            display: block;
            font-weight: 600;
            margin-bottom: 3px;
        }
        .feature-item span {
            color: var(--muted);
        }
        .type-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 0 0 20px;
            padding: 0;
            list-style: none;
        }
        .type-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid rgba(0,0,0,0.08);
        }
        .about-link-list {
            margin: 16px 0 0;
        }
        .about-section a.about-resource-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }
        .about-section a.about-resource-link:hover,
        .about-section a.about-resource-link:focus-visible {
            color: var(--primary);
            text-decoration: none;
        }
        .about-section a.about-resource-link i {
            font-size: 12px;
            opacity: 0.82;
        }
        .type-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .about-divider {
            border: none;
            border-top: 1px solid var(--line);
            margin: 36px 0;
        }
        .about-meta {
            font-size: 13px;
            color: var(--muted);
            line-height: 2.15;
        }
        .about-meta a {
            color: inherit;
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .about-meta abbr {
            border-bottom: none;
            text-decoration: none;
        }
        body.about-page {
            background: #fff;
        }
        [data-theme="dark"] body.about-page {
            background:
                radial-gradient(circle at top left, rgba(56, 139, 253, 0.10), transparent 28%),
                linear-gradient(180deg, #1f2537 0%, #1a1f2e 100%);
        }
        [data-theme="dark"] .about-card {
            background: linear-gradient(180deg, rgba(36, 43, 64, 0.96), rgba(30, 36, 54, 0.96));
            border-color: rgba(103, 116, 145, 0.45);
            box-shadow: 0 18px 42px rgba(0, 0, 0, 0.35);
        }
        [data-theme="dark"] .about-title,
        [data-theme="dark"] .feature-item,
        [data-theme="dark"] .type-tag {
            color: var(--text);
        }
        [data-theme="dark"] .about-title {
            color: #f3f6ff;
        }
        [data-theme="dark"] .about-kicker,
        [data-theme="dark"] .about-section h2 {
            color: #8cc6ff;
        }
        [data-theme="dark"] .about-subtitle,
        [data-theme="dark"] .about-section p,
        [data-theme="dark"] .feature-item span,
        [data-theme="dark"] .about-meta {
            color: var(--text-body);
        }
        [data-theme="dark"] .feature-item {
            background: rgba(26, 31, 46, 0.78);
            border-color: rgba(103, 116, 145, 0.38);
        }
        [data-theme="dark"] .feature-item strong {
            color: #eef3ff;
        }
        [data-theme="dark"] .capability-icon {
            background: rgba(140, 198, 255, 0.14);
            color: #8cc6ff;
        }
        [data-theme="dark"] .type-tag {
            border-color: rgba(103, 116, 145, 0.38);
            color: #eef3ff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.03);
        }
        [data-theme="dark"] .about-resource-link {
            color: #b9dcff;
        }
        [data-theme="dark"] .about-resource-link:hover,
        [data-theme="dark"] .about-resource-link:focus-visible {
            color: #d9ecff;
        }
        [data-theme="dark"] .type-tag .type-dot {
            box-shadow: 0 0 0 1px rgba(10, 14, 24, 0.45);
        }
        [data-theme="dark"] .about-divider {
            border-top-color: rgba(103, 116, 145, 0.38);
        }
    </style>
</head>
<body class="about-page">
<?php render_site_nav(); ?>
<main class="about-shell with-nav">
    <div class="about-card">
        <h1 id="about-title" class="about-title">À propos</h1>
        <p id="about-subtitle" class="about-subtitle">Un outil de scénarisation pédagogique pour concevoir, visualiser et exporter des séquences d'apprentissage.</p>

        <div class="about-section">
            <h2 id="about-section-capabilities-title">Ce que vous pouvez faire</h2>
            <ul class="feature-grid">
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-layer-group capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-1-title">Composer des séquences</strong>
                        <span id="about-feature-1-text">Organisez votre parcours en moments, chacun avec titre, objectifs et intentions pédagogiques.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-tags capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-2-title">Typez vos activités</strong>
                        <span id="about-feature-2-text">Associez chaque activité à l'un des 6 types ci-dessous pour visualiser l'équilibre de votre scénario.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-sliders capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-3-title">Paramétrez le contexte</strong>
                        <span id="about-feature-3-text">Durée, modalité (présentiel, distanciel, hybride), synchrone ou asynchrone, mode de groupement, évaluation.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-screwdriver-wrench capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-4-title">Intégrez les compétences numériques</strong>
                        <span id="about-feature-4-text">Associez vos activités à un curriculum structuré autour de trois domaines&nbsp;: Acquérir, Approfondir, Créer.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-chart-pie capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-5-title">Analysez visuellement</strong>
                        <span id="about-feature-5-text">Un panneau d'analyse affiche la répartition du temps entre les types d'activités sous forme de diagrammes.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-file-export capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-6-title">Exportez</strong>
                        <span id="about-feature-6-text">Exportez votre scénario en JSON, Markdown, Word, HTML ou Excel.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-floppy-disk capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-7-title">Sauvegardez</strong>
                        <span id="about-feature-7-text">Connectez-vous pour enregistrer vos scénarios sur votre compte et les retrouver dans Designs.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-table-cells-large capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-8-title">3 vues d'affichage</strong>
                        <span id="about-feature-8-text">Passez en vue liste, colonnes ou grille selon vos préférences de travail.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-graduation-cap capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-feature-9-title">Acquis d'apprentissage</strong>
                        <span id="about-feature-9-text">Formulez vos acquis à partir de la taxonomie révisée de Bloom, avec des verbes d'action classés par niveau cognitif.</span>
                    </div>
                </li>
            </ul>
        </div>

        <div class="about-section">
            <h2 id="about-section-types-title">6 types d'activités</h2>
            <ul class="type-list">
                <li id="about-type-1" class="type-tag" style="background:#a1f5ed22"><span class="type-dot" style="background:#a1f5ed"></span>Lire / Regarder / Écouter</li>
                <li id="about-type-2" class="type-tag" style="background:#f8807f22"><span class="type-dot" style="background:#f8807f"></span>Investiguer</li>
                <li id="about-type-3" class="type-tag" style="background:#bb98dc22"><span class="type-dot" style="background:#bb98dc"></span>Pratiquer</li>
                <li id="about-type-4" class="type-tag" style="background:#bdea7522"><span class="type-dot" style="background:#bdea75"></span>Produire</li>
                <li id="about-type-5" class="type-tag" style="background:#7aaeea22"><span class="type-dot" style="background:#7aaeea"></span>Discuter</li>
                <li id="about-type-6" class="type-tag" style="background:#ffd96622"><span class="type-dot" style="background:#ffd966"></span>Collaborer</li>
            </ul>
            <p id="about-types-description">Ce site s’appuie sur les six types d’apprentissage issus du Cadre conversationnel de Diana Laurillard, un modèle qui décrit les conditions nécessaires pour que l’apprentissage ait lieu.</p>
            <p id="about-types-mix">Ces six types sont&nbsp;: lire, écrire ou écouter, également appelé acquisition&nbsp;; investigation&nbsp;; pratique&nbsp;; production&nbsp;; discussion&nbsp;; collaboration. En principe, une bonne scénarisation pédagogique combine plusieurs de ces types d’apprentissage.</p>
            <div class="about-link-list">
                <a id="about-learning-design-link" class="about-resource-link" href="learning-design.php"><i class="fa-solid fa-diagram-project" aria-hidden="true"></i><span>Comprendre le learning design</span></a>
            </div>
        </div>

        <div class="about-section">
            <h2 id="about-section-bloom-title">Taxonomie révisée de Bloom</h2>
            <p id="about-bloom-intro">Les acquis d'apprentissage s'appuient sur la taxonomie révisée d'Anderson &amp; Krathwohl (2001), qui décrit six niveaux cognitifs progressifs&nbsp;:</p>
            <ul class="feature-grid">
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-brain capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-bloom-1-title">Se souvenir</strong>
                        <span id="about-bloom-1-text">Citer, définir, identifier, lister, reconnaître…</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-puzzle-piece capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-bloom-2-title">Comprendre</strong>
                        <span id="about-bloom-2-text">Expliquer, illustrer, interpréter, résumer…</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-pencil capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-bloom-3-title">Appliquer</strong>
                        <span id="about-bloom-3-text">Démontrer, exécuter, résoudre, utiliser…</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-chart-line capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-bloom-4-title">Analyser</strong>
                        <span id="about-bloom-4-text">Comparer, décomposer, différencier, examiner…</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-lightbulb capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-bloom-5-title">Évaluer</strong>
                        <span id="about-bloom-5-text">Critiquer, défendre, justifier, recommander…</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-hammer capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-bloom-6-title">Créer</strong>
                        <span id="about-bloom-6-text">Concevoir, élaborer, formuler, produire…</span>
                    </div>
                </li>
            </ul>
            <div class="about-link-list">
                <a id="about-bloom-link" class="about-resource-link" href="bloom.php"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i><span>Voir la taxonomie de Bloom</span></a>
            </div>
        </div>

        <div class="about-section">
            <h2 id="about-section-competencies-title">Compétences numériques</h2>
            <p id="about-competencies-intro">Learning Designer intègre un référentiel de 95 compétences numériques organisé en trois niveaux progressifs&nbsp;: Acquérir, Approfondir et Créer. Chaque activité peut être associée à une ou plusieurs compétences afin de rendre explicite la progression numérique travaillée dans le scénario.</p>
            <ul class="feature-grid">
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-seedling capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-competencies-1-title">Acquérir</strong>
                        <span id="about-competencies-1-text">Les bases de la vie numérique scolaire&nbsp;: iPad, recherche, organisation, communication, premiers usages créatifs.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-trowel capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-competencies-2-title">Approfondir</strong>
                        <span id="about-competencies-2-text">Des usages plus autonomes&nbsp;: veille, collaboration, données simples, programmation visuelle, IA et création multimédia.</span>
                    </div>
                </li>
                <li class="feature-item capability-item">
                    <i class="fa-solid fa-wand-magic-sparkles capability-icon" aria-hidden="true"></i>
                    <div>
                        <strong id="about-competencies-3-title">Créer</strong>
                        <span id="about-competencies-3-text">Des productions avancées&nbsp;: projet collaboratif, analyse de données, Python, site web, podcast, 3D et réalité augmentée.</span>
                    </div>
                </li>
            </ul>
            <p id="about-competencies-tracking">Une page dédiée présente le référentiel sous forme de tableau. Lorsque vous êtes connecté, elle peut aussi indiquer automatiquement les compétences déjà mobilisées dans vos designs enregistrés.</p>
            <div class="about-link-list">
                <a id="about-competencies-link" class="about-resource-link" href="competencies.php"><i class="fa-solid fa-table-list" aria-hidden="true"></i><span>Voir le tableau des compétences numériques</span></a>
            </div>
        </div>

        <div class="about-section">
            <h2 id="about-section-publish-title">Publication d’un design</h2>
            <p id="about-publish-text">Une fois connecté, vous pouvez publier un design enregistré afin de générer un lien de partage consultable par d’autres personnes. La page publiée présente le scénario dans un format lisible, avec les moments, activités, durées, compétences numériques et liens associés.</p>
            <p id="about-publish-control">Vous gardez la maîtrise de cette publication&nbsp;: le lien peut être révoqué depuis l’application, et la version publiée ne permet pas aux visiteurs de modifier votre design.</p>
        </div>

        <div class="about-section">
            <h2 id="about-section-privacy-title">Données et confidentialité</h2>
            <p id="about-privacy-text">Les modifications restent dans la page tant qu'elle est ouverte. Aucune donnée n'est envoyée sans votre action explicite. Pour sauvegarder un scénario, connectez-vous puis cliquez sur <strong>Enregistrer</strong> — votre travail est alors associé à votre compte uniquement.</p>
        </div>

        <hr class="about-divider">

        <p id="about-meta" class="about-meta">
            Inspiré de l'<a href="https://www.ucl.ac.uk/learning-designer/" target="_blank" rel="noopener noreferrer">UCL Learning Designer</a> (UCL Knowledge Lab, UCL Institute of Education, 2013–2026).<br>
            Conçu et développé par Yann Houry &amp; François Jourde (2026) · <abbr title="Creative Commons Attribution - Partage dans les mêmes conditions">CC BY-SA</abbr><br>
            Code source&nbsp;: <a href="https://github.com/YannHY/learning-designer" target="_blank" rel="noopener noreferrer">github.com/YannHY/learning-designer</a> (basé sur <a href="https://github.com/jourde" target="_blank" rel="noopener noreferrer">github.com/jourde</a>)<br>
        </p>
    </div>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var translations = {
        'about-title': 'About',
        'about-subtitle': 'A learning design tool to create, visualize, and export learning sequences.',
        'about-section-capabilities-title': 'What you can do',
        'about-feature-1-title': 'Build sequences',
        'about-feature-1-text': 'Organize your design into moments, each with its own title, objectives, and teaching intentions.',
        'about-feature-2-title': 'Categorize activities',
        'about-feature-2-text': 'Associate each activity with one of the 6 learning types below to visualize the balance of your design.',
        'about-feature-3-title': 'Set the context',
        'about-feature-3-text': 'Duration, delivery mode (onsite, online, hybrid), synchronous or asynchronous, grouping mode, assessment.',
        'about-feature-4-title': 'Integrate digital competencies',
        'about-feature-4-text': 'Connect activities to a structured digital competency curriculum across three domains: Acquire, Deepen, Create.',
        'about-feature-5-title': 'Analyze visually',
        'about-feature-5-text': 'An analysis panel shows how time is distributed across learning types with charts.',
        'about-feature-6-title': 'Export',
        'about-feature-6-text': 'Export your design as JSON, Markdown, Word, HTML, or Excel.',
        'about-feature-7-title': 'Save',
        'about-feature-7-text': 'Sign in to save your designs to your account and find them again in Saves.',
        'about-feature-8-title': '3 display views',
        'about-feature-8-text': 'Switch between list, columns, or grid view depending on how you prefer to work.',
        'about-feature-9-title': 'Learning outcomes',
        'about-feature-9-text': 'Write outcomes using the revised Bloom taxonomy, with action verbs organized by cognitive level.',
        'about-section-competencies-title': 'Digital competencies',
        'about-competencies-intro': 'Learning Designer includes a 95-item digital competency curriculum organized into three progressive levels: Acquire, Deepen, and Create. Each activity can be linked to one or more competencies to make the digital progression in a design explicit.',
        'about-competencies-1-title': 'Acquire',
        'about-competencies-1-text': 'Foundations of school digital life: iPad, search, organization, communication, and first creative uses.',
        'about-competencies-2-title': 'Deepen',
        'about-competencies-2-text': 'More autonomous uses: monitoring information, collaboration, simple data, visual programming, AI, and multimedia creation.',
        'about-competencies-3-title': 'Create',
        'about-competencies-3-text': 'Advanced productions: collaborative projects, data analysis, Python, websites, podcasts, 3D, and augmented reality.',
        'about-competencies-tracking': 'A dedicated page presents the curriculum as a table. When you are signed in, it can also automatically show which competencies are already used in your saved designs.',
        'about-competencies-link': 'View the digital competencies table',
        'about-section-bloom-title': "Revised Bloom's Taxonomy",
        'about-bloom-intro': "Learning outcomes rely on the revised taxonomy of Anderson & Krathwohl (2001), which describes six progressive cognitive levels:",
        'about-bloom-1-title': 'Remember',
        'about-bloom-1-text': 'Cite, define, identify, list, recognize…',
        'about-bloom-2-title': 'Understand',
        'about-bloom-2-text': 'Explain, illustrate, interpret, summarize…',
        'about-bloom-3-title': 'Apply',
        'about-bloom-3-text': 'Demonstrate, carry out, solve, use…',
        'about-bloom-4-title': 'Analyze',
        'about-bloom-4-text': 'Compare, break down, differentiate, examine…',
        'about-bloom-5-title': 'Evaluate',
        'about-bloom-5-text': 'Critique, defend, justify, recommend…',
        'about-bloom-6-title': 'Create',
        'about-bloom-6-text': 'Design, develop, formulate, produce…',
        'about-bloom-link': "View Bloom's taxonomy",
        'about-section-types-title': '6 learning activity types',
        'about-type-1': '<span class="type-dot" style="background:#a1f5ed"></span>Read / Watch / Listen',
        'about-type-2': '<span class="type-dot" style="background:#f8807f"></span>Investigate',
        'about-type-3': '<span class="type-dot" style="background:#bb98dc"></span>Practice',
        'about-type-4': '<span class="type-dot" style="background:#bdea75"></span>Produce',
        'about-type-5': '<span class="type-dot" style="background:#7aaeea"></span>Discuss',
        'about-type-6': '<span class="type-dot" style="background:#ffd966"></span>Collaborate',
        'about-types-description': "This site is based on the six learning types from Diana Laurillard’s Conversational Framework, a model that describes the conditions necessary for learning to take place.",
        'about-types-mix': 'These six types are: read, write, or listen, also called acquisition; inquiry; practice; production; discussion; collaboration. In principle, a good learning design combines several of these learning types.',
        'about-learning-design-link': 'Understand learning design',
        'about-section-publish-title': 'Publishing a design',
        'about-publish-text': 'Once signed in, you can publish a saved design to generate a shareable read-only link. The published page presents the design in a readable format, with moments, activities, durations, digital competencies, and related links.',
        'about-publish-control': 'You stay in control of the publication: the link can be revoked from the app, and visitors cannot edit your design from the published page.',
        'about-section-privacy-title': 'Data and privacy',
        'about-privacy-text': 'Changes stay in the page while it remains open. No data is sent anywhere without your explicit action. To save a design, sign in and click <strong>Save</strong> — your work is then associated only with your account.',
        'about-meta': 'Inspired by the <a href="https://www.ucl.ac.uk/learning-designer/" target="_blank" rel="noopener noreferrer">UCL Learning Designer</a> (UCL Knowledge Lab, UCL Institute of Education, 2013–2026).<br>Designed and developed by Yann Houry &amp; François Jourde (2026) · <abbr title="Creative Commons Attribution - ShareAlike">CC BY-SA</abbr><br>Source code: <a href="https://github.com/YannHY/learning-designer" target="_blank" rel="noopener noreferrer">github.com/YannHY/learning-designer</a> (based on <a href="https://github.com/jourde" target="_blank" rel="noopener noreferrer">github.com/jourde</a>)<br>'
    };

    function applyAboutLanguage(lang) {
        document.documentElement.lang = lang === 'en' ? 'en' : 'fr';
        document.title = lang === 'en' ? 'About | Learning Designer' : 'À propos | Learning Designer';

        Object.keys(translations).forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            if (lang !== 'en') return;
            if (id === 'about-meta' || id === 'about-privacy-text' || id.indexOf('about-type-') === 0) {
                el.innerHTML = translations[id];
            } else if (id === 'about-competencies-link' || id === 'about-bloom-link' || id === 'about-learning-design-link') {
                var span = el.querySelector('span');
                if (span) span.textContent = translations[id];
            } else {
                el.textContent = translations[id];
            }
        });
    }

    var lang = 'fr';
    try {
        lang = localStorage.getItem('learningDesignerLang') || 'fr';
    } catch (error) {
        lang = 'fr';
    }
    applyAboutLanguage(lang);

    var langSelect = document.getElementById('lang-select');
    if (langSelect) {
        langSelect.addEventListener('change', function () {
            applyAboutLanguage(langSelect.value);
            try {
                localStorage.setItem('learningDesignerLang', langSelect.value);
            } catch (error) {
            }
            if (langSelect.value !== 'en') {
                window.location.reload();
            }
        });
    }
});
</script>
<?php /* French source markup is the default content; English is layered client-side for now. */ ?>
</body>
</html>
