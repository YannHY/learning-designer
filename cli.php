<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

function cli_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
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

Mission :
Créer un fichier `design.json` complet, structuré et importable dans Learning Designer.

Commence par me poser les questions nécessaires en français :
- sujet ou thème de la séance/séquence ;
- niveau et public cible ;
- durée totale ;
- modalité : présentiel, distanciel ou hybride ;
- taille du groupe ;
- objectifs d’enseignement : ce que je veux faire travailler, transmettre ou entraîner ;
- acquis d’apprentissage attendus : ce que les élèves devront être capables de faire à la fin ;
- niveau Bloom souhaité pour chaque acquis, si je le connais ;
- compétences numériques à mobiliser, si pertinent ;
- contraintes matérielles, pédagogiques ou institutionnelles ;
- niveau de détail souhaité.

Distingue bien :
- les objectifs d’enseignement, qui décrivent mon intention pédagogique ;
- les acquis d’apprentissage, qui décrivent ce que les élèves sauront faire à la fin.

Si je donne seulement des objectifs d’enseignement, transforme-les en acquis d’apprentissage observables, formulés avec des verbes d’action et reliés à la taxonomie de Bloom.

Ensuite utilise le CLI, pas une écriture manuelle du JSON.

Commandes à utiliser :
- ./.tools/bin/learning init
- ./.tools/bin/learning add-moment
- ./.tools/bin/learning add-activity
- ./.tools/bin/learning outcome
- ./.tools/bin/learning validate design.json
- ./.tools/bin/learning prompt design.json

À la fin, restitue-moi :
- le chemin du fichier `design.json` ;
- le nombre de moments ;
- le nombre d’activités ;
- les objectifs d’enseignement pris en compte ;
- les acquis Bloom créés ;
- les compétences numériques mobilisées ;
- la répartition des durées ;
- le contenu ou le fichier `design.json`.

Publication :
Ne publie pas directement depuis ton sandbox sauf si je te donne explicitement un jeton CLI.
Pour publier depuis mon Mac, indique-moi simplement :

learning publish design.json

Règles importantes :
- Utilise le CLI autant que possible.
- N’écris pas le JSON à la main sauf si le CLI est impossible à utiliser après plusieurs tentatives.
- Si une commande échoue, explique pourquoi, corrige-la et recommence.
- Une fois `.tools/bin/learning` créé, ne dépends plus du réseau.
- Travaille progressivement : pose d’abord les questions nécessaires, puis exécute les commandes.
PROMPT;
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CLI et IA | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260502-2">
    <link rel="stylesheet" href="account-ui.css?v=20260502-2">
    <link rel="stylesheet" href="account-pages.css?v=20260506">
    <style>
        body.cli-page {
            background: #fff;
        }
        .cli-shell {
            max-width: 1120px;
            margin: 0 auto;
            padding: 104px 20px 56px;
        }
        .cli-hero {
            display: grid;
            gap: 10px;
            margin-bottom: 26px;
        }
        .cli-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            color: var(--primary);
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .cli-title {
            margin: 0;
            color: var(--text);
            font-size: clamp(32px, 5vw, 58px);
            line-height: 1.02;
            letter-spacing: 0;
        }
        .cli-subtitle {
            max-width: 780px;
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
                padding-top: 92px;
            }
        }
    </style>
