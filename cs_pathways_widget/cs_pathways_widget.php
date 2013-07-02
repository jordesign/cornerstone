<?php
/*
    Plugin Name: CornerStone Pathways Widget
    Plugin URI: http://www.jordesign.com/cornerstone
    Description: Adds an element of the page consisting of a title, image and text that all links to a single destination.
    Author: Jordan Gillman
    Version: 1.0
    Author URI: http://www.jordesign.com
*/


/* This widget incorporates MondayByNoons Widget Image Upload plugin - https://mondaybynoon.com/wordpress-widget-image-field/ */

//Define WidgetImageField for use.
if( !defined( 'IS_ADMIN' ) )
    define( 'IS_ADMIN',  is_admin() );

define( 'WIDGET_IMAGE_FIELD_VERSION', '0.3' );
define( 'WIDGET_IMAGE_FIELD_DIR', WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) ) );
define( 'WIDGET_IMAGE_FIELD_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );


class WidgetImageField
{
    private $image_id;
    private $src;
    private $width;
    private $height;
    private $widget_field;
    private $widget = null;

    function __construct( $widget = null, $image_id = 0 )
    {
        $uri        = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : NULL ;
        $file       = basename( parse_url( $uri, PHP_URL_PATH ) );

        // if we're on the Widgets page
        if( $uri && in_array( $file, array( 'widgets.php' ) ) && IS_ADMIN )
        {
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'thickbox' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'widgetimagefield', WIDGET_IMAGE_FIELD_URL . '/script.js', array( 'jquery', 'jquery-ui-core', 'thickbox', 'media-upload' ), false, true );

            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style( 'widgetimagefield', WIDGET_IMAGE_FIELD_URL . '/style.css' );
        }

        // set our properties
        $this->widget = $widget;
        if( $image_id )
        {
            $this->image_id         = intval( $image_id );
            $this->src              = $this->get_image_src( $this->image_id );
            $this->width            = $this->get_image_width( $this->image_id );
            $this->height           = $this->get_image_height( $this->image_id );
            $this->widget_field     = $this->get_widget_field( $widget, $this->image_id );
        }
    }

    function get_image( $size = 'thumbnail' )
    {
        $image = false;

        if( $this->image_id )
        {
            $image = wp_get_attachment_image_src( $this->image_id, $size );
        }

        return $image;
    }

    function get_image_src( $size = 'thumbnail' )
    {
        $src = false;

        if( $this->image_id )
        {
            $image      = $this->get_image( $size );
            $src        = $image[0];
        }

        return $src;
    }

    function get_image_dimensions( $size = 'thumbnail' )
    {
        $dimensions = array( null, null );

        if( $this->image_id )
        {
            $image          = $this->get_image( $size );
            $dimensions     = array( $image[1], $image[2] );
        }

        return $dimensions;
    }

    function get_image_width( $size = 'thumbnail' )
    {
        $width = false;

        if( $this->image_id )
        {
            $dimensions     = $this->get_image_dimensions( $size );
            $width          = $dimensions[0];
        }

        return $width;
    }

    function get_image_height( $size = 'thumbnail' )
    {
        $height = false;

        if( $this->image_id )
        {
            $dimensions     = $this->get_image_dimensions( $size );
            $height         = $dimensions[1];
        }

        return $height;
    }

    function get_widget_field( $field_name = null )
    {
        $field = false;
        if( $this->widget && ( isset( $this->widget->image_field ) || $field_name ) )
        {
            $field  = "<div class='iti-image-widget-field'><div class='iti-image-widget-image' id='" . $this->widget->id . "'>";
            $field .= "<input type='hidden' style='display:none;' id='" . $this->widget->get_field_id( $this->widget->image_field ) . "' name='" . $this->widget->get_field_name( $this->widget->image_field ) . "' value='" . $this->image_id . "' />";

            if( $this->image_id )
            {
                $field .= "<img src='" . $this->src . "' width='" . $this->width . "' height='" . $this->height . "' />";
            }

            $field .= "</div>";

            $field .= "<a class='button iti-image-widget-trigger' href='media-upload.php?TB_iframe=1&amp;width=640&amp;height=1500' title='" . __( 'Choose Image' ) . "'>";
            $field .= __( 'Choose Image' );
            $field .= "</a></div>";
        }
        return $field;
    }
}


