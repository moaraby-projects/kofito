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
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/boxicons.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet"> -->
    <title>Kofito - about us Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <!-- start banner -->
        <div class="banner">
            <h1>about us</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>/ about</span>
        </div>
        <div class="about-category">
            <div class="box">
                <img src="imgs/product1.jpg" alt="">
                <div class="details">
                    <span>coffee</span>
                    <h1>Coffee Beans</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="imgs/card1.jpg" alt="">
                <div class="details">
                    <span>coffee</span>
                    <h1>Coffee Drink</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="imgs/box3.jpg" alt="">
                <div class="details">
                    <span>coffee</span>
                    <h1>Coffee Package</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="imgs/product15.png" alt="">
                <div class="details">
                    <span>coffee</span>
                    <h1>Coffee Box</h1>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <!-- start banner -->
        <!-- start services -->
        <section class="services">
            <div class="title">
                <img class="logo" src="imgs/logo.png" alt="">
                <h1>why choose us</h1>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Omnis libero voluptatibus</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="img/icon2.png" alt="">
                    <div class="details">
                        <h3>great saving</h3>
                        <p>save big every order</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png" alt="">
                    <div class="details">
                        <h3>24*7 support</h3>
                        <p>one-on-one support</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon0.png" alt="">
                    <div class="details">
                        <h3>gift vouchers</h3>
                        <p>vouchers on every festivals</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon.png" alt="">
                    <div class="details">
                        <h3>worldwide delivery</h3>
                        <p>dropship worldwide </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- end services -->

        <!-- start about -->
        <div class="about">
            <div class="row">
                <div class="img-box">
                    <img src="imgs/box1.jpg" alt="">
                </div>
                <div class="details">
                    <h1>visit our beautiful showroom!</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos fugit temporibus enim harum
                        earum sunt beatae molestiae, doloremque animi quae rem at quisquam voluptatibus odio accusamus
                        esse vel asperiores repudiandae.</p>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <!-- end about -->

        <!-- start testimonials -->
        <div class="testimonials-container">
            <div class="title">
                <img class="logo" src="imgs/logo.png" alt="">
                <h1>what people say about us</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Natus excepturi magni tempore nihil harum
                    voluptatum, obcaecati id illo quidem eveniet.</p>
            </div>
            <div class="container">
                <div class="testimonials-item active">
                    <img src="imgs/team1.png" alt="">
                    <h1>david smith1</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam ut maiores esse doloremque
                        est perspiciatis, aut rerum corrupti placeat illum laborum sed minus totam iure nihil culpa
                        consectetur! Tenetur, et.</p>
                </div>
                <div class="testimonials-item ">
                    <img src="imgs/team2.png" alt="">
                    <h1>david smith2</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam ut maiores esse doloremque
                        est perspiciatis, aut rerum corrupti placeat illum laborum sed minus totam iure nihil culpa
                        consectetur! Tenetur, et.</p>
                </div>
                <div class="testimonials-item ">
                    <img src="imgs/team3.png" alt="">
                    <h1>david smith3</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Numquam ut maiores esse doloremque
                        est perspiciatis, aut rerum corrupti placeat illum laborum sed minus totam iure nihil culpa
                        consectetur! Tenetur, et.</p>
                </div>
                <div class="left-arrow" onclick="prevSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                <div class="right-arrow" onclick="nextSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
            </div>
        </div>
        <!-- end testimonials -->


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