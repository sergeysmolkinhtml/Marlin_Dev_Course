<?php


for ($i = 0 ; $i < count($_FILES['image']['name']) ; $i++) {
    uploadFile(
        $_FILES['image']['name'][$i],
        $_FILES['image']['tmp_name'][$i]
    );
}

function uploadFile($filename, $tmpName) : void
{

    $result = pathinfo($filename);

    $filename = uniqid() . 'marlin-course' . $result['extension'];

    move_uploaded_file($tmpName, 'uploads/' . $filename);


}

