<?php
/**
 * app/Views/dashboard_layout.php
 * Plantilla de layout para el panel de control de todos los usuarios.
 * Define la estructura con una barra lateral de navegación y un área de contenido principal.
 */
use App\Core\Auth;
use App\Core\Session;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> - CFTechBros</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configuración de Tailwind CSS para habilitar el modo oscuro basado en clases.
        // Esto es necesario cuando se usa el CDN de Tailwind.
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <!-- Google Fonts 'Inter' -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --bg-body-start: #e0f2fe;
            --bg-body-mid: #f0f4f8;
            --bg-body-end: #fefce8;
            --bg-card: #ffffff;
            --bg-card-secondary: #f9fafb;
            --bg-header: #1e40af;
            --text-main: #1f2937;
            --text-secondary: #4b5563;
            --text-muted: #6b7280;
            --text-accent: #1d4ed8;
            --text-accent-light: #2563eb;
            --text-inverted: #ffffff;
            --border-primary: #e5e7eb;
            --border-secondary: #d1d5db;
        }

        html.dark {
            --bg-body-start: #010409;
            --bg-body-mid: #0d1117;
            --bg-body-end: #1f1a24;
            --bg-card: #161b22;
            --bg-card-secondary: #0d1117;
            --bg-header: #010409;
            --text-main: #f9fafb;
            --text-secondary: #d1d5db;
            --text-muted: #9ca3af;
            --text-accent: #60a5fa;
            --text-accent-light: #93c5fd;
            --text-inverted: #f9fafb;
            --border-primary: #30363d;
            --border-secondary: #4a5568;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
        }

        /* Estilos para inputs en modo oscuro */
        html.dark input, html.dark textarea, html.dark select {
            background-color: var(--bg-card-secondary);
            color: var(--text-main);
            border-color: var(--border-secondary);
        }

        /* Custom styles for dashboard layout */
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
            color: #d1d5db; /* text-gray-300 */
        }
        .sidebar-link:hover {
            background-color: #374151; /* bg-gray-700 */
            color: #ffffff;
        }
        .sidebar-link.active {
            background-color: #2563eb; /* bg-blue-600 */
            color: #ffffff;
            font-weight: 600;
        }
        .sidebar-link i {
            width: 1.25rem; /* w-5 */
            margin-right: 0.75rem; /* mr-3 */
            text-align: center;
        }
        .sidebar-separator {
            padding: 1rem 1rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #9ca3af; /* text-gray-400 */
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-gray-800 dark:bg-black/25 p-4 flex flex-col">
            <div class="text-center mb-8">
                <a href="<?= BASE_URL ?>dashboard" class="text-2xl font-bold text-white">CFTechBros</a>
                <span class="text-sm text-blue-300 block">Panel de Usuario</span>
            </div>
            <nav class="flex-grow">
                <ul class="space-y-2">
                    <li>
                        <a href="<?= BASE_URL ?>dashboard" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php if (!Auth::isAdmin()): // Solo mostrar "Mis Servicios" a usuarios no administradores ?>
                    <li>
                        <a href="<?= BASE_URL ?>services" class="sidebar-link <?= (strpos($_SERVER['REQUEST_URI'], '/services') !== false && strpos($_SERVER['REQUEST_URI'], 'admin/services') === false) ? 'active' : '' ?>">
                            <i class="fas fa-briefcase"></i>
                            <span>Mis Servicios</span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if (Auth::isAdmin()): // Separador para la sección de administración ?>
                    <li class="sidebar-separator">
                        <span>Administración</span>
                    </li>
                    <?php endif; ?>

                    <?php if (Auth::can('manage_users')): ?>
                    <li>
                        <a href="<?= BASE_URL ?>admin/users" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'admin/users') !== false ? 'active' : '' ?>">
                            <i class="fas fa-users"></i>
                            <span>Gestionar Usuarios</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (Auth::can('manage_roles')): ?>
                    <li>
                        <a href="<?= BASE_URL ?>admin/roles" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'admin/roles') !== false ? 'active' : '' ?>">
                            <i class="fas fa-user-shield"></i>
                            <span>Gestionar Roles</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (Auth::can('manage_service_permissions')): ?>
                    <li>
                        <a href="<?= BASE_URL ?>admin/services" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'admin/services') !== false ? 'active' : '' ?>">
                            <i class="fas fa-cogs"></i>
                            <span>Permisos Servicios</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (Auth::can('view_admin_contacts')): ?>
                    <li>
                        <a href="<?= BASE_URL ?>admin/contacts" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'admin/contacts') !== false ? 'active' : '' ?>">
                            <i class="fas fa-envelope"></i>
                            <span class="flex-grow">Ver Mensajes</span>
                            <?php if (isset($unread_messages_count) && $unread_messages_count > 0): ?>
                                <span class="bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"><?= $unread_messages_count ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="pt-4 border-t border-gray-700">
                <a href="<?= BASE_URL ?>" class="sidebar-link">
                    <i class="fas fa-globe"></i>
                    <span>Volver al Sitio</span>
                </a>
                <a href="<?= BASE_URL ?>logout" class="sidebar-link mt-2 text-red-400 hover:bg-red-500 hover:text-white">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-md p-4 flex justify-between items-center">
                <div class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                    <?php if (Auth::isAdmin()): ?>
                        Panel de Administración
                    <?php else: ?>
                        Panel de Usuario
                    <?php endif; ?>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 dark:text-gray-300">Hola, <?= htmlspecialchars(Session::get('username', 'Usuario')) ?></span>
                    <button id="theme-toggle" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 py-2 px-3 rounded-md transition duration-300 focus:outline-none">
                        <i class="fas fa-moon" id="theme-icon"></i>
                    </button>
                </div>
            </header>
            
            <!-- Content area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6">
                <?php
                // `$path` viene del controlador y especifica qué vista cargar (ej. 'admin/dashboard')
                $viewPath = ROOT_PATH . 'app/Views/' . $path . '.php';
                if (file_exists($viewPath)) {
                    require_once $viewPath; // Incluye la vista específica
                } else {
                    echo '<div class="text-center text-red-500">Error: Vista no encontrada en ' . htmlspecialchars($viewPath) . '.</div>';
                }
                ?>
            </main>
        </div>
    </div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const htmlEl = document.documentElement;

        function applyTheme(theme) {
            if (theme === 'dark') {
                htmlEl.classList.add('dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                htmlEl.classList.remove('dark');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        const currentTheme = localStorage.getItem('theme');
        if (currentTheme) {
            applyTheme(currentTheme);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            applyTheme('dark');
        } else {
            applyTheme('light');
        }

        themeToggle.addEventListener('click', () => {
            const newTheme = htmlEl.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>
</html>