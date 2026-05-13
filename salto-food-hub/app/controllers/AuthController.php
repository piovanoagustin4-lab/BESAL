<?php
class AuthController
{
    public static function showLogin(): void {
        $title = 'Iniciar sesión'; $view = 'auth/login';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    public static function showRegister(): void {
        $title = 'Crear cuenta'; $view = 'auth/register';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    public static function login(): void {
        verify_csrf();
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';
        $u = Usuario::findByEmail($email);
        if (!$u || !password_verify($pass, $u['password'])) {
            flash('error', 'Credenciales inválidas.'); redirect(url('?p=login'));
        }
        if ($u['baneado']) { flash('error','Tu cuenta está suspendida.'); redirect(url('?p=login')); }
        unset($u['password']);
        $_SESSION['user'] = $u;
        flash('ok','¡Bienvenido, ' . $u['nombre'] . '!');
        redirect(url($u['rol']==='admin' ? '?p=admin' : '?p=home'));
    }
    public static function register(): void {
        verify_csrf();
        $data = [
            'nombre'   => trim($_POST['nombre'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'rol'      => in_array($_POST['rol'] ?? 'usuario', ['usuario','emprendedor'], true) ? $_POST['rol'] : 'usuario',
        ];
        $errors = [];
        if (strlen($data['nombre']) < 2) $errors[] = 'Nombre inválido.';
        if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/',$data['username'])) $errors[]='Username inválido (3-30, letras/números/_).';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[]='Email inválido.';
        if (strlen($data['password']) < 6) $errors[]='La contraseña debe tener al menos 6 caracteres.';
        if (Usuario::findByEmail($data['email'])) $errors[]='Ese email ya está registrado.';
        if (Usuario::findByUsername($data['username'])) $errors[]='Ese username ya existe.';
        if ($errors) { flash('error', implode('<br>',$errors)); redirect(url('?p=register')); }
        $id = Usuario::create($data);
        $u = Usuario::find($id); unset($u['password']);
        $_SESSION['user'] = $u;
        flash('ok','¡Cuenta creada!');
        redirect(url('?p=home'));
    }
    public static function logout(): void {
        $_SESSION = []; session_destroy();
        redirect(url('?p=home'));
    }
}
