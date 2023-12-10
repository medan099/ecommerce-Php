<?php
      // connect to database
      include 'config/database.php';

      // include objects
      include_once "objects/product.php";
      include_once "objects/product_image.php";
      include_once "objects/cart_item.php";


      // get database connection
      $database = new Database();
      $db = $database->getConnection();

      // set page title
      $page_title="Products";


      
      // page header html
      include 'layout_head_admin.php';
      echo '<div class="col-md-9">
          <div class="page-header">
              <h1 style="margin-bottom:70px">' . (isset($page_title) ? $page_title : "Processing") . '</h1>
          </div>
      </div>';

      
      echo '<button type="button" class="btn btn-primary" onclick="redirectToAddPage()" style="position: absolute;top: 110px;left: 20px;margin-top: 70px;margin-left: 100px;">';
      echo '    Add Product';
      echo '</button>';

      echo '<script>';
      echo '    function redirectToAddPage() {';
      echo '        window.location.href = "add.php";';
      echo '    }';
      echo '</script>';


      // initialize objects
      $product = new Product($db);
      $product_image = new ProductImage($db);
      $cart_item = new CartItem($db);


      // to prevent undefined index notice
      $action = isset($_GET['action']) ? $_GET['action'] : "";

      // for pagination purposes
      // page is the current page, if there's nothing set, default is page 1
      $page = isset($_GET['page']) ? $_GET['page'] : 1;
      // set records or rows of data per page
      $records_per_page = 6;
      // calculate for the query LIMIT clause
      $from_record_num = ($records_per_page * $page) - $records_per_page;





echo '      <form class="d-flex" role="search" action="" method="get" id="searchForm">
      <i class="fa-solid fa-magnifying-glass" style="color:#343a40;position: absolute;top:34px;left:1058px;"></i>
    <input class="form-control me-2" type="search" name="q" placeholder="Search" aria-label="Search" style="border-radius:25px;width:280px;text-indent: 20px;box-shadow:none; outline:none; border-color: transparent;" autocomplete="off">
</form>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $("input[name=\'q\']").on(\'input\', function() {
            clearTimeout($(this).data(\'timer\'));
            $(this).data(\'timer\', setTimeout(function(){
                $("#searchForm").submit();
            }, 1000));
        });
    });

