//import AjaxManager from './ajaxManager.js'
import Interface from './Interface.js'
import Quest from './quest.js'



function script() {

    //const ajax = new AjaxManager();



    let questArray = document.querySelectorAll('.html-quest-body');
    let questInstances = [];

    questArray.forEach((el, index) => {
        const htmlId = el.dataset.htmlid;
        const ddbId = el.dataset.ddbid;
        const penId = el.dataset.penid;

        questInstances.push(new Quest(htmlId, ddbId, penId));
    });

    const appInterface = new Interface(questInstances);

    questInstances.forEach((quest) => {

        document.getElementById(quest.penId).addEventListener('click', () => {

            appInterface.selectQuest(quest);
        });
    });

    //console.log(appInterface.questInstances);



    /*

    // Left column
    const addNpcToQuest = document.querySelectorAll('.add-npc-to-quest');
    const usableNpcId = document.querySelectorAll('.usable-NPC-id');

    // Right column
    let questCard = document.querySelectorAll('.quest-card');
    let editQuestPen = document.querySelectorAll('.edit-quest-pen');
    let deleteQuest = document.querySelectorAll('.delete-quest');
    let closeEditQuest = document.querySelectorAll('.close-edit-quest');
    let removeNpcFromQuest = document.querySelectorAll('.remove-npc-from-quest');
    let npcQuestStepNumber = document.querySelectorAll('.npc-quest-step-number');
    let npcIdFromQuest = document.querySelectorAll('.npc-id-from-quest');
    let npcQuestId = document.querySelectorAll('.npc-quest-id');
    let questId = document.querySelectorAll('.quest-id');
    let questNpcSlot = document.querySelectorAll('.quest-npc-slot');

    let selectedQuest;
    let selectedQuestIndex;
    let selectedNPC;
    let selectedStep;

    // Turn the quest card green
    // Turn all the other card red
    function openEditQuestCard(index) {

        // Update the selectedQuest variable
        selectedQuest = questId[index].value;
        selectedQuestIndex = index + 1;

        closeEditQuest[index].classList.remove('none');
        editQuestPen[index].classList.add('none');
        deleteQuest[index].classList.add('none');
        questCard[index].classList.add('activated');

        // Turn all the quest cards red
        questCard.forEach((el, j) => {
            questCard[j].classList.add('de-activated');
        });

        // Show add button on NPC cards from left column
        addNpcToQuest.forEach((el, j) => {
            addNpcToQuest[j].classList.remove('none');
        });

        // Show remove button on NPC cards only present in the quest card
        removeNpcFromQuest.forEach((el, j) => {
            if (questId[index].value === npcQuestId[j].value) {
                removeNpcFromQuest[j].classList.remove('none');
            }
        });

        // Remove the red backgraound from the selected quest
        questCard[index].classList.remove('de-activated');
    }

    // Turn the quest card back to normal
    function closeEditQuestCard(index) {
        closeEditQuest[index].classList.add('none');
        editQuestPen[index].classList.remove('none');
        deleteQuest[index].classList.remove('none');
        questCard[index].classList.remove('activated');

        // Remove the red background from all the quest cards
        questCard.forEach((el, j) => {
            questCard[j].classList.remove('de-activated');
        });

        // Remove the add button from the NPC cards from left column
        addNpcToQuest.forEach((el, j) => {
            addNpcToQuest[j].classList.add('none');
        });

        // Remove the delete button from the NPC cards from the selected quest card
        removeNpcFromQuest.forEach((el, j) => {
            removeNpcFromQuest[j].classList.add('none');
        });
    }

    function handleRemoveNpcFromQuest(index) {
        selectedNPC = npcIdFromQuest[index].value;
        selectedStep = npcQuestStepNumber[index].value;
        ajax.AjaxRemoveNpcFromQuest(selectedNPC, selectedQuest, selectedStep, questNpcSlot[selectedQuestIndex], reset);
        currentId = this.dataset.index;
    }

    function MetaRemoveNpcFromQuest() {
        removeNpcFromQuest.forEach((btn, index) => {

            btn.removeEventListener('click', () => {
                handleRemoveNpcFromQuest(index);
            });
            btn.addEventListener('click', () => {
                handleRemoveNpcFromQuest(index);
            });;
        });
    }

    function reset() {

        questCard = document.querySelectorAll('.quest-card');
        editQuestPen = document.querySelectorAll('.edit-quest-pen');
        deleteQuest = document.querySelectorAll('.delete-quest');
        closeEditQuest = document.querySelectorAll('.close-edit-quest');
        removeNpcFromQuest = document.querySelectorAll('.remove-npc-from-quest');
        npcQuestStepNumber = document.querySelectorAll('.npc-quest-step-number');
        npcIdFromQuest = document.querySelectorAll('.npc-id-from-quest');
        npcQuestId = document.querySelectorAll('.npc-quest-id');
        questId = document.querySelectorAll('.quest-id');
        questNpcSlot = document.querySelectorAll('.quest-npc-slot');

        MetaRemoveNpcFromQuest();
        openEditQuestCard(selectedQuestIndex - 1);
    }


    // Put Event Listener on the Pen icon from the quest cards
    editQuestPen.forEach((pen, index) => {
        pen.addEventListener('click', () => {
            questCard.forEach((el, j) => {
                closeEditQuestCard(j);
            });
            openEditQuestCard(index);
        });
    });

    // Put Event Listener on the X icon from the quest cards
    closeEditQuest.forEach((pen, index) => {
        pen.addEventListener('click', () => {
            closeEditQuestCard(index);
        });
    });

    // Put Event Listener on the Minus icon from the NPC cards in the quest cards (right column)
    MetaRemoveNpcFromQuest();

    // Put Event Listener on the Plus icon from the cards from left column
    addNpcToQuest.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            selectedNPC = usableNpcId[index].value;
            ajax.AjaxAddNpcToQuest(selectedNPC, selectedQuest, 1, questNpcSlot[selectedQuestIndex], reset);
        });
    });

    reset();
*/

}

window.addEventListener('DOMContentLoaded', script());