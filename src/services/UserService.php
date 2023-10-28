<?php

namespace mesusah\crafttryhackme\services;

use craft\base\Component;
use mesusah\crafttryhackme\TryHackMe;

class UserService extends Component
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
        $data = [
            'userName' => $username,
        ];

        // Get user rank, score and avatar
        $data = array_merge($data, $this->getUserRank($username));
         
        // Get all badges
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

        // Check if user has earned any badges
        $earnedBadges = $this->getBadgesUser($username);
        foreach ($earnedBadges as $badge) {
            if(isset($data['badges'][$badge['name']])) {
                $data['badges'][$badge['name']]['earned'] = true;
            }
        }

        // Get completed rooms
        $data['completedRooms'] = $this->getCompletedRooms($username);


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

    /**
     * Get users badges from the TryHackMe API
     * 
     * @param string $username
     * @return array
     */
    public function getBadgesUser($username)
    {
        $url = "{$this->webEndpoint}/api/badges/get/{$username}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $output = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($output, true);
        return $json;
    }

    /**
     * Get users badges from the TryHackMe API
     * 
     * @param string $username
     * @return array
     */
    public function getCompletedRooms($username)
    {
        $url = "{$this->webEndpoint}/api/all-completed-rooms?username={$username}&limit=1000";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $output = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($output, true);
        return $json;
    }
}
