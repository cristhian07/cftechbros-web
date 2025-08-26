<?php
/**
 * app/Views/admin/services/create.php
 * Vista para el formulario de creación de un nuevo servicio.
 */
?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Crear Nuevo Servicio</h2>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Error(es)!</strong>
            <ul class="mt-2 list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>admin/services/store" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <div>
            <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Nombre del Servicio:</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <label for="description" class="block text-gray-700 text-sm font-semibold mb-2">Descripción:</label>
            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
        </div>
        <div>
            <label for="icon_class" class="block text-gray-700 text-sm font-semibold mb-2">Clase del Icono (Font Awesome):</label>
            <input type="text" id="icon_class" name="icon_class" placeholder="Ej: fas fa-chart-line" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <label for="image_url" class="block text-gray-700 text-sm font-semibold mb-2">URL de la Imagen (para la página principal):</label>
            <input type="text" id="image_url" name="image_url" placeholder="Ej: images/services/development.jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex items-center">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="is_featured" class="ml-3 block text-sm font-medium text-gray-700">Marcar como servicio destacado en la página principal</label>
        </div>

        <hr class="my-6 border-gray-300">

        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Permisos Adicionales que Otorga este Servicio</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php if (empty($all_permissions)): ?>
                    <p class="text-gray-500 col-span-2">No hay permisos definidos en el sistema.</p>
                <?php else: ?>
                    <?php foreach ($all_permissions as $permission): ?>
                        <div class="flex items-center p-3 bg-gray-50 rounded-md">
                            <input type="checkbox" 
                                   id="permission_<?= $permission['id'] ?>" 
                                   name="permissions[]" 
                                   value="<?= htmlspecialchars($permission['name']) ?>"
                                   class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="permission_<?= $permission['id'] ?>" class="ml-3 block text-sm font-medium text-gray-700">
                                <?= htmlspecialchars($permission['name']) ?>
                                <span class="text-xs text-gray-500 block"><?= htmlspecialchars($permission['description']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="<?= BASE_URL ?>admin/services" class="text-blue-600 hover:underline font-semibold">Cancelar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Guardar Servicio</button>
        </div>
    </form>
</div>