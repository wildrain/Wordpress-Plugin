<?php 


function movie_list($attr,$content){

	$movies = array(
		'post_type' => 'roman_movie',
		'orderby' => 'title'
		);

	$loop = new WP_Query($movies);

	if($loop->have_posts()){

		//$output = '<ul class="roman_movie_list">';
		?>
			<ul class="roman_movie_list">
		<?php

		while($loop->have_posts()){
			$loop->the_post();

			$meta = get_post_meta(get_the_id(),'');			

			?>
			<li>
				<h3><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> | <?php echo $meta['movie_length'][0] ?> </a></h3>
				<div><?php echo $meta['movie_storyline'][0] ?> </div>

			</li>
			<hr class="fancy-hr" />
			<?php	

		}
	}

	//return $output;

 
}

add_shortcode('roman_movies','movie_list');
 ?>