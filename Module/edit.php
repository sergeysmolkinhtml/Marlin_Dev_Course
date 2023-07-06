<?php

require 'functions.php';

if(isAdmin(getCurrentUser())){
    $user = getCurrentUser();
}