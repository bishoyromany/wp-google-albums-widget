<?php
/**
 * register function 
 */
function register_google_albums_wedgit(){
    register_widget('\\Includes\\Widgets\\GoogleAlbumsWidget');
}
/**
 * hook wedgit
 */
add_action('widgets_init' , 'register_google_albums_wedgit');