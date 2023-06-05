<?php

namespace Controllers;

use PhpParser\Builder\Property;

class NPCController
{

    private $errors = [];

    public function getAllNPC()
    {
        $Models = new \Models\NPC();
        $NPCArray = $Models->getAllNPC();

        $JavaScript = 'manageNPC.js';
        $template = "views/NPC.phtml";
        require "views/layout.phtml";
    }

    public function createNPC()
    {
        if (isset($_POST['NPC-name'])) {

            $this->errors = [];

            // Verify the name input
            if (strlen($_POST['NPC-name']) > 256) {
                $this->errors[] = "The NPC's name should be less than 256 carachters long.";
            } else if (strlen($_POST['NPC-name']) < 3) {
                $this->errors[] = "The NPC's name should be at least 3 carachters long.";
            }

            // Upload the file
            $upload = $this->uploadPhoto('NPC-image'); // Returns file name if no error, return error's array if errors

            if (is_string($upload)) { // Exploite the returned data
                $newFileName = $upload;
            }

            // Write in the DDB if there is no errors
            if (empty($this->errors)) {

                // Call method to write in the DDB
                $Models = new \Models\NPC();
                $Models->createNPC($_POST['NPC-name'], $newFileName);

                header('Location: index.php?page=NPC');
                exit;
            } else {
                $errors = $this->errors;
            }
        }

        $template = "views/create_NPC.phtml";
        require "views/layout.phtml";
    }

    public function deleteNPC()
    {
        // Delete photo from the server
        $filename = 'public/uploads/NPC_img/' . $_GET['filename'];
        $default = 'public/uploads/NPC_img/default.png';
        if (file_exists($filename) && $filename != $default) {
            unlink($filename);
        }

        // Delete from the DDB
        $Models = new \Models\NPC();
        $Models->deleteNPC($_GET['id']);

        header('Location: index.php?page=NPC');
        exit;
    }

    public function updateNPC()
    {
        if (isset($_POST['update-NPC-name'])) {

            $this->errors = [];

            // Verify the name input
            if (strlen($_POST['update-NPC-name']) > 256) {
                $this->errors[] = "The NPC's name should be less than 256 carachters long.";
            } else if (strlen($_POST['update-NPC-name']) < 3) {
                $this->errors[] = "The NPC's name should be at least 3 carachters long.";
            }

            // Upload the file
            if (isset($_FILES["update-NPC-image"]) && $_FILES["update-NPC-image"]['error'] === UPLOAD_ERR_OK) {
                $upload = $this->uploadPhoto("update-NPC-image"); // Returns file name if no error, return error's array if errors
                if (is_string($upload)) { // Exploite the returned data

                    $newFileName = $upload;
                    // Delete the old photo
                    $filename = 'public/uploads/NPC_img/' . $_POST['old-NPC-photo'];
                    //$filename = $_POST['old-NPC-photo'];
                    $default = 'public/uploads/NPC_img/default.png';
                    if (file_exists($filename) && $filename != $default) {
                        unlink($filename);
                    }
                } else {
                    $newFileName = $_POST['old-NPC-photo'];
                }
            } else {
                $newFileName = $_POST['old-NPC-photo'];
            }


            // Write in the DDB if there is no errors
            if (empty($this->errors)) {

                // Call method to write in the DDB
                $Models = new \Models\NPC();
                $Models->updateNPC($_POST['update-NPC-id'], $_POST['update-NPC-name'], $newFileName);
                //die();
                header('Location: index.php?page=NPC');
                exit;
            } else {
                $errors = $this->errors;
            }
        } else {
            $this->errors[] = "There has been an errors... o.O";
            $errors = $this->errors;
        }
        //echo 'error';
        //die();
        $template = "views/NPC.phtml";
        require "views/layout.phtml";
    }

    private function uploadPhoto($photoName)  // Returns file name if no error, return error array if errors
    {
        // Verify the file
        if (isset($_FILES[$photoName]) && $_FILES[$photoName]['error'] === UPLOAD_ERR_OK) {
            $photoNPC = true;
            // Retrieve the file details
            $fileName = $_FILES[$photoName]['name'];
            $fileTmpPath = $_FILES[$photoName]['tmp_name'];
            $fileSize = $_FILES[$photoName]['size'];

            $validExtensions = ['jpg', 'jpeg', 'png']; // Valid file extensions
            $maxFileSize = 2 * 1024 * 1024; // Maximum file size in bytes (2MB)

            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadDirectory = 'public/uploads/NPC_img/';

            // Verify file conditions
            if (!in_array($fileExtension, $validExtensions)) {
                $this->errors[] = "We only accept 'jpg', 'jpeg' or 'png' format";
            }
            if ($fileSize >= $maxFileSize) {
                $this->errors[] = "The NPC's photo should be under 2MB of size.";
            }
        } else {
            $photoNPC = false;
            $newFileName = "default.png";
        }

        if (count($this->errors) > 0) {
            return false;
        } else {
            if ($photoNPC) {
                move_uploaded_file($fileTmpPath, $uploadDirectory . $newFileName);
            }
            return $newFileName;
        }
    }
}
