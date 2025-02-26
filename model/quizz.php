<?php

function getQuizz (PDO $pdo, int $idQuizz) {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT 
    q.id AS question_id, 
    q.label AS question_label, 
    q.num_question, 
    q.type AS question_type, 
    a.id AS answer_id, 
    a.text AS answer_text, 
    a.correct AS is_correct, 
    a.point AS points, 
    z.title AS quiz_title, 
    z.published AS quiz_published
FROM questions AS q
LEFT JOIN answers AS a ON a.question = q.id
LEFT JOIN quizz AS z ON z.id = q.quizz
WHERE q.quizz = :quizz_id
ORDER BY q.num_question, a.id";

    $prep = $pdo->prepare($query);
    $prep->bindValue(':quizz_id', $idQuizz, PDO::PARAM_INT);
    $prep->execute();
    $results = $prep->fetchAll(PDO::FETCH_ASSOC);

    $finalData = [];

    if (!empty($results)) {
        $finalData['quiz'] = [
            'quiz_title' => $results[0]['quiz_title'],
            'quiz_published' => $results[0]['quiz_published']
        ];
    }

    $questions = [];
    foreach ($results as $row) {
        $questionId = $row['question_id'];

        if (!isset($questions[$questionId])) {
            $questions[$questionId] = [
                'question_id' => $row['question_id'],
                'question_label' => $row['question_label'],
                'num_question' => $row['num_question'],
                'question_type' => $row['question_type'],
                'answers' => []
            ];
        }

        $questions[$questionId]['answers'][] = [
            'answer_id' => $row['answer_id'],
            'answer_text' => $row['answer_text'],
            'is_correct' => $row['is_correct'],
            'points' => $row['points']
        ];
    }

    $finalData['questions'] = array_values($questions);

    return $finalData;
}
function getUser(PDO $pdo, int $id): array | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="SELECT * FROM users WHERE id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    $res = $prep->fetch();
    $prep->closeCursor();

    return $res;
}
function updateQuestion(PDO $pdo, int $id, int $questionNum, string $questiontext, int $type): bool | string {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="UPDATE questions SET num_question = :num_question, label = :label, type = :type WHERE quizz = :quizz";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':num_question', $questionNum, PDO::PARAM_INT);
    $prep->bindValue(':label', $questiontext, PDO::PARAM_STR);
    $prep->bindValue(':type', $type, PDO::PARAM_INT);
    $prep->bindValue(':quizz', $id, PDO::PARAM_INT);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }
    $prep->closeCursor();

    return true;
}

function insertUser(
    PDO $pdo,
    string $username,
    string $pass,
    string $email,
    bool $enabled
): bool | string
{

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="INSERT INTO users (username, password, email, enabled) VALUES (:username, :password, :email, :enabled)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':password', $pass);
    $prep->bindValue(':username', $username);
    $prep->bindValue(':email', $email);
    $prep->bindValue(':enabled', $enabled, PDO::PARAM_BOOL);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }
    $prep->closeCursor();

    return true;
}


function insertAnswer(PDO $pdo, int $questionId, int $questionNum, string $responseText, int $isCorrect, int $points): bool|string
{
    $query = "INSERT INTO answers (question, question_num, text, correct, point) 
              VALUES (:question, :question_num, :text, :correct, :point)";
    $prep = $pdo->prepare($query);

    $prep->bindValue(':question', $questionId, PDO::PARAM_INT);
    $prep->bindValue(':question_num', $questionNum, PDO::PARAM_INT);
    $prep->bindValue(':text', $responseText, PDO::PARAM_STR);
    $prep->bindValue(':correct', $isCorrect, PDO::PARAM_INT);
    $prep->bindValue(':point', $points, PDO::PARAM_INT);

    try {
        $prep->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " - " . $e->getMessage();
    }

    $prep->closeCursor();

    return true;
}

function updateAnswer(PDO $pdo, int $questionId, int $questionNum, string $responseText, int $isCorrect, int $points): bool|string {
    $query = "UPDATE answers SET question = :question, question_num = :question_num, text = :text, correct = :correct, point = :point WHERE question = :question AND question_num = :question_num";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':question', $questionId, PDO::PARAM_INT);
    $prep->bindValue(':question_num', $questionNum, PDO::PARAM_INT);
    $prep->bindValue(':text', $responseText, PDO::PARAM_STR);
    $prep->bindValue(':correct', $isCorrect, PDO::PARAM_INT);
    $prep->bindValue(':point', $points, PDO::PARAM_INT);

    try {
        $prep->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " - " . $e->getMessage();
    }

    $prep->closeCursor();

    return true;
}

function insertQuestion(
    PDO $pdo,
    int $quizzId,
    int $questionNum,
    string $label,
    int $type
): bool | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO questions (quizz, num_question, label, type) 
              VALUES (:quizz, :num_question, :label, :type)";

    $prep = $pdo->prepare($query);

    $prep->bindValue(':quizz', $quizzId, PDO::PARAM_INT);
    $prep->bindValue(':num_question', $questionNum, PDO::PARAM_INT);
    $prep->bindValue(':label', $label, PDO::PARAM_STR);
    $prep->bindValue(':type', $type, PDO::PARAM_INT);

    try {
        $prep->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " - " . $e->getMessage();
    }

    $prep->closeCursor();

    return true;
}

function insertQuizz(
    PDO $pdo,
    string $title,
    bool $published
): bool | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO quizz (title, published) 
              VALUES (:title, :published)";

    $prep = $pdo->prepare($query);

    $prep->bindValue(':title', $title, PDO::PARAM_STR);
    $prep->bindValue(':published', $published, PDO::PARAM_BOOL);

    try {
        $prep->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " - " . $e->getMessage();
    }

    $prep->closeCursor();

    return true;
}
function updateQuizz(
    PDO $pdo, int $quizzId,
    string $title,
    bool $published
): bool | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "UPDATE quizz SET title = :title, published = :published WHERE id = :id";


    $prep = $pdo->prepare($query);

    $prep->bindValue(':title', $title, PDO::PARAM_STR);
    $prep->bindValue(':published', $published, PDO::PARAM_BOOL);
    $prep->bindValue(':id', $quizzId, PDO::PARAM_INT);


    try {
        $prep->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " - " . $e->getMessage();
    }

    $prep->closeCursor();

    return true;
}

function updateUser(
    PDO $pdo,
    int $id,
    string $username,
    string $email,
    bool $enabled,
    ?string $pass = null,
): bool | string
{

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "UPDATE users SET username = :username, email = :email, enabled = :enabled WHERE id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->bindValue(':username', $username);
    $prep->bindValue(':email', $email);
    $prep->bindValue(':enabled', $enabled, PDO::PARAM_BOOL);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }
    $prep->closeCursor();

    if (null !== $pass) {
        $query="UPDATE users SET password = :password WHERE id = :id";
        $prep = $pdo->prepare($query);
        $prep->bindValue(':id', $id, PDO::PARAM_INT);
        $prep->bindValue(':password', $pass);
        try
        {
            $prep->execute();
        }
        catch (PDOException $e)
        {
            return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
        }
        $prep->closeCursor();
    }

    return true;
}

function toggleEnabled(PDO $pdo, int $id): void {
    $res = $pdo->prepare('UPDATE `quizz` SET `published` = NOT published WHERE `id` = :id');
    $res->bindParam(':id', $id, PDO::PARAM_INT);
    $res->execute();
}


