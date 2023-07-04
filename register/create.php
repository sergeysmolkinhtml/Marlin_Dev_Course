<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-info">Емейл занят</div>
            <?php endif; ?>

            <form action="store.php" method="post">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="text" class="form-control" name="password">
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-success">Войти</button>
                </div>
            </form>

        </div>
    </div>
</div>
</body>
</html>