<section class="sfh-section">
  <div class="container">
    <h1 class="sfh-section-title">Mapa de Salto</h1>
    <p class="text-muted">Encontrá los emprendimientos cerca tuyo.</p>
    <div id="sfhMap" class="sfh-map-full"></div>
  </div>
</section>

<script>
window.SFH_MARKERS = <?= json_encode(array_map(function($m){
  return [
    'nombre'=>$m['nombre'],
    'slug'=>$m['slug'],
    'lat'=>(float)$m['latitud'],
    'lng'=>(float)$m['longitud'],
    'dir'=>$m['direccion']
  ];
}, $marcadores), JSON_UNESCAPED_UNICODE) ?>;

window.SFH_CENTER = {
  lat: <?= SALTO_LAT ?>,
  lng: <?= SALTO_LNG ?>
};

window.SFH_DETAIL_URL = "<?= url('?p=ver&slug=') ?>";
</script>

<!-- Leaflet CSS -->
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet/dist/leaflet.css"
/>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {

  const map = L.map('sfhMap').setView(
    [window.SFH_CENTER.lat, window.SFH_CENTER.lng],
    13
  );

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  window.SFH_MARKERS.forEach(marker => {

    const popup = `
      <div>
        <strong>${marker.nombre}</strong><br>
        <small>${marker.dir ?? ''}</small><br><br>
        <a href="${window.SFH_DETAIL_URL + marker.slug}">
          Ver emprendimiento
        </a>
      </div>
    `;

    L.marker([marker.lat, marker.lng])
      .addTo(map)
      .bindPopup(popup);

  });

});
</script>
