<?php
/*
Plugin Name: HT Feedback
Plugin URI: http://www.helpfultechnology.com
Description: Widget to display feedback form
Author: Luke Oatham
Version: 0.1
Author URI: http://www.helpfultechnology.com
*/

class htFeedback extends WP_Widget {
    function htFeedback() {
        parent::WP_Widget(false, 'HT Feedback', array('description' => 'Display feedback form. Requires Gravity Forms plugin.'));
    }

    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $formid = ($instance['formid']);
							echo $before_widget; 
							if ( !$title ) {
								$title="Is something wrong with this page?";
							}
?>
<h3>
<a  data-toggle="collapse" data-target="#feedbackform">
<?php echo $title ; ?>
</a>
</h3>

<div id="feedbackform" class="collapse out">

								<?php gravity_form($formid, false, true, false, '', true); ?>
</div>


<?php

						echo $after_widget; 

    }

    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['formid'] = strip_tags($new_instance['formid']);

       return $instance;
    }

    function form($instance) {
        $title = esc_attr($instance['title']);
        $formid = esc_attr($instance['formid']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
          <label for="<?php echo $this->get_field_id('formid'); ?>"><?php _e('Gravity Form ID:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('formid'); ?>" name="<?php echo $this->get_field_name('formid'); ?>" type="text" value="<?php echo $formid; ?>" />


        </p>

        <?php 
    }

}

add_action('widgets_init', create_function('', 'return register_widget("htFeedback");'));

?>