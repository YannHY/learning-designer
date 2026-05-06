<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

$token = trim((string)($_GET['token'] ?? ''));
if ($token === '') {
    http_response_code(400);
    echo 'Lien invalide.';
    exit;
}

$db = app_db();
$stmt = $db->prepare("SELECT id, title, document_json, updated_at FROM learning_designs WHERE share_token = ? AND is_published = 1 LIMIT 1");
$stmt->execute([$token]);
$row = $stmt->fetch();
if (!$row) {
    http_response_code(404);
    echo 'Cette production n\'est pas disponible ou son lien de partage a été révoqué.';
    exit;
}

$document = json_decode((string)$row['document_json'], true);
if (!is_array($document)) {
    $document = ['sessions' => [], 'meta' => []];
}

$meta     = is_array($document['meta'] ?? null) ? $document['meta'] : [];
$sessions = is_array($document['sessions'] ?? null) ? $document['sessions'] : [];
$title    = trim((string)($meta['name'] ?? ''));
if ($title === '') {
    $title = (string)$row['title'];
}
if ($title === '') {
    $title = 'Production sans titre';
}

$updatedAt = '';
try {
    $dt = new DateTimeImmutable((string)$row['updated_at'], new DateTimeZone('UTC'));
    $updatedAt = $dt->setTimezone(new DateTimeZone('Europe/Paris'))->format('d/m/Y H:i');
} catch (Exception) {}

// ── Label maps ───────────────────────────────────────────────
$LEARNING_TYPES = [
    'undefined'   => ['label' => 'Non défini',               'color' => '#d1d5db'],
    'read'        => ['label' => 'Lire / Regarder / Écouter', 'color' => '#a1f5ed'],
    'investigate' => ['label' => 'Investiguer',              'color' => '#f8807f'],
    'practice'    => ['label' => 'Pratiquer',                'color' => '#bb98dc'],
    'produce'     => ['label' => 'Produire',                 'color' => '#bdea75'],
    'discuss'     => ['label' => 'Discuter',                 'color' => '#7aaeea'],
    'collaborate' => ['label' => 'Collaborer',               'color' => '#ffd966'],
];
$GROUP_MODES    = ['whole' => 'Groupe entier', 'subgroups' => 'Sous-groupes', 'individual' => 'Individuel'];
$TRAINER_MODES  = ['present' => 'Enseignant présent', 'absent' => 'Enseignant absent'];
$SYNC_MODES     = ['sync' => 'Synchrone', 'async' => 'Asynchrone'];
$LOCATION_MODES = ['onsite' => 'Présentiel', 'online' => 'Distanciel', 'hybrid' => 'Hybride'];
$DELIVERY_MODES = ['onsite' => 'Présentiel', 'online' => 'Distanciel', 'hybrid' => 'Hybride'];
$EVAL_MODES     = [
    'none'          => null,
    'diagnostic'    => 'Diagnostique',
    'formative'     => 'Formative',
    'summative'     => 'Sommative',
    'certificative' => 'Certificative',
];

