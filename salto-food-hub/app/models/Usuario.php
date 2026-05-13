<?php
class Usuario
{
    public static function db(): PDO { return Database::getConnection(); }

    public static function findByEmail(string $email): ?array {
        $st = self::db()->prepare("SELECT * FROM usuarios WHERE email=? LIMIT 1");
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }
    public static function findByUsername(string $u): ?array {
        $st = self::db()->prepare("SELECT * FROM usuarios WHERE username=? LIMIT 1");
        $st->execute([$u]);
        return $st->fetch() ?: null;
    }
    public static function find(int $id): ?array {
        $st = self::db()->prepare("SELECT * FROM usuarios WHERE id=? LIMIT 1");
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }
    public static function create(array $data): int {
        $st = self::db()->prepare("INSERT INTO usuarios (nombre,username,email,password,rol) VALUES (?,?,?,?,?)");
        $st->execute([
            $data['nombre'],
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_ALGO),
            $data['rol'] ?? 'usuario',
        ]);
        return (int)self::db()->lastInsertId();
    }
    public static function all(int $limit = 100, int $offset = 0): array {
        $st = self::db()->prepare("SELECT id,nombre,username,email,rol,baneado,creado_en FROM usuarios ORDER BY creado_en DESC LIMIT ? OFFSET ?");
        $st->bindValue(1,$limit,PDO::PARAM_INT);
        $st->bindValue(2,$offset,PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll();
    }
    public static function count(): int {
        return (int)self::db()->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
    }
    public static function setBaneado(int $id, int $val): void {
        $st = self::db()->prepare("UPDATE usuarios SET baneado=? WHERE id=?");
        $st->execute([$val,$id]);
    }
    public static function delete(int $id): void {
        $st = self::db()->prepare("DELETE FROM usuarios WHERE id=?");
        $st->execute([$id]);
    }
}
