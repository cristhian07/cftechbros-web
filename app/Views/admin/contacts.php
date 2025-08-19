<?php
/**
 * app/Views/admin/contacts.php
 * Vista para el panel de administración de mensajes de contacto.
 */
?>
<div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Mensajes de Contacto</h2>

    <?php if (empty($contacts)): ?>
        <p class="text-center text-gray-600">No hay mensajes de contacto registrados.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo Electrónico</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mensaje</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($contact['name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($contact['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($contact['subject'] ?? 'N/A') ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs overflow-hidden truncate"><?= htmlspecialchars($contact['message']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    <?= $contact['status'] === 'Pendiente' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= htmlspecialchars($contact['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($contact['created_at']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="<?= BASE_URL ?>admin/contacts/update-status" method="POST">
                                    <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $contact['status'] === 'Pendiente' ? 'Leído' : 'Pendiente' ?>">
                                    
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                                    <button type="submit" class="text-blue-600 hover:text-blue-900 font-semibold">
                                        <?= $contact['status'] === 'Pendiente' ? 'Marcar como leído' : 'Marcar como pendiente' ?>
                                    </button>
                                </form>
                                <form action="<?= BASE_URL ?>admin/contacts/delete" method="POST">
                                    <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold" onclick="return confirm('¿Estás seguro de que quieres eliminar este mensaje?')">
                                        Eliminar
                                    </button>
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