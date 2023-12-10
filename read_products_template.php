

<?php 
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      extract($row);

      // creating box
      echo "<div class='col-md-4 m-b-20px'>";   

            // product id for javascript access
            echo "<div class='product-id display-none'>{$id}</div>";

            echo "<a href='product.php?id={$id}' class='product-link'>";
                // select and show first product image
           /*     $product_image->product_id=$id;
                $stmt_product_image=$product_image->readFirst();

                while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
                    echo "<div class='m-b-10px'>";
                        echo "<img src='uploads/images/{$row_product_image['name']}' class='w-100-pct' />";
                    echo "</div>";
                }*/
                echo "<div class='m-b-10px'>";
                $imageData = base64_encode($row['image']);

                echo '<img class="collections__items--img" src="data:image/png;base64,' . $imageData . '" />';
                echo "</div>";


                // product name
                echo "<div class='product-name m-b-10px'>name: {$name}</div>";
                
            echo "</a>";

            // product price and category name
            echo "<div class='m-b-10px'> price:";
                echo "&#36;" . number_format($price, 2, '.', ',');
            echo "</div>";
            echo "<div class='product-name m-b-10px'>category: {$category}</div>";

            // add to cart button
            echo "<div class='m-b-10px'>";
                // cart item settings
                $cart_item->user_id=$userId; // we default to a user with ID "1" for now
                //$cart_item->user_id=$userId
                $cart_item->product_id=$id;

                // if product was already added in the cart
                if($cart_item->exists()){
                    echo "<a href='cart.php' class='btn btn-success w-1-pct'>";
                        echo "Update Cart";
                    echo "</a>";
                }else{
                    echo "<a href='add_to_cart.php?id={$id}&page={$page}' class='btn btn-primary w-1-pct'>Add to Cart</a>";
                }


                /*
                echo "<a href='edit.php?id={$id}' class='btn btn-warning m-r-1em'>";
                echo "<i class='material-icons' style='font-size: 90%;'>edit</i>";
                echo "</a>";

                echo "<a href='#' onclick='deleteProduct({$id});' class='btn btn-danger'>";
                echo "<i class='material-icons' style='font-size: 90%;'>delete</i>";
                echo "</a>";*/
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

                
                <?php

            echo "</div>";



      echo "</div>";


    }

include_once "pagination.php";
?>
