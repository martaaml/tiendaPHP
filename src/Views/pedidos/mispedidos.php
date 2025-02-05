<?php
use Services\pedidosService;
use Services\productsService;
use Services\categoryService;

$pedidosService = new pedidosService();
$productsService = new productsService();
$categoryService = new categoryService();

$pedidos = $pedidosService->findAll();
$pedidos = is_array($pedidos) ? array_map(fn($pedido) => (array) $pedido, $pedidos) : [];

$products = $productsService->findAll();
$products = array_map(fn($product) => $product->toArray(), $products);

$categories = $categoryService->findActive();
$categories = array_map(fn($category) => $category->toArray(), $categories);

// Paginación para productos
$records_per_page = 5;
$pagination = new Zebra_Pagination();
$pagination->records(count($products));
$pagination->records_per_page($records_per_page);
$products = array_slice($products, ($pagination->get_page() - 1) * $records_per_page, $records_per_page);
?>

<div id="pedidos">
    <h2>Mis pedidos</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Provincia</th>
                <th>Localidad</th>
                <th>Direccion</th>
                <th>Coste</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="pedido in pedidos" :key="pedido.id">
                <td>{{ pedido.id }}</td>
                <td>{{ pedido.nombre }}</td>
                <td>{{ pedido.email }}</td>
                <td>{{ pedido.telefono }}</td>
                <td>{{ pedido.provincia }}</td>
                <td>{{ pedido.localidad }}</td>
                <td>{{ pedido.direccion }}</td>
                <td>{{ pedido.coste }}</td>
                <td>{{ pedido.estado }}</td>
                <td>{{ pedido.fecha }}</td>
                <td>{{ pedido.hora }}</td>
                <td class="d-flex gap-2">
                    <button @click="editarPedido(pedido)" class="btn btn-info">
                        <i class="mdi mdi-pencil-outline"></i>
                    </button>
                    <form v-if="!pedido.borrado" method="post" action="<?= BASE_URL ?>pedidos/delete">
                        <input type="hidden" name="id" v-model="pedido.id">
                        <button type="submit" class="btn btn-danger">
                            <i class="mdi mdi-delete-outline"></i>
                        </button>
                    </form>
                    <form v-if="pedido.borrado" method="post" action="<?= BASE_URL ?>pedidos/reactive">
                        <input type="hidden" name="id" v-model="pedido.id">
                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-reload"></i>
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
    <?php $pagination->render(); ?>

    <form method="post" action="<?= BASE_URL ?>pedidos">
        <h2>{{ formularioPedido.id ? 'Editar' : 'Crear nuevo' }} pedido</h2>
        <input type="text" name="estado" v-model="formularioPedido.estado">
        <button type="submit">Guardar</button>
    </form>
</div>

<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            pedidos: <?php echo json_encode($pedidos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>,
            formularioPedido: {
                id: null,
                estado: ''
            }
        };
    },
    methods: {
        editarPedido(pedido) {
            this.formularioPedido = { ...pedido };
        }
    }
}).mount('#pedidos');
</script>
    