<?php 
namespace Includes\Widgets;
require_once(__DIR__.'/googleAlbumAPI.php');
require_once(__DIR__.'/../Base/Controller.php');
use Includes\Base\Controller;
use Includes\Widgets\GoogleAlbumApi;
class GoogleAlbumsWidget extends \WP_Widget{
    public function __construct() {
        parent::__construct(
            'GoogleAlbumsWidget', // id
            esc_html__('Google Albums Widget', 'gaw_domain'), // name  
            ['description' => esc_html__('A Google Albums Widget', 'gaw_domain')] // desc
        );
        /**
         * hook the function 
         */
        add_action('wp_enqueue_scripts' , [$this,'gaw_add_scripts']);

    }
 
    public function widget( $args, $instance ) {
        // whatever i want before wedgit <div> etc

        // if(!empty($instance['title'])){
        //     echo $args['before_title'] . 
        //     apply_filters('widget_title', $instance['title']) . 
        //     $args['after_title'];
        // }

        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'gaw_text_domain');
        $album_url = !empty($instance['album_url']) ? $instance['album_url'] : esc_html__('https://photos.app.goo.gl/zR8nUz3JXLerfEFk7', 'gaw_text_album_url');
        $maximum_allowed_images = !empty($instance['maximum_allowed_images']) ? $instance['maximum_allowed_images'] : esc_html__(10, 'gaw_text_maximum_allowed_images');

        return require_once(Controller::template('Widgets/google_albums_widgets.php'));
        // echo esc_html__('Hello, World', 'gaw_text_domain');

        // whatever i want after wedgit </div> etc
        // outputs the content of the widget
    }
 
    public function form( $instance ) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'gaw_text_domain');
        $album_url = !empty($instance['album_url']) ? $instance['album_url'] : esc_html__('https://photos.app.goo.gl/zR8nUz3JXLerfEFk7', 'gaw_text_album_url');
        $maximum_allowed_images = !empty($instance['maximum_allowed_images']) ? $instance['maximum_allowed_images'] : esc_html__(10, 'gaw_text_maximum_allowed_images');
        ?>
            <!-- title -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_attr_e('Title', 'gaw_text_domain'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                type="text"
                value="<?php echo esc_attr($title); ?>"
                 />
            </p>

            <!-- album URL -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('album_url')); ?>">
                    <?php echo esc_attr_e('Album Url', 'gaw_text_album_url'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('album_url')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('album_url')); ?>" 
                type="text"
                value="<?php echo esc_attr($album_url); ?>"
                 />
            </p>

            <!-- maximum allowed images -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('maximum_allowed_images')); ?>">
                    <?php echo esc_attr_e('Maximum Allowed Images', 'gaw_text_maximum_allowed_images'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('maximum_allowed_images')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('maximum_allowed_images')); ?>" 
                type="number"
                value="<?php echo esc_attr($maximum_allowed_images); ?>"
                 />
            </p>

        <?php 
        // outputs the options form in the admin
    }
 
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['album_url'] = ( !empty( $new_instance['album_url'] ) ) ? strip_tags( $new_instance['album_url'] ) : '';
        $instance['maximum_allowed_images'] = ( !empty( $new_instance['maximum_allowed_images'] ) ) ? strip_tags( $new_instance['maximum_allowed_images'] ) : '';
        return $instance;
    }

    // add scripts 
    public function gaw_add_scripts(){
        // add main css 
        wp_enqueue_style('gaw-main-style' , plugins_url(). '/google-albums-widget/assets/css/wedgit/main.css');

        // add main js 
        wp_enqueue_script('gaw-main-javascript', plugins_url(). '/google-albums-widget/assets/js/wedgit/main.js');
    }
}