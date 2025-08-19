<?php
/**
 * app/Views/admin/users/manage_services.php
 * Vista para asignar o revocar servicios a un usuario.
 */
?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-2 text-center">Gestionar Servicios de Usuario</h2>
    <p class="text-center text-gray-600 mb-6">Asignando servicios para: <strong class="text-blue-800"><?= htmlspecialchars($user['username']) ?></strong></p>

    <form action="<?= BASE_URL ?>admin/users/update-services" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Servicios Disponibles</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($all_services as $service): ?>
                    <div class="flex items-center p-3 bg-gray-50 rounded-md">
                        <input type="checkbox" 
                               id="service_<?= $service['id'] ?>" 
                               name="services[]" 
                               value="<?= $service['id'] ?>"
                               class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                               <?= in_array($service['id'], $user_services_ids) ? 'checked' : '' ?>
                        >
                        <label for="service_<?= $service['id'] ?>" class="ml-3 block text-sm font-medium text-gray-700">
                            <?= htmlspecialchars($service['name']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="<?= BASE_URL ?>admin/users" class="text-blue-600 hover:underline font-semibold">Cancelar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105">Guardar Cambios</button>
        </div>
    </form>
</div>