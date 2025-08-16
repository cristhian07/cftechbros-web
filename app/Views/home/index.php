<?php
/**
 * app/Views/home/index.php
 * Vista de la página principal de presentación de CFTechBros.
 * Muestra una introducción a la empresa y sus servicios destacados.
 */
?>
<section class="text-center mb-12">
    <h1 class="text-5xl font-extrabold text-blue-800 mb-4 animate-fade-in-down">CFTechBros: Tu Socio en Innovación Tecnológica</h1>
    <p class="text-xl text-gray-700 max-w-3xl mx-auto animate-fade-in-up">
        Transformamos tus ideas en soluciones digitales robustas y escalables. Expertos en desarrollo de software, consultoría y soluciones a medida.
    </p>
    <div class="mt-8 flex justify-center space-x-4">
        <!-- Botón para registrarse (condicional si no está logueado, aunque aquí siempre se muestra) -->
        <a href="<?= BASE_URL ?>register" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
            ¡Regístrate ahora!
        </a>
        <!-- Botón para ir a la sección de servicios en la misma página -->
        <a href="#services" class="bg-gray-200 hover:bg-gray-300 text-blue-800 font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
            Nuestros Servicios
        </a>
    </div>
</section>

<!-- Separador visual -->
<hr class="my-12 border-blue-300" id="services">

<section class="mb-12">
    <h2 class="text-4xl font-bold text-center text-blue-700 mb-10">Nuestros Servicios Destacados</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Tarjeta de Servicio 1 -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-blue-200">
            <img src="https://placehold.co/100x100/A7F3D0/10B981?text=Dev" alt="Desarrollo de Software a Medida" class="mx-auto mb-6 rounded-full p-2 bg-blue-100">
            <h3 class="text-2xl font-semibold text-blue-800 mb-4 text-center">Desarrollo de Software a Medida</h3>
            <p class="text-gray-700 text-lg text-center">
                Creamos aplicaciones web y móviles personalizadas que se adaptan perfectamente a tus necesidades de negocio. Desde MVPs hasta sistemas empresariales complejos.
            </p>
        </div>
        <!-- Tarjeta de Servicio 2 -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-blue-200">
            <img src="https://placehold.co/100x100/FEE2E2/EF4444?text=Cloud" alt="Consultoría Cloud y DevOps" class="mx-auto mb-6 rounded-full p-2 bg-blue-100">
            <h3 class="text-2xl font-semibold text-blue-800 mb-4 text-center">Consultoría Cloud y DevOps</h3>
            <p class="text-gray-700 text-lg text-center">
                Optimizamos tu infraestructura y procesos con soluciones en la nube (AWS, Azure, GCP) y metodologías DevOps para una entrega continua y eficiente.
            </p>
        </div>
        <!-- Tarjeta de Servicio 3 -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-blue-200">
            <img src="https://placehold.co/100x100/D1FAE5/065F46?text=Seg" alt="Ciberseguridad y Auditorías" class="mx-auto mb-6 rounded-full p-2 bg-blue-100">
            <h3 class="text-2xl font-semibold text-blue-800 mb-4 text-center">Ciberseguridad y Auditorías</h3>
            <p class="text-gray-700 text-lg text-center">
                Protegemos tus activos digitales con auditorías de seguridad, implementación de políticas y soluciones avanzadas contra amenazas cibernéticas.
            </p>
        </div>
        <!-- Tarjeta de Servicio 4 -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-blue-200">
            <img src="https://placehold.co/100x100/DBEAFE/3B82F6?text=IA" alt="Inteligencia Artificial y Machine Learning" class="mx-auto mb-6 rounded-full p-2 bg-blue-100">
            <h3 class="text-2xl font-semibold text-blue-800 mb-4 text-center">Inteligencia Artificial y Machine Learning</h3>
            <p class="text-gray-700 text-lg text-center">
                Integramos soluciones de IA y ML para automatizar procesos, analizar datos y tomar decisiones más inteligentes, impulsando tu negocio.
            </p>
        </div>
        <!-- Tarjeta de Servicio 5 -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-blue-200">
            <img src="https://placehold.co/100x100/F0F9FF/60A5FA?text=Sop" alt="Soporte y Mantenimiento TI" class="mx-auto mb-6 rounded-full p-2 bg-blue-100">
            <h3 class="text-2xl font-semibold text-blue-800 mb-4 text-center">Soporte y Mantenimiento TI</h3>
            <p class="text-gray-700 text-lg text-center">
                Garantizamos el funcionamiento óptimo de tus sistemas con soporte técnico proactivo y mantenimiento continuo, 24/7.
            </p>
        </div>
        <!-- Tarjeta de Servicio 6 -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-blue-200">
            <img src="https://placehold.co/100x100/D1FAE5/065F46?text=Data" alt="Análisis de Datos y Business Intelligence" class="mx-auto mb-6 rounded-full p-2 bg-blue-100">
            <h3 class="text-2xl font-semibold text-blue-800 mb-4 text-center">Análisis de Datos y Business Intelligence</h3>
            <p class="text-gray-700 text-lg text-center">
                Transformamos tus datos en información valiosa para una toma de decisiones estratégica, utilizando herramientas de BI líderes en el mercado.
            </p>
        </div>
    </div>
</section>

<!-- Sección de llamada a la acción -->
<section class="text-center py-10 bg-blue-50 rounded-lg shadow-inner">
    <h2 class="text-3xl font-bold text-blue-700 mb-4">¿Listo para Impulsar tu Negocio?</h2>
    <p class="text-lg text-gray-700 mb-6">Contáctanos hoy mismo para discutir tus proyectos y necesidades tecnológicas.</p>
    <a href="#" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
        Contáctanos
    </a>
</section>
