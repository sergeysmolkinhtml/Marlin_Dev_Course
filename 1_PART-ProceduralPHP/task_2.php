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
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="panel-content">
                        <div class="bg-warning-100 border border-warning rounded">
                            <div class="input-group p-2 mb-0">
                                <input type="text"
                                       class="form-control form-control-lg shadow-inset-2 bg-warning-50 border-warning"
                                       id="js-list-msg-filter" placeholder="Фильтр">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-warning-500 border-warning">
                                        <i class="fal fa-search fs-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $menu = [
                                ['title' => 'Репорты', 'tag' => 'reports file'],
                                ['title' => 'Аналитика', 'tag' => 'analytics graphs'],
                                ['title' => 'Экспорт', 'tag' => 'export download'],
                                ['title' => 'Хранилище', 'tag' => 'storage']
                            ];

                            ?>
                            <ul id="js-list-msg" class="list-group px-2 pb-2 js-list-filter">
                                <?php foreach ($menu as $value): ?>
                                    <li class='list-group-item'>
                                        <span data-filter-tags=<?php echo $value['tag'] ?> > <?php echo $value['title'] ?> </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="filter-message js-filter-message mt-0 fs-sm"></div>
                        </div>
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
