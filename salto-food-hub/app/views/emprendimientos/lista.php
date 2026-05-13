<section class="sfh-section">
  <div class="container">
    <div class="sfh-page-head">
      <div>
        <h1 class="sfh-section-title mb-1">Explorar</h1>
        <p class="text-muted mb-0">Emprendimientos gastronómicos de Salto.</p>
      </div>
    </div>

    <form method="get" class="sfh-filters">
      <input type="hidden" name="p" value="explorar">
      <div class="sfh-filters-search">
        <i class="bi bi-search"></i>
        <input type="text" name="q" value="<?= e($f['q']) ?>" placeholder="Buscar por nombre, dirección o descripción">
      </div>
      <select name="categoria_id" class="form-select">
        <option value="0">Todas las categorías</option>
        <?php foreach ($categorias as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= $f['categoria_id']==$c['id']?'selected':'' ?>><?= e($c['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="orden" class="form-select">
        <option value="recientes" <?= $f['orden']==='recientes'?'selected':'' ?>>Más recientes</option>
        <option value="rating" <?= $f['orden']==='rating'?'selected':'' ?>>Mejor calificados</option>
        <option value="populares" <?= $f['orden']==='populares'?'selected':'' ?>>Más populares</option>
      </select>
      <button class="sfh-btn sfh-btn-primary">Filtrar</button>
    </form>

    <p class="text-muted small my-3"><?= (int)$total ?> resultados</p>

    <div class="row g-4">
      <?php foreach ($emprendimientos as $emp): ?>
        <div class="col-md-6 col-lg-4"><?php include BASE_PATH . '/app/views/partials/card_emp.php'; ?></div>
      <?php endforeach; ?>
      <?php if (!$emprendimientos): ?>
        <div class="col-12"><div class="sfh-empty">No encontramos resultados. Probá con otra búsqueda.</div></div>
      <?php endif; ?>
    </div>

    <?php if ($pg['pages'] > 1): ?>
      <nav class="sfh-pagination">
        <?php for ($i=1;$i<=$pg['pages'];$i++):
          $qs = $_GET; $qs['page']=$i; $href = url('?'.http_build_query($qs)); ?>
          <a href="<?= $href ?>" class="<?= $i==$pg['page']?'active':'' ?>"><?= $i ?></a>
        <?php endfor; ?>
      </nav>
    <?php endif; ?>
  </div>
</section>
