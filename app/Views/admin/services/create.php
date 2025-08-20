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

        <div class="flex justify-between items-center mt-8">
            <a href="<?= BASE_URL ?>admin/services" class="text-blue-600 hover:underline font-semibold">Cancelar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Guardar Servicio</button>
        </div>
    </form>
</div>