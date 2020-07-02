<?php 
namespace Includes\Widgets;
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

        if(!empty($instance['title'])){
            echo $args['before_title'] . 
            apply_filters('widget_title', $instance['title']) . 
            $args['after_title'];
        }

        echo esc_html__('Hello, Worl', 'gaw_text_domain');

        // whatever i want after wedgit </div> etc
        // outputs the content of the widget
    }
 
    public function form( $instance ) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Google Albums Wedgit', 'gaw_text_domain');
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

        <?php 
        // outputs the options form in the admin
    }
 
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
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