
export const nbQuestions = async (id) => {
    const response = await fetch(`index.php?component=quizzParty&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
    return await response.json()
}


export const getAllAnwsers = async (id) => {
    const response = await fetch(`index.php?component=quizzParty&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'GET'
    });
    return await response.json()
}