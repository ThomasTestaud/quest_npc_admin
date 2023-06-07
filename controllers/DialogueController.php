<?php

namespace Controllers;

class DialogueController
{
    private $errors = [];

    public function getDialogue()
    {
        $stepId = $_GET['step-id'];

        $Models = new \Models\Dialogue();

        $dialogues = $Models->getDialogueFromStepId($stepId);

        if (!$dialogues) {
            $Models->createDialogue($stepId);
            $dialogues = $Models->getDialogueFromStepId($stepId);
        }

        require "views/_dialogue_responce.phtml";
    }

    public function updateDialogue()
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $stepId = $data['step_id'];
        $beforeQuest = $data['before_quest'];
        $ongoingQuest = $data['ongoing_quest'];
        $completeQuest = $data['complete_quest'];
        $afterQuest = $data['after_quest'];

        $Models = new \Models\Dialogue();

        $Models->updateQuestStep($stepId, $beforeQuest, $ongoingQuest, $completeQuest, $afterQuest);
        $dialogues = $Models->getDialogueFromStepId($stepId);

        require "views/_dialogue_responce.phtml";
    }
}
