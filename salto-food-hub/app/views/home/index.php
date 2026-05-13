<section class="sfh-hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <span class="sfh-eyebrow"><i class="bi bi-geo-alt-fill"></i> Salto · Uruguay</span>
        <h1 class="sfh-hero-title">Descubrí los <em>sabores</em> de Salto.</h1>
        <p class="sfh-hero-sub">Hamburguesas, chivitos, café de especialidad, repostería y más. Apoyá a los emprendedores gastronómicos locales.</p>
        <form method="get" action="<?= url('') ?>" class="sfh-search">
          <input type="hidden" name="p" value="explorar">
          <i class="bi bi-search"></i>
          <input type="text" name="q" placeholder="Buscá hamburguesas, café, sushi…" autocomplete="off">
          <button class="sfh-btn sfh-btn-primary">Buscar</button>
        </form>
        <div class="sfh-hero-stats">
          <div><strong><?= (int)Emprendimiento::count() ?></strong><span>Emprendimientos</span></div>
          <div><strong><?= count($categorias) ?></strong><span>Categorías</span></div>
          <div><strong><?= (int)Resena::count() ?></strong><span>Reseñas</span></div>
        </div>
      </div>
      <div class="col-lg-5 d-none d-lg-block">
        <div class="sfh-hero-card">
          <div class="sfh-hero-card-img"></div>
          <div class="sfh-hero-card-body">
            <div class="d-flex align-items-center gap-2"><i class="bi bi-star-fill text-warning"></i><strong>4.8</strong><span class="text-muted">· Lo más amado</span></div>
            <h5 class="mt-2 mb-0">Burger Salto</h5>
            <small class="text-muted">Hamburguesas artesanales</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="sfh-section">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between mb-3">
      <h2 class="sfh-section-title">Explorá por categoría</h2>
      <a href="<?= url('?p=explorar') ?>" class="sfh-link">Ver todo <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="sfh-cats">
      <?php foreach ($categorias as $c): ?>
        <a href="<?= url('?p=explorar&categoria_id='.$c['id']) ?>" class="sfh-cat" style="--cat-color: <?= e($c['color']) ?>">
          <span class="sfh-cat-icon"><i class="bi <?= e($c['icono']) ?>"></i></span>
          <span class="sfh-cat-name"><?= e($c['nombre']) ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sfh-section">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between mb-3">
      <h2 class="sfh-section-title">Destacados de Salto</h2>
      <a href="<?= url('?p=explorar') ?>" class="sfh-link">Ver todos <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4">
      <?php if (!$destacados): ?>
        <p class="text-muted">Aún no hay emprendimientos destacados.</p>
      <?php endif; ?>
      <?php foreach ($destacados as $e): ?>
        <div class="col-md-6 col-lg-4">
          <?php $emp=$e; include BASE_PATH . '/app/views/partials/card_emp.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sfh-section sfh-section-alt">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-md-7">
        <h2 class="sfh-section-title mb-2">¿Tenés un emprendimiento gastronómico?</h2>
        <p class="text-muted mb-0">Sumate gratis a <?= e(SITE_NAME) ?> y mostrale tu propuesta a toda la ciudad.</p>
      </div>
      <div class="col-md-5 text-md-end">
        <a href="<?= url('?p=nuevo-emprendimiento') ?>" class="sfh-btn sfh-btn-primary sfh-btn-lg"><i class="bi bi-plus-circle"></i> Publicar mi negocio</a>
      </div>
    </div>
  </div>
</section>
