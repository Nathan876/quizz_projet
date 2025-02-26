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