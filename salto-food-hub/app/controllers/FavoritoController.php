<?php
class FavoritoController
{
    public static function toggle(): void {
        require_login(); verify_csrf();
        $eid = (int)($_POST['emprendimiento_id'] ?? 0);
        $now = Favorito::toggle((int)current_user()['id'], $eid);
        flash('ok', $now ? 'Agregado a favoritos.' : 'Removido de favoritos.');
        $emp = Emprendimiento::find($eid);
        redirect(url('?p=ver&slug='.urlencode($emp['slug'])));
    }

    public static function listar(): void {
        require_login();
        $items = Favorito::delUsuario((int)current_user()['id']);
        $title = 'Mis favoritos'; $view = 'perfil/favoritos';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
}
