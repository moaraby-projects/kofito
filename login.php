<?php
include 'components/connection.php';
session_start();

 if(isset($_SESSION['user_id'])){
 $user_id = $_SESSION['user_id'];
 }else{
 $user_id = '';
 }

if(isset($_POST['submit'])){
$email = $_POST['email'];
$email = filter_var($email , FILTER_SANITIZE_STRING);
$pass = $_POST['pass'];
$pass= filter_var($pass , FILTER_SANITIZE_STRING);

$select_user = $conn->prepare('select * from `users` where email= ? and password= ?');
$select_user->execute([$email,$pass]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

  if($select_user->rowCount() < 1){
  echo '<h1 class="alert-error-log">email or password error</h1>';
  }elseif ($row['user_status'] == "block") {
    echo '<h1 class="alert-error-log">Your Blocked!</h1>';
  }else{
  echo '<h1 class="alert-success-log">welcome, ' .$row['name'] .'</h1>';
    if($select_user->rowCount()>0){
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];
    header("REFRESH:3 , URL=home.php");

   }
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
    <title>Kofito - login Page</title>
</head>

<body>

    <!-- start main -->
    <div class="main-container">
        <!-- start form -->
        <section class="form-container">
            <div class="title">
                <img src="imgs/logo.png" class="logo-coffee" alt="">
                <h1>login now</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas, quis minus. Accusantium delectus
                    odio fugit cum esse consequatur, a quis.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>your email</p>
                    <input type="email" name="email" required maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>your password </p>
                    <input type="password" name="pass" required maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <button type="submit" name="submit" class="btn">Login</button>
                <p class="having">You do not have an account؟ <a href="register.php">register now</a> </p>
            </form>
        </section>
        <!-- end form -->
    </div>
    <!-- end main -->

    <!-- scripts -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script> -->
    <script>
    <?php include 'js/main.js'; ?>
    </script>
    <?php include 'components/alert.php'; ?>
</body>

</html>