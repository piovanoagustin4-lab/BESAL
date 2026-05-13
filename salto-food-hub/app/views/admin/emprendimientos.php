<?php if ($pendientes): ?>
<div class="sfh-panel mb-3">
  <h5>Pendientes de aprobación</h5>
  <table class="table align-middle">
    <tbody>
    <?php foreach ($pendientes as $p): ?>
      <tr>
        <td><strong><?= e($p['nombre']) ?></strong> <small class="text-muted">por <?= e($p['owner']) ?></small></td>
        <td class="text-end">
          <form method="post" action="<?= url('?p=admin&s=aprobar-emp') ?>" class="d-inline">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><input type="hidden" name="val" value="1">
            <button class="sfh-btn sfh-btn-primary sfh-btn-sm">Aprobar</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>

<div class="sfh-panel">
  <h5>Aprobados</h5>
  <table class="table align-middle">
    <thead><tr><th>Nombre</th><th>Categoría</th><th>Visitas</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($items as $e): ?>
      <tr>
        <td><strong><?= e($e['nombre']) ?></strong><br><small class="text-muted"><?= e($e['direccion']) ?></small></td>
        <td><?= e($e['categoria_nombre'] ?? '-') ?></td>
        <td><?= (int)$e['visitas'] ?></td>
        <td class="text-end">
          <a class="sfh-btn sfh-btn-ghost sfh-btn-sm" href="<?= url('?p=ver&slug='.urlencode($e['slug'])) ?>">Ver</a>
          <form method="post" action="<?= url('?p=admin&s=eliminar-emp') ?>" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$e['id'] ?>">
            <button class="sfh-btn sfh-btn-ghost sfh-btn-sm text-danger"><i class="bi bi-trash"></i></button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
