<?php
/**
 * SALTO FOOD HUB - Configuración principal
 * Edita estas constantes para personalizar tu instalación.
 */

// ====== INFORMACIÓN DEL SITIO ======
define('SITE_NAME', 'BESAL');
define('SITE_TAGLINE', 'Descubrí los sabores de Salto, Uruguay');
define('SITE_DESCRIPTION', 'Plataforma para descubrir y promocionar emprendimientos gastronómicos locales en Salto, Uruguay.');
define('SITE_URL', 'http://localhost/salto-food-hub');
define('SITE_EMAIL', 'contacto@saltofoodhub.uy');

// ====== BASE DE DATOS ======
define('DB_HOST', 'localhost');
define('DB_NAME', 'salto_food_hub');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ====== RUTAS ======
define('BASE_PATH', dirname(__DIR__));
define('UPLOADS_PATH', BASE_PATH . '/uploads');
define('UPLOADS_URL', SITE_URL . '/uploads');
define('ASSETS_URL', SITE_URL . '/assets');

// ====== SEGURIDAD ======
define('CSRF_TOKEN_NAME', 'sfh_csrf_token');
define('SESSION_NAME', 'SFH_SESSION');
define('PASSWORD_ALGO', PASSWORD_BCRYPT);

// ====== GOOGLE MAPS ======
// Obtené tu API key en: https://console.cloud.google.com/google/maps-apis
define('GOOGLE_MAPS_API_KEY', 'TU_API_KEY_AQUI');
define('SALTO_LAT', -31.3833);
define('SALTO_LNG', -57.9667);

// ====== SUBIDA DE ARCHIVOS ======
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5 MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

// ====== PAGINACIÓN ======
define('ITEMS_PER_PAGE', 12);

// ====== TEMA POR DEFECTO ======
// Opciones: dark_orange | coffee | modern_red | green_food | light_elegant
define('DEFAULT_THEME', 'dark_orange');

// ====== ENTORNO ======
define('ENVIRONMENT', 'development'); // development | production

if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

date_default_timezone_set('America/Montevideo');
