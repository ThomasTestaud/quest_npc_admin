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

    private function fetchNpcSlot(int $id_quest)
    {
        $Models = new \Models\Quest();
        $QuestArray = $Models->getAllQuest();

        // Initialise variables, adapter for the view
        $quest = [
            'quest_id' => $id_quest
        ];
        $steps = [];

        foreach ($QuestArray as $element) {
            $steps[] = [
                'quest_id' => $element['quest_id'],
                'step_number' => $element['step_number'],
                'npc_id' => $element['npc_id'],
                'npc_name' => $element['npc_name'],
                'npc_image' => $element['npc_image']
            ];
        }

        require 'views/_npc_inside_quest_cards.phtml';
    }
}
