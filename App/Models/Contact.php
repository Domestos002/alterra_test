<?php

namespace App\Models;

use Core\Model;
use PDO;

class Contact extends Model {

    public $tableName = 'contact';

    public function fields() {
        return ['name', 'phone'];
    }

    public function rules()
    {
        return [
          ['phone', 'required', 'Телефон обязателен для заполнения'],
          ['name', 'required', 'Имя обязателено для заполнения']
        ];
    }
}
