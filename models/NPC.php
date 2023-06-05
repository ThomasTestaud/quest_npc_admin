<?php

namespace Models;

class NPC extends Database
{

    //faire un fonction plus générique
    public function getAllNPC(): array | null
    {
        $req = "SELECT id, name, image FROM `npcs` ORDER BY name";

        $params = [];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function createNPC($name, $image): void
    {

        $req = "INSERT INTO `npcs`(`name`, `image`) VALUES (:name, :image)";

        $params = [
            'name' => $name,
            'image' => $image,
        ];

        $this->generic($req, $params);
    }

    public function deleteNPC($id): void
    {
        $req = "DELETE FROM `npcs` WHERE id = :id";

        $params = [
            'id' => $id,
        ];

        $this->generic($req, $params);
    }

    public function updateNPC($id, $name, $image): void
    {
        $req = "UPDATE `npcs` SET `name`= :name,`image`= :image WHERE id = :id";

        $params = [
            'id' => $id,
            'name' => $name,
            'image' => $image,
        ];

        $this->generic($req, $params);
    }
}
