<?php
/**
 * @package Google Albums Wedgit
 * 
 * Plugin Name:       Google Albums Widget
 * Plugin URI:        https://example.com/
 * Description:       Google Albums Widget Plugin.
 * Version:           1.0.0
 * Author:            Bishoy Romany
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * 
 */

// don't let users access this file direct
defined('ABSPATH') or die('Hi there!  I\'m just a plugin, not much I can do when called directly.');

/**
 * the composer autoloader
 */
require_once(__DIR__.'/vendor/autoload.php');

require_once(__DIR__.'/Includes/Base/Activate.php');
require_once(__DIR__.'/Includes/Base/Deactivate.php');
require_once(__DIR__.'/Includes/Init.php');

/**
 * the blugin name 
 */
define('PLUGIN' , plugin_basename(__FILE__));

/**
 * code run when plugin activate
 */
function activate_google_albums_widget_plugin(){
    Includes\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_google_albums_widget_plugin');

/**
 * code run when plugin deactivate
 */
function deactivate_google_albums_widget_plugin(){
    Includes\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_google_albums_widget_plugin');

/**
 * autocall register method of registered classes to init class
 */
if(class_exists('Includes\\Init')){
    Includes\Init::register_services();
}