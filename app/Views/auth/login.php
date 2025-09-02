<?php
/**
 * app/Views/auth/login.php
 * Vista del formulario de inicio de sesión.
 * Incluye manejo de mensajes de éxito/error y protección CSRF.
 */
?>
<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 animate-fade-in-up">    
    <!-- Tarjeta de login con efecto "glassmorphism" -->
    <div class="w-full max-w-md space-y-8 p-10 bg-white/10 dark:bg-black/20 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20">
        <div>
            <h2 class="mt-6 text-center text-4xl font-extrabold text-white tracking-tight">
                Iniciar Sesión
            </h2>
            <p class="mt-2 text-center text-sm text-gray-200 dark:text-gray-300">
                Accede a tu panel de CFTechBros
            </p>
        </div>

        <?php if (isset($success)): // Muestra mensaje de éxito si existe ?>
            <div class="bg-green-500/50 border border-green-400 text-white px-4 py-3 rounded-md relative" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): // Muestra mensaje de error si existe ?>
            <div class="bg-red-500/50 border border-red-400 text-white px-4 py-3 rounded-md relative" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
        <form action="<?= BASE_URL ?>login" method="POST" class="space-y-6">
            <!-- Campo oculto para el token CSRF -->
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
            <div>
                <label for="username" class="sr-only">Nombre de Usuario</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fas fa-user text-gray-400"></i></span>
                    <input type="text" id="username" name="username" class="w-full pl-10 px-4 py-3 bg-gray-900/50 border border-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" required placeholder="Nombre de Usuario">
                </div>
            </div>
            <div>
                <label for="password" class="sr-only">Contraseña</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fas fa-lock text-gray-400"></i></span>
                    <input type="password" id="password" name="password" class="w-full pl-10 pr-10 px-4 py-3 bg-gray-900/50 border border-gray-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" required placeholder="Contraseña">
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-gray-900">
                Entrar
            </button>
        </form>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const icon = this.querySelector('i');
            // toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // toggle the icon
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
</script>
