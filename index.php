<?php
require_once('controller/item_factory.php');
require_once('controller/navigation.php');
require_once('controller/database/product_controller.php');
Navigation::init_navigation(); /* Creation of root folder during runtime. */

$product_controller = new ProductController();
$products = $product_controller->get_last_produces(20);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Your market</title>
  <link rel="stylesheet" href="static/style/site.css" />

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />

<body>
  <!-- Barre de navigation -->
  <?php include "view/components/navbar.php" ?>
  <!-- Fin de la barre de navigation -->

  <!-- Header -->
  <header>
    <!-- Carousel wrapper -->
    <?php include "view/components/carousel.php" ?>
    <!-- Carousel wrapper -->
  </header>
  <!-- Fin du header -->

  <!-- Section principale -->
  <section class="main">
    <!-- Toutes les cartes -->
    <h1><em>Last Incoming</em></h1> <br>
    <div class="cards">
      <?php foreach ($products as $product)
        echo ItemFactory::render_item($product['id'], $product['thumbnail'], $product['name'], $product['price'], $product['description'], $product['type_of_sale']); ?>
      <!-- Fin de toutes les cartes -->
  </section>
  <!-- Fin de la section principale -->

  <!-- Footer -->
  <?php include "view/components/footer.php" ?>
  <!-- Footer -->

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>


</body>

</html>