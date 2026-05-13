<section class="sfh-section">
  <div class="container">
    <h1 class="sfh-section-title">Nuevo emprendimiento</h1>
    <p class="text-muted">Completá los datos. Quedará pendiente de aprobación por un administrador.</p>
    <form method="post" action="<?= url('?p=nuevo-emprendimiento') ?>" enctype="multipart/form-data" class="sfh-form">
      <?= csrf_field() ?>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Nombre</label><input name="nombre" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Categoría</label>
          <select name="categoria_id" class="form-select"><option value="0">Sin categoría</option>
          <?php foreach ($categorias as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['nombre']) ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="col-12"><label class="form-label">Descripción</label><textarea name="descripcion" class="form-control" rows="3"></textarea></div>
        <div class="col-md-6"><label class="form-label">Dirección</label><input name="direccion" class="form-control"></div>
        <div class="col-md-3"><label class="form-label">Teléfono</label><input name="telefono" class="form-control"></div>
        <div class="col-md-3"><label class="form-label">WhatsApp</label><input name="whatsapp" class="form-control" placeholder="59899..."></div>
        <div class="col-md-4"><label class="form-label">Instagram</label><input name="instagram" class="form-control" placeholder="@usuario"></div>
        <div class="col-md-4"><label class="form-label">Facebook (URL)</label><input name="facebook" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Horarios</label><input name="horarios" class="form-control" placeholder="Lun-Sab 18-00"></div>
        <div class="col-md-4"><label class="form-label">Latitud</label><input name="latitud" class="form-control" placeholder="-31.3833"></div>
        <div class="col-md-4"><label class="form-label">Longitud</label><input name="longitud" class="form-control" placeholder="-57.9667"></div>
        <div class="col-md-4"></div>
        <div class="col-md-6"><label class="form-label">Logo</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
        <div class="col-md-6"><label class="form-label">Portada</label><input type="file" name="portada" class="form-control" accept="image/*"></div>
      </div>
      <button class="sfh-btn sfh-btn-primary mt-4">Crear emprendimiento</button>
    </form>
  </div>
</section>
