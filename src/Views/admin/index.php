<div id="menu_admin">
    <div v-for="gestion in menu">
        <button @click="viewMenu(gestion.id)">{{ gestion.title }}</button>
    </div>
    <div v-if="verCat">
        <h2>Gestion de categorias</h2>
        <table id="categorias">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Borrado</th>
                <th>Acciones</th>
            </tr>
            <tr v-for="categoria in categorias">
                <td>{{ categoria.id }}</td>
                <td>{{ categoria.nombre }}</td>
                <td>{{ categoria.borrado }}</td>
                <td>
                    <button>Editar</button>
                    <button>Eliminar</button>
                </td>
            </tr>
        </table>
    </div>
    <div v-if="verProd">
        <h2>Gestion de productos</h2>
        <table id="products">
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
                <td>{{ products.id }}</td>
                <td>{{ products.categoria_id }}</td>
                <td>{{ products.nombre }}</td>
                <td>{{ products.descripcion }}</td>
                <td>{{ products.precio }}</td>
                <td>{{ products.stock }}</td>
                <td>{{ products.oferta }}</td>
                <td>{{ products.fecha }}</td>
                <td>{{ products.imagen }}</td>
                <td>{{ products.borrado }}</td>
                <td>
                    <button>Editar</button>
                    <button>Eliminar</button>
                </td>

            </tr>
        </table>
    </div>
</div>

<script>
  
  const { createApp } = Vue

  createApp({
    data() {
      return {
        menu:  <?php echo json_encode($menu); ?>,
        verCat:false,
        verProd:false,
        verPed:false,
        categorias: <?php echo json_encode($categorias); ?>,
        products: <?php echo json_encode($products); ?>
      }
    },
    methods: {
      viewMenu(gestion){
        switch(gestion){
          case 0:
            this.verCat=true;
            this.verProd=false;
            this.verPed=false;
            break;
          case 1:
            this.verProd=true;
            this.verPed=false;
            this.verCat=false;
            break;
          case 2:
            this.verPed=true;
            this.verProd=false;
            this.verCat=false;
            break;
        }
      }
      }
  }).mount('#menu_admin')

</script>
