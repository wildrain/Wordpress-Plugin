<?php 

error_reporting(E_ALL);

/*
Plugin Name: Custom_Post_Type
Plugin URI: http://example.com
Description: and amazing movie reveiw custom post type
Author Name: roman-ul-ferdosh
Author URI: http://example.com
Version:1.0
*/  

class Roman_Movies_Post_Type{

	public function __construct(){

		$this->register_post_type();
		$this-> taxonomies();
		$this->metaboxes();
		$this->another_metaboxes();

	}

	public function register_post_type(){

		$args = array(
			'labels' => array(
				'name' => 'Movies',
				'singular_name' => 'Movie',
				'add_new' => 'Add New Movie',
				'add_new_item' => 'Add New Movie',
				'edit_item' => 'Edit Item',
				'add_item' => 'Add new item',
				'view_item' => 'View Movie',
				'search_items' => 'Search Movie',
				'not_found' => 'No Movie Found',
				'not_found_in_trash' => 'No Movie Found in Trash'
				),
			'query_var' => 'movies',			
			'rewrite' => array(
				'slug' => 'movie/'
				),
			'public' => true,
			'supports' => array(
				'title',
				'thumbnail',
				'excerpt',
				//'custom-fields', 
				)

			);

		register_post_type('roman_movie',$args);
	}

	public function taxonomies(){

		$taxonomies = array();

		$taxonomies['genre'] = array(
			'hierarchical' => true,
			'query_var' => 'movie_genre',
			'rewrite' => array(
				'slug' => 'movies/genre'
				),
			'labels' => array(
				'name' => 'Genre',
				'singular_name' => 'Genre',
				'new_item_name' => 'Add New Genre',
				'add_new_item' => 'Add Genre',
				'edit_item' => 'Edit Genre',
				'update_item' => 'Update Genre',
				'all_items' => 'All Genre',
				'search_items' => 'Search Genre',
				'popular_items' => 'Popular Genre',
				'separete_items_with_comments' => 'Separae Genre with Comas',
				'add_or_remove_items' => 'Add or Remove Genre',
				'choose_from_most_used' => 'Choose from most used Genre'

				)
			);


		$taxonomies['studio'] = array(
			'hierarchical' => true,
			'query_var' => 'movie_studio',
			'rewrite' => array(
				'slug' => 'movies/Studios'
				),
			'labels' => array(
				'name' => 'Studios',
				'singular_name' => 'studio',
				'new_item_name' => 'Add New studio',
				'add_new_item' => 'Add studio',
				'edit_item' => 'Edit studio',
				'update_item' => 'Update studio',
				'all_items' => 'All studio',
				'search_items' => 'Search studio',
				'popular_items' => 'Popular studio',
				'separete_items_with_comments' => 'Separae studio with Comas',
				'add_or_remove_items' => 'Add or Remove studio',
				'choose_from_most_used' => 'Choose from most used studio'

				)
			);

		$this->register_all_taxonomies($taxonomies);
	}

	public function register_all_taxonomies($taxonomies){

		foreach ($taxonomies as $name => $arr) {
			register_taxonomy($name,array('roman_movie'),$arr);
		}
		
	}


	public function metaboxes(){

		add_action('add_meta_boxes',function(){

			//css id , title , cb function , page			
			add_meta_box('roman_movie_reveiw','Movie Reveiws','movie_review','roman_movie');

		});


		function movie_review($post){

			
			$values = get_post_custom($post->ID);
			//print_r($values);
			$movie = isset($values['movie_name'])? esc_attr($values['movie_name'][0]) : '';
			$year = isset($values['movie_release_year'])? esc_attr($values['movie_release_year'][0]) : '';
			$director = isset($values['director'])? esc_attr($values['director'][0]) : '';
			$writer = isset($values['writer'])? esc_attr($values['writer'][0]) : '';
			$stars = isset($values['stars'])? esc_attr($values['stars'][0]) : '';
			$length = isset($values['movie_length'])? esc_attr($values['movie_length'][0]) : '';
			$storyline = isset($values['movie_storyline'])? esc_attr($values['movie_storyline'][0]) : '';

			?>
				<p>
					<label for="movie_name">Movie Name : </label>
					<input type="text" class="widefat" id="movie_name" name="movie_name" value="<?php echo $movie; ?>" />
				</p>

				<p>
					<label for="movie_release_year">Movie Release Year : </label>
					<input type="text" class="widefat" id="movie_release_year" name="movie_release_year" value="<?php echo $year; ?>" />
				</p>

				<p>
					<label for="director">Director : </label>
					<input type="text" class="widefat" id="director" name="director" value="<?php echo $director; ?>" />
				</p>

				<p>
					<label for="writer">Writer : </label>
					<input type="text" class="widefat" id="writer" name="writer" value="<?php echo $writer; ?>" />
				</p>

				<p>
					<label for="stars">Stars : </label>
					<input type="text" class="widefat" id="stars" name="stars" value="<?php echo $stars; ?>" />
				</p>

				<p>
					<label for="movie_length">Movie length : </label>
					<input type="text" class="widefat" id="movie_length" name="movie_length" value="<?php echo $length; ?>" />
				</p>

				<p>
					<label for="movie_storyline">Storyline : </label>
					<textarea class="widefat" rows = "8" name="movie_storyline" id="movie_storyline"><?php echo $storyline; ?></textarea>
				</p>

			<?php
		}

		add_action('save_post',function($id){

			/*if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 

		    // if our nonce isn't there, or we can't verify it, bail 
		    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return; 
		     
		    // if our current user can't edit this post, bail  
		    if( !current_user_can( 'edit_post' ) ) return; */

		    $review_array = array(
		    	'movie_name',
		    	'movie_release_year',
		    	'director',
		    	'writer',
		    	'stars',
		    	'movie_length',
		    	'movie_storyline',
		    	'movie_image'
		    	);

		    $review_array_defaults = array(
		    	'movie_name' => 'None',
		    	'movie_release_year' => 'None',
		    	'director' => 'None',
		    	'writer' => 'None',
		    	'stars' => 'None',
		    	'movie_length' => 'None',
		    	'movie_storyline' => 'None',
		    	'movie_image' => 'None'
		    	);

		    /*$allowed_html = array(
		        'a' => array(
		            'href' => array(),
		            'title' => array()
		        ),
		        'em' => array(),
		        'strong' => array()
		    );*/


		    $review_array = wp_parse_args($review_array,$review_array_defaults);

		     foreach($review_array as $item) {
		        if( isset( $_POST[$item] ) )
		            update_post_meta( $id, $item, strip_tags($_POST[$item]) );
		    }



			/*if(isset($_POST['movie_name'])){
				update_post_meta($id,'movie_name',strip_tags($_POST['movie_name']));
			}

			if(isset($_POST['movie_release_year'])){
				update_post_meta($id,'movie_release_year',strip_tags($_POST['movie_release_year']));
			}

			if(isset($_POST['director'])){
				update_post_meta($id,'director',strip_tags($_POST['director']));
			}

			if(isset($_POST['writer'])){
				update_post_meta($id,'writer',strip_tags($_POST['writer']));
			}

			if(isset($_POST['stars'])){
				update_post_meta($id,'stars',strip_tags($_POST['stars']));
			}

			if(isset($_POST['movie_length'])){
				update_post_meta($id,'movie_length',strip_tags($_POST['movie_length']));
			}

			if(isset($_POST['movie_storyline'])){
				update_post_meta($id,'movie_storyline',strip_tags($_POST['movie_storyline']));
			}*/


		});
	}

