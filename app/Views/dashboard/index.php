<?php
/**
 * app/Views/dashboard/index.php
 * Vista del dashboard para usuarios autenticados.
 * Muestra un mensaje de bienvenida personalizado y secciones para futuros servicios.
 */
?>
<div class="text-center bg-white p-8 rounded-lg shadow-xl border border-blue-200">
    <!-- Asegúrate de que $username no sea null antes de pasarlo a htmlspecialchars -->
    <h2 class="text-4xl font-bold text-blue-700 mb-6">Bienvenido/a, <span class="text-blue-800"><?= htmlspecialchars($username ?? 'Usuario') ?></span>!</h2>
    <p class="text-lg text-gray-700 mb-8">¡Gracias por ser parte de la comunidad de CFTechBros!</p>

    <?php if (\App\Core\Auth::isAdmin()): ?>
        <!-- Panel de Administración para el rol Admin -->
        <div class="mt-2 border-t pt-8">
            <h3 class="text-3xl font-semibold text-gray-800 mb-4">Panel de Administración</h3>
            <p class="text-gray-600 mb-6">Accede a las herramientas de administración del sitio.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <?php if (\App\Core\Auth::can('manage_users')): ?>
                    <a href="<?= BASE_URL ?>admin/users" class="inline-block bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Gestionar Usuarios</a>
                <?php endif; ?>
                <?php if (\App\Core\Auth::can('manage_roles')): ?>
                    <a href="<?= BASE_URL ?>admin/roles" class="inline-block bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Gestionar Roles</a>
                <?php endif; ?>
                <?php if (\App\Core\Auth::can('manage_service_permissions')): ?>
                    <a href="<?= BASE_URL ?>admin/services" class="inline-block bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Permisos de Servicios</a>
                <?php endif; ?>
                <?php if (\App\Core\Auth::can('view_admin_contacts')): ?>
                    <a href="<?= BASE_URL ?>admin/contacts" class="inline-block bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Ver Mensajes</a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Panel de Usuario para otros roles -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <!-- Tarjeta para Servicios Contratados -->
            <div class="bg-blue-50 p-6 rounded-lg shadow-md border border-blue-100">
                <h3 class="text-2xl font-semibold text-blue-800 mb-3">Tus Servicios Contratados</h3>
                <p class="text-gray-700">Accede al panel para ver y gestionar todos los servicios que tienes activos con nosotros.</p>
                <a href="<?= BASE_URL ?>services" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Ver Servicios</a>
            </div>
            <!-- Tarjeta para Soporte Técnico -->
            <div class="bg-green-50 p-6 rounded-lg shadow-md border border-green-100">
                <h3 class="text-2xl font-semibold text-green-800 mb-3">Soporte Técnico</h3>
                <p class="text-gray-700">Accede a nuestro equipo de soporte para cualquier consulta o incidencia.</p>
                <?php if (\App\Core\Auth::can('open_support_ticket')): ?>
                    <a href="#" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Abrir Ticket</a>
                <?php else: ?>
                    <a href="#" class="mt-4 inline-block bg-gray-400 text-white font-bold py-2 px-4 rounded-lg cursor-not-allowed" title="Contrata el servicio de Soporte Técnico para habilitar esta opción">Abrir Ticket</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-10">
            <p class="text-lg text-gray-700">Mantente atento/a, pronto añadiremos nuevas funcionalidades y recursos exclusivos para ti.</p>
        </div>
    <?php endif; ?>

    <div class="mt-10 text-center">
        <a href="<?= BASE_URL ?>" class="mt-6 inline-block text-blue-600 hover:underline font-semibold">Volver a la página principal</a>
    </div>
</div>