</script>';
        
    
      //read all products in the database

        function performSearch($connection, $searchQuery) {
            $query = "SELECT * FROM products WHERE name LIKE :searchQuery OR category LIKE :searchQuery";

            $statement = $connection->prepare($query);
            $searchParam = "%{$searchQuery}%";
            $statement->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
          }
          $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
          if($searchQuery == ''){
            $searchResults = '';
        
          }else{
            $searchResults = performSearch($db,$searchQuery);
          }
        
        
        // Check if search results are available
        if (isset($searchResults) && !empty($searchResults)) {
            
            foreach ($searchResults as $row):
                echo "<div class='col-md-4 m-b-20px'>";   
        
                // product id for javascript access
                echo "<div class='product-id display-none'>" . $row['id'] . "</div>";
        
                echo "<a href='product.php?id=".$row['id']."' class='product-link'>";
                    echo "<div class='m-b-10px'>";
                    $imageData = base64_encode($row['image']);

                    echo '<img class="collections__items--img" src="data:image/png;base64,' . $imageData . '" style="width: 100px;" />';
                    echo "</div>";
        
                    // product name
                    echo "<div class='product-name m-b-10px'>name: ".$row['name']."</div>";
                echo "</a>";
        
                // product price and category name
                echo "<div class='m-b-10px'>price: ";
                    echo "&#36;" . number_format($row['price'], 2, '.', ',');
                echo "</div>";
                echo "<div class='product-name m-b-10px'>category: ".$row['category']."</div>";
                echo "<a href='edit.php?id= ". $row['id']."' class='btn btn-warning m-r-1em'>";
                echo "<i class='material-icons' style='font-size: 90%;'>edit</i>";
                echo "</a>";

                echo "<a href='#' onclick='deleteProduct(". $row['id'].");' class='btn btn-danger'>";
                echo "<i class='material-icons' style='font-size: 90%;'>delete</i>";
                echo "</a>";
        
                // add to cart button
                // Add your button code here
        
                echo "</div>";
            endforeach;
        } else {
            // Display products if search results are not available
        
            $stmt = $product->read($from_record_num, $records_per_page);
            $num = $stmt->rowCount();
        
            if ($num > 0) {
                $page_url = "adminPage.php";
                $total_rows = $product->count();
                
        
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
        
                    echo "<div class='col-md-4 m-b-20px'>";
                    echo "<div class='product-id display-none'>{$id}</div>";
                    echo "<a href='product.php?id={$id}' class='product-link'>";
                    echo "<div class='m-b-10px'>";
                    $imageData = base64_encode($row['image']);

                    echo '<img class="collections__items--img" src="data:image/jpg;base64,' . $imageData . '"/>';
                    echo "</div>";
        
                    // product name
                    echo "<div class='product-name m-b-10px'>name: {$name}</div>";
                    echo "</a>";
        
                    // product price and category name
                    echo "<div class='m-b-10px'>price: ";
                    echo "&#36;" . number_format($price, 2, '.', ',');
                    echo "</div>";
                    echo "<div class='product-name m-b-10px'>category: {$category}</div>";
        
                    echo "<a href='edit.php?id= ". $row['id']."' class='btn btn-warning m-r-1em'>";
                echo "<i class='material-icons' style='font-size: 90%;'>edit</i>";
                echo "</a>";

                echo "<a href='#' onclick='deleteProduct(". $row['id'].");' class='btn btn-danger'>";
                echo "<i class='material-icons' style='font-size: 90%;'>delete</i>";
                echo "</a>";
        
                    echo "</div>";
                }
                echo "</div>"; // Close the row div
        
                include_once "pagination.php";
            }
        }
        ?>
        
    





      


                <?php
                 include 'layout_foot.php';  ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP-PROJECT/PHPMailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function getOrders(){
    $database = new Database();
    $db = $database->getConnection();
    $query = "SELECT * FROM orders";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}
function getUserEmail(){
    $database = new Database();
    $db = $database->getConnection();
    $orders = getOrders();


    $userEmails = [];

    foreach ($orders as $order) {
        $query = "SELECT Email FROM users WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $order['user_id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $userEmails[] = $result['Email'];
        } 
    }

    return $userEmails;
}


$orders = getOrders();
?>

<?php
$userEmail = getUserEmail();

$mail = new PHPMailer(true);
$SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['send_validation'])){
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.office365.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mohamed-project@outlook.fr';
            $mail->Password   = 'ahmedmohamed123!';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $userEmail = getUserEmail();
            $mail->setFrom($mail->Username);
            $mail->addAddress($userEmail[0]);

            $mail->isHTML(true);
            $mail->Subject = 'shipment';
            $mail->Body    = 'Your order well received and we"ll contact you asap.';

            $mail->send();
            echo '<script>alert("Email sent successfully.")</script>';
        } catch (Exception $e) {
            echo 'Error sending email: ', $mail->ErrorInfo;
        }
    }
}

?>
<script>
                // Add this script to your HTML or include it in a separate JS file

                    function deleteProduct(productId) {
                        if (confirm('Are you sure you want to delete this product?')) {
                            // Send an AJAX request to delete_product.php
                            $.ajax({
                                type: 'POST', // You can use GET if you prefer
                                url: 'delete_product.php', // Update with your actual file name
                                data: { id: productId },
                                success: function(response) {
                                    // Handle the response, e.g., refresh the page or show a message
                                   
                                    location.reload(); // Reload the page after deletion
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error deleting product:', error);
                                }
                            });
                        }
                    }

                </script>

<?php include 'layout_foot.php';  ?>