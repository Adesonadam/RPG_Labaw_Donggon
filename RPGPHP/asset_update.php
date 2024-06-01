<?php

@include 'config.php';

class AssetUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateAsset($id, $asset_name, $asset_image, $asset_image_tmp_name, $asset_image_folder) {
        if (empty($asset_name) || empty($asset_image)) {
            return '<h1>Please fill out all fields!</h1>';
        } else {
            $stmt = $this->conn->prepare("UPDATE assets SET name=?, image=? WHERE id = ?");
            $stmt->bind_param('ssi', $asset_name, $asset_image, $id);
            $upload = $stmt->execute();

            if ($upload) {
                move_uploaded_file($asset_image_tmp_name, $asset_image_folder);
                header('location:asset.php');
                exit();
            } else {
                return '<h1>Error updating asset!</h1>';
            }
        }
    }
}

$assetUpdater = new AssetUpdater($conn);

$id = $_GET['edit'];

if (isset($_POST['update_asset'])) {
    $asset_name = $_POST['asset_name'];
    $asset_image = $_FILES['asset_image']['name'];
    $asset_image_tmp_name = $_FILES['asset_image']['tmp_name'];
    $asset_image_folder = 'uploaded_img/' . $asset_image;

    $message[] = $assetUpdater->updateAsset($id, $asset_name, $asset_image, $asset_image_tmp_name, $asset_image_folder);
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
      
      $select = mysqli_query($conn, "SELECT * FROM assets WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h1 class="title">update the asset</h1>
      <input type="text" class="box" name="asset_name" value="<?php echo $row['name']; ?>" placeholder="enter the asset name">
      <input type="file" class="box" name="asset_image"  accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="update product" name="update_asset" class="btn">
      <a href="asset.php" class="btn">go back!</a>
   </form>
   
   <?php }; ?>

   

</div>

</div>

<script src="script.js"></script>

</body>
</html>