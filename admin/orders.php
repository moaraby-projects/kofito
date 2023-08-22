            <!-- php code -->
            <?php
            include '../components/connection.php';

            // sum orders
            $sum_orders =0 ;
            $delivery_orders =0 ;
            $progress_orders =0 ;

            $select_order = $conn->prepare('select * from `orders`');
            $select_order->execute();

            if ($select_order->rowCount()>0) {
            $sum_orders = $select_order->rowCount();
            while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
            if ($fetch_order['status'] == 'delivery') {
                $delivery_orders++;

            }elseif($fetch_order['status'] == 'in progress'){
            $progress_orders++;

            }

            }
            }

            // delete all order
            if (isset($_POST['delete_all_orders'])) {
                $verify_orders = $conn->prepare('select * from `orders`');
                $verify_orders->execute();
                if ($verify_orders->rowCount() > 0) {
                    $delete_orders = $conn->prepare('DELETE FROM `orders`');
                    $delete_orders->execute();
                    header('location:orders.php');
                }
            }
            // delete one order
            if (isset($_POST['delete_item'])) {
                $verify_orders = $conn->prepare('select * from `orders` where id= ? limit 1');
                $verify_orders->execute([$_POST['id_order']]);
                if ($verify_orders->rowCount() > 0) {
                    $insert_delivery = $conn->prepare('DELETE FROM orders WHERE `orders`.`id` = ?');
                    $insert_delivery->execute([$_POST['id_order']]);
                    header('location:orders.php');
                }
            }

            // update status for delivery => get_d == get_delivery
            if (isset($_GET['get_d'])) {
                $verify_orders = $conn->prepare('select * from `orders` where id= ? limit 1');
                $verify_orders->execute([$_GET['get_d']]);
                if ($verify_orders->rowCount() > 0) {
                    $insert_delivery = $conn->prepare('UPDATE `orders` SET `status` = "delivery" WHERE `orders`.`id` = ?');
                    $insert_delivery->execute([$_GET['get_d']]);
                    header('location:orders.php');
                }
            }

            // update status for in progress => get_p == get_progress
            if (isset($_GET['get_p'])) {
                $verify_orders = $conn->prepare('select * from `orders` where id= ? limit 1');
                $verify_orders->execute([$_GET['get_p']]);
                if ($verify_orders->rowCount() > 0) {
                    $insert_delivery = $conn->prepare('UPDATE `orders` SET `status` = "in progress" WHERE `orders`.`id` = ?');
                    $insert_delivery->execute([$_GET['get_p']]);
                    header('location:orders.php');
                }
            }



            ?>
            <!-- end code -->

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <link rel="stylesheet" href="../css/boxicons.min.css">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <!----======== CSS ======== -->
                <style>
                <?php include '../css/dashboard.css';
                ?>
                </style>

                <!----===== Iconscout CSS ===== -->
                <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

                <title>Admin Dashboard Panel</title>
            </head>

            <body>
                <nav>
                    <div class="logo-name">
                        <div class="logo-image">
                            <img src="../imgs/logo.png" alt="">
                        </div>

                        <span class="logo_name">Dashboard</span>
                    </div>

                    <div class="menu-items">
                        <ul class="nav-links">
                            <li><a href="dashboard.php">
                                    <i class="uil uil-estate"></i>
                                    <span class="link-name">Dashboard</span>
                                </a></li>
                            <li><a href="products.php">
                                    <i class="uil uil-files-landscapes"></i>
                                    <span class="link-name">Products</span>
                                </a></li>
                            <li><a href="orders.php">
                                    <i class="uil uil-chart"></i>
                                    <span class="link-name">Orders</span>
                                </a></li>
                            <li><a href="users.php">
                                    <i class='uil uil-users-alt'></i>
                                    <span class="link-name">Users</span>
                                </a></li>
                            <li><a href="messages.php">
                                    <i class="uil uil-comments"></i>
                                    <span class="link-name">messages</span>
                                </a></li>
                        </ul>

                        <ul class="logout-mode">
                            <li><a href="#">
                                    <i class="uil uil-signout"></i>
                                    <span class="link-name">Logout</span>
                                </a></li>

                            <li class="mode">
                                <!-- <a href="#">
                                    <i class="uil uil-moon"></i>
                                    <span class="link-name">Dark Mode</span>
                                </a> -->

                                <div class="mode-toggle">
                                    <!-- <span class="switch"></span> -->
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <section class="dashboard">
                    <div class="top">
                        <i class="uil uil-bars sidebar-toggle"></i>

                        <div class="search-box">
                            <i class="uil uil-search"></i>
                            <input type="text" placeholder="Search here...">
                        </div>
                    </div>

                    <div class="order-details">
                        <h4 class="title-custom">All Orders (<?php echo $sum_orders;?>) <form class="form-delete"
                                action="orders.php" method="post">
                                <button type="submit" name="delete_all_orders" class="btn-delete all"
                                    onclick="return confirm('delete all orders')"><i class="bx bx-x"></i></button>
                            </form>
                            <div> <span style="color:green;font-size:1rem;">Delivery :
                                    (<?php echo $delivery_orders;?>)</span>
                                <span style="color:orange;font-size:1rem;">In
                                    Progress :
                                    (<?php echo $progress_orders;?>)</span>
                            </div>
                        </h4>

                        <div class="box-container">
                            <?php
                    $grand_total = 0;
                    $select_order = $conn->prepare('select * from `orders` order by date desc');
                    $select_order->execute();

                    if ($select_order->rowCount()>0) {
                    $sum_orders = $select_order->rowCount();
                        while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                        if($fetch_order['status'] == 'canceled'){

                        }
                        else{
                        $select_product = $conn->prepare('select * from `products` where id= ?');
                        $select_product->execute([$fetch_order['product_id']]);

                            if ($select_product->rowCount() > 0) {
                                while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                                $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
                                $grand_total += $sub_total;

                ?>

                            <div class="box">
                                <form style="width: 100%;" action="orders.php" method="post">
                                    <input type="hidden" name="id_order" value="<?php echo $fetch_order['id']; ?>">
                                    <button type="submit" name="delete_item" class="btn-delete"
                                        onclick="return confirm('delete this item')"><i class="bx bx-x"></i></button>
                                </form>
                                <div class="col">
                                    <p class="title"><i class='bx bxs-calendar'></i><?php echo $fetch_order['date']; ?>
                                    </p>
                                    <img src="../img/<?php echo $fetch_product['image']; ?>" class="image" alt="">
                                    <p class="price"><?php echo $fetch_order['price']; ?> x
                                        <?php echo $fetch_order['qty']; ?></p>
                                    <h3 class="name"><?php echo $fetch_product['name']; ?></h3>
                                    <p class="grand-total">total amount : <span> $<?php echo $grand_total; ?></span></p>
                                </div>
                                <div class="col">
                                    <p class="title">billing address</p>
                                    <p class="user"><i class='bx bx-user'></i><?php echo $fetch_order['name']; ?></p>
                                    <p class="user"><i class="bx bx-phone"></i><?php echo $fetch_order['number']; ?></p>
                                    <p class="user"><i class="bx bx-envelope"></i><?php echo $fetch_order['email']; ?>
                                    </p>
                                    <p class="user"><i class='bx bx-map-pin'></i><?php echo $fetch_order['address']; ?>
                                    </p>
                                    <p class="title">status</p>
                                    <p class="status"
                                        style="color:<?php if($fetch_order['status'] == 'delivery'){echo 'green';}elseif($fetch_order['status'] == 'canceled'){echo 'red';} else{echo 'orange';}; ?>;">
                                        <?php if($fetch_order['status'] == 'delivery'){echo "delivery";}elseif($fetch_order['status'] == 'canceled'){echo "canceled";}else {echo 'in progress';}; ?>
                                    </p>

                                    <?php
                        if ($fetch_order['status'] == "in progress"){
                        ?>
                                    <a class="btn" onclick="return confirm('do you want to delivery this order?')"
                                        href="orders.php?get_d=<?php echo $fetch_order['id']; ?>">Delivery</a>
                                    <?php
                        }else {
                        ?>
                                    <a class="btn" onclick="return confirm('do you want to in progress this order?')"
                                        href="orders.php?get_p=<?php echo $fetch_order['id']; ?>">In Progress</a>
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
                        }
                    }else{
                        echo '<p class="empty">no order found</p>';
                    }

                ?>
                        </div>
                    </div>
                </section>

                <script>
                <?php include '../js/dashboard.js'; ?>
                </script>
            </body>

            </html>