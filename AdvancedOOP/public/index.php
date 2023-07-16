<?php

require 'G:\OS\OSPanel\domains\marlin-course\vendor\autoload.php';

if($_SERVER['REQUEST_URI'] === '/home') {
    require '../app/controllers/homepage.php';
}
exit();