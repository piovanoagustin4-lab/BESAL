<?php
/**
 * Funciones de utilidad globales.
 */

function csrf_token(): string {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

function csrf_field(): string {
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . csrf_token() . '">';
}

function verify_csrf(): void {
    $token = $_POST[CSRF_TOKEN_NAME] ?? '';
    if (!hash_equals($_SESSION[CSRF_TOKEN_NAME] ?? '', $token)) {
        http_response_code(403);
        die('Token CSRF inválido.');
    }
}

function e(?string $str): string {
    return htmlspecialchars((string)$str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function url(string $path = ''): string {
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}

function asset(string $path): string {
    return rtrim(ASSETS_URL, '/') . '/' . ltrim($path, '/');
}

function uploaded(string $file, string $folder = ''): string {
    if (!$file) return asset('img/placeholder.svg');
    return rtrim(UPLOADS_URL, '/') . '/' . ($folder ? trim($folder,'/') . '/' : '') . $file;
}

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool {
    return !empty($_SESSION['user']);
}

function require_login(): void {
    if (!is_logged_in()) redirect(url('?p=login'));
}

function require_role(string $role): void {
    require_login();
    if (($_SESSION['user']['rol'] ?? '') !== $role) {
        http_response_code(403);
        die('Acceso denegado.');
    }
}

function flash(string $key, ?string $msg = null) {
    if ($msg !== null) { $_SESSION['_flash'][$key] = $msg; return; }
    $m = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $m;
}

function slugify(string $text): string {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
    $text = strtolower(trim($text));
    $text = preg_replace('/[\s-]+/', '-', $text);
    return $text ?: 'item';
}

function upload_image(array $file, string $folder): ?string {
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > MAX_UPLOAD_SIZE) return null;
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!in_array($mime, ALLOWED_IMAGE_TYPES, true)) return null;
    $ext = match($mime) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        default => 'bin',
    };
    $name = bin2hex(random_bytes(8)) . '.' . $ext;
    $dest = UPLOADS_PATH . '/' . trim($folder,'/') . '/' . $name;
    if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0775, true);
    if (!move_uploaded_file($file['tmp_name'], $dest)) return null;
    return $name;
}

function paginate_args(int $total, int $perPage = ITEMS_PER_PAGE): array {
    $page = max(1, (int)($_GET['page'] ?? 1));
    $pages = max(1, (int)ceil($total / $perPage));
    $page = min($page, $pages);
    return ['page' => $page, 'pages' => $pages, 'offset' => ($page - 1) * $perPage, 'limit' => $perPage];
}

function get_setting(string $key, $default = null) {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        try {
            $rows = Database::getConnection()->query("SELECT clave, valor FROM configuraciones")->fetchAll();
            foreach ($rows as $r) $cache[$r['clave']] = $r['valor'];
        } catch (Throwable $e) {}
    }
    return $cache[$key] ?? $default;
}

function active_theme(): string {
    return get_setting('tema_activo', DEFAULT_THEME);
}
