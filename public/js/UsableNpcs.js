class UsableNpcs {

    id;
    ddbId;
    addIconId;
    addIconIdElement;

    constructor(dataSet) {
        this.id = dataSet.usablenpcid;
        this.addIconId = dataSet.addiconid;
        this.ddbId = dataSet.ddbid;
        this.addIconIdElement = document.getElementById(this.addIconId);
    }

}

export default UsableNpcs