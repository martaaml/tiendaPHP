<div id="productos">
    <div v-for="product in products">
        <h2>{{ product.nombre }}</h2>
        <p>{{ product.descripcion }}</p>
        <p>{{ product.precio }}</p>
    </div>

</div>

<script>
  const { createApp } = Vue

  createApp({
    data() {
      return {
        product:  <?php echo json_encode($products); ?>
      }
    }
  }).mount('#product')
</script>