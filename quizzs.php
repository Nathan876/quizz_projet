<?php
/**
 * @var PDO $pdo
 * @var string $actionName
 */
require "model/quizzs.php";
//$quizzs = getUsers($pdo, 1, 15);
//if(!is_array($quizzs)) {
//    $errors[] = $quizzs;
//}
if (isset($_POST['create_button'])) {

    echo "Formulaire soumis";

    $username = cleanString($_POST['username']);
    $newQuizz = insertQuizz($pdo, $username);
}
if (isset($_POST['create_button'])) {
    echo "Formulaire créé";
}

if (!empty($_GET['id'])) {
    $actionName = 'togglePublished';
}

const LIST_PERSONS_ITEMS_PER_PAGE = 20;
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
){
    $page = isset($_GET['page']) ? cleanString($_GET['page']) : 1;
    [$persons, $count] = getQuizzs($pdo, LIST_PERSONS_ITEMS_PER_PAGE, $page);

    if (!is_array($persons)) {
        $errors[] = $persons;
    }
    header('Content-Type: application/json');
    echo json_encode(['results' => $persons, 'count' => $count]);
    exit();
}


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
){
    switch ($actionName) {
        case 'togglePublished':
            $id = cleanString($_GET['id']);
            $res = toggleEnabled($pdo, $id);
            header('Content-Type: application/json');
            if (is_bool($res)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => $res]);
            }
            exit();
            break;
    }
}
require "view/quizzs.php";