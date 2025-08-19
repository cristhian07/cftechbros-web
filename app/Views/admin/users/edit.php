<?php
/**
 * app/Views/admin/users/edit.php
 * Vista para editar el rol de un usuario.
 */
?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-2 text-center">Asignar Rol a Usuario</h2>
    <p class="text-center text-gray-600 mb-6">Estás editando el rol para: <strong class="text-blue-800"><?= htmlspecialchars($user['username']) ?></strong></p>

    <form action="<?= BASE_URL ?>admin/users/update-role" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <div>
            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">Selecciona un nuevo rol:</label>
            <select id="role_id" name="role_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars(ucfirst($role['name'])) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="<?= BASE_URL ?>admin/users" class="text-blue-600 hover:underline font-semibold">Cancelar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Guardar Cambios</button>
        </div>
    </form>
</div>