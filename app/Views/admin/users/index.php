<?php
/**
 * app/Views/admin/users/index.php
 * Vista para la gestión de usuarios.
 */
use App\Core\Session;
use App\Core\Auth;
?>

<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Gestionar Usuarios</h2>
        <a href="<?= BASE_URL ?>admin/users/create" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 flex items-center">
            <i class="fas fa-plus mr-2"></i>Añadir Usuario
        </a>
    </div>

    <?php if (isset($success) && $success): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>
    <?php if (isset($error) && $error): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Registrado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200"><?= $user['id'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200"><?= htmlspecialchars($user['username']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                <?= htmlspecialchars(ucfirst($user['role_name'])) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?= BASE_URL ?>admin/users/edit?id=<?= $user['id'] ?>" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Editar Rol</a>
                            <?php if (Auth::can('manage_user_services')): ?>
                                <a href="<?= BASE_URL ?>admin/users/manage-services?id=<?= $user['id'] ?>" class="ml-4 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">Servicios</a>
                            <?php endif; ?>
                            <?php if ($user['id'] != 1 && $user['id'] != Session::get('user_id')): ?>
                                <form action="<?= BASE_URL ?>admin/users/delete" method="POST" class="inline-block ml-4" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario? Esta acción no se puede deshacer.');">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">Eliminar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>