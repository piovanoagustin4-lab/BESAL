<?php
class EmprendimientoController
{
    public static function nuevoForm(): void {
        require_login();
        $categorias = Categoria::all();
        $title = 'Nuevo emprendimiento'; $view = 'emprendimientos/form';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    public static function crear(): void {
        require_login(); verify_csrf();
        $u = current_user();
        $logo = isset($_FILES['logo']) ? upload_image($_FILES['logo'], 'logos') : null;
        $portada = isset($_FILES['portada']) ? upload_image($_FILES['portada'], 'logos') : null;
        $id = Emprendimiento::create([
            'usuario_id' => $u['id'],
            'categoria_id' => (int)($_POST['categoria_id'] ?? 0),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'whatsapp' => trim($_POST['whatsapp'] ?? ''),
            'instagram' => trim($_POST['instagram'] ?? ''),
            'facebook' => trim($_POST['facebook'] ?? ''),
            'horarios' => trim($_POST['horarios'] ?? ''),
            'latitud' => $_POST['latitud'] ?? null,
            'longitud' => $_POST['longitud'] ?? null,
            'logo' => $logo, 'portada' => $portada,
        ]);
        // Promover usuario a emprendedor si aún no lo es
        if ($u['rol'] === 'usuario') {
            Database::getConnection()->prepare("UPDATE usuarios SET rol='emprendedor' WHERE id=?")->execute([$u['id']]);
            $_SESSION['user']['rol'] = 'emprendedor';
        }
        flash('ok','Emprendimiento creado. Pendiente de aprobación.');
        redirect(url('?p=mis-emprendimientos'));
    }
    public static function misEmprendimientos(): void {
        require_login();
        $items = Emprendimiento::byUsuario((int)current_user()['id']);
        $title = 'Mis emprendimientos'; $view = 'emprendimientos/mis';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    public static function nuevaPublicacion(): void {
        require_login(); verify_csrf();
        $eid = (int)($_POST['emprendimiento_id'] ?? 0);
        $emp = Emprendimiento::find($eid);
        if (!$emp || $emp['usuario_id'] != current_user()['id']) { flash('error','No autorizado.'); redirect(url('?p=mis-emprendimientos')); }
        $img = isset($_FILES['imagen']) ? upload_image($_FILES['imagen'],'publicaciones') : null;
        Publicacion::create([
            'emprendimiento_id' => $eid,
            'titulo' => trim($_POST['titulo'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio' => $_POST['precio'] ?? '',
            'imagen' => $img,
        ]);
        flash('ok','Publicación creada.');
        redirect(url('?p=mis-emprendimientos'));
    }
}
