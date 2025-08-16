<?php
/**
 * app/Views/dashboard/index.php
 * Vista del dashboard para usuarios autenticados.
 * Muestra un mensaje de bienvenida personalizado y secciones para futuros servicios.
 */
?>
<div class="text-center bg-white p-8 rounded-lg shadow-xl border border-blue-200">
    <h2 class="text-4xl font-bold text-blue-700 mb-6">Bienvenido/a, <span class="text-blue-800"><?= htmlspecialchars($username) ?></span>!</h2>
    <p class="text-lg text-gray-700 mb-8">¡Gracias por ser parte de la comunidad de CFTechBros!</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
        <!-- Tarjeta para Servicios Contratados -->
        <div class="bg-blue-50 p-6 rounded-lg shadow-md border border-blue-100">
            <h3 class="text-2xl font-semibold text-blue-800 mb-3">Tus Servicios Contratados</h3>
            <p class="text-gray-700">Aquí podrás ver y gestionar los servicios que has contratado con CFTechBros. ¡Próximamente!</p>
            <a href="#" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Ver Servicios</a>
        </div>
        <!-- Tarjeta para Soporte Técnico -->
        <div class="bg-green-50 p-6 rounded-lg shadow-md border border-green-100">
            <h3 class="text-2xl font-semibold text-green-800 mb-3">Soporte Técnico</h3>
            <p class="text-gray-700">Accede a nuestro equipo de soporte para cualquier consulta o incidencia.</p>
            <a href="#" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Abrir Ticket</a>
        </div>
    </div>

    <div class="mt-10">
        <p class="text-lg text-gray-700">Mantente atento/a, pronto añadiremos nuevas funcionalidades y recursos exclusivos para ti.</p>
        <a href="<?= BASE_URL ?>" class="mt-6 inline-block text-blue-600 hover:underline font-semibold">Volver a la página principal</a>
    </div>
</div>
