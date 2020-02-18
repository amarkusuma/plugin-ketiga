<?php
// session_start();
// if (!isset($_SESSION['random'])) {
//     $_SESSION['random'] = rand(2, 4);
// }

class testimonial_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            // ID widget
            'testimonial_widget',
            // nama widget
            __('Widget testimonial', ' testimonial_widget'),
            // deskripsi widget
            array('description' => __('Widget testimonial', 'testimonial_widget'),)
        );
    }

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        //if title is present
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        global $wpdb;
        // $id = rand(2, 4);
        // $random = $_SESSION['random'];
        global $blog_id;
        $myrows = $wpdb->get_results("SELECT * from komentar where blog_id='$blog_id' ORDER BY rand() LIMIT 1 ");
        foreach ($myrows as $data) {
            echo __($data->testimonial, 'testimonial_widget');
        }
    }

    public function form($instance)
    {
        if (isset($instance['title']))
            $title = $instance['title'];
        else
            $title = __('Default Title', 'testimonial_widget');
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input onclick="<?php session_destroy(); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

add_action('widgets_init', function () {
    register_widget('testimonial_widget');
});
