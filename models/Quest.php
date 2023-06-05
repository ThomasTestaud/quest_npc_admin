<?php

namespace Models;

class Quest extends Database
{

    public function getAllQuest(): array | null
    {
        $req = "SELECT quests.id AS quest_id, quests.name AS quest_name, quest_number, money_reward, experience_reward, step_number, npcs.id AS npc_id, npcs.name AS npc_name, image AS npc_image 
        FROM `quests`
        LEFT JOIN `quest_steps`
        ON quest_steps.id_quest = quests.id
        LEFT JOIN `npcs`
        ON npcs.id = quest_steps.id_npc
        ORDER BY quests.id";

        $params = [];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function createQuest($name, $money_reward, $experience_reward, $quest_number): void
    {

        $req = "INSERT INTO `quests`(`name`, `money_reward`, `experience_reward`, `quest_number`) 
                            VALUES (:name, :money_reward, :experience_reward, :quest_number)";

        $params = [
            'name' => $name,
            'money_reward' => $money_reward,
            'experience_reward' => $experience_reward,
            'quest_number' => $quest_number,

        ];

        $this->generic($req, $params);
    }

    public function deleteQuest($id): void
    {
        $req = "DELETE FROM `quests` WHERE id = :id";

        $params = [
            'id' => $id,
        ];

        $this->generic($req, $params);
    }

    public function updateQuest($id, $name, $money_reward, $experience_reward, $quest_number): void
    {

        $req = "UPDATE `quests` SET 
                `name`= :name,
                `money_reward`= :money_reward,
                `experience_reward`= :experience_reward,
                `quest_number`= :quest_number
                WHERE id = :id";

        $params = [
            'id' => $id,
            'name' => $name,
            'money_reward' => $money_reward,
            'experience_reward' => $experience_reward,
            'quest_number' => $quest_number,

        ];

        $this->generic($req, $params);
    }
}
