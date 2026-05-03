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
    </style>
</head>
<body>
<?php render_site_nav(); ?>
<main class="about-shell with-nav">
    <div class="about-card">
        <p class="about-kicker">Learning Designer</p>
        <h1 class="about-title">À propos</h1>
        <p class="about-subtitle">Un outil de scénarisation pédagogique pour concevoir, visualiser et exporter des séquences d'apprentissage.</p>

        <div class="about-section">
            <h2>Ce que vous pouvez faire</h2>
            <ul class="feature-grid">
                <li class="feature-item">
                    <strong>Composer des séquences</strong>
                    <span>Organisez votre parcours en moments, chacun avec titre, objectifs et intentions pédagogiques.</span>
                </li>
                <li class="feature-item">
                    <strong>Typez vos activités</strong>
                    <span>Associez chaque activité à l'un des 6 types ci-dessous pour visualiser l'équilibre de votre scénario.</span>
                </li>
                <li class="feature-item">
                    <strong>Paramétrez le contexte</strong>
                    <span>Durée, modalité (présentiel, distanciel, hybride), synchrone ou asynchrone, mode de groupement, évaluation.</span>
                </li>
                <li class="feature-item">
                    <strong>Associez des outils</strong>
                    <span>Liez vos activités à des outils Moodle ou à des types de contenus H5P.</span>
                </li>
                <li class="feature-item">
                    <strong>Analysez visuellement</strong>
                    <span>Un panneau d'analyse affiche la répartition du temps entre les types d'activités sous forme de diagrammes.</span>
                </li>
                <li class="feature-item">
                    <strong>Exportez</strong>
                    <span>Exportez votre scénario en Markdown, HTML, feuille de calcul ou CSV.</span>
                </li>
                <li class="feature-item">
                    <strong>Sauvegardez</strong>
                    <span>Connectez-vous pour enregistrer vos scénarios sur votre compte et les retrouver dans Sauvegardes.</span>
                </li>
                <li class="feature-item">
                    <strong>3 vues d'affichage</strong>
                    <span>Passez en vue liste, colonnes ou grille selon vos préférences de travail.</span>
                </li>
                <li class="feature-item">
                    <strong>Acquis d'apprentissage</strong>
                    <span>Formulez vos acquis à partir de la taxonomie révisée de Bloom, avec des verbes d'action classés par niveau cognitif.</span>
                </li>
            </ul>
        </div>

        <div class="about-section">
            <h2>Taxonomie révisée de Bloom</h2>
            <p>Les acquis d'apprentissage s'appuient sur la taxonomie révisée d'Anderson &amp; Krathwohl (2001), qui décrit six niveaux cognitifs progressifs :</p>
            <ul class="feature-grid">
                <li class="feature-item">
                    <strong>1 — Se souvenir</strong>
                    <span>Citer, définir, identifier, lister, reconnaître…</span>
                </li>
                <li class="feature-item">
                    <strong>2 — Comprendre</strong>
                    <span>Expliquer, illustrer, interpréter, résumer…</span>
                </li>
                <li class="feature-item">
                    <strong>3 — Appliquer</strong>
                    <span>Démontrer, exécuter, résoudre, utiliser…</span>
                </li>
                <li class="feature-item">
                    <strong>4 — Analyser</strong>
                    <span>Comparer, décomposer, différencier, examiner…</span>
                </li>
                <li class="feature-item">
                    <strong>5 — Évaluer</strong>
                    <span>Critiquer, défendre, justifier, recommander…</span>
                </li>
                <li class="feature-item">
                    <strong>6 — Créer</strong>
                    <span>Concevoir, élaborer, formuler, produire…</span>
                </li>
            </ul>
        </div>

        <div class="about-section">
            <h2>6 types d'activités</h2>
            <ul class="type-list">
                <li class="type-tag" style="background:#a1f5ed22"><span class="type-dot" style="background:#a1f5ed"></span>Lire / Regarder / Écouter</li>
                <li class="type-tag" style="background:#f8807f22"><span class="type-dot" style="background:#f8807f"></span>Investiguer</li>
                <li class="type-tag" style="background:#bb98dc22"><span class="type-dot" style="background:#bb98dc"></span>Pratiquer</li>
                <li class="type-tag" style="background:#bdea7522"><span class="type-dot" style="background:#bdea75"></span>Produire</li>
                <li class="type-tag" style="background:#7aaeea22"><span class="type-dot" style="background:#7aaeea"></span>Discuter</li>
                <li class="type-tag" style="background:#ffd96622"><span class="type-dot" style="background:#ffd966"></span>Collaborer</li>
                <li class="type-tag" style="background:#d1d5db22"><span class="type-dot" style="background:#d1d5db"></span>Non défini</li>
            </ul>
        </div>

        <div class="about-section">
            <h2>Données et confidentialité</h2>
            <p>Les modifications restent dans la page tant qu'elle est ouverte. Aucune donnée n'est envoyée sans votre action explicite. Pour sauvegarder un scénario, connectez-vous puis cliquez sur <strong>Enregistrer</strong> — votre travail est alors associé à votre compte uniquement.</p>
        </div>

        <hr class="about-divider">

        <p class="about-meta">
            Inspiré de l'<a href="https://www.ucl.ac.uk/learning-designer/" target="_blank" rel="noopener noreferrer">UCL Learning Designer</a> (UCL Knowledge Lab, UCL Institute of Education, 2013–2026).<br>
            Conçu et développé par Yann Houry &amp; François Jourde (2026) · <abbr title="Creative Commons Attribution - Partage dans les mêmes conditions">CC BY-SA</abbr><br>
            Code source : <a href="https://github.com/YannHY/learning-designer" target="_blank" rel="noopener noreferrer">github.com/YannHY/learning-designer</a> (basé sur <a href="https://github.com/jourde" target="_blank" rel="noopener noreferrer">github.com/jourde</a>)<br>
        </p>
    </div>
</main>
</body>
</html>
