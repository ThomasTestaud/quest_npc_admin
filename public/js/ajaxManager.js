class AjaxManager {

    AjaxAddNpcToQuest(NpcId, QuestId, stepNumber, container, callback) {
        const url = 'index.php?page=create-quest-step';
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
                callback();
                //console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    AjaxRemoveNpcFromQuest(NpcId, QuestId, stepNumber, container, callback) {
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
                callback();
                //console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


}

export default AjaxManager