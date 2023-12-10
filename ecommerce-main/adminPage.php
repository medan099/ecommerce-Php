<?php
include 'config/database.php';
include_once "objects/product.php";
include_once "objects/product_image.php";
include_once "objects/cart_item.php";

// ...

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product_image = new ProductImage($db);
$cart_item = new CartItem($db);

// ...

$page_title = "Products";
include 'layout_head_admin.php';

// Output HTML header
echo '<div class="col-md-9">
    <div class="page-header">
        <h1 style="margin-bottom:70px">' . (isset($page_title) ? $page_title : "Processing") . '</h1>
    </div>
</div>';

// Output "Add Product" button and JavaScript function
echo '<button type="button" class="btn btn-primary" onclick="redirectToAddPage()" style="position: absolute;top: 110px;left: 20px;margin-top: 70px;margin-left: 100px;">';
echo '    Add Product';
echo '</button>';

// Output JavaScript function for redirection
echo '<script>
    function redirectToAddPage() {
        window.location.href = "add.php";
    }
</script>';

// ... (Other HTML content)

// Perform search and display results
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($searchQuery != '') {
    $searchResults = performSearch($db, $searchQuery);

    // Display search results
    if (!empty($searchResults)) {
        foreach ($searchResults as $row) {
            // Output search result HTML
            // ...
        }
    } else {
        // Handle no search results
    }
} else {
    // Display products if no search query
    // ...
}

// ... (Other HTML content)

include 'layout_foot.php';
include 'layout_foot.php'; // Note: duplicated inclusion

// ... (Other PHP code)

?>
