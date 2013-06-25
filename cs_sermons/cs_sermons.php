<?php
/*
Plugin Name: CornerStone Sermons
Plugin URI: http://www.jordesign.com/cornerstone
Description: Add and organise Sermons to your site.
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
add_action( 'wp_enqueue_scripts', 'cs_sermon_styles' );
function cs_sermon_styles() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'cssermons-style', plugins_url('style.css', __FILE__) );
   // wp_enqueue_script('csSermons-script', plugins_url('csSermons.js', __FILE__) ,array( 'jquery' ) );
    wp_enqueue_style( 'cssermons-style' );
}

//Add Image Size for sermons series Thumbnails
//Add Default Slide size
add_image_size( 'cs_sermon_img', 100, 100 ); 

// Add CPT for Sermons
if ( ! function_exists('cs_sermon_type') ) {

// Register Custom Post Type
function cs_sermon_type() {
	$labels = array(
		'name'                => _x( 'Sermons', 'Post Type General Name', 'cornerstone' ),
		'singular_name'       => _x( 'Sermon', 'Post Type Singular Name', 'cornerstone' ),
		'menu_name'           => __( 'Sermons', 'cornerstone' ),
		'parent_item_colon'   => __( 'Parent Sermon:', 'cornerstone' ),
		'all_items'           => __( 'All Sermons', 'cornerstone' ),
		'view_item'           => __( 'View Sermon', 'cornerstone' ),
		'add_new_item'        => __( 'Add New Sermon', 'cornerstone' ),
		'add_new'             => __( 'New Sermon', 'cornerstone' ),
		'edit_item'           => __( 'Edit Sermon', 'cornerstone' ),
		'update_item'         => __( 'Update Sermon', 'cornerstone' ),
		'search_items'        => __( 'Search Sermons', 'cornerstone' ),
		'not_found'           => __( 'No Sermons found', 'cornerstone' ),
		'not_found_in_trash'  => __( 'No Sermons found in Trash', 'cornerstone' ),
	);
    $iconURL = plugins_url("sermons.png", __FILE__);
	$args = array(
		'label'               => __( 'Sermon', 'cornerstone' ),
		'description'         => __( 'Add and Manage Sermons', 'cornerstone' ),
		'labels'              => $labels,
		'supports'            => array( 'title', ),
		'taxonomies'          => array( 'series','speaker','topic' ),
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

	register_post_type( 'sermon', $args );
}

// Hook into the 'init' action
add_action( 'init', 'cs_sermon_type', 0 );

}

//Add Custom taxonomies for sermon series
if ( ! function_exists('cs_series_taxonomy') ) {

// Register Custom Taxonomy
function cs_series_taxonomy()  {
	$labels = array(
		'name'                       => _x( 'Series', 'Taxonomy General Name', 'cornerstone' ),
		'singular_name'              => _x( 'Series', 'Taxonomy Singular Name', 'cornerstone' ),
		'menu_name'                  => __( 'Series', 'cornerstone' ),
		'all_items'                  => __( 'All Series', 'cornerstone' ),
		'parent_item'                => __( 'Parent Series', 'cornerstone' ),
		'parent_item_colon'          => __( 'Parent Series:', 'cornerstone' ),
		'new_item_name'              => __( 'New Series Name', 'cornerstone' ),
		'add_new_item'               => __( 'Add New Series', 'cornerstone' ),
		'edit_item'                  => __( 'Edit Series', 'cornerstone' ),
		'update_item'                => __( 'Update Series', 'cornerstone' ),
		'separate_items_with_commas' => __( 'Separate series with commas', 'cornerstone' ),
		'search_items'               => __( 'Search Series', 'cornerstone' ),
		'add_or_remove_items'        => __( 'Add or remove Series', 'cornerstone' ),
		'choose_from_most_used'      => __( 'Choose from the most used Series', 'cornerstone' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);

	register_taxonomy( 'series', 'sermon', $args );
}

// Hook into the 'init' action
add_action( 'init', 'cs_series_taxonomy', 0 );

}

if ( ! function_exists('cs_speakers_taxonomy') ) {

// Register Custom Taxonomy
function cs_speakers_taxonomy()  {
	$labels = array(
		'name'                       => _x( 'Speakers', 'Taxonomy General Name', 'cornerstone' ),
		'singular_name'              => _x( 'Speaker', 'Taxonomy Singular Name', 'cornerstone' ),
		'menu_name'                  => __( 'Speakers', 'cornerstone' ),
		'all_items'                  => __( 'All Speakers', 'cornerstone' ),
		'parent_item'                => __( 'Parent Speakers', 'cornerstone' ),
		'parent_item_colon'          => __( 'Parent Speaker:', 'cornerstone' ),
		'new_item_name'              => __( 'New Speaker Name', 'cornerstone' ),
		'add_new_item'               => __( 'Add New Speaker', 'cornerstone' ),
		'edit_item'                  => __( 'Edit Speaker', 'cornerstone' ),
		'update_item'                => __( 'Update Speaker', 'cornerstone' ),
		'separate_items_with_commas' => __( 'Separate speaker with commas', 'cornerstone' ),
		'search_items'               => __( 'Search speaker', 'cornerstone' ),
		'add_or_remove_items'        => __( 'Add or remove speakers', 'cornerstone' ),
		'choose_from_most_used'      => __( 'Choose from the most used speakers', 'cornerstone' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);

	register_taxonomy( 'speaker', 'sermon', $args );
}

// Hook into the 'init' action
add_action( 'init', 'cs_speakers_taxonomy', 0 );

}

if ( ! function_exists('cs_topics_taxonomy') ) {

// Register Custom Taxonomy
function cs_topics_taxonomy()  {
	$labels = array(
		'name'                       => _x( 'Topics', 'Taxonomy General Name', 'cornerstone' ),
		'singular_name'              => _x( 'Topic', 'Taxonomy Singular Name', 'cornerstone' ),
		'menu_name'                  => __( 'Topics', 'cornerstone' ),
		'all_items'                  => __( 'All Topics', 'cornerstone' ),
		'parent_item'                => __( 'Parent Topics', 'cornerstone' ),
		'parent_item_colon'          => __( 'Parent Topic:', 'cornerstone' ),
		'new_item_name'              => __( 'New Topic Name', 'cornerstone' ),
		'add_new_item'               => __( 'Add New Topic', 'cornerstone' ),
		'edit_item'                  => __( 'Edit Topic', 'cornerstone' ),
		'update_item'                => __( 'Update Topic', 'cornerstone' ),
		'separate_items_with_commas' => __( 'Separate Topic with commas', 'cornerstone' ),
		'search_items'               => __( 'Search Topics', 'cornerstone' ),
		'add_or_remove_items'        => __( 'Add or remove Topics', 'cornerstone' ),
		'choose_from_most_used'      => __( 'Choose from the most used Topics', 'cornerstone' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);

	register_taxonomy( 'topic', 'sermon', $args );
}

// Hook into the 'init' action
add_action( 'init', 'cs_topics_taxonomy', 0 );

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
		'id' => 'acf_sermon-details',
		'title' => 'Sermon Details',
		'fields' => array (
			array (
				'default_value' => '',
				'formatting' => 'none',
				'key' => 'field_51b456a0aa705',
				'label' => 'Sermon Audio URL',
				'name' => 'sermon_audio',
				'type' => 'text',
				'instructions' => 'The URL of the sermon audio file',
			),
			array (
				'default_value' => '',
				'formatting' => 'none',
				'key' => 'field_51b456c3aa706',
				'label' => 'Sermon Video URL',
				'name' => 'sermon_video',
				'type' => 'text',
				'instructions' => 'The URL of the sermon video file',
			),
			array (
				'default_value' => '',
				'formatting' => 'br',
				'key' => 'field_51b456deaa707',
				'label' => 'Passages',
				'name' => 'passages',
				'type' => 'textarea',
			),
			array (
				'save_format' => 'object',
				'library' => 'uploadedTo',
				'key' => 'field_51b4570faa708',
				'label' => 'Sermon Notes',
				'name' => 'sermon_notes',
				'type' => 'file',
				'instructions' => 'Upload the sermon notes',
			),
			array (
				'save_format' => 'object',
				'library' => 'all',
				'key' => 'field_51b45726aa709',
				'label' => 'Sermon Presentation',
				'name' => 'sermon_presentation',
				'type' => 'file',
				'instructions' => 'Upload the sermon presentation',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sermon',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'custom_fields',
				3 => 'discussion',
				4 => 'revisions',
				5 => 'author',
				6 => 'format',
				7 => 'featured_image',
			),
		),
		'menu_order' => 0,
	));
}


/**
 *  Front-End Output
 *
 *  Functions to output the sermon/s within templates. Also used later for the widgets & Shortcodes
 *  
 */

