<?php
session_start();
$rememberedUsername = isset($_SESSION['rememberedUsername']) ? $_SESSION['rememberedUsername'] : '';

  // get the product id
  $product_id = isset($_GET['id']) ? $_GET['id'] : "";

  // connect to database
  include 'config/database.php';

  // include object
  include_once "objects/cart_item.php";
  include_once "objects/user.php";

  // get database connection
  $database = new Database();
  $db = $database->getConnection();

  // initialize objects
  $cart_item = new CartItem($db);
  $userDetails = new User($db);
  $userId = $userDetails->findUserIdByUsername($rememberedUsername);

  // remove cart item from database
  $cart_item->user_id=$userId; // we default to '1' because we do not have logged in user
  $cart_item->product_id=$product_id;
  $cart_item->delete();

  // redirect to product list and tell the user it was added to cart
  header('Location: cart.php?action=removed&id=' . $id);
?>