$TOOLS_LABELS = [
    'moodle:workshop'          => 'Atelier',
    'moodle:database'          => 'Base de données',
    'moodle:bigbluebutton'     => 'BigBlueButton',
    'moodle:capytale'          => 'Capytale',
    'moodle:chat'              => 'Chat',
    'moodle:group-choice'      => 'Choix de groupe',
    'moodle:assignment'        => 'Devoir',
    'moodle:collaborative-doc' => 'Document collaboratif',
    'moodle:folder'            => 'Dossier',
    'moodle:etherpad'          => 'Etherpad Lite',
    'moodle:file'              => 'Fichier',
    'moodle:forum'             => 'Forum',
    'moodle:glossary'          => 'Glossaire',
    'moodle:lesson'            => 'Leçon',
    'moodle:book'              => 'Livre',
    'moodle:module'            => 'Module',
    'moodle:word-cloud'        => 'Nuage de mots',
    'moodle:page'              => 'Page',
    'moodle:file-share'        => 'Partage de fichiers',
    'moodle:feedback'          => 'Questionnaire',
    'moodle:choice'            => 'Sondage',
    'moodle:sticky-notes'      => 'Sticky Notes',
    'moodle:tableau'           => 'Tableau',
    'moodle:quiz'              => 'Test (quiz)',
    'moodle:url'               => 'URL',
    'moodle:wiki'              => 'Wiki',
    'moodle:text-media'        => 'Zone texte et média',
    'h5p:interactive-video'    => 'Vidéo interactive',
    'h5p:course-presentation'  => 'Présentation de cours',
    'h5p:branching-scenario'   => 'Scénario ramifié',
    'h5p:accordion'            => 'Accordéon',
    'h5p:advent-calendar'      => "Calendrier de l'Avent",
    'h5p:agamotto'             => 'Agamotto',
    'h5p:ar-scavenger'         => 'Chasse au trésor en RA',
    'h5p:arithmetic-quiz'      => 'Quiz arithmétique',
    'h5p:audio-recorder'       => 'Enregistreur audio',
    'h5p:chart'                => 'Graphique',
    'h5p:collage'              => 'Collage',
    'h5p:complex-fill-blanks'  => 'Texte à trous complexe',
    'h5p:cornell-notes'        => 'Notes Cornell',
    'h5p:crossword'            => 'Mots croisés',
    'h5p:dialog-cards'         => 'Cartes dialogues',
    'h5p:dictation'            => 'Dictée',
    'h5p:documentation-tool'   => 'Outil de documentation',
    'h5p:drag-and-drop'        => 'Glisser-déposer',
    'h5p:drag-the-words'       => 'Glisser les mots',
    'h5p:essay'                => 'Essai',
    'h5p:fill-in-the-blanks'   => 'Texte à trous',
    'h5p:find-multiple-hotspots'=> 'Trouver plusieurs zones',
    'h5p:find-the-hotspot'     => 'Trouver la zone',
    'h5p:find-the-words'       => 'Cherche les mots',
    'h5p:flashcards'           => 'Cartes mémoire',
    'h5p:game-map'             => 'Carte de jeu',
    'h5p:guess-the-answer'     => 'Devinez la réponse',
    'h5p:iframe-embedder'      => 'Intégrateur Iframe',
    'h5p:image-hotspots'       => 'Zones interactives sur image',
    'h5p:image-juxtaposition'  => "Juxtaposition d'images",
    'h5p:image-pairing'        => "Appariement d'images",
    'h5p:image-sequencing'     => "Séquence d'images",
    'h5p:image-slider'         => "Diaporama d'images",
    'h5p:impressive-presentation'=> 'Présentation impressionnante',
    'h5p:information-wall'     => "Mur d'informations",
    'h5p:interactive-book'     => 'Livre interactif',
    'h5p:kewar-code'           => 'Code QR (KewAr)',
    'h5p:mark-the-words'       => 'Surligner les mots',
    'h5p:memory-game'          => 'Jeu de mémoire',
    'h5p:multiple-choice'      => 'Choix multiple',
    'h5p:multimedia-choice'    => 'Choix multimédia',
    'h5p:page'                 => 'Page H5P',
    'h5p:personality-quiz'     => 'Quiz de personnalité',
    'h5p:questionnaire'        => 'Questionnaire H5P',
    'h5p:question-set'         => 'Quiz (ensemble de questions)',
    'h5p:single-choice-set'    => 'Choix unique',
    'h5p:sort-the-paragraphs'  => 'Trier les paragraphes',
    'h5p:speak-the-words'      => 'Parle les mots',
    'h5p:speak-the-words-set'  => 'Ensemble vocal',
    'h5p:structure-strip'      => 'Bande de structure',
    'h5p:summary'              => 'Résumé',
    'h5p:timeline'             => 'Frise chronologique',
    'h5p:true-false-question'  => 'Question vrai/faux',
    'h5p:virtual-tour'         => 'Visite virtuelle (360°)',
];

function safeText(mixed $value): string {
    if (is_array($value) || is_object($value)) return '';
    $s = trim((string)$value);
    if ($s === '[object Object]') return '';
    return $s;
}

