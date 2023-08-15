<?php 
require_once './database/connection.php'
?>


<?php



if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
}else {
    header("Location: ./show_users.php");
}
$sql = "SELECT * FROM `users` WHERE `id` ='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();


$delImg=$user['file_name'];


$sql="DELETE  FROM `users` WHERE `id`=$id";

if ($conn->query($sql)) {
    $folder ='uploads/';
    unlink($folder.$delImg);
  
    header("Location: ./show_users.php");
}else {
    $error="User Failed To Delete";
}