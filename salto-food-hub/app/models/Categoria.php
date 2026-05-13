<?php
class Categoria
{
    public static function db(): PDO { return Database::getConnection(); }
    public static function all(): array {
        return self::db()->query("SELECT * FROM categorias ORDER BY orden, nombre")->fetchAll();
    }
    public static function find(int $id): ?array {
        $st = self::db()->prepare("SELECT * FROM categorias WHERE id=?");
        $st->execute([$id]); return $st->fetch() ?: null;
    }
    public static function findBySlug(string $slug): ?array {
        $st = self::db()->prepare("SELECT * FROM categorias WHERE slug=?");
        $st->execute([$slug]); return $st->fetch() ?: null;
    }
    public static function create(array $d): int {
        $st = self::db()->prepare("INSERT INTO categorias (nombre,slug,icono,color,orden) VALUES (?,?,?,?,?)");
        $st->execute([$d['nombre'], slugify($d['nombre']), $d['icono'] ?? 'bi-shop', $d['color'] ?? '#ff8c42', (int)($d['orden'] ?? 0)]);
        return (int)self::db()->lastInsertId();
    }
    public static function delete(int $id): void {
        self::db()->prepare("DELETE FROM categorias WHERE id=?")->execute([$id]);
    }
}
