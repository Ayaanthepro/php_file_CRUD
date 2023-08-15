<?php
require_once './database/connection.php'
?>

<?php
$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
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
        <div class="row d-flex">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1>Users</h1>
                        <a href="./create.php" class="btn btn-primary">Create User</a>
                    </div>
                    <div class="card-body">
                        <table class=" table table-dark table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($users) {
                                    foreach ($users as $user) {
                                ?>

                                        <tr>
                                            <td><?php echo $user['name'] ?></td>
                                            <td><?php echo $user['email'] ?></td>
                                            <td><?php echo date('F j, Y, g:i a', strtotime($user['created_at'])); ?></td>

                                            <td>
                                                <div class="d-flex">
                                                    <a href="./profile.php?id=<?php echo $user['id']?>" class="btn btn-warning">Show Profile</a>
                                                    <a href="./edit.php?id=<?php echo $user['id'] ?>" class="btn btn-outline-success mx-2">Edit</a>
                                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" id="delete-btn" onclick="Delete(<?php echo $user['id']; ?>)">Delete</button>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>

                                    <p class="d-flex justify-content-center h1 text-danger">No record Found</p>
                                <?php
                                }


                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="" class="btn btn-danger" id="btn-delete">Delete</a>
                </div>
            </div>
        </div>
    </div>
</body>




</body>
<script>
    const title = document.location.pathname.split('/').pop();
    const fileName = title.split('.')[0];
    document.getElementById('title').innerText = fileName;


    function Delete(id) {
        btnDelete = document.getElementById('btn-delete');
        btnDelete.setAttribute('href', './delete.php?id=' + id);

    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</html>