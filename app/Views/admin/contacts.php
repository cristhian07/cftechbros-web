<?php
/**
 * Se utiliza \App\Core\Auth para verificar permisos directamente en la vista.
 * 
 * app/Views/admin/contacts.php
 * Vista para el panel de administración de mensajes de contacto.
 */
?>
<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-6 text-center">Mensajes de Contacto</h2>

    <?php if (empty($contacts)): ?>
        <p class="text-center text-gray-600 dark:text-gray-400">No hay mensajes de contacto registrados.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Correo Electrónico</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asunto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mensaje</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200"><?= htmlspecialchars($contact['name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200"><?= htmlspecialchars($contact['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200"><?= htmlspecialchars($contact['subject'] ?? 'N/A') ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200 max-w-xs overflow-hidden truncate"><?= htmlspecialchars($contact['message']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    <?= $contact['status'] === 'Pendiente' ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' : 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' ?>">
                                    <?= htmlspecialchars($contact['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($contact['created_at']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <?php if (\App\Core\Auth::can('update_contact_status')): ?>
                                    <form action="<?= BASE_URL ?>admin/contacts/update-status" method="POST" class="inline-block">
                                        <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                                        <input type="hidden" name="status" value="<?= $contact['status'] === 'Pendiente' ? 'Leído' : 'Pendiente' ?>">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">
                                            <?= $contact['status'] === 'Pendiente' ? 'Marcar como leído' : 'Marcar como pendiente' ?>
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <?php if (\App\Core\Auth::can('delete_contact')): ?>
                                    <form action="<?= BASE_URL ?>admin/contacts/delete" method="POST" class="inline-block ml-2">
                                        <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold" onclick="return confirm('¿Estás seguro de que quieres eliminar este mensaje?')">
                                            Eliminar
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <div class="mt-8 text-center">
        <a href="<?= BASE_URL ?>dashboard" class="text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300 font-semibold">Volver al Dashboard</a>
    </div>
</div>