function esc(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function safeEsc(mixed $v): string {
    return esc(safeText($v));
}

function inlineMarkdown(string $text): string {
    $html = esc($text);
    $html = preg_replace('/\*\*([^*\n]+)\*\*/u', '<strong>$1</strong>', $html) ?? $html;
    $html = preg_replace('/(^|[^*])\*([^*\n]+)\*/u', '$1<em>$2</em>', $html) ?? $html;
    return $html;
}

function markdownHtml(string $text): string {
    $lines = preg_split('/\R/u', $text) ?: [];
    $html = [];
    $paragraph = [];
    $listType = '';

    $closeParagraph = function () use (&$html, &$paragraph): void {
        if (!$paragraph) return;
        $html[] = '<p>' . implode('<br>', array_map('inlineMarkdown', $paragraph)) . '</p>';
        $paragraph = [];
    };
    $closeList = function () use (&$html, &$listType): void {
        if ($listType === '') return;
        $html[] = '</' . $listType . '>';
        $listType = '';
    };
    $openList = function (string $type) use (&$html, &$listType, $closeParagraph, $closeList): void {
        $closeParagraph();
        if ($listType === $type) return;
        $closeList();
        $html[] = '<' . $type . '>';
        $listType = $type;
    };

    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '') {
            $closeParagraph();
            $closeList();
            continue;
        }

        if (preg_match('/^##\s+(.+)$/u', $trimmed, $m)) {
            $closeParagraph();
            $closeList();
            $html[] = '<h2>' . inlineMarkdown($m[1]) . '</h2>';
            continue;
        }

        if (preg_match('/^[-*]\s+(.+)$/u', $trimmed, $m)) {
            $openList('ul');
            $html[] = '<li>' . inlineMarkdown($m[1]) . '</li>';
            continue;
        }

        if (preg_match('/^\d+\.\s+(.+)$/u', $trimmed, $m)) {
            $openList('ol');
            $html[] = '<li>' . inlineMarkdown($m[1]) . '</li>';
            continue;
        }

        if (preg_match('/^>\s?(.+)$/u', $trimmed, $m)) {
            $closeParagraph();
            $closeList();
            $html[] = '<blockquote>' . inlineMarkdown($m[1]) . '</blockquote>';
            continue;
        }

        $closeList();
        $paragraph[] = $line;
    }

    $closeParagraph();
    $closeList();
    return implode('', $html);
}

function labelFor(array $map, string $key, string $fallback = ''): string {
    return $map[$key] ?? ($fallback !== '' ? $fallback : $key);
}

function normalizeCatalogSlug(string $value): string {
    $value = trim($value);
    $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
    if (is_string($transliterated)) {
        $value = $transliterated;
    }
    $value = strtolower($value);
    $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
    $value = trim($value, '-');
    return $value !== '' ? $value : 'general';
}

function toRomanNumeral(int $value): string {
    if ($value <= 0) return '';
    $map = [
        1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD',
        100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL',
        10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I',
    ];
    $result = '';
    foreach ($map as $amount => $symbol) {
        while ($value >= $amount) {
            $result .= $symbol;
            $value -= $amount;
        }
    }
    return $result;
}

function normalizeCompetencyToken(string $value): string {
    $value = trim($value);
    $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
    if (is_string($transliterated)) {
        $value = $transliterated;
    }
    return strtolower(preg_replace('/[^a-z0-9]+/', '', $value) ?? '');
}

function loadCompetencyCatalog(): array {
    static $catalog = null;
    if (is_array($catalog)) return $catalog;

    $catalog = [];
    $sourcePath = __DIR__ . '/interface.js';
    $js = is_file($sourcePath) ? file_get_contents($sourcePath) : '';
    if (!is_string($js) || !preg_match('/const\s+COMPETENCY_CATALOG_SOURCE\s*=\s*String\.raw`(.*?)`;/s', $js, $matches)) {
        return $catalog;
    }

    $badgeByLevel = ['acquerir' => 'N1', 'approfondir' => 'N2', 'creer' => 'N3'];
    $legacyCodeByLevel = ['acquerir' => 'A', 'approfondir' => 'P', 'creer' => 'C'];
    $currentLevel = null;
    $currentLevelSections = [];

    foreach (preg_split('/\R/', (string)$matches[1]) ?: [] as $rawLine) {
        $line = str_replace("\r", '', (string)$rawLine);
        if (trim($line) === '') continue;

        if (str_starts_with($line, '# ')) {
            [$id, $labelFr, $labelEn] = array_pad(explode("\t", substr($line, 2)), 3, '');
            $currentLevel = ['id' => $id, 'labelFr' => $labelFr, 'labelEn' => $labelEn];
            $currentLevelSections = [];
            continue;
        }

        if (!is_array($currentLevel)) continue;
        $parts = explode("\t", $line);
        [$sectionRaw, $appRaw, $numberRaw, $labelRaw] = array_pad(array_slice($parts, 0, 4), 4, '');
        $descRaw = implode("\t", array_slice($parts, 4));
        $section = trim($sectionRaw) !== '' ? trim($sectionRaw) : 'Général';
        $sectionIndex = array_search($section, $currentLevelSections, true);
        if ($sectionIndex === false) {
            $currentLevelSections[] = $section;
            $sectionIndex = count($currentLevelSections) - 1;
        }
        $sectionNumber = (int)$sectionIndex + 1;
        $sectionRoman = toRomanNumeral($sectionNumber);
        $competencyNumber = (int)$numberRaw;
        $label = trim($labelRaw);
        $description = trim($descRaw);
        if ($competencyNumber <= 0 || $label === '' || $description === '') continue;

        $id = 'competency:' . $currentLevel['id'] . ':' . trim($numberRaw);
        $shortCode = $currentLevel['labelFr'] . '-' . $sectionRoman . '-' . $competencyNumber;
        $legacyShortCode = ($legacyCodeByLevel[$currentLevel['id']] ?? substr($currentLevel['id'], 0, 1)) . $competencyNumber;
        $entry = [
            'id' => $id,
            'platform' => $currentLevel['id'],
            'category' => $currentLevel['id'] . ':' . normalizeCatalogSlug($section),
            'sectionFr' => $section,
            'sectionEn' => $section,
            'appFr' => trim($appRaw),
            'appEn' => trim($appRaw),
            'levelLabelFr' => $currentLevel['labelFr'],
            'levelLabelEn' => $currentLevel['labelEn'],
            'levelBadge' => $badgeByLevel[$currentLevel['id']] ?? $currentLevel['id'],
            'number' => $competencyNumber,
            'sectionNumber' => $sectionNumber,
            'sectionRoman' => $sectionRoman,
            'shortCode' => $shortCode,
            'legacyShortCode' => $legacyShortCode,
            'labelFr' => $label,
            'labelEn' => $label,
            'descFr' => $description,
            'descEn' => $description,
        ];

        foreach ([$id, $shortCode, $legacyShortCode, $label] as $token) {
            $normalized = normalizeCompetencyToken($token);
            if ($normalized !== '') {
                $catalog[$normalized] = $entry;
            }
        }
    }

    return $catalog;
}

