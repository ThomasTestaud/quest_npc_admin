class DialoguePopup {

    popUp;
    crossIcon;
    responceContainer;
    npc;
    dialogueForm;
    closeDialogueFormIcon;
    penIcons;
    btnSubmitDialogues;

    constructor(npc) {
        this.popUp = document.getElementById('dialogues-popup');
        this.crossIcon = document.getElementById('dialogue-popup-cross-icon');
        this.crossIcon.addEventListener('click', () => {
            this.closeDialogue();
        });
        this.npc = npc;
        this.responceContainer = document.getElementById('dialogue-popup-responce');
    }

    displayDialogue(questId) {
        this.popUp.classList.remove('none');
        this.fetchDialoguesForThisStep(this.npc.stepId);
        console.log(this.npc.stepId);
    }

    closeDialogue() {
        this.popUp.classList.add('none');
        this.responceContainer.innerHTML = "";
    }

    attachToNewHTML() {

        this.penIcons = document.querySelectorAll('.dialogue-pen');
        this.dialogueForm = document.getElementById('dialogues-form');
        this.closeDialogueFormIcon = document.getElementById('dialogue-form-cross-icon');
        this.btnSubmitDialogues = document.getElementById('submit-dialogues');

        this.penIcons.forEach((pen) => {
            pen.addEventListener('click', () => {
                this.displayFormDialogue();
            });
        });

        this.closeDialogueFormIcon.addEventListener('click', () => {
            this.hideFormDialogue();
        });


        this.btnSubmitDialogues.addEventListener('click', () => {
            // Fetch the content of the inputs
            let beforeQuest = document.getElementById('before-quest').value;
            let ongoingQuest = document.getElementById('ongoing-quest').value;
            let completeQuest = document.getElementById('complete-quest').value;
            let afterQuest = document.getElementById('after-quest').value;
            // Update dialogues in the database
            this.updateDialogueInDatabase(this.npc.stepId, beforeQuest, ongoingQuest, completeQuest, afterQuest)
        });
    }

    displayFormDialogue() {
        this.dialogueForm.classList.remove('none');
    }

    hideFormDialogue() {
        this.dialogueForm.classList.add('none');
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
                this.attachToNewHTML();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    updateDialogueInDatabase(stepId, beforeQuest, ongoingQuest, completeQuest, afterQuest) {
        const url = 'index.php?page=update-dialogue';
        const data = {
            step_id: stepId,
            before_quest: beforeQuest,
            ongoing_quest: ongoingQuest,
            complete_quest: completeQuest,
            after_quest: afterQuest
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
                this.responceContainer.innerHTML = data;
                this.attachToNewHTML();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

}

export default DialoguePopup