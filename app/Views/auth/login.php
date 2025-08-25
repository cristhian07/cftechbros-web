<?php
/**
 * app/Views/auth/login.php
 * Vista del formulario de inicio de sesión.
 * Incluye manejo de mensajes de éxito/error y protección CSRF.
 */
?>
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-xl border border-gray-200">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Iniciar Sesión</h2>

    <?php if (isset($success)): // Muestra mensaje de éxito si existe ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): // Muestra mensaje de error si existe ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <!-- Formulario de inicio de sesión -->
    <form action="<?= BASE_URL ?>login" method="POST" class="space-y-6">
        <!-- Campo oculto para el token CSRF -->
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
        <div>
            <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
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
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
            Iniciar Sesión
        </button>
    </form>
    <p class="mt-6 text-center text-gray-600">
        ¿No tienes una cuenta? <a href="<?= BASE_URL ?>register" class="text-blue-600 hover:underline font-semibold">Regístrate aquí</a>
    </p>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const icon = this.querySelector('i');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>
