import {nbQuestions, getAllAnwsers} from "../services/quizzParty.js"
import {showToast} from "./shared/toast.js"

export const updateProgressBar = (value, nbQuestions) => {

    const progressElement = document.querySelector('#progress')
    const progressBarElement =  progressElement.querySelector('.progress-bar')
    const updateValue = (100/nbQuestions) * (value)
    const roundedValue = Math.round(updateValue)
    progressElement.setAttribute('aria-valuenow', roundedValue)
    progressBarElement.style.width = `${roundedValue}%`
    progressBarElement.innerHTML = `${roundedValue}%`
}

export const getAnwsers = async (id) => {
    const data = await getAllAnwsers(id);

    if (!data) {
        console.error("Aucune donnée récupérée.");
        return null;
    }

    console.log("Données récupérées :", data);

    return data;
}

export const resulting = (nbGoodAnwsers, nbBadAnwsers)=> {

    const chart = document.querySelector('#my-chart')
    new Chart(chart, {
        type: 'doughnut',
        data: {
            labels: [
                'Bonnes réponses',
                'Mauvaises réponses',
            ],
            datasets: [{
                label: 'Résultat QCM',
                data: [nbGoodAnwsers, nbBadAnwsers],
                backgroundColor: [
                    '#013221',
                    '#660001'
                ],
                hoverOffset: 4
            }]
        },
    })
}



export const results = (resultsAnswers, userAnswers) => {
    let goodAnswers = 0
    let badAnswers = 0
    let nbPoints = 0
    let maxPoints = 0

    for (let i = 0; i < resultsAnswers.questions.length; i++) {
        const correctAnswers = resultsAnswers.questions[i].answers
        const userAnswer = userAnswers[i]

        for (let j = 0; j < correctAnswers.length; j++) {
            const correctAnswer = correctAnswers[j]

            maxPoints += correctAnswer.points

            if (userAnswer.includes(j+1) && correctAnswer.is_correct === 1) {
                nbPoints += correctAnswer.points
                goodAnswers++;
            } else if (userAnswer.includes(j+1) && correctAnswer.is_correct === 0) {
                badAnswers++
            }
        }
    }

    return [goodAnswers, badAnswers, nbPoints, maxPoints]
}

export const mouvPage = (numPage, nb_Questions, sens)=> {

    if (numPage < nb_Questions && sens === 1) {
        document.querySelector('#previous-btn').disabled = false
        const nextContent = document.querySelector(`#question-${numPage + 1}-content`)
        nextContent.classList.add("show", "active")
        const nextBtn = document.querySelector(`#question-${numPage + 1}-tab`)
        nextBtn.classList.add("active")
        nextBtn.setAttribute('aria-selected', 'true')
    } else if (sens === 0 && numPage > 1) {
        document.querySelector('#previous-btn').disabled = false
        const nextContent = document.querySelector(`#question-${numPage - 1}-content`)
        nextContent.classList.add("show", "active")
        const nextBtn = document.querySelector(`#question-${numPage - 1}-tab`)
        nextBtn.classList.add("active")
        nextBtn.setAttribute('aria-selected', 'true')
    }

    const selectedContent = document.querySelector(`#question-${numPage}-content`)
    const selectedBtn = document.querySelector(`#question-${numPage}-tab`)

    selectedBtn.classList.remove("active")
    selectedBtn.setAttribute('aria-selected', 'false')
    selectedContent.classList.remove("show", "active")
}

export const previousMouvPage = (numPage, nbQuestions)=> {
    const selectedContent = document.querySelector(`#question-${numPage}-content`)
    const nextContent = document.querySelector(`#question-${numPage-1}-content`)
    const selectedBtn = document.querySelector(`#question-${numPage}-tab`)
    const nextBtn = document.querySelector(`#question-${numPage-1}-tab`)

    if (numPage === nbQuestions) {
        nextBtn.disabled = true
    }
    selectedBtn.classList.remove("active")
    selectedBtn.setAttribute('aria-selected', 'false')
    selectedContent.classList.remove("show", "active")

    nextBtn.classList.add("active")
    nextBtn.setAttribute('aria-selected', 'true')
    nextContent.classList.add("show", "active")
}

document.addEventListener("DOMContentLoaded", async () => {
    const url = new URL(window.location.href)
    const id = url.searchParams.get('id')
    const answerData = await getAnwsers(id)
    const nbQuestions = answerData.questions.length
    const previousBtn = document.querySelector('#previous-btn')
    const nextBtn = document.querySelector("#next-btn")

    let userAnswers = Array.from({ length: nbQuestions }, () => [])
    let currentPage = 1

    for (let i = 0; i < nbQuestions; i++) {
        const form = document.querySelector(`#form-question-${i + 1}`)
        form.addEventListener("change", () => {
            const formData = new FormData(form)
            const selectedValues = []

            for (const [name, value] of formData) {
                selectedValues.push(parseInt(value))
            }

            userAnswers[i] = selectedValues
        });
    }

    previousBtn.addEventListener('click', async () => {
        if (currentPage > 1) {
            mouvPage(currentPage, nbQuestions, 0)
            currentPage--
            updateProgressBar(currentPage, nbQuestions)
        }
    });

    // Gestion du bouton suivant
    nextBtn.addEventListener('click', async () => {
        if (currentPage < nbQuestions) {
            mouvPage(currentPage, nbQuestions, 1)
            currentPage++
            updateProgressBar(currentPage, nbQuestions)
        } else if (currentPage === nbQuestions) {
            updateProgressBar(nbQuestions, nbQuestions)

            const resultContent = document.querySelector("#results-content")
            const resultTab = document.querySelector('#results-tab')
            const actualContent = document.querySelector(`#question-${nbQuestions}-content`)
            const actualTab = document.querySelector(`#question-${nbQuestions}-tab`)
            const nextBtn = document.querySelector('#next-btn')
            const previousBtn = document.querySelector('#previous-btn')
            nextBtn.setAttribute("disabled", "true")
            previousBtn.setAttribute("disabled", "true")

            resultContent.classList.add("show", "active");
            resultTab.classList.add("active");
            resultTab.setAttribute('aria-selected', 'true')
            actualContent.classList.remove('show', 'active')
            actualTab.classList.remove('active')
            actualTab.setAttribute('aria-selected', 'false')
            const result = results(answerData, userAnswers)
            const tab = resulting(result[0], result[1])
        }
    });
});