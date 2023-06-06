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

        $NPC_Id_1 = intval($data['NPC_Id_1']);
        $step_Number_1 = intval($data['step_Number_1']);

        $NPC_Id_2 = intval($data['NPC_Id_2']);
        $step_Number_2 = intval($data['step_Number_2']);

        $Models = new \Models\QuestStep();

        // Prepare
        $npcId = $NPC_Id_1;
        $oldStepNumber  = $step_Number_1;
        $newStepNumber = $step_Number_2;
        // Execute
        $Models->updateQuestStep($npcId, $oldStepNumber, $newStepNumber, $questId);

        // Prepare
        $npcId = $NPC_Id_2;
        $oldStepNumber  = $step_Number_2;
        $newStepNumber = $step_Number_1;
        // Execute
        $Models->updateQuestStep($npcId, $oldStepNumber, $newStepNumber, $questId);

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
        // Sort $steps array by the 'step_number' column
        usort($steps, function ($a, $b) {
            return $a['step_number'] <=> $b['step_number'];
        });

        require 'views/_npc_inside_quest_cards.phtml';
    }
}
