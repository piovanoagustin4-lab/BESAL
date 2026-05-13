<section class="sfh-section">
  <div class="container">
    <h1 class="sfh-section-title">Mis favoritos</h1>
    <?php if (!$items): ?><div class="sfh-empty">Todavía no marcaste ningún favorito.</div><?php endif; ?>
    <div class="row g-4">
      <?php foreach ($items as $emp): ?>
        <div class="col-md-6 col-lg-4"><?php include BASE_PATH . '/app/views/partials/card_emp.php'; ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
