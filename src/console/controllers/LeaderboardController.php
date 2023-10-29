<?php
namespace mesusah\crafttryhackme\console\controllers;

use Craft;
use yii\console\ExitCode;
use craft\helpers\Console;
use craft\console\Controller;
use mesusah\crafttryhackme\TryHackMe;
use mesusah\crafttryhackme\models\Country;


class LeaderboardController extends Controller
{   
    public function actionImport()
    {
        // Get complete list of country leaderbards to import
        $country_id = TryHackMe::getInstance()->getSettings()->country;
        $country_ids = TryHackMe::getInstance()->getSettings()->countryCompetition;
        if(!in_array($country_id, $country_ids)) {
            array_push($country_ids, $country_id);
        }

        // Find country models and import leaderboards
        $countries = Country::find()->where(['in', 'id', $country_ids])->all();
        foreach ($countries as $country) {
            $this->stdout("Importing leaderboard for " . $country->name . "... \t");
            TryHackMe::getInstance()->leaderboard->importLeaderboard($country);
            $this->stdout("Done" . PHP_EOL, Console::FG_GREEN);
        }

        return ExitCode::OK;
    }
}