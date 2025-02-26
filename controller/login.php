<?php
///**
// * @var PDO $pdo
// */
//require "model/login.php";
//
//if (!empty($_SERVER['CONTENT_TYPE']) &&
//    (
//        $_SERVER['CONTENT_TYPE'] === 'application/json' ||
//        str_starts_with($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded')
//    )
//) {
//    $username = !empty($_POST["username"]) ? $_POST["username"] : null;
//    $pass = !empty($_POST["pass"]) ? $_POST["pass"] : null;
//
//    if (!empty($username) && !empty($pass)) {
//        $username = cleanString($username);
//        $pass = cleanString($pass);
//        $user = getUser($pdo, $username);
//
//        //Version longue
////            if (is_array($pdo, $username)) {
////                $isMatchPassword = password_verify($pass, $user['password']);
////            }
//        //Version courte
//        $isMatchPassword = is_array($user) && password_verify($pass, $user['password']);
//
//        // && $user['enabled']
//        if (!empty($username) && !empty($pass)) {
//            $username = cleanString($username);
//            $pass = cleanString($pass);
//            $user = getUser($pdo, $username);
//            //Version longue
////            if (is_array($pdo, $username)) {
////                $isMatchPassword = password_verify($pass, $user['password']);
////            }
//            //Version courte
//            $isMatchPassword = is_array($user) && password_verify($pass, $user['password']);
//
//            if ($isMatchPassword) {
//                $_SESSION['auth'] = true;
//                $_SESSION['user_id'] = $user['id'];
//                $_SESSION['user_username'] = $user['username'];
//                header("Content-type: application/json");
//                echo json_encode(['authentication' => true]);
//
//                //header("Location: index.php");
//                exit();
//            }  else {
//                $errors[] = "L'identification a échouée";
//            }
//
//            if (!empty($errors)) {
//                header("Content-type: application/json");
//                echo json_encode(['errors' => $errors]);
//                exit();
//            }
//        }
//    }
//}
//
//
//require "view/login.php";

require("model/login.php");

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
) {
    $errors = [];
    $username = $_POST['username'] ?? null;
    $pass = $_POST['password'] ?? null;

    if (empty($username) || empty($pass)) {
        $errors[] = "Identifiant ou mot de passe vide";
    } else {
        $user = getUser($pdo, $username);

        if (!$user || !password_verify($pass, $user['password'])) {
            $errors[] = "Erreur d'identification, veuillez essayer à nouveau";
        } else {
            $_SESSION["auth"] = true;
            $_SESSION["username"] = $user['username'];

            header("Content-Type: application/json");
            echo json_encode(['authentication' => true]);
            exit();
        }
    }

    if (!empty($errors)) {
        header("Content-Type: application/json");
        echo json_encode(['errors' => $errors]);
        exit();
    }
}

require("view/login.php");