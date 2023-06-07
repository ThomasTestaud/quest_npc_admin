<?php

namespace Models;

class Dialogue extends Database
{
    public function createDialogue($stepId): void
    {

        $req = "INSERT INTO `dialogues`(`step_id`, `before_quest`, `ongoing_quest`, `complete_quest`, `after_quest`) 
                VALUES (:stepId,
                'I have nothing to say to you.',
                'I have nothing to say to you.',
                'I have nothing to say to you.',
                'I have nothing to say to you.')";

        $params = [
            'stepId' => $stepId
        ];

        $this->generic($req, $params);
    }

    public function getDialogueFromStepId($stepId)
    {

        $req = "SELECT `step_id`, `before_quest`, `ongoing_quest`, `complete_quest`, `after_quest`, `name`, `image`
                FROM `dialogues`
                JOIN quest_steps
                ON quest_steps.id = step_id
                JOIN npcs
                ON quest_steps.id_npc = npcs.id
                WHERE step_id = :stepId";

        $params = [
            'stepId' => $stepId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }

    public function updateQuestStep($stepId, $beforeQuest, $ongoingQuest, $completeQuest, $afterQuest): void
    {
        $req = "UPDATE `dialogues` 
                SET `before_quest`= :beforeQuest,
                    `ongoing_quest`= :ongoingQuest,
                    `complete_quest`= :completeQuest,
                    `after_quest`= :afterQuest 
                WHERE step_id = :stepId";

        $params = [
            'stepId' => $stepId,
            'beforeQuest' => $beforeQuest,
            'ongoingQuest' => $ongoingQuest,
            'completeQuest' => $completeQuest,
            'afterQuest' => $afterQuest
        ];

        $this->generic($req, $params);
    }
}
