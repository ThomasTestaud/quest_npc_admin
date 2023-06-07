<?php

namespace Models;

class Dialogue extends Database
{
    public function createDialogue(): void
    {

        $req = "";

        $params = [];

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
                WHERE step_id = 9";

        $params = [];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }


    public function deleteDialogue(): void
    {
        $req = "";

        $params = [];

        $this->generic($req, $params);
    }

    public function updateQuestStep(): void
    {
        $req = "";

        $params = [];

        $this->generic($req, $params);
    }
}
