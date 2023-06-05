class Quest {

    questHtmlId;
    questDdbId;
    penId;

    constructor(questHtmlId, questDdbId, penId) {
        this.questHtmlId = questHtmlId;
        this.questDdbId = questDdbId;
        this.penId = penId;
    }

    getPenId() {
        console.log(this.penId);
    }

}

export default Quest