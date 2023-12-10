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


      //read all products in the database
      $stmt = $product->read($from_record_num, $records_per_page);

      //count number of retrieved products
      $num = $stmt->rowCount();

      //if products retrieved are more than zeror
      if($num > 0){
        //used for pagination
        $page_url = "adminPage.php";
        $total_rows = $product->count();
        
        //show the products
        








      }else{
        echo "<div class='col-md-12'>";
          echo "<div class='alert alert-danger'>No products found.</div>";
        echo "</div>";
      }

      // layout footer code
      include 'layout_foot.php';
?>

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Orders Table</title>
</head>
<body>

<div class="container mt-4">
    <h2>Orders Table</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Date</th>
                <th>Total Price</th>
                <th>Send Email</th>
            </tr>
        </thead>
        <tbody>
            <form action="" method="POST">
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['date']; ?></td>
                    <td><?php echo 'DT' . number_format($order['total_price'], 2); ?></td>
                    <td><button type="submit" name="send_validation" value="Send Email Validation" class="btn btn-primary">Send Email Validation</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
            </form>
    </table>
    

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
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