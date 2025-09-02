<?php
/**
 * app/Views/home/index.php
 * Vista de la página principal de presentación de CFTechBros, con un diseño moderno.
 */
?>
<!-- Sección de Banner Dinámico (Ajustado para Móvil) -->
<section id="banner-container" class="relative h-[500px] md:h-[500px] overflow-hidden group">
    <!-- Contenedor de las imágenes del slider. Ocupa todo el ancho. -->
    <div id="banner-slider" class="h-full w-full flex transition-transform duration-700 ease-in-out">
        <!-- Slide 1 -->
        <div class="banner-slide relative h-full w-full flex-shrink-0 bg-cover bg-center" style="background-image: url('<?= BASE_URL ?>images/banner-tech-1.jpg');">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent md:bg-gradient-to-l flex flex-col justify-center items-center text-center md:items-end md:text-right p-6 md:p-16">
                <div class="text-content text-white max-w-2xl">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                        Innovación y Desarrollo a tu Medida
                    </h2>
                    <p class="text-lg md:text-xl mb-6" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
                        Transformamos tus ideas en soluciones digitales robustas y escalables.
                    </p>
                    <a href="<?= BASE_URL ?>contact" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                        Empieza tu Proyecto
                    </a>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="banner-slide relative h-full w-full flex-shrink-0 bg-cover bg-center" style="background-image: url('<?= BASE_URL ?>images/banner-tech-2.jpg');">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent md:bg-gradient-to-l flex flex-col justify-center items-center text-center md:items-end md:text-right p-6 md:p-16">
                <div class="text-content text-white max-w-2xl">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                        Optimización Cloud y DevOps
                    </h2>
                    <p class="text-lg md:text-xl mb-6" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
                        Llevamos tu infraestructura al siguiente nivel con agilidad y eficiencia.
                    </p>
                    <a href="<?= BASE_URL ?>#services" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                        Descubre Nuestros Servicios
                    </a>
                </div>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="banner-slide relative h-full w-full flex-shrink-0 bg-cover bg-center" style="background-image: url('<?= BASE_URL ?>images/banner-tech-3.jpg');">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent md:bg-gradient-to-l flex flex-col justify-center items-center text-center md:items-end md:text-right p-6 md:p-16">
                <div class="text-content text-white max-w-2xl">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                        Seguridad Digital Integral
                    </h2>
                    <p class="text-lg md:text-xl mb-6" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
                        Protegemos tus activos más valiosos con estrategias de ciberseguridad avanzadas.
                    </p>
                    <a href="<?= BASE_URL ?>contact" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                        Solicita una Auditoría
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de Navegación -->
    <button id="banner-prev" class="banner-nav-btn absolute top-1/2 left-4 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button id="banner-next" class="banner-nav-btn absolute top-1/2 right-4 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Puntos de Navegación -->
    <div id="banner-dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-3">
        <!-- Los puntos se generarán con JS -->
    </div>
</section>

<!-- Contenedor para el resto del contenido de la página, centrado y con padding -->
<div class="container mx-auto px-6">

    <!-- Separador visual -->
    <hr class="my-16 border-blue-300" id="services">

    <section class="mb-16">
        <h2 class="text-4xl font-bold text-center text-blue-700 mb-10">Nuestros Servicios Destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                    <!-- Tarjeta de Servicio Dinámica -->
                    <div class="service-card rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                        <img src="<?= BASE_URL . htmlspecialchars($service['image_url']) ?>" alt="<?= htmlspecialchars($service['name']) ?>" class="w-full h-48 object-cover rounded-t-2xl" loading="lazy">
                        <div class="p-6 text-center">
                            <h3 class="text-2xl font-semibold text-blue-800 mb-4"><?= htmlspecialchars($service['name']) ?></h3>
                            <p class="text-gray-700 text-lg">
                                <?= htmlspecialchars($service['description']) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-500 col-span-full">No hay servicios destacados para mostrar en este momento.</p>
            <?php endif; ?>
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
</div>
