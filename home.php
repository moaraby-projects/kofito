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
    <title>Kofito - Home Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">

        <!-- start home session -->
        <section class="home-session">
            <div class="slider">
                <!-- start slide -->
                <div class="slider_slider slide1">
                    <div class="overlay"></div>
                    <div class="slide-details">
                        <h1>Lorem ipsum dolor sit</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste fuga voluptates veniam
                            obcaecati
                        </p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-des-top"></div>
                    <div class="hero-des-bottom"></div>
                    <div class="hero-des-r-top"></div>
                    <div class="hero-des-r-bottom"></div>
                </div>

                <div class="slider_slider slide2">
                    <div class="overlay"></div>
                    <div class="slide-details">
                        <h1>welcome my shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste fuga voluptates veniam
                            obcaecati
                        </p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-des-top"></div>
                    <div class="hero-des-bottom"></div>
                    <div class="hero-des-r-top"></div>
                    <div class="hero-des-r-bottom"></div>
                </div>

                <div class="slider_slider slide3">
                    <div class="overlay"></div>
                    <div class="slide-details">
                        <h1>Lorem ipsum dolor sit</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste fuga voluptates veniam
                            obcaecati
                        </p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-des-top"></div>
                    <div class="hero-des-bottom"></div>
                    <div class="hero-des-r-top"></div>
                    <div class="hero-des-r-bottom"></div>
                </div>

                <div class="slider_slider slide4">
                    <div class="overlay"></div>
                    <div class="slide-details">
                        <h1>welcome my shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste fuga voluptates veniam
                            obcaecati
                        </p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-des-top"></div>
                    <div class="hero-des-bottom"></div>
                    <div class="hero-des-r-top"></div>
                    <div class="hero-des-r-bottom"></div>
                </div>

                <div class="slider_slider slide5">
                    <div class="overlay"></div>
                    <div class="slide-details">
                        <h1>welcome my shop</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste fuga voluptates veniam
                            obcaecati
                        </p>
                        <a href="view_products.php" class="btn">Shop now</a>
                    </div>
                    <div class="hero-des-top"></div>
                    <div class="hero-des-bottom"></div>
                    <div class="hero-des-r-top"></div>
                    <div class="hero-des-r-bottom"></div>
                </div>
                <!-- end slide -->
                <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
                <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
            </div>
        </section>
        <!-- end home session -->

        <!-- start thumb -->
        <section class="thumb">
            <div class="box-container">
                <div class="box">
                    <img src="imgs/coffee.png" alt="">
                    <h3>Coffee beans</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="imgs/coffee2.png" alt="">
                    <h3>coffee cup</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="imgs/coffee3.png" alt="">
                    <h3>coffee hot</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="imgs/coffee4.png" alt="">
                    <h3>coffee shot</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
            </div>
        </section>
        <!-- end thumb -->
        <!-- start container -->
        <section class="container">
            <div class="box-container">
                <div class="box">
                    <img class="img-about" src="imgs/box2.jpg" alt="">
                </div>
                <div class="box">
                    <img class="logo-coffee" src="imgs/logo.png" alt="">
                    <span>healthy coffee</span>
                    <h1>save up to 50%</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor aut perspiciatis, assumenda
                        molestias vitae cumque corrupti quibusdam quaerat, nesciunt velit totam labore ipsum officiis
                        qui quam omnis enim quis placeat.</p>
                </div>
            </div>
        </section>
        <!-- end container -->
        <!-- start shop -->
        <div class="shop">
            <div class="title">
                <img class="logo-coffee" src="imgs/logo.png" alt="">
                <h1>treading products</h1>
            </div>
            <div class="row">
                <div style="width: 100%;" class="row-details">
                    <img src="imgs/Kofito.png" alt="">
                    <div class="top-footer">
                        <h1 style="    text-align: center;margin: auto;">a cup of Coffee makes you healthy</h1>
                    </div>
                </div>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="imgs/product1.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="imgs/box1.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="imgs/card1.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="imgs/box3.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="imgs/product13.png" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="imgs/product8.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="imgs/card3.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
                <div class="box">
                    <img src="imgs/product11.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <!-- end shop -->

        <!-- start shop category -->
        <section class="shop-category">
            <div class="box-container">
                <div class="box">
                    <img src="imgs/background10.jpg" alt="">
                    <div class="details">
                        <span>BIG OFFERS</span>
                        <h1>Extra 15% off</h1>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                </div>
                <div class="box">
                    <img src="imgs/background13.jpg" alt="">
                    <div class="details">
                        <span>NEW IN TASTE</span>
                        <h1>COFFEE HOUSE</h1>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- end shop category -->

        <!-- start services -->
        <section class="services">
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

        <!-- start brand -->
        <section class="brand">
            <div class="box-container">
                <div class="box">
                    <img src="img/brand (1).jpg" alt="">
                </div>
                <div class="box">
                    <img src="img/brand (2).jpg" alt="">
                </div>
                <div class="box">
                    <img src="img/brand (3).jpg" alt="">
                </div>
                <div class="box">
                    <img src="img/brand (4).jpg" alt="">
                </div>
                <div class="box">
                    <img src="img/brand (5).jpg" alt="">
                </div>
            </div>
        </section>
        <!-- end brand -->

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