<?php

namespace mesusah\crafttryhackme\models;

use Craft;
use craft\db\ActiveRecord;

class Country extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tryhackme_country}}';
    }
}
