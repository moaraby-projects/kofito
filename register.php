<?php
include 'components/connection.php';
session_start();

 if(isset($_SESSION['user_id'])){
 $user_id = $_SESSION['user_id'];
 }else{
 $user_id = '';
 }

if(isset($_POST['submit'])){
// $id = uniqid();
$name = $_POST['name'];
$name = filter_var($name , FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$email = filter_var($email , FILTER_SANITIZE_STRING);
$pass = $_POST['pass'];
$pass= filter_var($pass , FILTER_SANITIZE_STRING);
$cpass= $_POST['cpass'];
$cpass= filter_var($cpass , FILTER_SANITIZE_STRING);

$select_user = $conn->prepare('select * from `users` where email= ?');
$select_user->execute([$email]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

  if($select_user->rowCount() > 0){
//   echo '<h1 class="alert-error-log">email already exist</h1>';
  }else{
  if($pass != $cpass){
  echo '<h1 class="alert-error-log">confirm your password</h1>';
   }else{
   $insert_user = $conn->prepare('insert into `users`(name,email,password) values( ? , ? , ?)');
   $insert_user->execute([$name,$email,$pass]);

   $select_user = $conn->prepare('select * from `users` where email= ? and password= ?');
   $select_user->execute([$email,$pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount()>0){
    echo '<h1 class="alert-success-log">welcome, ' .$row['name'].'</h1>';

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];
    header("REFRESH:3 , URL=home.php");
    }
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
    <title>Kofito - register Page</title>
</head>

<body>

    <!-- start main -->
    <div class="main-container">
        <!-- start form -->
        <section class="form-container">
            <div class="title">
                <img class="logo" src="imgs/logo.png" alt="">
                <h1>register now</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas, quis minus. Accusantium delectus
                    odio fugit cum esse consequatur, a quis.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>your name <sup>*</sup> </p>
                    <input type="text" name="name" required maxlength="50">
                </div>
                <div class="input-field">
                    <p>your email <sup>*</sup> </p>
                    <input type="email" name="email" required maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>your password <sup>*</sup> </p>
                    <input type="password" name="pass" required maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>confirm password <sup>*</sup> </p>
                    <input type="password" name="cpass" required maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <button type="submit" name="submit" class="btn">register</button>
                <p class="having">already have an account? <a href="login.php">Login now</a> </p>
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