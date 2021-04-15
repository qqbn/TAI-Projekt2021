<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Fredoka+One&family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/upload.css">
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


if (isset($_POST['send'])) {
    $target = "photos/".basename($_FILES['image']['name']);
    $image = $_FILES['image']['name'];
    $comment = $_POST['comment'];
    $date= new DateTime;
    $czas=$date->format('Y-m-d H:i:s');
    $sql = "INSERT INTO posts (post_id, content, photo, user_id, upload_date) VALUES (NULL, '$comment', '$image', '$user_id', '$czas')";
    $db->insert($sql);
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        echo "Image uploaded successfully";
    }else{
        echo "There was a problem uploading image";
    }
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
            <h1>Select photo and add some description!</h1>
            <div class="upload-box">
                <form action="uploading.php" method="POST" enctype="multipart/form-data" class="form">
                <input type="text" name="comment" id="comment">
                <input type="submit" name="send" id="send" value="Add!">
                <input type="file" name="image" id="image">
                </form>
            </div>
        </div>
        <div class="right-container">
            
            <img src="icons/uploading.svg" alt="upload" class="uploadimg">                
            
        </div>
    </div>
</body>
</html>