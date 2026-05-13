<?php
/**
 * Layout principal - sitio público
 * Variables esperadas: $title, $view, (otras según vista)
 */
$tema = active_theme();
?>
<!DOCTYPE html>
<html lang="es" data-theme="<?= e($tema) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? SITE_NAME) ?></title>
<meta name="description" content="<?= e(SITE_DESCRIPTION) ?>">
<meta property="og:title" content="<?= e($title ?? SITE_NAME) ?>">
<meta property="og:description" content="<?= e(SITE_DESCRIPTION) ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= e(SITE_URL) ?>">
<link rel="icon" href="<?= asset('img/favicon.svg') ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="<?= asset('css/styles.css') ?>" rel="stylesheet">
</head>
<body>

<?php require BASE_PATH . '/app/views/partials/navbar.php'; ?>

<main class="sfh-main">
  <?php if ($flashOk = flash('ok')): ?>
    <div class="sfh-toast sfh-toast-ok"><i class="bi bi-check-circle"></i> <?= $flashOk /* mensajes internos */ ?></div>
  <?php endif; ?>
  <?php if ($flashError = flash('error')): ?>
    <div class="sfh-toast sfh-toast-err"><i class="bi bi-exclamation-triangle"></i> <?= $flashError ?></div>
  <?php endif; ?>

  <?php require BASE_PATH . '/app/views/' . $view . '.php'; ?>
</main>

<?php require BASE_PATH . '/app/views/partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
