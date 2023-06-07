<?php

namespace Models;

class QuestStep extends Database
{
    public function getAllQuestSteps()
    {

        $req = "SELECT `step_number`, `id_quest`, `id_npc`, `name`, `image`, quest_steps.id as id
                FROM `quest_steps`
                JOIN `npcs`
                ON id_npc = npcs.id
                ORDER BY step_number";

        $params = [];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function getAllQuestStepsFromQuest($questId)
    {

        $req = "SELECT `step_number`, `id_quest`, `id_npc`, `name`, `image`, quest_steps.id as id 
                FROM `quest_steps`
                JOIN `npcs`
                ON id_npc = npcs.id
                WHERE id_quest = :questId
                ORDER BY step_number";

        $params = [
            'questId' => $questId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function createQuestStep($step_number, $id_quest, $id_npc): void
    {

        $req = "INSERT INTO `quest_steps`(`step_number`, `id_quest`, `id_npc`) 
                                VALUES (:step_number, :id_quest, :id_npc)";

        $params = [
            'step_number' => $step_number,
            'id_quest' => $id_quest,
            'id_npc' => $id_npc,

        ];

        $this->generic($req, $params);
    }

    public function deleteQuestStep($npcId, $questId, $stepNumber): void
    {
        $req = "DELETE FROM `quest_steps` 
                WHERE id_npc = :npcId 
                AND id_quest = :questId 
                AND step_number = :stepNumber;

                UPDATE `quest_steps`
                SET step_number = step_number - 1
                WHERE step_number > :stepNumber AND id_quest = :questId";

        $params = [
            'npcId' => $npcId,
            'questId' => $questId,
            'stepNumber' => $stepNumber,
        ];

        $this->generic($req, $params);
    }

    public function updateQuestStep($npcId, $oldStepNumber, $newStepNumber, $questId): void
    {
        $req = "UPDATE `quest_steps` 
                SET `step_number`= :newStepNumber
                WHERE id_npc = :npcId AND id_quest = :questId AND step_number = :oldStepNumber";

        $params = [
            'npcId' => $npcId,
            'questId' => $questId,
            'oldStepNumber' => $oldStepNumber,
            'newStepNumber' => $newStepNumber
        ];

        $this->generic($req, $params);
    }
}
