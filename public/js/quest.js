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
    }

    getAllNPC() {
        this.npcs = [];

        let npcArr = document.querySelectorAll('.quest' + this.questDdbId);

        npcArr.forEach((npc) => {
            const newNpc = [];

            newNpc['npcDdbId'] = npc.dataset.npcddbid;
            newNpc['npcHtmlid'] = npc.dataset.npchtmlid;
            newNpc['npcStep'] = npc.dataset.npcstep;
            newNpc['minusIcon'] = npc.dataset.npcminusicon;

            this.npcs.push(newNpc);

            //const ajax = new AjaxManager();
            const icon = document.getElementById(newNpc['minusIcon']);

            icon.addEventListener('click', () => {
                //console.log(this.questNpcSlot);
                this.RemoveNpcFromQuest(newNpc['npcDdbId'], this.questDdbId, newNpc['npcStep'], this.questNpcSlot);
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
                //callback();
                //console.log(data);
                //refresh();
                this.getAllNPC();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


}

export default Quest