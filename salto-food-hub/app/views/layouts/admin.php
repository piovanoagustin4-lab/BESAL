<?php $tema = active_theme(); ?>
<!DOCTYPE html>
<html lang="es" data-theme="<?= e($tema) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'Admin') ?> · Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="<?= asset('css/styles.css') ?>" rel="stylesheet">
<link href="<?= asset('css/admin.css') ?>" rel="stylesheet">
</head>
<body class="sfh-admin-body">

<aside class="sfh-sidebar">
  <a href="<?= url('?p=admin') ?>" class="sfh-sidebar-brand">
    <i class="bi bi-egg-fried"></i><span><?= e(SITE_NAME) ?></span>
  </a>
  <nav class="sfh-sidebar-nav">
    <a href="<?= url('?p=admin') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="<?= url('?p=admin&s=usuarios') ?>"><i class="bi bi-people"></i> Usuarios</a>
    <a href="<?= url('?p=admin&s=emprendimientos') ?>"><i class="bi bi-shop"></i> Emprendimientos</a>
    <a href="<?= url('?p=admin&s=categorias') ?>"><i class="bi bi-tags"></i> Categorías</a>
    <a href="<?= url('?p=admin&s=tema') ?>"><i class="bi bi-palette"></i> Tema</a>
    <hr>
    <a href="<?= url('?p=home') ?>"><i class="bi bi-arrow-left"></i> Volver al sitio</a>
    <a href="<?= url('?p=logout') ?>"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
  </nav>
</aside>

<div class="sfh-admin-main">
  <header class="sfh-admin-header">
    <h1><?= e($title) ?></h1>
    <div class="sfh-admin-user"><i class="bi bi-person-circle"></i> <?= e(current_user()['nombre'] ?? '') ?></div>
  </header>

  <?php if ($f = flash('ok')): ?><div class="sfh-toast sfh-toast-ok"><i class="bi bi-check-circle"></i> <?= $f ?></div><?php endif; ?>
  <?php if ($f = flash('error')): ?><div class="sfh-toast sfh-toast-err"><i class="bi bi-exclamation-triangle"></i> <?= $f ?></div><?php endif; ?>

  <div class="sfh-admin-content">
    <?php require BASE_PATH . '/app/views/' . $view . '.php'; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
