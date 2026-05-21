<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$user = require_login_page();
$db = app_db();
$flashMessage = '';
$flashKind = 'info';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_same_origin_post(false);
    $designId = (int)($_POST['design_id'] ?? 0);
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'delete' && $designId > 0) {
        $stmt = $db->prepare('DELETE FROM learning_designs WHERE id = ? AND owner_user_id = ?');
        $stmt->execute([$designId, (int)$user['id']]);
        $flashMessage = $stmt->rowCount() > 0
            ? 'Production supprimée.'
            : 'Production introuvable.';
        $flashKind = $stmt->rowCount() > 0 ? 'success' : 'warning';
    }
}

$stmt = $db->prepare('SELECT id, title, updated_at, created_at FROM learning_designs WHERE owner_user_id = ? ORDER BY updated_at DESC');
$stmt->execute([(int)$user['id']]);
$items = $stmt->fetchAll();

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mes designs | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260520-2" />
    <link rel="stylesheet" href="account-ui.css?v=20260520-4" />
    <link rel="stylesheet" href="account-pages.css?v=20260521-width" />
    <style>
      body.designs-page {
        background: #fff;
      }
      [data-theme="dark"] body.designs-page {
        background:
          radial-gradient(circle at top left, rgba(56, 139, 253, 0.10), transparent 28%),
          linear-gradient(180deg, #1f2537 0%, #1a1f2e 100%);
      }

      .saved-shell {
        width: min(var(--content-shell-width, 1180px), calc(100vw - var(--content-shell-gutter, 36px)));
        margin: 40px auto;
        padding: 32px;
        border: 1px solid var(--line);
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: var(--shadow-soft);
      }

      .saved-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
      }

      .saved-title {
        margin: 0;
        font-size: clamp(28px, 4vw, 38px);
        color: var(--text-strong);
      }

      .saved-subtitle {
        margin: 6px 0 0;
        color: var(--muted);
      }

      .saved-flash {
        margin: 0 0 20px;
        padding: 12px 14px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: var(--surface-light);
        color: var(--text-strong);
      }

      .saved-flash-success {
        border-color: rgba(20, 140, 80, 0.22);
      }

      .saved-flash-warning {
        border-color: rgba(209, 140, 19, 0.22);
      }

      .saved-grid {
        display: grid;
        gap: 14px;
      }

      .saved-empty {
        margin: 0;
        padding: 24px;
        border: 1px dashed var(--line);
        border-radius: 18px;
        color: var(--muted);
        background: var(--surface-light);
      }

      .saved-card {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding: 18px;
        border: 1px solid var(--line);
        border-radius: 18px;
        background: var(--panel-2);
      }

      .saved-card-title {
        margin: 0 0 6px;
        font-size: 18px;
        color: var(--text-strong);
      }

      .saved-card-meta {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.5;
      }

      .saved-card-actions {
        display: inline-flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
      }

      .saved-card-actions form {
        margin: 0;
      }

      .saved-card-actions a.btn,
      .saved-card-actions a.btn:hover,
      .saved-card-actions a.btn:focus {
        text-decoration: none;
      }

      [data-theme="dark"] .saved-shell {
        border-color: rgba(103, 116, 145, 0.45);
        background: linear-gradient(180deg, rgba(36, 43, 64, 0.96), rgba(30, 36, 54, 0.96));
        box-shadow: 0 18px 42px rgba(0, 0, 0, 0.35);
      }

      [data-theme="dark"] .saved-title {
        color: #f3f6ff;
      }

      [data-theme="dark"] .saved-subtitle,
      [data-theme="dark"] .saved-card-meta,
      [data-theme="dark"] .saved-empty {
        color: var(--text-body);
      }

      [data-theme="dark"] .saved-flash {
        border-color: rgba(103, 116, 145, 0.4);
        background: rgba(30, 36, 54, 0.94);
        color: #e8edf5;
      }

      [data-theme="dark"] .saved-flash-success {
        border-color: rgba(106, 176, 255, 0.28);
      }

      [data-theme="dark"] .saved-flash-warning {
        border-color: rgba(251, 191, 36, 0.24);
        color: #fde68a;
      }

      [data-theme="dark"] .saved-empty {
        border-color: rgba(103, 116, 145, 0.38);
        background: rgba(30, 36, 54, 0.78);
      }

      [data-theme="dark"] .saved-card {
        border-color: rgba(103, 116, 145, 0.38);
        background: rgba(30, 36, 54, 0.78);
      }

      [data-theme="dark"] .saved-card-title {
        color: #eef3ff;
      }

      @media (max-width: 760px) {
        .saved-shell {
          padding: 22px;
        }

        .saved-header,
        .saved-card {
          flex-direction: column;
          align-items: stretch;
        }
      }
    </style>
  </head>
  <body class="designs-page">
    <?php render_site_nav('saves'); ?>
    <main class="saved-shell">
      <div class="saved-header">
        <div>
          <h1 class="saved-title">Mes designs</h1>
          <p class="saved-subtitle">Retrouvez, ouvrez ou supprimez vos designs enregistrés.</p>
        </div>
      </div>

      <?php if ($flashMessage !== ''): ?>
        <p class="saved-flash saved-flash-<?= e($flashKind) ?>"><?= e($flashMessage) ?></p>
      <?php endif; ?>

      <?php if (!$items): ?>
        <p class="saved-empty">Aucune sauvegarde pour le moment. Revenez dans l’éditeur puis utilisez le bouton Enregistrer.</p>
      <?php else: ?>
        <section class="saved-grid" aria-label="Liste des productions sauvegardées">
          <?php foreach ($items as $item): ?>
            <article class="saved-card">
              <div>
                <h2 class="saved-card-title"><?= e((string)$item['title']) ?></h2>
                <p class="saved-card-meta">
                  Dernière mise à jour :
                  <?= e((string)$item['updated_at']) ?><br />
                  Créée le :
                  <?= e((string)$item['created_at']) ?>
                </p>
              </div>
              <div class="saved-card-actions">
                <a class="btn btn-primary" href="index.html?remote_design_id=<?= (int)$item['id'] ?>">
                  <span class="btn-label"><i class="fa-regular fa-folder-open btn-icon-inline" aria-hidden="true"></i>Ouvrir</span>
                </a>
                <form method="post" action="my-designs.php">
                  <input type="hidden" name="action" value="delete" />
                  <input type="hidden" name="design_id" value="<?= (int)$item['id'] ?>" />
                  <button class="btn btn-light" type="submit">
                    <span class="btn-label"><i class="fa-regular fa-trash-can btn-icon-inline" aria-hidden="true"></i>Supprimer</span>
                  </button>
                </form>
              </div>
            </article>
          <?php endforeach; ?>
        </section>
      <?php endif; ?>
    </main>
    <?php render_site_footer(); ?>
  </body>
</html>
