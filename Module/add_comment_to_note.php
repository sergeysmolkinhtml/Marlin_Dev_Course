<?php

require 'notes_functions.php';


if($_POST) {
    $content = $_POST['content'];
    $user_id = $_GET['id'];
    $note_id = $_GET['note_id'];

    createComment(content: $content, user_id: $user_id, note_id: $note_id);
    redirectToProfile();
}




