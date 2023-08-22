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
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="styleshe
    et">
    <link rel="stylesheet" href="css/boxicons.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css"> -->
    <title>Kofito - orders Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>my orders</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>/ orders</span>
        </div>
        <section class="orders">
            <div class="title">
                <img src="imgs/logo.png" alt="" class="logo-coffee">
                <h1>my orders</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim quisquam numquam laboriosam! Neque
                    quae natus optio obcaecati tempora eum.</p>
            </div>
            <div class="box-container">
                <?php
                    $select_order = $conn->prepare('select * from `orders` where user_id = ? order by date desc');
                    $select_order->execute([$user_id]);
                    if ($select_order->rowCount() > 0) {
                    while ($fetch_orders = $select_order->fetch(PDO::FETCH_ASSOC)) {
                    $select_product = $conn->prepare('select * from `products` where id=?');
                    $select_product->execute([$fetch_orders['product_id']]);

                        if ($select_product->rowCount() > 0) {
                            while ($fetch_products = $select_product->fetch(pdo::FETCH_ASSOC)) {

                    ?>

                <div class="box"
                    <?php if($fetch_orders['status'] == 'cancel') {echo 'style="border: 2px solid red"';}; ?>>
                    <a href="view_order.php?get_id=<?php echo $fetch_orders['id']; ?>">
                        <p class="date"><i class='bx bxs-calendar'></i><span><?php echo $fetch_orders['date']; ?></span>
                        </p>
                        <img src="img/<?php echo $fetch_products['image']; ?>" alt="">

                        <div class="row">
                            <h3 class="name"><?php echo $fetch_products['name']; ?></h3>
                            <p class="price">price : $<?php echo $fetch_orders['price']; ?> x
                                <?php echo $fetch_orders['qty']; ?></p>
                            <p class="status"
                                style="color:<?php if($fetch_orders['status'] == 'delivery'){echo 'green';}elseif($fetch_orders['status'] == 'canceled'){echo 'red';} else{echo 'orange';}; ?>;">
                                <?php if($fetch_orders['status'] == 'delivery'){echo "delivery";}elseif($fetch_orders['status'] == 'canceled'){echo "canceled";}else {echo 'in progress';}; ?>
                            </p>
                        </div>
                    </a>
                </div>

                <?php
                            }
                        }
                    }
                }else{
                        echo '<p class="empty">no order added yet!</p>';
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