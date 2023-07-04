<?php
function update_password($password,$id){}
function update_email($email,$id){}

$email = $_POST['email'];
$password = $_POST['password'];
$id = $_GET['id'];

update_email($email, $id);
if(!empty($password)){
    update_password($password, $id);
}