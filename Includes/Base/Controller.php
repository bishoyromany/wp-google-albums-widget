<?php 
namespace Includes\Base;

class Controller{
    protected $pluginAuthor = 'Bishoy Romany';

    protected $pluginVersion = '0.0.1';

    protected $pluginTitle = 'Google Albums Widget';
    
    protected $pluginSlug = PLUGIN;
    
    protected $postTypes = [
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

    protected $adminLinksPages = [
        'settings' => [
            'slug' => 'google-albums-widget-settings',
        ]
    ];


    public function get_post_types(){
        return $this->postTypes;
    }

    public function get_admin_links_pages(){
        return $this->adminLinksPages;
    }

    public function get_plugin_slug(){
        return $this->pluginSlug;
    }

    public static function asset($path){
        return plugins_url('/../../assets/'.$path, __FILE__);
    }

    public static function template($path){
        return __DIR__.'/../Templates/'.$path;
    }

}