function competencyForReference(string $reference): ?array {
    $catalog = loadCompetencyCatalog();
    return $catalog[normalizeCompetencyToken($reference)] ?? null;
}

function competencyStyle(string $level): array {
    return match ($level) {
        'approfondir' => ['#ede9fe', '#c4b5fd', '#5b21b6', '#ddd6fe'],
        'creer' => ['#dcfce7', '#86efac', '#166534', '#bbf7d0'],
        default => ['#e0f2fe', '#7dd3fc', '#075985', '#bae6fd'],
    };
}

function competencyTooltip(array $competency): string {
    $label = trim((string)($competency['shortCode'] ?? '') . ' ' . (string)($competency['labelFr'] ?? ''));
    $description = safeText($competency['descFr'] ?? '');
    return implode(' — ', array_filter([$label, $description], static fn(string $part): bool => $part !== ''));
}

function formatDuration(int $minutes): string {
    if ($minutes < 60) return $minutes . ' min';
    $h = intdiv($minutes, 60);
    $m = $minutes % 60;
    return $m > 0 ? "{$h} h {$m} min" : "{$h} h";
}

function totalSessionDuration(array $session): int {
    $total = 0;
    foreach ($session['activities'] ?? [] as $act) {
        $total += max(1, (int)($act['duration'] ?? 1));
    }
    return $total;
}

// ── Meta info helpers ────────────────────────────────────────
$metaDesigners  = safeText($meta['designers'] ?? $meta['author'] ?? '');
$metaTrainers   = safeText($meta['trainers'] ?? '');
$metaDescription= safeText($meta['description'] ?? '');
$metaDelivery   = safeText($meta['modeDelivery'] ?? '');
$metaClassSize  = safeText($meta['sizeClass'] ?? '');
$metaLearningDays= (int)($meta['learningDays'] ?? 0);
$metaLearningH  = (int)($meta['learningHours'] ?? 0);
$metaLearningMin= (int)($meta['learningMinutes'] ?? 0);

$learningTimeParts = [];
if ($metaLearningDays > 0) $learningTimeParts[] = $metaLearningDays . ' j';
if ($metaLearningH > 0)    $learningTimeParts[] = $metaLearningH . ' h';
if ($metaLearningMin > 0)  $learningTimeParts[] = $metaLearningMin . ' min';
$learningTime = implode(' ', $learningTimeParts);

$totalActivities = 0;
$totalMinutes    = 0;
foreach ($sessions as $s) {
    $totalActivities += count($s['activities'] ?? []);
    $totalMinutes    += totalSessionDuration($s);
}

