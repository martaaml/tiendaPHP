<html>
<head>
    <title>TIENDA</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
</head>
    <header>
        <h1>TIENDA</h1>
        <nav>
            <?php if (isset($_SESSION['user'])) : ?>
                <li><a href="<?= BASE_URL ?>logout">Cerrar sesión</a></li>
            <?php else : ?>
                <li><a href="<?= BASE_URL ?>login">Iniciar sesión</a></li>
                <li><a href="<?= BASE_URL ?>register">Registrarse</a></li>
            <?php endif; ?>
            <a href="   <?= BASE_URL ?>categorias">Categorias</a>
            <a href="<?= BASE_URL ?>">Productos</a>
            <a href="">Carrito</a>
            <?php if (isset($_SESSION['admin'])) : ?>
                <a href="<?= BASE_URL ?>admin">Admin</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>