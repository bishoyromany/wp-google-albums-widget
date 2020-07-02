<?php 
namespace Includes\Plugin;
use Includes\Plugin\Admin\AdminPages;
class GAWActivePlugin{
    private $postTypes = [
        [
            'public' => true,
            'type' => 'sermon',
            'label' => 'Sermons',
        ],
        [
            'public' => true,
            'type' => 'book',
            'label' => 'Books',
        ],
    ];

    protected $settignsPage = 'google_album_wedgit_settings';

    public function register(){
        // enqueue scripts and styles
        add_filter('plugin_action_links_'.GAW_PLUGIN_NAME , [$this, 'addPluginLinks']);
        $this->activate();
        $admin = new AdminPages;
        $admin->addAdminMenu();
        $this->registerPostTypes();
    }


    /**
     * add plugins links
     */
    public function addPluginLinks($links){
        // add custom links
        $settings_link = "<a href='admin.php?page=".$this->settignsPage."'>Settings</a>";
        $links[] = $settings_link;
        return $links;
    }

    public function activate(){
        // flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * register post types
     */ 
    public function registerPostTypes(){
        foreach($this->postTypes as $type){
            register_post_type($type['type'], ['public' => $type['public'], 'label' => $type['label']]);
        }
    }
}