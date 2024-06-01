<?php

@include 'config.php';

class DialogUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateDialog($id, $dialog_name, $dialog_price, $dialog_image, $dialog_image_tmp_name, $dialog_image_folder) {
        if (empty($dialog_name) || empty($dialog_price) || empty($dialog_image)) {
            return '<h1>Please fill out all fields!</h1>';
        } else {
            $stmt = $this->conn->prepare("UPDATE dialogs SET name=?, price=?, image=? WHERE id = ?");
            $stmt->bind_param('sssi', $dialog_name, $dialog_price, $dialog_image, $id);
            $upload = $stmt->execute();

            if ($upload) {
                move_uploaded_file($dialog_image_tmp_name, $dialog_image_folder);
                header('location:dialog.php');
                exit();
            } else {
                return '<h1>Error updating dialog!</h1>';
            }
        }
    }
}

$dialogUpdater = new DialogUpdater($conn);

$id = $_GET['edit'];

if (isset($_POST['update_dialog'])) {
    $dialog_name = $_POST['dialog_name'];
    $dialog_price = $_POST['dialog_price'];
    $dialog_image = $_FILES['dialog_image']['name'];
    $dialog_image_tmp_name = $_FILES['dialog_image']['tmp_name'];
    $dialog_image_folder = 'uploaded_img/' . $dialog_image;

    $message[] = $dialogUpdater->updateDialog($id, $dialog_name, $dialog_price, $dialog_image, $dialog_image_tmp_name, $dialog_image_folder);
}

?>


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
      
      $select = mysqli_query($conn, "SELECT * FROM dialogs WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h1 class="title">update the dialog</h1>
      <input type="text" class="box" name="dialog_name" value="<?php echo $row['name']; ?>" placeholder="enter name">
      <input type="text" min="0" class="box" name="dialog_price" value="<?php echo $row['price']; ?>" placeholder="enter dialog">
      <input type="file" class="box" name="dialog_image"  accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="update product" name="update_dialog" class="btn">
      <a href="dialog.php" class="btn">go back!</a>
   </form>
   
   <?php }; ?>

   

</div>

</div>

<script src="script.js"></script>

</body>
</html>