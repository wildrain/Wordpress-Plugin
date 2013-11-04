<?php

//error_reporting(E_ALL);

/*
Plugin Name: adaptive_tabbed_widgets
Plugin URI: http://example.com
Description: a amazing tabbed widgets widget for adaptive framework
Author Name: roman-ul-ferdosh
Author URI: http://example.com
Version:1.0
*/  

class roman_tabbed_widget extends WP_Widget{

    function __construct(){

        $params = array(
            'description' => 'An amazing tabbed widget for recent post , popular post, and random post type.it will review movie,game,and music',
            'name' => 'Adaptive_tabbed_widget'
            );

        parent::__construct('roman_tabbed_widget','',$params);

    }

    public function form($instance){
       
        $defaults = array(                       
                        'show_recent_posts'=>true,
                        'show_popular_posts'=>true,
                        'show_random_posts'=>true,
                        'num_recent_posts'=>10,
                        'num_popular_posts'=>10,
                        'num_random_posts'=>10
            );

        $instance = wp_parse_args(array($instance),$defaults);
       
        extract($instance);
        
        ?>

        <!-- html for form goes here
        ================================================== -->

        

        <p>
            <input
                type="checkbox"
                class="checkbox" 
                id="<?php echo $this->get_field_id('show_recent_posts'); ?>"
                name="<?php echo $this->get_field_name('show_recent_posts'); ?>"
                <?php checked(isset($instance['show_recent_posts'])? $instance['show_recent_posts'] : 0); ?>
            />Display 

            <input 
                id="<?php echo $this->get_field_id( 'num_recent_posts' ); ?>"
                name="<?php echo $this->get_field_name( 'num_recent_posts' ); ?>"
                value="<?php echo $instance['num_recent_posts']; ?>"
                style="width:30px"
             />recent posts     
           
        </p>


        <p>
            <input
                type="checkbox"
                class="checkbox" 
                id="<?php echo $this->get_field_id('show_popular_posts'); ?>"
                name="<?php echo $this->get_field_name('show_popular_posts'); ?>"
                <?php checked(isset($instance['show_popular_posts'])? $instance['show_popular_posts'] : 0); ?>
            />Display 

            <input 
                id="<?php echo $this->get_field_id( 'num_popular_posts' ); ?>"
                name="<?php echo $this->get_field_name( 'num_popular_posts' ); ?>"
                value="<?php echo $instance['num_popular_posts']; ?>"
                style="width:30px"
             />popular posts 
           
        </p>

         <p>
            <input
                type="checkbox"
                class="checkbox" 
                id="<?php echo $this->get_field_id('show_random_posts'); ?>"
                name="<?php echo $this->get_field_name('show_random_posts'); ?>"
                <?php checked(isset($instance['show_random_posts'])? $instance['show_random_posts'] : 0); ?>
            />Display 

            <input 
                id="<?php echo $this->get_field_id( 'num_random_posts' ); ?>"
                name="<?php echo $this->get_field_name( 'num_random_posts' ); ?>"
                value="<?php echo $instance['num_random_posts']; ?>"
                style="width:30px"
             />random posts
           
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



        <!-- end!!!!!!!form
        ================================================== -->
        
        


        <?php

    }

