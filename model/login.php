<?php
function getUser(PDO $pdo, string $username): array | bool
{
    /**
     * @var PDO $pdo
     */
    $query = 'SELECT * FROM users WHERE username = :username';
    $res = $pdo->prepare($query);
    $res->bindParam(':username', $username);
    $res->execute();
    return $res->fetch();
}


function connect(PDO $pdo, string $username, string $pass) {
    $user = getUser($pdo, $username);
    if ($user && password_verify($pass, $user['password'])) {
        return $user;
    }
    return false;
}