<?php
/**
 * app/Views/home/index.php
 * Vista de la página principal de presentación de CFTechBros, con un diseño moderno.
 */
?>
<!-- Sección de Banner Dinámico -->
<section id="banner-container" class="relative h-80 md:h-96 mb-12 overflow-hidden rounded-lg shadow-2xl">
    <!-- Contenedor de las imágenes del slider -->
    <div id="banner-slider" class="h-full w-full flex transition-transform duration-1000 ease-in-out">
        <!-- Slide 1 -->
        <div class="banner-slide h-full w-full flex-shrink-0 bg-cover bg-center" style="background-image: url('<?= BASE_URL ?>images/banner-tech-1.jpg');"></div>
        <!-- Slide 2 -->
        <div class="banner-slide h-full w-full flex-shrink-0 bg-cover bg-center" style="background-image: url('<?= BASE_URL ?>images/banner-tech-2.jpg');"></div>
        <!-- Slide 3 -->
        <div class="banner-slide h-full w-full flex-shrink-0 bg-cover bg-center" style="background-image: url('<?= BASE_URL ?>images/banner-tech-3.jpg');"></div>
    </div>

    <!-- Capa de superposición con texto -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-center text-white p-4">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 animate-fade-in-down" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
            CFTechBros: Tu Socio en Innovación Tecnológica
        </h1>
        <p class="text-lg md:text-xl max-w-3xl mx-auto animate-fade-in-up" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
            Transformamos tus ideas en soluciones digitales robustas y escalables.
        </p>
    </div>

    <!-- Botones de Navegación -->
    <button id="banner-prev" class="banner-nav-btn absolute top-1/2 left-4 -translate-y-1/2">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button id="banner-next" class="banner-nav-btn absolute top-1/2 right-4 -translate-y-1/2">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Puntos de Navegación -->
    <div id="banner-dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
        <!-- Los puntos se generarán con JS -->
    </div>
</section>

<!-- Separador visual -->
<hr class="my-12 border-blue-300" id="services">

<section class="mb-12">
    <h2 class="text-4xl font-bold text-center text-blue-700 mb-10">Nuestros Servicios Destacados</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
        <!-- Tarjeta de Servicio 1 -->
        <div class="service-card p-8 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
            <div class="icon-container mx-auto mb-6 w-20 h-20 flex items-center justify-center rounded-full text-white text-4xl">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h3 class="text-2xl font-semibold text-blue-800 mb-4">Desarrollo de Software a Medida</h3>
            <p class="text-gray-700 text-lg">
                Creamos aplicaciones web y móviles personalizadas que se adaptan perfectamente a tus necesidades de negocio. Desde MVPs hasta sistemas empresariales complejos.
            </p>
        </div>
        <!-- Tarjeta de Servicio 2 -->
        <div class="service-card p-8 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
            <div class="icon-container mx-auto mb-6 w-20 h-20 flex items-center justify-center rounded-full text-white text-4xl">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <h3 class="text-2xl font-semibold text-blue-800 mb-4">Consultoría Cloud y DevOps</h3>
            <p class="text-gray-700 text-lg">
                Optimizamos tu infraestructura y procesos con soluciones en la nube (AWS, Azure, GCP) y metodologías DevOps para una entrega continua y eficiente.
            </p>
        </div>
        <!-- Tarjeta de Servicio 3 -->
        <div class="service-card p-8 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
            <div class="icon-container mx-auto mb-6 w-20 h-20 flex items-center justify-center rounded-full text-white text-4xl">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="text-2xl font-semibold text-blue-800 mb-4">Ciberseguridad y Auditorías</h3>
            <p class="text-gray-700 text-lg">
                Protegemos tus activos digitales con auditorías de seguridad, implementación de políticas y soluciones avanzadas contra amenazas cibernéticas.
            </p>
        </div>
        <!-- Tarjeta de Servicio 4 -->
        <div class="service-card p-8 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
            <div class="icon-container mx-auto mb-6 w-20 h-20 flex items-center justify-center rounded-full text-white text-4xl">
                <i class="fas fa-brain"></i>
            </div>
            <h3 class="text-2xl font-semibold text-blue-800 mb-4">Inteligencia Artificial y ML</h3>
            <p class="text-gray-700 text-lg">
                Integramos soluciones de IA y ML para automatizar procesos, analizar datos y tomar decisiones más inteligentes, impulsando tu negocio.
            </p>
        </div>
        <!-- Tarjeta de Servicio 5 -->
        <div class="service-card p-8 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
            <div class="icon-container mx-auto mb-6 w-20 h-20 flex items-center justify-center rounded-full text-white text-4xl">
                <i class="fas fa-headset"></i>
            </div>
            <h3 class="text-2xl font-semibold text-blue-800 mb-4">Soporte y Mantenimiento TI</h3>
            <p class="text-gray-700 text-lg">
                Garantizamos el funcionamiento óptimo de tus sistemas con soporte técnico proactivo y mantenimiento continuo, 24/7.
            </p>
        </div>
        <!-- Tarjeta de Servicio 6 -->
        <div class="service-card p-8 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
            <div class="icon-container mx-auto mb-6 w-20 h-20 flex items-center justify-center rounded-full text-white text-4xl">
                <i class="fas fa-chart-pie"></i>
            </div>
            <h3 class="text-2xl font-semibold text-blue-800 mb-4">Análisis de Datos y BI</h3>
            <p class="text-gray-700 text-lg">
                Transformamos tus datos en información valiosa para una toma de decisiones estratégica, utilizando herramientas de BI líderes en el mercado.
            </p>
        </div>
    </div>
</section>

<section class="text-center py-10">
    <h2 class="text-3xl font-bold text-blue-700 mb-4">¿Listo para Impulsar tu Negocio?</h2>
    <p class="text-lg text-gray-700 mb-6">Contáctanos hoy mismo para discutir tus proyectos y necesidades tecnológicas.</p>
    <div class="flex flex-wrap justify-center items-center gap-4">
        <a href="<?= BASE_URL ?>contact" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
            Contáctanos
        </a>
        <a href="https://wa.me/+51923497380?text=Hola,%20quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20sus%20servicios." target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 transform hover:scale-105 flex items-center">
            <i class="fab fa-whatsapp mr-2"></i> WhatsApp
        </a>
    </div>
</section>
