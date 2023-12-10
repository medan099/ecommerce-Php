<?php
// Include your database connection file
include_once "config/database.php";

// Include the Product class
include_once "objects/product.php";
include_once "objects/cart_item.php";



      $database = new Database();
      $db = $database->getConnection();

      $page_title="Edit Product";

include 'layout_head_admin.php';

// Check if the product ID is provided in the URL
if(isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Initialize the Product object
    $product = new Product($db);

    // Set the product ID property of the Product class
    $product->id = $productId;

    // Fetch product details from the database
    $product->readOne();

    // Get the product details
    $productName = $product->name;
    $productPrice = $product->price;
    $productImage = $product->image;
    $productCategory = $product->category;
} else {
    // Redirect to products.php if the product ID is not provided
    header("Location: products.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="libs/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add additional styles if needed -->
    <!-- custom css for users -->
    <link href="libs/css/user.css" rel="stylesheet" media="screen">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
     
        <form method="post" action="update_product.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $productName; ?>" required>
            </div>
            <div class="form-group">
                <label for="productPrice">Product Price</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" value="<?php echo $productPrice; ?>" required>
            </div>
            <div class="form-group">
                <label for="productImage">Product Image</label>
                <input type="file" name="productImage" id="productImage" accept="image/*">
            </div>
            <div>
                    <label>
                        <input type="radio" name="productCategory" value="european"> european
                    </label>
                    <label>
                        <input type="radio" name="productCategory" value="asian"> asian
                        </label>
            </div>
            
            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
          </div>
      </div>

    </div>




    <!-- jQuery library -->
    <script src="libs/js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="libs/js/bootstrap.min.js"></script>
    <!-- ... (rest of your HTML code) ... -->
</body>
</html>


