
export const getQuizzs = async (currentPage = 1) => {
    const response = await fetch(`index.php?component=quizzs&page=${currentPage}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    return await response.json()
}

export const createPerson = async (form) =>  {

    const data = new FormData(form)

    const response = await fetch(`index.php?component=person&action=create`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
        body: data
    })

    return response.json()
}

export const updatePerson = async (form, id) =>  {

    const data = new FormData(form)

    const response = await fetch(`index.php?component=quizz&action=update&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
        body: data
    })

    return response.json()
}
export const togglePublishedQuizz = async (id) => {
    const response = await fetch(`index.php?component=quizzs&action=togglePublished&id=${id}`,{
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return await response.json()
}