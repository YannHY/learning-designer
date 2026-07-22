<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

function cli_ref_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function cli_ref_i18n_attrs(string $fr, string $en, bool $html = false): string
{
    $attrs = ' data-cli-ref-i18n-fr="' . cli_ref_h($fr) . '" data-cli-ref-i18n-en="' . cli_ref_h($en) . '"';
    if ($html) {
        $attrs .= ' data-cli-ref-i18n-html="1"';
    }
    return $attrs;
}

function cli_ref_i18n_attr_attrs(string $attr, string $fr, string $en): string
{
    return ' data-cli-ref-i18n-attr="' . cli_ref_h($attr) . '" data-cli-ref-i18n-fr="' . cli_ref_h($fr) . '" data-cli-ref-i18n-en="' . cli_ref_h($en) . '"';
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLI détaillé | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260722-mobile-tab-spacing">
    <link rel="stylesheet" href="account-ui.css?v=20260520-4">
    <link rel="stylesheet" href="account-pages.css?v=20260722-neutral-theme">
    <style>
        .cli-ref-hero {
            display: grid;
            gap: 14px;
            margin-bottom: 26px;
        }
        .cli-ref-subtitle {
            max-width: 980px;
            margin: 0;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.65;
        }
        .cli-ref-section {
            min-width: 0;
            margin-top: 24px;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            box-shadow: 0 8px 18px rgba(0,0,0,0.04);
        }
        .cli-ref-section h2,
        .cli-ref-section h3 {
            margin: 0 0 14px;
            color: var(--text);
            letter-spacing: 0;
        }
        .cli-ref-section h2 {
            font-size: 24px;
        }
        .cli-ref-section h3 {
            font-size: 18px;
        }
        .cli-ref-copy {
            color: var(--muted);
            line-height: 1.65;
        }
        .cli-ref-list {
            display: grid;
            gap: 18px;
            min-width: 0;
            margin-top: 18px;
        }
        .cli-ref-item {
            min-width: 0;
            padding-top: 18px;
            border-top: 1px solid var(--line);
        }
        .cli-ref-item:first-child {
            padding-top: 0;
            border-top: 0;
        }
        .cli-ref-code {
            overflow-x: auto;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            margin: 14px 0 18px;
            padding: 16px;
            border-radius: 8px;
            background: #0b1020;
            color: #e5edf8;
            font: 13px/1.55 ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            white-space: pre;
        }
        .cli-ref-copy-wrap {
            position: relative;
            max-width: 100%;
            min-width: 0;
        }
        .cli-ref-copy-wrap .cli-ref-code {
            padding-right: 54px;
        }
        .cli-ref-copy-btn {
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
        .cli-ref-copy-btn:hover,
        .cli-ref-copy-btn:focus-visible {
            background: rgba(255,255,255,0.16);
            outline: none;
        }
        .cli-ref-note {
            margin: 16px 0;
            padding: 14px;
            border-radius: 8px;
            background: #f6f8fa;
            color: var(--text);
            line-height: 1.55;
        }
        [data-theme="dark"] .cli-ref-title,
        [data-theme="dark"] .cli-ref-section h2,
        [data-theme="dark"] .cli-ref-section h3 {
            color: #f3f6ff;
        }
        [data-theme="dark"] .cli-ref-section {
            background: rgba(30, 36, 54, 0.96);
            border-color: rgba(103, 116, 145, 0.45);
        }
        [data-theme="dark"] .cli-ref-subtitle,
        [data-theme="dark"] .cli-ref-copy {
            color: var(--text-body);
        }
        [data-theme="dark"] .cli-ref-note {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-body);
        }
        [data-theme="dark"] .cli-ref-item {
            border-color: rgba(103, 116, 145, 0.45);
        }
    </style>
</head>
<body class="cli-ref-page">
<?php render_site_nav('cli-reference'); ?>
<main class="cli-ref-shell">
    <header class="cli-ref-hero">
        <h1 class="cli-ref-title"><span<?= cli_ref_i18n_attrs('CLI détaillé', 'CLI details') ?>>CLI détaillé</span></h1>
        <p class="cli-ref-subtitle"<?= cli_ref_i18n_attrs('La commande <code>learning</code> sert à créer, compléter, valider et publier un fichier <code>design.json</code> Learning Designer depuis le terminal. Cette page est utile si vous voulez publier manuellement ou comprendre ce que l’IA exécute dans son environnement.', 'The <code>learning</code> command creates, completes, validates, and publishes a Learning Designer <code>design.json</code> file from the terminal. This page is useful if you want to publish manually or understand what the AI runs in its environment.', true) ?>>La commande <code>learning</code> sert à créer, compléter, valider et publier un fichier <code>design.json</code> Learning Designer depuis le terminal. Cette page est utile si vous voulez publier manuellement ou comprendre ce que l’IA exécute dans son environnement.</p>
    </header>

    <section class="cli-ref-section">
        <h2><span<?= cli_ref_i18n_attrs('Installer', 'Install') ?>>Installer</span></h2>
        <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('L’installation locale est nécessaire seulement si vous voulez utiliser le CLI depuis votre ordinateur, par exemple pour publier vous-même. Si l’IA crée le design dans son sandbox, elle peut installer sa propre copie temporaire.', 'Local installation is only needed if you want to use the CLI from your computer, for example to publish yourself. If the AI creates the design in its sandbox, it can install its own temporary copy.') ?>>L’installation locale est nécessaire seulement si vous voulez utiliser le CLI depuis votre ordinateur, par exemple pour publier vous-même. Si l’IA crée le design dans son sandbox, elle peut installer sa propre copie temporaire.</p>
        <div class="cli-ref-list">
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('1. Lancer l’installateur', '1. Run the installer') ?>>1. Lancer l’installateur</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('Le script vérifie les prérequis, propose un dossier déjà disponible dans le <code>PATH</code>, puis installe la commande <code>learning</code>. Il peut vous demander de confirmer l’emplacement ou d’utiliser <code>sudo</code> selon votre système.', 'The script checks prerequisites, suggests a folder already available in your <code>PATH</code>, then installs the <code>learning</code> command. It may ask you to confirm the location or use <code>sudo</code> depending on your system.', true) ?>>Le script vérifie les prérequis, propose un dossier déjà disponible dans le <code>PATH</code>, puis installe la commande <code>learning</code>. Il peut vous demander de confirmer l’emplacement ou d’utiliser <code>sudo</code> selon votre système.</p>
            </div>
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('2. Vérifier la commande', '2. Check the command') ?>>2. Vérifier la commande</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('<code>learning status</code> confirme la version installée et indique si un jeton de publication est déjà configuré.', '<code>learning status</code> confirms the installed version and shows whether a publishing token is already configured.', true) ?>><code>learning status</code> confirme la version installée et indique si un jeton de publication est déjà configuré.</p>
            </div>
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('3. Créer un jeton', '3. Create a token') ?>>3. Créer un jeton</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('Connectez-vous au site, ouvrez votre profil, puis créez un jeton dans la section <strong>Publication depuis le CLI</strong>. Copiez-le tout de suite : il ne sera affiché qu’une seule fois.', 'Sign in to the site, open your profile, then create a token in the <strong>CLI publishing</strong> section. Copy it immediately: it will only be shown once.', true) ?>>Connectez-vous au site, ouvrez votre profil, puis créez un jeton dans la section <strong>Publication depuis le CLI</strong>. Copiez-le tout de suite : il ne sera affiché qu’une seule fois.</p>
            </div>
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('4. Connecter le CLI', '4. Connect the CLI') ?>>4. Connecter le CLI</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('<code>learning login</code> enregistre le jeton sur votre ordinateur pour les publications suivantes. Vous pouvez ensuite publier avec <code>learning publish</code>.', '<code>learning login</code> saves the token on your computer for future publications. You can then publish with <code>learning publish</code>.', true) ?>><code>learning login</code> enregistre le jeton sur votre ordinateur pour les publications suivantes. Vous pouvez ensuite publier avec <code>learning publish</code>.</p>
            </div>
        </div>
        <div class="cli-ref-copy-wrap">
            <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-ref-code">curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/install.sh | sh
learning status
learning login</pre>
        </div>
    </section>

    <section class="cli-ref-section">
        <h2><span<?= cli_ref_i18n_attrs('Créer un design', 'Create a design') ?>>Créer un design</span></h2>
        <div class="cli-ref-list">
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('1. Initialiser le fichier', '1. Initialize the file') ?>>1. Initialiser le fichier</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('<code>init</code> crée le fichier JSON de départ avec le titre, la langue, la durée, la modalité et les informations générales.', '<code>init</code> creates the starting JSON file with the title, language, duration, mode, and general information.', true) ?>><code>init</code> crée le fichier JSON de départ avec le titre, la langue, la durée, la modalité et les informations générales.</p>
                <div class="cli-ref-copy-wrap">
                    <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-ref-code">learning init design.json --title "Atelier IA" --lang fr --duration 120 --mode hybride --group-size 24</pre>
                </div>
            </div>
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('2. Ajouter des moments', '2. Add moments') ?>>2. Ajouter des moments</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('Un moment correspond à une grande phase de la séance ou de la séquence.', 'A moment is a major phase of the lesson or sequence.') ?>>Un moment correspond à une grande phase de la séance ou de la séquence.</p>
                <div class="cli-ref-copy-wrap">
                    <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-ref-code">learning add-moment design.json --title "Explorer" --objectives "Identifier les usages possibles"</pre>
                </div>
            </div>
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('3. Ajouter des activités', '3. Add activities') ?>>3. Ajouter des activités</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('Une activité précise le type d’apprentissage, la durée, le groupe, la présence enseignante, le rythme, la modalité, l’évaluation et les compétences numériques.', 'An activity defines the learning type, duration, group, teacher presence, pacing, mode, evaluation, and digital competencies.') ?>>Une activité précise le type d’apprentissage, la durée, le groupe, la présence enseignante, le rythme, la modalité, l’évaluation et les compétences numériques.</p>
                <div class="cli-ref-copy-wrap">
                    <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-ref-code">learning add-activity design.json --type investigate --duration 30 --group subgroups --teacher present --pacing sync --mode onsite --evaluation formative --competencies A6,P34 --description "Comparer trois exemples d'usages de l'IA."</pre>
                </div>
            </div>
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('4. Ajouter des acquis Bloom', '4. Add Bloom outcomes') ?>>4. Ajouter des acquis Bloom</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('<code>outcome</code> ajoute un acquis d’apprentissage relié à la taxonomie de Bloom.', '<code>outcome</code> adds a learning outcome linked to Bloom’s taxonomy.', true) ?>><code>outcome</code> ajoute un acquis d’apprentissage relié à la taxonomie de Bloom.</p>
                <div class="cli-ref-copy-wrap">
                    <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-ref-code">learning outcome design.json --bloom analyser --verb "Comparer" --text "Comparer des réponses générées par IA selon leur fiabilité."</pre>
                </div>
            </div>
            <div class="cli-ref-item">
                <h3><span<?= cli_ref_i18n_attrs('5. Valider et préparer le relais', '5. Validate and prepare handoff') ?>>5. Valider et préparer le relais</span></h3>
                <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('<code>validate</code> vérifie le fichier. <code>prompt</code> produit un prompt de relais utile pour demander à Claude Code ou Codex de continuer le travail.', '<code>validate</code> checks the file. <code>prompt</code> produces a handoff prompt useful for asking Claude Code or Codex to continue the work.', true) ?>><code>validate</code> vérifie le fichier. <code>prompt</code> produit un prompt de relais utile pour demander à Claude Code ou Codex de continuer le travail.</p>
                <div class="cli-ref-copy-wrap">
                    <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-ref-code">learning validate design.json
learning prompt design.json</pre>
                </div>
            </div>
        </div>
    </section>

    <section class="cli-ref-section">
        <h2><span<?= cli_ref_i18n_attrs('Publier', 'Publish') ?>>Publier</span></h2>
        <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('Pour publier depuis votre ordinateur, créez d’abord un jeton dans votre profil, section <strong>Publication depuis le CLI</strong>. Ensuite, connectez le CLI et publiez le fichier.', 'To publish from your computer, first create a token in your profile, in the <strong>CLI publishing</strong> section. Then connect the CLI and publish the file.', true) ?>>Pour publier depuis votre ordinateur, créez d’abord un jeton dans votre profil, section <strong>Publication depuis le CLI</strong>. Ensuite, connectez le CLI et publiez le fichier.</p>
        <div class="cli-ref-copy-wrap">
            <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-ref-code">learning login
learning publish design.json</pre>
        </div>
        <p class="cli-ref-copy"<?= cli_ref_i18n_attrs('Pour mettre à jour une publication existante, gardez l’identifiant renvoyé lors de la première publication.', 'To update an existing publication, keep the identifier returned by the first publication.') ?>>Pour mettre à jour une publication existante, gardez l’identifiant renvoyé lors de la première publication.</p>
        <div class="cli-ref-copy-wrap">
            <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-ref-code">learning publish design.json --design-id 123</pre>
        </div>
        <div class="cli-ref-note"<?= cli_ref_i18n_attrs('Le jeton CLI est personnel. Il permet de publier sur votre compte : ne le transmettez à l’IA que si vous voulez explicitement qu’elle publie à votre place.', 'The CLI token is personal. It can publish to your account: only give it to the AI if you explicitly want it to publish on your behalf.') ?>>Le jeton CLI est personnel. Il permet de publier sur votre compte : ne le transmettez à l’IA que si vous voulez explicitement qu’elle publie à votre place.</div>
    </section>

    <section class="cli-ref-section">
        <h2><span<?= cli_ref_i18n_attrs('Commandes utiles', 'Useful commands') ?>>Commandes utiles</span></h2>
        <div class="cli-ref-copy-wrap">
            <button class="cli-ref-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= cli_ref_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-ref-code">learning --help
learning list types
learning list bloom
learning list competencies
learning status
learning upgrade</pre>
        </div>
    </section>
</main>
<?php render_site_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function applyCliRefLanguage(lang) {
        lang = lang === 'en' ? 'en' : 'fr';
        document.documentElement.lang = lang;
        document.title = lang === 'en' ? 'CLI details | Learning Designer' : 'CLI détaillé | Learning Designer';
        document.querySelectorAll('[data-cli-ref-i18n-en]').forEach(function (el) {
            var value = lang === 'en' ? el.dataset.cliRefI18nEn : el.dataset.cliRefI18nFr;
            if (!value) return;
            var attrList = (el.dataset.cliRefI18nAttr || '').split(',').map(function (attr) {
                return attr.trim();
            }).filter(Boolean);
            if (attrList.length) {
                attrList.forEach(function (attr) {
                    el.setAttribute(attr, value);
                });
            } else if (el.dataset.cliRefI18nHtml === '1') {
                el.innerHTML = value;
            } else {
                el.textContent = value;
            }
        });
    }

    var currentLang = 'fr';
    try {
        currentLang = localStorage.getItem('learningDesignerLang') || 'fr';
    } catch (error) {
        currentLang = 'fr';
    }
    applyCliRefLanguage(currentLang);

    var langSelect = document.getElementById('lang-select');
    if (langSelect) {
        langSelect.addEventListener('change', function () {
            applyCliRefLanguage(langSelect.value);
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

    document.querySelectorAll('.cli-ref-copy-wrap .cli-ref-copy-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var code = button.parentElement.querySelector('.cli-ref-code');
            if (code) copyText(code.textContent.trim(), button);
        });
    });
});
</script>
</body>
</html>
