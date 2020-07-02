<?php 
namespace Includes\Base;
use Includes\Base\Controller;
require_once(__DIR__.'/Controller.php');
class Enq{
    public function register(){
        // enqueue scripts and styles
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * require styles and js scripts
     */
    public static function enqueueAdminScripts(){
        wp_enqueue_style('GAWStylesAdmin', Controller::asset('css/admin/main.css'));
        wp_enqueue_script('GAWScriptsAdmin', Controller::asset('js/admin/main.js'));
    }

    /**
     * require styles and js scripts
     */
    public static function enqueueScripts(){
        wp_enqueue_style('GAWStyles', Controller::asset('css/main.css'));
        wp_enqueue_script('GAWScripts', Controller::asset('js/main.js'));
    }

}