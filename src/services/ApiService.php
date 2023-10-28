<?php
/**
 * haxor plugin for Craft CMS 3.x
 *
 * Plugin for haxor.no
 *
 * @link      haxor.no
 * @copyright Copyright (c) 2023 Stanley Skarshaug
 */

 namespace mesusah\crafttryhackme\services;

use mesusah\crafttryhackme\TryHackMe;

use Craft;
use craft\base\Component;

class ApiService extends Component
{
    /**
     * Get the user rank from the TryHackMe API
     * 
     * @param string $username
     * @return array
     */
    public function getUserRank($username)
    {
        $url = "https://tryhackme.com/api/discord/user/{$username}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $output = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($output, true);
        return $json;
    }
}
