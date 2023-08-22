<?php
            include '../components/connection.php';

            // sum products
            $sum_products =0 ;

            $select_products = $conn->prepare('select * from `products`');
            $select_products->execute();

            if ($select_products->rowCount()>0) {
            $sum_products = $select_products->rowCount();
            }

            // sum messages
            $sum_messages =0 ;

            $select_messages = $conn->prepare('select * from `messages`');
            $select_messages->execute();

            if ($select_messages->rowCount()>0) {
            $sum_messages = $select_messages->rowCount();
            }

            // sum users
            $sum_users =0 ;

            $select_users = $conn->prepare('select * from `users`');
            $select_users->execute();

            if ($select_users->rowCount()>0) {
            $sum_users = $select_users->rowCount();
            }

            // sum orders
            $sum_orders =0 ;

            $select_orders = $conn->prepare('select * from `orders`');
            $select_orders->execute();

            if ($select_orders->rowCount()>0) {
            $sum_orders = $select_orders->rowCount();
            }
?>

<!DOCTYPE html>
<html lang="en">

<style>
<?php include '../css/dashboard.css';
?>
</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../css/dashboard.css">

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
                        <i class="uil uil-create-dashboard"></i>
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

            <!--<img src="images/profile.jpg" alt="">-->
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="text">Total Products</span>
                        <span class="number"><?php echo $sum_products; ?></span>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Total Messages</span>
                        <span class="number"><?php echo $sum_messages; ?></span>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-chart"></i>
                        <span class="text">Total Orders</span>
                        <span class="number"><?php echo $sum_orders; ?></span>
                    </div>
                    <div class="box box4">
                        <i class='uil uil-users-alt'></i>
                        <span class="text">Total Users</span>
                        <span class="number"><?php echo $sum_users; ?></span>
                    </div>
                </div>
            </div>

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Recent Activity</span>
                </div>

                <div style="justify-content: center; height: 40vh;" class="activity-data">
                    <p style="font-size:2rem;">Not Found Now!</p>
                </div>
            </div>
        </div>
    </section>

    <script>
    <?php include '../js/dashboard.js'; ?>
    </script>
</body>

</html>