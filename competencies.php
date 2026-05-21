<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

function competency_catalog_source(): string
{
    $path = __DIR__ . '/interface.js';
    $source = is_file($path) ? (string)file_get_contents($path) : '';
    if (!preg_match('/const\s+COMPETENCY_CATALOG_SOURCE\s*=\s*String\.raw`(.*?)`;/s', $source, $matches)) {
        return '';
    }
    return (string)$matches[1];
}

function competency_roman(int $value): string
{
    $numerals = [
        ['M', 1000], ['CM', 900], ['D', 500], ['CD', 400],
        ['C', 100], ['XC', 90], ['L', 50], ['XL', 40],
        ['X', 10], ['IX', 9], ['V', 5], ['IV', 4], ['I', 1],
    ];
    $result = '';
    foreach ($numerals as [$symbol, $amount]) {
        while ($value >= $amount) {
            $result .= $symbol;
            $value -= $amount;
        }
    }
    return $result;
}

function parse_competency_catalog(string $source): array
{
    $items = [];
    $levels = [];
    $sectionsByLevel = [];
    $legacyCodeByLevel = ['acquerir' => 'A', 'approfondir' => 'P', 'creer' => 'C'];
    $currentLevel = null;
    $currentAppByLevel = [];

    foreach (preg_split('/\R/u', $source) ?: [] as $line) {
        $line = trim((string)$line, "\r");
        if (trim($line) === '') {
            continue;
        }

        if (str_starts_with($line, '# ')) {
            [$id, $labelFr, $labelEn] = array_pad(explode("\t", substr($line, 2)), 3, '');
            $currentLevel = [
                'id' => trim($id),
                'labelFr' => trim($labelFr),
                'labelEn' => trim($labelEn),
            ];
            $levels[$currentLevel['id']] = $currentLevel;
            $sectionsByLevel[$currentLevel['id']] = [];
            $currentAppByLevel[$currentLevel['id']] = '';
            continue;
        }

        if (!$currentLevel) {
            continue;
        }

        [$sectionRaw, $appRaw, $numberRaw, $labelRaw, $descriptionRaw] = array_pad(explode("\t", $line, 5), 5, '');
        $number = (int)trim($numberRaw);
        $label = trim($labelRaw);
        $description = trim($descriptionRaw);
        if ($number <= 0 || $label === '' || $description === '') {
            continue;
        }

        $levelId = $currentLevel['id'];
        $section = trim($sectionRaw) !== '' ? trim($sectionRaw) : 'Général';
        if (!in_array($section, $sectionsByLevel[$levelId], true)) {
            $sectionsByLevel[$levelId][] = $section;
            $currentAppByLevel[$levelId] = '';
        }
        if (trim($appRaw) !== '') {
            $currentAppByLevel[$levelId] = trim($appRaw);
        }
        $sectionNumber = array_search($section, $sectionsByLevel[$levelId], true) + 1;
        $sectionRoman = competency_roman((int)$sectionNumber);

        $items[] = [
            'id' => 'competency:' . $levelId . ':' . trim($numberRaw),
            'levelId' => $levelId,
            'levelFr' => $currentLevel['labelFr'],
            'levelEn' => $currentLevel['labelEn'],
            'section' => $section,
            'sectionRoman' => $sectionRoman,
            'app' => $currentAppByLevel[$levelId],
            'number' => $number,
            'shortCode' => $currentLevel['labelFr'] . '-' . $sectionRoman . '-' . $number,
            'legacyCode' => ($legacyCodeByLevel[$levelId] ?? strtoupper(substr($levelId, 0, 1))) . $number,
            'label' => $label,
            'description' => $description,
        ];
    }

    return ['levels' => array_values($levels), 'items' => $items];
}

function collect_competency_references(mixed $value, array &$references): void
{
    if (!is_array($value)) {
        return;
    }

    foreach (['tools', 'activity_competencies', 'activity_tools'] as $key) {
        if (!isset($value[$key])) {
            continue;
        }
        $rawReferences = is_array($value[$key])
            ? $value[$key]
            : preg_split('/[;,]/', (string)$value[$key]);
        foreach ($rawReferences ?: [] as $reference) {
            if (is_string($reference) && trim($reference) !== '') {
                $references[$reference] = true;
            }
        }
    }

    foreach ($value as $child) {
        collect_competency_references($child, $references);
    }
}

