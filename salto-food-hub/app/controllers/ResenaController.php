<?php
class ResenaController
{
    public static function crear(): void {
        require_login(); verify_csrf();
        $eid = (int)($_POST['emprendimiento_id'] ?? 0);
        $stars = max(1, min(5, (int)($_POST['estrellas'] ?? 5)));
        $coment = trim($_POST['comentario'] ?? '');
        if (strlen($coment) > 1000) $coment = substr($coment,0,1000);
        Resena::upsert($eid, (int)current_user()['id'], $stars, $coment);
        flash('ok','¡Gracias por tu reseña!');
        $emp = Emprendimiento::find($eid);
        redirect(url('?p=ver&slug='.urlencode($emp['slug'])));
    }
}
