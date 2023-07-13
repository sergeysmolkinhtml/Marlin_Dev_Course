<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>
            Подготовительные задания к курсу
        </title>
        <meta name="description" content="Chartist.html">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="../css/vendors.bundle.css">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="../css/app.bundle.css">
        <link id="myskin" rel="stylesheet" media="screen, print" href="../css/skins/skin-master.css">
        <link rel="stylesheet" media="screen, print" href="../css/statistics/chartist/chartist.css">
        <link rel="stylesheet" media="screen, print" href="../css/miscellaneous/lightgallery/lightgallery.bundle.css">
        <link rel="stylesheet" media="screen, print" href="../css/fa-solid.css">
        <link rel="stylesheet" media="screen, print" href="../css/fa-brands.css">
        <link rel="stylesheet" media="screen, print" href="../css/fa-regular.css">
    </head>
    <body class="mod-bg-1 mod-nav-link ">
        <main id="js-page-content" role="main" class="page-content">
            <div class="col-md-6">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Задание
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        </div>
                    </div>
                    <?php
                        $pdo = new PDO('mysql:host=marl;dbname=users','root', '');
                        $statement = $pdo->prepare('SELECT * FROM users');
                        $statement->execute();
                        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <h5 class="frame-heading">
                                Обычная таблица
                            </h5>
                            <div class="frame-wrap">
                                <table class="table m-0">
                                    <thead> Users </thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                            <th>Actions</th>
                                        </tr>

                                    <tbody>
                                    <?php foreach ($users as $user):?>
                                        <tr>
                                            <th scope="row"><?php echo $user['id']?></th>
                                            <td><?php echo $user['first_name']?></td>
                                            <td><?php echo $user['last_name']?></td>
                                            <td><?php echo $user['username']?></td>
                                            <td>
                                                <a href="show.php?id=<?php echo $user['id']?>" class="btn btn-info">Редактировать</a>
                                                <a href="edit.php?id=<?php echo $user['id']?>" class="btn btn-warning">Изменить</a>
                                                <a href="delete.php?id=<?php echo $user['id']?>" class="btn btn-danger">Удалить</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        

        <script src="../js/vendors.bundle.js"></script>
        <script src="../js/app.bundle.js"></script>
        <script>
            // default list filter
            initApp.listFilter($('#js_default_list'), $('#js_default_list_filter'));
            // custom response message
            initApp.listFilter($('#js-list-msg'), $('#js-list-msg-filter'));
        </script>
    </body>
</html>
