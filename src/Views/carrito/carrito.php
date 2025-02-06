<section class="carrito">
    <?php if (!empty($productosCarrito)): ?>
        <?php foreach ($productosCarrito as $key => $productoCarrito): ?>
            <?php if ($productoCarrito['productos'][0]->getBorrado() == 0): ?>
                <article class="carrito__producto">
                    <div class="carrito__producto__info">
                        <div class="carrito__producto__content">
                            <img src="<?= BASE_URL . "/subidas/" . $productoCarrito['productos'][0]->getImagen() ?>" 
                                 alt="Producto" class="carrito__producto__content__img">
                        </div>
                        <p><b>Nombre:</b> <?= $productoCarrito['productos'][0]->getNombre() ?></p>
                        <p><b>Precio:</b> <?= $productoCarrito['productos'][0]->getPrecio() ?>€</p>
                    </div>
                    <div class="carrito__producto__cantidad">
                        <form action="<?= BASE_URL ?>carrito/restar" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $productoCarrito['id'] ?>">
                            <button type="submit">-</button>
                        </form>
                        <p><?= $productoCarrito["unidades"] ?></p>
                        <form action="<?= BASE_URL ?>carrito/sumar" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $productoCarrito['id'] ?>">
                            <button type="submit">+</button>
                        </form>
                    </div>
                    <div class="carrito__producto__delete">
                        <form action="<?= BASE_URL ?>carrito/borrar" method="POST">
                            <input type="hidden" name="id" value="<?= $productoCarrito['id'] ?>">
                            <button type="submit">Borrar</button>
                        </form>
                    </div>
                </article>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>
</section>

<?php if (count($_SESSION["carrito"]) > 0 && isset($_SESSION['identity'])): ?>
    <section>
        <form action="<?= BASE_URL ?>pedido" method="POST">
            <button type="submit">Realizar pedido</button>
        </form>
    </section>
<?php elseif (!isset($_SESSION['identity'])): ?>

  <?php if (!isset($_SESSION['user'])): ?>
    <section>
        <h2>Inicia sesión antes de realizar el pedido:</h2>
        <form action="<?= BASE_URL ?>login" method="post">
            <button name="login" value="true">Inicia sesión</button>
        </form>
    </section>
    <?php endif; ?> 
<?php else: ?>
    <section>
        <h2>Aún no hay nada añadido:</h2>
        <a href="<?= BASE_URL ?>">Volver al inicio</a>
    </section>
<?php endif; ?>
