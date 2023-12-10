<?php    
// Include your database connection file
    include_once "config/database.php";

    // Include the Product class
    include_once "objects/product.php";
    include_once "objects/cart_item.php";


        // Get database connection
        $database = new Database();
        $db = $database->getConnection();
        $page_title="Add Product";

// Check if the form is submitted
include 'layout_head_admin.php';



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

   

    // Initialize the Product object
    $product = new Product($db);


    // Set product properties from the form
    $product->name = $_POST['productName'];
    $product->price = $_POST['productPrice'];
    $product->image = file_get_contents($_FILES['productImage']['tmp_name']);
    $product->category = $_POST['productCategory'];

    // Add the product to the database
    if ($product->create()) {
        echo "Product added successfully!";
        header("Location: adminPage.php");
    } else {
        echo "Unable to add product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="libs/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add additional styles if needed -->
    <!-- custom css for users -->
    <link href="libs/css/user.css" rel="stylesheet" media="screen">
    <style>
  /* Style général du dropdown */
  .dropdown {
      position: relative;
      display: inline-block;
    }

    /* Style du bouton principal */
    .dropbtn {
      background-color: #3498db;
      color: white;
      padding: 10px;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    /* Style du contenu du dropdown */
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
      z-index: 1;
    }

    /* Style des liens dans le dropdown */
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    /* Changement de couleur au survol des liens */
    .dropdown-content a:hover {
      background-color: #ddd;
    }

    /* Affichage du dropdown au survol du bouton principal */
    .dropdown:hover .dropdown-content {
      display: block;
    }
  </style>

</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
               
                <!-- Your form for adding a product can go here -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add_product"> <!-- Added hidden field for action -->
                    <!-- Add your form fields here -->
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" name="productName" required>
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Product Price</label>
                        <input type="number" class="form-control" name="productPrice" required>
                    </div>
                    <div class="">
                    <label for="productImage">Product Image:</label>
                   <input type="file" name="productImage" id="productImage" accept="image/*"   >
                    </div>
                  <!--  <div class="form-group">
                        <label for="productCategory">Product Category</label>
                        <input type="text" class="form-control" name="productCategory" required>
                    </div>-->
                    <div>
                 
                    <label>Category:</label>
                    <br>
                    <label>
                        <input type="radio" name="productCategory" value="european"> european
                    </label>
                    <label>
                        <input type="radio" name="productCategory" value="asian"> asian
                        </label>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>

    <script src="libs/js/bootstrap.min.js"></script>
    <script>
    // JavaScript pour gérer la sélection d'options
    document.addEventListener('DOMContentLoaded', function() {
      var dropdown = document.querySelector('.dropdown');
      var options = document.querySelectorAll('.dropdown-content a');

      options.forEach(function(option) {
        option.addEventListener('click', function() {
          // Mettez en surbrillance l'option sélectionnée (ajoutez votre propre style ici)
          options.forEach(function(o) {
            o.classList.remove('selected');
          });
          option.classList.add('selected');

          // Changez le texte du bouton principal en fonction de l'option sélectionnée
          var selectedText = option.innerText;
          dropdown.querySelector('.dropbtn').innerText = selectedText;
        });
      });
    });
  </script>
    <!-- Add additional scripts if needed -->
</body>
</html>
