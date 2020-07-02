<?php 
namespace Includes\Base;
use Includes\Base\Controller;
require_once(__DIR__.'/Controller.php');
class SettingsLinks extends Controller{
    public function register(){
        add_filter('plugin_action_links_'.$this->get_plugin_slug() , [$this, 'add_plugin_links']);
    }

    /**
     * add plugins links
     */
    public function add_plugin_links($links){
        // add custom links
        foreach($this->get_admin_links_pages() as $link){
            $settings_link = "<a href='admin.php?page=".$link['slug']."'>Settings</a>";
            $links[] = $settings_link;
        }
        return $links;
    }
}