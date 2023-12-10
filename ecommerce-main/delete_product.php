<?php
// Include your database connection file
include_once "config/database.php";

// Include the Product class
include_once "objects/product.php";

// Check if the product ID is provided
if (isset($_POST['id'])) {
    $productId = $_POST['id'];
    echo $productId;
    // Get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Initialize the Product object
    $product = new Product($db);

    // Set the product ID property
    $product->id = $productId;

    // Delete the product
    if ($product->delete()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unable to delete product.']);
    }
} else {
    // Invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
