# Craft TryHackMe

TryHackMe ranking and score tracker for Craft CMS

## Requirements

This plugin requires Craft CMS 4.5.0 or later, and PHP 8.0.2 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

### Crontab
To automatically import daily leaderboards, add this to your crontab:
```bash
55 23 * * * <username> /path/to/project/root php craft tryhackme/leaderboard/import
```


#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “TryHackMe”. Then press “Install”.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require mesusah/craft-tryhackme

# tell Craft to install the plugin
./craft plugin/install tryhackme
```
