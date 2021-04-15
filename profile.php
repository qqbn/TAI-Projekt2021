<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Fredoka+One&family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style2.css">
    <title>PHOTO BLOGS PROFILE</title>
</head>
<?php
include "Baza.php";
include "UserManager.php";
$db=new Baza("localhost", "root", "", "blogs");
$um=new UserManager();
session_start();
$session_id=session_id();
session_destroy();
$user_id=$um->getLoggedInUser($db, $session_id);
if($user_id<0){
    header("location:login.php");
}
$photos=$db->select("SELECT photo FROM posts WHERE user_id='$user_id'");
$photos_number=count($photos);
$profile_info=$db->select("SELECT login, email FROM users WHERE user_id='$user_id'");
$login=$profile_info[0]->login;
$email=$profile_info[0]->email;

if (isset($_POST['delete'])){
$db->delete("DELETE FROM users WHERE user_id='$user_id'");
$db->delete("DELETE FROM posts WHERE user_id='$user_id'");
$db->delete("DELETE FROM logged_in_users WHERE user_id='$user_id'");
header("location:login.php");
}
?>
<body>
    <nav>
        <ul>
            <li><a href="main.php">MAIN</a></li>
            <li><a href="profile.php">PROFILE</a></li>
            <li><a href="login.php?logout">LOGOUT</a></li>
        </ul>
    </nav>
    <div class="main-container">
        <div class="left-container">
            <h1>Welcome to your profile!</h1>
            <div class="image1"><img src="icons/profile.svg" alt="login"></div>
        </div>
        <div class="right-container">
            <img class="background" src="icons/background.svg" alt="back">
                <div class="profile-box">
                    <div class="imgbox"><img src="icons/login2.svg" alt="login"></div>
                    <div class="info">
                        <p>Login: <?php echo $login ?></p>
                        <p>E-mail: <?php echo $email ?></p>
                        <p>Photos: <?php echo $photos_number ?></p>  
                        <form action="profile.php" method="POST"><input type="submit" name="delete" id="delete" value="Delete my profile" ></form>
                    </div>
                </div>
                
            
        </div>
    </div>
</body>
</html>