class DialoguePopup {

    popUp;
    crossIcon;
    responceContainer;
    npc;

    constructor(npc) {
        this.popUp = document.getElementById('dialogues-popup');
        this.crossIcon = document.getElementById('dialogue-popup-cross-icon');
        this.crossIcon.addEventListener('click', () => {
            this.closeDialogue();
        });
        this.npc = npc;
        this.responceContainer = document.getElementById('dialogue-popup-responce');
        console.log(this.responceContainer);
    }

    displayDialogue(questId) {
        this.popUp.classList.remove('none');
        this.fetchDialoguesForThisStep(this.npc.stepId);
        console.log(this.npc.stepId);
    }

    closeDialogue() {
        this.popUp.classList.add('none');
    }

    fetchDialoguesForThisStep(stepId) {
        const url = 'index.php?page=get-dialogue&step-id=' + stepId;
        const requestOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
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
                this.responceContainer.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });

    }

}

export default DialoguePopup