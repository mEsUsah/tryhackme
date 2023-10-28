<?php

namespace mesusah\crafttryhackme\models;

use Craft;
use craft\base\Model;
use mesusah\crafttryhackme\models\Country;

/**
 * TryHackMe settings
 */
class Settings extends Model
{
    public $username = '';
    public $country = '';

    public function data(){
        $countries = Country::find()->all();
        $data = [
            'countries' => []
        ];

        foreach($countries as $country){
            $data['countries'][$country->id] = $country->name;
        }

        return $data;
    }
}
