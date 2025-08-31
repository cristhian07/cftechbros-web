<?php
/**
 * app/Views/admin/services/edit.php
 * Vista para editar los permisos que otorga un servicio específico.
 */
?>
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-6 text-center">Editar Servicio</h2>

    <form action="<?= BASE_URL ?>admin/services/update" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <input type="hidden" name="service_id" value="<?= $service['id'] ?>">

        <div>
            <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Nombre del Servicio:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($service['name']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div>
            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Descripción:</label>
            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required><?= htmlspecialchars($service['description']) ?></textarea>
        </div>
        <div>
            <label for="icon_class" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Clase del Icono (Font Awesome):</label>
            <input type="text" id="icon_class" name="icon_class" value="<?= htmlspecialchars($service['icon_class']) ?>" placeholder="Ej: fas fa-chart-line" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div>
            <label for="image_url" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">URL de la Imagen (para la página principal):</label>
            <input type="text" id="image_url" name="image_url" value="<?= htmlspecialchars($service['image_url'] ?? '') ?>" placeholder="Ej: images/services/development.jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div class="flex items-center">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" <?= !empty($service['is_featured']) ? 'checked' : '' ?>>
            <label for="is_featured" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Marcar como servicio destacado en la página principal</label>
        </div>

        <hr class="my-6 border-gray-300">

        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Funcionalidades que Otorga este Servicio</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if (empty($all_permissions)): ?>
                    <p class="text-gray-500 dark:text-gray-400 col-span-2">No hay funcionalidades definidas en el sistema.</p>
                <?php else: ?>
                    <?php foreach ($all_permissions as $permission): ?>
                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-md">
                            <input type="checkbox" 
                                   id="permission_<?= $permission['id'] ?>" 
                                   name="permissions[]" 
                                   value="<?= htmlspecialchars($permission['name']) ?>"
                                   class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   <?= in_array($permission['name'], $service_permissions) ? 'checked' : '' ?>
                            >
                            <label for="permission_<?= $permission['id'] ?>" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <?= htmlspecialchars($permission['name']) ?>
                                <span class="text-xs text-gray-500 dark:text-gray-400 block"><?= htmlspecialchars($permission['description']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="<?= BASE_URL ?>admin/services" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">Guardar Cambios</button>
        </div>
    </form>
</div>