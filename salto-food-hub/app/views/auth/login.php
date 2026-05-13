<section class="sfh-auth">
  <div class="sfh-auth-card">
    <h2>Iniciá sesión</h2>
    <p class="text-muted">Bienvenido de vuelta a <?= e(SITE_NAME) ?>.</p>
    <form method="post" action="<?= url('?p=login') ?>">
      <?= csrf_field() ?>
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
      <label class="form-label mt-3">Contraseña</label>
      <input type="password" name="password" class="form-control" required>
      <button class="sfh-btn sfh-btn-primary w-100 mt-4">Entrar</button>
    </form>
    <p class="text-center mt-3 small">¿No tenés cuenta? <a href="<?= url('?p=register') ?>">Crear cuenta</a></p>
  </div>
</section>
