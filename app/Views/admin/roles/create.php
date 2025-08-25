<?php
/**
 * app/Views/admin/roles/create.php
 * Vista para crear un nuevo rol.
 */
?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Crear Nuevo Rol</h2>

    <?php if (\App\Core\Session::has('error_message')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= \App\Core\Session::get('error_message') ?></span>
            <?php \App\Core\Session::delete('error_message'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>admin/roles/store" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Rol</label>
            <input type="text" id="name" name="name" required
                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <p class="mt-2 text-xs text-gray-500">El nombre debe ser único y en minúsculas (ej: editor, supervisor).</p>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea id="description" name="description" rows="3" required
                      class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
            <p class="mt-2 text-xs text-gray-500">Una breve descripción de lo que este rol puede hacer.</p>
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="<?= BASE_URL ?>admin/roles" class="text-blue-600 hover:underline font-semibold">Cancelar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Crear Rol</button>
        </div>
    </form>
</div>