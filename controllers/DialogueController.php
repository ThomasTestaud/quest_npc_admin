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

        require "views/_dialogue_responce.phtml";
    }

    public function createDialogue()
    {
    }

    public function updateDialogue()
    {
    }

    public function deleteDialogue()
    {
    }
}
