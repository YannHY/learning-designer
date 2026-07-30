<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$db = app_db();
$user = current_user();

$stmt = $db->query("SELECT d.title, d.document_json, d.share_token, d.license_code, d.updated_at, d.listed_at, u.username
    FROM learning_designs d
    JOIN users u ON u.id = d.owner_user_id
    WHERE d.is_published = 1 AND d.is_listed = 1 AND d.share_token IS NOT NULL
    ORDER BY COALESCE(d.listed_at, d.updated_at) DESC, d.id DESC");
$items = [];

foreach ($stmt->fetchAll() as $row) {
    $document = json_decode((string)$row['document_json'], true);
    if (!is_array($document)) {
        $document = ['sessions' => [], 'meta' => []];
    }

    $meta = is_array($document['meta'] ?? null) ? $document['meta'] : [];
    $sessions = is_array($document['sessions'] ?? null) ? $document['sessions'] : [];
    $activityCount = 0;
    $duration = 0;
    foreach ($sessions as $session) {
        $activities = is_array($session['activities'] ?? null) ? $session['activities'] : [];
        $activityCount += count($activities);
        foreach ($activities as $activity) {
            $duration += max(0, (int)($activity['duration'] ?? 0));
        }
    }

    $title = trim((string)($meta['name'] ?? ''));
    if ($title === '') {
        $title = trim((string)$row['title']);
    }
    if ($title === '') {
        $title = 'Production sans titre';
    }

    $description = trim((string)($meta['description'] ?? ''));
    if ($description === '') {
        $description = trim((string)($meta['personas'] ?? ''));
    }
    if (mb_strlen($description, 'UTF-8') > 220) {
        $description = mb_substr($description, 0, 217, 'UTF-8') . '...';
    }

    $mode = trim((string)($meta['modeDelivery'] ?? ''));
    $designedDuration = share_designed_minutes($meta);
    $license = creative_commons_license((string)($row['license_code'] ?? ''));
    $items[] = [
        'title' => $title,
        'description' => $description,
        'author' => (string)$row['username'],
        'token' => (string)$row['share_token'],
        'updated_at' => (string)$row['updated_at'],
        'session_count' => count($sessions),
        'activity_count' => $activityCount,
        'duration' => $designedDuration > 0 ? $designedDuration : $duration,
        'mode' => $mode,
        'license' => $license,
    ];
}

function share_designed_minutes(array $meta): int
{
    return max(0, (int)($meta['designedMinutes'] ?? 0));
}

function share_format_minutes(int $minutes): string
{
    if ($minutes <= 0) {
        return 'Durée non précisée';
    }
    $hours = intdiv($minutes, 60);
    $rest = $minutes % 60;
    if ($hours > 0 && $rest > 0) {
        return $hours . ' h ' . $rest . ' min';
    }
    if ($hours > 0) {
        return $hours . ' h';
    }
    return $rest . ' min';
}

function share_mode_label(string $mode): string
{
    return match ($mode) {
        'online' => 'Distanciel',
        'hybrid' => 'Hybride',
        'onsite' => 'Présentiel',
        default => 'Mode non précisé',
    };
}

function share_count_label(int $count, string $singular): string
{
    return $count . ' ' . $singular . ($count > 1 ? 's' : '');
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Designs partagés | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260729-language-toggle" />
    <link rel="stylesheet" href="account-ui.css?v=20260520-4" />
    <link rel="stylesheet" href="account-pages.css?v=20260730-dark-primary" />
    <style>
      .shared-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 24px;
      }

      .shared-shell {
        width: min(1180px, calc(100vw - 36px));
      }

      .shared-subtitle {
        max-width: 760px;
        margin: 8px 0 0;
        color: var(--muted);
        line-height: 1.6;
      }

      .shared-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
      }

      .shared-card {
        display: flex;
        min-height: 260px;
        flex-direction: column;
        gap: 16px;
        padding: 18px;
        border: 1px solid var(--line);
        border-radius: 8px;
        background: var(--panel-2);
      }

      .shared-card-title {
        margin: 0;
        color: var(--text-strong);
        font-size: 20px;
        line-height: 1.25;
      }

      .shared-card-copy {
        margin: 0;
        color: var(--muted);
        line-height: 1.55;
      }

      .shared-meta {
        display: flex;
        flex-wrap: nowrap;
        gap: 6px;
        margin-top: auto;
      }

      .shared-pill {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        gap: 5px;
        padding: 6px 7px;
        border: 1px solid var(--line);
        border-radius: 999px;
        color: var(--muted);
        font-size: 12px;
        white-space: nowrap;
        background: #fff;
      }

      .shared-meta a.shared-pill {
        text-decoration: none;
      }

      .shared-meta a.shared-pill:hover,
      .shared-meta a.shared-pill:focus {
        border-color: var(--accent);
        color: var(--accent);
      }

      .shared-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
      }

      .shared-actions form {
        margin: 0;
      }

      .shared-actions .shared-action-btn {
        width: 108px;
      }

      .shared-actions a.btn,
      .shared-actions a.btn:hover,
      .shared-actions a.btn:focus {
        text-decoration: none;
      }

      .shared-empty {
        margin: 0;
        padding: 24px;
        border: 1px dashed var(--line);
        border-radius: 8px;
        color: var(--muted);
        background: var(--surface-light);
      }

      [data-theme="dark"] .shared-title,
      [data-theme="dark"] .shared-card-title {
        color: #eef3ff;
      }

      [data-theme="dark"] .shared-subtitle,
      [data-theme="dark"] .shared-card-copy,
      [data-theme="dark"] .shared-pill,
      [data-theme="dark"] .shared-empty {
        color: var(--text-body);
      }

      [data-theme="dark"] .shared-card,
      [data-theme="dark"] .shared-empty {
        border-color: var(--line);
        background: var(--panel-2);
      }

      [data-theme="dark"] .shared-pill {
        border-color: var(--line);
        background: var(--surface-light);
      }

      @media (max-width: 1140px) {
        .shared-grid {
          grid-template-columns: 1fr;
        }
      }

      @media (max-width: 760px) {
        .shared-header {
          align-items: stretch;
          flex-direction: column;
        }
      }

      @media (max-width: 580px) {
        .shared-meta {
          flex-wrap: wrap;
        }
      }
    </style>
  </head>
  <body class="shared-page">
    <?php render_site_nav('share'); ?>
    <main class="shared-shell">
      <div class="shared-header">
        <div>
          <h1 class="shared-title">Designs partagés</h1>
          <p class="shared-subtitle">Explorez les designs partagés et importez ceux que vous souhaitez adapter.</p>
        </div>
      </div>

      <?php if (!$items): ?>
        <p class="shared-empty">Aucun design n’est encore visible dans la page de partage.</p>
      <?php else: ?>
        <section class="shared-grid" aria-label="Designs publiés dans le catalogue">
          <?php foreach ($items as $item): ?>
            <article class="shared-card">
              <div>
                <h2 class="shared-card-title"><?= h($item['title']) ?></h2>
                <p class="shared-card-copy">Par <?= h($item['author']) ?></p>
              </div>
              <?php if ($item['description'] !== ''): ?>
                <p class="shared-card-copy"><?= h($item['description']) ?></p>
              <?php endif; ?>
              <div class="shared-meta" aria-label="Résumé du design">
                <span class="shared-pill"><i class="fa-regular fa-folder" aria-hidden="true"></i><?= h(share_count_label((int)$item['session_count'], 'séance')) ?></span>
                <span class="shared-pill"><i class="fa-solid fa-list-check" aria-hidden="true"></i><?= h(share_count_label((int)$item['activity_count'], 'activité')) ?></span>
                <span class="shared-pill"><i class="fa-regular fa-clock" aria-hidden="true"></i><?= h(share_format_minutes((int)$item['duration'])) ?></span>
                <span class="shared-pill"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><?= h(share_mode_label($item['mode'])) ?></span>
                <?php if ($item['license']): ?>
                  <a class="shared-pill" href="<?= h($item['license']['url']) ?>" target="_blank" rel="license noopener noreferrer"><i class="fa-brands fa-creative-commons" aria-hidden="true"></i><?= h($item['license']['label']) ?></a>
                <?php endif; ?>
              </div>
              <div class="shared-actions">
                <a class="btn btn-light shared-action-btn" href="view.php?token=<?= urlencode($item['token']) ?>">
                  <span class="btn-label"><i class="fa-regular fa-eye btn-icon-inline" aria-hidden="true"></i><span data-site-i18n-en="View" data-site-i18n-fr="Voir">Voir</span></span>
                </a>
                <?php if ($user): ?>
                  <form method="post" action="import_shared_design.php">
                    <input type="hidden" name="token" value="<?= h($item['token']) ?>" />
                    <button class="btn btn-primary shared-action-btn" type="submit">
                      <span class="btn-label"><i class="fa-solid fa-file-import btn-icon-inline" aria-hidden="true"></i><span data-site-i18n-en="Import" data-site-i18n-fr="Importer">Importer</span></span>
                    </button>
                  </form>
                <?php else: ?>
                  <a class="btn btn-primary" href="login.php">
                    <span class="btn-label"><i class="fa-regular fa-user btn-icon-inline" aria-hidden="true"></i><span data-site-i18n-en="Sign in to import" data-site-i18n-fr="Se connecter pour importer">Se connecter pour importer</span></span>
                  </a>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </section>
      <?php endif; ?>
    </main>
    <?php render_site_footer(); ?>
  </body>
</html>
