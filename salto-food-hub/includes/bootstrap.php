<?php
/**
 * Bootstrap del sistema. Cargado por todos los front controllers.
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';

session_name(SESSION_NAME);
session_start();

// Autoload simple para Models/Controllers
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/models/' . $class . '.php',
        BASE_PATH . '/app/controllers/' . $class . '.php',
    ];
    foreach ($paths as $p) {
        if (file_exists($p)) { require_once $p; return; }
    }
});
