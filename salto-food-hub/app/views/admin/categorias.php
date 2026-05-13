<div class="row g-3">
  <div class="col-lg-4">
    <div class="sfh-panel">
      <h5>Nueva categoría</h5>
      <form method="post" action="<?= url('?p=admin&s=crear-categoria') ?>">
        <?= csrf_field() ?>
        <label class="form-label mt-2">Nombre</label><input name="nombre" class="form-control" required>
        <label class="form-label mt-2">Icono (Bootstrap Icons)</label><input name="icono" class="form-control" value="bi-shop">
        <label class="form-label mt-2">Color</label><input name="color" type="color" class="form-control form-control-color" value="#ff8c42">
        <label class="form-label mt-2">Orden</label><input name="orden" type="number" class="form-control" value="0">
        <button class="sfh-btn sfh-btn-primary mt-3 w-100">Crear</button>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="sfh-panel">
      <table class="table align-middle">
        <thead><tr><th>Nombre</th><th>Icono</th><th>Color</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $c): ?>
          <tr>
            <td><strong><?= e($c['nombre']) ?></strong></td>
            <td><i class="bi <?= e($c['icono']) ?>"></i> <?= e($c['icono']) ?></td>
            <td><span style="display:inline-block;width:20px;height:20px;border-radius:6px;background:<?= e($c['color']) ?>"></span></td>
            <td class="text-end">
              <form method="post" action="<?= url('?p=admin&s=eliminar-categoria') ?>" onsubmit="return confirm('¿Eliminar?')">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                <button class="sfh-btn sfh-btn-ghost sfh-btn-sm text-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
