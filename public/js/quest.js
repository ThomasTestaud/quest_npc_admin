import AjaxManager from './ajaxManager.js'

class Quest {

    questElement;
    questHtmlId;
    questDdbId;
    penId;
    penElement;
    crossId;
    crossElement;
    trashId;
    trashElement;
    questNpcSlot;
    npcs; // list of all npcs in this quest
    questInfo;
    updateQuestInfo;

    constructor(questHtmlId) {
        this.questHtmlId = questHtmlId;
        this.questElement = document.getElementById(questHtmlId);
        this.questDdbId = this.questElement.dataset.ddbid;
        this.penId = this.questElement.dataset.penid;
        this.crossId = this.questElement.dataset.crossid;
        this.trashId = this.questElement.dataset.deletequestid;
        this.getAllNPC();
        this.penElement = document.getElementById(this.penId);
        this.crossElement = document.getElementById(this.crossId);
        this.trashElement = document.getElementById(this.trashId);
        this.questNpcSlot = document.getElementById(this.questElement.dataset.questnpcslot);
        this.questInfo = document.getElementById(this.questElement.dataset.questinfo);
        this.updateQuestInfo = document.getElementById(this.questElement.dataset.updatequestinfo);
    }

    getAllNPC() {
        this.npcs = [];

        let npcArr = document.querySelectorAll('.quest' + this.questDdbId);

        npcArr.forEach((npc) => {
            const newNpc = {};

            newNpc.npcDdbId = npc.dataset.npcddbid;
            newNpc.npcHtmlid = npc.dataset.npchtmlid;
            newNpc.npcStep = npc.dataset.npcstep;
            newNpc.minusIcon = npc.dataset.npcminusicon;
            newNpc.arrowUpIcon = document.getElementById(npc.dataset.npcarrowup);
            newNpc.arrowDownIcon = document.getElementById(npc.dataset.npcarrowdown);

            this.npcs.push(newNpc);

            const minusIcon = document.getElementById(newNpc['minusIcon']);

            minusIcon.addEventListener('click', () => {
                //console.log(this.questNpcSlot);
                this.RemoveNpcFromQuest(newNpc.npcDdbId, this.questDdbId, newNpc.npcStep, this.questNpcSlot);
            });

        });

        this.npcs.forEach((npc, index) => {

            npc.arrowUpIcon.addEventListener('click', () => {
                if (index > 0) {
                    // Prepare data
                    let QuestId = this.questDdbId;

                    let NpcId1 = this.npcs[index].npcDdbId;
                    let stepNumber1 = this.npcs[index].npcStep;

                    let NpcId2 = this.npcs[index - 1].npcDdbId;
                    let stepNumber2 = this.npcs[index - 1].npcStep;
                    // Ajax request
                    this.SwapNpcSteps(NpcId1, stepNumber1, NpcId2, stepNumber2, QuestId, this.questNpcSlot);
                }
            });


            npc.arrowDownIcon.addEventListener('click', () => {
                if (index < this.npcs.length - 1) {
                    // Prepare data
                    let QuestId = this.questDdbId;

                    let NpcId1 = this.npcs[index].npcDdbId;
                    let stepNumber1 = this.npcs[index].npcStep;

                    let NpcId2 = this.npcs[index + 1].npcDdbId;
                    let stepNumber2 = this.npcs[index + 1].npcStep;
                    // Ajax request
                    this.SwapNpcSteps(NpcId1, stepNumber1, NpcId2, stepNumber2, QuestId, this.questNpcSlot);
                }
            });

        });
    }

    RemoveNpcFromQuest(NpcId, QuestId, stepNumber, container) {
        const url = 'index.php?page=delete-quest-step';
        const data = {
            NPC_Id: NpcId,
            quest_Id: QuestId,
            step_Number: stepNumber
        };
        const requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        };

        fetch(url, requestOptions)
            .then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('Request failed with status:', response.status);
                }
            })
            .then(data => {
                container.innerHTML = data;
                this.getAllNPC();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    SwapNpcSteps(NpcId1, stepNumber1, NpcId2, stepNumber2, QuestId, container) {
        const url = 'index.php?page=update-quest-step';
        const data = {
            quest_Id: QuestId,

            NPC_Id_1: NpcId1,
            step_Number_1: stepNumber1,

            NPC_Id_2: NpcId2,
            step_Number_2: stepNumber2
        };
        const requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        };

        fetch(url, requestOptions)
            .then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('Request failed with status:', response.status);
                }
            })
            .then(data => {
                container.innerHTML = data;
                this.getAllNPC();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


}

export default Quest