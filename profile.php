<?php
require_once './database/connection.php';
?>


<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id =htmlspecialchars($_GET['id']);
}else {
    header('Location ./show_users.php');
}


$sql="SELECT * FROM `users` WHERE `id`='$id'";
$result = $conn->query($sql);
$userData = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            height: 100vh;
            overflow: hidden;
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: center;
        }
        img{
            border-radius:50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body d-flex flex-column align-item-center justify-content-center">
                <img src="./uploads/<?php echo $userData['file_name']?>" alt="" class=" img-fuild mx-auto" style="width:50%;">
                <h1 class="text-center mt-5 mb-2">Name: <?php echo $userData['name']?></h1>
                <h1 class="text-center mt-5 mb-2">Email: <?php echo $userData['email']?></h1>
                 <a href="./show_users.php" class="btn btn-primary mt-5">Back</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</html>