?><!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title) ?> — Learning Designer</title>
  <style>
    :root {
      --bg: #f5f7fb;
      --surface: #ffffff;
      --surface-2: #eef2f7;
      --border: #d8dee8;
      --text-1: #1e2430;
      --text-2: #5a6474;
      --accent: #2f5bea;
      --accent-soft: #e9efff;
      --radius: 16px;
      --shadow: 0 8px 24px rgba(21,32,56,.07);
      font-family: Inter, system-ui, sans-serif;
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      background: linear-gradient(180deg, #fbfcff, var(--bg));
      color: var(--text-1);
      font: 15px/1.6 Inter, system-ui, sans-serif;
    }
    a { color: var(--accent); }
    .page { max-width: 1000px; margin: 0 auto; padding: 32px 20px 60px; }

    /* Header */
    .hero { margin-bottom: 32px; }
    .hero h1 {
      margin: 0 0 8px;
      font-size: clamp(26px, 4vw, 40px);
      line-height: 1.1;
      letter-spacing: -.03em;
    }
    .hero-meta { color: var(--text-2); font-size: 13px; display: flex; flex-wrap: wrap; gap: 6px 16px; }
    .hero-meta span { white-space: nowrap; }

    /* Info cards row */
    .meta-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 24px;
    }
    .meta-card {
      display: inline-flex;
      align-items: baseline;
      gap: 6px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 999px;
      padding: 5px 10px;
      min-width: 0;
    }
    .meta-card-label {
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: .04em;
      color: var(--text-2);
      white-space: nowrap;
    }
    .meta-card-value {
      font-size: 13px;
      font-weight: 700;
      white-space: nowrap;
    }

    /* Description block */
    .meta-description {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 16px 20px;
      margin-bottom: 32px;
      font-size: 14px;
      color: var(--text-1);
      line-height: 1.65;
    }

    /* Sessions */
    .sessions { display: grid; gap: 20px; }
    .session-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
    }
    .session-head {
      padding: 16px 20px 14px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      gap: 12px;
      flex-wrap: wrap;
    }
    .session-title {
      font-size: 17px;
      font-weight: 700;
      letter-spacing: -.02em;
    }
    .session-duration {
      font-size: 13px;
      color: var(--text-2);
      white-space: nowrap;
    }

    /* Timeline strip */
    .session-timeline {
      display: flex;
      height: 8px;
      overflow: hidden;
    }
    .session-timeline-block {
      flex-shrink: 0;
      transition: opacity .15s;
    }
    .session-timeline-block:hover { opacity: .75; }

    /* Objectives / intentions */
    .session-text {
      padding: 12px 20px;
      font-size: 13px;
      color: var(--text-2);
      border-bottom: 1px solid var(--border);
      line-height: 1.6;
    }
    .session-text > strong { color: var(--text-1); font-size: 11px; text-transform: uppercase; letter-spacing: .07em; display: block; margin-bottom: 2px; }
    .markdown-content p,
    .markdown-content blockquote,
    .markdown-content ul,
    .markdown-content ol {
      margin: 0 0 8px;
    }
    .markdown-content > :last-child {
      margin-bottom: 0;
    }
    .markdown-content h2 {
      margin: 0 0 8px;
      font-size: 16px;
      color: var(--text-1);
    }
    .markdown-content ul,
    .markdown-content ol {
      padding-left: 20px;
    }
    .markdown-content blockquote {
      padding-left: 10px;
      border-left: 3px solid var(--border);
      color: var(--text-2);
    }

    /* Activities */
    .activity-list { padding: 12px 16px; display: grid; gap: 10px; }
    .activity-card {
      border: 1px solid var(--border);
      border-left: 4px solid #999;
      border-radius: 10px;
      padding: 12px 14px;
      background: #fafbfd;
    }
    .activity-head {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
      margin-bottom: 6px;
    }
    .activity-type-badge {
      font-size: 12px;
      font-weight: 700;
      padding: 3px 9px;
      border-radius: 99px;
      background: #eee;
    }
    .activity-duration-badge {
      font-size: 12px;
      color: var(--text-2);
      font-weight: 600;
    }
    .activity-description {
      font-size: 14px;
      color: var(--text-1);
      margin-bottom: 8px;
      line-height: 1.6;
    }
    .activity-chips { display: flex; flex-wrap: wrap; gap: 5px; }
    .chip {
      font-size: 11px;
      padding: 3px 8px;
      border-radius: 99px;
      border: 1px solid var(--border);
      color: var(--text-2);
      background: var(--surface);
      white-space: nowrap;
    }
    .chip-tools { background: var(--accent-soft); border-color: rgba(47,91,234,.18); color: var(--accent); }
    .chip-competency {
      background: var(--competency-bg);
      border-color: var(--competency-border);
      color: var(--competency-text);
      font-weight: 700;
      cursor: help;
      transition: background .15s ease, border-color .15s ease, transform .15s ease;
    }
    .chip-competency:hover {
      background: var(--competency-active);
      transform: translateY(-1px);
    }
    .activity-links-public {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-top: 8px;
    }
    .activity-link-public {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      max-width: 100%;
      padding: 4px 9px;
      border-radius: 99px;
      border: 1px solid rgba(47,91,234,.18);
      background: var(--accent-soft);
      color: var(--accent);
      font-size: 12px;
      font-weight: 600;
      text-decoration: none;
    }
    .activity-link-public:hover { text-decoration: underline; }
    .activity-notes {
      margin-top: 8px;
      font-size: 13px;
      color: var(--text-2);
      font-style: italic;
      line-height: 1.5;
    }

    /* Footer */
    .view-footer {
      margin-top: 40px;
      text-align: center;
      font-size: 13px;
      color: var(--text-2);
    }
    .view-footer a { color: var(--accent); text-decoration: none; }
    .view-footer a:hover { text-decoration: underline; }
    #app-tooltip {
      position: fixed;
      z-index: 9999;
      padding: 5px 11px 6px;
      border-radius: 7px;
      background: #1e2433;
      color: #eef2ff;
      font-size: 12px;
      font-weight: 500;
      line-height: 1.4;
      max-width: 220px;
      white-space: normal;
      text-align: center;
      pointer-events: none;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.30);
      opacity: 0;
      transform: translateY(5px) scale(0.96);
      transition: opacity 140ms ease, transform 140ms cubic-bezier(0.34, 1.4, 0.64, 1);
      will-change: opacity, transform;
    }
    #app-tooltip.tip-visible {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
    #app-tooltip::after {
      content: '';
      position: absolute;
      left: var(--tip-arrow, 50%);
      transform: translateX(-50%);
      border: 5px solid transparent;
    }
    #app-tooltip.tip-above::after {
      top: 100%;
      border-top-color: #1e2433;
    }
    #app-tooltip.tip-below::after {
      bottom: 100%;
      border-bottom-color: #1e2433;
    }

    @media print {
      body { background: #fff; }
      #app-tooltip { display: none; }
      .session-card { break-inside: avoid; }
    }
  </style>
</head>
<body>
<main class="page">

  <header class="hero">
    <h1><?= esc($title) ?></h1>
    <div class="hero-meta">
      <?php if ($metaDesigners !== ''): ?>
        <span>✏️ <?= esc($metaDesigners) ?></span>
      <?php endif; ?>
      <?php if ($metaTrainers !== ''): ?>
        <span>🎓 Enseignant(s) : <?= esc($metaTrainers) ?></span>
      <?php endif; ?>
      <?php if ($updatedAt !== ''): ?>
        <span>Mis à jour le <?= esc($updatedAt) ?></span>
      <?php endif; ?>
    </div>
  </header>

  <?php
  $metaCards = [];
  if (count($sessions) > 0) $metaCards[] = ['Moments', count($sessions)];
  if ($totalActivities > 0) $metaCards[] = ['Activités', $totalActivities];
  if ($totalMinutes > 0)    $metaCards[] = ['Durée totale', formatDuration($totalMinutes)];
  if ($learningTime !== '')  $metaCards[] = ['Temps d\'apprentissage', $learningTime];
  if ($metaDelivery !== '')  $metaCards[] = ['Mode', labelFor($DELIVERY_MODES, $metaDelivery, $metaDelivery)];
  if ($metaClassSize !== '') $metaCards[] = ['Taille du groupe', $metaClassSize];
  ?>
  <?php if ($metaCards): ?>
  <div class="meta-grid">
    <?php foreach ($metaCards as [$label, $value]): ?>
    <div class="meta-card">
      <div class="meta-card-label"><?= esc($label) ?></div>
      <div class="meta-card-value"><?= esc((string)$value) ?></div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ($metaDescription !== ''): ?>
  <div class="meta-description markdown-content"><?= markdownHtml($metaDescription) ?></div>
  <?php endif; ?>

  <div class="sessions">
  <?php foreach ($sessions as $si => $session):
    $sTitle      = safeText($session['title'] ?? '');
    $sObjectives = safeText($session['objectives'] ?? '');
    $sIntentions = safeText($session['intentions'] ?? '');
    $sNotes      = safeText($session['notes'] ?? '');
    $activities  = is_array($session['activities'] ?? null) ? $session['activities'] : [];
    $sDuration   = totalSessionDuration($session);
  ?>
  <section class="session-card">
    <div class="session-head">
      <div class="session-title"><?= esc($sTitle !== '' ? $sTitle : 'Séance ' . ($si + 1)) ?></div>
      <?php if ($sDuration > 0): ?>
        <div class="session-duration"><?= esc(formatDuration($sDuration)) ?></div>
      <?php endif; ?>
    </div>

    <?php if ($activities): ?>
    <div class="session-timeline">
      <?php foreach ($activities as $act):
        $dur   = max(1, (int)($act['duration'] ?? 1));
        $type  = (string)($act['type'] ?? 'undefined');
        $color = $LEARNING_TYPES[$type]['color'] ?? '#d1d5db';
        $pct   = $sDuration > 0 ? round($dur / $sDuration * 100, 2) : 0;
        $aLabel = $LEARNING_TYPES[$type]['label'] ?? $type;
      ?>
      <div class="session-timeline-block" style="width:<?= esc((string)$pct) ?>%;background:<?= esc($color) ?>" title="<?= esc($aLabel) ?> – <?= esc((string)$dur) ?> min"></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($sObjectives !== ''): ?>
    <div class="session-text"><strong>Objectifs</strong><div class="markdown-content"><?= markdownHtml($sObjectives) ?></div></div>
    <?php endif; ?>
    <?php if ($sIntentions !== ''): ?>
    <div class="session-text"><strong>Intentions pédagogiques</strong><div class="markdown-content"><?= markdownHtml($sIntentions) ?></div></div>
    <?php endif; ?>

    <?php if ($activities): ?>
    <div class="activity-list">
      <?php foreach ($activities as $ai => $act):
        $aType  = (string)($act['type'] ?? 'undefined');
        $aDur   = max(1, (int)($act['duration'] ?? 1));
        $aColor = $LEARNING_TYPES[$aType]['color'] ?? '#d1d5db';
        $aLabel = $LEARNING_TYPES[$aType]['label'] ?? $aType;
        $aDesc  = safeText($act['description'] ?? '');
        $aNotes = safeText($act['notes'] ?? '');
        $aTools = is_array($act['tools'] ?? null) ? array_filter($act['tools'], 'is_string') : [];
        $aLinks = is_array($act['links'] ?? null) ? $act['links'] : [];

        $chips = [];
        $gm = labelFor($GROUP_MODES, (string)($act['groupMode'] ?? ''));
        if ($gm !== '') $chips[] = $gm;
        $tr = labelFor($TRAINER_MODES, (string)($act['teacherPresence'] ?? ''));
        if ($tr !== '') $chips[] = $tr;
        $sm = labelFor($SYNC_MODES, (string)($act['syncMode'] ?? ''));
        if ($sm !== '') $chips[] = $sm;
        $lm = labelFor($LOCATION_MODES, (string)($act['locationMode'] ?? ''));
        if ($lm !== '') $chips[] = $lm;
        $ev = $EVAL_MODES[(string)($act['evaluationMode'] ?? 'none')] ?? null;
        if ($ev !== null) $chips[] = $ev;
      ?>
      <article class="activity-card" style="border-left-color:<?= esc($aColor) ?>">
        <div class="activity-head">
          <span class="activity-type-badge" style="background:<?= esc($aColor) ?>;color:rgba(0,0,0,.65)"><?= esc($aLabel) ?></span>
          <span class="activity-duration-badge"><?= esc(formatDuration($aDur)) ?></span>
        </div>
        <?php if ($aDesc !== ''): ?>
        <div class="activity-description markdown-content"><?= markdownHtml($aDesc) ?></div>
        <?php endif; ?>
        <?php if ($chips || $aTools): ?>
        <div class="activity-chips">
          <?php foreach ($chips as $chip): ?>
          <span class="chip"><?= esc($chip) ?></span>
          <?php endforeach; ?>
          <?php foreach ($aTools as $toolId):
            $competency = competencyForReference($toolId);
            if ($competency) {
                [$competencyBg, $competencyBorder, $competencyText, $competencyActive] = competencyStyle((string)$competency['platform']);
                $toolLabel = (string)$competency['shortCode'];
                $toolTitle = competencyTooltip($competency);
            } else {
                $toolLabel = $TOOLS_LABELS[$toolId] ?? $toolId;
                $toolTitle = $toolLabel;
                $competencyBg = '';
                $competencyBorder = '';
                $competencyText = '';
                $competencyActive = '';
            }
          ?>
          <span
            class="chip <?= $competency ? 'chip-competency' : 'chip-tools' ?>"
            data-tooltip="<?= esc($toolTitle) ?>"
            <?php if ($competency): ?>style="--competency-bg:<?= esc($competencyBg) ?>;--competency-border:<?= esc($competencyBorder) ?>;--competency-text:<?= esc($competencyText) ?>;--competency-active:<?= esc($competencyActive) ?>"<?php endif; ?>
          ><?= esc($toolLabel) ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if ($aLinks): ?>
        <div class="activity-links-public" aria-label="Liens de l'activité">
          <?php foreach ($aLinks as $link):
            if (!is_array($link)) continue;
            $linkTitle = safeText($link['title'] ?? '');
            $linkUrl = safeText($link['url'] ?? '');
            if ($linkTitle === '' || $linkUrl === '') continue;
          ?>
          <a class="activity-link-public" href="<?= esc($linkUrl) ?>" target="_blank" rel="noopener noreferrer">↗ <?= esc($linkTitle) ?></a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if ($aNotes !== ''): ?>
        <div class="activity-notes markdown-content"><?= markdownHtml($aNotes) ?></div>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($sNotes !== ''): ?>
    <div class="session-text" style="border-top:1px solid var(--border);border-bottom:none"><strong>Notes</strong><div class="markdown-content"><?= markdownHtml($sNotes) ?></div></div>
    <?php endif; ?>
  </section>
  <?php endforeach; ?>
  </div>

  <footer class="view-footer">
    <p>Partagé avec Learning Designer</p>
  </footer>

</main>
<script>
(() => {
  const tip = document.createElement('div');
  tip.id = 'app-tooltip';
  tip.setAttribute('role', 'tooltip');
  tip.setAttribute('aria-hidden', 'true');
  document.body.appendChild(tip);

  let timer = null;
  let activeTarget = null;

  function nearestTip(el) {
    let node = el;
    while (node && node !== document.body) {
      if (node.dataset && node.dataset.tooltip) return node;
      node = node.parentElement;
    }
    return null;
  }

  function formatTipText(text) {
    return String(text || '').replace(/([^:\s])\s*:\s*(?!\/\/)/g, '$1\u00a0:\u00a0');
  }

  function place(target) {
    const rect = target.getBoundingClientRect();
    const gap = 9;
    const vw = window.innerWidth;
    tip.classList.remove('tip-above', 'tip-below');

    let top;
    if (rect.top - tip.offsetHeight - gap > 6) {
      top = rect.top - tip.offsetHeight - gap;
      tip.classList.add('tip-above');
    } else {
      top = rect.bottom + gap;
      tip.classList.add('tip-below');
    }

    let left = rect.left + rect.width / 2 - tip.offsetWidth / 2;
    left = Math.max(6, Math.min(vw - tip.offsetWidth - 6, left));
    const arrowPos = Math.max(14, Math.min(tip.offsetWidth - 14, rect.left + rect.width / 2 - left));
    tip.style.setProperty('--tip-arrow', `${arrowPos}px`);
    tip.style.top = `${Math.round(top)}px`;
    tip.style.left = `${Math.round(left)}px`;
  }

  function show(target) {
    activeTarget = target;
    tip.textContent = formatTipText(target.dataset.tooltip);
    tip.setAttribute('aria-hidden', 'false');
    tip.style.left = '-9999px';
    tip.style.top = '-9999px';
    tip.classList.add('tip-visible');
    requestAnimationFrame(() => {
      if (activeTarget === target) place(target);
    });
  }

  function hide() {
    clearTimeout(timer);
    activeTarget = null;
    tip.classList.remove('tip-visible', 'tip-above', 'tip-below');
    tip.setAttribute('aria-hidden', 'true');
  }

  document.addEventListener('mouseover', (event) => {
    const target = nearestTip(event.target);
    if (!target || target === activeTarget) return;
    clearTimeout(timer);
    timer = setTimeout(() => show(target), 480);
  });
  document.addEventListener('mouseout', (event) => {
    if (!nearestTip(event.target)) return;
    hide();
  });
  document.addEventListener('click', hide, true);
  document.addEventListener('keydown', hide, true);
  document.addEventListener('scroll', () => {
    if (activeTarget) place(activeTarget);
  }, { passive: true, capture: true });
})();
</script>
</body>
</html>
