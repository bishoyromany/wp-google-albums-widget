<?php 
namespace Includes\Pages;
use Includes\Base\Controller;
use Includes\Api\SettingsApi;
require_once(__DIR__.'/../Base/Controller.php');
require_once(__DIR__.'/../Api/SettingsApi.php');
class Admin extends Controller{

    public $settings;

    private $adminPages = [
        'settings' => [
            'title' => 'Google Albums Widget',
            'name' => 'Google Albums',
            'slug' => 'google-albums-widget-settings',
            'role' => 'manage_options',
            'function' => '\\Includes\\Api\\CallBack::adminSettingsPage',
            'icon' => 'dashicons-format-image',
            'order' => 111,
            'subPages' => [ 
                [
                    'clone' => true,
                    'title' => 'Dashboard'
                ],
                [
                    'title' => 'INC',
                    'name' => 'INC',
                    'slug' => 'google-albums-widget-inc',
                    'role' => 'manage_options',
                    'function' => '\\Includes\\Api\\CallBack::adminSettingsPage',
                    'icon' => 'dashicons-format-image', 
                ]
            ]
        ],
    ];

    private $fields = [
        'settings' => [
            'option' => [
                [             
                    // the option group, we need it when we call settings_fields to get fields
                    'option_group' => 'google_albums_settings',
                    // option name is the option that stores at database 
                    'option_name' => 'album_url',
                    // call back function of the input
                    'callback' => '\\Includes\\Api\\CallBack::googleAlbumsSettings'
                ],
                [             
                    // the option group, we need it when we call settings_fields to get fields
                    'option_group' => 'google_albums_settings',
                    // option name is the option that stores at database 
                    'option_name' => 'album_max_images',
                    // call back function of the input
                    'callback' => '\\Includes\\Api\\CallBack::googleAlbumsSettings'
                ],
            ],
            'section' => [
                [            
                    // the section id
                    'id' => 'google_albums_settings',
                    // title of the section
                    'title' => 'Settings',
                    // adding custom html under the section title
                    'callback' => '\\Includes\\Api\\CallBack::googleAlbumsSettingsSection',
                    // the page that should be used in
                    'page' => "google-albums-widget-settings",
                ]
            ],
            'field' => [
                [            
                    'id' => 'album_url',
                    'title' => 'Album URL',
                    'callback' => '\\Includes\\Api\\CallBack::googleAlbumsSettingsAlbumUrl',
                    'page' => "google-albums-widget-settings",
                    'section' => "google_albums_settings",
                    'args' => [
                        'label_for' => 'album_url',
                        'class' => 'album_url',
                    ],
                ],
                [            
                    'id' => 'album_max_images',
                    'title' => 'Album Max Images',
                    'callback' => '\\Includes\\Api\\CallBack::googleAlbumsSettingsMaxImages',
                    'page' => "google-albums-widget-settings",
                    'section' => "google_albums_settings",
                    'args' => [
                        'label_for' => 'album_max_images',
                        'class' => 'album_max_images',
                    ],
                ],
            ]

        ]

    ];  

    public function __construct(){
        $this->settings = new SettingsApi;
    }

    public function register(){
        $this->settings->addPages($this->adminPages)->withSubPages(true)->addFields($this->fields)->register();
    }

}