$catalog = parse_competency_catalog(competency_catalog_source());
$levels = $catalog['levels'];
$items = $catalog['items'];
$total = count($items);
$referenceMap = [];
foreach ($items as $item) {
    foreach ([$item['id'], $item['shortCode'], $item['legacyCode'], $item['label']] as $reference) {
        $reference = trim((string)$reference);
        if ($reference !== '') {
            $referenceMap[mb_strtolower($reference, 'UTF-8')] = $item['id'];
        }
    }
}
$usedCompetencyIds = [];
$currentUser = current_user();
if ($currentUser) {
    $stmt = app_db()->prepare('SELECT document_json FROM learning_designs WHERE owner_user_id = ?');
    $stmt->execute([(int)$currentUser['id']]);
    foreach ($stmt->fetchAll() as $designRow) {
        $document = json_decode((string)($designRow['document_json'] ?? ''), true);
        if (!is_array($document)) {
            continue;
        }
        $references = [];
        collect_competency_references($document, $references);
        foreach (array_keys($references) as $reference) {
            $normalized = mb_strtolower(trim((string)$reference), 'UTF-8');
            if (isset($referenceMap[$normalized])) {
                $usedCompetencyIds[$referenceMap[$normalized]] = true;
            }
        }
    }
}
$levelCounts = [];
foreach ($items as $item) {
    $levelCounts[$item['levelId']] = ($levelCounts[$item['levelId']] ?? 0) + 1;
}
$sectionGroups = [];
foreach ($items as $item) {
    $sectionKey = $item['levelId'] . ':' . $item['sectionRoman'] . ':' . $item['section'];
    if (!isset($sectionGroups[$sectionKey])) {
        $sectionGroups[$sectionKey] = [
            'levelId' => $item['levelId'],
            'levelFr' => $item['levelFr'],
            'levelEn' => $item['levelEn'],
            'section' => $item['section'],
            'sectionRoman' => $item['sectionRoman'],
            'items' => [],
        ];
    }
    $sectionGroups[$sectionKey]['items'][] = $item;
}
$levelGroups = [];
foreach ($levels as $level) {
    $levelGroups[$level['id']] = [
        'levelId' => $level['id'],
        'levelFr' => $level['labelFr'],
        'levelEn' => $level['labelEn'],
        'sections' => [],
        'count' => $levelCounts[$level['id']] ?? 0,
    ];
}
foreach ($sectionGroups as $sectionKey => $group) {
    $levelGroups[$group['levelId']]['sections'][$sectionKey] = $group;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compétences numériques | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260520-2">
    <link rel="stylesheet" href="account-ui.css?v=20260520-4">
    <link rel="stylesheet" href="account-pages.css?v=20260521-width">
    <style>
        body.competencies-page {
            background: #fff;
        }
        .competencies-shell {
            width: min(var(--content-shell-width, 1180px), calc(100vw - var(--content-shell-gutter, 36px)));
            margin: 32px auto 64px;
        }
        .competencies-header {
            display: grid;
            gap: 10px;
            margin-bottom: 22px;
        }
        .competencies-kicker {
            margin: 0;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 12px;
            font-weight: 700;
        }
        .competencies-title {
            margin: 0;
            color: var(--text);
            font-size: clamp(25px, 4vw, 36px);
        }
        .competencies-subtitle {
            max-width: 760px;
            margin: 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
        }
        .competencies-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 18px 0 0;
        }
        .competencies-stat,
        .competencies-filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 36px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            color: var(--text);
            padding: 7px 12px;
            font-size: 13px;
            font-weight: 700;
        }
        .competencies-stat span {
            color: var(--muted);
            font-weight: 600;
        }
        .competencies-controls {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) auto;
            gap: 12px;
            align-items: center;
            margin: 24px 0 14px;
        }
        .competencies-search {
            width: 100%;
            min-height: 42px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            color: var(--text);
            padding: 0 14px;
            font: inherit;
        }
        .competencies-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
        }
        .competencies-filter-btn {
            cursor: pointer;
            transition: background var(--transition-fast), border-color var(--transition-fast), color var(--transition-fast);
        }
        .competencies-filter-btn.is-active {
            border-color: var(--primary);
            background: rgba(20, 91, 180, 0.10);
            color: var(--primary);
        }
        .competencies-dot {
            width: 9px;
            height: 9px;
            flex: 0 0 auto;
            border-radius: 50%;
        }
        .competencies-dot-acquerir {
            background: #0ea5e9;
        }
        .competencies-dot-approfondir {
            background: #7c3aed;
        }
        .competencies-dot-creer {
            background: #16a34a;
        }
        .competencies-table-wrap {
            overflow-x: auto;
            border: 1px solid #c7d0dc;
            border-radius: 4px;
            background: var(--panel);
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
        }
        .competencies-table {
            width: 100%;
            min-width: 920px;
            border-collapse: collapse;
            font-size: 12px;
            table-layout: fixed;
        }
        .competencies-col-used {
            width: 68px;
        }
        .competencies-col-code {
            width: 48px;
        }
        .competencies-col-label {
            width: 34%;
        }
        .competencies-col-description {
            width: auto;
        }
        .competencies-table th,
        .competencies-table td {
            border-right: 1px solid #d9e0ea;
            border-bottom: 1px solid #d9e0ea;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        .competencies-table th:last-child,
        .competencies-table td:last-child {
            border-right: none;
        }
        .competencies-column-row th {
            background: #ffffff;
            color: #1f2937;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 1px solid #b9c5d4;
        }
        .competencies-column-row th:first-child,
        .competencies-table td:first-child {
            text-align: center;
        }
        .competencies-used-cell {
            text-align: center;
        }
        .competencies-used-check {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            vertical-align: middle;
        }
        .competencies-used-empty {
            color: #94a3b8;
            font-weight: 700;
        }
        .competencies-table tr:last-child td {
            border-bottom: none;
        }
        .competencies-item-row[data-level="acquerir"] td {
            background: #f8fcff;
        }
        .competencies-item-row[data-level="acquerir"][data-row-shade="alt"] td {
            background: #eef9ff;
        }
        .competencies-item-row[data-level="approfondir"] td {
            background: #fcfbff;
        }
        .competencies-item-row[data-level="approfondir"][data-row-shade="alt"] td {
            background: #f5f1ff;
        }
        .competencies-item-row[data-level="creer"] td {
            background: #f8fff9;
        }
        .competencies-item-row[data-level="creer"][data-row-shade="alt"] td {
            background: #effcf3;
        }
        .competencies-item-row:hover td {
            background: #fffef3;
        }
        .competencies-level-row td,
        .competencies-section-row td {
            padding: 0;
        }
        .competencies-level-row td {
            background: #e6ebf2;
            border-top: 1px solid #b9c5d4;
            border-bottom-color: #c7d0dc;
        }
        .competencies-section-row td {
            background: #f7f9fc;
            border-bottom-color: #d9e0ea;
        }
        .competencies-level-toggle,
        .competencies-section-toggle {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            border: 0;
            background: transparent;
            color: var(--text);
            padding: 7px 10px;
            font: inherit;
            text-align: left;
            cursor: pointer;
        }
        .competencies-level-toggle {
            padding: 8px 10px;
        }
        .competencies-section-toggle {
            padding: 7px 10px 7px 12px;
        }
        .competencies-section-heading {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            font-weight: 800;
        }
        .competencies-level-heading {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            color: var(--text);
            font-size: 13px;
            font-weight: 900;
        }
        .competencies-level-title {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .competencies-section-title {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .competencies-section-title {
            color: #334155;
            font-weight: 800;
        }
        .competencies-section-meta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }
        .competencies-chevron {
            color: var(--muted);
            transition: transform var(--transition-fast);
        }
        .competencies-level-toggle[aria-expanded="false"] .competencies-chevron,
        .competencies-section-toggle[aria-expanded="false"] .competencies-chevron {
            transform: rotate(-90deg);
        }
        .competency-code {
            display: inline-flex;
            align-items: center;
            width: 32px;
            justify-content: center;
            border: 1px solid var(--competency-border);
            border-radius: 3px;
            background: var(--competency-bg);
            color: var(--competency-text);
            padding: 1px 3px;
            font-weight: 800;
            font-size: 11px;
            white-space: nowrap;
        }
        .competency-code-acquerir {
            --competency-bg: #e0f2fe;
            --competency-border: #7dd3fc;
            --competency-text: #075985;
        }
        .competency-code-approfondir {
            --competency-bg: #ede9fe;
            --competency-border: #c4b5fd;
            --competency-text: #5b21b6;
        }
        .competency-code-creer {
            --competency-bg: #dcfce7;
            --competency-border: #86efac;
            --competency-text: #166534;
        }
        .competencies-level {
            font-weight: 800;
            color: var(--text);
            white-space: nowrap;
        }
        .competencies-label {
            color: var(--text);
            font-weight: 700;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }
        .competencies-description {
            color: var(--muted);
            line-height: 1.45;
            overflow-wrap: anywhere;
        }
        .competencies-empty {
            display: none;
            margin: 18px 0 0;
            color: var(--muted);
            font-size: 14px;
        }
        .competencies-empty.is-visible {
            display: block;
        }
        [data-theme="dark"] body.competencies-page {
            background:
                radial-gradient(circle at top left, rgba(56, 139, 253, 0.10), transparent 28%),
                linear-gradient(180deg, #1f2537 0%, #1a1f2e 100%);
        }
        [data-theme="dark"] .competencies-title,
        [data-theme="dark"] .competencies-level-heading,
        [data-theme="dark"] .competencies-section-title,
        [data-theme="dark"] .competencies-label,
        [data-theme="dark"] .competencies-level-toggle,
        [data-theme="dark"] .competencies-section-toggle,
        [data-theme="dark"] .competencies-table thead th,
        [data-theme="dark"] .competencies-stat,
        [data-theme="dark"] .competencies-filter-btn {
            color: #eef3ff;
        }
        [data-theme="dark"] .competencies-kicker {
            color: #8cc6ff;
        }
        [data-theme="dark"] .competencies-subtitle,
        [data-theme="dark"] .competencies-description,
        [data-theme="dark"] .competencies-empty,
        [data-theme="dark"] .competencies-stat span {
            color: var(--text-body);
        }
        [data-theme="dark"] .competencies-table-wrap,
        [data-theme="dark"] .competencies-search,
        [data-theme="dark"] .competencies-stat,
        [data-theme="dark"] .competencies-filter-btn {
            background: rgba(30, 36, 54, 0.96);
            border-color: rgba(103, 116, 145, 0.45);
        }
        [data-theme="dark"] .competencies-column-row th {
            background: rgba(30, 36, 54, 0.98);
            border-bottom-color: rgba(126, 145, 178, 0.55);
        }
        [data-theme="dark"] .competencies-table th,
        [data-theme="dark"] .competencies-table td {
            border-right-color: rgba(103, 116, 145, 0.42);
            border-bottom-color: rgba(103, 116, 145, 0.42);
        }
        [data-theme="dark"] .competencies-level-row td {
            background: rgba(50, 59, 80, 0.98);
            border-bottom-color: rgba(103, 116, 145, 0.45);
        }
        [data-theme="dark"] .competencies-section-row td {
            background: rgba(34, 41, 59, 0.98);
            border-bottom-color: rgba(103, 116, 145, 0.45);
        }
        [data-theme="dark"] .competencies-item-row[data-level="acquerir"] td {
            background: rgba(14, 165, 233, 0.055);
        }
        [data-theme="dark"] .competencies-item-row[data-level="acquerir"][data-row-shade="alt"] td {
            background: rgba(14, 165, 233, 0.095);
        }
        [data-theme="dark"] .competencies-item-row[data-level="approfondir"] td {
            background: rgba(124, 58, 237, 0.055);
        }
        [data-theme="dark"] .competencies-item-row[data-level="approfondir"][data-row-shade="alt"] td {
            background: rgba(124, 58, 237, 0.095);
        }
        [data-theme="dark"] .competencies-item-row[data-level="creer"] td {
            background: rgba(22, 163, 74, 0.055);
        }
        [data-theme="dark"] .competencies-item-row[data-level="creer"][data-row-shade="alt"] td {
            background: rgba(22, 163, 74, 0.095);
        }
        [data-theme="dark"] .competencies-item-row:hover td {
            background: rgba(250, 204, 21, 0.12);
        }
        [data-theme="dark"] .competencies-filter-btn.is-active {
            border-color: #8cc6ff;
            background: rgba(140, 198, 255, 0.14);
            color: #8cc6ff;
        }
        @media (max-width: 760px) {
            .competencies-shell {
                margin-top: 22px;
            }
            .competencies-controls {
                grid-template-columns: 1fr;
            }
            .competencies-filters {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body class="competencies-page">
<?php render_site_nav(); ?>
<main class="competencies-shell with-nav">
    <header class="competencies-header">
        <p class="competencies-kicker" data-i18n-fr="Référentiel" data-i18n-en="Curriculum">Référentiel</p>
        <h1 class="competencies-title" data-i18n-fr="Compétences numériques" data-i18n-en="Digital Competencies">Compétences numériques</h1>
        <p class="competencies-subtitle" data-i18n-fr="Tableau complet du curriculum utilisé dans le sélecteur de compétences de Learning Designer. Les codes courts reprennent les trois niveaux : Acquérir, Approfondir et Créer." data-i18n-en="Complete table of the curriculum used in Learning Designer’s competency picker. Short codes follow the three levels: Acquire, Deepen, and Create.">Tableau complet du curriculum utilisé dans le sélecteur de compétences de Learning Designer. Les codes courts reprennent les trois niveaux : Acquérir, Approfondir et Créer.</p>
        <div class="competencies-summary" aria-label="Résumé du référentiel" data-i18n-attr="aria-label" data-i18n-fr="Résumé du référentiel" data-i18n-en="Curriculum summary">
            <div class="competencies-stat"><strong><?= h((string)$total) ?></strong> <span data-i18n-fr="compétences" data-i18n-en="competencies">compétences</span></div>
            <?php foreach ($levels as $level): ?>
                <div class="competencies-stat">
                    <span class="competencies-dot competencies-dot-<?= h($level['id']) ?>" aria-hidden="true"></span>
                    <strong data-level-fr="<?= h($level['labelFr']) ?>" data-level-en="<?= h($level['labelEn']) ?>"><?= h($level['labelFr']) ?></strong>
                    <span><?= h((string)($levelCounts[$level['id']] ?? 0)) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </header>

    <section class="competencies-controls" aria-label="Filtres" data-i18n-attr="aria-label" data-i18n-fr="Filtres" data-i18n-en="Filters">
        <label class="sr-only" for="competency-search" data-i18n-fr="Rechercher une compétence" data-i18n-en="Search competencies">Rechercher une compétence</label>
        <input id="competency-search" class="competencies-search" type="search" placeholder="Rechercher par code, section, outil, compétence..." data-i18n-attr="placeholder" data-i18n-fr="Rechercher par code, section, outil, compétence..." data-i18n-en="Search by code, section, tool, competency...">
        <div class="competencies-filters" role="group" aria-label="Filtrer par niveau" data-i18n-attr="aria-label" data-i18n-fr="Filtrer par niveau" data-i18n-en="Filter by level">
            <button class="competencies-filter-btn is-active" type="button" data-level-filter="all" data-i18n-fr="Tout" data-i18n-en="All">Tout</button>
            <?php foreach ($levels as $level): ?>
                <button class="competencies-filter-btn" type="button" data-level-filter="<?= h($level['id']) ?>">
                    <span class="competencies-dot competencies-dot-<?= h($level['id']) ?>" aria-hidden="true"></span>
                    <span data-level-fr="<?= h($level['labelFr']) ?>" data-level-en="<?= h($level['labelEn']) ?>"><?= h($level['labelFr']) ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </section>

    <div class="competencies-table-wrap">
        <table class="competencies-table">
            <colgroup>
                <col class="competencies-col-used">
                <col class="competencies-col-code">
                <col class="competencies-col-label">
                <col class="competencies-col-description">
            </colgroup>
            <tbody id="competencies-table-body">
                <?php foreach ($levelGroups as $levelGroup): ?>
                    <tr class="competencies-level-row" data-level-row="<?= h($levelGroup['levelId']) ?>" data-level="<?= h($levelGroup['levelId']) ?>">
                        <td colspan="4">
                            <button class="competencies-level-toggle" type="button" aria-expanded="true" data-level-toggle="<?= h($levelGroup['levelId']) ?>">
                                <span class="competencies-level-heading">
                                    <span class="competencies-dot competencies-dot-<?= h($levelGroup['levelId']) ?>" aria-hidden="true"></span>
                                    <span class="competencies-level-title" data-level-fr="<?= h($levelGroup['levelFr']) ?>" data-level-en="<?= h($levelGroup['levelEn']) ?>"><?= h($levelGroup['levelFr']) ?></span>
                                </span>
                                <span class="competencies-section-meta">
                                    <i class="fa-solid fa-chevron-down competencies-chevron" aria-hidden="true"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <?php foreach ($levelGroup['sections'] as $sectionKey => $group): ?>
                        <tr class="competencies-section-row" data-section-key="<?= h($sectionKey) ?>" data-level="<?= h($group['levelId']) ?>">
                            <td colspan="4">
                                <button class="competencies-section-toggle" type="button" aria-expanded="true" data-section-toggle="<?= h($sectionKey) ?>">
                                    <span class="competencies-section-heading">
                                        <span class="competencies-section-title"><?= h($group['sectionRoman']) ?> - <?= h($group['section']) ?></span>
                                    </span>
                                    <span class="competencies-section-meta">
                                        <i class="fa-solid fa-chevron-down competencies-chevron" aria-hidden="true"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                        <tr class="competencies-column-row" data-section="<?= h($sectionKey) ?>" data-level="<?= h($group['levelId']) ?>">
                            <th scope="col" data-i18n-fr="Utilisée" data-i18n-en="Used">Utilisée</th>
                            <th scope="col" data-i18n-fr="Code" data-i18n-en="Code">Code</th>
                            <th scope="col" data-i18n-fr="Compétence" data-i18n-en="Competency">Compétence</th>
                            <th scope="col" data-i18n-fr="Repères observables" data-i18n-en="Observable indicators">Repères observables</th>
                        </tr>
                        <?php foreach ($group['items'] as $index => $item): ?>
                            <tr class="competencies-item-row" data-row-shade="<?= $index % 2 === 1 ? 'alt' : 'base' ?>" data-section="<?= h($sectionKey) ?>" data-level="<?= h($item['levelId']) ?>" data-search="<?= h(mb_strtolower(implode(' ', $item), 'UTF-8')) ?>">
                                <td class="competencies-used-cell">
                                    <?php if ($currentUser): ?>
                                        <input class="competencies-used-check" type="checkbox" disabled <?= isset($usedCompetencyIds[$item['id']]) ? 'checked' : '' ?> aria-label="<?= h('Compétence utilisée : ' . $item['legacyCode']) ?>">
                                    <?php else: ?>
                                        <span class="competencies-used-empty" aria-label="Connexion requise">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="competency-code competency-code-<?= h($item['levelId']) ?>" title="<?= h($item['shortCode']) ?>"><?= h($item['legacyCode']) ?></span></td>
                                <td class="competencies-label"><?= h((string)$item['number']) ?>. <?= h($item['label']) ?></td>
                                <td class="competencies-description"><?= h(str_replace(' | ', ' · ', $item['description'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p id="competencies-empty" class="competencies-empty" data-i18n-fr="Aucune compétence ne correspond à ce filtre." data-i18n-en="No competency matches this filter.">Aucune compétence ne correspond à ce filtre.</p>
</main>
<?php render_site_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var activeLevel = 'all';
    var searchInput = document.getElementById('competency-search');
    var itemRows = Array.prototype.slice.call(document.querySelectorAll('.competencies-item-row'));
    var sectionRows = Array.prototype.slice.call(document.querySelectorAll('.competencies-section-row'));
    var levelRows = Array.prototype.slice.call(document.querySelectorAll('.competencies-level-row'));
    var columnRows = Array.prototype.slice.call(document.querySelectorAll('.competencies-column-row'));
    var empty = document.getElementById('competencies-empty');
    var filterButtons = Array.prototype.slice.call(document.querySelectorAll('[data-level-filter]'));
    var sectionToggles = Array.prototype.slice.call(document.querySelectorAll('[data-section-toggle]'));
    var levelToggles = Array.prototype.slice.call(document.querySelectorAll('[data-level-toggle]'));
    var collapsedSections = new Set();
    var collapsedLevels = new Set();

    function normalize(value) {
        return String(value || '').toLocaleLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function filterRows() {
        var query = normalize(searchInput ? searchInput.value : '');
        var visibleCount = 0;
        var sectionMatches = {};
        var levelMatches = {};

        itemRows.forEach(function (row) {
            var matchesLevel = activeLevel === 'all' || row.dataset.level === activeLevel;
            var matchesSearch = !query || normalize(row.dataset.search).indexOf(query) !== -1;
            var matches = matchesLevel && matchesSearch;
            row.dataset.matchesFilter = matches ? 'true' : 'false';
            if (matches) {
                visibleCount += 1;
                sectionMatches[row.dataset.section] = (sectionMatches[row.dataset.section] || 0) + 1;
                levelMatches[row.dataset.level] = (levelMatches[row.dataset.level] || 0) + 1;
            }
        });

        levelRows.forEach(function (row) {
            var count = levelMatches[row.dataset.levelRow] || 0;
            row.hidden = count === 0;
        });

        sectionRows.forEach(function (row) {
            var count = sectionMatches[row.dataset.sectionKey] || 0;
            row.hidden = count === 0 || collapsedLevels.has(row.dataset.level);
        });

        columnRows.forEach(function (row) {
            var count = sectionMatches[row.dataset.section] || 0;
            row.hidden = count === 0 || collapsedLevels.has(row.dataset.level) || collapsedSections.has(row.dataset.section);
        });

        itemRows.forEach(function (row) {
            var matches = row.dataset.matchesFilter === 'true';
            row.hidden = !matches || collapsedLevels.has(row.dataset.level) || collapsedSections.has(row.dataset.section);
        });
        if (empty) {
            empty.classList.toggle('is-visible', visibleCount === 0);
        }
    }

    levelToggles.forEach(function (button) {
        button.addEventListener('click', function () {
            var level = button.dataset.levelToggle;
            var isCollapsed = collapsedLevels.has(level);
            if (isCollapsed) {
                collapsedLevels.delete(level);
            } else {
                collapsedLevels.add(level);
            }
            button.setAttribute('aria-expanded', isCollapsed ? 'true' : 'false');
            filterRows();
        });
    });

    sectionToggles.forEach(function (button) {
        button.addEventListener('click', function () {
            var section = button.dataset.sectionToggle;
            var isCollapsed = collapsedSections.has(section);
            if (isCollapsed) {
                collapsedSections.delete(section);
            } else {
                collapsedSections.add(section);
            }
            button.setAttribute('aria-expanded', isCollapsed ? 'true' : 'false');
            filterRows();
        });
    });

    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            activeLevel = button.dataset.levelFilter || 'all';
            filterButtons.forEach(function (candidate) {
                candidate.classList.toggle('is-active', candidate === button);
            });
            filterRows();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', filterRows);
    }

    function applyPageLanguage(lang) {
        document.documentElement.lang = lang === 'en' ? 'en' : 'fr';
        document.title = lang === 'en' ? 'Digital Competencies | Learning Designer' : 'Compétences numériques | Learning Designer';
        document.querySelectorAll('[data-i18n-fr]').forEach(function (el) {
            var value = lang === 'en' ? el.dataset.i18nEn : el.dataset.i18nFr;
            if (!value) return;
            var attrs = (el.dataset.i18nAttr || '').split(',').map(function (attr) {
                return attr.trim();
            }).filter(Boolean);
            if (attrs.length) {
                attrs.forEach(function (attr) {
                    el.setAttribute(attr, value);
                });
            } else {
                el.textContent = value;
            }
        });
        document.querySelectorAll('[data-level-fr]').forEach(function (el) {
            el.textContent = lang === 'en' ? el.dataset.levelEn : el.dataset.levelFr;
        });
    }

    var lang = 'fr';
    try {
        lang = localStorage.getItem('learningDesignerLang') || 'fr';
    } catch (error) {
        lang = 'fr';
    }
    applyPageLanguage(lang);

    var langSelect = document.getElementById('lang-select');
    if (langSelect) {
        langSelect.addEventListener('change', function () {
            applyPageLanguage(langSelect.value);
        });
    }
});
</script>
</body>
</html>
