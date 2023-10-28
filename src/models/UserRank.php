<?php

namespace mesusah\crafttryhackme\models;

use Craft;
use craft\db\ActiveRecord;

class UserRank extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tryhackme_user_rank}}';
    }
}
