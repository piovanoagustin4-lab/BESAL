<footer class="sfh-footer">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-5">
        <div class="sfh-brand mb-2">
          <img src="<?= asset('img/SALTO.png') ?>" alt="<?= e(SITE_NAME) ?>" class="sfh-brand-logo">
          <span class="sfh-brand-text"><?= e(SITE_NAME) ?></span>
        </div>
        <p class="text-muted mb-0"><?= e(SITE_DESCRIPTION) ?></p>
      </div>
      <div class="col-md-3">
        <h6>Explorar</h6>
        <a href="<?= url('?p=explorar') ?>">Emprendimientos</a><br>
        <a href="<?= url('?p=mapa') ?>">Mapa</a>
      </div>
      <div class="col-md-4">
        <h6>Sumate</h6>
        <a href="<?= url('?p=nuevo-emprendimiento') ?>">Publicar mi negocio</a><br>
        <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a>
      </div>
    </div>
    <hr>
    <p class="text-center text-muted small mb-0">© <?= date('Y') ?> <?= e(SITE_NAME) ?> · Salto, Uruguay</p>
  </div>
</footer>
