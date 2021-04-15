<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Fredoka+One&family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>PHOTO BLOGS</title>
</head>
<?php
include "Baza.php";
include "UserManager.php";
$db=new Baza("localhost", "root", "", "blogs");
$um=new UserManager();
session_start();
$session_id=session_id();
session_destroy();

if (isset($_POST['register'])){
$um->register($db);
}

if($um->getLoggedInUser($db, $session_id)>0){
    header("location:main.php");
}
?>
<body>
    <div class="main-container">
        <div class="left-container">
            <h1>PHOTO BLOGS</h1>
            <div class="left-p"><p>Place where you can find inspiration!</p></div>
            <div class="image1"><img src="icons/mainpage.svg" alt="login"></div>
        </div>
        <div class="right-container">
            <img class="background" src="icons/background.svg" alt="back">
                <div class="register-box">
                    <div class="imgbox"><img src="icons/login2.svg" alt="login"></div>
                    <div class="registration">
                        <p class="register-text">Register</p>
                        <form action="register.php" method="POST" class="form">
                        <input type="text" placeholder="Login" name="login" id="login" required>
                        <input type="email" placeholder="Email" name="email" id="email" required>
                        <input type="password" placeholder="Password" name="passwd" id="passwd" required>
                        <input type="submit" name="register" id="register" value="START!" >
                        </form>
                    <p class="question"><a href="login.php">Registered?Login!</a></p>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>