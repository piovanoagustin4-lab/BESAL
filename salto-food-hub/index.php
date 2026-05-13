<?php
/**
 * SALTO FOOD HUB - Front controller
 * Punto de entrada único. Enrutador simple por parámetro ?p=
 */
require __DIR__ . '/includes/bootstrap.php';

$p = $_GET['p'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($p) {
        // ---------- Públicas ----------
        case 'home':                HomeController::index(); break;
        case 'explorar':            HomeController::explorar(); break;
        case 'ver':                 HomeController::ver(); break;
        case 'mapa':                HomeController::mapa(); break;

        // ---------- Auth ----------
        case 'login':               $method==='POST' ? AuthController::login() : AuthController::showLogin(); break;
        case 'register':            $method==='POST' ? AuthController::register() : AuthController::showRegister(); break;
        case 'logout':              AuthController::logout(); break;

        // ---------- Emprendedor ----------
        case 'nuevo-emprendimiento':$method==='POST' ? EmprendimientoController::crear() : EmprendimientoController::nuevoForm(); break;
        case 'mis-emprendimientos': EmprendimientoController::misEmprendimientos(); break;
        case 'nueva-publicacion':   EmprendimientoController::nuevaPublicacion(); break;

        // ---------- Reseñas / favoritos ----------
        case 'resena':              ResenaController::crear(); break;
        case 'favorito':            FavoritoController::toggle(); break;
        case 'favoritos':           FavoritoController::listar(); break;

        // ---------- Admin ----------
        case 'admin':
            $s = $_GET['s'] ?? 'dashboard';
            switch ($s) {
                case 'usuarios':         AdminController::usuarios(); break;
                case 'banear':           AdminController::banearUsuario(); break;
                case 'eliminar-usuario': AdminController::eliminarUsuario(); break;
                case 'emprendimientos':  AdminController::emprendimientos(); break;
                case 'aprobar-emp':      AdminController::aprobarEmprendimiento(); break;
                case 'eliminar-emp':     AdminController::eliminarEmprendimiento(); break;
                case 'categorias':       AdminController::categorias(); break;
                case 'crear-categoria':  AdminController::crearCategoria(); break;
                case 'eliminar-categoria': AdminController::eliminarCategoria(); break;
                case 'tema':             AdminController::tema(); break;
                case 'set-tema':         AdminController::setTema(); break;
                default:                 AdminController::dashboard();
            }
            break;

        default: HomeController::notFound();
    }
} catch (Throwable $e) {
    if (ENVIRONMENT === 'development') {
        echo '<pre style="padding:24px;font-family:monospace;background:#111;color:#f55;">' . e($e->getMessage()) . "\n\n" . e($e->getTraceAsString()) . '</pre>';
    } else {
        http_response_code(500);
        echo 'Ocurrió un error inesperado.';
    }
}