// And Now the Widget

//Check for the WidgetImageField (defined above)
if( class_exists( 'WidgetImageField' ) )
    add_action( 'widgets_init', create_function( '', "register_widget( 'cs_pathways' );" ) );
 
//Initialise Widget 
class cs_pathways extends WP_Widget
{
    var $image_field = 'image';  // the image field ID
 
    function __construct()
    {
        $widget_ops = array(
                'classname'     => 'cs_pathways',
                'description'   => __( 'Add a Pathway (made up of a title, image, text and link)' )
            );
        parent::__construct( 'cs_pathways', __( 'Pathway' ), $widget_ops );
    }


// The Widget Form
function form( $instance )
{
    $headline   = esc_attr( isset( $instance['headline'] ) ? $instance['headline'] : '' );
    $image_id   = esc_attr( isset( $instance[$this->image_field] ) ? $instance[$this->image_field] : 0 );
    $blurb      = esc_attr( isset( $instance['blurb'] ) ? $instance['blurb'] : '' );
    $link      = esc_attr( isset( $instance['link'] ) ? $instance['link'] : '' );
 
    $image      = new WidgetImageField( $this, $image_id );
    ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'headline' ); ?>"><?php _e( 'Pathway Title:' ); ?>
                <input class="widefat" id="<?php echo $this->get_field_id( 'headline' ); ?>" name="<?php echo $this->get_field_name( 'headline' ); ?>" type="text" value="<?php echo $headline; ?>" />
            </label>
        </p>
        <div>
            <label><?php _e( 'Image:' ); ?></label>
            <?php echo $image->get_widget_field(); ?>
        </div>
        <p>
            <label for="<?php echo $this->get_field_id( 'blurb' ); ?>"><?php _e( 'Pathway Text:' ); ?>
                <textarea class="widefat" id="<?php echo $this->get_field_id( 'blurb' ); ?>" name="<?php echo $this->get_field_name( 'blurb' ); ?>" type="text" height="120"><?php echo $blurb; ?></textarea>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Pathway Link:' ); ?>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $link; ?>" />
            </label>
        </p>
    <?php
}

//Update the Fields
function update( $new_instance, $old_instance )
{
    $instance = $old_instance;
 
    $instance['headline']            = strip_tags( $new_instance['headline'] );
    $instance[$this->image_field]    = intval( strip_tags( $new_instance[$this->image_field] ) );
    $instance['blurb']               = strip_tags( $new_instance['blurb'] );
    $instance['link']               = strip_tags( $new_instance['link'] );
 
    return $instance;
}

// Front end output
function widget( $args, $instance )
{
    extract($args);
 
    $headline   = $instance['headline'];
    $image_id   = $instance[$this->image_field];
    $blurb      = $instance['blurb'];
    $link      = $instance['link'];
    $image      = new WidgetImageField( $this, $image_id );
 
    echo $before_widget;
 
    ?>
        <a href="<?php echo $link; ?>">
        <?php if( !empty( $headline ) ) : ?>
            <?php echo $before_title; ?><?php echo $headline; ?><?php echo $after_title; ?>
        <?php endif; ?>
        <?php if( !empty( $image_id ) ) : ?>
            <?php $size = apply_filters( 'csPathway_size', "medium" ); // (thumbnail, medium, large, full or custom size) ?>
            <img src="<?php echo $image->get_image_src( $size ); ?>" width="<?php echo $image->get_image_width( $size ); ?>" height="<?php echo $image->get_image_height( $size ); ?>" />
        <?php endif; ?>
        <?php if( !empty( $blurb ) ) : ?>
            <p><?php echo $blurb; ?></p>
        <?php endif; ?>
        </a>
    <?php
 
    echo $after_widget;
}



}



