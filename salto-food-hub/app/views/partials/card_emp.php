<?php
/** Variables: $emp (array con keys de emprendimientos, opcional categoria_nombre, rating, reviews) */
$rating = isset($emp['rating']) ? round((float)$emp['rating'],1) : null;
?>
<a href="<?= url('?p=ver&slug='.urlencode($emp['slug'])) ?>" class="sfh-card">
  <div class="sfh-card-img" style="background-image:url('<?= $emp['logo'] ? uploaded($emp['logo'],'logos') : asset('img/placeholder.svg') ?>')"></div>
  <div class="sfh-card-body">
    <div class="d-flex justify-content-between align-items-start gap-2">
      <h5 class="sfh-card-title"><?= e($emp['nombre']) ?></h5>
      <?php if ($rating): ?><span class="sfh-rating"><i class="bi bi-star-fill"></i> <?= e((string)$rating) ?></span><?php endif; ?>
    </div>
    <p class="sfh-card-meta"><i class="bi bi-tag"></i> <?= e($emp['categoria_nombre'] ?? 'Sin categoría') ?></p>
    <p class="sfh-card-desc"><?= e(mb_substr($emp['descripcion'] ?? '',0,90)) ?><?= mb_strlen($emp['descripcion'] ?? '')>90?'…':'' ?></p>
    <div class="sfh-card-foot">
      <span><i class="bi bi-geo-alt"></i> <?= e(mb_substr($emp['direccion'] ?? 'Salto',0,40)) ?></span>
      <span class="sfh-link">Ver más <i class="bi bi-arrow-right"></i></span>
    </div>
  </div>
</a>
