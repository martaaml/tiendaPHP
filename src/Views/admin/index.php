<div id="menu_admin">
    <div v-for="gestion in menu">
        <button @click="viewMenu(gestion.id)">{{ gestion.title }}</button>
    </div>
    <div v-if="verCat" class="d-flex gap-2">
        <div class="w-75">
            <h2>Gestion de categorias</h2>
            <table id="categorias" class="table table-striped table-hover">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Borrado</th>
                    <th>Acciones</th>
                </tr>
                <tr v-for="categoria in categorias">
                    <td>{{ categoria.id }}</td>
                    <td>{{ categoria.nombre }}</td>
                    <td>{{ categoria.borrado?'Si':'No' }}</td>
                    <td class="d-flex gap-2">
                        <button @click="editarCategoria(categoria)" class="btn btn-info"><i class="mdi mdi-pencil-outline"></i></button>
                        <form action="<?= BASE_URL ?>categorias/delete" method="post" v-if="categoria.borrado == false">
                            <input type="hidden" name="id" id="id" v-model="categoria.id">
                            <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete-outline"></i></button>
                        </form>
                        <form action="<?= BASE_URL ?>categorias/reactive" method="post" v-if="categoria.borrado == true">
                            <input type="hidden" name="id" id="id" v-model="categoria.id">
                            <button type="submit" class="btn btn-success"><i class="mdi mdi-reload"></i></button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        <form action="<?= BASE_URL ?>categorias" method="post">
            <h2>{{formularioCategoria.id ? 'Editar' : 'Crear nueva'}} categoria</h2>
            <input type="number" name="id" id="id" v-model="formularioCategoria.id" readonly hidden>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required v-model="formularioCategoria.nombre">
            <button type="submit">{{ formularioCategoria.id ? 'Editar' : 'Crear' }}</button>
            <button type="button" v-if="formularioCategoria.id" @click="formularioCategoria={}">Cancelar</button>

        </form>
    </div>

    
    <div v-if="verProd">
        <h2>Gestion de productos</h2>
        <table id="products" class="table table-striped table-hover">
            <tr>
                <th>Id</th>
                <th>Categoria_id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Oferta</th>
                <th>Fecha</th>
                <th>Imagen</th>
                <th>Borrado</th>
                <th>Acciones</th>
            </tr>
            <tr v-for="product in products">
                <td>{{ product.id }}</td>
                <td>{{ product.categoria_id }}</td>
                <td>{{ product.nombre }}</td>
                <td>{{ product.descripcion }}</td>
                <td>{{ product.precio }}</td>
                <td>{{ product.stock }}</td>
                <td>{{ product.oferta }}</td>
                <td>{{ product.fecha }}</td>
                <td>{{ product.imagen }}</td>
                <td>{{ product.borrado }}</td>
                <td class="d-flex gap-2">
                    <button @click="editarProducto(product)" class="btn btn-info"><i class="mdi mdi-pencil-outline"></i></button>
                    
                    <form action="<?= BASE_URL ?>productos/delete" method="POST" v-if="product.borrado == false">
                        <input type="hidden" name="id" id="id" v-model="product.id">
                        <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete-outline"></i></button>
                    </form>
                    <form action="<?= BASE_URL ?>productos/reactive" method="POST" v-if="product.borrado == true">
                        <input type="hidden" name="id" id="id" v-model="product.id">
                        <button type="submit" class="btn btn-success"><i class="mdi mdi-reload"></i></button>
                    </form>
                </td>

            </tr>
        </table>
        <form action="<?= BASE_URL ?>productos" method="post">
            <h2>{{formularioProducto.id ? 'Editar' : 'Crear nuevo'}} producto</h2>
            <input type="number" name="id" id="id" v-model="formularioProducto.id" readonly hidden>
            <input type="number" name="categoria_id" id="categoria_id" v-model="formularioProducto.categoria_id">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required v-model="formularioProducto.nombre">
            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" required v-model="formularioProducto.descripcion">
            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" required v-model="formularioProducto.precio">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" required v-model="formularioProducto.stock">
            <label for="oferta">Oferta</label>
            <input type="number" name="oferta" id="oferta" required v-model="formularioProducto.oferta">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" required v-model="formularioProducto.fecha">
            <label for="imagen">Imagen</label>
            <input type="text" name="imagen" id="imagen" required v-model="formularioProducto.imagen">
            <button type="submit">{{ formularioProducto.id ? 'Editar' : 'Crear' }}</button>
            <button type="button" v-if="formularioProducto.id" @click="formularioProducto={}">Cancelar</button>
        </form>
    </div>
    <div v-if="verPed">
        <h2>Gestion de pedidos</h2>
        <table id="pedidos" class="table table-striped table-hover">
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
            <tr v-for="pedido in pedidos">
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
                <button>Editar</button>
                <button>Eliminar</button>
                </td>
            </tr>
        </table>

        <from action="pedidos/editar" method="post" id="formularioPedido">
            <h2>{{formularioPedido.id ? 'Editar' : 'Crear nuevo'}} pedido</h2>
            <input type="text" name="estado" value="">
            <button>Guardar</button>
        </from>

    </div>

    <div v-if="regiUser">
        <table id="usuario" class="table table-striped table-hover">

            <h2>Usuario</h2>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Contraseña</th>
                <th>Rol</th>
            </tr>

            <tr v-for="regiUser in regiUsers">
                <p>Id: {{ regiUsers.id }}</p>
                <p>Nombre: {{ regiUsers.nombre }}</p>
                <p>Email: {{ regiUsers.email }}</p>
                <p>Contraseña: {{ regiUsers.password }}</p>
                <p>Rol: {{ regiUsers.rol }}</p>


        </table>


    </div>

    <script>
        const {
            createApp
        } = Vue

        createApp({
            data() {
                return {
                    menu: <?php echo json_encode($menu); ?>,
                    verCat: false,
                    verProd: false,
                    verPed: false,
                    categorias: <?php echo json_encode($categorias); ?>,
                    products: <?php echo json_encode($products); ?>,
                    pedidos: <?php echo json_encode($pedidos); ?>,
                    formularioCategoria: {
                        id: null,
                        nombre: ''
                    },
                    formularioProducto: {
                        id: null,
                        nombre: '',
                        descripcion: '',
                        precio: '',
                        stock: '',
                        oferta: '',
                        fecha: '',
                        imagen: '',
                    },
                    formularioPedido: {
                        estado: '',
                    }
                }
            },
            methods: {
                viewMenu(gestion) {
                    switch (gestion) {
                        case 0:
                            this.verCat = true;
                            this.verProd = false;
                            this.verPed = false;
                            this.verUsr = false;
                            break;
                        case 1:
                            this.verProd = true;
                            this.verPed = false;
                            this.verCat = false;
                            this.verUsr = false;
                            break;
                        case 2:
                            this.verPed = true;
                            this.verProd = false;
                            this.verCat = false;
                            break;
                    }
                },
                editarCategoria(cat) {
                    this.formularioCategoria = cat;
                },
                editarProducto(prod) {
                    this.formularioProducto = prod;
                },
                editarPedido(ped) {
                    this.formularioPedido = ped;
                },
            }
        }).mount('#menu_admin')
    </script>