import AjaxManager from './ajaxManager.js'
import Interface from './Interface.js'
import Quest from './quest.js'
import UsableNpcs from './UsableNpcs.js'

function script() {

    const ajax = new AjaxManager();

    //// CREAT INSTANCES ////
    // Create quest
    let questArray = document.querySelectorAll('.html-quest-body');
    let questInstances = [];
    questArray.forEach((el) => {
        const htmlId = el.dataset.htmlid;
        questInstances.push(new Quest(htmlId));
    });

    // Create Usable NPCs
    let usableNpcArray = document.querySelectorAll('.usable-npcs-body');
    let usableNpcInstances = [];
    usableNpcArray.forEach((npc) => {
        usableNpcInstances.push(new UsableNpcs(npc.dataset));
    });

    // Interface instance
    let appInterface = new Interface(questInstances, usableNpcInstances);
    appInterface.unselectQuest();

    //// CALLBACK FROM AJAX ////
    function refresh() {
        questInstances.forEach((quest) => {
            quest.getAllNPC();
        });
        appInterface.selectQuest(appInterface.selectedQuest);
    }


    //// EVENT LISTENERS ////
    appInterface.questInstances.forEach((quest) => {
        // Select quest
        quest.penElement.addEventListener('click', () => {
            appInterface.selectQuest(quest);
        });
        // Unselect quest
        quest.crossElement.addEventListener('click', function () {
            appInterface.unselectQuest();
        });
    });


    appInterface.usableNpcs.forEach((usableNpc) => {
        // Add to quest
        usableNpc.addIconIdElement.addEventListener('click', function () {
            const NpcId = usableNpc.ddbId;
            const QuestId = appInterface.selectedQuest.questDdbId;
            const stepNumber = appInterface.selectedQuest.npcs.length + 1;
            const container = appInterface.selectedQuest.questNpcSlot;

            ajax.AddNpcToQuest(NpcId, QuestId, stepNumber, container, refresh);
        });
    });

}

window.addEventListener('DOMContentLoaded', script());