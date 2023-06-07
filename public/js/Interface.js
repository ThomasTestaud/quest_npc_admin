class Interface {

    selectedQuest;
    questInstances;
    usableNpcs;
    selectedUsableNpc;

    constructor(questInstances, usableNpcs) {
        this.questInstances = questInstances;
        this.usableNpcs = usableNpcs;
    }

    selectQuest(quest) {
        this.selectedQuest = quest;
        //console.log(this.selectedQuest.questNpcSlot);
        this.unselectQuest();
        // Turn red all quests
        this.questInstances.forEach((quest) => {
            document.getElementById(quest.questHtmlId).classList.add('de-activated');
        });
        // Turn green selected quest
        this.selectedQuest.questElement.classList.remove('de-activated');
        this.selectedQuest.questElement.classList.add('activated');
        // Show and hide icons
        this.selectedQuest.penElement.classList.add('none');
        this.selectedQuest.trashElement.classList.remove('none');
        this.selectedQuest.crossElement.classList.remove('none');
        // Show the plus icons on usable-npcs
        this.usableNpcs.forEach((npc) => {
            npc.addIconIdElement.classList.remove('none');
        });
        // For the NPC cards inside the quests cards
        quest.npcs.forEach((npc) => {
            // Display minus icons on the nps quest
            const arr = document.querySelectorAll("#" + npc.minusIcon);
            arr.forEach((el) => {
                el.classList.remove('none');
            });
            // Display the arrows
            npc.arrowUpIcon.classList.remove('none');
            npc.arrowDownIcon.classList.remove('none');
            npc.dialogueIcon.classList.add('none');
        });
        // Show form and hide infos
        quest.questInfo.classList.add('none');
        quest.updateQuestInfo.classList.remove('none');


    }

    unselectQuest() {
        this.questInstances.forEach((quest) => {
            // De-color quest cards
            quest.questElement.classList.remove('de-activated');
            quest.questElement.classList.remove('activated');
            // Show and hide icons
            quest.penElement.classList.remove('none');
            quest.trashElement.classList.add('none');
            quest.crossElement.classList.add('none');
            // For NPCs
            quest.npcs.forEach((npc) => {
                const arr = document.querySelectorAll("#" + npc.minusIcon);
                arr.forEach((el) => {
                    el.classList.add('none');
                });
                // Display the arrows
                npc.arrowUpIcon.classList.add('none');
                npc.arrowDownIcon.classList.add('none');
                npc.dialogueIcon.classList.remove('none');
            });
            // Hide form and show infos
            quest.questInfo.classList.remove('none');
            quest.updateQuestInfo.classList.add('none');
        });
        // Hide plus icons
        this.usableNpcs.forEach((npc) => {
            npc.addIconIdElement.classList.add('none');

        });

    }

}

export default Interface