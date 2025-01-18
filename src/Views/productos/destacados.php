<div id="productos">
    <div v-for="product in products">
        <h2>{{ products.nombre }}</h2>
        <p>{{ products.descripcion }}</p>
        <p>{{ products.precio }}</p>
    </div>

</div>

<script>
  const { createApp } = Vue

  createApp({
    data() {
      return {
        products:  <?php echo json_encode($products); ?>
      }
    }
  }).mount('#products')
</script>
