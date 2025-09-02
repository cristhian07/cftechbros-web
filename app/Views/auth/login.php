<?php
/**
 * app/Views/auth/login.php
 * Vista del formulario de inicio de sesión.
 * Incluye manejo de mensajes de éxito/error y protección CSRF.
 */
?>
<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 animate-fade-in-up">
    <div class="w-full max-w-5xl bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
        
        <!-- Columna Izquierda: Imagen y Branding (visible en pantallas medianas y grandes) -->
        <div class="w-full md:w-1/2 hidden md:block relative">
            <!-- Se recomienda usar una imagen local, por ejemplo: <?= BASE_URL ?>images/login-bg.jpg -->
            <img class="absolute h-full w-full object-cover" src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=700&q=80" alt="Equipo trabajando en tecnología">
            <div class="absolute inset-0 bg-blue-800 bg-opacity-75 flex flex-col justify-center p-12 text-white">
                <h2 class="text-4xl font-bold leading-tight">Bienvenido de Nuevo a CFTechBros</h2>
                <p class="mt-4 text-lg text-blue-100">Tu socio en soluciones tecnológicas. Accede a tu panel para gestionar tus servicios.</p>
            </div>
        </div>

        <!-- Columna Derecha: Formulario -->
        <div class="w-full md:w-1/2 p-8 sm:p-12">
            <h2 class="text-3xl font-bold text-center text-blue-700 dark:text-blue-400 mb-6">Iniciar Sesión</h2>

            <?php if (isset($success)): // Muestra mensaje de éxito si existe ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/50 dark:text-green-300 dark:border-green-600 p-4 rounded-r-lg mb-4" role="alert">
                    <p class="font-bold">¡Éxito!</p>
                    <p><?= htmlspecialchars($success) ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): // Muestra mensaje de error si existe ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900/50 dark:text-red-300 dark:border-red-600 p-4 rounded-r-lg mb-4" role="alert">
                    <p class="font-bold">¡Error!</p>
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>

            <!-- Formulario de inicio de sesión -->
            <form action="<?= BASE_URL ?>login" method="POST" class="space-y-6">
                <!-- Campo oculto para el token CSRF -->
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                <div>
                    <label for="username" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Nombre de Usuario:</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-user text-gray-400"></i>
                        </span>
                        <input type="text" id="username" name="username" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required placeholder="tu_usuario">
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Contraseña:</label>
                    <div class="relative">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input type="password" id="password" name="password" class="w-full pl-10 pr-10 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required placeholder="••••••••">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Iniciar Sesión
                </button>
            </form>
        </div>
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
