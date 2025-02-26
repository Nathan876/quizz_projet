<?php
/**
 * @var array $quizzs
 */
//$quizzs = $quizzs ?? [];
?>
<div class="row">
    <div class="col">
        <div class="h1 pt-2 pb-2 text-center">Liste des quizz</div>
        <div class="row">
            <div class="mb-3 d-flex justify-content-end">
                <a href="index.php?component=quizz" type="button" class="btn btn-primary" ><i class="fa fa-plus me-2"></i>Ajouter</a>
            </div>
        </div>
        <table class="table" id="list-quizzs">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Identifiant</th>
                <th scope="col">Actif</th>
                <th scope="col">Édition</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center" id="pagination">

        </ul>
    </nav>
</div>
<script src="./assets/js/services/quizzs.js" type="module"></script>
<script src="./assets/js/components/quizzs.js" type="module"></script>
<script type="module">
    import {refreshList} from "./assets/js/components/quizzs.js";
    import {handleEnableList} from "./assets/js/components/quizzs.js";

    document.addEventListener('DOMContentLoaded', async () => {

        let currentPage = 1

        await refreshList(currentPage)
        handleEnableList()
        const previousLink = document.querySelector('#previous-link')
        const nextLink = document.querySelector('#next-link')

        previousLink.addEventListener('click', async () => {
            if (currentPage > 1) {
                currentPage--
                await refreshList(currentPage)
            }
        })

        nextLink.addEventListener('click', async () => {
            currentPage++
            await refreshList(currentPage)
        })
    })
</script>
