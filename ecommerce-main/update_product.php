<?php

// Include your database connection file
include_once "config/database.php";

// Include the Product class
include_once "objects/product.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
    // Get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Initialize the Product object
    $product = new Product($db);

    // Set product properties from the form
    $product->id = $_POST['productId'];
    $product->name = $_POST['productName'];
    $product->price = $_POST['productPrice'];
    if (isset($_FILES['productImage']) && is_uploaded_file($_FILES['productImage']['tmp_name'])) {
        $product->image = file_get_contents($_FILES['productImage']['tmp_name']);}

    $product->category = $_POST['productCategory'];

    // Update the product in the database
    if ($product->update()) {
        echo "Product updated successfully!";
        // Redirect to the products page after updating
        header("Location: adminPage.php");
    } else {
        echo "Unable to update product.";
    }
}
?>