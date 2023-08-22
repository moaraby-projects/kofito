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
  header('location:view_products.php');
  }

if(isset($_GET['get_id'])){
$get_id = $_GET['get_id'];
}else{
$get_id = '';
header('location:home.php');
}

// again order
if (isset($_POST['again'])) {
    $verify_orders = $conn->prepare('select * from `orders` where id= ? limit 1');
    $verify_orders->execute([$get_id]);
    if ($verify_orders->rowCount() > 0) {
        $insert_again = $conn->prepare('UPDATE `orders` SET `status` = "in progress" WHERE `orders`.`id` = ?');
        $insert_again->execute([$get_id]);
    }
}
// cancel order
if (isset($_POST['cancel'])) {
    $verify_order = $conn->prepare('select * from `orders` where id= ? limit 1');
    $verify_order->execute([$get_id]);
    if ($verify_order->rowCount() > 0) {
        $insert_cancel = $conn->prepare('UPDATE `orders` SET `status` = "canceled" WHERE `orders`.`id` = ?');
        $insert_cancel->execute([$get_id]);
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
    <title>Kofito- orders details Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>orders details</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a> <a href="orders.php">/ orders </a> <span>/ orders details</span>
        </div>
        <section class="order-details">
            <div class="title">
                <img src="imgs/logo.png" alt="" class="logo-coffee">
                <h1>orders details</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim quisquam numquam laboriosam! Neque
                    quae natus optio obcaecati tempora eum.</p>
            </div>
            <div class="box-container">
                <?php
                    $grand_total = 0;
                    $select_order = $conn->prepare('select * from `orders` where id = ? limit 1');
                    $select_order->execute([$get_id]);

                    if ($select_order->rowCount()>0) {
                        while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                        $select_product = $conn->prepare('select * from `products` where id= ? limit 1');
                        $select_product->execute([$fetch_order['product_id']]);

                            if ($select_product->rowCount() > 0) {
                                while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                                $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
                                $grand_total += $sub_total;

                ?>

                <div class="box">
                    <div class="col">
                        <p class="title"><i class='bx bxs-calendar'></i><?php echo $fetch_order['date']; ?></p>
                        <img src="img/<?php echo $fetch_product['image']; ?>" class="image" alt="">
                        <p class="price"><?php echo $fetch_order['price']; ?> x <?php echo $fetch_order['qty']; ?></p>
                        <h3 class="name"><?php echo $fetch_product['name']; ?></h3>
                        <p class="grand-total">total amount : <span> $<?php echo $grand_total; ?></span></p>
                    </div>
                    <div class="col">
                        <p class="title">billing address</p>
                        <p class="user"><i class='bx bx-user'></i><?php echo $fetch_order['name']; ?></p>
                        <p class="user"><i class="bx bx-phone"></i><?php echo $fetch_order['number']; ?></p>
                        <p class="user"><i class="bx bx-envelope"></i><?php echo $fetch_order['email']; ?></p>
                        <p class="user"><i class='bx bx-map-pin'></i><?php echo $fetch_order['address']; ?></p>
                        <p class="title">status</p>
                        <p class="status"
                            style="color:<?php if($fetch_order['status'] == 'delivery'){echo 'green';}elseif($fetch_order['status'] == 'canceled'){echo 'red';} else{echo 'orange';}; ?>;">
                            <?php if($fetch_order['status'] == 'delivery'){echo "delivery";}elseif($fetch_order['status'] == 'canceled'){echo "canceled";}else {echo 'in progress';}; ?>
                        </p>

                        <?php
                        if ($fetch_order['status'] == "canceled"){
                        ?>
                        <form action="" method="post">
                            <button type="submit" name="again" class="btn">order again</button>
                        </form>
                        <?php
                        }else {
                        ?>
                        <form action="" method="post">
                            <button type="submit" name="cancel" class="btn"
                                onclick="return confirm('do you want to cancel this order?') ">cancel
                                order</button>
                        </form>
                        <?php
                        }
                        ?>

                    </div>
                </div>

                <?php
                                }
                            }else{
                                echo '<p class="empty">product not found</p>';
                            }

                        }
                    }else{
                        echo '<p class="empty">no order found</p>';
                    }

                ?>
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