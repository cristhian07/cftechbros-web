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
    <script>
        // Configuración de Tailwind CSS para habilitar el modo oscuro basado en clases.
        // Esto es necesario cuando se usa el CDN de Tailwind.
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <!-- Fuente Google Fonts 'Inter' para una tipografía moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Iconos de Font Awesome para el botón de modo (luna/sol) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* 
         * Se utilizan variables CSS (:root) para estandarizar los colores en toda la aplicación.
         * Esto mejora la consistencia entre navegadores y facilita el mantenimiento del tema.
         * El tema oscuro se activa simplemente añadiendo la clase 'dark' al tag <html>,
         * lo que sobreescribe las variables de color.
        */
        :root {
            --bg-body-start: #e0f2fe;
            --bg-body-mid: #f0f4f8;
            --bg-body-end: #fefce8;
            --bg-card: #ffffff;
            --bg-card-secondary: #f9fafb; /* bg-gray-50 */
            --bg-header: #1e40af; /* bg-blue-800 */
            --text-main: #1f2937; /* text-gray-800 */
            --text-secondary: #4b5563; /* text-gray-600 */
            --text-muted: #6b7280; /* text-gray-500 */
            --text-accent: #1d4ed8; /* text-blue-800 */
            --text-accent-light: #2563eb; /* text-blue-700 */
            --text-inverted: #ffffff;
            --border-primary: #e5e7eb; /* border-gray-200 */
            --border-secondary: #d1d5db; /* border-gray-300 */
            --service-card-bg: rgba(255, 255, 255, 0.2);
            --service-card-border: rgba(255, 255, 255, 0.3);
        }

        html.dark {
            --bg-body-start: #010409;
            --bg-body-mid: #0d1117;
            --bg-body-end: #1f1a24;
            --bg-card: #161b22;
            --bg-card-secondary: #0d1117; /* Same as body bg for subtle difference */
            --bg-header: #010409;
            --text-main: #f9fafb; /* gray-50, casi blanco */
            --text-secondary: #d1d5db; /* gray-300, gris claro */
            --text-muted: #9ca3af; /* gray-400, gris más suave */
            --text-accent: #60a5fa;
            --text-accent-light: #93c5fd;
            --text-inverted: #f9fafb;
            --border-primary: #30363d;
            --border-secondary: #4a5568;
            --service-card-bg: rgba(22, 27, 34, 0.5);
            --service-card-border: rgba(56, 62, 74, 0.8);
        }

        /* 
         * Overrides para las clases de utilidad de Tailwind en modo oscuro.
         * Esto asegura que los componentes que usan clases de Tailwind (ej. text-gray-700)
         * también se adapten al tema oscuro, usando los colores definidos en las variables CSS.
        */
        html.dark .text-gray-900,
        html.dark .text-gray-800 { color: var(--text-main); }
        html.dark .text-gray-700,
        html.dark .text-gray-600 { color: var(--text-secondary); }
        html.dark .text-gray-500 { color: var(--text-muted); }

        html.dark .bg-white { background-color: var(--bg-card); }
        html.dark .bg-gray-50,
        html.dark .bg-gray-100 { background-color: var(--bg-card-secondary); }

        html.dark .border-gray-200,
        html.dark .border-blue-300 { border-color: var(--border-primary); }
        html.dark .border-gray-300 { border-color: var(--border-secondary); }
        html.dark .divide-gray-200 > :not([hidden]) ~ :not([hidden]) { border-color: var(--border-primary); }

        html.dark .text-blue-800 { color: var(--text-accent); }
        html.dark .text-blue-700 { color: var(--text-accent-light); }
        html.dark .text-blue-600 { color: var(--text-accent-light); }
        html.dark .text-indigo-600 { color: #a5b4fc; } /* indigo-300 */
        html.dark .hover\:text-indigo-900:hover { color: #818cf8; } /* indigo-400 */
        html.dark .text-red-600 { color: #f87171; } /* red-400 */
        html.dark .hover\:text-red-900:hover { color: #ef4444; } /* red-500 */
        
        html.dark .placeholder-gray-400::placeholder { color: var(--text-muted); }

        /* Estilos para inputs en modo oscuro para garantizar la visibilidad del texto */
        html.dark input[type="text"],
        html.dark input[type="password"],
        html.dark input[type="email"],
        html.dark textarea {
            background-color: var(--bg-card);
            color: var(--text-main);
            border-color: var(--border-secondary);
        }

        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
            color: var(--text-main);
            background-color: var(--bg-body-mid);
            background-image: linear-gradient(135deg, var(--bg-body-start) 0%, var(--bg-body-mid) 50%, var(--bg-body-end) 100%);
        }
    </style>
    <!-- Enlace a tu archivo CSS personalizado (si lo usas) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body class="min-h-screen flex flex-col">
    <!-- Cabecera de la página -->
    <header class="p-4 shadow-md" style="background-color: var(--bg-header); color: var(--text-inverted);">
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
    <main class="flex-grow <?php 
        // En la página de inicio, no se aplican los estilos de contenedor para permitir un banner de ancho completo.
        if ($path !== 'home/index') echo 'container mx-auto p-6 my-8'; 
    ?>">
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
    <footer class="p-6 mt-8 shadow-inner" style="background-color: var(--bg-header); color: var(--text-inverted);">
        <div class="container mx-auto text-center">
            <p>&copy; <?= date('Y') ?> CFTechBros. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const htmlEl = document.documentElement;

        // Función para aplicar el tema
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
            if (htmlEl.classList.contains('dark')) {
                applyTheme('light');
                localStorage.setItem('theme', 'light');
            } else {
                applyTheme('dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // Lógica para el banner de la página de inicio
        document.addEventListener('DOMContentLoaded', () => {
            const bannerContainer = document.getElementById('banner-container');
            if (bannerContainer) {
                const slider = document.getElementById('banner-slider');
                const slides = document.querySelectorAll('.banner-slide');
                const prevBtn = document.getElementById('banner-prev');
                const nextBtn = document.getElementById('banner-next');
                const dotsContainer = document.getElementById('banner-dots');
                
                let currentSlide = 0;
                const totalSlides = slides.length;
                let slideInterval;

                if (totalSlides > 1) {
                    // Crear puntos de navegación
                    for (let i = 0; i < totalSlides; i++) {
                        const dot = document.createElement('button');
                        dot.classList.add('banner-dot');
                        dot.addEventListener('click', () => goToSlide(i));
                        dotsContainer.appendChild(dot);
                    }
                    const dots = dotsContainer.children;

                    // Función para ir a un slide específico
                    const goToSlide = (slideIndex) => {
                        slider.style.transform = `translateX(-${slideIndex * 100}%)`;
                        
                        // Quitar clase 'active' del slide y dot actual
                        slides[currentSlide].classList.remove('active');
                        if (dots.length > 0) {
                            dots[currentSlide].classList.remove('active');
                        }

                        // Añadir clase 'active' al nuevo slide y dot
                        slides[slideIndex].classList.add('active');
                        if (dots.length > 0) {
                            dots[slideIndex].classList.add('active');
                        }

                        currentSlide = slideIndex;
                        resetInterval();
                    };

                    // Función para reiniciar el intervalo de auto-desplazamiento
                    const resetInterval = () => {
                        clearInterval(slideInterval);
                        slideInterval = setInterval(() => {
                            goToSlide((currentSlide + 1) % totalSlides);
                        }, 7000); // Cambia de imagen cada 7 segundos
                    };

                    // Event listeners para los botones
                    nextBtn.addEventListener('click', () => goToSlide((currentSlide + 1) % totalSlides));
                    prevBtn.addEventListener('click', () => goToSlide((currentSlide - 1 + totalSlides) % totalSlides));

                    // Iniciar el carrusel
                    goToSlide(0);
                }
            }
        });
    </script>
</body>
</html>
