# SALTO FOOD HUB

Plataforma para descubrir y promocionar emprendimientos gastronómicos locales en **Salto, Uruguay**.
Stack: **PHP 8+ · MySQL · Bootstrap 5 · JS puro** · MVC simple.

---

## 1. Instalación en XAMPP

1. Copiá toda la carpeta del proyecto en `xampp/htdocs/salto-food-hub`.
2. Iniciá **Apache** y **MySQL** desde el panel de XAMPP.
3. Abrí phpMyAdmin → http://localhost/phpmyadmin
4. Importá el archivo **`database/schema.sql`**. Esto crea la BD `salto_food_hub` con las tablas y datos demo.
5. Editá **`config/config.php`** y ajustá:
   - `SITE_URL` → `http://localhost/salto-food-hub`
   - `SITE_NAME` (si querés cambiar el nombre)
   - Datos de la BD (`DB_USER`, `DB_PASS`)
   - `GOOGLE_MAPS_API_KEY` (opcional, para el mapa)
6. Asegurate de que `uploads/` tenga permisos de escritura.
7. Abrí http://localhost/salto-food-hub

## 2. Cuentas demo

> **Importante:** El SQL trae usuarios demo pero el hash es de ejemplo.
> Para usar `password123` regenerá los hashes desde phpMyAdmin con:
> ```sql
> UPDATE usuarios SET password = '$2y$10$...' WHERE email='admin@saltofoodhub.uy';
> ```
> Generá tus hashes con `php -r "echo password_hash('password123', PASSWORD_BCRYPT);"`
>
> O simplemente registrá un usuario nuevo desde `/?p=register` y desde phpMyAdmin
> cambiale el rol a `admin` en la tabla `usuarios`.

## 3. Estructura

```
/app
  /controllers   Lógica (Auth, Home, Emprendimiento, Resena, Admin)
  /models        Acceso a BD (PDO)
  /views         Plantillas PHP
    /layouts     main.php / admin.php
    /partials    navbar / footer / cards
/assets          CSS / JS / imágenes
/uploads         Archivos subidos por usuarios
/config          config.php · database.php
/database        schema.sql
/includes        bootstrap.php · helpers.php
index.php        Front controller
sitemap.php      Sitemap dinámico
robots.txt
.htaccess
```

## 4. Funcionalidades

- Auth con `password_hash` + sesiones PHP + protección **CSRF**
- Roles: `usuario`, `emprendedor`, `admin`
- Crear emprendimientos, publicaciones, reseñas, favoritos
- Búsqueda + filtros + paginación + orden por rating/popularidad
- Mapa interactivo con Google Maps centrado en Salto
- Panel `/admin` (acceso vía `?p=admin`): dashboard, usuarios, emprendimientos, categorías, **5 temas de color**
- 5 temas seleccionables desde admin: `dark_orange`, `coffee`, `modern_red`, `green_food`, `light_elegant`
- Subida segura de imágenes (validación MIME + tamaño)
- Diseño responsive con Bootstrap 5 + tokens CSS modernos (glassmorphism, sombras, oklab)

## 5. Personalización

- **Nombre del sitio**: `SITE_NAME` en `config/config.php`
- **Tema por defecto**: `DEFAULT_THEME` (también editable desde `/admin → Tema`)
- **Categorías**: editables desde `/admin → Categorías`

## 6. Producción

- Cambiá `ENVIRONMENT` a `production` en `config/config.php`
- Configurá HTTPS y un dominio real en `SITE_URL`
- Restringí permisos de `uploads/` (no ejecución de PHP)
