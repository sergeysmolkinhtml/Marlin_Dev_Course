<?php

session_start();


$_SESSION['counter'] +=1;

header('Location: http://marl/task_14.php');


