<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require "includes/database.php";
require "config/config.php";
require ("includes/helper.php");
require_once "script/fixtures.php";


if(isset($_GET['deconnect'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
$_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
)  {
    if(!empty($_SESSION['auth'])) {
        if(isset($_GET["component"])){
            $componentName = cleanString($_GET["component"]);
            if(file_exists("controller/$componentName.php")){
                require "controller/$componentName.php";
                exit();
            }
        } else {
            require "controller/quizzs.php";
            exit();
        }
    } else {
        if(isset($_GET["component"])){
            $componentName = cleanString($_GET["component"]);
            if(file_exists("controller/$componentName.php")){
                require "controller/$componentName.php";
                exit();
            }
        } else {
            require 'controller/allQuizzParty.php';
            exit();
        }
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mon App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="container-fluid pt-1">
    <?php
    if (empty($_SESSION['auth'])) {

        if(isset($_GET["component"])) {
            $componentName = cleanString($_GET["component"]);
            if (file_exists("controller/$componentName.php")) {
                require "controller/$componentName.php";
            }
        } else {
            require "controller/allQuizzParty.php";
        }
    }

    if(!empty($_SESSION['auth']) && $_SESSION['auth'] === true) {
        require "_partials/_navbar.php";
        if(isset($_GET["component"])) {
            $componentName = cleanString($_GET["component"]);
            if (file_exists("controller/$componentName.php")) {
                require "controller/$componentName.php";
            } else {
                throw new Exception("Component '$componentName' does not exist");
            }
        } else {
            require "controller/quizzs.php";
        }
    }
    ?>
</div>
<?php require "_partials/_toast.html"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>