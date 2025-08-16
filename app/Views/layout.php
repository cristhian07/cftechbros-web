<?php
/**
 * app/Views/layout.php
 * Plantilla de layout principal para toda la aplicación.
 * Define la estructura HTML básica, cabecera, navegación, contenido principal y pie de página.
 * Incluye Tailwind CSS para el estilo.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CFTechBros - Soluciones Tecnológicas</title>
    <!-- Tailwind CSS CDN para un estilo rápido y responsivo -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fuente Google Fonts 'Inter' para una tipografía moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilo personalizado para la fuente Inter en todo el cuerpo */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <!-- Enlace a tu archivo CSS personalizado (si lo usas) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <!-- Cabecera de la página -->
    <header class="bg-blue-800 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo/Nombre de la empresa -->
            <a href="<?= BASE_URL ?>" class="text-2xl font-bold rounded-md px-2 py-1 hover:bg-blue-700 transition duration-300">CFTechBros</a>
            <!-- Menú de navegación -->
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="<?= BASE_URL ?>" class="hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Inicio</a></li>
                    <li><a href="<?= BASE_URL ?>#services" class="hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Servicios</a></li>
                    <?php if (\App\Core\Session::has('user_id')): // Si el usuario está logueado ?>
                        <li><a href="<?= BASE_URL ?>dashboard" class="hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Dashboard</a></li>
                        <li><a href="<?= BASE_URL ?>logout" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">Cerrar Sesión</a></li>
                    <?php else: // Si el usuario no está logueado ?>
                        <li><a href="<?= BASE_URL ?>login" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">Iniciar Sesión</a></li>
                        <!-- <li><a href="<?= BASE_URL ?>register" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">Registrarse</a></li> -->
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido principal (aquí se cargará la vista específica de cada página) -->
    <main class="flex-grow container mx-auto p-6 my-8 bg-white rounded-lg shadow-xl">
        <?php
        // `$path` viene del controlador y especifica qué vista cargar (ej. 'home/index')
        $viewPath = ROOT_PATH . 'app/Views/' . $path . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath; // Incluye la vista específica
        } else {
            // Mensaje de error si la vista no se encuentra (solo para depuración)
            echo '<div class="text-center text-red-500">Error: Vista no encontrada.</div>';
        }
        ?>
    </main>

    <!-- Pie de página -->
    <footer class="bg-blue-800 text-white p-6 mt-8 shadow-inner">
        <div class="container mx-auto text-center">
            <p>&copy; <?= date('Y') ?> CFTechBros. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
