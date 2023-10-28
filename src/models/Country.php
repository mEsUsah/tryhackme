<?php

namespace mesusah\crafttryhackme\models;

use Craft;
use craft\db\ActiveRecord;
use mesusah\crafttryhackme\models\User;

class Country extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tryhackme_country}}';
    }

    public function users()
    {
        return $this->hasMany(User::class, ['country_id' => 'id']);
    }
}
