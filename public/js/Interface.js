class Interface {

    selectedQuest;
    questInstances;

    constructor(questInstances) {
        this.questInstances = questInstances;
    }

    selectQuest(quest) {
        console.log('select');
        this.selectedQuest = quest;
        console.log(this.selectedQuest);
    }

}

export default Interface