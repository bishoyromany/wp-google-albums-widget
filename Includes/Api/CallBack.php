<?php 
namespace Includes\Api;
use Includes\Base\Controller;
require_once(__DIR__.'/../Base/Controller.php');

class CallBack{

    /**
     * return admin settings template page
     */
    public static function adminSettingsPage(){
        return require_once(Controller::template('Admin/settings.php'));
    }


    /**
     * album url field
     */
    public static function googleAlbumsSettings($input){
        return $input;
    }

    /**
     * album url field Section
     */
    public static function googleAlbumsSettingsSection(){
        // echo "this is my sectino";
    }

    /**
     * album url
     */
    public static function googleAlbumsSettingsAlbumUrl(){
        $value = esc_attr(get_option('album_url'));
        echo "<input type='text' class='regular-text' name='album_url' placeholder='Album URL' value='$value' />";
    }

    public static function googleAlbumsSettingsMaxImages(){
        $value = esc_attr(get_option('album_max_images'));
        echo "<input type='text' class='regular-text' name='album_max_images' placeholder='Album Max Show Images' value='$value' />";
    }
}