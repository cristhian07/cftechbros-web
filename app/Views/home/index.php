<?php
/**
 * app/Views/home/index.php
 * Vista de la página principal de presentación de CFTechBros, con un diseño moderno.
 */
?>
<section class="text-center mb-12">
    <h1 class="text-5xl font-extrabold text-blue-800 mb-4 animate-fade-in-down">CFTechBros: Tu Socio en Innovación Tecnológica</h1>
    <p class="text-xl text-gray-700 max-w-3xl mx-auto animate-fade-in-up">
        Transformamos tus ideas en soluciones digitales robustas y escalables. Expertos en desarrollo de software, consultoría y soluciones a medida.
    </p>
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
