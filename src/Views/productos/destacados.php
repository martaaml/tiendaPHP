<div id="products">
    <div v-for="product in products">
        <h2>{{ product.nombre }}</h2>
        <img src="{{ product.imagen }}" alt="">
        <p>{{ product.descripcion }}</p>
        <p>{{ product.precio }}</p>
        <p>{{product.id}}</p>
        <div class="d-flex gap-2">
          <form action="<?= BASE_URL ?>carrito/restar" method="post">
            <input type ="hidden" name="id" id="id" v-model="product.id">
           <button class="btn btn-primary"><i class="mdi mdi-minus"></i></button>
          </form> 
          <p>{{sesion.carrito[product.id]??0}}</p>
          <form action="<?= BASE_URL ?>carrito/sumar" method="post">
            <input type ="hidden" name="id" id="id" v-model="product.id">
            <button class="btn btn-primary"><i class="mdi mdi-plus"></i></button>
          </form>
        </div>
    </div>

</div>

<script>

  const { createApp } = Vue

  createApp({
    data() {
      return {
        products:  <?php echo json_encode($products); ?>,
        sesion: <?php echo json_encode($_SESSION); ?>
      }
    }
  }).mount('#products')
</script>