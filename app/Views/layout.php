<?php
/**
 * app/Views/layout.php
 * Plantilla de layout principal para toda la aplicación.
 * Define la estructura HTML básica, cabecera, navegación, contenido principal y pie de página.
 * Incluye Tailwind CSS para el estilo.
 *
 * Se ha añadido funcionalidad para el cambio de modo día/noche con contraste mejorado.
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
    <!-- Iconos de Font Awesome para el botón de modo (luna/sol) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Estilo personalizado para la fuente Inter en todo el cuerpo */
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease; /* Suaviza la transición de color de fondo y texto */
        }

        /* Clases para el modo oscuro con contraste mejorado */
        .dark .bg-gray-100 { background-color: #0d1117; } /* Fondo del body (casi negro) */
        .dark .text-gray-900 { color: #f0f6fc; } /* Color de texto general (blanco brillante) */

        .dark .bg-white { background-color: #161b22; } /* Fondo de cards/secciones principales (gris oscuro) */
        .dark .text-blue-800 { color: #58a6ff; } /* Títulos azules en modo claro (azul claro para contraste) */
        .dark .text-blue-700 { color: #79c0ff; } /* Títulos más claros (azul más claro) */
        .dark .text-gray-700 { color: #c9d1d9; } /* Texto gris oscuro en modo claro (gris claro para contraste) */
        
        .dark .border-blue-200 { border-color: #30363d; } /* Bordes más oscuros */
        .dark .bg-blue-50 { background-color: #2b6cb0; } /* Fondos más claros (azul oscuro) */
        .dark .bg-blue-800 { background-color: #010409; } /* Header y Footer (casi negro, con un toque de azul) */
        .dark .text-white { color: #e6edf3; } /* Texto blanco en modo claro (grisáceo claro) */

        /* Ajustes para los botones de la cabecera */
        .dark .bg-green-600 { background-color: #2ea043; } /* Iniciar Sesión */
        .dark .hover\:bg-green-700:hover { background-color: #238636; }
        .dark .bg-blue-600 { background-color: #3b82f6; } /* Registrarse */
        .dark .hover\:bg-blue-700:hover { background-color: #2563eb; }
        .dark .bg-red-600 { background-color: #da3633; } /* Cerrar Sesión */
        .dark .hover\:bg-red-700:hover { background-color: #bb2825; }

        /* Ajustes para los placehold.co (los iconos de servicio) */
        .dark img[src*="placehold.co"] {
            /* Puedes ajustar el filtro CSS para oscurecer o invertir los colores de las imágenes si es necesario */
            /* filter: invert(0.8) hue-rotate(180deg); */ 
            background-color: #30363d; /* Fondo de los círculos de icono más oscuro */
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
            <!-- Menú de navegación y botón de modo -->
            <nav class="flex items-center space-x-4">
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
                <!-- Botón de cambio de modo día/noche -->
                <button id="theme-toggle" class="bg-blue-700 hover:bg-blue-600 text-white py-2 px-3 rounded-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-moon" id="theme-icon"></i>
                </button>
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

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;

        // Función para aplicar el tema
        function applyTheme(theme) {
            if (theme === 'dark') {
                body.classList.add('dark');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                body.classList.remove('dark');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        // Cargar el tema guardado en localStorage al cargar la página
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme) {
            applyTheme(currentTheme);
        } else {
            // Si no hay tema guardado, usa la preferencia del sistema operativo
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                applyTheme('dark');
            } else {
                applyTheme('light');
            }
        }

        // Cambiar tema al hacer clic en el botón
        themeToggle.addEventListener('click', () => {
            if (body.classList.contains('dark')) {
                applyTheme('light');
                localStorage.setItem('theme', 'light');
            } else {
                applyTheme('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
</body>
</html>
