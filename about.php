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
    <link rel="stylesheet" href="interface.css?v=20260502-1">
    <link rel="stylesheet" href="account-ui.css?v=20260502-2">
    <link rel="stylesheet" href="account-pages.css">
    <style>
        .about-shell {
            max-width: 760px;
            margin: 32px auto 64px;
            padding: 0 18px;
        }
        .about-card {
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 36px 40px;
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
            margin: 0 0 32px;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
        }
        .about-section {
            margin-bottom: 32px;
        }
        .about-section h2 {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--primary);
            margin: 0 0 12px;
        }
        .about-section p {
            margin: 0 0 10px;
            color: var(--muted);
            line-height: 1.65;
            font-size: 14px;
        }
        .about-section p:last-child {
            margin-bottom: 0;
        }
        .about-section a {
            color: var(--primary);
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .feature-item {
            background: #f4f7fc;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 13px;
            color: var(--text);
            line-height: 1.4;
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
            margin: 0;
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
        .type-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .about-divider {
            border: none;
            border-top: 1px solid var(--line);
            margin: 28px 0;
        }
        .about-meta {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.7;
        }
        .about-meta a { color: var(--primary); }
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
        [data-theme="dark"] .type-tag {
            border-color: rgba(103, 116, 145, 0.38);
            color: #eef3ff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.03);
        }
        [data-theme="dark"] .type-tag .type-dot {
            box-shadow: 0 0 0 1px rgba(10, 14, 24, 0.45);
        }
        [data-theme="dark"] .about-divider {
            border-top-color: rgba(103, 116, 145, 0.38);
        }
    </style>
</head>
<body>
<?php render_site_nav(); ?>
<main class="about-shell with-nav">
    <div class="about-card">
        <p id="about-kicker" class="about-kicker">Learning Designer</p>
        <h1 id="about-title" class="about-title">À propos</h1>
        <p id="about-subtitle" class="about-subtitle">Un outil de scénarisation pédagogique pour concevoir, visualiser et exporter des séquences d'apprentissage.</p>

        <div class="about-section">
            <h2 id="about-section-capabilities-title">Ce que vous pouvez faire</h2>
            <ul class="feature-grid">
                <li class="feature-item">
                    <strong id="about-feature-1-title">Composer des séquences</strong>
                    <span id="about-feature-1-text">Organisez votre parcours en moments, chacun avec titre, objectifs et intentions pédagogiques.</span>
                </li>
                <li class="feature-item">
                    <strong id="about-feature-2-title">Typez vos activités</strong>
                    <span id="about-feature-2-text">Associez chaque activité à l'un des 6 types ci-dessous pour visualiser l'équilibre de votre scénario.</span>
                </li>
                <li class="feature-item">
                    <strong id="about-feature-3-title">Paramétrez le contexte</strong>
                    <span id="about-feature-3-text">Durée, modalité (présentiel, distanciel, hybride), synchrone ou asynchrone, mode de groupement, évaluation.</span>
                </li>
                <li class="feature-item">
                    <strong id="about-feature-4-title">Associez des outils</strong>
                    <span id="about-feature-4-text">Liez vos activités à des outils Moodle ou à des types de contenus H5P.</span>
                </li>
                <li class="feature-item">
                    <strong id="about-feature-5-title">Analysez visuellement</strong>
                    <span id="about-feature-5-text">Un panneau d'analyse affiche la répartition du temps entre les types d'activités sous forme de diagrammes.</span>
                </li>
                <li class="feature-item">
                    <strong id="about-feature-6-title">Exportez</strong>
                    <span id="about-feature-6-text">Exportez votre scénario en Markdown, HTML, feuille de calcul ou CSV.</span>
                </li>
                <li class="feature-item">
                    <strong id="about-feature-7-title">Sauvegardez</strong>
                    <span id="about-feature-7-text">Connectez-vous pour enregistrer vos scénarios sur votre compte et les retrouver dans Designs.</span>
                </li>
                <li class="feature-item">
                    <strong id="about-feature-8-title">3 vues d'affichage</strong>
                    <span id="about-feature-8-text">Passez en vue liste, colonnes ou grille selon vos préférences de travail.</span>
                </li>
                <li class="feature-item">
                    <strong id="about-feature-9-title">Acquis d'apprentissage</strong>
                    <span id="about-feature-9-text">Formulez vos acquis à partir de la taxonomie révisée de Bloom, avec des verbes d'action classés par niveau cognitif.</span>
                </li>
            </ul>
        </div>

        <div class="about-section">
            <h2 id="about-section-bloom-title">Taxonomie révisée de Bloom</h2>
            <p id="about-bloom-intro">Les acquis d'apprentissage s'appuient sur la taxonomie révisée d'Anderson &amp; Krathwohl (2001), qui décrit six niveaux cognitifs progressifs :</p>
            <ul class="feature-grid">
                <li class="feature-item">
                    <strong id="about-bloom-1-title">1 — Se souvenir</strong>
                    <span id="about-bloom-1-text">Citer, définir, identifier, lister, reconnaître…</span>
                </li>
                <li class="feature-item">
                    <strong id="about-bloom-2-title">2 — Comprendre</strong>
                    <span id="about-bloom-2-text">Expliquer, illustrer, interpréter, résumer…</span>
                </li>
                <li class="feature-item">
                    <strong id="about-bloom-3-title">3 — Appliquer</strong>
                    <span id="about-bloom-3-text">Démontrer, exécuter, résoudre, utiliser…</span>
                </li>
                <li class="feature-item">
                    <strong id="about-bloom-4-title">4 — Analyser</strong>
                    <span id="about-bloom-4-text">Comparer, décomposer, différencier, examiner…</span>
                </li>
                <li class="feature-item">
                    <strong id="about-bloom-5-title">5 — Évaluer</strong>
                    <span id="about-bloom-5-text">Critiquer, défendre, justifier, recommander…</span>
                </li>
                <li class="feature-item">
                    <strong id="about-bloom-6-title">6 — Créer</strong>
                    <span id="about-bloom-6-text">Concevoir, élaborer, formuler, produire…</span>
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
                <li id="about-type-7" class="type-tag" style="background:#d1d5db22"><span class="type-dot" style="background:#d1d5db"></span>Non défini</li>
            </ul>
        </div>

        <div class="about-section">
            <h2 id="about-section-privacy-title">Données et confidentialité</h2>
            <p id="about-privacy-text">Les modifications restent dans la page tant qu'elle est ouverte. Aucune donnée n'est envoyée sans votre action explicite. Pour sauvegarder un scénario, connectez-vous puis cliquez sur <strong>Enregistrer</strong> — votre travail est alors associé à votre compte uniquement.</p>
        </div>

        <hr class="about-divider">

        <p id="about-meta" class="about-meta">
            Inspiré de l'<a href="https://www.ucl.ac.uk/learning-designer/" target="_blank" rel="noopener noreferrer">UCL Learning Designer</a> (UCL Knowledge Lab, UCL Institute of Education, 2013–2026).<br>
            Conçu et développé par Yann Houry &amp; François Jourde (2026) · <abbr title="Creative Commons Attribution - Partage dans les mêmes conditions">CC BY-SA</abbr><br>
            Code source : <a href="https://github.com/YannHY/learning-designer" target="_blank" rel="noopener noreferrer">github.com/YannHY/learning-designer</a> (basé sur <a href="https://github.com/jourde" target="_blank" rel="noopener noreferrer">github.com/jourde</a>)<br>
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
        'about-feature-4-title': 'Attach tools',
        'about-feature-4-text': 'Link your activities to Moodle tools or H5P content types.',
        'about-feature-5-title': 'Analyze visually',
        'about-feature-5-text': 'An analysis panel shows how time is distributed across learning types with charts.',
        'about-feature-6-title': 'Export',
        'about-feature-6-text': 'Export your design as Markdown, HTML, spreadsheet, or CSV.',
        'about-feature-7-title': 'Save',
        'about-feature-7-text': 'Sign in to save your designs to your account and find them again in Saves.',
        'about-feature-8-title': '3 display views',
        'about-feature-8-text': 'Switch between list, columns, or grid view depending on how you prefer to work.',
        'about-feature-9-title': 'Learning outcomes',
        'about-feature-9-text': 'Write outcomes using the revised Bloom taxonomy, with action verbs organized by cognitive level.',
        'about-section-bloom-title': "Revised Bloom's Taxonomy",
        'about-bloom-intro': "Learning outcomes rely on the revised taxonomy of Anderson & Krathwohl (2001), which describes six progressive cognitive levels:",
        'about-bloom-1-title': '1 — Remember',
        'about-bloom-1-text': 'Cite, define, identify, list, recognize…',
        'about-bloom-2-title': '2 — Understand',
        'about-bloom-2-text': 'Explain, illustrate, interpret, summarize…',
        'about-bloom-3-title': '3 — Apply',
        'about-bloom-3-text': 'Demonstrate, carry out, solve, use…',
        'about-bloom-4-title': '4 — Analyze',
        'about-bloom-4-text': 'Compare, break down, differentiate, examine…',
        'about-bloom-5-title': '5 — Evaluate',
        'about-bloom-5-text': 'Critique, defend, justify, recommend…',
        'about-bloom-6-title': '6 — Create',
        'about-bloom-6-text': 'Design, develop, formulate, produce…',
        'about-section-types-title': '6 learning activity types',
        'about-type-1': '<span class="type-dot" style="background:#a1f5ed"></span>Read / Watch / Listen',
        'about-type-2': '<span class="type-dot" style="background:#f8807f"></span>Investigate',
        'about-type-3': '<span class="type-dot" style="background:#bb98dc"></span>Practice',
        'about-type-4': '<span class="type-dot" style="background:#bdea75"></span>Produce',
        'about-type-5': '<span class="type-dot" style="background:#7aaeea"></span>Discuss',
        'about-type-6': '<span class="type-dot" style="background:#ffd966"></span>Collaborate',
        'about-type-7': '<span class="type-dot" style="background:#d1d5db"></span>Undefined',
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
