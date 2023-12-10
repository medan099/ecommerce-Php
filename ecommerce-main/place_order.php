<?php
$rememberedUsername = isset($_SESSION['rememberedUsername']) ? $_SESSION['rememberedUsername'] : '';

  // include classes
  include_once "config/database.php";
  include_once "objects/cart_item.php";
  include_once "objects/user.php";
  // get database connection
  $database = new Database();
  $db = $database->getConnection();

  // initialize objects
  $cart_item = new CartItem($db);
  /*$userDetails = new User($db);
  $userId = $userDetails->findUserIdByUsername($rememberedUsername);*/
  // remove all cart item by user, from database
  // we default to '1' because we do not have logged in user

 

  // set page title
  $page_title="Thank You!";

  // include page header HTML
  include_once 'layout_head.php';




  



  
  $cart_item->user_id=$userId;
  $cart_item->deleteByUser();

  echo "<div class='col-md-12'>";
      // tell the user order has been placed
      echo "<div class='alert alert-success'>";
          echo "<strong>Your order has been placed!</strong> Thank you very much!";
      echo "</div>";
  echo "</div>";

  // include page footer HTML
  include_once 'layout_foot.php';
?>
