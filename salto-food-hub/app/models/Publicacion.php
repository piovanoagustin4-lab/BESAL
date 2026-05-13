<?php
class Publicacion
{
    public static function db(): PDO { return Database::getConnection(); }

    public static function feed(int $limit=20, int $offset=0): array {
        $st = self::db()->prepare("SELECT p.*, e.nombre AS emp_nombre, e.slug AS emp_slug, e.logo AS emp_logo
            FROM publicaciones p JOIN emprendimientos e ON e.id=p.emprendimiento_id
            WHERE p.activo=1 AND e.aprobado=1
            ORDER BY p.creado_en DESC LIMIT ? OFFSET ?");
        $st->bindValue(1,$limit,PDO::PARAM_INT); $st->bindValue(2,$offset,PDO::PARAM_INT);
        $st->execute(); return $st->fetchAll();
    }
    public static function byEmprendimiento(int $eid): array {
        $st = self::db()->prepare("SELECT * FROM publicaciones WHERE emprendimiento_id=? ORDER BY creado_en DESC");
        $st->execute([$eid]); return $st->fetchAll();
    }
    public static function find(int $id): ?array {
        $st = self::db()->prepare("SELECT * FROM publicaciones WHERE id=?");
        $st->execute([$id]); return $st->fetch() ?: null;
    }
    public static function create(array $d): int {
        $st = self::db()->prepare("INSERT INTO publicaciones (emprendimiento_id,titulo,descripcion,precio,imagen) VALUES (?,?,?,?,?)");
        $st->execute([$d['emprendimiento_id'],$d['titulo'],$d['descripcion'] ?? '', $d['precio'] !== '' ? $d['precio'] : null, $d['imagen'] ?? null]);
        return (int)self::db()->lastInsertId();
    }
    public static function delete(int $id): void {
        self::db()->prepare("DELETE FROM publicaciones WHERE id=?")->execute([$id]);
    }
    public static function count(): int {
        return (int)self::db()->query("SELECT COUNT(*) FROM publicaciones")->fetchColumn();
    }
}
