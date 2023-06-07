<?php

session_start();

spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});

$JavaScript = 'main.js';

//Router
if (array_key_exists('page', $_GET)) {

    switch ($_GET['page']) {
            // NPC
        case 'NPC':
            $controller = new Controllers\NPCController();
            $controller->getAllNPC();
            break;

        case 'create-NPC':
            $controller = new Controllers\NPCController();
            $controller->createNPC();
            break;

        case 'update-NPC':
            $controller = new Controllers\NPCController();
            $controller->updateNPC();
            break;

        case 'delete-NPC':
            $controller = new Controllers\NPCController();
            $controller->deleteNPC();
            break;

            // Quest
        case 'quest':
            $controller = new Controllers\QuestController();
            $controller->getAllQuest();
            break;

        case 'create-quest':
            $controller = new Controllers\QuestController();
            $controller->createQuest();
            break;

        case 'update-quest':
            $controller = new Controllers\QuestController();
            $controller->updateQuest();
            break;

        case 'delete-quest':
            $controller = new Controllers\QuestController();
            $controller->deleteQuest();
            break;

            // Quest Step
        case 'create-quest-step':
            $controller = new Controllers\QuestStepController();
            $controller->createQuestStep();
            break;

        case 'update-quest-step':
            $controller = new Controllers\QuestStepController();
            $controller->updateQuestStep();
            break;

        case 'delete-quest-step':
            $controller = new Controllers\QuestStepController();
            $controller->deleteQuestStep();
            break;

            // Dialogues
        case 'get-dialogue':
            $controller = new Controllers\DialogueController();
            $controller->getDialogue();
            break;

        case 'update-dialogue':
            $controller = new Controllers\DialogueController();
            $controller->updateDialogue();
            break;

        default:
            header('Location: index.php?page=NPC');
            exit;
    }
} else {
    header('Location: index.php?page=NPC');
    exit;
}
