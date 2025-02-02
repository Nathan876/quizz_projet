
<div class="container">
    <div class="mt-2 d-flex justify-content-between">
        <div>
            <a class="btn btn-primary hidden" id="home-btn" href="index.php">Accueil</a>
        </div>
        <div>
            <a class="btn btn-primary hidden" id="try-again-btn" href="#" onclick="window.location.reload(); return false;">Recommencer</a>
        </div>
    </div>
    <div class="row mt-2">
        <div>
            <h1><?php echo $quizzData['quiz']['quiz_title']?></h1>
        </div>
        <div class="col">
            <div id="progress" class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 0%">0%</div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php foreach ($quizzData['questions'] as $question): ?>
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link disabled <?php echo $question['num_question'] === 1 ? 'active' : ''?>"
                        id="question-<?php echo $question['num_question']?>-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#question-<?php echo $question['num_question']?>-content"
                        type="button"
                        role="tab"
                        aria-controls="question-<?php echo $question['num_question']?>-content"
                        aria-selected="<?php echo $question['num_question']===1 ? 'true' : 'false'?> aria-disabled="true"
                >
                    Question <?php echo $question['num_question']?>
                </button>
            </li>
            <?php endforeach ?>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link disabled"
                    id="results-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#results-content"
                    type="button" role="tab"
                    aria-controls="results-content"
                    aria-selected="false"
                >
                    Résultats
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <?php foreach ($quizzData['questions'] as $question): ?>
            <div
                class="tab-pane fade <?php echo $question['num_question'] === 1 ? 'show active' : '' ?>"
                id="question-<?php echo $question['num_question']?>-content"
                role="tabpanel"
                aria-labelledby="question-<?php echo $question['num_question']?>-tab"
                tabindex="0"
            >
                <form id="form-question-<?php echo $question['num_question']?>">
                    <div class="mb-3">
                        <label><?php echo $question['question_label']?></label>
                        <?php $answer_num = 0;?>
                        <?php foreach ($question['answers'] as $answer): ?>
                        <?php $answer_num++?>
                        <div class="form-check">
                            <input class="form-check-input" type="<?php echo $question['question_type'] === 1 ? 'radio' : 'checkbox'; ?>" name="question-<?php echo $question['num_question'];?>" id="question-<?php echo $question['num_question'];?>-<?php echo $answer_num?>" value="<?php echo $answer_num;?>">
                            <label class="form-check-label" for="question-1-client">
                                <?php echo $answer['answer_text']?>
                            </label>
                        </div>
                        <?php endforeach;?>
                    </div>
                </form>
            </div>
            <?php endforeach ?>
            <div
                class="tab-pane fade"
                id="results-content"
                role="tabpanel"
                aria-labelledby="question-response-tab"
                tabindex="0"
            >
                <div style="width: 50%; margin: auto; text-align: center;">
                    <canvas id="my-chart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 d-flex justify-content-between">
        <div>
            <button class="btn btn-primary" type="button" id="previous-btn">Précédente</button>
        </div>
        <div>
            <button class="btn btn-primary" type="button" id="next-btn">Suivante</button>
        </div>
    </div>
</div>
<script src="./assets/js/services/quizzParty.js" type="module"></script>
<script src="./assets/js/components/quizzParty.js" type="module"></script>
