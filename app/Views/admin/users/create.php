<?php
/**
 * app/Views/admin/users/create.php
 * Vista para el formulario de creación de nuevos usuarios.
 */
use App\Core\Session;

$errorMessage = Session::get('error_message');
Session::delete('error_message');
?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-6">Crear Nuevo Usuario</h2>

    <?php if ($errorMessage): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($errorMessage) ?></span>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>admin/users/store" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de Usuario</label>
            <input type="text" id="username" name="username" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
            <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
            <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Mínimo 6 caracteres.</p>
        </div>

        <div>
            <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
            <select id="role_id" name="role_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="" disabled selected>Selecciona un rol</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>">
                        <?= htmlspecialchars(ucfirst($role['name'])) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="<?= BASE_URL ?>admin/users" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                Crear Usuario
            </button>
        </div>
    </form>
</div>