<?php
class HomeController
{
    public static function index(): void {
        $categorias = Categoria::all();
        $destacados = Emprendimiento::destacados(6);
        $feed = Publicacion::feed(8);
        $title = SITE_NAME . ' · ' . SITE_TAGLINE;
        $view = 'home/index';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    public static function explorar(): void {
        $categorias = Categoria::all();
        $f = [
            'q' => trim($_GET['q'] ?? ''),
            'categoria_id' => (int)($_GET['categoria_id'] ?? 0),
            'orden' => $_GET['orden'] ?? 'recientes',
        ];
        $total = Emprendimiento::countAll($f);
        $pg = paginate_args($total);
        $f['limit']=$pg['limit']; $f['offset']=$pg['offset'];
        $emprendimientos = Emprendimiento::search($f);
        $title = 'Explorar emprendimientos · ' . SITE_NAME;
        $view = 'emprendimientos/lista';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    public static function ver(): void {
        $slug = $_GET['slug'] ?? '';
        $emp = Emprendimiento::findBySlug($slug);
        if (!$emp) { http_response_code(404); $view='404'; $title='No encontrado'; require BASE_PATH.'/app/views/layouts/main.php'; return; }
        Emprendimiento::incrementarVisita((int)$emp['id']);
        $publicaciones = Publicacion::byEmprendimiento((int)$emp['id']);
        $resenas = Resena::porEmprendimiento((int)$emp['id']);
        $promedio = 0; if ($resenas) { $promedio = array_sum(array_column($resenas,'estrellas'))/count($resenas); }
        $esFav = is_logged_in() ? Favorito::esFavorito((int)$_SESSION['user']['id'], (int)$emp['id']) : false;
        $title = $emp['nombre'] . ' · ' . SITE_NAME;
        $view = 'emprendimientos/detalle';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    public static function mapa(): void {
        $marcadores = Emprendimiento::paraMapa();
        $title = 'Mapa · ' . SITE_NAME; $view = 'emprendimientos/mapa';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    public static function notFound(): void {
        http_response_code(404); $title='404'; $view='404';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
}
