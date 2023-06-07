<?php

namespace Controllers;

class QuestStepController
{
    private $errors = [];

    public function createQuestStep()
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $id_npc = intval($data['NPC_Id']);
        $id_quest = intval($data['quest_Id']);
        $step_number = intval($data['step_Number']);

        $Models = new \Models\QuestStep();
        $Models->createQuestStep($step_number, $id_quest, $id_npc);

        $this->fetchNpcSlot($id_quest);
    }

    public function updateQuestStep()
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        // Sort data
        $questId = intval($data['quest_Id']);

        $stepId1 = intval($data['step_id_1']);
        $stepNumber1 = intval($data['step_Number_1']);

        $stepId2 = intval($data['step_id_2']);
        $stepNumber2 = intval($data['step_Number_2']);

        $Models = new \Models\QuestStep();

        $Models->updateQuestStep($stepId1, $stepNumber2);
        $Models->updateQuestStep($stepId2, $stepNumber1);

        // Return the new set of NPCs to the ajax
        $this->fetchNpcSlot($questId);
    }

    public function deleteQuestStep()
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $npcId = $data['NPC_Id'];
        $questId = $data['quest_Id'];
        $stepNumber = $data['step_Number'];

        $Models = new \Models\QuestStep();
        $Models->deleteQuestStep($npcId, $questId, $stepNumber);

        $this->fetchNpcSlot($questId);
    }

    private function fetchNpcSlot(int $questId)
    {
        // Get all quests_steps
        $Models = new \Models\QuestStep();
        $stepArray = $Models->getAllQuestStepsFromQuest($questId);

        $quest['quest_id'] = $questId;
        $quest['npcs'] = [];

        foreach ($stepArray as $step) {
            $quest['npcs'][] = [
                'quest_id' => $step['id_quest'],
                'step_number' => $step['step_number'],
                'npc_id' => $step['id_npc'],
                'npc_name' => htmlspecialchars($step['name']),
                'npc_image' => $step['image'],
                'step_id' => $step['id']
            ];
        }

        require 'views/_npc_inside_quest_cards.phtml';
    }
}
