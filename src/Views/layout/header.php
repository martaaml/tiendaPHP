<html>
<head>
    <title>TIENDA</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
    <header class="container" style="background-color: #f2f2f2;">
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
    <style>
        .container {
            max-width: 960px;
            margin: 0 auto;
        }
        .container > header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container > header > h1 {
            font-size: 1.5rem;
            margin: 0;
        }
        .container > header > nav {
            display: flex;
            gap: 1rem;
        }
        .container > header > nav > a {
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid transparent;
            color: black;
        }
        .container > header > nav > a:hover {
            border-color: black;
        }
        .container > header > nav > a.active {
            border-color: black;
        }
        main {
            margin-top: 2rem;
        }
        a {
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
        }
        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
    <main>