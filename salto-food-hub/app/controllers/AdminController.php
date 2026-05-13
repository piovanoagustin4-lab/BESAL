<?php
class AdminController
{
    public static function dashboard(): void {
        require_role('admin');
        $stats = [
            'usuarios' => Usuario::count(),
            'emprendimientos' => Emprendimiento::count(),
            'publicaciones' => Publicacion::count(),
            'resenas' => Resena::count(),
        ];
        $pendientes = Emprendimiento::pendientes();
        $recientes = Resena::recientes(8);
        $title = 'Panel admin · ' . SITE_NAME; $view = 'admin/dashboard';
        require BASE_PATH . '/app/views/layouts/admin.php';
    }
    public static function usuarios(): void {
        require_role('admin');
        $items = Usuario::all(200,0);
        $title='Usuarios'; $view='admin/usuarios';
        require BASE_PATH . '/app/views/layouts/admin.php';
    }
    public static function banearUsuario(): void {
        require_role('admin'); verify_csrf();
        $id=(int)$_POST['id']; $val=(int)$_POST['val'];
        Usuario::setBaneado($id,$val);
        flash('ok','Usuario actualizado.'); redirect(url('?p=admin&s=usuarios'));
    }
    public static function eliminarUsuario(): void {
        require_role('admin'); verify_csrf();
        Usuario::delete((int)$_POST['id']);
        flash('ok','Usuario eliminado.'); redirect(url('?p=admin&s=usuarios'));
    }
    public static function emprendimientos(): void {
        require_role('admin');
        $items = Emprendimiento::search(['limit'=>200]);
        $pendientes = Emprendimiento::pendientes();
        $title='Emprendimientos'; $view='admin/emprendimientos';
        require BASE_PATH . '/app/views/layouts/admin.php';
    }
    public static function aprobarEmprendimiento(): void {
        require_role('admin'); verify_csrf();
        Emprendimiento::aprobar((int)$_POST['id'],(int)$_POST['val']);
        flash('ok','Estado actualizado.'); redirect(url('?p=admin&s=emprendimientos'));
    }
    public static function eliminarEmprendimiento(): void {
        require_role('admin'); verify_csrf();
        Emprendimiento::delete((int)$_POST['id']);
        flash('ok','Eliminado.'); redirect(url('?p=admin&s=emprendimientos'));
    }
    public static function categorias(): void {
        require_role('admin');
        $items = Categoria::all();
        $title='Categorías'; $view='admin/categorias';
        require BASE_PATH . '/app/views/layouts/admin.php';
    }
    public static function crearCategoria(): void {
        require_role('admin'); verify_csrf();
        Categoria::create([
            'nombre'=>trim($_POST['nombre'] ?? ''),
            'icono'=>trim($_POST['icono'] ?? 'bi-shop'),
            'color'=>trim($_POST['color'] ?? '#ff8c42'),
            'orden'=>(int)($_POST['orden'] ?? 0),
        ]);
        flash('ok','Categoría creada.'); redirect(url('?p=admin&s=categorias'));
    }
    public static function eliminarCategoria(): void {
        require_role('admin'); verify_csrf();
        Categoria::delete((int)$_POST['id']);
        flash('ok','Eliminada.'); redirect(url('?p=admin&s=categorias'));
    }
    public static function tema(): void {
        require_role('admin');
        $title='Tema visual'; $view='admin/tema';
        require BASE_PATH . '/app/views/layouts/admin.php';
    }
    public static function setTema(): void {
        require_role('admin'); verify_csrf();
        $tema = $_POST['tema'] ?? DEFAULT_THEME;
        $valid = ['dark_orange','coffee','modern_red','green_food','light_elegant'];
        if (!in_array($tema,$valid,true)) $tema = DEFAULT_THEME;
        $st = Database::getConnection()->prepare("INSERT INTO configuraciones (clave,valor) VALUES ('tema_activo',?) ON DUPLICATE KEY UPDATE valor=VALUES(valor)");
        $st->execute([$tema]);
        flash('ok','Tema actualizado.'); redirect(url('?p=admin&s=tema'));
    }
}
