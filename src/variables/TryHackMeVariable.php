<?php

namespace mesusah\crafttryhackme\variables;

use Craft;
use mesusah\crafttryhackme\TryHackMe;

/**
 * haxor Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.tryhackme }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    mEsUsah
 * @package   TryHackMe
 * @since     1.0.0
 */
class TryHackMeVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.tryhackme.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.tryhackme.exampleVariable(twigValue) }}
     *     {{ craft.tryhackme.getTryHackMeScoreboard($locations) }}
     *
     * @param null $optional
     * @return string
     */
    
    /** 
     * This will return the configured username from the plugin settings
     * Call this variable from a template with
     * 
     *     {{ craft.tryhackme.username }}
     * 
     * @param null
     * @return string
    */
    public function username()
    {
        return TryHackMe::getInstance()->getSettings()->username;
    }
}
