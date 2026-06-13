<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

function skill_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function skill_i18n_attrs(string $fr, string $en, bool $html = false): string
{
    $attrs = ' data-skill-i18n-fr="' . skill_h($fr) . '" data-skill-i18n-en="' . skill_h($en) . '"';
    if ($html) {
        $attrs .= ' data-skill-i18n-html="1"';
    }
    return $attrs;
}

function skill_i18n_attr_attrs(string $attr, string $fr, string $en): string
{
    return ' data-skill-i18n-attr="' . skill_h($attr) . '" data-skill-i18n-fr="' . skill_h($fr) . '" data-skill-i18n-en="' . skill_h($en) . '"';
}

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
    <title>Skill Claude | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260520-2">
    <link rel="stylesheet" href="account-ui.css?v=20260520-4">
    <link rel="stylesheet" href="account-pages.css?v=20260521-width">
    <style>
        body.skill-page {
            background: #fff;
        }
        .skill-shell {
            width: min(var(--content-shell-width, 1180px), calc(100vw - var(--content-shell-gutter, 36px)));
            margin: 0 auto;
            padding: 28px 0 56px;
        }
        .skill-hero {
            display: grid;
            gap: 14px;
            margin-bottom: 26px;
        }
        .skill-title {
            display: flex;
            align-items: center;
            gap: 18px;
            margin: 0;
            color: var(--text);
            font-size: clamp(32px, 5vw, 58px);
            line-height: 1.02;
            letter-spacing: 0;
        }
        .skill-title i {
            flex: 0 0 auto;
            font-size: 0.5em;
            line-height: 1;
        }
        .skill-subtitle {
            max-width: 980px;
            margin: 0;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.65;
        }
        .skill-section {
            margin-top: 24px;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            box-shadow: 0 12px 28px rgba(0,0,0,0.06);
        }
        .skill-section h2,
        .skill-section h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 14px;
            color: var(--text);
            letter-spacing: 0;
        }
        .skill-section h2 {
            font-size: 24px;
        }
        .skill-section h3 {
            font-size: 18px;
        }
        .skill-section h3:not(:first-child) {
            margin-top: 22px;
        }
        .skill-copy {
            color: var(--muted);
            line-height: 1.65;
        }
        .skill-steps {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 18px;
        }
        .skill-step {
            min-height: 138px;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel-2);
        }
        .skill-step i {
            display: inline-grid;
            place-items: center;
            width: 34px;
            height: 34px;
            margin-bottom: 12px;
            border-radius: 8px;
            background: rgba(56, 139, 253, 0.12);
            color: var(--primary);
        }
        .skill-step strong {
            display: block;
            margin-bottom: 6px;
            color: var(--text);
            font-size: 15px;
        }
        .skill-step span {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.45;
        }
        .skill-code,
        .skill-prompt {
            overflow-x: auto;
            width: 100%;
            box-sizing: border-box;
            margin: 14px 0 18px;
            padding: 16px;
            border: 1px solid transparent;
            border-radius: 8px;
            background: #0b1020;
            color: #e5edf8;
            font: 13px/1.55 ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            white-space: pre;
        }
        .skill-prompt {
            min-height: 150px;
            resize: vertical;
        }
        .skill-copy-wrap,
        .skill-prompt-wrap {
            position: relative;
        }
        .skill-copy-wrap .skill-code,
        .skill-prompt-wrap .skill-prompt {
            padding-right: 54px;
        }
        .skill-copy-btn {
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
        .skill-copy-btn:hover,
        .skill-copy-btn:focus-visible {
            background: rgba(255,255,255,0.16);
            outline: none;
        }
        .skill-note {
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
        .skill-note i {
            color: var(--primary);
            margin-top: 3px;
        }
        [data-theme="dark"] body.skill-page {
            background:
                radial-gradient(circle at top left, rgba(56, 139, 253, 0.10), transparent 28%),
                linear-gradient(180deg, #1f2537 0%, #1a1f2e 100%);
        }
        [data-theme="dark"] .skill-title,
        [data-theme="dark"] .skill-title span,
        [data-theme="dark"] .skill-section h2,
        [data-theme="dark"] .skill-section h3,
        [data-theme="dark"] .skill-step strong {
            color: #f3f6ff;
        }
        [data-theme="dark"] .skill-section {
            background: linear-gradient(180deg, rgba(36, 43, 64, 0.96), rgba(30, 36, 54, 0.96));
            border-color: rgba(103, 116, 145, 0.45);
        }
        [data-theme="dark"] .skill-step {
            background: rgba(26, 31, 46, 0.78);
            border-color: rgba(103, 116, 145, 0.38);
        }
        [data-theme="dark"] .skill-subtitle,
        [data-theme="dark"] .skill-copy,
        [data-theme="dark"] .skill-step span {
            color: var(--text-body);
        }
        [data-theme="dark"] .skill-note {
            background: rgba(140, 198, 255, 0.12);
            color: var(--text-body);
        }
        @media (max-width: 900px) {
            .skill-steps {
                grid-template-columns: 1fr;
            }
            .skill-shell {
                padding-top: 24px;
            }
        }
    </style>
</head>
<body class="skill-page">
<?php render_site_nav('skill'); ?>
<main class="skill-shell">
    <header class="skill-hero">
        <h1 class="skill-title"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> <span<?= skill_i18n_attrs('Créer une skill Claude', 'Create a Claude skill') ?>>Créer une skill Claude</span></h1>
        <p class="skill-subtitle"<?= skill_i18n_attrs('Une skill permet de donner à Claude Code une méthode réutilisable. Pour Learning Designer, elle lui explique comment créer un design avec le CLI, le valider, puis préparer la publication.', 'A skill gives Claude Code a reusable method. For Learning Designer, it explains how to create a design with the CLI, validate it, then prepare publishing.') ?>>Une skill permet de donner à Claude Code une méthode réutilisable. Pour Learning Designer, elle lui explique comment créer un design avec le CLI, le valider, puis préparer la publication.</p>
    </header>

    <section class="skill-section">
        <h2><i class="fa-solid fa-download" aria-hidden="true"></i> <span<?= skill_i18n_attrs('Installer la skill publiée', 'Install the published skill') ?>>Installer la skill publiée</span></h2>
        <p class="skill-copy"<?= skill_i18n_attrs('C’est la méthode la plus simple : elle crée le bon dossier Claude Code et télécharge le fichier <code>SKILL.md</code> déjà prêt.', 'This is the simplest method: it creates the right Claude Code folder and downloads the ready-made <code>SKILL.md</code> file.', true) ?>>C’est la méthode la plus simple : elle crée le bon dossier Claude Code et télécharge le fichier <code>SKILL.md</code> déjà prêt.</p>
        <div class="skill-copy-wrap">
            <button class="skill-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= skill_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="skill-code">mkdir -p .claude/skills/learning-design
curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/skills/learning-designer/SKILL.md -o .claude/skills/learning-design/SKILL.md</pre>
        </div>
        <p class="skill-copy"<?= skill_i18n_attrs('Relancez Claude Code si la commande slash n’apparaît pas tout de suite, puis lancez la skill avec :', 'Restart Claude Code if the slash command does not appear immediately, then launch the skill with:') ?>>Relancez Claude Code si la commande slash n’apparaît pas tout de suite, puis lancez la skill avec :</p>
        <div class="skill-copy-wrap">
            <button class="skill-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= skill_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="skill-code">/learning-design</pre>
        </div>
    </section>

    <section class="skill-section">
        <h2><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> <span<?= skill_i18n_attrs('Créer la skill manuellement', 'Create the skill manually') ?>>Créer la skill manuellement</span></h2>
        <div class="skill-steps">
            <div class="skill-step">
                <i class="fa-solid fa-folder-plus" aria-hidden="true"></i>
                <strong<?= skill_i18n_attrs('1. Créer le dossier', '1. Create the folder') ?>>1. Créer le dossier</strong>
                <span<?= skill_i18n_attrs('Dans votre projet, créez <code>.claude/skills/learning-design</code>.', 'In your project, create <code>.claude/skills/learning-design</code>.', true) ?>>Dans votre projet, créez <code>.claude/skills/learning-design</code>.</span>
            </div>
            <div class="skill-step">
                <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                <strong<?= skill_i18n_attrs('2. Ajouter SKILL.md', '2. Add SKILL.md') ?>>2. Ajouter SKILL.md</strong>
                <span<?= skill_i18n_attrs('Le fichier doit s’appeler <code>SKILL.md</code>, au singulier.', 'The file must be named <code>SKILL.md</code>, singular.', true) ?>>Le fichier doit s’appeler <code>SKILL.md</code>, au singulier.</span>
            </div>
            <div class="skill-step">
                <i class="fa-solid fa-terminal" aria-hidden="true"></i>
                <strong<?= skill_i18n_attrs('3. Lancer la skill', '3. Run the skill') ?>>3. Lancer la skill</strong>
                <span<?= skill_i18n_attrs('Dans Claude Code, tapez <code>/learning-design</code>.', 'In Claude Code, type <code>/learning-design</code>.', true) ?>>Dans Claude Code, tapez <code>/learning-design</code>.</span>
            </div>
        </div>
        <p class="skill-copy"<?= skill_i18n_attrs('Depuis la racine de votre projet :', 'From your project root:') ?>>Depuis la racine de votre projet :</p>
        <div class="skill-copy-wrap">
            <button class="skill-copy-btn" type="button" aria-label="Copier la commande" title="Copier"<?= skill_i18n_attr_attrs('aria-label,title', 'Copier la commande', 'Copy command') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="skill-code">mkdir -p .claude/skills/learning-design
code .claude/skills/learning-design/SKILL.md</pre>
        </div>
        <p class="skill-copy"<?= skill_i18n_attrs('Dans <code>SKILL.md</code>, commencez par ce modèle, puis ajoutez les consignes complètes de votre méthode.', 'In <code>SKILL.md</code>, start with this template, then add the full instructions for your method.', true) ?>>Dans <code>SKILL.md</code>, commencez par ce modèle, puis ajoutez les consignes complètes de votre méthode.</p>
        <div class="skill-copy-wrap">
            <button class="skill-copy-btn" type="button" aria-label="Copier le modèle" title="Copier"<?= skill_i18n_attr_attrs('aria-label,title', 'Copier le modèle', 'Copy template') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="skill-code">---
description: Crée un fichier design.json Learning Designer avec le CLI learning, pose les questions pédagogiques utiles, valide le fichier et prépare les commandes de publication.
---

# Learning Designer

Collez ici les consignes complètes que Claude doit suivre.</pre>
        </div>
        <div class="skill-note">
            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
            <div<?= skill_i18n_attrs('Le chemin attendu par Claude Code est <code>.claude/skills/learning-design/SKILL.md</code>. Le dossier <code>skills</code> et le nom <code>SKILL.md</code> sont importants.', 'The path expected by Claude Code is <code>.claude/skills/learning-design/SKILL.md</code>. The <code>skills</code> folder and the <code>SKILL.md</code> filename matter.', true) ?>>Le chemin attendu par Claude Code est <code>.claude/skills/learning-design/SKILL.md</code>. Le dossier <code>skills</code> et le nom <code>SKILL.md</code> sont importants.</div>
        </div>
    </section>

    <section class="skill-section">
        <h2><i class="fa-solid fa-message" aria-hidden="true"></i> <span<?= skill_i18n_attrs('Usage ponctuel sans installation', 'One-off use without installation') ?>>Usage ponctuel sans installation</span></h2>
        <p class="skill-copy"<?= skill_i18n_attrs('Si vous ne voulez pas installer de skill locale, copiez simplement ce prompt dans Claude ou Codex. L’IA ira lire la méthode publiée.', 'If you do not want to install a local skill, simply copy this prompt into Claude or Codex. The AI will read the published method.') ?>>Si vous ne voulez pas installer de skill locale, copiez simplement ce prompt dans Claude ou Codex. L’IA ira lire la méthode publiée.</p>
        <div class="skill-prompt-wrap">
            <button class="skill-copy-btn" type="button" id="copy-skill-prompt-btn" aria-label="Copier le prompt" title="Copier"<?= skill_i18n_attr_attrs('aria-label,title', 'Copier le prompt', 'Copy prompt') ?>><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <textarea class="skill-prompt" id="skill-prompt" readonly><?= skill_h($skillPrompt) ?></textarea>
        </div>
    </section>
</main>
<?php render_site_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var promptTexts = {
        fr: <?= json_encode($skillPrompt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
        en: <?= json_encode($skillPromptEn, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
    };

    function applySkillLanguage(lang) {
        lang = lang === 'en' ? 'en' : 'fr';
        document.documentElement.lang = lang;
        document.title = lang === 'en' ? 'Claude skill | Learning Designer' : 'Skill Claude | Learning Designer';
        document.querySelectorAll('[data-skill-i18n-en]').forEach(function (el) {
            var value = lang === 'en' ? el.dataset.skillI18nEn : el.dataset.skillI18nFr;
            if (!value) return;
            var attrList = (el.dataset.skillI18nAttr || '').split(',').map(function (attr) {
                return attr.trim();
            }).filter(Boolean);
            if (attrList.length) {
                attrList.forEach(function (attr) {
                    el.setAttribute(attr, value);
                });
            } else if (el.dataset.skillI18nHtml === '1') {
                el.innerHTML = value;
            } else {
                el.textContent = value;
            }
        });

        var prompt = document.getElementById('skill-prompt');
        if (prompt) prompt.value = promptTexts[lang];
    }

    var currentLang = 'fr';
    try {
        currentLang = localStorage.getItem('learningDesignerLang') || 'fr';
    } catch (error) {
        currentLang = 'fr';
    }
    applySkillLanguage(currentLang);

    var langSelect = document.getElementById('lang-select');
    if (langSelect) {
        langSelect.addEventListener('change', function () {
            applySkillLanguage(langSelect.value);
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

    document.querySelectorAll('.skill-copy-wrap .skill-copy-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var code = button.parentElement.querySelector('.skill-code');
            if (code) copyText(code.textContent.trim(), button);
        });
    });

    var promptButton = document.getElementById('copy-skill-prompt-btn');
    var promptTextarea = document.getElementById('skill-prompt');
    if (promptButton && promptTextarea) {
        promptButton.addEventListener('click', function () {
            copyText(promptTextarea.value, promptButton);
        });
    }
});
</script>
</body>
</html>
