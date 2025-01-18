<div id="categorias">
<h2>Categorias</h2>
    <div v-for="categoria in categorias">
        <h3>{{ categoria.nombre }}</h3> 
    </div>

</div>

<script>
  const { createApp } = Vue

  createApp({
    data() {
      return {
        categorias:  <?php echo json_encode($categorias); ?>
      }
    }
  }).mount('#categorias')
</script>

