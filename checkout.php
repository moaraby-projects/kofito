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

  if (isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $name = filter_var($name , FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number , FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email , FILTER_SANITIZE_STRING);
    $address = $_POST['flat']. ',' .$_POST['street']. ',' .$_POST['city']. ',' .$_POST['country']. ',' .$_POST['zipcode'];
    $address = filter_var($address , FILTER_SANITIZE_STRING);
    $address_type = $_POST['address_type'];
    $address_type = filter_var($address_type , FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method , FILTER_SANITIZE_STRING);

    $verify_cart = $conn->prepare('select * from `cart` where user_id =?');
    $verify_cart->execute([$user_id]);

    if (isset($_GET['get_id'])) {
        $get_product = $conn->prepare('select * from `products` where id =? limit 1');
        $get_product->execute([$_GET['get_id']]);

        if ($get_product->rowCount() > 0) {
            while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                $insert_order = $conn->prepare("INSERT INTO `orders`(user_id,name,number,email,address,address_type,method,product_id,price,qty,status) values(?,?,?,?,?,?,?,?,?,?,?) ");
                $insert_order->execute([$user_id,$name,$number,$email,$address,$address_type,$method,$fetch_p['id'] ,$fetch_p['price'] , 1, 'in progress']);
                header('location: orders.php');

            }
        }else {
        echo 'something went wrong';
        }
        }elseif ($verify_cart->rowCount() > 0){
            while ($fetch_c = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
                    $insert_order = $conn->prepare("INSERT INTO `orders`(user_id,name,number,email,address,address_type,method,product_id,price,qty,status) values(?,?,?,?,?,?,?,?,?,?,?) ");
                    $insert_order->execute([$user_id,$name,$number,$email,$address,$address_type,$method,$fetch_c['product_id'] ,$fetch_c['price'] , $fetch_c['qty'], 'in progress']);
                    header('location: orders.php');
        }

            if ($insert_order) {
                $delete_cart_id = $conn->prepare('DELETE FROM `cart` WHERE user_id = ?');
                $delete_cart_id->execute([$user_id]);
                        header('location: orders.php');
            }
        }else {
        echo 'something went wrong';
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
    <title>Kofito - checkout Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>checkout summary</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a> <a href="view_products.php">/ products </a> <span>/ checkout</span>
        </div>
        <section class="checkout">
            <div class="title">
                <img src="imgs/logo.png" alt="" class="logo-coffee">
                <h1>checkout summary</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi asperiores repudiandae, unde error
                    fugit est.</p>
            </div>
            <div class="row">
                <form action="" method="post">
                    <h3>billing details</h3>
                    <div class="flex">
                        <div class="box">
                            <div class="input-field">
                                <p>your name <span>*</span></p>
                                <input type="text" name="name" required maxlength="50" placeholder="Enter Your Name"
                                    class="input">
                            </div>
                            <div class="input-field">
                                <p>your number <span>*</span> </p>
                                <input type="number" name="number" required maxlength="11"
                                    placeholder="Enter Your number" class="input">
                            </div>
                            <div class="input-field">
                                <p>your email <span>*</span></p>
                                <input type="email" name="email" required maxlength="50" placeholder="Enter Your email"
                                    class="input">
                            </div>
                            <div class="input-field">
                                <p>payment method <span>*</span></p>
                                <select name="method" class="input">
                                    <option value="cash on delivery">cash on delivery</option>
                                    <option value="credit or debit card">credit or debit card</option>
                                    <option value="paypal">paypal</option>
                                    <option value="banking">banking</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <p>address type <span>*</span></p>
                                <select name="address_type" class="input">
                                    <option value="home">home</option>
                                    <option value="office">office</option>
                                </select>
                            </div>
                        </div>
                        <div class="box">
                            <div class="input-field">
                                <p>address line 01 <span>*</span></p>
                                <input type="text" name="flat" required maxlength="50"
                                    placeholder="e.g flat & building number" class="input">
                            </div>
                            <div class="input-field">
                                <p>address line 02 </p>
                                <input type="text" name="street" maxlength="50" placeholder="e.g street name"
                                    class="input">
                            </div>
                            <div class="input-field">
                                <p>city name<span>*</span></p>
                                <input type="text" name="city" required maxlength="50"
                                    placeholder="enter your city name" class="input">
                            </div>
                            <div class="input-field">
                                <p>country name<span>*</span></p>
                                <input type="text" name="country" required maxlength="50"
                                    placeholder="enter your country name" class="input">
                            </div>
                            <div class="input-field">
                                <p>zip code<span>*</span></p>
                                <input type="number" name="zipcode" required maxlength="6" placeholder="10001" min="0"
                                    max="999999" class="input">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="place_order" class="btn">place order</button>
                </form>
                <div class="summary">
                    <h3>my bag</h3>
                    <div class="box-container">
                        <?php
                            $grand_total = 0;

                            if(isset($_GET['get_id'])){
                            $select_get = $conn->prepare('select * from `products` where id = ?');
                            $select_get->execute([$_GET['get_id']]);

                                while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                                $sub_total = $fetch_get['price'];
                                $grand_total += $sub_total;

                       ?>

                        <div class="flex">
                            <img src="img/<?php echo $fetch_get['image']; ?>" alt="">
                            <div>
                                <h3 class="name"><?php echo $fetch_get['name']; ?></h3>
                                <p class="price"><?php echo $fetch_get['price']; ?></p>
                            </div>
                        </div>

                        <?php
                                }
                           }else {
                           $grand_total = 0;

                           $select_cart = $conn->prepare('select * from `cart` where user_id=?');
                           $select_cart->execute([$user_id]);

                           if ($select_cart->rowCount() > 0) {
                            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                $select_product = $conn->prepare('select *  from `products` where id =?');
                                $select_product->execute([$fetch_cart['product_id']]);

                                if ($select_product->rowCount() > 0) {
                                $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
                                $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);
                                $grand_total += $sub_total;

                                    ?>

                        <div class="flex">
                            <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
                            <div>
                                <h3 class="name"><?php echo $fetch_product['name']; ?></h3>
                                <p class="price"><?php echo $fetch_product['price']; ?> x
                                    <?php echo $fetch_cart['qty']; ?></p>
                            </div>
                        </div>

                        <?php
                                }

                             }
                           }else{
                                    echo '<p class="empty">your cart is empty</p>';
                                    }

                           }
                        ?>
                    </div>
                    <div class="grand-total"><span>total amount : </span>
                        <p>$<?php echo $grand_total;?></p>
                    </div>
                </div>
            </div>
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