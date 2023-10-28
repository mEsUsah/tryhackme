<?php

namespace mesusah\crafttryhackme\models;

use Craft;
use craft\db\ActiveRecord;
use mesusah\crafttryhackme\models\Country;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tryhackme_user}}';
    }

    public function country()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
}
