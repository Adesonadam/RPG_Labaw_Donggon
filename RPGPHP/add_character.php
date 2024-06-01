<?php

@include 'config.php';

class ProductManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addProduct($product_name, $product_price, $product_image, $product_image_tmp_name, $product_image_folder) {
        if (empty($product_name) || empty($product_price) || empty($product_image)) {
            return 'Please fill out all fields';
        } else {
            $stmt = $this->conn->prepare("INSERT INTO products(name, price, image) VALUES(?, ?, ?)");
            $stmt->bind_param('sss', $product_name, $product_price, $product_image);
            $upload = $stmt->execute();

            if ($upload) {
                move_uploaded_file($product_image_tmp_name, $product_image_folder);
                return 'New product added successfully';
            } else {
                return 'Could not add the product';
            }
        }
    }

    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}

$productManager = new ProductManager($conn);

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;

    $message[] = $productManager->addProduct($product_name, $product_price, $product_image, $product_image_tmp_name, $product_image_folder);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $productManager->deleteProduct($id);
    header('location:add_character.php');
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="style.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

<header class="header">
        <a href="admin_page.php" class="logo">RPG 
            <span>DB</span></a>

            <i class='bx bx-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="admin_page.php" class="active">Home</a>
                <a href="add_character.php">Characters</a>
                <a href="dialog.php">Dialog</a>
                <a href="asset.php">Assets</a>
                
            </nav>
    </header>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>
   
  

   
<div class="container">

   <br><br><br><br><br><br><br>

   <div class="admin-product-form-container">

      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h1>add a new character</h1>
         <input type="text" placeholder="enter  name" name="product_name" class="box">
         <input type="text" placeholder="enter location" name="product_price" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="submit" class="btn" name="add_product" value="add product">
      </form>

   </div>

   <?php

   $select = mysqli_query($conn, "SELECT * FROM products");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Character Image</th>
            <th>Character Name</th>
            <th>Location</th>
            <th>action</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td>
               <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="add_character.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>

</div>





<script src="script.js"></script>

</body>
</html>