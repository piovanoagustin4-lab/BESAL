<section class="sfh-section">
  <div class="container">
    <h1 class="sfh-section-title">Mapa de Salto</h1>
    <p class="text-muted">Encontrá los emprendimientos cerca tuyo.</p>
    <div id="sfhMap" class="sfh-map-full"></div>
  </div>
</section>

<script>
window.SFH_MARKERS = <?= json_encode(array_map(function($m){
  return ['nombre'=>$m['nombre'],'slug'=>$m['slug'],'lat'=>(float)$m['latitud'],'lng'=>(float)$m['longitud'],'dir'=>$m['direccion']];
}, $marcadores), JSON_UNESCAPED_UNICODE) ?>;
window.SFH_CENTER = {lat: <?= SALTO_LAT ?>, lng: <?= SALTO_LNG ?>};
window.SFH_DETAIL_URL = "<?= url('?p=ver&slug=') ?>";
</script>
<?php if (GOOGLE_MAPS_API_KEY && GOOGLE_MAPS_API_KEY !== 'TU_API_KEY_AQUI'): ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= e(GOOGLE_MAPS_API_KEY) ?>&callback=initSFHMap" async defer></script>
<?php else: ?>
<div class="container"><div class="sfh-empty mt-3"><i class="bi bi-info-circle"></i> Configurá <code>GOOGLE_MAPS_API_KEY</code> en <code>config/config.php</code> para ver el mapa.</div></div>
<?php endif; ?>
