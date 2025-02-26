<?php
/**
 * @var array $data
 */
?>
<div class="row">
    <div class="col">
        <div class="h1 pt-2 pb-2 text-center">Liste des quizz</div>
        <div class="d-flex flex-wrap justify-content-around">
            <table class="table" id="list-quizzs">
                <thead>
                </thead>
                <tbody>
                <?php foreach ($data as $quiz) { ?>
                    <div class="card mb-5" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $quiz['title']?></h5>
                            <a href="?component=quizzParty&id=<?php echo urlencode($quiz['id']); ?>" class="btn btn-primary">Jouer</a>
                        </div>
                    </div>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center" id="pagination">

        </ul>
    </nav>
</div>
<script src="./assets/js/components/allQuizzParty.js" type="module"></script>