//Output a list of sermons by date
function cs_list_sermons(
    $sermonCount = NULL,     //Number of Sermons to show. Defaults to 1
    $sermonSpeaker = 0,      //Show Speaker Name (True/False)
    $sermonSeries = 0   //Show Series Image (True/False)
){


    if ( !$sermonCount ) {
        $sermonCount = 1;
    }

    // The Query
    $cs_sermon_query = new WP_Query("post_type=sermon&posts_per_page=$sermonCount&order_by=date" );

    // The Loop
    if ( $cs_sermon_query->have_posts() ) {
    	while ( $cs_sermon_query->have_posts() ) {
    		$cs_sermon_query->the_post(); ?>
    		    
    		    <div class="cs_sermon">
    		    
    		    <?php $size = apply_filters( 'cs_sermon_img_size', "cs_sermon_img" ); // (thumbnail, medium, large, full or custom size)
    		        print apply_filters( 'taxonomy-images-list-the-terms', '',array(
    		        'image_size' => $size,
    		        'class' => 'sermonImage',
    		        'taxonomy' => 'series',
    		        'after'        => '',
    		        'after_image'  => '',
    		        'before'       => '',
    		        'before_image' => '',
    		        ) );  ?>
    		        <p class="cs_sermon_title">
    		            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> &nbsp;
    		            <span class="cs_sermon_date"><?php the_date(); ?></span>
    		        </p>
    		        <audio src="<?php echo the_field('sermon_audio'); ?>" controls="controls"></audio>
    		        <p class="cs_sermon_meta">
    		            <?php if ($sermonSpeaker) { ?><span class="cs_sermon_speaker">Speaker: <?php the_terms( get_the_ID(), 'speaker', '', ', ', ' ' ); } ?> </span>
    		            <?php if ($sermonSeries) {?><span class="cs_sermon_series">Series: <?php the_terms( get_the_ID(), 'series', '', ', ', ' ' ); } ?> </span>
    		        </p>
    		    </div>   
    		

    	<?php }
    } else {
    	// no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();
 }


