<?php

session_start();

unset($_SESSION['user']);

header('Location: http://marl/register/index.php');
