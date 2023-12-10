<?php
session_start();
$_SESSION['cart']=isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$rememberedUsername = isset($_SESSION['rememberedUsername']) ? $_SESSION['rememberedUsername'] : '';


include_once "objects/user.php";
include_once "config/database.php";
include_once "objects/cart_item.php";
$database = new Database();           
$db = $database->getConnection();
$userDetails = new User($db);
$userId = $userDetails->findUserIdByUsername($rememberedUsername);


?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo isset($page_title) ? $page_title : "Processing"; ?></title>
   
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Bootstrap CSS -->
    <link href="libs/css/bootstrap.min.css" rel="stylesheet" media="screen">


    <!-- custom css for users -->
    <link href="libs/css/user.css" rel="stylesheet" media="screen">

  </head>
  <body>
  <div class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="products.php">Food Delivery</a>
                </div>

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        <!-- highlight if $page_title has 'Products' word. -->
                        <li <?php echo strpos($page_title, "Product")!==false ? "class='active'" : ""; ?>>
                        <?php
                        if($rememberedUsername == "med"){
                            echo '<a href="adminPage.php">Products</a>';

                        } else {
                           echo' <a href="products.php">Products</a>';
                        }
                            ?>
                        </li>

                        <li <?php echo $page_title=="Cart" ? "class='active'" : ""; ?> >
                            <a href="cart.php">
                              <?php
                                      //count the products in the Cart
                                      $cart_item = new CartItem($db);
                                      $cart_item->user_id=$userId; //default to user iwth ID "1" for now
                                      $cart_count = $cart_item->count();
                                  ?>
                                  Cart <span class="badge" id="comparison-count"><?php echo $cart_count ?></span>
                            </a>
                        </li>
                        <li><a href="#">Bienvenue, <?php echo $rememberedUsername; ?></a></li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>

                </div><!--/.nav-collapse -->

            </div>
            
        </div>
        
        
        <!-- /navbar -->

        <!-- container -->
        <div class="container">
            <div class="row"  >

                <div class="col-md-12"   >
                    <div class="page-header">
                        <h1 style="margin-bottom:70px"><?php echo isset($page_title) ? $page_title : "Processing"; ?></h1>
                    </div>
                </div>

