<?php
/**
 * @var PDO $pdo
 */
require "model/quizz.php";

$action = 'create';
$errors = [];
if (!empty($_GET['id'])) {
    $action = 'edit';
    $quizzData = getQuizz($pdo, $_GET['id']);
    if(!is_array($quizzData)) {
        $errors = $quizzData;
    }
}
if ($action == 'create') {
    if (isset($_POST['create_button'])) {
        $title = !empty($_POST['title']) ? cleanString($_POST['title']) : null;
        $published = !empty($_POST['published']) ? (int)$_POST['published'] : 0;
        if (empty($title)) {
            $errors[] = "Le titre du quizz est requis.";
        }

        if (empty($errors)) {
            $newQuizz = insertQuizz($pdo, $title, $published);
            if ($newQuizz === true) {
                $quizzId = $pdo->lastInsertId();
                $questions = !empty($_POST['questions']) ? $_POST['questions'] : [];
                $questionNum = 0;
                foreach ($questions as $question) {
                    $questionText = !empty($question['text']) ? cleanString($question['text']) : null;
                    $type = isset($question['type']) ? (int)$question['type'] : null; // Utilisation de isset pour éviter null
                    $questionNum++;
                    if (empty($questionText)) {
                        $errors[] = "Le texte de la question est requis.";
                        continue;
                    }

                    if ($type === null) {
                        $errors[] = "Le type de la question est requis.";
                        continue;
                    }
                    if (empty($questionText)) {
                        $errors[] = "Le texte du quizz est requis.";
                    }

                    $newQuestion = insertQuestion($pdo, $quizzId, $questionNum, $questionText, $type);
                    $numAnswer = 0;
                    if ($newQuestion === true) {
                        $questionId = $pdo->lastInsertId();
                        $anwsers = $question['anwsers'];
                        foreach ($anwsers as $anwser) {
                            $numAnswer++;
                            $anwsersText = !empty($anwser['text']) ? cleanString($anwser['text']) : null;
                            $points = !empty($anwser['points']) ? (int)$anwser['points'] : 0;
                            if ($points > 0) {
                                $correct = 1;
                            } else {
                                $correct = 0;
                            }

                            if (empty($anwsersText)) {
                                $errors[] = "Le texte de la réponse est requis.";
                            }
                            $newAnwser = insertAnswer($pdo, $questionId, $numAnswer, $anwsersText, $correct, $points);

                            if ($newAnwser !== true) {
                                $errors[] = $newAnwser;
                            }
                        }
                    } else {
                        $errors[] = $newQuestion;
                    }
                }
            }
            if (empty($errors)) {
                echo "Le quizz a été ajouté avec succès";
            } else {
                $errors = $newQuizz;
            }
        }
    }
} else if ($action == 'edit') {
    if (isset($_POST['edit_button'])) {
        $title = !empty($_POST['title']) ? cleanString($_POST['title']) : null;
        $published = !empty($_POST['published']) ? (int)$_POST['published'] : 0;
        if (empty($title)) {
            $errors[] = "Le titre du quizz est requis.";
        }
        if (empty($errors)) {
            $quizzId = $_GET['id'];
            $newQuizz = updateQuizz($pdo, $quizzId, $title, $published);
            if ($newQuizz === true) {

                //$questions = $_POST['questions'];
                $questions = !empty($_POST['questions']) ? $_POST['questions'] : [];
                $questionNum = 0;
                foreach ($questions as $question) {
                    $questionText = !empty($question['text']) ? cleanString($question['text']) : null;
                    $type = isset($question['type']) ? (int)$question['type'] : null;
                    $questionNum++;
                    if (empty($questionText)) {
                        $errors[] = "Le texte de la question est requis.";
                        continue;
                    }

                    if ($type === null) {
                        $errors[] = "Le type de la question est requis.";
                        continue;
                    }

                    $newQuestion = updateQuestion($pdo, $quizzId, $questionNum, $questionText, $type);
                    $numAnswer = 0;
                    if ($newQuestion === true) {
                        $questionId = $pdo->lastInsertId();
                        $anwsers = $question['anwsers'];
                        foreach ($anwsers as $anwser) {
                            $numAnswer++;
                            $anwsersText = !empty($anwser['text']) ? cleanString($anwser['text']) : null;
                            //$correct = !empty($anwser['correct']) ? (int)$anwser['correct'] : 0;
                            $points = !empty($anwser['points']) ? (int)$anwser['points'] : 0;
                            if ($points > 0) {
                                $correct = 1;
                            } else {
                                $correct = 0;
                            }

                            if (empty($anwsersText)) {
                                $errors[] = "Le texte de la réponse est requis.";
                            }
                            $newAnwser = updateAnswer($pdo, $questionId, $numAnswer, $anwsersText, $correct, $points);

                            if ($newAnwser !== true) {
                                $errors[] = $newAnwser;
                            }
                        }
                    } else {
                        $errors[] = $newQuestion;
                    }

                }
            }
            if (empty($errors)) {
                echo "Le quizz a été modifié avec succès";
            } else {
                $errors = $newQuizz;
            }
        }
    }
}


if (!empty($errors) && is_array($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}

require "view/quizz.php";
