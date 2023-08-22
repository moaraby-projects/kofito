            <!-- php code -->
            <?php
            include '../components/connection.php';

            // sum users
            $sum_users =0 ;

            $select_users = $conn->prepare('select * from `users`');
            $select_users->execute();

            if ($select_users->rowCount()>0) {
            $sum_users = $select_users->rowCount();
            }

            // update user_status for block
            if (isset($_POST['block'])) {
                $verify_user = $conn->prepare('select * from `users` where id= ? limit 1');
                $verify_user->execute([$_POST['user_id']]);
                if ($verify_user->rowCount() > 0) {
                    $update_user = $conn->prepare('UPDATE `users` SET `user_status` = "block" WHERE `users`.`id` = ?');
                    $update_user->execute([$_POST['user_id']]);
                    header('location:users.php');
                }
            }
            // update user_status for unblock
            if (isset($_POST['unblock'])) {
                $verify_user = $conn->prepare('select * from `users` where id= ? limit 1');
                $verify_user->execute([$_POST['user_id']]);
                if ($verify_user->rowCount() > 0) {
                    $update_user = $conn->prepare('UPDATE `users` SET `user_status` = "unblock" WHERE `users`.`id` = ?');
                    $update_user->execute([$_POST['user_id']]);
                    header('location:users.php');
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

                    <div class="users">
                        <h4 class="title-custom">All Users (<?php echo $sum_users; ?>)</h4>

                        <div class="grid-messages">
                            <?php
                            $select_users =$conn->prepare('select * from `users`');
                            $select_users->execute();

                            if ($select_users->rowCount() > 0) {
                                while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                                ?>

                            <div class="box"
                                style="background:<?php if($fetch_users['user_status'] == "block"){echo "red";} ?>;">
                                <img src="../img/02.jpg" alt="">
                                <div class="info">
                                    <h3 class="user">User_ID :
                                        <span><?php echo $fetch_users['id']; ?></span>
                                    </h3>
                                    <h3 class="name">Name : <span><?php echo $fetch_users['name']; ?></span></h3>
                                    <h3 class="email">Email: <span><?php echo $fetch_users['email']; ?></span></h3>
                                </div>

                                <?php
                                    if ($fetch_users['user_status'] == "block"){
                                    ?>
                                <form style="width: 100%;" action="users.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $fetch_users['id']; ?>">
                                    <button type="submit" name="unblock" class="btn"
                                        onclick="return confirm('block user?')">UnBlock</button>
                                </form>
                                <?php
                                    }else {
                                    ?>
                                <form style="width: 100%;" action="users.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $fetch_users['id']; ?>">
                                    <button type="submit" name="block" class="btn"
                                        onclick="return confirm('block user?')">Block</button>
                                </form>
                                <?php
                                    }
                                ?>
                            </div>

                            <?php
                                }
                            }else{
                            echo 'No Found messages';
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