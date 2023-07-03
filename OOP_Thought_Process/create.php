<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create post </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <div class="row div col-md-8 offset-md-2">
        <form action="store.php" method="post">
            <div class="form-group">
                <label for="title">Title
                    <input type="text" name="title" class="form-control">
                </label>
                <div class="form-group">
                    <button class="btn btn-success">Add post</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>