	public function another_metaboxes(){
		add_action('add_meta_boxes','add_custom_meta_box');


		function add_custom_meta_box(){

		add_meta_box('custom_meta_box','Custom Meta Box','show_custom_meta_box','roman_movie');
		}

		function show_custom_meta_box($post){
			
			$values = get_post_custom($post->ID);
			print_r($values);

			$check = isset($values['my_meta_box_check']) ? esc_attr($values['my_meta_box_check']) : ''; 
			$selected = isset( $values['my_meta_box_select'] ) ? esc_attr( $values['my_meta_box_select'] ) : ''; 
			$movie_rating = isset( $values['movie_review_rating'] ) ? esc_attr( $values['movie_review_rating'] ) : '';
			$gallery_type = isset( $values['gallery_type'] ) ? esc_attr( $values['gallery_type'] ) : '';  
		    ?>
		    	<p> 
			        <input type="checkbox" id="my_meta_box_check" name="my_meta_box_check" <?php checked( $check,'on' ); ?> />  
			        <label for="my_meta_box_check">Do not check this</label>  
			    </p> 

			    <p>
			    	<label for="my_meta_box_select"> color : </label>
			    	<select  id="my_meta_box_select" name="my_meta_box_select">
			    		<option value="red" <?php echo selected( $selected, 'red' ); ?>>Red</option> 
            			<option value="blue" <?php echo selected( $selected, 'blue' ); ?>>Blue</option>
            			<option value="green" <?php echo selected( $selected, 'green' ); ?>>Green</option>
            			<option value="pink" <?php echo selected( $selected, 'pink' ); ?>>Pink</option>
			    	</select>
			    </p>

			    <p>
			    	<label for="movie_review_rating">Movie Rating : </label>
			    	<select style="width: 100px;" name="movie_review_rating" id="movie_review_rating">
			    		<?php
			    			for($rating = 5; $rating >= 1 ; $rating--){
			    				?>
			    					<option value="<?php echo $rating; ?>" <?php echo selected($rating,$movie_rating); ?>><?php echo $rating."stars" ?></option>
			    				<?php

			    			}
			    		?>
			    	</select>
			    </p>

			    <p>
			    	<label for="radio_button">Radio Button : </label></br></hr>
			    	<input type="radio" name="gallery_type" value="radio_button_01" <?php if ($gallery_type == 'radio_button_01') echo "checked=1";?>/> Radio 01<br/>
    				<input type="radio" name="gallery_type" value="radio_button_02" <?php if ($gallery_type == 'radio_button_02') echo "checked=1";?>/> Radio 02<br/>
    				<input type="radio" name="gallery_type" value="radio_button_03" <?php if ($gallery_type == 'radio_button_03') echo "checked=1";?>/> Radio 03<br/>
    				<input type="radio" name="gallery_type" value="radio_button_04" <?php if ($gallery_type == 'radio_button_04') echo "checked=1";?>/> Radio 04<br/>
			    </p>

		    <?php 
		   

			

			
		}


		add_action('save_post','save_custom_meta');

		function save_custom_meta($post_id){

			$chk = isset($_POST['my_meta_box_check'])? 'on': 'off';
			update_post_meta($post_id,'my_meta_box_check',$chk);

			if( isset( $_POST['my_meta_box_select'] ) )  
        		update_post_meta( $post_id, 'my_meta_box_select', esc_attr( $_POST['my_meta_box_select'] ) );

        	if( isset( $_POST['movie_review_rating'] ) )  
        		update_post_meta( $post_id, 'movie_review_rating', esc_attr( $_POST['movie_review_rating'] ) );

        	if( isset( $_POST['gallery_type'] ) )  
        		update_post_meta( $post_id, 'gallery_type', esc_attr( $_POST['gallery_type'] ) );
			
			 
		
		}




	}

	
}


add_action('init',function(){

	new Roman_Movies_Post_Type();
	include dirname(__FILE__).'/custom_post_type_shortcode.php';

});


 ?>