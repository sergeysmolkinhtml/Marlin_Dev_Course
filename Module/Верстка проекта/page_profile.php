<?php session_start();

include_once '../functions.php';
include_once '../notes_functions.php';


if(!getCurrentUser()) {header("Location: http://marl/Module/Верстка%20проекта/page_login.php"); exit(); }

$userAuth = getUserById($_SESSION['user']['id']);
$userReal = getUserById($_GET['id'] ?? $_SESSION['user']['id']) ;

if(!isAdmin(getCurrentUser()) && !isEqual($userAuth, getCurrentUser())){
    header("Location: http://marl/Module/Верстка%20проекта/page_login.php");exit();
}

$notes = getUserNotes($userReal['id']);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
</head>
    <body class="mod-bg-1 mod-nav-link">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
            <a class="navbar-brand d-flex align-items-center fw-500" href="#"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Главная</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Войти</a>
                    </li>

                    <li class="nav-item">
                        <form action="../logout.php?id=<?php echo $userAuth['id']?>" method="post">
                            <button type="submit" class="nav-link" href="">Выйти</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
        <main id="js-page-content" role="main" class="page-content mt-3">
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-user'></i>
                </h1>
            </div>
            <div class="row">
              <div class="col-lg-6 col-xl-6 m-auto">
                    <!-- profile summary -->
                    <div class="card mb-g rounded-top">
                        <div class="row no-gutters row-grid">
                            <div class="col-12">
                                <div class="d-flex flex-column align-items-center justify-content-center p-4">
                                    <img src="img/demo/avatars/avatar-admin-lg.png" class="rounded-circle shadow-2 img-thumbnail" alt="">
                                    <h5 class="mb-0 fw-700 text-center mt-3">
                                        <?php echo $userReal['name'] ?? 'SOME NAME' ?>
                                        <small class="text-muted mb-0"><?php echo $userReal['job'] ?? 'Some job'?></small>
                                    </h5>
                                    <div class="mt-4 text-center demo">
                                        <a href="<?php echo $userReal['instagram']?>" class="fs-xl" style="color:#C13584">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="<?php echo $userReal['vk']?>" class="fs-xl" style="color:#4680C2">
                                            <i class="fab fa-vk"></i>
                                        </a>
                                        <a href="<?php echo $userReal['telegram']?>" class="fs-xl" style="color:#0088cc">
                                            <i class="fab fa-telegram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 text-center">
                                    <a href="tel:+13174562564" class="mt-1 d-block fs-sm fw-400 text-dark">
                                        <i class="fas fa-mobile-alt text-muted mr-2"></i> <?php echo $userReal['phone'] ?? 'Some phone'?></a>
                                    <a href="mailto:oliver.kopyov@marlin.ru" class="mt-1 d-block fs-sm fw-400 text-dark">
                                        <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?php echo $userReal['email'] ?? 'Some email'?></a>
                                    <address class="fs-sm fw-400 mt-4 text-muted">
                                        <i class="fas fa-map-pin mr-2"></i> <?php echo $userReal['address'] ?? 'Some address'?>
                                    </address>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 text-center">
                                    <div class="fs-sm fw-400 mt-4 text-muted">
                                        <i class="fas fa-map-pin mr-2"></i>
                                        <?php if(isAdmin($userAuth)): ?>
                                            <form action="../add_new_note.php?id=<?php echo $userReal['id']?>" method="post">
                                                <div class="form-group">
                                                    <label class="form-label" for="title">Название</label>
                                                    <input type="text" id="title" name="title" class="form-control"">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label" for="context">Контент</label>
                                                    <textarea id="context" name="context" class="form-control"> </textarea>
                                                </div>
                                               <button type="submit" class="btn btn-success">Добавить</button>
                                            </form>
                                        <?php endif ?>
                                        <nav class="navbar navbar-expand-sm navbar-dark">
                                            <img src="https://i.imgur.com/CFpa3nK.jpg" width="20" height="20" class="d-inline-block align-top rounded-circle" alt="">
                                            <a class="navbar-brand ml-2" href="#" data-abc="true">Rib Simpson</a>
                                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                                                <span class="navbar-toggler-icon"></span>
                                            </button>
                                            <div class="end">
                                                <div class="collapse navbar-collapse" id="navbarColor02">
                                                    <ul class="navbar-nav">
                                                        <li class="nav-item"> <a class="nav-link" href="#" data-abc="true">Work</a> </li>
                                                        <li class="nav-item"> <a class="nav-link" href="#" data-abc="true">Capabilities</a> </li>
                                                        <li class="nav-item "> <a class="nav-link" href="#" data-abc="true">Articles</a> </li>
                                                        <li class="nav-item active"> <a class="nav-link mt-2" href="#" data-abc="true" id="clicked">Contact<span class="sr-only">(current)</span></a> </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </nav>
                                        <?php foreach ($notes as $note): ?>
                                            <!-- posts -->
                                            <div class="card">
                                                <h5 class="card-header"><?php echo $note['title'] ?> </h5>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $note['id'] ?></h5>
                                                    <p class="card-text"><?php echo $note['context'] ?></p>
                                                </div>
                                            </div>
                                            <!-- Comments -->
                                            <section>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-5 col-md-6 col-12 pb-4">
                                                            <h1>Comments</h1>
                                                            <div class="comment mt-4 text-justify float-left">
                                                                <?php foreach (getUsersNotesComments($note['id'], $userReal['id']) as $noteCom):?>
                                                                    <img src="https://i.imgur.com/yTFUilP.jpg" alt="" class="rounded-circle" width="40" height="40">
                                                                    <h4></h4>
                                                                    <span> <?php echo $noteCom['created_at']?>8</span>

                                                                    <br>
                                                                    <p><?php echo $noteCom['content']?></p>
                                                                    <?php var_dump(displayNestedComments($noteCom['id'], getUsersNotesComments($note['id'], $userReal['id'])));exit();

                                                                    displayNestedComments($noteCom['id'], getUsersNotesComments($note['id'], $userReal['id']));
                                                                    ?>
                                                                <?php endforeach;?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                                                            <form action="../add_comment_to_note.php?id=<?php echo $userReal['id']?>&note_id=<?php echo $note['id']?>" method="post" id="algin-form">
                                                                <div class="form-group">
                                                                    <h4>Leave a comment</h4>
                                                                    <label for="message">Message</label>
                                                                    <textarea name="content" id="msg" cols="30" rows="5" class="form-control" style="background-color: #efeaea;"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="submit" id="post" class="btn btn-success">Post Comment</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <hr style="border: 2px solid darkcyan;">
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>

            </div>
        </main>
    </body>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

        });

    </script>
</html>