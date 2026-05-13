// SALTO FOOD HUB - main.js
document.addEventListener('DOMContentLoaded', () => {
  // Auto-dismiss toasts
  document.querySelectorAll('.sfh-toast').forEach(t => {
    setTimeout(() => { t.style.transition = 'opacity .3s'; t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 4000);
  });

  // Lazy loading nativo
  document.querySelectorAll('img').forEach(img => { if (!img.hasAttribute('loading')) img.setAttribute('loading','lazy'); });

  // Suave scroll a anchors
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const id = a.getAttribute('href').slice(1);
      const t = document.getElementById(id);
      if (t) { e.preventDefault(); t.scrollIntoView({behavior:'smooth'}); }
    });
  });
});

// Leaflet + OpenStreetMap
function initSFHMap() {
  const el = document.getElementById('sfhMap');

  if (!el || typeof L === 'undefined') {
    return;
  }

  const map = L.map('sfhMap').setView(
    [
      window.SFH_CENTER?.lat || -31.3833,
      window.SFH_CENTER?.lng || -57.9667
    ],
    14
  );

  // Estilo claro moderno tipo Apple Maps
  L.tileLayer(
    'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
    {
      attribution: '&copy; OpenStreetMap & CARTO'
    }
  ).addTo(map);

  (window.SFH_MARKERS || []).forEach(m => {

    const popup = `
      <div style="min-width:180px">
        <strong>${m.nombre}</strong><br>
        <small>${m.dir || ''}</small><br><br>

        <a href="${window.SFH_DETAIL_URL + encodeURIComponent(m.slug)}">
          Ver emprendimiento
        </a>
      </div>
    `;

    L.marker([m.lat, m.lng])
      .addTo(map)
      .bindPopup(popup);

  });
}

window.addEventListener('DOMContentLoaded', () => {
  initSFHMap();
});