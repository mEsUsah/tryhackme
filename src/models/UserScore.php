<?php

namespace mesusah\crafttryhackme\models;

use Craft;
use craft\db\ActiveRecord;
use mesusah\crafttryhackme\models\User;

class UserScore extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tryhackme_user_score}}';
    }

    public function user()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
