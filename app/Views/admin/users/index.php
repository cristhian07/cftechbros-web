<?php
/**
 * app/Views/admin/users/index.php
 * Vista para listar y gestionar los usuarios del sistema.
 */
?>
<div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Gestión de Usuarios</h2>

    <?php if (!empty($success)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p class="font-bold">Éxito</p>
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <?php if (empty($users)): ?>
        <p class="text-center text-gray-600">No hay usuarios registrados en el sistema.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo Electrónico</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol Actual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $user['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 capitalize">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $user['role_name'] === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' ?>">
                                    <?= htmlspecialchars($user['role_name'] ?? 'Sin rol') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?= BASE_URL ?>admin/users/edit?id=<?= $user['id'] ?>" class="text-blue-600 hover:text-blue-900 font-semibold">Cambiar Rol</a>
                                <?php if (\App\Core\Auth::can('manage_user_services')): ?>
                                    <a href="<?= BASE_URL ?>admin/users/manage-services?id=<?= $user['id'] ?>" class="ml-4 text-green-600 hover:text-green-900 font-semibold">Gestionar Servicios</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>