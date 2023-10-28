<?php

namespace mesusah\crafttryhackme\variables;

use Craft;
use mesusah\crafttryhackme\TryHackMe;

class TryHackMeVariable
{
    
    /** 
     * This will return the configured username from the plugin settings
     * 
     * Call this variable from a template with
     * 
     *     {{ craft.tryhackme.userName }}
     * 
     * @param null
     * @return string
    */
    public function userName()
    {
        return TryHackMe::getInstance()->getSettings()->username;
    }

    /** 
     * This will return all data on the configured user
     * from the TryHackMe API
     * 
     * Call this variable from a template with
     * 
     *     {{ craft.tryhackme.userData }}
     * 
     * @param null
     * @return array
    */
    public function userData()
    {
        $username = TryHackMe::getInstance()->getSettings()->username;
        return TryHackMe::getInstance()->api->userData($username);
    }
}
