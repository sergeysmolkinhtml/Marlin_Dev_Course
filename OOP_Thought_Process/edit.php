<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Edit</title>
</head>
<body>

<?php
$db = include_once 'Database/Start.php';

$id = $_GET['id'];
$post = $db->getOne('posts', $id);

?>

<div class="container">
    <h5>Edit</h5>
    <form action="update.php?id=<?php echo $id?>" method="post">
        <label for="title"> Title
            <input type="text" name="title" class="form-control" value="<?php echo $post['title'];?>">
        </label>
        <div class="form-group">
            <button class="btn btn-success">Edit post</button>
        </div>
    </form>
</div>


</body>
</html>