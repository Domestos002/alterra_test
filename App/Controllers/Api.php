<?php

namespace App\Controllers;

use App\Helper;
use PDO;

class Api extends \Core\Api
{
    public function indexAction()
    {
        $db = Helper::getDB();
        $stmt = $db->query("SELECT * FROM " . $this->requestParams['table']);

        $this->response($stmt->fetchAll(PDO::FETCH_ASSOC), 200);
    }

    public function viewAction()
    {
        $id = $this->requestParams['id'];

        if($id){
            $db = Helper::getDB();
            $stmt = $db->query("SELECT * FROM " . $this->requestParams['table'] . " WHERE  id =" . $id);
            if($stmt){
                $this->response($stmt->fetchAll(PDO::FETCH_ASSOC), 200);
            }
        }
    }

    public function createAction()
    {
        $obj = json_decode(file_get_contents('php://input'), TRUE);

        $modelName = "\App\Models\\".$this->requestParams['model'];

        $tableName = $this->requestParams['table'];

        $model = new $modelName($obj);

        $modelFields = array_map(function ($el) { return $el; }, $model->fields());

        $fields = implode(",", $modelFields);

        $fieldsValues = implode(",", array_map(function ($el) { return ':'.$el; }, $modelFields));

        $sql = "INSERT INTO ${tableName} (${fields}) VALUES (${fieldsValues})";

        $db = Helper::getDB();

        $stmt = $db->prepare($sql);

        foreach($modelFields as $el) {
            $stmt->bindValue(':'.$el, $obj[$el], PDO::PARAM_STR);
        }

        if($model->validate()) {
            if ($stmt->execute()) {
                $this->response('Data saved.', 200);
            } else {
                $this->response("Saving error", 500);
            }
        } else {
            $this->response($model->errors, 303);
        }
    }

    public function updateAction()
    {

    }

    public function deleteAction()
    {
        $id = $this->requestParams['id'];

        if($id) {
            $db = Helper::getDB();
            $sql = "DELETE FROM " . $this->requestParams['table'] . " WHERE  id =" . $id;
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $this->response('Data removed.', 200);
            } else {
                $this->response("Error", 500);
            }
        }
    }
}
