<?php
class Resena
{
    public static function db(): PDO { return Database::getConnection(); }
    public static function porEmprendimiento(int $eid): array {
        $st = self::db()->prepare("SELECT r.*, u.nombre, u.username, u.foto_perfil FROM resenas r JOIN usuarios u ON u.id=r.usuario_id WHERE r.emprendimiento_id=? AND r.aprobada=1 ORDER BY r.creado_en DESC");
        $st->execute([$eid]); return $st->fetchAll();
    }
    public static function upsert(int $eid, int $uid, int $stars, string $comentario): void {
        $st = self::db()->prepare("INSERT INTO resenas (emprendimiento_id,usuario_id,estrellas,comentario)
            VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE estrellas=VALUES(estrellas), comentario=VALUES(comentario), creado_en=NOW()");
        $st->execute([$eid,$uid,$stars,$comentario]);
    }
    public static function delete(int $id): void {
        self::db()->prepare("DELETE FROM resenas WHERE id=?")->execute([$id]);
    }
    public static function count(): int {
        return (int)self::db()->query("SELECT COUNT(*) FROM resenas")->fetchColumn();
    }
    public static function recientes(int $limit=10): array {
        $st = self::db()->prepare("SELECT r.*, u.nombre, e.nombre AS emp_nombre FROM resenas r JOIN usuarios u ON u.id=r.usuario_id JOIN emprendimientos e ON e.id=r.emprendimiento_id ORDER BY r.creado_en DESC LIMIT ?");
        $st->bindValue(1,$limit,PDO::PARAM_INT); $st->execute(); return $st->fetchAll();
    }
}
