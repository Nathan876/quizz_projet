export const getQuizzs = async () => {
    const response = await fetch(`index.php?component=allQuizzParty`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    return await response.json()
}
