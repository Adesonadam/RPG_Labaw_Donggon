<?php

@include 'config.php';

class ProductUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateProduct($id, $product_name, $product_price, $product_image, $product_image_tmp_name, $product_image_folder) {
        if (empty($product_name) || empty($product_price) || empty($product_image)) {
            return '<h1>Please fill out all fields!</h1>';
        } else {
            $stmt = $this->conn->prepare("UPDATE products SET name=?, price=?, image=? WHERE id = ?");
            $stmt->bind_param('sssi', $product_name, $product_price, $product_image, $id);
            $upload = $stmt->execute();

            if ($upload) {
                move_uploaded_file($product_image_tmp_name, $product_image_folder);
                header('location:add_character.php');
                exit();
            } else {
                return '<h1>Error updating product!</h1>';
            }
        }
    }
}

$productUpdater = new ProductUpdater($conn);

$id = $_GET['edit'];

if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;

    $message[] = $productUpdater->updateProduct($id, $product_name, $product_price, $product_image, $product_image_tmp_name, $product_image_folder);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="style.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">


<div class="admin-product-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h1 class="title">update the character</h1>
      <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="enter character name">
      <input type="text" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="enter location">
      <input type="file" class="box" name="product_image"  accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="update product" name="update_product" class="btn">
      <a href="add_character.php" class="btn">go back!</a>
   </form>
   
   <?php }; ?>

   

</div>

</div>

<script src="script.js"></script>

</body>
</html>