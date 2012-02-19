<?php

/**
 * Path to the root picon directory without a trailing slash
 * This is the directory containing PiconApplication
 */
define("PICON_DIRECTORY", __DIR__.'/podium/picon');

/**
 * Path to the assets directory in which the user
 * created classes reside
 */
define("ASSETS_DIRECTORY", __DIR__.'/podium/assets');

/**
 * Path to the config directory in which the xml config files
 * reside
 */
define("CONFIG_FILE", __DIR__.'/config/picon.xml');

/**
 * Path to the cache directory in which persisted resources
 * will be stored. This directory needs write access
 */
define("CACHE_DIRECTORY", __DIR__.'/cache');

require_once("podium/picon/PiconApplication.php");

use picon\PiconApplication;
use picon\PageClassAuthorisationStrategy;

class PodiumApplication extends PiconApplication
{
    public function init()
    {
        $this->getSecuritySettings()->setAuthorisationStrategy(new PodiumAuthorisationStrategory());
        $this->addPageMapInitializationListenerCollection(new PageMapMountingListener());
    }
}

//Create the application
$application = new PodiumApplication();
$application->run();



?>
