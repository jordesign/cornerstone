<?php
/*
Plugin Name: CornerStone FeedBurner Signup
Plugin URI: http://www.jordesign.com/csfs
Description: Add a widget allowing users to subscribe via email - using FeedBurner. Part of the CornerStone framework .
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

// Enqueue CSS
add_action( 'wp_enqueue_scripts', 'cs_addFeedburner' );
function cs_addFeedburner() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'csfs-style', plugins_url('style.css', __FILE__) );
    wp_enqueue_style( 'csfs-style' );
}


 //Registering the function 
 
class cs_feedburner extends WP_Widget {

	function cs_feedburner() {
		$widget_ops = array('classname' => 'cs_feedburner', 'description' => __(' Add a form for users to subscribe to your posts in their email. Part of the CornerStone framework.'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('cs_feedburner', __('Feedburner Signup'), $widget_ops, $control_ops);
	}
	
	function widget( $args, $instance ) {
		extract($args);		
		$csfs_title = $instance['csfs_title'];
		$csfs_blurb = $instance['csfs_blurb'];
		$feedburner_id = $instance['feedburner_id'];
		?>
		
<!--begin of cs_feedburner Widget--> 
<?php echo $before_widget; ?>
        <?php if($csfs_title) { ?>
            <?php echo $before_title; ?><?php echo $csfs_title; ?><?php echo $after_title; ?>
        <?php } ?>
        
        <?php if($csfs_blurb) { ?>
            <p><?php echo $csfs_blurb; ?></p>
        <?php } ?>

<?php echo $after_widget; ?>
    


<!-- Subscribe -->
<?php if ($feedburner_id) { ?>
	
			<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburner_id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">	
				<input class="email" type="text" id="email" name="email" value="your email" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>		
				<input type="hidden" value="<?php echo $feedburner_id; ?>" name="uri"/>
				<input type="hidden" name="loc" value="en_US"/>
				<input class="subscribe button blue" name="commit" type="submit" value="Subscribe"/>	
			</form> 
	</div>
	 <?php }?>

<!--end of Feedburner Signup widget--> 
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;	
		$instance['csfs_title'] =      strip_tags($new_instance['csfs_title'] );	
        $instance['csfs_blurb'] =      strip_tags($new_instance['csfs_blurb'] );	
        $instance['feedburner_id'] =      strip_tags($new_instance['feedburner_id'] );	
		return $instance;
	}

	function form( $instance ) { 
		$instance = wp_parse_args( (array) $instance, array( 'csfs_title' => '', 'csfs_blurb' => '', 'feedburner_id' => '' ) );
		$csfs_title = format_to_edit($instance['csfs_title']);
		$csfs_blurb = format_to_edit($instance['csfs_blurb']);
		$feedburner_id = format_to_edit($instance['feedburner_id']);
	?>			
	    <p><strong><label for="<?php echo $this->get_field_id('csfs_title'); ?>"><?php _e('Widget Title (optional)'); ?></label></strong>
	    <input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('csfs_title'); ?>" value="<?php echo $csfs_title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('csfs_blurb'); ?>"><?php _e('Optional Blurb text'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('csfs_blurb'); ?>" value="<?php echo $csfs_blurb; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('feedburner_id'); ?>"><?php _e('Enter your Feedburner ID'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('feedburner_id'); ?>" value="<?php echo $feedburner_id; ?>" /></p>
		
		

		<?php }
}


add_action('widgets_init', create_function('', 'return register_widget(\'cs_feedburner\');'));