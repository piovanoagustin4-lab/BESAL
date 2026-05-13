<section class="sfh-section">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="sfh-section-title mb-0">Mis emprendimientos</h1>
      <a href="<?= url('?p=nuevo-emprendimiento') ?>" class="sfh-btn sfh-btn-primary"><i class="bi bi-plus-circle"></i> Nuevo</a>
    </div>
    <?php if (!$items): ?>
      <div class="sfh-empty">Todavía no creaste ningún emprendimiento.</div>
    <?php endif; ?>
    <?php foreach ($items as $emp): ?>
      <div class="sfh-mine-card">
        <div class="sfh-mine-head">
          <div class="sfh-mine-logo" style="background-image:url('<?= $emp['logo']?uploaded($emp['logo'],'logos'):asset('img/placeholder.svg') ?>')"></div>
          <div class="flex-grow-1">
            <h5 class="mb-1"><?= e($emp['nombre']) ?></h5>
            <small class="text-muted"><?= e($emp['direccion']) ?></small>
          </div>
          <span class="sfh-badge <?= $emp['aprobado']?'sfh-badge-ok':'sfh-badge-warn' ?>"><?= $emp['aprobado']?'Aprobado':'Pendiente' ?></span>
          <a href="<?= url('?p=ver&slug='.urlencode($emp['slug'])) ?>" class="sfh-btn sfh-btn-ghost">Ver</a>
        </div>

        <details class="mt-3">
          <summary class="sfh-link">+ Nueva publicación</summary>
          <form method="post" action="<?= url('?p=nueva-publicacion') ?>" enctype="multipart/form-data" class="sfh-form mt-3">
            <?= csrf_field() ?>
            <input type="hidden" name="emprendimiento_id" value="<?= (int)$emp['id'] ?>">
            <div class="row g-3">
              <div class="col-md-6"><input name="titulo" class="form-control" placeholder="Título" required></div>
              <div class="col-md-3"><input name="precio" type="number" step="0.01" class="form-control" placeholder="Precio (opcional)"></div>
              <div class="col-md-3"><input type="file" name="imagen" class="form-control" accept="image/*"></div>
              <div class="col-12"><textarea name="descripcion" class="form-control" rows="2" placeholder="Descripción"></textarea></div>
            </div>
            <button class="sfh-btn sfh-btn-primary mt-2">Publicar</button>
          </form>
        </details>
      </div>
    <?php endforeach; ?>
  </div>
</section>
