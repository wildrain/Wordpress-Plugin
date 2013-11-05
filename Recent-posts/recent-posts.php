<?php

error_reporting(E_ALL);

/*
Plugin Name: recent_posts
Plugin URI: http://example.com
Description: a amazing recent posts widget for adaptive framework
Author Name: roman-ul-ferdosh
Author URI: http://example.com
Version:1.0
*/  


class Recent_posts extends WP_Widget{


	function __construct(){

		$params = array(
			'description' => 'a amazing recent posts widget for adaptive framework',
			'name' => 'Adaptive_recent_posts'
			);

		parent::__construct('Recent_posts','',$params);

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
			<label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts : </label>
			<input
				type="number"
				class="widefat"
				min="3"
				max="10"
				id="<?php echo $this->get_field_id('post_number'); ?>"
				name="<?php echo $this->get_field_name('post_number'); ?>"
				value="<?php echo !empty($post_number)? $post_number: 5; ?>"/>

		</p>

		<p>
			<label for="<?php echo $this->get_field_id('post_length'); ?>">Length of Description : </label>
			<input
				type="number"
				class="widefat"
				min="10"
				max="50"
				id="<?php echo $this->get_field_id('post_length'); ?>"
				name="<?php echo $this->get_field_name('post_length'); ?>"
				value="<?php echo !empty($post_length)? $post_length: 30; ?>"/>

		</p>

		<p>
			<input
				type="checkbox"
				class="checkbox"
				id="<?php echo $this->get_field_id('disable_thumbnail'); ?>"
				name="<?php echo $this->get_field_name('disable_thumbnail'); ?>"
				<?php checked( $disable_thumbnail ); ?>
			/>
			<label for="<?php echo $this->get_field_id('disable_thumbnail'); ?>">Disable Thumbnail</label>
		</p>
		<?php

	}


	function widget($args, $instance) {
		
		extract($args);
		extract($instance);

		$title = !empty($title)? $title: 'Recent_posts';
		
		$query = array(
					'showposts' => $post_number,
					'nopaging'  => 0,
					'no_found_rows' => true,
					'post_status' => 'publish',
					'ignore_sticky_posts' => 1 
			);

		$query_posts = new WP_Query($query);

		?>

		<?php if($query_posts->have_posts()):  ?>

			<?php echo $before_widget; ?>
			<h3><?php if($title) echo $title; ?></h3>

			<ul class="post-list">

				<?php while($query_posts->have_posts()): $query_posts->the_post(); ?>

				<li>
					<div class="post-info">

						<?php if(!$disable_thumbnail): ?>
							<a class="thumbnail" href="<?php get_permalink(); ?>" title="<?php the_title(); ?>">
								<?php if(has_post_thumbnail()): ?>
									<?php the_post_thumbnail(array(65,65),array('title'=>get_the_title(),'alt'=>get_the_title())); ?>
								<?php else: ?>
									<img src="http://placehold.it/65x65" width="65" height="65" title="<?php the_title();?>" alt="<?php the_title();?>"/>
								<?php endif; ?>	
							</a>
						<?php endif; ?>

						<h6><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr(get_the_title()? get_the_title() : get_the_ID()); ?> "> <?php if(get_the_title()) the_title();else the_ID(); ?></a></h6>
						<time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time>
						<p><?php echo wp_html_excerpt(get_the_excerpt(),$post_length); ?></p>

					</div>
				</li>

				<?php endwhile; ?>
			</ul>

		<?php endif; ?>
		<?php

	
	}

	public function update($new_instance,$old_instance){

		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_number'] = (int)strip_tags($new_instance['post_number']);
		$instance['post_length'] = (int)strip_tags($new_instance['post_length']);
		$instance['disable_thumbnail'] = !empty($new_instance['disable_thumbnail']) ? 1:0;

		return $instance;

	}


}




add_action('widgets_init','roman_register_recent_posts');


function roman_register_recent_posts(){

	register_widget('Recent_posts');

}

 ?>
