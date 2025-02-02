
import {createPerson, getQuizzs, updatePerson, togglePublishedQuizz} from "../services/quizzs.js"
import {showToast} from "./shared/toast.js"


export const refreshList = async (page) => {
    const spinner = document.querySelector('#spinner')
    const listElement = document.querySelector('#list-quizzs')

    spinner.classList.remove('d-none')

    const data = await getQuizzs(page)

    const listContent = []

    for (let i = 0; i < data.results.length; i++) {
        listContent.push(`
        <tr>
            <th scope="row">${data.results[i].id}</th>
            <td>${data.results[i].title}</td>
            <td>
                <a href="#">
                    ${
            data.results[i].published === 1
                ? `<i class="fa-solid fa-check text-success enabled-icon" data-id="${data.results[i].id}"></i>`
                : `<i class="fa-solid fa-xmark enabled-icon" data-id="${data.results[i].id}"></i>`
        }
                </a>
                <div class="spinner-border spinner-border-sm d-none" role="status" id="enabled-spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
            <td>
                <a href="index.php?component=quizz&action=edit&id=${data.results[i].id}">
                    <i class="fa fa-edit text-success"></i>
                </a>
                
            </td>
        </tr>
    `);
    }

    listElement.querySelector('tbody').innerHTML = listContent.join('')

    document.querySelector('#pagination').innerHTML = getPagination(data.count.total)

    handlePaginationNavigation(page)

    spinner.classList.add('d-none')
}

const getPagination = (total) => {
    const countPages =  Math.ceil(total / 20)
    let paginationButton = []
    paginationButton.push(`<li class="page-item"><a class="page-link" href="#" id="previous-link">Précédent</a></li>`)

    for (let i = 1; i <= countPages; i++){
        paginationButton.push(`<li class="page-item"><a data-page="${i}" class="page-link pagination-btn" href="#">${i}</a></li>`)
    }

    paginationButton.push(` <li class="page-item"><a class="page-link" href="#" id="next-link">Suivant</a></li>`)

    return paginationButton.join('')
}

const handlePaginationNavigation = (page) => {
    const previousLink = document.querySelector('#previous-link')
    const nextLink = document.querySelector('#next-link')
    const paginationBtns = document.querySelectorAll('.pagination-btn')

    previousLink.addEventListener('click', async () => {
        if (page > 1 ){
            page--
            await refreshList(page)
        }
    })

    for (let i = 0; i < paginationBtns.length; i++){
        paginationBtns[i].addEventListener('click', async (e) => {
            const pageNumber = e.target.getAttribute('data-page')
            await refreshList(pageNumber)
        })
    }

    nextLink.addEventListener('click', async () => {
        page++
        await refreshList(page)
    })
}

export const handlePersonForm = () => {
    const validBtn = document.querySelector('#valid-form-person')
    let result, message

    validBtn.addEventListener('click', async(e) => {
        const form = document.querySelector('#person-form')

        if (!form.checkValidity()) {
            form.reportValidity()
            return false
        }


        if (e.target.name === 'create_button') {
            result = await createPerson(form)
            message = 'La personne a été créé avec succès'
        } else {
            result = await updatePerson(form, e.target.getAttribute('data-id'))
            message = 'La personne a été modifié avec succès'
        }


        if (result.hasOwnProperty('success')) {
            showToast(message, 'bg-success')
            (e.target.name === 'create_button') ? form.reset() :null
        } else if(result.hasOwnProperty('error')) {
            showToast(`Une erreur a été rencontrée: ${result.error}`, 'bg-danger')
        }
    })
}

export const handleRemoveImageClick = () => {
    const removeBtn = document.querySelector('#remove-image-btn')
    removeBtn.addEventListener('click', async () => {
        if (window.confirm("L'image va être supprimé, souhaitez vous confirmer ?")) {
            const reset = await resetImage(removeBtn.getAttribute('data-id'))
            if (reset.hasOwnProperty('success')) {
                document.querySelector('#person-image').innerHTML = ''
                showToast("L'image a été détruite", "bg-success")
            }
        }
    })
}
export const handleEnableList = ()=> {
    const enabledIcons = document.querySelectorAll(".enabled-icon")
    //const spinner = document.querySelector("#enabled-spinner")

    enabledIcons.forEach(enabledIcon => {
        enabledIcon.addEventListener('click', async(e)=> {
            const quizzId = e.target.getAttribute('data-id')
            const result = await togglePublishedQuizz(quizzId)
            if (result.hasOwnProperty('success')) {
                if (e.target.classList.contains("fa-check")) {
                    e.target.classList.remove('fa-check', 'text-success')
                    e.target.classList.add('fa-mark', 'text-danger')
                } else {
                    e.target.classList.add('fa-check', 'text-success')
                    e.target.classList.remove('fa-mark', 'text-danger')
                }
                showToast('le statut de l\'utilisateur a été modifié avec succès', 'bg-success')
            } else {
                showToast(result.error, 'bg-danger')
            }
        })
    })
}