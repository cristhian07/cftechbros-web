<?php
/**
 * app/Views/contact/form.php
 * Vista del formulario de contacto.
 */
?>
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Contáctanos</h2>
    <p class="text-center text-gray-600 mb-6">Envíanos tu consulta y te responderemos a la brevedad.</p>

    <?php if (isset($success)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
        </div>
    <?php endif; ?>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Error(es)!</strong>
            <ul class="mt-2 list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>contact" method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <div>
            <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Nombre Completo:</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $name_val ?? '' ?>" required>
        </div>
        <div>
            <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Correo Electrónico:</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $email_val ?? '' ?>" required>
        </div>
        <div>
            <label for="subject" class="block text-gray-700 text-sm font-semibold mb-2">Asunto:</label>
            <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $subject_val ?? '' ?>">
        </div>
        <div>
            <label for="message" class="block text-gray-700 text-sm font-semibold mb-2">Mensaje:</label>
            <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required><?= $message_val ?? '' ?></textarea>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
            Enviar Mensaje
        </button>
    </form>
    <p class="mt-6 text-center text-gray-600">
        <a href="<?= BASE_URL ?>" class="text-blue-600 hover:underline font-semibold">Volver a la página principal</a>
    </p>
</div>