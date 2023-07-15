<?php

require_once 'init.php';
echo Session::flash('success') . "<br>";
$user = new User();
if($user->isLoggedIn()) {
   echo "Hi, {$user->getData()->username}";
   echo "<p><a href='logout.php'> Logout</a></p>";
   echo "<p><a href='update.php'> Update </a></p>";
   echo "<p><a href='change_password.php'> Change password </a></p>";
   if($user->hasPermission('admin')) {
       echo 'You are admin';
   }
} else {
    echo "<a href='login.php'> Login</a> or <a href='register.php'> Register </a>";
}