    public function widget($args,$instance){

        extract($args);
        extract($instance);
        
        ?>

        <div id="roman-tabbed">

            <ul class="tabnav">
                <?php if($show_recent_posts) { ?><li> <a href="#tabs-recent">recent</a></li><?php } ?>
                <?php if($show_popular_posts) { ?><li> <a href="#tabs-popular">popular</a></li><?php } ?>
                <?php if($show_random_posts) { ?><li> <a href="#tabs-random">random</a></li><?php } ?>
            </ul>


            <div class="tabdiv-wrapper">

                <!-- for movie reveiw
                ================================================== -->

                <?php if($show_recent_posts) {?>

                    <div id="tabs-recent" class="tabdiv">
                        <ul>
                            <?php

                                
                                $args=array(
                                        'suppress' => true,
                                        'posts_per_page' => $num_recent_posts,
                                        'post_type' => 'post',
                                        'post_status' => 'publish', 
                                        'no_found_rows' => true,                                        
                                        'ignore_sticky_posts' => 1 
                                    );

                                
                                $custom_loop = new WP_Query($args);

                                if ($custom_loop->have_posts()) : while ($custom_loop->have_posts()) : $custom_loop->the_post(); $postcount++;

                                             ?>
                                            
                                            <li> 
                                                <div class="r-image">
                                                    <?php if(!$disable_thumbnail): ?>
                                                        <a class="thumbnail" href="<?php get_permalink(); ?>" title="<?php the_title(); ?>">
                                                            <?php if(has_post_thumbnail()): ?>
                                                                <?php the_post_thumbnail(array(65,65),array('title'=>get_the_title(),'alt'=>get_the_title())); ?>
                                                            <?php else: ?>
                                                                <img src="http://placehold.it/65x65" width="65" height="65" title="<?php the_title();?>" alt="<?php the_title();?>"/>
                                                            <?php endif; ?> 
                                                        </a>
                                                    <?php endif; ?> 
                                                </div>
                                                <div class="text-content">                                                                                         
                                                    <a class="post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                                    <span><time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time></span>
                                                    <p><?php echo wp_html_excerpt(get_the_excerpt(),$post_length); ?></p>
                                                </div>     
                                            </li>


                                            <?php                                         


                                    endwhile;
                                endif; 
                                wp_reset_query();           
                             ?>
                             <li class="last gentesque tooltip" title="View all movie reviews"><a href="movie-reviews/">More</a></li>
                        </ul>
                    </div>

                <?php } ?>


                <!-- end movie review
                ================================================== -->


                <!-- for music reveiws
                ================================================== -->

                <?php if($show_popular_posts) { ?>
                    
                    <div id="tabs-popular" class="tabdiv">
                        <ul>
                            <?php // setup the query
                            $args=array(
                                        'suppress' => true,
                                        'posts_per_page' => $num_recent_posts,
                                        'post_type' => 'post',
                                        'post_status' => 'publish', 
                                        'no_found_rows' => true,
                                        'orderby' => 'comment_count',                                        
                                        'ignore_sticky_posts' => 1 
                                    );                                
                            $custom_loop = new WP_Query($args); 

                            if ($custom_loop->have_posts()) : 
                                while ($custom_loop->have_posts()) : 
                                    $custom_loop->the_post();
                                    $postcount++;                          
                                    

                                     ?>

                                        <li> 
                                            <div class="r-image">
                                                <?php if(!$disable_thumbnail): ?>
                                                    <a class="thumbnail" href="<?php get_permalink(); ?>" title="<?php the_title(); ?>">
                                                        <?php if(has_post_thumbnail()): ?>
                                                            <?php the_post_thumbnail(array(65,65),array('title'=>get_the_title(),'alt'=>get_the_title())); ?>
                                                        <?php else: ?>
                                                            <img src="http://placehold.it/65x65" width="65" height="65" title="<?php the_title();?>" alt="<?php the_title();?>"/>
                                                        <?php endif; ?> 
                                                    </a>
                                                <?php endif; ?> 
                                            </div>
                                            <div class="text-content">                                                                                         
                                                <a class="post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                                <span><time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time></span>
                                                <p><?php echo wp_html_excerpt(get_the_excerpt(),$post_length); ?></p>
                                            </div>     
                                        </li>
                                        
                                    <?php 

                                 endwhile; 
                            endif; 
                            wp_reset_query(); ?> 
                            
                            <li class="last gentesque tooltip" title="View all music reviews"><a href="music-reviews/">More</a></li>
       
                        </ul>
                    </div>
                    
                <?php } ?>


                <!-- end music reviews
                ================================================== -->


                <!-- for games reveiw
                ================================================== -->

                <?php if($show_random_posts) {?>

                    <div id="tabs-random" class="tabdiv">
                        <ul>
                            <?php

                                $args=array(
                                        'suppress' => true,
                                        'posts_per_page' => $num_random_posts,
                                        'post_type' => 'post',                                        
                                        'orderby' => 'rand',
                                        'no_found_rows' => true,
                                        'ignore_sticky_posts' => 1 
                                    ); 

                                $custom_loop = new WP_Query($args);

                                if($custom_loop->have_posts()) :
                                    while($custom_loop->have_posts()):
                                        $custom_loop->the_post();
                                            $postcount++;                                            

                                             ?>
                                            
                                            <li> 
                                                <div class="r-image">
                                                    <?php if(!$disable_thumbnail): ?>
                                                        <a class="thumbnail" href="<?php get_permalink(); ?>" title="<?php the_title(); ?>">
                                                            <?php if(has_post_thumbnail()): ?>
                                                                <?php the_post_thumbnail(array(65,65),array('title'=>get_the_title(),'alt'=>get_the_title())); ?>
                                                            <?php else: ?>
                                                                <img src="http://placehold.it/65x65" width="65" height="65" title="<?php the_title();?>" alt="<?php the_title();?>"/>
                                                            <?php endif; ?> 
                                                        </a>
                                                    <?php endif; ?> 
                                                </div>
                                                <div class="text-content">                                                                                         
                                                    <a class="post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                                    <span><time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time></span>
                                                    <p><?php echo wp_html_excerpt(get_the_excerpt(),$post_length); ?></p>
                                                </div>     
                                            </li>

                                            <?php                                         


                                    endwhile;
                                endif; 
                                wp_reset_query();           
                             ?>
                             <li class="last gentesque tooltip" title="View all movie reviews"><a href="movie-reviews/">More</a></li>
                        </ul>
                    </div>

                <?php } ?>


                <!-- end movie review
                ================================================== -->
                
                
            </div>


        </div>

        <?php





    }

    public function update($new_instance,$old_instance){

        $instance = $old_instance;

        
        $instance['show_recent_posts'] = strip_tags($new_instance['show_recent_posts']);
        $instance['show_popular_posts'] = strip_tags($new_instance['show_popular_posts']);
        $instance['show_random_posts'] = strip_tags($new_instance['show_random_posts']);
        $instance['num_recent_posts'] = strip_tags($new_instance['num_recent_posts']);
        $instance['num_popular_posts'] = strip_tags($new_instance['num_popular_posts']);
        $instance['num_random_posts'] = strip_tags($new_instance['num_random_posts']);
        $instance['post_length'] = (int)strip_tags($new_instance['post_length']);
        $instance['disable_thumbnail'] = !empty($new_instance['disable_thumbnail']) ? 1:0;

        return $instance;

    }


}



add_action('widgets_init','roman_register_tabbed_widget');

function roman_register_tabbed_widget(){
	register_widget('roman_tabbed_widget');
}
 ?>