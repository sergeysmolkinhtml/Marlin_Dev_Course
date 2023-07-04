<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <div class="col-md-4">
        <?php if ($_SESSION['user']): ?>
            <h4>Здраствуйте, <?php echo $_SESSION['user']['email'] ?></h4>
        <?php else: ?>
            <h4>Вы не авторизованы</h4>
        <?php endif ?>

        <?php if ($_SESSION['user']): ?>
            <a href="logout.php" class="btn btn-danger"> Выйти</a>
        <?php else: ?>
            <a href="auth_form.php" class="btn btn-info"> Войти</a>
        <?php endif ?>

    </div>
</div>
</body>
</html>