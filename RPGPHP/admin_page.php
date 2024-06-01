<?php

@include 'config.php';

if(isset($_POST['add_product'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'uploaded_img/'.$product_image;

   if(empty($product_name) || empty($product_price) || empty($product_image)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         $message[] = 'new product added successfully';
      }else{
         $message[] = 'could not add the product';
      }
   }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM products WHERE id = $id");
   header('location:admin_page.php');
};


if(isset($_POST['add_dialog'])){

   $dialog_name = $_POST['dialog_name'];
   $dialog_price = $_POST['dialog_price'];
   $dialog_image = $_FILES['dialog_image']['name'];
   $dialog_image_tmp_name = $_FILES['dialog_image']['tmp_name'];
   $dialog_image_folder = 'uploaded_img/'.$dialog_image;

   if(empty($dialog_name) || empty($dialog_price) || empty($dialog_image)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO dialogs(name, price, image) VALUES('$dialog_name', '$dialog_price', '$dialog_image')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($dialog_image_tmp_name, $dialog_image_folder);
         $message[] = 'new product added successfully';
      }else{
         $message[] = 'could not add the product';
      }
   }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM dialogs WHERE id = $id");
   header('location:dialog.php');
};

if(isset($_POST['add_asset'])){

   $asset_name = $_POST['asset_name'];
   $asset_image = $_FILES['asset_image']['name'];
   $asset_image_tmp_name = $_FILES['asset_image']['tmp_name'];
   $asset_image_folder = 'uploaded_img/'.$asset_image;

   if( empty($asset_image) ||empty($asset_name)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO assets(name, image) VALUES('$asset_name', '$asset_image')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($asset_image_tmp_name, $asset_image_folder);
         $message[] = 'new product added successfully';
      }else{
         $message[] = 'could not add the product';
      }
   }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM assets WHERE id = $id");
   header('location:asset.php');
};

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
        <a href="#home" class="logo">RPG 
            <span>DB</span></a>

            <i class='bx bx-menu' id="menu-icon"></i>

            <nav class="navbar">
                <a href="#home" class="active">Home</a>
                <a href="#about">Characters</a>
                <a href="#services">Dialogs</a>
                <a href="#language">Assets</a>
                <a href="#contact">Developers</a>

            </nav>
    </header>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>

  
   <section class="home" id="home">

<div class="home-img">
    <img src="Labaw.jpeg" alt="">
</div>

<div class="home-content">
    <h1>Labaw<span> Donggon </span></h1>
    <h3 class="text-animation">
        Epikong <span class=></span>
    </h3>

    <p>
    Labaw Donggon is about the amorous exploits of the son of a goddess Alunsina, by a mortal, Datu Paubari. Labaw falls in love with and marries three different women, fighting monsters and giants to win their hands. His sons later free him after he is imprisoned by a rival suitor for one of the wives.
    </p> <br><br>
    

</div>
</section>


<section class="about" id="about">
        <div class="about-content">
            <h2 class="heading">Labaw 
               <span>Character</span>
            </h2>
            
<div class="container">

<a href="add_character.php" class="btn">Add Character</a>

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
         
      </tr>
      </thead>
      <?php while($row = mysqli_fetch_assoc($select)){ ?>
      <tr>
         <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
         <td><?php echo $row['name']; ?></td>
         <td><?php echo $row['price']; ?></td>
         
      </tr>
   <?php } ?>
   </table>
</div>

</div>
        
    </section>






    <section class="services" id="services">
        <h2 class="heading">Labaw <span>Dialog</span></h2>

            
            <div class="container">

<a href="dialog.php" class="btn">Add Dialog</a>
<?php


$select = mysqli_query($conn, "SELECT * FROM dialogs");

?>
<div class="product-display">
   <table class="product-display-table">
      <thead>
      <tr>
         <th>Characters Image</th>
         <th>Characters Name</th>
         <th>Dialogs</th>
         
      </tr>
      </thead>
      <?php while($row = mysqli_fetch_assoc($select)){ ?>
      <tr>
         <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
         <td><?php echo $row['name']; ?></td>
         <td><?php echo $row['price']; ?></td>
         
      </tr>
   <?php } ?>
   </table>
         </div>         
      </div>
   </div>

    </section>



    <section class="language" id="language">

        <h2 class="heading">Labaw <span>
            Assets</span></h2>

        
            <?php

   $select = mysqli_query($conn, "SELECT * FROM assets");
   
   ?>

   <a href="asset.php" class="btn">Add Assets</a>

   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Assets</th>
            <th>Description</th>
            
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            
            
         </tr>
      <?php } ?>
      </table>
   </div>


    </section>


    <section class="contact" id="contact">

        <h2 class="heading">About <span>
            Developers</span></h2>

        <div class="service-container">
        
            <div class="service-box">
                <p>Macarubbo, Joshua V.</p>
                <div class="service-info">
                <a href="josh.php">
                        <img src="dev/jos.jpg" alt="jpg">
                    </a>
                </div>
            </div>
            
            <div class="service-box">
               <p>Lumba, Albert Red S.</p>
               <div class="service-info">
               <a href="red.php">
            <img src="dev/Reda.jpg" alt="jpg">
            </a>
               </div>
            </div>


            <div class="service-box">
                <p>Macaraig, Adeson M.</p>
                <div class="service-info">
                <a href="ade.php">
                        <img src="dev/ade.jpg" alt="jpg" >
                    </a>
                </div>
            </div>
            
        </div>


    </section>








<script src="script.js"></script>

</body>
</html>