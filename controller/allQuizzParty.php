<?php
/**
 * @var PDO $pdo
*/
require 'model/allQuizzParty.php';

$data = getQuizzs($pdo);

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
){
    header('Content-Type: application/json');
    echo json_encode(['result' => $data]);
    exit();
}
require 'view/allQuizzParty.php';
