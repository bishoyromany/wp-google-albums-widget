<?php 
namespace Includes\Widgets;
require_once(__DIR__.'/YoutubeApi.php');
require_once(__DIR__.'/../Base/Controller.php');
use Includes\Base\Controller;
use Includes\Widgets\YoutubeApi;
class YoutubeLastVideo extends \WP_Widget{
    public function __construct() {
        parent::__construct(
            'YoutubeLastVideo', // id
            esc_html__('Youtube Last Video Widget', 'gaw_domain'), // name  
            ['description' => esc_html__('Youtube Last Video Widget', 'gaw_domain')] // desc
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

        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'gawy_text_domain');
        $channel_url = !empty($instance['channel_url']) ? $instance['channel_url'] : esc_html__('', 'gawy_text_channel_url');
        $channel_id = !empty($instance['channel_id']) ? $instance['channel_id'] : esc_html__('', 'gawy_text_channel_id');
        $api_token = !empty($instance['api_token']) ? $instance['api_token'] : esc_html__('', 'gawy_text_api_token');

        return require_once(Controller::template('Widgets/youtube_last_video.php'));
        // echo esc_html__('Hello, World', 'gawy_text_domain');

        // whatever i want after wedgit </div> etc
        // outputs the content of the widget
    }
 
    public function form( $instance ) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'gawy_text_domain');
        $channel_url = !empty($instance['channel_url']) ? $instance['channel_url'] : esc_html__('', 'gawy_text_channel_url');
        $channel_id = !empty($instance['channel_id']) ? $instance['channel_id'] : esc_html__('', 'gawy_text_channel_id');
        $api_token = !empty($instance['api_token']) ? $instance['api_token'] : esc_html__('', 'gawy_text_api_token');
        ?>
            <!-- title -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_attr_e('Title', 'gawy_text_domain'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                type="text"
                value="<?php echo esc_attr($title); ?>"
                 />
            </p>

            <!-- channel id -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('channel_url')); ?>">
                    <?php echo esc_attr_e('Channel URL', 'gawy_text_channel_url'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('channel_url')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('channel_url')); ?>" 
                type="text"
                value="<?php echo esc_attr($channel_url); ?>"
                 />
            </p>

            <!-- channel id -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('channel_id')); ?>">
                    <?php echo esc_attr_e('Channel ID', 'gawy_text_channel_id'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('channel_id')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('channel_id')); ?>" 
                type="text"
                value="<?php echo esc_attr($channel_id); ?>"
                 />
            </p>

            <!-- API Token -->
            <p>
                <label 
                for="<?php echo esc_attr($this->get_field_id('api_token')); ?>">
                    <?php echo esc_attr_e('API Token', 'gawy_text_api_token'); ?>
                </label>

                <input class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('api_token')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('api_token')); ?>" 
                type="text"
                value="<?php echo esc_attr($api_token); ?>"
                 />
            </p>

        <?php 
        // outputs the options form in the admin
    }
 
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['channel_url'] = ( !empty( $new_instance['channel_url'] ) ) ? strip_tags( $new_instance['channel_url'] ) : '';
        $instance['channel_id'] = ( !empty( $new_instance['channel_id'] ) ) ? strip_tags( $new_instance['channel_id'] ) : '';
        $instance['api_token'] = ( !empty( $new_instance['api_token'] ) ) ? strip_tags( $new_instance['api_token'] ) : '';
        return $instance;
    }

    // add scripts 
    public function gaw_add_scripts(){
        // add main css 
        wp_enqueue_style('gawy-main-style' , plugins_url(). '/google-albums-widget/assets/css/wedgit/main.css');

        // add main js 
        wp_enqueue_script('gawy-main-javascript', plugins_url(). '/google-albums-widget/assets/js/wedgit/main.js');
    }
}