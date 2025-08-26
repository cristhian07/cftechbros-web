<?php
/**
 * app/Views/admin/services/index.php
 * Vista para listar los servicios y gestionar sus permisos asociados.
 */
?>
<div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Gestión de Permisos por Servicio</h2>

    <div class="mb-6 text-right">
        <a href="<?= BASE_URL ?>admin/services/create" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
            <i class="fas fa-plus mr-2"></i>Crear Nuevo Servicio
        </a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p class="font-bold">Éxito</p>
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Error</p>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <?php if (empty($services)): ?>
        <p class="text-center text-gray-600">No hay servicios definidos en el sistema.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $service['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 flex items-center">
                                <i class="<?= htmlspecialchars($service['icon_class'] ?? 'fas fa-question-circle') ?> text-blue-600 mr-3 w-5 text-center"></i>
                                <span><?= htmlspecialchars($service['name']) ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?= BASE_URL ?>admin/services/edit?id=<?= $service['id'] ?>" class="text-blue-600 hover:text-blue-900 font-semibold mr-4">Editar</a>
                                <form action="<?= BASE_URL ?>admin/services/delete" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este servicio? Esta acción no se puede deshacer y eliminará todos los datos asociados.');">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                                    <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <div class="mt-8 text-center">
        <a href="<?= BASE_URL ?>dashboard" class="text-blue-600 hover:underline font-semibold">Volver al Dashboard</a>
    </div>
</div>