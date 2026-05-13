<?php $u = current_user(); ?>
<nav class="sfh-navbar">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="<?= url('?p=home') ?>" class="sfh-brand">
      <span class="sfh-brand-mark"><i class="bi bi-egg-fried"></i></span>
      <span class="sfh-brand-text"><?= e(SITE_NAME) ?></span>
    </a>
    <div class="d-none d-md-flex align-items-center gap-3">
      <a href="<?= url('?p=explorar') ?>" class="sfh-nav-link"><i class="bi bi-compass"></i> Explorar</a>
      <a href="<?= url('?p=mapa') ?>" class="sfh-nav-link"><i class="bi bi-geo-alt"></i> Mapa</a>
      <?php if ($u): ?>
        <a href="<?= url('?p=favoritos') ?>" class="sfh-nav-link"><i class="bi bi-heart"></i></a>
        <a href="<?= url('?p=mis-emprendimientos') ?>" class="sfh-nav-link"><i class="bi bi-shop"></i> Mis negocios</a>
        <?php if ($u['rol']==='admin'): ?>
          <a href="<?= url('?p=admin') ?>" class="sfh-btn sfh-btn-ghost"><i class="bi bi-shield-lock"></i> Admin</a>
        <?php endif; ?>
        <div class="dropdown">
          <button class="sfh-btn sfh-btn-ghost dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i> <?= e($u['nombre']) ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= url('?p=favoritos') ?>">Favoritos</a></li>
            <li><a class="dropdown-item" href="<?= url('?p=mis-emprendimientos') ?>">Mis emprendimientos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= url('?p=logout') ?>">Cerrar sesión</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a href="<?= url('?p=login') ?>" class="sfh-nav-link">Iniciar sesión</a>
        <a href="<?= url('?p=register') ?>" class="sfh-btn sfh-btn-primary">Crear cuenta</a>
      <?php endif; ?>
    </div>
    <button class="sfh-btn sfh-btn-ghost d-md-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <i class="bi bi-list"></i>
    </button>
  </div>
</nav>

<div class="offcanvas offcanvas-end" id="mobileMenu" tabindex="-1">
  <div class="offcanvas-header"><h5><?= e(SITE_NAME) ?></h5><button class="btn-close" data-bs-dismiss="offcanvas"></button></div>
  <div class="offcanvas-body d-flex flex-column gap-2">
    <a href="<?= url('?p=explorar') ?>" class="sfh-nav-link">Explorar</a>
    <a href="<?= url('?p=mapa') ?>" class="sfh-nav-link">Mapa</a>
    <?php if ($u): ?>
      <a href="<?= url('?p=favoritos') ?>" class="sfh-nav-link">Favoritos</a>
      <a href="<?= url('?p=mis-emprendimientos') ?>" class="sfh-nav-link">Mis negocios</a>
      <?php if ($u['rol']==='admin'): ?><a href="<?= url('?p=admin') ?>" class="sfh-nav-link">Admin</a><?php endif; ?>
      <a href="<?= url('?p=logout') ?>" class="sfh-nav-link">Cerrar sesión</a>
    <?php else: ?>
      <a href="<?= url('?p=login') ?>" class="sfh-nav-link">Iniciar sesión</a>
      <a href="<?= url('?p=register') ?>" class="sfh-btn sfh-btn-primary">Crear cuenta</a>
    <?php endif; ?>
  </div>
</div>
