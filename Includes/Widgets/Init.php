<?php 
namespace Includes\Widgets;
require_once(__DIR__.'/GoogleAlbumsWidget.php');
require_once(__DIR__.'/YoutubeLastVideo.php');
require_once(__DIR__.'/LoadingScreenWidget.php');
class Init{
    public function register(){
        /**
         * hook wedgit
         */
        add_action('widgets_init' , [$this, 'register_google_albums_wedgit']);
    }


    public function register_google_albums_wedgit(){
        register_widget('\\Includes\\Widgets\\GoogleAlbumsWidget');
        register_widget('\\Includes\\Widgets\\YoutubeLastVideo');
        register_widget('\\Includes\\Widgets\\LoadingScreenWidget');
    }
}