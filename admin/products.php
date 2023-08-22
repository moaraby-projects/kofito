            <!-- php code -->
            <?php
            include '../components/connection.php';

            if(isset($_POST['add'])){
            $NAME = $_POST['name'];
            $PRICE = $_POST['price'];

            // IMAGE
            $IMAGE_NAME =$_FILES['image']['name'];
            $IMAGE_TMP =$_FILES['image']['tmp_name'];

            if(empty($NAME) || empty($PRICE)){
            echo '<div style="text-align: center;font-size: 25px;" class="alert alert-dark"  role="alert">الرجاء ملء جميع الحقول </div>';
            }else{
            $post_image = rand(0,1000)."_".$IMAGE_NAME;
            move_uploaded_file($IMAGE_TMP,"../img\\$post_image");

            $insert_product = $conn->prepare("insert into `products`(name,price,image) values('$NAME','$PRICE','$post_image')");
            $insert_product->execute();
            if($insert_product){
            echo '<div style=" text-align: center;font-size: 25px;" class="alert alert-success"  role="alert">تم اضافة المنشور بنجاح</div>';
            header('location:products.php');
            }else{
            echo '<div style="text-align: center;font-size: 25px;" class="alert alert-danger">حدث خطأ ما</div>';
            }
            }
            }

            // delete item from cart
               if(isset($_POST['delete_item'])){
                $product_id = $_POST['product_id'];
                $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
                $verify_delete_items = $conn->prepare('select * from `products` where id =?');
                $verify_delete_items->execute([$product_id]);

                if($verify_delete_items->rowCount() > 0){
                $delete_item = $conn->prepare("DELETE FROM `products` WHERE `products`.`id` = ?");
                $delete_item->execute([$product_id]);
                // echo 'done deleted';
                header('location:products.php');
                }else{
                echo 'cart items already deleted';
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

                    <div class="add-product">
                        <h4 class="title-custom">ADD Product</h4>
                        <!-- php code -->
                        <!-- end code -->
                        <form action="products.php" method="post" enctype="multipart/form-data">
                            <div class="all">
                                <div class="inputBox">
                                    <input name="name" placeholder="Write here..." type="text" required="">
                                    <span>Name :</span>
                                </div>
                                <div class="inputBox">
                                    <input name="price" placeholder="Write here..." type="text" required="">
                                    <span>Price :</span>
                                </div>
                                <div class="inputBox">
                                    <input name="image" placeholder="Write here..." type="file" required="">
                                    <span>Image :</span>
                                </div>
                            </div>
                            <button type="submit" name="add"><span>ADD</span></button>
                        </form>
                    </div>
                    <section class="products">
                        <h4 class="title-custom"></h4>

                        <div class="box-container">
                            <?php
                $select_user = $conn->prepare('select * from `products`');
                $select_user->execute();
                if($select_user->rowCount() > 0){
                  while($fetch_products = $select_user->fetch(PDO::FETCH_ASSOC)){

                ?>
                            <form method="post" class="box">
                                <img src='../img/<?php echo $fetch_products['image']; ?>' alt="">
                                <h3 class="name"><?php echo $fetch_products['name']; ?></h3>
                                <input type="hidden" name="product_id" value='<?php echo $fetch_products['id']; ?>'>
                                <div class="flex">
                                    <p class="price">price $<?php echo $fetch_products['price'] ; ?></p>
                                </div>
                                <button id="remove-cart" type="submit" name="delete_item" class="btn-delete"
                                    onclick="return confirm('delete this item')"><i class="bx bx-x"></i></button>

                            </form>
                            <?php
                  }
                }else{
                  echo '<p class="empty">no products added yet!</p>';
                  }
                ?>
                        </div>
                        <h4 class="title-custom bottom"></h4>

                    </section>
                </section>

                <script>
                <?php include '../js/dashboard.js'; ?>
                </script>
            </body>

            </html>