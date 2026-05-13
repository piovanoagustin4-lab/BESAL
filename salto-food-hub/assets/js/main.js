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

// Google Maps callback
function initSFHMap() {
  const el = document.getElementById('sfhMap');
  if (!el || !window.google) return;
  const map = new google.maps.Map(el, {
    center: window.SFH_CENTER || { lat: -31.3833, lng: -57.9667 },
    zoom: 14,
    styles: [{ elementType:'geometry', stylers:[{color:'#1a1a1a'}]}, {elementType:'labels.text.fill', stylers:[{color:'#aaaaaa'}]}, {elementType:'labels.text.stroke', stylers:[{color:'#0f0f0f'}]}]
  });
  (window.SFH_MARKERS || []).forEach(m => {
    const mk = new google.maps.Marker({ position: { lat: m.lat, lng: m.lng }, map, title: m.nombre });
    const iw = new google.maps.InfoWindow({ content: `<div style="color:#222;min-width:160px"><strong>${m.nombre}</strong><br><small>${m.dir||''}</small><br><a href="${window.SFH_DETAIL_URL+encodeURIComponent(m.slug)}">Ver</a></div>` });
    mk.addListener('click', () => iw.open({ map, anchor: mk }));
  });
}
window.initSFHMap = initSFHMap;
