<?php
/**
 * app/Views/auth/register.php
 * Vista del formulario de registro de usuario.
 * Incluye manejo de mensajes de error (validación) y protección CSRF.
 */
?>
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Registrarse</h2>

    <?php if (isset($errors) && !empty($errors)): // Muestra una lista de errores de validación si existen ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Error(es)!</strong>
            <ul class="mt-2 list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (isset($error) && !isset($errors)): // Muestra un error único si existe (ej. error CSRF) ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <!-- Formulario de registro -->
    <form action="<?= BASE_URL ?>register" method="POST" class="space-y-6">
        <!-- Campo oculto para el token CSRF -->
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <div>
            <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
        </div>
        <div>
            <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Correo Electrónico:</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div>
            <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Contraseña:</label>
            <div class="relative">
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10" required>
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <div>
            <label for="confirm_password" class="block text-gray-700 text-sm font-semibold mb-2">Confirmar Contraseña:</label>
            <div class="relative">
                <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10" required>
                <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
            Registrarse
        </button>
    </form>
    <p class="mt-6 text-center text-gray-600">
        ¿Ya tienes una cuenta? <a href="<?= BASE_URL ?>login" class="text-blue-600 hover:underline font-semibold">Inicia Sesión aquí</a>
    </p>
</div>

<script>
    function setupPasswordToggle(inputId, toggleButtonId) {
        const toggleButton = document.getElementById(toggleButtonId);
        const passwordInput = document.getElementById(inputId);

        if (!toggleButton || !passwordInput) return;

        toggleButton.addEventListener('click', function() {
            const icon = this.querySelector('i');
            // toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // toggle the icon
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    setupPasswordToggle('password', 'togglePassword');
    setupPasswordToggle('confirm_password', 'toggleConfirmPassword');
</script>
