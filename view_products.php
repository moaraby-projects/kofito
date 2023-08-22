<?php
include 'components/connection.php';
session_start();

 if(isset($_SESSION['user_id'])){
 $user_id = $_SESSION['user_id'];

    $user = $conn->prepare('select * from `users` where id = ? limit 1');
    $user->execute([$user_id]);
    $result = $user->fetch(PDO::FETCH_ASSOC);

    if ($result['user_status'] == "block") {
          session_destroy();
        header('location:login.php');
    }
 }else{
 $user_id = '';
 }

  if(isset($_POST['logout'])){
  session_destroy();
  header('location:home.php');
  }

  // adding products in wishlist
  if(isset($_POST['add_to_wishlist'])){
if ($user_id == ''){
 header('location:login.php');
}else{
  $product_id = $_POST['product_id'];

  $verify_wishlist = $conn->prepare('select * from `wishlist` where user_id = ? and product_id = ?');
  $verify_wishlist->execute([$user_id,$product_id]);

  $verify_cart = $conn->prepare('select * from `cart` where user_id = ? and product_id = ?');
  $verify_cart->execute([$user_id,$product_id]);

  if($verify_wishlist->rowCount()> 0){
  echo '<h1 class="alert-error">product already exist in your wishlist</h1>';
  }else if($verify_cart->rowCount() > 0){
  echo '<h1 class="alert-error">product already exist in your cart</h1>';

  }else{
  $select_price = $conn->prepare('select * from `products` where id = ? limit 1');
  $select_price->execute([$product_id]);
  $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

  $insert_wishlist = $conn->prepare('insert into `wishlist`(user_id,product_id,price) values(?,?,?)');
  $insert_wishlist->execute([$user_id,$product_id,$fetch_price['price']]);

  echo '<h1 class="alert-success">product added to wishlist success</h1>';
  }

}
  }

  // adding products in cart
  if(isset($_POST['add_to_cart'])){
  if ($user_id == ''){
  header('location:login.php');
  }else{
    $product_id = $_POST['product_id'];
  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);

  $verify_cart = $conn->prepare('select * from `cart` where user_id = ? and product_id = ?');
  $verify_cart->execute([$user_id,$product_id]);

  $max_cart_items = $conn->prepare('select * from `cart` where user_id = ?');
  $max_cart_items->execute([$user_id]);

  if($verify_cart->rowCount()> 0){
 echo '<h1 class="alert-error">product already exist in your cart</h1>';

  }else if($max_cart_items->rowCount() > 20){
  echo '<h1 class="alert-error">cart is full</h1>';

  }else{
  $select_price = $conn->prepare('select * from `products` where id = ? limit 1');
  $select_price->execute([$product_id]);
  $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

  $insert_cart = $conn->prepare('insert into `cart`(user_id,product_id,price,qty) values(?,?,?,?)');
  $insert_cart->execute([$user_id,$product_id,$fetch_price['price'],$qty]);

  echo '<h1 class="alert-success">product added to cart success</h1>';
  }

  }

}

?>
<style>
<?php include 'css/style.css';
?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/boxicons.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css"> -->
    <title>Kofito - shop Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>our shop</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>/ shop</span>
        </div>
        <section class="products">
            <div class="box-container">
                <?php

                $limit_loading = 12;
                if (isset($_GET['inc'])) {
                  $limit_loading += $_GET['inc'];
                }

                $select_user = $conn->prepare("select * from `products` limit $limit_loading ");
                $select_user->execute();
                if($select_user->rowCount() > 0){
                  while($fetch_products = $select_user->fetch(PDO::FETCH_ASSOC)){

                ?>
                <form method="post" class="box">
                    <img src='img/<?php echo $fetch_products['image']; ?>' alt="">
                    <div class="button">
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                        <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bx bxs-show"></a>
                    </div>
                    <h3 class="name"><?php echo $fetch_products['name']; ?></h3>
                    <input type="hidden" name="product_id" value='<?php echo $fetch_products['id']; ?>'>
                    <div class="flex">
                        <p class="price">price $<?php echo $fetch_products['price'] ; ?></p>
                        <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                    </div>
                    <a href="checkout.php?get_id=<?php echo $fetch_products['id']; ?>" class="btn">buy now</a>
                </form>
                <?php
                  }
                }else{
                  echo '<p class="empty">no products added yet!</p>';
                  }
                ?>
            </div>
            <a style="
                display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
            " type="submit" href="view_products.php?inc=<?php echo $limit_loading; ?>" class="btn">More..</a>
        </section>

        <!-- footer -->
        <?php include 'components/footer.php'; ?>

    </div>
    <!-- scripts -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.js"></script> -->
    <script>
    <?php include 'js/main.js'; ?>
    </script>
    <?php include 'components/alert.php'; ?>
</body>

</html>