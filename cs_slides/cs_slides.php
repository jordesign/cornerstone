<?php
/*
Plugin Name: CornerStone Slides
Plugin URI: http://www.jordesign.com/cornerstone
Description: Adds slideshow CTP and functionality. Part of the CornerStone framework .
Version: 1.0
Author: Jordan Gillman
Author URI: http://www.jordesign.com
License: GPLv2
*/
/*  This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Include ACF Lite (but only if ACF isn't installed somewhere else)
global $acf;
 
if( !$acf ){
    define( 'ACF_LITE' , true );
    include_once('advanced-custom-fields/acf.php' );
}

// Enqueue CSS
add_action( 'wp_enqueue_scripts', 'cs_slide_styles' );
function cs_slide_styles() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'csslides-style', plugins_url('style.css', __FILE__) );
    wp_enqueue_script('csslides-script', plugins_url('csslides.js', __FILE__) ,array( 'jquery' ) );
    wp_enqueue_style( 'csslides-style' );
}

//Add Default Slide size
add_image_size( 'cs_slide', 600, 300, true ); 


// Add CPT for Slides
if ( ! function_exists('cs_slide_type') ) {

// Register Custom Post Type
function cs_slide_type() {
	$labels = array(
		'name'                => _x( 'Slides', 'Post Type General Name', 'cornerstone' ),
		'singular_name'       => _x( 'Slide', 'Post Type Singular Name', 'cornerstone' ),
		'menu_name'           => __( 'Homepage Slideshow', 'cornerstone' ),
		'parent_item_colon'   => __( 'Parent Slide:', 'cornerstone' ),
		'all_items'           => __( 'All Slides', 'cornerstone' ),
		'view_item'           => __( 'View Slide', 'cornerstone' ),
		'add_new_item'        => __( 'Add New Slide', 'cornerstone' ),
		'add_new'             => __( 'New Slide', 'cornerstone' ),
		'edit_item'           => __( 'Edit Slide', 'cornerstone' ),
		'update_item'         => __( 'Update Slide', 'cornerstone' ),
		'search_items'        => __( 'Search Slides', 'cornerstone' ),
		'not_found'           => __( 'No Slides found', 'cornerstone' ),
		'not_found_in_trash'  => __( 'No Slides found in Trash', 'cornerstone' ),
	);
    $iconURL = plugins_url("slides.png", __FILE__);
	$args = array(
		'label'               => __( 'slide', 'cornerstone' ),
		'description'         => __( 'Slides for the Homepage slideshow', 'cornerstone' ),
		'labels'              => $labels,
		'supports'            => array( 'title', ),
		'taxonomies'          => array( '' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 20,
		'menu_icon'           => $iconURL,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);

	register_post_type( 'slide', $args );
}

// Hook into the 'init' action
add_action( 'init', 'cs_slide_type', 0 );

}

/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_slide-details',
		'title' => 'Slide Details',
		'fields' => array (
			array (
				'key' => 'field_51ab446731ef8',
				'label' => 'Slide Image',
				'name' => 'slide_image',
				'type' => 'image',
				'required' => 1,
				'save_format' => 'id',
				'preview_size' => 'medium',
			),
			array (
				'key' => 'field_51ab449631ef9',
				'label' => 'Slide Link',
				'name' => 'slide_link',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_51ab44ab31efa',
				'label' => 'Slide Caption',
				'name' => 'slide_caption',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slide',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}


// Function to output the slideshow in the theme
function cs_slides() { ?>
<div class="cs_slides_wrapper">
<div id="cs_slides">
  <?php // The Query
  $csslide_query = new WP_Query( 'post_type=slide&orderby=menu_order' );
  $count = 0;
  // The Loop
  if ( $csslide_query->have_posts() ) {
  	while ( $csslide_query->have_posts() ) {
  	    $count++;
  		$csslide_query->the_post(); ?>
  		
  		<div class="slide" id="slide<?php echo $count; ?>">
  		    <?php $attachment_id = get_field('slide_image');
  		    $size = apply_filters( 'csslide_size', "cs_slide" ); // (thumbnail, medium, large, full or custom size)
  		     $image = wp_get_attachment_image_src( $attachment_id, $size );

  		?>
  		    <a href="<?php the_field('slide_link'); ?>">
  		        <img src="<?php echo $image[0]; ?>" alt="<?php the_field('slide_caption'); ?>">
  		        <p><?php the_field('slide_caption'); ?></p>
  		    </a>
  		    
  		</div>
  		
  	<?php } ?>

 <?php } else {
  	// no posts found
  }
  /* Restore original Post Data */
  wp_reset_postdata(); ?>
  
 
    	  
</div>
<ul class="csslide_nav">

  	<?php $count = 0;
  	while ( $csslide_query->have_posts() ) {
  	  		$csslide_query->the_post();
  	  		$count++; ?>
  	  		
  	  	  		    <li class="slide<?php echo $count; ?> <?php if($count === 1){ ?>active<?php } ?>"><a href="#slide<?php echo $count; ?>">
                        Link to Slide <?php echo $count; ?>
  	  		    </a></li>

  	  		
  	  	<?php } ?>
  	  </ul>
</div>
<?php }


