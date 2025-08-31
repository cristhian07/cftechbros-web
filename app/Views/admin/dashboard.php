<?php
/**
 * app/Views/admin/dashboard.php
 * Vista de bienvenida para el panel de administración.
 */
?>
<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-4xl font-bold text-blue-700 dark:text-blue-400 mb-4">¡Bienvenido al Panel de Administración!</h2>
    <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
        Hola, <span class="font-semibold"><?= htmlspecialchars($username ?? 'Admin') ?></span>. Desde aquí puedes gestionar el contenido y los usuarios del sitio.
    </p>

    <?php if (isset($unread_messages_count) && $unread_messages_count > 0): ?>
        <div class="bg-yellow-100 dark:bg-yellow-900/30 border-l-4 border-yellow-500 text-yellow-800 dark:text-yellow-200 p-4 rounded-md mb-6 shadow-md" role="alert">
            <div class="flex items-center">
                <div class="py-1"><i class="fas fa-exclamation-triangle text-2xl mr-4"></i></div>
                <div>
                    <p class="font-bold">¡Atención!</p>
                    <p>
                        Tienes <strong><?= $unread_messages_count ?></strong> <?= $unread_messages_count == 1 ? 'mensaje nuevo pendiente' : 'mensajes nuevos pendientes' ?> de revisión.
                        <a href="<?= BASE_URL ?>admin/contacts" class="font-semibold underline hover:text-yellow-600 dark:hover:text-yellow-100 transition">
                            Ir a mensajes
                        </a>.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <p class="text-gray-600 dark:text-gray-400">
        Utiliza la barra de navegación a la izquierda para acceder a las diferentes secciones de administración.
    </p>
    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Accesos Rápidos</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if (\App\Core\Auth::can('manage_users')): ?>
                <a href="<?= BASE_URL ?>admin/users" class="bg-blue-100 dark:bg-blue-900/50 p-4 rounded-lg flex items-center hover:bg-blue-200 dark:hover:bg-blue-800/50 transition">
                    <i class="fas fa-users text-blue-500 text-2xl mr-4"></i>
                    <div>
                        <h4 class="font-semibold text-blue-800 dark:text-blue-300">Gestionar Usuarios</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Editar roles y servicios.</p>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (\App\Core\Auth::can('manage_roles')): ?>
                 <a href="<?= BASE_URL ?>admin/roles" class="bg-green-100 dark:bg-green-900/50 p-4 rounded-lg flex items-center hover:bg-green-200 dark:hover:bg-green-800/50 transition">
                    <i class="fas fa-user-shield text-green-500 text-2xl mr-4"></i>
                    <div>
                        <h4 class="font-semibold text-green-800 dark:text-green-300">Gestionar Roles</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Definir permisos para roles.</p>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (\App\Core\Auth::can('manage_permissions')): ?>
                 <a href="<?= BASE_URL ?>admin/permissions" class="bg-purple-100 dark:bg-purple-900/50 p-4 rounded-lg flex items-center hover:bg-purple-200 dark:hover:bg-purple-800/50 transition">
                    <i class="fas fa-key text-purple-500 text-2xl mr-4"></i>
                    <div>
                        <h4 class="font-semibold text-purple-800 dark:text-purple-300">Funcionalidades</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Crear y editar funcionalidades.</p>
                    </div>
                </a>
            <?php endif; ?>
            <?php if (\App\Core\Auth::can('view_admin_contacts')): ?>
                 <a href="<?= BASE_URL ?>admin/contacts" class="bg-yellow-100 dark:bg-yellow-900/50 p-4 rounded-lg flex items-center hover:bg-yellow-200 dark:hover:bg-yellow-800/50 transition">
                    <i class="fas fa-envelope text-yellow-500 text-2xl mr-4"></i>
                    <div>
                        <h4 class="font-semibold text-yellow-800 dark:text-yellow-300">Mensajes de Contacto</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Revisar los envíos del formulario.</p>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>