<?php
/**
 * app/Views/services/index.php
 * Vista para mostrar los servicios contratados por el usuario.
 */
?>
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-6">Mis Servicios Contratados</h2>

    <?php if (empty($services)): ?>
        <div class="text-center py-12">
            <i class="fas fa-folder-open text-5xl text-gray-400 dark:text-gray-500 mb-4"></i>
            <p class="text-lg text-gray-600 dark:text-gray-400">Aún no tienes servicios contratados.</p>
            <p class="text-gray-500 dark:text-gray-500 mt-2">Explora nuestros servicios y encuentra el que mejor se adapte a tus necesidades.</p>
            <a href="<?= BASE_URL ?>#services" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Ver Servicios Disponibles
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $service): ?>
                <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 flex flex-col justify-between transition transform hover:-translate-y-1">
                    <div>
                        <div class="flex items-center mb-4">
                            <i class="<?= htmlspecialchars($service['icon_class']) ?> text-3xl text-blue-600 dark:text-blue-400 mr-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200"><?= htmlspecialchars($service['name']) ?></h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4"><?= htmlspecialchars($service['description']) ?></p>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="<?= BASE_URL . htmlspecialchars($service['route']) ?>?id=<?= $service['id'] ?>" class="font-semibold text-blue-600 dark:text-blue-400 hover:underline">Acceder al Servicio <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>