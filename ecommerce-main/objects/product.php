<?php
// The Product objects
class Product{

      //database connection
      private $conn;
      private $table_name="products";

      //object properties
      public $id;
      public $name;
      public $price;
      public $description;
      public $category_id;
      public $category_name;
      public $timestamp;
      public $image;
      public $category;

      //constructor
      public function __construct($db){
        $this->conn = $db;
      }

      

      //read all the products from the db
      function read($from_record_num, $records_per_page){

        // select all products query
        $query = "SELECT
                    id, name, description, price, image, category
                FROM
                    " . $this->table_name . "
                ORDER BY
                    created ASC
                LIMIT
                    ?, ?";

          //prepare query statement
          $stmt = $this->conn->prepare($query);

          // bind limit clause variables
          $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
          $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

          // execute query
          $stmt->execute();

          // return values
          return $stmt;
      }

      //used for pagination
      public function count(){
        // query to count all product records
        $query = "SELECT count(*) FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // get row value return array index is column 
        $rows = $stmt->fetch(PDO::FETCH_NUM);

        // return count  /total rows
        return $rows[0];
      }

      // read all product based on product ids included in the $ids variable
      public function readByIds($ids){

          $ids_arr = str_repeat('?,', count($ids) - 1) . '?';

          // query to select products
          $query = "SELECT id, name, price, image FROM " . $this->table_name . " WHERE id IN ({$ids_arr}) ORDER BY name";

          // prepare query statement
          $stmt = $this->conn->prepare($query);

          // execute query
          $stmt->execute($ids);

          // return values from database
          return $stmt;
      }

      public function create() {
        // Query to insert a new product into the database
        $query = "INSERT INTO products (name, price, image, category) VALUES (:name, :price, :image, :category)";

        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":category", $this->category);
        // Execute the query
        if ($stmt->execute()) {
            return true; // Product added successfully
        } else {
            // Print error details if needed
            // print_r($stmt->errorInfo());
            return false; // Unable to add product
        }
    }


    // Add the readOne function in your Product class
      public function readOne(){
        // query to select single product
        $query = "SELECT id, name, price, image FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind product id variable
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->image = $row['image'];
      }



      public function update(){
        // update query
        $query = "UPDATE " . $this->table_name . "
                SET name = :name, price = :price, category = :category";
    
        // conditionally include image update
        if(isset($this->image)){
            $query .= ", image = :image";
        }
    
        $query .= " WHERE id = :id";
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
    
        // conditionally bind image value
        if(isset($this->image)){
            $stmt->bindParam(':image', $this->image);
        }
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    

    public function delete() {
      // Query to delete the product
      $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
  
      // Prepare the query
      $stmt = $this->conn->prepare($query);
  
      // Bind parameters
      $stmt->bindParam(':id', $this->id);
  
      // Execute the query
      if ($stmt->execute()) {
          return true; // Deletion successful
      } else {
          return false; // Error in deletion
      }
  }

  // In your Product class (objects/product.php)
public function search($keyword, $start, $limit){
  $query = "SELECT * FROM " . $this->table_name . " WHERE name LIKE ? LIMIT {$start}, {$limit}";

  $stmt = $this->conn->prepare($query);

  $keyword = "%{$keyword}%";
  $stmt->bindParam(1, $keyword);

  $stmt->execute();

  return $stmt;
}


  




}
?>
