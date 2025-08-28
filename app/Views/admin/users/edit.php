<?php
/**
 * app/Views/admin/users/edit.php
 * Vista para editar el rol de un usuario.
 */
?>
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-2 text-center">Asignar Rol a Usuario</h2>
    <p class="text-center text-gray-600 dark:text-gray-300 mb-6">Estás editando el rol para: <strong class="text-blue-800 dark:text-blue-300"><?= htmlspecialchars($user['username']) ?></strong></p>

    <form action="<?= BASE_URL ?>admin/users/update-role" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <div>
            <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Selecciona un nuevo rol:</label>
            <select id="role_id" name="role_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars(ucfirst($role['name'])) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="<?= BASE_URL ?>admin/users" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">Guardar Cambios</button>
        </div>
    </form>
</div>