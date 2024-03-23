<?php

namespace micro\models;

use yii\db\ActiveRecord;

class Blog extends ActiveRecord
{
    public static function tableName()
    {
        return '{{blog}}';
    }
}