<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img style="width:120px;" src="./imgs/logo-site.png"></a>

        <nav class="navbar">
            <a href="home.php" class="active">home</a>
            <a href="view_products.php">products</a>
            <a href="orders.php">orders</a>
            <a href="about.php">about us</a>
            <a href="contact.php">contact</a>
        </nav>

        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>

            <?php
            $count_wishlist_items = $conn->prepare('select * from `wishlist` where user_id=?');
            $count_wishlist_items->execute([$user_id]);

            $total_wishlist = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare('select * from `cart` where user_id=?');
            $count_cart_items->execute([$user_id]);

            $total_cart = $count_cart_items->rowCount();



            ?>

            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup
                    class="sup-sum"><?php echo $total_wishlist; ?></sup></a>
            <a href="cart.php" class="cart-btn"><i class='bx bxs-cart-alt cart'></i><sup
                    class="sup-sum"><?php echo $total_cart; ?></sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size:2rem;"></i>
        </div>

        <div class="user-box">
            <p id="info-log">Name : <span><?php
            if(isset($_SESSION['user_name'])){
            echo $_SESSION['user_name'];
            ?>
                    <style>
                    #info-log {
                        display: block;
                    }

                    #login {
                        display: none;
                    }

                    #register {
                        display: none;
                    }

                    #logout {
                        display: inline-block;
                    }

                    .sup-sum {
                        display: inline-block !important;
                    }
                    </style>
                    <?php
            }
            ?>
                </span></p>
            <p id="info-log">Email : <span><?php
            if(isset($_SESSION['user_name'])){
             echo $_SESSION['user_email'];
             }
             ?></span></p>
            <a href="login.php" class="btn" id="login">login</a>
            <a href="register.php" class="btn" id="register">register</a>

            <form method="post">
                <button id="logout" type="submit" name="logout" class="logout-btn">log out</button>
            </form>
        </div>

    </div>
</header>