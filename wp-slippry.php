<?php
 
/*
Plugin Name: WP Slippry Slider
Plugin URI: https://github.com/codebangla/wp-slippry-slider
Description: Slippry A Resposive Silder for WordPress
Author: Md. Sajedul Haque Romi
Version: 1.0
Author URI: http://codebangla.com
*/
 
?>
<?php

//enqueuing css and js files

define('CBWPS_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
wp_enqueue_style('WP_Slippry_demo_css', CBWPS_PATH.'css/demo.css');
wp_enqueue_style('WP_Slippry_css', CBWPS_PATH.'css/slippry.css');

wp_enqueue_script('WP_Slippry_js', CBWPS_PATH.'js/slippry.min.js', array('jquery'));

//jquery call of slippry added

function cbwps_script(){
 ?>

                <script>
			jQuery(document).ready(function($) {
                        "use strict";
				$("#demo1").slippry({
					transition: 'fade',
					useCSS: true,
					speed: 1000,
					pause: 3000,
					auto: true,
					preload: 'visible'
				});

				
			});
		</script>

			
</script>
 <?php
}
 
add_action('wp_footer', 'cbwps_script');

//custom post type
define('CPT_NAME', "Slippry Slider");
define('CPT_SINGLE', "Slippry slider");
define('CPT_TYPE', "slider-image");
 
add_theme_support('post-thumbnails', array('slider-image'));

function cbwps_register() { 
    $args = array( 
        'label' => __(CPT_NAME), 
        'singular_label' => __(CPT_SINGLE), 
        'public' => true, 
        'show_ui' => true, 
        'capability_type' => 'post', 
        'hierarchical' => false, 
        'rewrite' => true, 
        'supports' => array('title', 'editor', 'thumbnail') 
       ); 
   
    register_post_type(CPT_TYPE , $args ); 
} 
 
add_action('init', 'cbwps_register');

// silder contents
function cbwps_get_slider(){
 
$slider= '<section class="demo_wrapper">
    <article class="demo_block">
      <ul id="demo1">';
 
    $cbwps_query= "post_type=slider-image";
    query_posts($cbwps_query);
     
     
    if (have_posts()) : while (have_posts()) : the_post();
        $attr = array(
	'alt' => get_the_title()
        );
        $img= get_the_post_thumbnail( $post->ID, 'large', $attr );
        $slider.='<li><a href="#slide">'.$img.'</a></li>';
             
    endwhile; endif; wp_reset_query();
    $slider.= '</ul>
        </article>
    </section>';
    return $slider;
 
}
 
 
/**add the shortcode for the slider- for use in editor**/
 
function cbwps_insert_slider($atts, $content=null){
 
$slider= cbwps_get_slider();
 
return $slider;
 
}
 
 
add_shortcode('wp_slippry', 'cbwps_insert_slider');
 
 
 
/**add template tag- for use in themes**/
 
function cbwps_slider(){
 
    echo cbwps_get_slider();
}


?>
