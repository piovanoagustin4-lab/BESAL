<div class="sfh-panel">
  <table class="table align-middle">
    <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($items as $u): ?>
      <tr>
        <td><?= (int)$u['id'] ?></td>
        <td><?= e($u['nombre']) ?> <small class="text-muted">@<?= e($u['username']) ?></small></td>
        <td><?= e($u['email']) ?></td>
        <td><span class="sfh-badge"><?= e($u['rol']) ?></span></td>
        <td><?= $u['baneado']?'<span class="sfh-badge sfh-badge-warn">Baneado</span>':'<span class="sfh-badge sfh-badge-ok">Activo</span>' ?></td>
        <td class="text-end">
          <form method="post" action="<?= url('?p=admin&s=banear') ?>" class="d-inline">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="val" value="<?= $u['baneado']?0:1 ?>">
            <button class="sfh-btn sfh-btn-ghost sfh-btn-sm"><?= $u['baneado']?'Desbanear':'Banear' ?></button>
          </form>
          <form method="post" action="<?= url('?p=admin&s=eliminar-usuario') ?>" class="d-inline" onsubmit="return confirm('¿Eliminar usuario?')">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
            <button class="sfh-btn sfh-btn-ghost sfh-btn-sm text-danger"><i class="bi bi-trash"></i></button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
