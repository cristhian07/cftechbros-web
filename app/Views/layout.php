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

        /* Estilos específicos para el fondo de la página de login */
        .login-background {
            /* Se recomienda usar una imagen local para mejor rendimiento y estabilidad */
            background-image: url('https://images.unsplash.com/photo-1522252234503-e356532cafd5?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Fija la imagen para que no se mueva con el scroll */
        }
        /* Superposición oscura para mejorar la legibilidad del contenido sobre la imagen */
        .login-background::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        /* Asegura que el contenido principal (header, main, footer) esté por encima de la superposición */
        .login-background > * {
            position: relative;
            z-index: 1;
        }

        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
            color: var(--text-main);
            background-color: var(--bg-body-mid);
            background-image: linear-gradient(135deg, var(--bg-body-start) 0%, var(--bg-body-mid) 50%, var(--bg-body-end) 100%);
        }

        /* Elimina el resaltado azul/gris por defecto al tocar en navegadores móviles */
        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        /* --- Animación para el menú móvil --- */
        /* Por defecto, el menú está colapsado (altura máxima 0) y su contenido oculto */
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out;
        }
        /* Cuando tiene la clase 'menu-open', se expande a una altura suficiente para mostrar su contenido */
        #mobile-menu.menu-open {
            max-height: 30rem; /* ~480px, un valor suficientemente grande */
        }
    </style>
    <!-- Enlace a tu archivo CSS personalizado (si lo usas) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body class="min-h-screen flex flex-col <?php if ($path === 'auth/login') echo 'login-background'; ?>">
    <!-- Cabecera de la página -->
    <header class="shadow-md sticky top-0 z-50" style="background-color: var(--bg-header); color: var(--text-inverted);">
        <div class="container mx-auto flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
            <!-- Logo/Nombre de la empresa -->
            <a href="<?= BASE_URL ?>" class="text-2xl font-bold rounded-md px-2 py-1 hover:bg-blue-700 transition duration-300">CFTechBros</a>
            
            <!-- Menú de navegación para escritorio -->
            <nav class="hidden md:flex items-center space-x-4">
                <a href="<?= BASE_URL ?>" class="hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Inicio</a>
                <a href="<?= BASE_URL ?>#services" class="hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Servicios</a>
                <?php if (\App\Core\Session::has('user_id')): // Si el usuario está logueado ?>
                    <a href="<?= BASE_URL ?>dashboard" class="hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Dashboard</a>
                    <a href="<?= BASE_URL ?>logout" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">Cerrar Sesión</a>
                <?php else: // Si el usuario no está logueado ?>
                    <a href="<?= BASE_URL ?>login" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">Iniciar Sesión</a>
                <?php endif; ?>
                <!-- Botón de cambio de modo día/noche -->
                <button id="theme-toggle" class="bg-blue-700 hover:bg-blue-600 text-white py-2 px-3 rounded-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-moon" id="theme-icon"></i>
                </button>
            </nav>

            <!-- Botón de hamburguesa para móvil -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-400">
                    <span class="sr-only">Abrir menú principal</span>
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </div>
        </div>

        <!-- Menú desplegable para móvil -->
        <div class="md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="<?= BASE_URL ?>" class="block hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Inicio</a>
                <a href="<?= BASE_URL ?>#services" class="block hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Servicios</a>
                <?php if (\App\Core\Session::has('user_id')): ?>
                    <a href="<?= BASE_URL ?>dashboard" class="block hover:text-blue-200 transition duration-300 rounded-md px-3 py-2">Dashboard</a>
                    <a href="<?= BASE_URL ?>logout" class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300 text-center">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>login" class="block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300 text-center">Iniciar Sesión</a>
                <?php endif; ?>
                
                <!-- Botón de cambio de modo día/noche para móvil -->
                <div class="pt-4 pb-3 border-t border-blue-700">
                    <div class="flex items-center px-3">
                        <button id="theme-toggle-mobile" class="bg-blue-700 hover:bg-blue-600 text-white py-2 px-3 rounded-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-moon" id="theme-icon-mobile"></i>
                        </button>
                        <span class="ml-3 text-base font-medium">Cambiar Tema</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido principal (aquí se cargará la vista específica de cada página) -->
    <main class="flex-grow <?php 
        // En páginas como inicio o login, no se aplican los estilos de contenedor para permitir un diseño de ancho completo.
        if (!in_array($path, ['home/index', 'auth/login'])) {
            echo 'container mx-auto p-6 my-8';
        }
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
        // --- Lógica para el cambio de tema (Día/Noche) ---
        const themeToggles = [document.getElementById('theme-toggle'), document.getElementById('theme-toggle-mobile')];
        const themeIcons = [document.getElementById('theme-icon'), document.getElementById('theme-icon-mobile')];
        const htmlEl = document.documentElement;

        // Función para aplicar el tema y actualizar los íconos
        function applyTheme(theme) {
            if (theme === 'dark') {
                htmlEl.classList.add('dark');
                themeIcons.forEach(icon => {
                    if (icon) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    }
                });
            } else {
                htmlEl.classList.remove('dark');
                themeIcons.forEach(icon => {
                    if (icon) {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                });
            }
        }

        // Función para cambiar el tema y guardarlo
        function toggleTheme() {
            const newTheme = htmlEl.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        }

        // Añadir event listener a ambos botones
        themeToggles.forEach(button => {
            if (button) {
                button.addEventListener('click', toggleTheme);
            }
        });

        // Cargar el tema guardado al iniciar
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme) {
            applyTheme(currentTheme);
        } else {
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                applyTheme('dark');
            } else {
                applyTheme('light');
            }
        }
        
        // --- Lógica para el menú móvil y el banner ---
        document.addEventListener('DOMContentLoaded', () => {
            // Lógica para el menú móvil
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('menu-open');
                    const icon = mobileMenuButton.querySelector('i');
                    icon.classList.toggle('fa-bars');
                    icon.classList.toggle('fa-times'); // Cambia a un ícono de 'X'
                });
            }

            // Lógica para el banner de la página de inicio
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

            // --- Lógica para animar elementos al hacer scroll ---
            const scrollElements = document.querySelectorAll('.animate-on-scroll');

            if (scrollElements.length > 0) {
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        // Si el elemento está en el viewport
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            // Dejar de observar el elemento una vez que es visible para que no se repita
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1 // La animación se dispara cuando el 10% del elemento es visible
                });

                scrollElements.forEach(el => {
                    observer.observe(el);
                });
            }
        });
    </script>
</body>
</html>
