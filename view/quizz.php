<?php
/**
 * @var string $action
 */
$numQuestion = 0;
$displayNumQuestion = $numQuestion + 1
?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="h1 pt-2 pb-2 text-center">Créer / Modifier un quizz</div>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $quizzData['quiz']['quiz_title'] ?? ''?>"required>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" name="add_button" id="addBtn">Ajouter une question</button>
                </div>
                <div id="questions">
                    <?php if(!empty($quizzData['questions'])) : ?>
                        <?php $questionIndex = 0 ?>
                        <?php foreach($quizzData['questions'] as $question) : ?>
                            <div id="question-<?php echo $question[$questionIndex] ?>">
                                <div class="mb-3">
                                    <div class="h3 pt-2 pb-2 text-center">Question <?php echo $question['num_question'] ?></div>
                                    <div class="mb-3">
                                        <label for="question" class="form-label">Question <?php echo $displayNumQuestion ?></label>
                                        <input type="text" class="form-control" id="questions[<?php echo $numQuestion ?>][text]" name="questions[<?php echo $numQuestion ?>][text]" value="<?php echo $quizzData['questions'][$questionIndex]['question_label'] ?? '';?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="questions[<?php echo $questionIndex ?>][type]" id="questions[<?php echo $questionIndex ?>][type]" value="1" <?php echo $quizzData['questions'][$questionIndex]['question_type'] == 1 ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="questions[<?php echo $questionIndex ?>][type]">
                                                Réponse unique
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="questions[<?php echo $questionIndex ?>][type]" id="questions[<?php echo $questionIndex ?>][type]" value="2" <?php echo $quizzData['questions'][$questionIndex]['question_type'] == 2 ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="questions[<?php echo $questionIndex ?>][type]">
                                                Réponses multiples
                                            </label>
                                        </div>
                                    </div>


                                    <div id="responses<?php echo $questionIndex ?>">
                                        <?php if(!empty($question['answers'])) : ?>
                                            <?php $anwserIndex = 0 ?>
                                            <?php foreach($question['answers'] as $anwser) : ?>
                                                <div class="mb-3">
                                                    <label for="response<?php echo $questionIndex ?><?php echo $anwserIndex+1 ?>" class="form-label">Réponse <?php echo $anwserIndex+1?></label>
                                                    <input type="text" class="form-control answer" id="response${questionId}${responseNumber}" name="questions[<?php echo $questionIndex ?>][anwsers][<?php echo $anwserIndex ?>][text]" value="<?php echo $anwser['answer_text']?>"required>
                                                    <label>Points :</label>
                                                    <input type="number" class="form-control" name="questions[<?php echo $questionIndex ?>"][answers][<?php echo $anwserIndex?>][points]" value="<?php echo $anwser['points']?>" required>
                                                </div>
                                                <?php $anwserIndex++; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3 d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" id="add-response<?php echo $questionIndex ?>" data-question="<?php echo $questionIndex ?>">Ajouter une réponse</button>
                                    </div>
                                </div>
                            </div>
                            <?php $questionIndex++ ?>
                        <?php endForeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="published" <?php echo !empty($quizzData['quiz']['quiz_published']) && $quizzData['quiz']['quiz_published'] !== 0 ? 'checked' : '' ?>>
                    <label class="form-check-label" for="published"">
                        Publier
                    </label>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="<?php echo !(empty($_GET['id'])) ? 'edit_button' : 'create_button'?>">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

    let responseCount = []
    let questionsCount = 0

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('#addBtn').addEventListener('click', addQuestions)
    })

    const addQuestions = ()=> {

        responseCount[questionsCount] = 1
        const newQuestion = document.createElement('div')
        newQuestion.classList.add('mb-3')
        newQuestion.innerHTML = `
                <div id="question-${questionsCount}">
                    <div class="h3 pt-2 pb-2 text-center">Question ${questionsCount + 1}</div>
                    <div class="mb-3">
                        <label for="question${questionsCount}" class="form-label">Question ${questionsCount + 1}</label>
                        <input type="text" class="form-control" id="questions[${questionsCount}][text]" name="questions[${questionsCount}][text]" required>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionsCount}][type]" id="questions[${questionsCount}][type]" value="1">
                            <label class="form-check-label" for="questions[${questionsCount}][type]">
                                Réponse unique
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionsCount}][type]" id="questions[${questionsCount}][type]" value="2" checked>
                            <label class="form-check-label" for="flexRadioDefault2${questionsCount}">
                                Réponses multiples
                            </label>
                        </div>
                    </div>

                    <div id="responses${questionsCount}">
                        <div class="mb-3">
                            <label for="response${questionsCount}${responseCount[questionsCount]}" class="form-label">Réponse ${responseCount[questionsCount]}</label>
                            <input type="text" class="form-control answer" id="questions[${questionsCount}][anwsers][0][text]" name="questions[${questionsCount}][anwsers][0][text]" required>
                            <label>Points :</label>
                            <input type="number" class="form-control" name="questions[${questionsCount}][anwsers][0][points]" value="0" required>
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" id="add-response${questionsCount}" data-question="${questionsCount}">Ajouter une réponse</button>
                        </div>
                    <div class="h3 pt-2 pb-2 text">Bonne réponse</div>
                    <div id="goodanwsers${questionsCount}">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox${questionsCount}1" value="option${questionsCount}1">
                            <label class="form-check-label" for="inlineCheckbox${questionsCount}1">1</label>
                        </div>
                    </div>
                </div>`

        document.querySelector('#questions').appendChild(newQuestion)
        document.querySelector(`#add-response${questionsCount}`).addEventListener('click', (e) => addResponse(e))
        questionsCount++
    }

    const addResponse = (e)=> {
        const questionId = e.target.getAttribute('data-question')
        if (!responseCount[questionId]) {
            responseCount[questionId] = 0;
        } else {
            responseCount[questionId] ++;
        }
        const responseNb = document.querySelector(`#question-${questionId}`).querySelectorAll('.answer').length

        const responseContainer = document.querySelector(`#responses${questionId}`)
        const displayReponseNumber = responseNb + 1
        const responseNumber = responseNb

        const newResponse = document.createElement('div')
        newResponse.classList.add('mb-3')
        newResponse.innerHTML = `
            <label for="response${questionId}${responseNumber}" class="form-label">Réponse ${displayReponseNumber}</label>
            <input type="text" class="form-control answer" id="questions[${questionId}][anwsers][${responseNumber}][text]" name="questions[${questionId}][anwsers][${responseNumber}][text]" required>
            <label>Points :</label>
            <input type="number" class="form-control" name="questions[${questionId}][anwsers][${responseNumber}][points]" value="0" required>
        `;
        responseContainer.appendChild(newResponse)

        const goodAnswersContainer = document.querySelector(`#goodanwsers${questionId}`);
        const newGoodAnswer = document.createElement('div');
        newGoodAnswer.classList.add('form-check', 'form-check-inline');
        newGoodAnswer.innerHTML = `
        <input class="form-check-input" type="checkbox" id="questions[${questionId}][anwsers][${responseNumber}][correct]" name="questions[${questionId}][anwsers][${responseNumber}][correct]" value="questions[${questionId}][anwsers][${responseNumber}][correct]">
        <label class="form-check-label" for="questions[${questionId}][anwsers][${responseNumber}][correct]">${responseNumber}</label>
        `;

        goodAnswersContainer.appendChild(newGoodAnswer);
    }

    const addFunctReponseBtn = (questionId)=> {
        const addResponseBtn = document.querySelector('#addBtn')
        addResponseBtn.addEventListener('click', addResponse(questionId))
    }

</script>

