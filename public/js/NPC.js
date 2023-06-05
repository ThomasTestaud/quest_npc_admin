Class NPC {

    htmlBody;
    npcName;
    questId;
    npcId;
    questStep;

    constructor(htmlBody, npcName, questId, npcId, questStep) {
        this.htmlBody = htmlBody;
        this.npcName = npcName;
        this.questId = questId;
        this.npcId = npcId;
        this.questStep = questStep;
    }

}

export default NPC