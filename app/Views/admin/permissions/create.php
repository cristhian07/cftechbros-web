<?php
/**
 * app/Views/admin/permissions/create.php
 * Vista para el formulario de creación de un nuevo permiso.
 */
?>
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-6 text-center">Crear Nueva Funcionalidad</h2>

    <?php if (isset($error) && !empty($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>admin/permissions/store" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <div>
            <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Nombre del Permiso (ej: manage_users):</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-mono" required>
        </div>
        <div>
            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Descripción:</label>
            <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
        </div>

        <hr class="my-6 border-gray-300">

        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Asociar a Servicios</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Selecciona los servicios que habilitarán esta funcionalidad a los usuarios que los contraten. Es obligatorio seleccionar al menos uno.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if (empty($services)): ?>
                    <p class="text-gray-500 dark:text-gray-400 col-span-2">No hay servicios creados. Debes crear un servicio antes de poder asignarle una funcionalidad.</p>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-md">
                            <input type="checkbox" id="service_<?= $service['id'] ?>" name="services[]" value="<?= $service['id'] ?>"
                                   class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   <?= in_array($service['id'], $old['services'] ?? []) ? 'checked' : '' ?>>
                            <label for="service_<?= $service['id'] ?>" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300"><?= htmlspecialchars($service['name']) ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="<?= BASE_URL ?>admin/permissions" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">Crear Funcionalidad</button>
        </div>
    </form>
</div>