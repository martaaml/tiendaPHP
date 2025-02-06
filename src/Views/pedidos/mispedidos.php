<section class="carrito">
    <?php if(isset($pedidos) && !empty($pedidos)) : ?>
        <?php foreach ($pedidos as $pedido) : ?>
            <form action="<?= BASE_URL ?>detalle_pedido" method="post">
                <article class="carrito__producto">
                    <p>Fecha pedido: <?= htmlspecialchars($pedido->getFecha()) ?></p>
                    <p>Precio Total: <?= htmlspecialchars($pedido->getCoste()) ?> €</p>
                    <div>
                        <p>Dirección: <?= htmlspecialchars($pedido->getDireccion()) ?></p>
                        <p>Provincia: <?= htmlspecialchars($pedido->getProvincia()) ?></p>
                    </div>
                    <p>Estado: <?= htmlspecialchars($pedido->getEstado()) ?></p>
                    <button type="submit" name="detalle" value="<?= htmlspecialchars($pedido->getId()) ?>">Ver Detalle</button>
                </article>
            </form>

            <!-- Mostrar detalles solo si se seleccionó el pedido -->
            <?php if(isset($detalles) && !empty($detalles) && $detalles[0]['pedido_id'] == $pedido->getId()) : ?>
                <article class="detalle__producto">
                    <div class="detalle__producto--cabecera">
                        <h2>Detalles de su pedido:</h2>
                        <a href="<?= BASE_URL ?>pedidos/mispedidos"><i class="ph-light ph-x"></i></a>
                    </div>
                    <div>
                        <?php foreach ($detalles as $detalle) : ?>
                            <div class="carrito__producto__info">
                                <div class="carrito__producto__content">
                                    <img src="<?= BASE_URL . "public/img/" . htmlspecialchars($detalle['imagen']) ?>" alt="Producto" class="carrito__producto__content__img">
                                </div>
                                <p><?= htmlspecialchars($detalle['nombre']) ?></p>
                                <p><?= htmlspecialchars($detalle['precio']) ?> €/unidad</p>
                                <p>Unidades: <?= htmlspecialchars($detalle['unidades']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No hay pedidos disponibles.</p>
    <?php endif; ?>
</section>
