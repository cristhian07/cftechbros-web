<?php
/**
 * app/Views/services/index.php
 * Vista que lista los servicios contratados por el usuario.
 */
?>
<div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">Mis Servicios Contratados</h2>

    <?php if (empty($services)): ?>
        <div class="text-center py-10">
            <p class="text-gray-600 text-lg">Actualmente no tienes ningún servicio contratado.</p>
            <p class="text-gray-500 mt-2">Explora nuestros servicios y descubre cómo podemos ayudarte.</p>
            <a href="<?= BASE_URL ?>#services" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">Ver Catálogo de Servicios</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($services as $service): ?>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 flex flex-col shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex-grow">
                        <div class="flex items-center mb-4">
                            <i class="<?= htmlspecialchars($service['icon_class'] ?? 'fas fa-cogs') ?> text-3xl text-blue-600 mr-4"></i>
                            <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($service['name']) ?></h3>
                        </div>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($service['description']) ?></p>
                    </div>
                    <div class="mt-auto">
                        <p class="text-sm text-gray-500 mb-4">Contratado el: <?= date('d/m/Y', strtotime($service['contract_date'])) ?></p>
                        <a href="<?= BASE_URL ?><?= htmlspecialchars($service['route']) ?>?id=<?= $service['id'] ?>" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 block">Acceder al Servicio</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mt-10 text-center">
        <a href="<?= BASE_URL ?>dashboard" class="text-blue-600 hover:underline font-semibold">Volver al Dashboard</a>
    </div>
</div>