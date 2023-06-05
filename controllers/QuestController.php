<?php

namespace Controllers;

class QuestController
{
    private $errors = [];

    public function getAllQuest()
    {
        $Models = new \Models\Quest();
        $QuestArray = $Models->getAllQuest();

        $Models = new \Models\NPC();
        $NPCs = $Models->getAllNPC();

        // Initialise variables
        $quests = [];
        $steps = [];

        $lastId = 0;

        foreach ($QuestArray as $element) {
            if ($element['quest_id'] != $lastId) {
                $lastId = $element['quest_id'];
                $quests[] = [
                    'quest_id' => $element['quest_id'],
                    'quest_number' => $element['quest_number'],
                    'quest_name' => $element['quest_name'],
                    'money_reward' => $element['money_reward'],
                    'experience_reward' => $element['experience_reward'],
                ];
            }

            $steps[] = [
                'quest_id' => $element['quest_id'],
                'step_number' => $element['step_number'],
                'npc_id' => $element['npc_id'],
                'npc_name' => $element['npc_name'],
                'npc_image' => $element['npc_image']
            ];
        }
        $JavaScript = 'manageQuest.js';
        $template = "views/quest_view.phtml";
        require "views/layout.phtml";
    }

    public function createQuest()
    {
        if (isset($_POST['quest-name'])) {
            //Verifs
            if (strlen($_POST['quest-name']) > 256) {
                $this->errors[] = "The quest's name should be less than 256 carachters long.";
            } else if (strlen($_POST['quest-name']) < 3) {
                $this->errors[] = "The quest's name should be at least 3 carachters long.";
            }
            if (empty($_POST['quest-number']) || empty($_POST['quest-money-reward']) || empty($_POST['quest-experience-reward'])) {
                $this->errors[] = "All the inputs are required in order to create a new quest.";
            }

            // Upload new quest
            if (empty($this->errors)) {
                $Models = new \Models\Quest();
                $Models->createQuest($_POST['quest-name'], $_POST['quest-money-reward'], $_POST['quest-experience-reward'], $_POST['quest-number']);

                // Redirect user
                header('Location: index.php?page=quest');
                exit;
            }

            $errors = $this->errors;
        }
        $template = "views/_create_quest.phtml";
        require "views/layout.phtml";
    }

    public function deleteQuest()
    {
        if (isset($_GET['id'])) {
            $Models = new \Models\Quest();
            $Models->deleteQuest($_GET['id']);
        }

        header('Location: index.php?page=quest');
        exit;
    }

    public function updateQuest()
    {
        if (isset($_POST['quest-name'])) {
            //Verifs
            if (strlen($_POST['quest-name']) > 256) {
                $this->errors[] = "The quest's name should be less than 256 carachters long.";
            } else if (strlen($_POST['quest-name']) < 3) {
                $this->errors[] = "The quest's name should be at least 3 carachters long.";
            }
            if (empty($_POST['quest-number']) || empty($_POST['quest-money-reward']) || empty($_POST['quest-experience-reward'])) {
                $this->errors[] = "All the inputs are required in order to create a new quest.";
            }
            if (empty($_POST['quest-id'])) {
                $this->errors[] = "There has been an error with the quest id...";
            }
            // Upload new quest
            if (empty($this->errors)) {
                $Models = new \Models\Quest();
                $Models->updateQuest($_POST['quest-id'], $_POST['quest-name'], $_POST['quest-money-reward'], $_POST['quest-experience-reward'], $_POST['quest-number']);

                // Redirect user
                header('Location: index.php?page=quest');
                exit;
            }

            $errors = $this->errors;
        }
        $JavaScript = 'manageQuest.js';
        $template = "views/quest_view.phtml";
        require "views/layout.phtml";
    }
}
