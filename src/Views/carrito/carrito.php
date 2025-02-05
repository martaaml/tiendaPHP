<div id="carrito">
  <h2>Carrito</h2>
  <div v-for="product in carrito">
    <h3>{{ product.nombre }}</h3>
    <p>{{ product.precio }}</p>
    <button @click="removeProducto(product.id)">Eliminar</button>
  </div>
</div>