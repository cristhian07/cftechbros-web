<?php
/**
 * app/Views/admin/roles/edit.php
 * Vista para editar los permisos de un rol específico.
 */
?>
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-2 text-center">Editar Funcionalidades de Rol</h2>
    <p class="text-center text-gray-600 dark:text-gray-300 mb-6">Asignando funcionalidades para el rol: <strong class="text-blue-800 dark:text-blue-300 capitalize"><?= htmlspecialchars($role['name']) ?></strong></p>

    <form action="<?= BASE_URL ?>admin/roles/update" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <input type="hidden" name="role_id" value="<?= $role['id'] ?>">

        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Funcionalidades Disponibles</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if (empty($all_permissions)): ?>
                    <p class="text-gray-500 dark:text-gray-400 col-span-2">No hay funcionalidades definidas en el sistema.</p>
                <?php else: ?>
                    <?php foreach ($all_permissions as $permission): ?>
                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-md">
                            <input type="checkbox" 
                                   id="permission_<?= $permission['id'] ?>" 
                                   name="permissions[]" 
                                   value="<?= $permission['id'] ?>"
                                   class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   <?= in_array($permission['id'], $role_permissions_ids) ? 'checked' : '' ?>
                                   <?= $role['name'] === 'admin' ? 'disabled' : '' ?>
                            >
                            <label for="permission_<?= $permission['id'] ?>" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <?= htmlspecialchars($permission['description']) ?>
                                <span class="text-xs font-mono text-gray-500 dark:text-gray-400 block"><?= htmlspecialchars($permission['name']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if ($role['name'] === 'admin'): ?>
                <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-4">Las funcionalidades del rol 'admin' no se pueden modificar.</p>
            <?php endif; ?>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="<?= BASE_URL ?>admin/roles" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition" <?= $role['name'] === 'admin' ? 'disabled' : '' ?>>Guardar Cambios</button>
        </div>
    </form>
</div>