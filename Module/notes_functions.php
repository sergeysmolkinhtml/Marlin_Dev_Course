<?php

function createNote($title, $context, $user_id) : Mixed
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $stmt = $pdo->prepare('INSERT INTO module.notes (title, context, user_id) VALUES (:title, :context, :user_id) ');
    $stmt->execute([
        'title' => $title,
        'context' => $context,
        'user_id' => $user_id,
    ]);

    $note = $stmt->fetch(PDO::FETCH_ASSOC);
    return $note;

}

function getUserNotes($id) : bool | array
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $stmt = $pdo->prepare("SELECT * FROM module.notes WHERE user_id = $id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createComment($content, $user_id, $note_id) : array | bool
{
    $date = getdate();
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $stmt = $pdo->prepare("INSERT INTO module.comments (note_id, user_id,  content, created_at) 
    VALUES (:note_id,:user_id,:content,:created_at)");
    $stmt->execute([
        'content' => $content,
        'note_id' => $note_id,
        'user_id' => $user_id,
        'created_at' => $date['year'].'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].':'.$date['minutes'].':'.$date['seconds']
        ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUsersNotesComments($note_id,$user_id) : array
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $stmt = $pdo->prepare("SELECT * FROM module.comments WHERE note_id = $note_id AND user_id = $user_id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function redirectToProfile()
{
    header("Location: http://marl/Module/Верстка%20проекта/page_profile.php");
    exit();
}

function displayNestedComments($parentId, $comments) : void
{
    if (!isset($comments[$parentId])) {
        return;
    }
    echo '123';
    echo '<ul>';

    foreach ($comments as $comment) {
        if ($comment['parent_id'] == 0) {
            echo '<div>';
            echo '<p>' . $comment['content'] . '</p>';

            // Рекурсивный вызов для вывода вложенных комментариев
            displayNestedComments($comment['id'], $comments);

            echo '</div>';
        }
    }
}