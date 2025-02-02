<?php

require 'model/quizzParty.php';

if (!empty($_GET['id'])) {
    $quizzData = getQuizz($pdo, $_GET['id']);
    if(!is_array($quizzData)) {
        $errors = $quizzData;
    }
}


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
) {

    $response = [
        'quiz' => $quizzData['quiz'],
        'questions' => $quizzData['questions']
    ];
    echo json_encode($response);
    exit();
}


require 'view/quizzParty.php';