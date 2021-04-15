<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Fredoka+One&family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/mainstyle.css">
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
$user_id=$um->getLoggedInUser($db,$session_id);
if($user_id<0){
    header("location:login.php");
}

if (isset($_GET['delete'])){
    $photo_delete=$_GET['delete'];
    $db->delete("DELETE FROM posts WHERE post_id='$photo_delete'");
}
$sql = "SELECT * FROM posts ORDER BY upload_date desc";
$result=$db->select($sql);

?>


<body>
    <nav>
        <ul>
            <li><a href="main.php">MAIN</a></li>
            <li><a href="profile.php">PROFILE</a></li>
            <li><a href="login.php?logout">LOGOUT</a></li>
        </ul>
    </nav>
    <?php
    if(count($result)==0){
        echo"
        <div class='right-container'>
            <img class='background' src='icons/background.svg' alt='back'>
                <div class='main-text'>
                <p>Add some stuff to our community!</p>
                <label class='add-button'>
                    <a href='uploading.php'><img src='icons/plus3.svg' alt='plus'></a>
                </label>
                
                </div>
        </div>


        ";
    }else{
    foreach($result as $post){
        echo"
        <div class='main-container'>
        <div class='left-container'>
            <div class='main-box'>
                <div class='images'>
                    <img class='photos' src='photos/$post->photo'  alt='photo'>
                </div>
                <div class='images-text'>
                    <p>$post->content</p>
                </div>
                <div class='heart'>
                   ";
                   if($post->user_id==$user_id){
                    echo"<a href='main.php?delete=$post->post_id'>DELETE!</a>";
                   }
                   $username=$db->select("SELECT login FROM users WHERE user_id='$post->user_id'");
                   $username=$username[0]->login;
                   $czas=date('d-m-Y', strtotime($post->upload_date));
                   echo "
                
                   <p> $username </p>
                   <p>$czas</p>
                </div>
            </div>
        </div>
        <div class='right-container'>
            <img class='background' src='icons/background.svg' alt='back'>
                <div class='main-text'>
                <p>Add some stuff to our community!</p>
                <label class='add-button'>
                    <a href='uploading.php'><img src='icons/plus3.svg' alt='plus'></a>
                </label>
                
                </div>
        </div>

    </div>
    ";    
    }
}
   

    ?>
</body>
</html>