<?php
class Emprendimiento
{
    public static function db(): PDO { return Database::getConnection(); }

    public static function search(array $f = []): array {
        $sql = "SELECT e.*, c.nombre AS categoria_nombre, c.icono AS categoria_icono,
                       (SELECT AVG(estrellas) FROM resenas r WHERE r.emprendimiento_id=e.id AND r.aprobada=1) AS rating,
                       (SELECT COUNT(*) FROM resenas r WHERE r.emprendimiento_id=e.id AND r.aprobada=1) AS reviews
                FROM emprendimientos e
                LEFT JOIN categorias c ON c.id = e.categoria_id
                WHERE e.aprobado=1";
        $params = [];
        if (!empty($f['q'])) { $sql .= " AND (e.nombre LIKE ? OR e.descripcion LIKE ? OR e.direccion LIKE ?)"; $q="%{$f['q']}%"; array_push($params,$q,$q,$q); }
        if (!empty($f['categoria_id'])) { $sql .= " AND e.categoria_id=?"; $params[] = (int)$f['categoria_id']; }
        $orden = $f['orden'] ?? 'recientes';
        $sql .= match($orden) {
            'rating' => " ORDER BY rating DESC, reviews DESC",
            'populares' => " ORDER BY visitas DESC",
            default => " ORDER BY e.creado_en DESC",
        };
        $limit = (int)($f['limit'] ?? 50); $offset = (int)($f['offset'] ?? 0);
        $sql .= " LIMIT $limit OFFSET $offset";
        $st = self::db()->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public static function countAll(array $f = []): int {
        $sql = "SELECT COUNT(*) FROM emprendimientos e WHERE e.aprobado=1";
        $params=[];
        if (!empty($f['q'])) { $sql.=" AND (e.nombre LIKE ? OR e.descripcion LIKE ?)"; $q="%{$f['q']}%"; array_push($params,$q,$q); }
        if (!empty($f['categoria_id'])) { $sql.=" AND e.categoria_id=?"; $params[]=(int)$f['categoria_id']; }
        $st=self::db()->prepare($sql); $st->execute($params); return (int)$st->fetchColumn();
    }

    public static function find(int $id): ?array {
        $st = self::db()->prepare("SELECT e.*, c.nombre AS categoria_nombre FROM emprendimientos e LEFT JOIN categorias c ON c.id=e.categoria_id WHERE e.id=?");
        $st->execute([$id]); return $st->fetch() ?: null;
    }
    public static function findBySlug(string $slug): ?array {
        $st = self::db()->prepare("SELECT e.*, c.nombre AS categoria_nombre FROM emprendimientos e LEFT JOIN categorias c ON c.id=e.categoria_id WHERE e.slug=?");
        $st->execute([$slug]); return $st->fetch() ?: null;
    }
    public static function byUsuario(int $uid): array {
        $st = self::db()->prepare("SELECT * FROM emprendimientos WHERE usuario_id=? ORDER BY creado_en DESC");
        $st->execute([$uid]); return $st->fetchAll();
    }
    public static function create(array $d): int {
        $slug = slugify($d['nombre']) . '-' . substr(bin2hex(random_bytes(2)),0,4);
        $st = self::db()->prepare("INSERT INTO emprendimientos
            (usuario_id,categoria_id,nombre,slug,descripcion,direccion,telefono,whatsapp,instagram,facebook,horarios,latitud,longitud,logo,portada)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $st->execute([
            $d['usuario_id'], $d['categoria_id'] ?: null, $d['nombre'], $slug,
            $d['descripcion'] ?? '', $d['direccion'] ?? '', $d['telefono'] ?? '',
            $d['whatsapp'] ?? '', $d['instagram'] ?? '', $d['facebook'] ?? '',
            $d['horarios'] ?? '', $d['latitud'] ?: null, $d['longitud'] ?: null,
            $d['logo'] ?? null, $d['portada'] ?? null,
        ]);
        return (int)self::db()->lastInsertId();
    }
    public static function update(int $id, array $d): void {
        $st = self::db()->prepare("UPDATE emprendimientos SET categoria_id=?, nombre=?, descripcion=?, direccion=?, telefono=?, whatsapp=?, instagram=?, facebook=?, horarios=?, latitud=?, longitud=? WHERE id=?");
        $st->execute([$d['categoria_id'] ?: null, $d['nombre'], $d['descripcion'] ?? '', $d['direccion'] ?? '', $d['telefono'] ?? '', $d['whatsapp'] ?? '', $d['instagram'] ?? '', $d['facebook'] ?? '', $d['horarios'] ?? '', $d['latitud'] ?: null, $d['longitud'] ?: null, $id]);
    }
    public static function setLogo(int $id, string $file): void {
        self::db()->prepare("UPDATE emprendimientos SET logo=? WHERE id=?")->execute([$file,$id]);
    }
    public static function aprobar(int $id, int $val): void {
        self::db()->prepare("UPDATE emprendimientos SET aprobado=? WHERE id=?")->execute([$val,$id]);
    }
    public static function delete(int $id): void {
        self::db()->prepare("DELETE FROM emprendimientos WHERE id=?")->execute([$id]);
    }
    public static function incrementarVisita(int $id): void {
        self::db()->prepare("UPDATE emprendimientos SET visitas=visitas+1 WHERE id=?")->execute([$id]);
    }
    public static function destacados(int $limit=6): array {
        return self::db()->query("SELECT e.*, c.nombre AS categoria_nombre FROM emprendimientos e LEFT JOIN categorias c ON c.id=e.categoria_id WHERE e.aprobado=1 AND e.destacado=1 ORDER BY e.creado_en DESC LIMIT $limit")->fetchAll();
    }
    public static function paraMapa(): array {
        return self::db()->query("SELECT id,nombre,slug,latitud,longitud,direccion,logo FROM emprendimientos WHERE aprobado=1 AND latitud IS NOT NULL AND longitud IS NOT NULL")->fetchAll();
    }
    public static function count(): int {
        return (int)self::db()->query("SELECT COUNT(*) FROM emprendimientos")->fetchColumn();
    }
    public static function pendientes(): array {
        return self::db()->query("SELECT e.*, u.nombre AS owner FROM emprendimientos e JOIN usuarios u ON u.id=e.usuario_id WHERE e.aprobado=0 ORDER BY e.creado_en DESC")->fetchAll();
    }
}
