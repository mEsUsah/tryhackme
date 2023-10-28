<?php

namespace mesusah\crafttryhackme\models;

use Craft;
use craft\db\ActiveRecord;

class UserScore extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tryhackme_user_score}}';
    }
}
