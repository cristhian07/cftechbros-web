<?php
/**
 * app/Views/admin/services/edit.php
 * Vista para editar los permisos que otorga un servicio específico.
 */
?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-2 text-center">Editar Permisos de Servicio</h2>
    <p class="text-center text-gray-600 mb-6">Asignando permisos para el servicio: <strong class="text-blue-800"><?= htmlspecialchars($service['name']) ?></strong></p>

    <form action="<?= BASE_URL ?>admin/services/update" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <input type="hidden" name="service_id" value="<?= $service['id'] ?>">

        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Permisos Disponibles</h4>
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
                                   class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   <?= in_array($permission['name'], $service_permissions) ? 'checked' : '' ?>
                            >
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
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Guardar Cambios</button>
        </div>
    </form>
</div>