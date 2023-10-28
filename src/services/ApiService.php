<?php

namespace mesusah\crafttryhackme\services;

use mesusah\crafttryhackme\TryHackMe;

use craft\base\Component;

class ApiService extends Component
{
    private $webEndpoint = "https://tryhackme.com";
    private $assetsEndpoint = "https://assets.tryhackme.com";

    /**
     * Get the user rank from the TryHackMe API
     * 
     * @param string $username
     * @return array
     */

     public function userData($username)
     {
         $data = $this->getUserRank($username);
         
         $badges = $this->getBadgesAll();
         foreach ($badges as $badge) {
             $data['badges'][$badge['name']] = [
                 'title' => $badge['title'],
                 'name' => $badge['name'],
                 'description' => $badge['description'],
                 'image' => $this->assetsEndpoint . $badge['image'],
                 'earned' => false,
             ];
         }

         return $data;
     }

    public function getUserRank($username)
    {
        $url = "{$this->webEndpoint}/api/discord/user/{$username}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $output = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($output, true);
        return $json;
    }

    /**
     * Get all badges from the TryHackMe API
     * 
     * @param null
     * @return array
     */
    public function getBadgesAll()
    {
        $url = "{$this->webEndpoint}/api/badges/get";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $output = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($output, true);
        return $json;
    }
}
