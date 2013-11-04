<?php

/*
Plugin Name: youtube video
Plugin URI: http://example.com
Description: enjoy youtube video shortcode 
Author Name: roman-ul-ferdosh
Author URI: http://example.com
Version:1.0
*/ 


function roman_youtube_video($atts,$content){

	extract($atts);
	$atts = shortcode_atts(
		array(			
			'content' => !empty($content)? $content : 'Enjoy this video'
			),$atts);
	$return = $content;
	if($content)
		$return .= "</br></br>";

	$return .= '<iframe width="560" height="349" src="http://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe>';

	return $return;
}


add_shortcode('youtube','roman_youtube_video');

 ?>