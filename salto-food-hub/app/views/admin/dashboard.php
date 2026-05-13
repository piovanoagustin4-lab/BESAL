<div class="row g-3">
  <?php foreach (['usuarios'=>['bi-people','Usuarios'],'emprendimientos'=>['bi-shop','Emprendimientos'],'publicaciones'=>['bi-card-image','Publicaciones'],'resenas'=>['bi-star','Reseñas']] as $k=>$v): ?>
    <div class="col-md-6 col-lg-3">
      <div class="sfh-stat">
        <i class="bi <?= $v[0] ?>"></i>
        <div><strong><?= (int)$stats[$k] ?></strong><span><?= $v[1] ?></span></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="row g-3 mt-2">
  <div class="col-lg-7">
    <div class="sfh-panel">
      <h5>Emprendimientos pendientes de aprobación</h5>
      <?php if (!$pendientes): ?><p class="text-muted small">No hay pendientes.</p><?php endif; ?>
      <?php foreach ($pendientes as $p): ?>
        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
          <div><strong><?= e($p['nombre']) ?></strong><br><small class="text-muted"><?= e($p['owner']) ?></small></div>
          <form method="post" action="<?= url('?p=admin&s=aprobar-emp') ?>" class="d-inline">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><input type="hidden" name="val" value="1">
            <button class="sfh-btn sfh-btn-primary sfh-btn-sm">Aprobar</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="sfh-panel">
      <h5>Reseñas recientes</h5>
      <?php foreach ($recientes as $r): ?>
        <div class="py-2 border-bottom">
          <strong><?= e($r['nombre']) ?></strong> · <span class="text-muted small"><?= e($r['emp_nombre']) ?></span>
          <div class="text-warning small">
            <?php for ($i=1;$i<=5;$i++): ?><i class="bi bi-star<?= $r['estrellas']>=$i?'-fill':'' ?>"></i><?php endfor; ?>
          </div>
          <small class="text-muted"><?= e(mb_substr($r['comentario'],0,100)) ?></small>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