</head>
<body class="cli-page">
<?php render_site_nav('cli'); ?>
<main class="cli-shell">
    <header class="cli-hero">
        <p class="cli-kicker"><i class="fa-solid fa-code" aria-hidden="true"></i> CLI et IA</p>
        <h1 class="cli-title">Créer avec l’IA</h1>
        <p class="cli-subtitle">Installez la commande, demandez à Claude ou Codex de préparer le fichier, puis publiez le design en ligne avec une seule ligne.</p>
        <nav class="cli-anchor-list" aria-label="Sections de la page">
            <a href="#express"><i class="fa-solid fa-bolt" aria-hidden="true"></i> Version courte</a>
            <a href="#detail"><i class="fa-solid fa-list-check" aria-hidden="true"></i> Guide détaillé</a>
            <a href="#prompt"><i class="fa-solid fa-message" aria-hidden="true"></i> Prompt IA</a>
        </nav>
    </header>

    <section id="express" class="cli-section">
        <h2><i class="fa-solid fa-bolt" aria-hidden="true"></i> Version courte</h2>
        <p class="cli-copy">Pour un usage normal, il suffit de suivre ces quatre étapes.</p>
        <div class="cli-steps">
            <div class="cli-step">
                <i class="fa-solid fa-download" aria-hidden="true"></i>
                <strong>1. Installer</strong>
                <span>À faire une seule fois sur votre ordinateur.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-key" aria-hidden="true"></i>
                <strong>2. Connecter</strong>
                <span>Créer un jeton dans le profil, puis le coller dans le terminal.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-robot" aria-hidden="true"></i>
                <strong>3. Créer</strong>
                <span>Donner le prompt à Claude ou Codex pour obtenir un fichier <code>design.json</code>.</span>
            </div>
            <div class="cli-step">
                <i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
                <strong>4. Publier</strong>
                <span>Une commande publie le design et renvoie le lien public.</span>
            </div>
        </div>
        <div class="cli-copy-wrap">
            <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <pre class="cli-code">curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/install.sh | sh
learning login
learning publish ~/Desktop/design.json</pre>
        </div>
        <div class="cli-note">
            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
            <div>Le jeton CLI est personnel. Il ne faut pas le donner à une IA sauf si vous voulez explicitement qu’elle publie à votre place.</div>
        </div>
    </section>

    <section id="detail" class="cli-section">
        <h2><i class="fa-solid fa-list-check" aria-hidden="true"></i> Guide détaillé</h2>
        <div class="cli-details-grid">
            <div>
                <h3><i class="fa-solid fa-download" aria-hidden="true"></i> Installer ou mettre à jour</h3>
                <p class="cli-copy">La commande suivante installe <code>learning</code>. Si elle est déjà installée, utilisez ensuite <code>learning upgrade</code> pour la mettre à jour.</p>
                <div class="cli-copy-wrap">
                    <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-code">curl -fsSL https://raw.githubusercontent.com/YannHY/learning-designer/main/install.sh | sh
learning upgrade
learning status</pre>
                </div>
            </div>
            <div>
                <h3><i class="fa-solid fa-key" aria-hidden="true"></i> Créer le jeton</h3>
                <p class="cli-copy">Dans votre profil, créez un jeton dans la section <strong>Publication depuis le CLI</strong>. Copiez-le tout de suite : il ne sera affiché qu’une seule fois.</p>
                <div class="cli-copy-wrap">
                    <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-code">learning login</pre>
                </div>
            </div>
            <div>
                <h3><i class="fa-solid fa-file-code" aria-hidden="true"></i> Vérifier le fichier</h3>
                <p class="cli-copy">Quand Claude ou Codex vous donne <code>design.json</code>, vérifiez-le avant la publication.</p>
                <div class="cli-copy-wrap">
                    <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-code">learning validate ~/Desktop/design.json</pre>
                </div>
            </div>
            <div>
                <h3><i class="fa-solid fa-globe" aria-hidden="true"></i> Publier</h3>
                <p class="cli-copy">La publication renvoie une URL publique. Gardez aussi le <strong>Design ID</strong> si vous voulez mettre à jour la même publication plus tard.</p>
                <div class="cli-copy-wrap">
                    <button class="cli-copy-btn" type="button" aria-label="Copier la commande" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
                    <pre class="cli-code">learning publish ~/Desktop/design.json
learning publish ~/Desktop/design.json --design-id 123</pre>
                </div>
            </div>
        </div>
    </section>

    <section id="prompt" class="cli-section">
        <h2><i class="fa-solid fa-message" aria-hidden="true"></i> Prompt à donner à Claude ou Codex</h2>
        <p class="cli-copy">Copiez ce prompt dans Claude ou Codex. Il demande à l’IA d’utiliser le CLI, de poser les bonnes questions pédagogiques, puis de produire un fichier validé.</p>
        <div class="cli-prompt-wrap">
            <button class="cli-copy-btn" type="button" id="copy-prompt-btn" aria-label="Copier le prompt" title="Copier"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
            <textarea class="cli-prompt" id="ai-prompt" readonly><?= cli_h($prompt) ?></textarea>
        </div>
    </section>
</main>
<?php render_site_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
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
