<?php

require_once('navigation.php');

class ItemFactory
{

  public static function render_item($id, $thumbnail, $title, $price, $description, $type_of_sale): string
  {
    $button_name = $type_of_sale == 2 ? 'Add to cart' : 'Make an offer';
    $route = Navigation::product_page($id);
    return '
        <div class="card border-primary mb-3">
        <div class="bg-image hover-overlay">
          <img height=300px src="data:image;base64,' . base64_encode($thumbnail) . '"/>
          <a href="' . $route . '"">
          <div class="card-header mask overlay">
            <h4 class="title">' . $title . '</h4>
            <h4 class="price">' . $price . '$</h4>
          </div>
          </a>
        </div>
        <div class="card-body">
          <p>' . substr($description, 0, 30) . '...</p>
          <a href="' . $route . '" class="btn btn-outline-primary btn-rounded" data-mdb-ripple-color="dark">' . $button_name . '</a>
        </div>
      </div>
      ';
  }
}
