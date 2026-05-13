<?php $u = current_user(); ?>
<section class="sfh-section">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="sfh-detail-cover" style="background-image:url('<?= $emp['portada'] ? uploaded($emp['portada'],'logos') : asset('img/placeholder.svg') ?>')"></div>
        <div class="sfh-detail-head">
          <div class="sfh-detail-logo" style="background-image:url('<?= $emp['logo'] ? uploaded($emp['logo'],'logos') : asset('img/placeholder.svg') ?>')"></div>
          <div class="flex-grow-1">
            <h1 class="mb-1"><?= e($emp['nombre']) ?></h1>
            <p class="text-muted mb-2"><i class="bi bi-tag"></i> <?= e($emp['categoria_nombre'] ?? 'Sin categoría') ?></p>
            <div class="sfh-rating sfh-rating-lg">
              <?php for ($i=1;$i<=5;$i++): ?>
                <i class="bi bi-star<?= $promedio>=$i?'-fill':($promedio>=$i-0.5?'-half':'') ?>"></i>
              <?php endfor; ?>
              <span class="ms-2"><?= number_format($promedio,1) ?> · <?= count($resenas) ?> reseñas</span>
            </div>
          </div>
        </div>

        <p class="mt-3"><?= nl2br(e($emp['descripcion'])) ?></p>

        <h4 class="mt-5 mb-3">Menú / Publicaciones</h4>
        <div class="row g-3">
          <?php foreach ($publicaciones as $p): ?>
            <div class="col-md-6">
              <div class="sfh-pub">
                <?php if ($p['imagen']): ?><div class="sfh-pub-img" style="background-image:url('<?= uploaded($p['imagen'],'publicaciones') ?>')"></div><?php endif; ?>
                <div class="sfh-pub-body">
                  <div class="d-flex justify-content-between"><strong><?= e($p['titulo']) ?></strong><?php if ($p['precio']): ?><span class="sfh-price">$<?= number_format($p['precio'],0,',','.') ?></span><?php endif; ?></div>
                  <p class="text-muted small mb-0"><?= e($p['descripcion']) ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <?php if (!$publicaciones): ?><p class="text-muted">Aún no hay publicaciones.</p><?php endif; ?>
        </div>

        <h4 class="mt-5 mb-3">Reseñas</h4>
        <?php if ($u): ?>
          <form method="post" action="<?= url('?p=resena') ?>" class="sfh-resena-form mb-4">
            <?= csrf_field() ?>
            <input type="hidden" name="emprendimiento_id" value="<?= (int)$emp['id'] ?>">
            <div class="sfh-stars-input">
              <?php for ($i=5;$i>=1;$i--): ?>
                <input type="radio" id="s<?= $i ?>" name="estrellas" value="<?= $i ?>" <?= $i===5?'checked':'' ?>><label for="s<?= $i ?>"><i class="bi bi-star-fill"></i></label>
              <?php endfor; ?>
            </div>
            <textarea name="comentario" class="form-control" rows="2" placeholder="Contanos tu experiencia"></textarea>
            <button class="sfh-btn sfh-btn-primary mt-2">Publicar reseña</button>
          </form>
        <?php else: ?>
          <p class="text-muted"><a href="<?= url('?p=login') ?>">Iniciá sesión</a> para dejar tu reseña.</p>
        <?php endif; ?>

        <?php foreach ($resenas as $r): ?>
          <div class="sfh-resena">
            <div class="d-flex justify-content-between">
              <strong><?= e($r['nombre']) ?></strong>
              <span class="sfh-rating"><?php for ($i=1;$i<=5;$i++): ?><i class="bi bi-star<?= $r['estrellas']>=$i?'-fill':'' ?>"></i><?php endfor; ?></span>
            </div>
            <p class="mb-0"><?= nl2br(e($r['comentario'])) ?></p>
            <small class="text-muted"><?= e($r['creado_en']) ?></small>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="col-lg-5">
        <div class="sfh-info-card">
          <h5>Información</h5>
          <p><i class="bi bi-geo-alt"></i> <?= e($emp['direccion']) ?: 'Salto, Uruguay' ?></p>
          <?php if ($emp['telefono']): ?><p><i class="bi bi-telephone"></i> <?= e($emp['telefono']) ?></p><?php endif; ?>
          <?php if ($emp['horarios']): ?><p><i class="bi bi-clock"></i> <?= e($emp['horarios']) ?></p><?php endif; ?>
          <div class="d-flex gap-2 flex-wrap mt-3">
            <?php if ($emp['whatsapp']): ?><a href="https://wa.me/<?= e($emp['whatsapp']) ?>" class="sfh-btn sfh-btn-primary" target="_blank"><i class="bi bi-whatsapp"></i> WhatsApp</a><?php endif; ?>
            <?php if ($emp['instagram']): ?><a href="https://instagram.com/<?= e(ltrim($emp['instagram'],'@')) ?>" class="sfh-btn sfh-btn-ghost" target="_blank"><i class="bi bi-instagram"></i></a><?php endif; ?>
            <?php if ($emp['facebook']): ?><a href="<?= e($emp['facebook']) ?>" class="sfh-btn sfh-btn-ghost" target="_blank"><i class="bi bi-facebook"></i></a><?php endif; ?>
            <?php if ($u): ?>
              <form method="post" action="<?= url('?p=favorito') ?>" class="d-inline">
                <?= csrf_field() ?><input type="hidden" name="emprendimiento_id" value="<?= (int)$emp['id'] ?>">
                <button class="sfh-btn sfh-btn-ghost"><i class="bi bi-heart<?= $esFav?'-fill':'' ?>"></i></button>
              </form>
            <?php endif; ?>
          </div>
        </div>

        <?php if ($emp['latitud'] && $emp['longitud']): ?>
          <div class="sfh-info-card mt-3">
            <h5>Ubicación</h5>
            <iframe class="sfh-map-embed" src="https://www.google.com/maps?q=<?= e($emp['latitud']) ?>,<?= e($emp['longitud']) ?>&output=embed" loading="lazy"></iframe>
            <a class="sfh-btn sfh-btn-ghost mt-2 w-100" target="_blank" href="https://www.google.com/maps/dir/?api=1&destination=<?= e($emp['latitud']) ?>,<?= e($emp['longitud']) ?>"><i class="bi bi-navigation"></i> Cómo llegar</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
