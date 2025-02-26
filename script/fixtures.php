<?php
/**
 * @var PDO $pdo
 */
require './includes/database.php';
require './vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    for ($i = 0; $i < 10; $i++) {
        $query = "INSERT INTO quizz (title, published) VALUES (:title, :published)";
        $prep = $pdo->prepare($query);
        $prep->execute([
            ':title' => $faker->sentence(3),
            ':published' => (int)$faker->boolean(80)
        ]);
        $quiz_id = $pdo->lastInsertId();

        for ($j = 0; $j < rand(5, 10); $j++) {
            $query = "INSERT INTO questions (quizz, num_question, label, type) VALUES (:quizz, :num_question, :label, :type)";
            $prep = $pdo->prepare($query);
            $prep->execute([
                ':quizz' => $quiz_id,
                ':num_question' => $j+1,
                ':label' => $faker->sentence(10),
                ':type' => rand(1, 2)
            ]);
            $question_id = $pdo->lastInsertId();

            for ($k = 0; $k < rand(2, 4); $k++) {
                $is_correct = ($k === 0) ? 1 : (int) $faker->boolean(30);
                $query = "INSERT INTO answers (question, question_num, text, correct, point) VALUES (:question, :question_num, :text, :correct, :point)";
                $prep = $pdo->prepare($query);
                $prep->execute([
                    ':question' => $question_id,
                    ':question_num' => $j+1,
                    ':text' => $faker->sentence(5),
                    ':correct' => $is_correct,
                    ':point' => $is_correct ? rand(1, 5) : 0
                ]);
            }
        }
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}