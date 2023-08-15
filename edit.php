<?php
require_once './database/connection.php'
?>


<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
} else {
    header('Location: ./show_users.php');
}
$sql = "SELECT * FROM `users` WHERE `id` ='$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$error = $success = "";
$name = $user['name'];
$email = $user['email'];
$delImg = $user['file_name'];

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    if (empty($name)) {
        $error = "Please enter your name.";
    } else if (empty($email)) {
        $error = "Please enter your email.";
    } else if (!empty($_FILES['file']['tmp_name'])) {
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileTemp = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        if ($fileType !== 'image/png' && $fileType !== 'image/jpeg' && $fileType !== 'image/jpg') {
            $error = "Only Png and jpeg files allowed";
        } 
        else if ($fileSize>2097152) {
            $error ='File size exceeds the maximum limit (2 MB).';
        }
        else {

            $folder = 'uploads/';
            $destination = 'uploads/' . $fileName;
            unlink($folder . $delImg);
            move_uploaded_file($fileTemp, $destination);
            $sql = "SELECT * FROM `users` WHERE `email` ='$email' AND `id` != $id";
            $result = $conn->query($sql);
            if ($result->num_rows==0) {
                $sql = "UPDATE `users` SET`name`='$name',`email`='$email',`file_name`='$fileName' WHERE `id` ='$id'";
                if ($conn->query($sql)) {
                    $success = "User data updated";
                } else {
                    $error = "User data failed to update";
                }
            } else {
                $error = "E-mail already exists";
            }
        }

    } else {
        $sql = "SELECT * FROM `users` WHERE `email` ='$email' AND `id` != $id";
        $result = $conn->query($sql);
        if ($result->num_rows==0) {
            $sql = "UPDATE `users` SET`name`='$name',`email`='$email' WHERE `id` ='$id'";
            if ($conn->query($sql)) {
                $success = "User title updated";
            } else {
                $error = "User title failed to update";
            }
        } else {
            $error = "E-mail already exists";
        }
    }

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title"></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            height: 100vh;
            overflow: hidden;
            display: flex;
            width: 100vw;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="row d-flex ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="h2">Update User</div>
                            <a href="./show_users.php" class="btn btn-outline-primary">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-danger"><?php echo $error ?></p>
                        <p class="text-success"><?php echo $success ?></p>
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" class="form" method="post" enctype="multipart/form-data">
                            <div class="mb-2 mt-2">
                                <label for="name" class="form-label h5">
                                    Name
                                </label>
                                <input type="text" class="form-control" name="name" value="<?php echo $name ?>" placeholder="Enter Your Name">
                            </div>
                            <div class="mb-2 mt-2">
                                <label for="email" class="form-label h5">
                                    Email
                                </label>
                                <input type="email" class="form-control" name="email" value="<?php echo $email ?>" placeholder="Enter Your Email">
                            </div>
                            <img src="./uploads/<?php echo $user['file_name'] ?>" alt="" style="width:200px";>
                            <div class="mb-2 mt-2">
                                <label for="password" class="form-label h5">
                                    Update Image
                                </label>
                                <input type="file" class="form-control" name="file" value="">
                            </div>
                            <div class="mb-2 mt-2">
                                <input type="submit" value="Submit" class="btn btn-primary" name="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const title =document.getElementById('title');
    filename=document.location.pathname;
    file =filename.split("/").pop(".");
    title.innerText=file.split('.')[0];
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</html>