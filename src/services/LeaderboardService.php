<?php

namespace mesusah\crafttryhackme\services;

use Craft;
use craft\base\Component;
use mesusah\crafttryhackme\TryHackMe;
use mesusah\crafttryhackme\models\Country;
use mesusah\crafttryhackme\models\User;

class LeaderboardService extends Component
{
    private $webEndpoint = "https://tryhackme.com";
    private $assetsEndpoint = "https://assets.tryhackme.com";
    private $cacheDuration = 3600;
    
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Haxor::getInstance()->thm->getScoreboard($locations)
     *
     * @return mixed
     */

    public function getScoreBoardUpdate()
    {
        $cacheKey = md5("tryHackMeScoreboardUpdated");
        $updatedTime = Craft::$app->cache->get($cacheKey);
        if ($updatedTime != null ) {
            return $updatedTime;
        }
        return null;
    }

    /**
     * Get the scoreboard for a list of locations
     * @param array $locations
     * @param bool $cache
     * @return array
     */
    public function getScoreboards($locations, $cache=true)
    {
        $locationsString = implode(",", $locations);
        $cacheKey = md5("tryHackMeScoreboard_" . $locationsString);
        $cachedData = Craft::$app->cache->get($cacheKey);
        if (!$cache || $cachedData != null ) {
            return $cachedData;
        }
        
        $returnArray = [
            "updated" => date("c"),
            "contries" => array(),
            "scoreboard" => array()
        ];

        Craft::$app->cache->set(
            md5("tryHackMeScoreboardUpdated"), 
            $returnArray['updated'], 
            $this->cacheDuration
        );

        foreach ($locations as $location) {
            array_push($returnArray["contries"], $location);

            $ranks = $this->getScoreboard($location);
            foreach ($ranks as $rank){
                array_push($returnArray["scoreboard"], $rank);
            }
        }

        usort($returnArray["scoreboard"], function ($item1, $item2) {
            return $item2['points'] <=> $item1['points'];
        });
        
        Craft::$app->cache->set($cacheKey, $returnArray, $this->cacheDuration);
        return $returnArray;
    }

    /**
     * Get the scoreboard for a specific location
     * 
     * @param string $location
     * @param bool $cache
     * @return array
     */
    public function getScoreboard($location, $cache=true)
    {
        $cacheKey = md5("tryHackMeScoreboard_" . $location);
        $cachedData = Craft::$app->cache->get($cacheKey);
        if ($cache && $cachedData != null ) {
            return $cachedData;
        }
        
        $url = "{$this->webEndpoint}/api/leaderboards?country={$location}";
        $_h = curl_init();
        curl_setopt($_h, CURLOPT_HEADER, false);
        curl_setopt($_h, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($_h, CURLOPT_HTTPGET, 1);
        curl_setopt($_h, CURLOPT_URL, $url );
        curl_setopt($_h, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
        curl_setopt($_h, CURLOPT_DNS_CACHE_TIMEOUT, 2 );

        $result = json_decode(curl_exec($_h), true);
        $data = $result["ranks"];
        Craft::$app->cache->set($cacheKey, $data, $this->cacheDuration);
        return $data;
    }

    /**
     * Import the scoreboard for a specific location to database
     * 
     * @param string $location
     * @return void
     */
    public function importLeaderboard($country_id)
    {
        // get all users in scoreboard
        $location = Country::find()->where(['id' => $country_id])->one()->handle;
        $ranks = $this->getScoreboard($location);
        
        $importCount = 0;
        $updateCount = 0;

        try {
            // Find/create user in database
            foreach ($ranks as $rank){
                $user = User::find()->where(['name' => $rank['username']])->one();
                if ($user == null) {
                    $user = new User();
                    $user->name = $rank['username'];
                    $user->avatar = $rank['avatar'];
                    $user->country_id = $country_id;
                    $user->save();
                    $importCount++;
                } else {
                    $user->avatar = $rank['avatar'];
                    $user->save();
                    $updateCount++;
                }
            }
        } catch (\Throwable $th) {
            return [
                'error' => $th->getMessage(),
                'users' => [
                    'import' => $importCount, 
                    'update' => $updateCount
                ]
            ];
        }

        return [
            'users' => [
                'import' => $importCount, 
                'update' => $updateCount
            ]
        ];
    }
}
