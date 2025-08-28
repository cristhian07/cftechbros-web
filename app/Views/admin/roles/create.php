<?php
/**
 * app/Views/admin/roles/create.php
 * Vista para crear un nuevo rol.
 */
?>
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-6 text-center">Crear Nuevo Rol</h2>

    <?php if (\App\Core\Session::has('error_message')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= \App\Core\Session::get('error_message') ?></span>
            <?php \App\Core\Session::delete('error_message'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>admin/roles/store" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Rol</label>
            <input type="text" id="name" name="name" required
                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">El nombre debe ser único y en minúsculas (ej: editor, supervisor).</p>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
            <textarea id="description" name="description" rows="3" required
                      class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Una breve descripción de lo que este rol puede hacer.</p>
        </div>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="<?= BASE_URL ?>admin/roles" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">Crear Rol</button>
        </div>
    </form>
</div>