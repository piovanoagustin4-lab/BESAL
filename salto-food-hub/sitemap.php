<?php
require __DIR__ . '/includes/bootstrap.php';
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
$urls = [url('?p=home'), url('?p=explorar'), url('?p=mapa')];
foreach ($urls as $u) echo "<url><loc>".htmlspecialchars($u)."</loc></url>\n";
foreach (Emprendimiento::search(['limit'=>500]) as $e) {
    echo "<url><loc>".htmlspecialchars(url('?p=ver&slug='.$e['slug']))."</loc></url>\n";
}
echo '</urlset>';
