<?php
/*
Plugin Name: CornerStone Social Buttons
Plugin URI: http://www.jordesign.com/cssb
Description: Add a widget with Social Media links. Part of the CornerStone framework .
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
add_action( 'wp_enqueue_scripts', 'cs_addSocialButtonStyles' );
function cs_addSocialButtonStyles() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'cssb-style', plugins_url('style.css', __FILE__) );
    wp_enqueue_style( 'cssb-style' );
}


 //Registering the function 
 
class cs_socialButtons extends WP_Widget {

	function cs_socialButtons() {
		$widget_ops = array('classname' => 'cs_socialButtons', 'description' => __(' Add Buttons to your Social Networks. Part of the CornerStone framework.'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('cs_socialButtons', __('Social Buttons Widget'), $widget_ops, $control_ops);
	}
	
	function widget( $args, $instance ) {
		extract($args);		
		$cssb_title = $instance['cssb_title'];
		$twtr_id = $instance['twtr_id'];
		$fb_id = $instance['fb_id'];
		$pinterest_id = $instance['pinterest_id'];
		$gplus_id = $instance['gplus_id'];
		$instagram_id = $instance['instagram_id'];
		$linkedin_id = $instance['linkedin_id'];
		$vimeo_id = $instance['vimeo_id'];
		$youtube_id = $instance['youtube_id'];
		?>
		
<!--begin of cs_socialButtons Widget--> 
<div class="cs_socialButtons">
<?php if($cssb_title) { ?>
    <h4><?php echo $cssb_title; ?></h4>
<?php } ?>
<ul> 
    
    <?php if ($fb_id) { ?>
        <li class="cs_socialButton facebook">
        	<a rel="nofollow external" title="Facebook" href="<?php echo $fb_id; ?>" target="_blank"><i class="foundicon-facebook"></i>Facebook</a>
        </li>
     <?php }?>
     
     <?php if ($twtr_id) { ?>
         <li class="cs_socialButton twitter">
         	<a rel="nofollow external" title="Twitter" href="<?php echo $twtr_id; ?>" target="_blank"><i class="foundicon-twitter"></i>Twitter</a>
         </li>
      <?php }?>
      
      <?php if ($pinterest_id) { ?>
          <li class="cs_socialButton pinterest">
          	<a rel="nofollow external" title="Pinterest" href="<?php echo $pinterest_id; ?>" target="_blank"><i class="foundicon-pinterest"></i>Pinterest</a>
          </li>
       <?php }?>
       
       <?php if ($gplus_id) { ?>
           <li class="cs_socialButton gplus">
           	<a rel="nofollow external" title="Google +" href="<?php echo $gplus_id; ?>" target="_blank"><i class="foundicon-google-plus"></i>Google +</a>
           </li>
        <?php }?>
        
        <?php if ($instagram_id) { ?>
            <li class="cs_socialButton instagram">
            	<a rel="nofollow external" title="Instagram" href="<?php echo $instagram_id; ?>" target="_blank"><i class="foundicon-instagram"></i>Instagram</a>
            </li>
         <?php }?>
         
         <?php if ($linkedin_id) { ?>
             <li class="cs_socialButton linkedin">
             	<a rel="nofollow external" title="Linkedin" href="<?php echo $linkedin_id; ?>" target="_blank"><i class="foundicon-linkedin"></i>Linkedin</a>
             </li>
          <?php }?>
          
          <?php if ($vimeo_id) { ?>
              <li class="cs_socialButton vimeo">
              	<a rel="nofollow external" title="Vimeo" href="<?php echo $vimeo_id; ?>" target="_blank"><i class="foundicon-vimeo"></i>Vimeo</a>
              </li>
           <?php }?>
           
           <?php if ($youtube_id) { ?>
               <li class="cs_socialButton youtube">
               	<a rel="nofollow external" title="Youtube" href="<?php echo $youtube_id; ?>" target="_blank"><i class="foundicon-youtube"></i>Youtube</a>
               </li>
            <?php }?>

		 
		
	</ul></div> <!-- End Widget -->

<!--end of socialButtons widget--> 
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;	
		$instance['cssb_title'] =      strip_tags($new_instance['cssb_title'] );	
		$instance['twtr_id'] =      strip_tags($new_instance['twtr_id'] );
		$instance['fb_id'] =        strip_tags($new_instance['fb_id'] );
		$instance['pinterest_id'] =  strip_tags($new_instance['pinterest_id'] );
		$instance['gplus_id'] =      strip_tags($new_instance['gplus_id'] );
		$instance['instagram_id'] =      strip_tags($new_instance['instagram_id'] );
		$instance['linkedin_id'] =      strip_tags($new_instance['linkedin_id'] );
		$instance['vimeo_id'] =      strip_tags($new_instance['vimeo_id'] );
		$instance['youtube_id'] =      strip_tags($new_instance['youtube_id'] );

		return $instance;
	}

	function form( $instance ) { 
		$instance = wp_parse_args( (array) $instance, array( 'twtr_id' => '', 'fb_id' => '', 'pinterest_id' => '', 'gplus_id' => '', 'instagram_id' => '', 'linkedin_id' => '', 'vimeo_id' => '', 'youtube_id' => '', 'cssb_title' => 'Connect with Us' ) );
		$cssb_title = format_to_edit($instance['cssb_title']);
		$twtr_id = format_to_edit($instance['twtr_id']);
		$fb_id = format_to_edit($instance['fb_id']);
		$pinterest_id = format_to_edit($instance['pinterest_id']);
		$gplus_id = format_to_edit($instance['gplus_id']);
		$instagram_id = format_to_edit($instance['instagram_id']);
		$linkedin_id = format_to_edit($instance['linkedin_id']);
		$vimeo_id = format_to_edit($instance['vimeo_id']);
		$youtube_id = format_to_edit($instance['youtube_id']);
	?>			
	    <p><label for="<?php echo $this->get_field_id('cssb_title'); ?>"><?php _e('Widget Title (optional)'); ?></label>
	    <input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('cssb_title'); ?>" value="<?php echo $cssb_title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('fb_id'); ?>"><?php _e('Enter your Facebook URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('fb_id'); ?>" value="<?php echo $fb_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('twtr_id'); ?>"><?php _e('Enter your Twitter Profile URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('twtr_id'); ?>" value="<?php echo $twtr_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('pinterest_id'); ?>"><?php _e('Enter your Pinterest URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('pinterest_id'); ?>" value="<?php echo $pinterest_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('gplus_id'); ?>"><?php _e('Enter your Google + URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('gplus_id'); ?>" value="<?php echo $gplus_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('instagram_id'); ?>"><?php _e('Enter your Instagram Profile URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('instagram_id'); ?>" value="<?php echo $instagram_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('linkedin_id'); ?>"><?php _e('Enter your Linkedin URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('linkedin_id'); ?>" value="<?php echo $linkedin_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('vimeo_id'); ?>"><?php _e('Enter your Vimeo URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('vimeo_id'); ?>" value="<?php echo $vimeo_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('youtube_id'); ?>"><?php _e('Enter your Youtube URL:'); ?></label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('youtube_id'); ?>" value="<?php echo $youtube_id; ?>" /></p>

		<?php }
}


add_action('widgets_init', create_function('', 'return register_widget(\'cs_socialButtons\');'));