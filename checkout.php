<?php
$rememberedUsername = isset($_SESSION['rememberedUsername']) ? $_SESSION['rememberedUsername'] : '';

  // connect to database
  include_once 'config/database.php';

  // include objects
  include_once "objects/product.php";
  include_once "objects/product_image.php";
  include_once "objects/cart_item.php";
  include_once "objects/user.php";


  // get database connection
  $database = new Database();
  $db = $database->getConnection();
function getOrderIdFromUser(){
    $database = new Database();
  $db = $database->getConnection();
    $userid = $_GET['userid'];
    $query = "SELECT id FROM orders WHERE user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $userid);
    $stmt->execute();
    $order_id = $stmt->fetch(PDO::FETCH_ASSOC);
    return $order_id;
}
function getProductFromCart(){
    $database = new Database();
  $db = $database->getConnection();
    $userid = $_GET['userid'];
    $query = "SELECT product_id, quantity FROM cart_items WHERE user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $userid);
    $stmt->execute();
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}
  // initialize objects
  $product = new Product($db);
  $product_image = new ProductImage($db);
  $cart_item = new CartItem($db);
  $userDetails = new User($db);
  $userId = $userDetails->findUserIdByUsername($rememberedUsername);
  // set page title
  $page_title="Checkout";

  // include page header html
  include 'layout_head.php';
  // $cart_count variable is initialized in navigation.php
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['proceed_checkout'])){
        $userid = $_GET['userid'];
        $total_price = $_GET['total'];
        $query = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $total_price);
        $stmt->execute();
        echo '<script>alert("order submitted successfully")</script>';
        
        $order_id = (int)getOrderIdFromUser();
        $test = getProductFromCart();

foreach ($test as $item) {
    $product_id = is_array($item['product_id']) ? $item['product_id'][0] : $item['product_id'];
    $quantity = is_array($item['quantity']) ? $item['quantity'][0] : $item['quantity'];

    $stmt2 = $db->prepare("INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt2->bindParam(1, $order_id);
    $stmt2->bindParam(2, $product_id);
    $stmt2->bindParam(3, $quantity);
    $stmt2->execute();
}

        


    }
  }
  if($cart_count>0){

      $cart_item->user_id=$userId;
      $stmt=$cart_item->read();

      $total=0;
      $item_count=0;

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);

          $sub_total=$price*$quantity;

          echo "<div class='cart-row'>";
              echo "<div class='col-md-8'>";

                  echo "<div class='product-name m-b-10px'><h4>{$name}</h4></div>";
                  echo $quantity>1 ? "<div>{$quantity} items</div>" : "<div>{$quantity} item</div>";

              echo "</div>";

              echo "<div class='col-md-4'>";
                  echo "<h4>&#36;" . number_format($price, 2, '.', ',') . "</h4>";
              echo "</div>";
          echo "</div>";

          $item_count += $quantity;
          $total+=$sub_total;
      }
      echo "<form action='' method='POST'>";
      echo "<div class='col-md-12 text-align-center'>";
          echo "<div class='cart-row'>";
              if($item_count>1){
                  echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
              }else{
                  echo "<h4 class='m-b-10px'>Total ({$item_count} item)</h4>";
              }
              echo "<h4>&#36;" . number_format($total, 2, '.', ',') . "</h4>";

              echo "<button type='submit' name='proceed_checkout' class='btn btn-lg btn-success m-b-10px'>";
                  echo "<span class='glyphicon glyphicon-shopping-cart'></span> Place Order";
              echo "</button>";
          echo "</div>";
      echo "</div>";
      echo "</form>";

  }else{
    echo "<div class='col-md-12'>";
        echo "<div class='alert alert-danger'>";
            echo "No products found in your cart!";
        echo "</div>";
    echo "</div>";
  }

include 'layout_foot.php';
?>
