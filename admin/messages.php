            <!-- php code -->
            <?php
            include '../components/connection.php';

            // sum messages
            $sum_messages =0 ;

            $select_messages = $conn->prepare('select * from `messages`');
            $select_messages->execute();

            if ($select_messages->rowCount()>0) {
            $sum_messages = $select_messages->rowCount();
            }

            // delete all messages
            if (isset($_POST['delete_all_messages'])) {
                $verify_messages = $conn->prepare('select * from `messages`');
                $verify_messages->execute();
                if ($verify_messages->rowCount() > 0) {
                    $delete_messages = $conn->prepare('DELETE FROM `messages`');
                    $delete_messages->execute();
                    header('location:messages.php');
                }
            }

            // delete messages
            if (isset($_POST['delete_message'])) {
                $verify_messages = $conn->prepare('select * from `messages` where id= ? limit 1');
                $verify_messages->execute([$_POST['id_message']]);
                if ($verify_messages->rowCount() > 0) {
                    $delete_messages = $conn->prepare('DELETE FROM `messages` WHERE `messages`.`id` = ?');
                    $delete_messages->execute([$_POST['id_message']]);
                    header('location:messages.php');
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

                    <div class="messages">
                        <h4 class="title-custom">All Messages (<?php echo $sum_messages; ?>) <form class="form-delete"
                                action="messages.php" method="post">
                                <button type="submit" name="delete_all_messages" class="btn-delete-all"
                                    onclick="return confirm('delete all orders')"><i class="bx bx-x"></i></button>
                            </form>
                        </h4>

                        <div class="grid-messages">
                            <?php
                            $select_messages =$conn->prepare('select * from `messages`');
                            $select_messages->execute();

                            if ($select_messages->rowCount() > 0) {
                                while ($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)) {
                                ?>

                            <div class="box">
                                <form style="width: 100%;" action="messages.php" method="POST">
                                    <input type="hidden" name="id_message" value="<?php echo $fetch_messages['id']; ?>">
                                    <button type="submit" name="delete_message" class="btn-delete"
                                        onclick="return confirm('delete this item')"><i class="bx bx-x"></i></button>
                                </form>
                                <img src="../img/02.jpg" alt="">
                                <div class="info">
                                    <h3 class="user">User_ID :
                                        <span><?php if($fetch_messages['user_id']){echo $fetch_messages['user_id'];}else{echo 'Unknown';} ?></span>
                                    </h3>
                                    <h3 class="name">Name : <span><?php echo $fetch_messages['name']; ?></span></h3>
                                    <h3 class="email">Email: <span><?php echo $fetch_messages['email']; ?></span></h3>
                                    <h3 class="number">Number : <span><?php echo $fetch_messages['number']; ?></span>
                                    </h3>
                                    <p class="message"> Message : <span><?php echo $fetch_messages['message']; ?></span>
                                    </p>
                                </div>
                                <form action=" mailto:<?php echo $fetch_messages['email']; ?>" method="post"
                                    enctype="text/plain">
                                    <button type="submit" class="btn">Reply</button>
                                </form>
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