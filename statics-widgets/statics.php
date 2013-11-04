<?php

error_reporting(E_ALL);

/*
Plugin Name: statistics_widgets
Plugin URI: http://example.com
Description: a amazing statistics widget
Author Name: roman-ul-ferdosh
Author URI: http://example.com
Version:1.0
*/  


class Statistics extends WP_Widget{


	function __construct(){

		$params = array(
			'description' => 'An amazing statistics widget',
			'name' => 'Statistics'
			);

		parent::__construct('Statistics','',$params);

	}


	public function form($instance){
		print_r($instance);
		extract($instance);

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php if(isset($title)) echo esc_attr('title'); ?>"/>

		</p>

		<p>
			<label for="<?php echo $this->get_field_id('statistics'); ?>">Statistics Option</label>
			<input
				class="widefat"
				id="<?php echo $this->get_field_id('statistics'); ?>"
				name="<?php echo $this->get_field_name('statistics'); ?>"
				value="<?php if(isset($statistics)) echo esc_attr('statistics'); ?>"/>

		</p>
		<?php

	}


	public function widget($atts,$instance){
		//print_r($atts);
		//print_r($instance);

		extract($atts);
		extract($instance);


		//echo $statistics;
		$title = strtolower($statistics);

		$data = $this->wp_get_count($title);		

	}

	private function wp_get_count($title){

		global $wpdb;
		$count = 0;
		$format = '1';
		$extra='1';

		switch ($title) {
			case 'posts':
				$count = wp_count_posts('post');
            	$count = $count->publish;
				break;

			case 'posts_by_author':
	        case 'posts_by_user':
	            $query = "SELECT count(*) FROM $wpdb->posts";
	            $where = "WHERE post_type='post' AND post_status='publish' AND post_author='$extra' ";
	            $count = $wpdb->get_var($query.$where);
	            break;

	        case 'pages':
	            $count = wp_count_posts('page');
	            $count = $count->publish;
	            break;    

	        case 'tags':
	            $count = wp_count_terms('post_tag');
	            break;

	        case 'categories':
	            $count = wp_count_terms('category');
	            break;    

	        case 'users':
	            $count = count_users();
	            $count = $count['total_users'];
	            break;  

	        case 'ms_users':
	            $count = get_user_count();
	            break;

	        case 'blogroll':
	            $query = "SELECT count(*) FROM $wpdb->links ";
	            $where = "WHERE link_visible='Y' ";
	            $count = $wpdb->get_var($query.$where);
	            break;

	        case 'blogroll_categories':
	            $count = wp_count_terms('link_category');
	            break;

	        case 'commenters':
	            $query = " SELECT count(DISTINCT comment_author) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='1' AND comment_type='' ";
	            $count = $wpdb->get_var($query.$where);
	            break; 

	        case 'comments':
	            $query = " SELECT count(*) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='1' AND comment_type='' ";
	            $count = $wpdb->get_var($query.$where);
	            break;  

	        case 'comments_pending':
	            $query = " SELECT count(*) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='0' AND comment_type='' ";
	            $count = $wpdb->get_var($query.$where);
	            break;

	        case 'comments_spam':
	            $query = " SELECT count(*) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='spam' AND comment_type='' ";
	            $count = $wpdb->get_var($query.$where);
	            break;                              

	        case 'comments_pingback':
	        case 'comments_pingbacks':
	        case 'comments_trackback':
	        case 'comments_trackbacks':
	            $query = " SELECT count(*) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='1' AND comment_type='pingback' ";
	            $count = $wpdb->get_var($query.$where);
	            break;  

	        case 'commenters_by_user':
	            $query = " SELECT count(*) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='1' AND comment_type='' AND user_id='$extra' ";
	            $count = $wpdb->get_var($query.$where);
	            break;  

	        case 'commenters_by_author':
	        case 'comments_by_nicename':
	            $query = " SELECT count(*) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='1' AND comment_type='' AND comment_author='$extra' ";
	            $count = $wpdb->get_var($query.$where);
	            break;     

	        case 'comments_by_email':
	            $query = " SELECT count(*) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='1' AND comment_type='' AND comment_author_email='$extra' ";
	            $count = $wpdb->get_var($query.$where);
	            break;   

	        case 'comments_per_post':
	            $posts_count = wp_count_posts('post');
	            $posts_count = $posts_count->publish;

	            $query = " SELECT count(*) FROM $wpdb->comments ";
	            $where= " WHERE comment_approved='1' AND comment_type=''";
	            $comment_count = $wpdb->get_var($query.$where);

	            return round($comment_count/$posts_count,$extra);
	            break;	
			
			default:
	            $count = 0;
	            break;
		}

		if ($format) {$count = number_format_i18n($count);}  
		echo "counted statistics...EOL $title :: $count";
        	return $count;
	}


}




add_action('widgets_init','roman_register_statistics');


function roman_register_statistics(){

	register_widget('Statistics');

}

 ?>