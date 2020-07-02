<?php 
/**
 * @package Google Albums Wedgit
 * 
 * uninstall plugin file
 */
defined('WP_UNINSTALL_PLUGIN') or die("You Can't Access This Uninstall Part");

require_once(__DIR__.'/includes/plugin/GAWUninstallPlugin.php');


// clear database data
$unistall = new GAWUninstallPlugin;
$unistall->Uninstall();