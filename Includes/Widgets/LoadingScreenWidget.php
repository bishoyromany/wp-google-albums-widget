<?php 
namespace Includes\Widgets;
require_once(__DIR__.'/googleAlbumAPI.php');
require_once(__DIR__.'/../Base/Controller.php');
use Includes\Base\Controller;
use Includes\Widgets\GoogleAlbumApi;
class LoadingScreenWidget extends \WP_Widget{
    public function __construct() {
        parent::__construct(
            'LoadingScreenWidget', // id
            esc_html__('Loading Screen Widget', 'gaw_domain'), // name  
            ['description' => esc_html__('A Loading Screen  Widget', 'gaw_domain')] // desc
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

        $stmary_image = !empty($instance['stmary_image']) ? $instance['stmary_image'] : esc_html__('http://minasidhom.com/wp-content/themes/Divi/images/church/logo.png', 'gaw_text_domain');
        $background_image = !empty($instance['background_image']) ? $instance['background_image'] : esc_html__('http://minasidhom.com/wp-content/uploads/2019/12/background-3.png', 'gaw_text_background_image');
        $overlay_color = !empty($instance['overlay_color']) ? $instance['overlay_color'] : esc_html__('#000', 'gaw_text_overlay_color');
        $first_circle_color = !empty($instance['first_circle_color']) ? $instance['first_circle_color'] : esc_html__('#eee', 'gaw_text_first_circle_color');
        $second_circle_color = !empty($instance['second_circle_color']) ? $instance['second_circle_color'] : esc_html__('lightskyblue', 'gaw_text_second_circle_color');

        return require_once(Controller::template('Widgets/screen_load_widget.php'));
        // echo esc_html__('Hello, World', 'gaw_text_domain');

        // whatever i want after wedgit </div> etc
        // outputs the content of the widget
    }
 
    public function form( $instance ) {
        $stmary_image = !empty($instance['stmary_image']) ? $instance['stmary_image'] : esc_html__('http://minasidhom.com/wp-content/themes/Divi/images/church/logo.png', 'gaw_text_domain');
        $background_image = !empty($instance['background_image']) ? $instance['background_image'] : esc_html__('http://minasidhom.com/wp-content/uploads/2019/12/background-3.png', 'gaw_text_background_image');
        $overlay_color = !empty($instance['overlay_color']) ? $instance['overlay_color'] : esc_html__('#000', 'gaw_text_overlay_color');
        $first_circle_color = !empty($instance['first_circle_color']) ? $instance['first_circle_color'] : esc_html__('#eee', 'gaw_text_first_circle_color');
        $second_circle_color = !empty($instance['second_circle_color']) ? $instance['second_circle_color'] : esc_html__('lightskyblue', 'gaw_text_second_circle_color');

        ?>
            <!-- title -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('stmary_image')); ?>">
                    <?php echo esc_attr_e('Stmary Image', 'gaw_text_domain'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('stmary_image')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('stmary_image')); ?>" 
                type="text"
                value="<?php echo esc_attr($stmary_image); ?>"
                 />
            </p>

            <!-- background image -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('background_image')); ?>">
                    <?php echo esc_attr_e('Background Image', 'gaw_text_background_image'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('background_image')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('background_image')); ?>" 
                type="text"
                value="<?php echo esc_attr($background_image); ?>"
                 />
            </p>

            <!-- maximum allowed images -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('overlay_color')); ?>">
                    <?php echo esc_attr_e('Overlay Color', 'gaw_text_overlay_color'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('overlay_color')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('overlay_color')); ?>" 
                type="text"
                value="<?php echo esc_attr($overlay_color); ?>"
                 />
            </p>

            <!-- maximum allowed images -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('first_circle_color')); ?>">
                    <?php echo esc_attr_e('First Circle Color', 'gaw_text_first_circle_color'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('first_circle_color')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('first_circle_color')); ?>" 
                type="text"
                value="<?php echo esc_attr($first_circle_color); ?>"
                 />
            </p>

            <!-- maximum allowed images -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('second_circle_color')); ?>">
                    <?php echo esc_attr_e('Second Circle Color', 'gaw_text_second_circle_color'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('second_circle_color')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('second_circle_color')); ?>" 
                type="text"
                value="<?php echo esc_attr($second_circle_color); ?>"
                 />
            </p>

        <?php 
        // outputs the options form in the admin
    }
 
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = array();
        $instance['stmary_image'] = ( !empty( $new_instance['stmary_image'] ) ) ? strip_tags( $new_instance['stmary_image'] ) : '';
        $instance['background_image'] = ( !empty( $new_instance['background_image'] ) ) ? strip_tags( $new_instance['background_image'] ) : '';
        $instance['overlay_color'] = ( !empty( $new_instance['overlay_color'] ) ) ? strip_tags( $new_instance['overlay_color'] ) : '';
        $instance['first_circle_color'] = ( !empty( $new_instance['first_circle_color'] ) ) ? strip_tags( $new_instance['first_circle_color'] ) : '';
        $instance['second_circle_color'] = ( !empty( $new_instance['second_circle_color'] ) ) ? strip_tags( $new_instance['second_circle_color'] ) : '';
        return $instance;
    }

    // add scripts 
    public function gaw_add_scripts(){
        // // add main css 
        // wp_enqueue_style('gaw-main-style' , plugins_url(). '/google-albums-widget/assets/css/wedgit/main.css');

        // // add main js 
        // wp_enqueue_script('gaw-main-javascript', plugins_url(). '/google-albums-widget/assets/js/wedgit/main.js');
    }
}