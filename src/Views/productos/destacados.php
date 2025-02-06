<?php
// how many records should be displayed on a page?
$records_per_page = 5;
// instantiate the pagination object
$pagination = new Zebra_Pagination();
// the number of total records is the number of records in the array
$pagination->records(count($products));
// records per page
$pagination->records_per_page($records_per_page);
// here's the magic: we need to display only the records for the current page
$products = array_slice(
    $products,
    (($pagination->get_page() - 1) * $records_per_page),
    $records_per_page
);

?>

<div id="products" class="products-container">
    <div class="product-card" v-for="product in products">

        <h2>{{ product.nombre }}</h2>
        <img src="{{ product.imagen }}">
        <p>{{ product.descripcion }}</p>
        <p class="stock">{{ product.stock }} en stock</p>
        <p class="price">{{ product.precio }}€</p>
        <div class="d-flex gap-2 actions"> 
            <form action="<?= BASE_URL ?>carrito/restar" method="post">

                <input type="hidden" name="id" id="id" v-model="product.id">
                <button class="btn btn-primary"><i class="mdi mdi-minus"></i></button>
            </form>

            <form action="<?= BASE_URL ?>carrito/sumar" method="post">
                <input type="hidden" name="id" id="id" v-model="product.id">
                <button class="btn btn-primary"><i class="mdi mdi-plus"></i></button>
            </form>
        </div>
    </div>
    
</div>
<?php
    $pagination->render();?>


<script>

  const { createApp } = Vue;

  createApp({
    data() {
      return {
        products:  <?php echo json_encode($products); ?>,
        sesion: <?php echo json_encode($_SESSION); ?>
      }
    }
  }).mount('#products')
</script>

<style>
  /* General Container */
.products-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px;
}

/* Product Card */
.product-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    flex: 1 1 calc(33.333% - 20px); /* 3 cards per row */
    max-width: calc(33.333% - 20px);
    text-align: center;
    padding: 15px;
}

/* Card Hover Effect */
.product-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

/* Product Image */
.product-card img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Product Details */
.product-card h2 {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #333;
}

.product-card p {
    margin: 5px 0;
    color: #666;
}

.product-card .price {
    font-size: 1.2em;
    color: #28a745;
    font-weight: bold;
}

/* Actions (Buttons and Quantity) */
.actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
}

.actions .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.actions .btn:hover {
    background-color: #0056b3;
}

.cart-quantity {
    font-size: 1.2em;   
    font-weight: bold;
}

/*Media queries for responsive design*/
@media (max-width: 768px) {
    .products-container {
        flex-direction: column;
        gap: 10px;
        padding: 10px;
        margin-top: 20px;
    }
    .product-card {
        flex: 1 1 calc(50% - 10px); /* 2 cards per row */
        max-width: calc(50% - 10px);
    }
} 

</style>