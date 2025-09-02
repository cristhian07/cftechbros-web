<?php
use App\Core\Session;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CFTechBros' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/custom.css">
</head>
<body class="bg-gray-100 font-sans">

<header class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
        <a href="<?= BASE_URL ?>" class="text-xl font-bold text-blue-600">CFTechBros</a>

        <!-- Menú para Escritorio (md y superior) -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="<?= BASE_URL ?>#services" class="nav-link">Servicios</a>
            <a href="<?= BASE_URL ?>contact" class="nav-link">Contacto</a>
            <?php if (Session::has('user_id')): ?>
                <a href="<?= BASE_URL ?>dashboard" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Dashboard</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>login" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Iniciar Sesión</a>
            <?php endif; ?>
        </div>

        <!-- Botón Hamburguesa para Móvil (visible solo en pantallas pequeñas) -->
        <div class="md:hidden">
            <button id="mobile-menu-button" class="text-gray-800 focus:outline-none">
                <i class="fas fa-bars fa-lg"></i>
            </button>
        </div>
    </nav>

    <!-- Menú Desplegable para Móvil -->
    <div id="mobile-menu" class="hidden md:hidden px-6 pt-2 pb-4 space-y-2 bg-white border-t">
        <a href="<?= BASE_URL ?>#services" class="block nav-link">Servicios</a>
        <a href="<?= BASE_URL ?>contact" class="block nav-link">Contacto</a>
        <?php if (Session::has('user_id')): ?>
            <a href="<?= BASE_URL ?>dashboard" class="block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-center">Dashboard</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>login" class="block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-center">Iniciar Sesión</a>
        <?php endif; ?>
    </div>
</header>

<main>
