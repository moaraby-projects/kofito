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
echo 'Login First!';
}else{
  $product_id = $_POST['product_id'];

  $verify_wishlist = $conn->prepare('select * from `wishlist` where user_id = ? and product_id = ?');
  $verify_wishlist->execute([$user_id,$product_id]);

  $verify_cart = $conn->prepare('select * from `cart` where user_id = ? and product_id = ?');
  $verify_cart->execute([$user_id,$product_id]);

  if($verify_wishlist->rowCount()> 0){
  echo 'product already exist in your wishlist';
  }else if($verify_cart->rowCount() > 0){
  echo 'product already exist in your cart';

  }else{
  $select_price = $conn->prepare('select * from `products` where id = ? limit 1');
  $select_price->execute([$product_id]);
  $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

  $insert_wishlist = $conn->prepare('insert into `wishlist`(user_id,product_id,price) values(?,?,?)');
  $insert_wishlist->execute([$user_id,$product_id,$fetch_price['price']]);

  echo 'product added to wishlist success ';
  }

}

  }

  // adding products in cart
  if(isset($_POST['add_to_cart'])){
  if ($user_id == ''){
  echo 'Login First!';
  }else{
    $product_id = $_POST['product_id'];
  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);

  $verify_cart = $conn->prepare('select * from `cart` where user_id = ? and product_id = ?');
  $verify_cart->execute([$user_id,$product_id]);

  $max_cart_items = $conn->prepare('select * from `cart` where user_id = ?');
  $max_cart_items->execute([$user_id]);

  if($verify_cart->rowCount()> 0){
  echo 'product already exist in your cart';

  }else if($max_cart_items->rowCount() > 20){
  echo 'cart is full';

  }else{
  $select_price = $conn->prepare('select * from `products` where id = ? limit 1');
  $select_price->execute([$product_id]);
  $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

  $insert_cart = $conn->prepare('insert into `cart`(user_id,product_id,price,qty) values(?,?,?,?)');
  $insert_cart->execute([$user_id,$product_id,$fetch_price['price'],$qty]);

  echo 'product added to cart success ';
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
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <title>Kofito - product details Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>product details</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a> <a href="view_products.php">/ shop </a> <span>/ product details</span>
        </div>
        <section class="view_page">
            <?php
                if(isset($_GET['pid'])){
                $pid = $_GET['pid'];
                $select_product = $conn-> prepare("select * from `products` where id= '$pid' ");
                $select_product->execute();

                    if($select_product->rowCount() >0){
                        while($fetch_product =$select_product->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" method="post">
                <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
                <div class="details">
                    <div class="price">price $<?php echo $fetch_product['price']; ?></div>
                    <div class="name"><?php echo $fetch_product['name']; ?></div>
                    <div class="product-details">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo odio porro modi cum
                            repudiandae. Hic rem obcaecati facere alias nostrum eum, vero nesciunt voluptatum non odio
                            eos, qui ex aliquam temporibus enim modi nisi illo reiciendis sequi assumenda voluptate!
                            Labore, aliquid excepturi dicta eaque, nemo illum, soluta temporibus totam ducimus atque
                            quaerat! Rem impedit quibusdam animi, odio nulla repellendus quae sint in, fugit deleniti id
                            unde odit, veniam corporis nemo reprehenderit quia expedita eius ex adipisci! Modi
                            veritatis.
                        </p>
                    </div>

                    <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
                    <div style="margin-top:1rem;" class="button">
                        <button type="submit" name="add_to_wishlist" class="btn">add to wishlist <i
                                class="bx bx-heart"></i></button>
                        <input type="hidden" name="qty" required min="0" value="1" class="quantity">
                        <button type="submit" name="add_to_cart" class="btn">add to cart <i
                                class="bx bx-cart"></i></button>
                    </div>
                </div>
            </form>
            <?php
                        }
                    }

                }

            ?>
        </section>

        <!-- footer -->
        <?php include 'components/footer.php'; ?>

    </div>
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
    <?php include 'js/main.js'; ?>
    </script>
    <?php include 'components/alert.php'; ?>
</body>

</html>