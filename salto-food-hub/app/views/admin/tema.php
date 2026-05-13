<?php $actual = active_theme(); $temas = [
  'dark_orange' => ['Dark Orange', ['#1a1a1a','#262626','#ff8c42','#ffffff']],
  'coffee'      => ['Coffee',      ['#3e2723','#6d4c41','#d7ccc8','#fff8f0']],
  'modern_red'  => ['Modern Red',  ['#121212','#1e1e1e','#ff3b30','#f5f5f5']],
  'green_food'  => ['Green Food',  ['#1b4332','#2d6a4f','#95d5b2','#f1faee']],
  'light_elegant'=>['Light Elegant',['#ffffff','#f5f5f5','#c59d5f','#222222']],
]; ?>
<div class="sfh-panel">
  <h5>Elegí el tema visual</h5>
  <p class="text-muted small">El tema se aplica a todo el sitio para todos los usuarios.</p>
  <form method="post" action="<?= url('?p=admin&s=set-tema') ?>">
    <?= csrf_field() ?>
    <div class="row g-3">
      <?php foreach ($temas as $k=>$t): ?>
        <div class="col-md-6 col-lg-4">
          <label class="sfh-theme-card <?= $actual===$k?'is-active':'' ?>">
            <input type="radio" name="tema" value="<?= $k ?>" <?= $actual===$k?'checked':'' ?>>
            <div class="sfh-theme-preview">
              <?php foreach ($t[1] as $c): ?><span style="background:<?= $c ?>"></span><?php endforeach; ?>
            </div>
            <strong><?= e($t[0]) ?></strong>
          </label>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="sfh-btn sfh-btn-primary mt-3">Guardar tema</button>
  </form>
</div>
