<?php
class Favorito
{
    public static function db(): PDO { return Database::getConnection(); }
    public static function toggle(int $uid, int $eid): bool {
        $st = self::db()->prepare("SELECT id FROM favoritos WHERE usuario_id=? AND emprendimiento_id=?");
        $st->execute([$uid,$eid]);
        if ($row = $st->fetch()) {
            self::db()->prepare("DELETE FROM favoritos WHERE id=?")->execute([$row['id']]);
            return false;
        }
        self::db()->prepare("INSERT INTO favoritos (usuario_id,emprendimiento_id) VALUES (?,?)")->execute([$uid,$eid]);
        return true;
    }
    public static function delUsuario(int $uid): array {
        $st = self::db()->prepare("SELECT e.*, c.nombre AS categoria_nombre FROM favoritos f JOIN emprendimientos e ON e.id=f.emprendimiento_id LEFT JOIN categorias c ON c.id=e.categoria_id WHERE f.usuario_id=? ORDER BY f.creado_en DESC");
        $st->execute([$uid]); return $st->fetchAll();
    }
    public static function esFavorito(int $uid, int $eid): bool {
        $st = self::db()->prepare("SELECT 1 FROM favoritos WHERE usuario_id=? AND emprendimiento_id=?");
        $st->execute([$uid,$eid]); return (bool)$st->fetchColumn();
    }
}
