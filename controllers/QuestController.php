<?php

namespace Controllers;

class QuestController
{
    private $errors = [];

    public function getAllQuest()
    {
        // Get all the npc for the "Usable NPCs" column
        $Models = new \Models\NPC();
        $NPCs = $Models->getAllNPC();

        // Get all quests
        $Models = new \Models\Quest();
        $questArray = $Models->getAllQuest();

        // Get all quests_steps
        $Models = new \Models\QuestStep();
        $stepArray = $Models->getAllQuestSteps();

        $quests = [];
        foreach ($questArray as $quest) {

            $steps = [];
            foreach ($stepArray as $step) {
                if ($quest['quest_id'] === $step['id_quest']) {
                    $steps[] = [
                        'quest_id' => $step['id_quest'],
                        'step_number' => $step['step_number'],
                        'npc_id' => $step['id_npc'],
                        'npc_name' => htmlspecialchars($step['name']),
                        'npc_image' => $step['image'],
                        'step_id' => $step['id']
                    ];
                }
            }

            $quests[] = [
                'quest_id' => $quest['quest_id'],
                'quest_number' => $quest['quest_number'],
                'quest_name' => htmlspecialchars($quest['quest_name']),
                'money_reward' => $quest['money_reward'],
                'experience_reward' => $quest['experience_reward'],
                'npcs' => $steps
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
