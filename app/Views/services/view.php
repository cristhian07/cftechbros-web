<?php
/**
 * app/Views/services/view.php
 * Vista para mostrar el detalle de un servicio contratado.
 */
?>
<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <div class="flex items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-6">
        <i class="<?= htmlspecialchars($service['icon_class']) ?> text-5xl text-blue-700 dark:text-blue-400 mr-6"></i>
        <div>
            <h2 class="text-4xl font-bold text-blue-700 dark:text-blue-400"><?= htmlspecialchars($service['name']) ?></h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">Panel de control del servicio</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Columna de Información -->
        <div class="md:col-span-2">
            <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Descripción del Servicio</h3>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                <?= htmlspecialchars($service['description']) ?>
            </p>
            
            <div class="mt-8">
                <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">Funcionalidades Clave</h4>
                <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                    <li>Acceso a reportes de rendimiento.</li>
                    <li>Gestión de configuraciones avanzadas.</li>
                    <li>Soporte técnico prioritario.</li>
                    <li>Historial de actividad.</li>
                </ul>
            </div>
        </div>

        <!-- Columna de Detalles -->
        <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
            <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Detalles de tu Contrato</h4>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Estado:</span>
                    <span class="font-bold text-green-600 dark:text-green-400 capitalize"><?= htmlspecialchars($service['status']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600 dark:text-gray-400">Fecha de Contratación:</span>
                    <span class="text-gray-800 dark:text-gray-200"><?= date('d/m/Y', strtotime($service['contract_date'])) ?></span>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                 <a href="#" class="w-full text-center block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Contactar a Soporte</a>
            </div>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
        <a href="<?= BASE_URL ?>services" class="text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300 font-semibold"><i class="fas fa-arrow-left mr-2"></i> Volver a Mis Servicios</a>
    </div>
</div>