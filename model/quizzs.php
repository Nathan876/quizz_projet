<?php
function toggleEnabled(PDO $pdo, int $id): string | bool
{
    $res = $pdo->prepare('UPDATE `quizz` SET published = NOT published WHERE id = :id');
    $res->bindParam(':id', $id, PDO::PARAM_INT);

    try
    {
        $res->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    return true;
}

function getQuizzs(PDO $pdo, int $itemPerPage, int $page = 1): array | string
{
    $offset = (($page - 1) * $itemPerPage);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="SELECT * FROM quizz 
          LIMIT $itemPerPage OFFSET $offset";
    $prep = $pdo->prepare($query);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    $persons = $prep->fetchAll(PDO::FETCH_ASSOC);
    $prep->closeCursor();

    $query="SELECT COUNT(*) AS total FROM quizz";
    $prep = $pdo->prepare($query);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    $count = $prep->fetch(PDO::FETCH_ASSOC);
    $prep->closeCursor();

    return [$persons, $count];
}
