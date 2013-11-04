<?php
/*
Plugin Name: WPTuts Flickr
Plugin URI: http://wp.tutsplus.com
Description: Blah...
Version: 1.0
Author: George Gecewicz
Author URI: http://heyitsgeorge.com
*/

function wptuts_flickr_jquery() {
	wp_enqueue_script('jquery');
}
add_action('widgets_init','wptuts_flickr_jquery');

class WPTuts_Flickr extends WP_Widget {

	// constructor...
	function WPTuts_Flickr() {
    $widget_ops = array( 'classname' => 'wptuts-flickr', 'description' => __('A simple Flickr widget to demonstrate the Widget API.') );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'wptuts-flickr-widget' );
		$this->WP_Widget('wptuts-flickr-widget', __('WP Tuts Flickr Widget'), $widget_ops, $control_ops);
  }


	// displays/outputs the widgety goodness...
	function widget( $args, $instance ) {
 		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$flickrid = $instance['flickrid'];

		if ( $title )
			echo $before_title . $title . $after_title;

			// let's get into the javascript...
			?>

			<ul id="flickr">&nbsp;</ul>

			<script type="text/javascript">
				jQuery(document).ready(function($){
					$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?ids=<?php print $flickrid; ?>&lang=en-us&format=json&jsoncallback=?", function(data){
				          $.each(data.items, function(index, item){
				                $("<img/>").attr("src", item.media.m).appendTo("#flickr")
				                  .wrap("<li><a href='" + item.link + "'></a></li>");
				          });
				        });
				});
			</script>

			<?php

  }

	// handles...updating the widget...
	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title']);
		$instance['flickrid'] = strip_tags( $new_instance['flickrid']);

		return $instance;

	}


	function form( $instance ) {
		?>

		<!-- widget title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

	 <p>
			<label for="<?php echo $this->get_field_id('flickrid'); ?>"><?php _e('Your Flickr User ID:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('flickrid'); ?>" name="<?php echo $this->get_field_name('flickrid'); ?>" value="<?php echo $instance['flickrid']; ?>" />
	 		<small>Don't know your ID? Head on over to <a href="http://idgettr.com">idgettr</a> to find it.</small>
	 </p>


		<?php

	}




}

add_action('widgets_init','load_wptuts_flickr');

function load_wptuts_flickr() {
	register_widget('WPTuts_Flickr');
}

?>