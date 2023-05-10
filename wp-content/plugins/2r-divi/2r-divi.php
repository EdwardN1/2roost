<?php
/*
Plugin Name: 2Roost styles and mods
Plugin URI: https://www.technicks.com
Description: General Additions for 2Roost site
Author: Edward Nickerson
License: GPLv2 or later
Version: 1.0.0
Author URI: https://www.technicks.com
*/

define('twordivi_FUNCTIONSPATH', plugin_dir_path( __FILE__ ) . 'includes/');
define('twordivi_PLUGINURI', plugin_dir_url( __FILE__ ));

foreach (glob(twordivi_FUNCTIONSPATH.'autoinc-*.php') as $filename)
{
    require_once ($filename);
}