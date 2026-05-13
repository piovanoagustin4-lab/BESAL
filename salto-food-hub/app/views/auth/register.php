<section class="sfh-auth">
  <div class="sfh-auth-card">
    <h2>Crear cuenta</h2>
    <p class="text-muted">Sumate a <?= e(SITE_NAME) ?>.</p>
    <form method="post" action="<?= url('?p=register') ?>">
      <?= csrf_field() ?>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Nombre</label><input name="nombre" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Username</label><input name="username" class="form-control" required></div>
        <div class="col-12"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Contraseña</label><input type="password" name="password" class="form-control" required minlength="6"></div>
        <div class="col-md-6"><label class="form-label">Tipo de cuenta</label>
          <select name="rol" class="form-select"><option value="usuario">Usuario</option><option value="emprendedor">Emprendedor</option></select>
        </div>
      </div>
      <button class="sfh-btn sfh-btn-primary w-100 mt-4">Crear cuenta</button>
    </form>
    <p class="text-center mt-3 small">¿Ya tenés cuenta? <a href="<?= url('?p=login') ?>">Iniciar sesión</a></p>
  </div>
</section>
