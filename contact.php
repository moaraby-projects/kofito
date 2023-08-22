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

  if (isset($_POST['submit-btn'])) {
  $name = $_POST['name'];
  $name = filter_var($name , FILTER_SANITIZE_STRING);
  $email = $_POST['email'];
  $email = filter_var($email , FILTER_SANITIZE_STRING);
  $number = $_POST['number'];
  $number = filter_var($number , FILTER_SANITIZE_STRING);
  $message = $_POST['message'];
  $message = filter_var($message , FILTER_SANITIZE_STRING);

  $insert_message = $conn->prepare('insert into `messages`(name,email,number,message,user_id) values(?,?,?,?,?)');
  $insert_message->execute([$name,$email,$number,$message,$user_id]);

  if ($insert_message) {
    echo 'send message : Done';
    header('refresh:1; url=home.php');
  }else{
  echo 'send message : error!';
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet"> -->
    <title>Kofito - contact Page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>contact us</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>/ contact</span>
        </div>
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

        <!-- start form -->
        <div class="form-container">
            <div class="title">
                <img class="logo" src="imgs/logo.png" alt="">
                <h1>leave a message</h1>
            </div>
            <form action="contact.php" method="post">
                <div class="input-field">
                    <p>your name <sup>*</sup> </p>
                    <input type="text" required name="name">
                </div>
                <div class="input-field">
                    <p>your email <sup>*</sup> </p>
                    <input type="email" required name="email">
                </div>
                <div class="input-field">
                    <p>your number </p>
                    <input type="text" name="number">
                </div>
                <div class="input-field">
                    <p>your message <sup>*</sup> </p>
                    <textarea required name="message"></textarea>
                </div>
                <button type="submit" name="submit-btn" class="btn">send message</button>
            </form>
        </div>
        <!-- end form -->

        <!-- start address -->
        <div class="address">
            <div class="title">
                <img class="logo" src="imgs/logo.png" alt="">
                <h1>contact details</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, exercitationem?</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>address</h4>
                        <p>1008 new your city </p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-phone-call"></i>
                    <div>
                        <h4>phone number</h4>
                        <p>0101000000</p>
                    </div>
                </div>
                <div class="box">
                    <i class='bx bx-envelope'></i>
                    <div>
                        <h4>email</h4>
                        <p>moaraby@gmail.com</p>
                    </div>
                </div>

            </div>
        </div>
        <!-- end address -->

        <!-- footer -->
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