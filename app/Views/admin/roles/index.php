<?php
/**
 * app/Views/admin/roles/index.php
 * Vista para listar y gestionar los roles del sistema.
 */
?>
<div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Gestión de Roles</h2>
        <a href="<?= BASE_URL ?>admin/roles/create" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
            Crear Nuevo Rol
        </a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/50 dark:text-green-200 p-4 mb-4" role="alert">
            <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900/50 dark:text-red-200 p-4 mb-4" role="alert">
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                <?php if (empty($roles)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay roles definidos.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($roles as $role): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?= $role['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100"><?= htmlspecialchars($role['name']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"><?= htmlspecialchars($role['description']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="<?= BASE_URL ?>admin/roles/edit?id=<?= $role['id'] ?>" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4">Editar Permisos</a>
                                <?php if ($role['name'] !== 'admin' && $role['name'] !== 'user'): ?>
                                    <form action="<?= BASE_URL ?>admin/roles/delete" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este rol? Esta acción no se puede deshacer.');">
                                        <input type="hidden" name="role_id" value="<?= $role['id'] ?>">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-400 cursor-not-allowed" title="Rol protegido">Eliminar</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>