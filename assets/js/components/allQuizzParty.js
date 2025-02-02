import {getQuizzs} from "../services/allQuizzParty.js";

export const quizzCard = async () => {
    console.log("test")
    const listElement = document.querySelector('#list-quizzs')
    const data = await getQuizzs()
    console.log(data)

    const listContent = []

    for (let i = 0; i < data.result.length; i++) {
        listContent.push(`<tr>
                            <th scope="row">${data.result[i].id}</th>
                                    <td>${data.result[i].id}</td>
                                    <td>${data.result[i].title}</td>
                                    <td>
                                        <a href="#">
                                            ${data.result[i].published === 1 ? `<i class="fa-solid fa-check text-success enabled-icon" data-id="${data.result[i].id}"></i>` : `<i class="fa-solid fa-xmark enabled-icon"data-id="${data.result[i].id}"></i>`}
                                        </a>
                                        <div class="spinner-border spinner-border-sm d-none" role="status" id="enabled-spinner">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <a href="#"><i class="fa-solid fa-gamepad" data-id="${data.result[i].id}"></i></a>
                                    </td>
                                    <td>
                                        <a href="index.php?component=quizz&action=edit&id=${data.result[i].id}">
                                            <i class="fa fa-edit text-success"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </a>
                                    </td>
                            <td> <a href="index.php?component=quizz&id=${data.result[i].id}">
                            <i class="fa fa-edit text-success"></i>
                        </a></td>
                        </tr>`)
    }

    listElement.querySelector('tbody').innerHTML = listContent.join('')

}

export const refreshList = async (page) => {
    const spinner = document.querySelector('#spinner')

    spinner.classList.remove('d-none')
    const data = await getQuizzs(page)
    const listContent = []

    for (let i = 0; i < data.results.length; i++) {
        listContent.push(`<tr>
                            <th scope="row">${data.results[i].id}</th>
                                    <td>${data.results[i].id}</td>
                                    <td>${data.results[i].title}</td>
                                    <td>
                                        <a href="#">
                                            ${data.results[i].published === 1 ? '<i class="fa-solid fa-check text-success enabled-icon" data-id="data.results[i].id"></i>' : '<i class="fa-solid fa-xmark enabled-icon"data-id="data.results[i].id"></i>'}
                                        </a>
                                        <div class="spinner-border spinner-border-sm d-none" role="status" id="enabled-spinner">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <a href="#"><i class="fa-solid fa-gamepad" data-id="${data.results[i].id}"></i></a>
                                    </td>
                                    <td>
                                        <a href="index.php?component=quizz&action=edit&id=${data.results[i].id}">
                                            <i class="fa fa-edit text-success"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </a>
                                    </td>
                            <td> <a href="index.php?component=quizz&id=${data.results[i].id}">
                            <i class="fa fa-edit text-success"></i>
                        </a></td>
                        </tr>`)
    }

    document.querySelector('#pagination').innerHTML = getPagination(data.count.total)

    handlePaginationNavigation(page)

    spinner.classList.add('d-none')
}
