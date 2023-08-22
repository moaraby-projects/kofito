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

  // adding products in cart
  if(isset($_POST['add_to_cart'])){
  if ($user_id == ''){
  echo '<h1 class="alert-error">Login First!</h1>';
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

// delete item from cart
if(isset($_POST['delete_item'])){
 $cart_id = $_POST['cart_id'];
 $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
 $verify_delete_items = $conn->prepare('select * from `cart` where id =?');
 $verify_delete_items->execute([$cart_id]);

 if($verify_delete_items->rowCount() > 0){
 $delete_item = $conn->prepare("DELETE FROM `cart` WHERE `cart`.`id` = ?");
 $delete_item->execute([$cart_id]);
 echo '<h1 class="alert-success">done deleted</h1>';
 }else{
 echo '<h1 class="alert-error">cart items already deleted</h1>';
 }

}
// update item from cart
if(isset($_POST['update_cart'])){
  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);

 $cart_id = $_POST['cart_id'];
 $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
 $verify_update_items = $conn->prepare('select * from `cart` where id =?');
 $verify_update_items->execute([$cart_id]);

 if($verify_update_items->rowCount() > 0){
 $update_item = $conn->prepare("UPDATE `cart` SET `qty` = ? WHERE `cart`.`id` = ?");
 $update_item->execute([$qty,$cart_id]);
 echo '<h1 class="alert-success">done update</h1>';
    header("REFRESH:.5 , URL=cart.php");
 }else{
 echo '<h1 class="alert-error">cart items already update</h1>';
 }

}
// empty all items from cart
if(isset($_POST['empty_cart'])){
 $verify_empty_items = $conn->prepare('select * from `cart` where user_id =?');
 $verify_empty_items->execute([$user_id]);

 if($verify_empty_items->rowCount() > 0){
 $empty_item = $conn->prepare("DELETE from `cart` WHERE user_id = ?");
 $empty_item->execute([$user_id]);
 echo '<h1 class="alert-success">done empty cart</h1>';
    header("REFRESH:.5 , URL=cart.php");
 }else{
 echo '<h1 class="alert-error">cart items already empty</h1>';
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet"> -->
    <title>Kofito - cart Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>my cart</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a> <a href="view_products.php">/ products </a> <span>/ cart</span>
        </div>
        <section class="products">
            <h1 class="title">product added in cart</h1>
            <div class="box-container">
                <?php
                $grand_total =0;
                $select_cart = $conn->prepare('select * from `cart` where user_id = ?');
                $select_cart->execute([$user_id]);
                    if($select_cart->rowCount() > 0){
                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            $select_products = $conn->prepare('select * from `products` where id= ?');
                            $select_products->execute([$fetch_cart['product_id']]);

                            if($select_products->rowCount() > 0){
                            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                            ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                    <img src="img/<?php echo $fetch_products['image'];?>" alt="" class="img">
                    <h3><?php echo $fetch_products['name']; ?></h3>

                    <div class="flex">
                        <p class="price">price $<?php echo $fetch_products['price']; ?></p>
                        <input type="number" name="qty" required min="1" value="<?php echo $fetch_cart['qty'] ; ?>"
                            max="99" maxlength="2" class="qty">
                        <button type="submit" name="update_cart" id="edit-cart" class="bx bx-edit"></button>
                    </div>
                    <p class="sub-total">sub total :
                        <span>$<?php echo $sub_total = ($fetch_cart['qty'] * $fetch_cart['price']); ?></span>
                    </p>
                    <button id="remove-cart" type="submit" name="delete_item" class="btn"
                        onclick="return confirm('delete this item')"><i class="bx bx-x"></i></button>
                </form>

                <?php
                            $grand_total +=$sub_total;

                                        }else{
                                    echo '<p class="empty">product was not found!</p>';
                                    }
                                    }
                                }else{
                                    echo '<p class="empty">no products added yet!</p>';
                                    }

                ?>
            </div>

            <?php
            if ($grand_total !=0) {

            ?>
            <div class="cart-total">
                <p>total amount : <span>$<?php echo $grand_total;?></span></p>
                <div class="buttons">
                    <form action="" method="post">
                        <button type="submit" name="empty_cart" class="btn"
                            onclick="return confirm('are you sure to empty your cart?')">empty cart</button>
                        <a href="checkout.php" class="btn">checkout</a>
                    </form>
                </div>
            </div>
            <?php
            }
            ?>

        </section>

        <!-- footer -->
        <?php include 'components/footer.php'; ?>

    </div>
    <!-- scripts -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script> -->
    <script>
    <?php include 'js/main.js'; ?>
    </script>
    <?php include 'components/alert.php'; ?>
</body>

</html>