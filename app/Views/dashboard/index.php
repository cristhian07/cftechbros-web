<?php
/**
 * app/Views/dashboard/index.php
 * Vista del dashboard para usuarios autenticados.
 * Muestra un mensaje de bienvenida personalizado y secciones para futuros servicios.
 */
?>
<div class="text-center bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <!-- Asegúrate de que $username no sea null antes de pasarlo a htmlspecialchars -->
    <h2 class="text-4xl font-bold text-blue-700 dark:text-blue-400 mb-6">Bienvenido/a, <span class="text-blue-800 dark:text-blue-300"><?= htmlspecialchars($username ?? 'Usuario') ?></span>!</h2>
    <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">Desde aquí podrás gestionar tus servicios contratados y acceder a soporte técnico.</p>
    
    <!-- Panel de Usuario para roles no administradores -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <!-- Tarjeta para Servicios Contratados -->
            <div class="bg-blue-50 dark:bg-blue-900/50 p-6 rounded-lg shadow-md border border-blue-100 dark:border-blue-800">
                <h3 class="text-2xl font-semibold text-blue-800 dark:text-blue-300 mb-3">Tus Servicios Contratados</h3>
                <p class="text-gray-700 dark:text-gray-400">Accede al panel para ver y gestionar todos los servicios que tienes activos con nosotros.</p>
                <a href="<?= BASE_URL ?>services" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Ver Servicios</a>
            </div>
            <!-- Tarjeta para Soporte Técnico -->
            <div class="bg-green-50 dark:bg-green-900/50 p-6 rounded-lg shadow-md border border-green-100 dark:border-green-800">
                <h3 class="text-2xl font-semibold text-green-800 dark:text-green-300 mb-3">Soporte Técnico</h3>
                <p class="text-gray-700 dark:text-gray-400">Accede a nuestro equipo de soporte para cualquier consulta o incidencia.</p>
                <?php if (\App\Core\Auth::can('open_support_ticket')): ?>
                    <a href="#" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Abrir Ticket</a>
                <?php else: ?>
                    <a href="#" class="mt-4 inline-block bg-gray-400 text-white font-bold py-2 px-4 rounded-lg cursor-not-allowed" title="Contrata el servicio de Soporte Técnico para habilitar esta opción">Abrir Ticket</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-10">
            <p class="text-lg text-gray-700 dark:text-gray-300">Mantente atento/a, pronto añadiremos nuevas funcionalidades y recursos exclusivos para ti.</p>
        </div>
    
    <div class="mt-10 text-center">
        <a href="<?= BASE_URL ?>" class="mt-6 inline-block text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300 font-semibold">Volver a la página principal</a>
    </div>
</div>
