<?php

namespace Models;

class QuestStep extends Database
{

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
        $req = "DELETE FROM `quest_steps` WHERE id_npc = :npcId AND id_quest = :questId AND step_number = :stepNumber";

        $params = [
            'npcId' => $npcId,
            'questId' => $questId,
            'stepNumber' => $stepNumber,
        ];

        $this->generic($req, $params);
    }

    public function updateQuestStep(): void
    {
        $req = "";

        $params = [];

        $this->generic($req, $params);
    }
}
