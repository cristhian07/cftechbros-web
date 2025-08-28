<?php
/**
 * app/Views/admin/users/manage_services.php
 * Vista para asignar o revocar servicios a un usuario.
 */
?>
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-2 text-center">Gestionar Servicios de Usuario</h2>
    <p class="text-center text-gray-600 dark:text-gray-300 mb-6">Asignando servicios para: <strong class="text-blue-800 dark:text-blue-300"><?= htmlspecialchars($user['username']) ?></strong></p>

    <form action="<?= BASE_URL ?>admin/users/update-services" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Servicios Disponibles</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($all_services as $service): ?>
                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-md">
                        <input type="checkbox" 
                               id="service_<?= $service['id'] ?>" 
                               name="services[]" 
                               value="<?= $service['id'] ?>"
                               class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                               <?= in_array($service['id'], $user_services_ids) ? 'checked' : '' ?>
                        >
                        <label for="service_<?= $service['id'] ?>" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            <?= htmlspecialchars($service['name']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="<?= BASE_URL ?>admin/users" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">Guardar Cambios</button>
        </div>
    </form>
</div>