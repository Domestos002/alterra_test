<?php

namespace Core;
use \App\Helper;
use PDO;

/**
 * Base model
 *
 * PHP version 7.0
 */
abstract class Model
{
    public $errors = [];
    public $attributes = [];
    public $tableName;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->attributes[$key] = (object)[
                'value' => $value,
                'errors' => [],
            ];
        }
    }

    public function rules()
    {
        return [];
    }

    public function validate() {
        foreach ($this->rules() as $ruleString) {

            $field = $ruleString[0];
            $rule = $ruleString[1];
            $message = $ruleString[2];

            switch ($rule) {
                case 'required':
                    if(isset($this->attributes[$field])) {
                        if(trim($this->attributes[$field]->value) == '') {
                            array_push($this->errors, $message);
                        }
                    }
                    break;
            }
        }

        return empty($this->errors);
    }

    public function getAll()
    {
        $db = Helper::getDB();
        $stmt = $db->query("SELECT * FROM " . $this->tableName);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
