<?php 
/**
 *  ShortCodes
 *
 *  Shortcode to output a single sermon in the editor
 *  
 */

function cs_sermon_single_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'sermon_id' => 1,
		'sermon_image' => false,
		'sermon_series' => false,
		'sermon_speaker' => false,
	), $atts ) );

	cs_single_sermon($sermon_id, $sermon_image, $sermon_series, $sermon_speaker);
}
add_shortcode( 'sermon', 'cs_sermon_single_shortcode' );



/**
 *  Widgets
 *
 *  Widgets to output either a single sermon, or a list of recent sermons
 *  
 */
 
 //Single Sermon Widget 
  
 class cs_single_sermon_widget extends WP_Widget {
 
 	function cs_single_sermon_widget() {
 		$widget_ops = array('classname' => 'cs_sermon_single', 'description' => __(' Add a specific single sermon to your sidebar'));
 		$control_ops = array('width' => 250, 'height' => 350);
 		$this->WP_Widget('cs_sermon_single', __('CS Sermons - Single Sermon'), $widget_ops, $control_ops);
 	}
 	
 	function widget( $args, $instance ) {
 		extract($args);		
 		$cs_sermon_title = $instance['cs_sermon_title'];
 		$cs_sermon_id = $instance['cs_sermon_id'];
 		$cs_sermon_image = $instance['cs_sermon_image'];
 		$cs_sermon_series = $instance['cs_sermon_series'];
 		$cs_sermon_speaker = $instance['cs_sermon_speaker'];
 		?>
 		
 <!--begin  Widget--> 
 <?php echo $before_widget; ?>
 <?php if($cs_sermon_title) { ?>
     <?php echo $before_title; ?><?php echo $cs_sermon_title; ?><?php echo $after_title; ?>
 <?php } 
 
     cs_single_sermon($cs_sermon_id, $cs_sermon_image, $cs_sermon_series, $cs_sermon_speaker);
     
 
 	
  echo $after_widget; ?> 
  <!-- End Widget -->
 

 		<?php
 	}
 
 	function update( $new_instance, $old_instance ) {
 		$instance = $old_instance;	
 		$instance['cs_sermon_title'] =      strip_tags($new_instance['cs_sermon_title'] );	
 		$instance['cs_sermon_id'] =      strip_tags($new_instance['cs_sermon_id'] );
 		$instance['cs_sermon_image'] =        strip_tags($new_instance['cs_sermon_image'] );
 		$instance['cs_sermon_series'] =  strip_tags($new_instance['cs_sermon_series'] );
 		$instance['cs_sermon_speaker'] =      strip_tags($new_instance['cs_sermon_speaker'] );
 
 		return $instance;
 	}
 
 	function form( $instance ) { 
 		$instance = wp_parse_args( (array) $instance, array( 'cs_sermon_title' => '', 'cs_sermon_id' => '', 'cs_sermon_image' => '', 'cs_sermon_series' => '', 'cs_sermon_speaker' => '' ) );
 		$cs_sermon_title = format_to_edit($instance['cs_sermon_title']);
 		$cs_sermon_id = format_to_edit($instance['cs_sermon_id']);
 		$cs_sermon_image = format_to_edit($instance['cs_sermon_image']);
 		$cs_sermon_series = format_to_edit($instance['cs_sermon_series']);
 		$cs_sermon_speaker= format_to_edit($instance['cs_sermon_speaker']);
 	?>			
 	    <p><label for="<?php echo $this->get_field_id('cs_sermon_title'); ?>"><?php _e('Widget Title (optional)'); ?></label>
 	    <input class="widefat" type="text" id="<?php echo $this->get_field_id('cs_sermon_title'); ?>" name="<?php echo $this->get_field_name('cs_sermon_title'); ?>" value="<?php echo $cs_sermon_title; ?>" /></p>
 	    
 	    <p><label for="<?php echo $this->get_field_id('cs_sermon_id'); ?>"><?php _e('Sermon ID'); ?></label>
 	    <input class="widefat" type="text" id="<?php echo $this->get_field_id('cs_sermon_id'); ?>" name="<?php echo $this->get_field_name('cs_sermon_id'); ?>" value="<?php echo $cs_sermon_id; ?>" /></p>
 
 		<p><input id="<?php echo $this->get_field_id('cs_sermon_image'); ?>" name="<?php echo $this->get_field_name('cs_sermon_image'); ?>" type="checkbox" value="1" <?php checked( '1', $cs_sermon_image ); ?>/>
 		    	<label for="<?php echo $this->get_field_id('cs_sermon_image'); ?>"><?php _e('Include Series Image?'); ?></label>
 		    </p>
 		    
 		<p><input id="<?php echo $this->get_field_id('cs_sermon_series'); ?>" name="<?php echo $this->get_field_name('cs_sermon_series'); ?>" type="checkbox" value="1" <?php checked( '1', $cs_sermon_series ); ?>/>
 		    	<label for="<?php echo $this->get_field_id('cs_sermon_series'); ?>"><?php _e('Show Series Title?'); ?></label>
 		    </p>
 		
 		<p><input id="<?php echo $this->get_field_id('cs_sermon_speaker'); ?>" name="<?php echo $this->get_field_name('cs_sermon_speaker'); ?>" type="checkbox" value="1" <?php checked( '1', $cs_sermon_speaker ); ?>/>
 		    	<label for="<?php echo $this->get_field_id('cs_sermon_speaker'); ?>"><?php _e('Show Speaker Name?'); ?></label>
 		    </p>
 
 		<?php }
 }
 
 
 add_action('widgets_init', create_function('', 'return register_widget(\'cs_single_sermon_widget\');'));
 
 
 
 //Recent Sermons Widget 
  
 class cs_sermon_list extends WP_Widget {
 
 	function cs_sermon_list() {
 		$widget_ops = array('classname' => 'cs_sermon_list', 'description' => __('Show a list of Recent Sermons'));
 		$control_ops = array('width' => 250, 'height' => 350);
 		$this->WP_Widget('cs_sermon_list', __('CS Sermons - Recent List'), $widget_ops, $control_ops);
 	}
 	
 	function widget( $args, $instance ) {
 		extract($args);		
 		$cs_sermon_title = $instance['cs_sermon_title'];
 		$cs_sermon_list_count = $instance['cs_sermon_list_count'];
 		$cs_sermon_list_image = $instance['cs_sermon_list_image'];
 		$cs_sermon_list_series = $instance['cs_sermon_list_series'];
 		$cs_sermon_list_speaker = $instance['cs_sermon_list_speaker'];
 		?>
 		
 <!--begin Widget--> 
 <?php echo $before_widget; ?>
 <?php if($cs_sermon_title) { ?>
     <?php echo $before_title; ?><?php echo $cs_sermon_title; ?><?php echo $after_title; ?>
 <?php } 
 
     cs_list_sermons($cs_sermon_list_count,  $cs_sermon_list_series, $cs_sermon_list_speaker, $cs_sermon_list_image);
     
 
 	
  echo $after_widget; ?> 
  <!-- End Widget -->
 

 		<?php
 	}
 
 	function update( $new_instance, $old_instance ) {
 		$instance = $old_instance;	
 		$instance['cs_sermon_list_title'] =      strip_tags($new_instance['cs_sermon_list_title'] );	
 		$instance['cs_sermon_list_count'] =      strip_tags($new_instance['cs_sermon_list_count'] );
 		$instance['cs_sermon_list_image'] =        strip_tags($new_instance['cs_sermon_list_image'] );
 		$instance['cs_sermon_list_series'] =  strip_tags($new_instance['cs_sermon_list_series'] );
 		$instance['cs_sermon_list_speaker'] =      strip_tags($new_instance['cs_sermon_list_speaker'] );
 
 		return $instance;
 	}
 
 	function form( $instance ) { 
 		$instance = wp_parse_args( (array) $instance, array( 'cs_sermon_list_title' => '', 'cs_sermon_list_count' => '', 'cs_sermon_list_image' => '', 'cs_sermon_list_series' => '', 'cs_sermon_list_speaker' => '' ) );
 		$cs_sermon_list_title = format_to_edit($instance['cs_sermon_list_title']);
 		$cs_sermon_list_count = format_to_edit($instance['cs_sermon_list_count']);
 		$cs_sermon_list_image = format_to_edit($instance['cs_sermon_list_image']);
 		$cs_sermon_list_series = format_to_edit($instance['cs_sermon_list_series']);
 		$cs_sermon_list_speaker= format_to_edit($instance['cs_sermon_list_speaker']);
 	?>			
 	    <p><label for="<?php echo $this->get_field_id('cs_sermon_list_title'); ?>"><?php _e('Widget Title (optional)'); ?></label>
 	    <input class="widefat" type="text" id="<?php echo $this->get_field_id('cs_sermon_list_title'); ?>" name="<?php echo $this->get_field_name('cs_sermon_list_title'); ?>" value="<?php echo $cs_sermon_list_title; ?>" /></p>
 	    
 	    <p><label for="<?php echo $this->get_field_id('cs_sermon_list_count'); ?>"><?php _e('Number of Sermons to show:'); ?></label>
 	    <input class="widefat" type="text" id="<?php echo $this->get_field_id('cs_sermon_list_count'); ?>" name="<?php echo $this->get_field_name('cs_sermon_list_count'); ?>" value="<?php echo $cs_sermon_list_count; ?>" /></p>
 
 		<p><input id="<?php echo $this->get_field_id('cs_sermon_list_image'); ?>" name="<?php echo $this->get_field_name('cs_sermon_list_image'); ?>" type="checkbox" value="1" <?php checked( '1', $cs_sermon_list_image ); ?>/>
 		    	<label for="<?php echo $this->get_field_id('cs_sermon_list_image'); ?>"><?php _e('Include Series Image?'); ?></label>
 		    </p>
 		    
 		<p><input id="<?php echo $this->get_field_id('cs_sermon_list_series'); ?>" name="<?php echo $this->get_field_name('cs_sermon_list_series'); ?>" type="checkbox" value="1" <?php checked( '1', $cs_sermon_list_series ); ?>/>
 		    	<label for="<?php echo $this->get_field_id('cs_sermon_list_series'); ?>"><?php _e('Show Series Title?'); ?></label>
 		    </p>
 		
 		<p><input id="<?php echo $this->get_field_id('cs_sermon_list_speaker'); ?>" name="<?php echo $this->get_field_name('cs_sermon_list_speaker'); ?>" type="checkbox" value="1" <?php checked( '1', $cs_sermon_list_speaker ); ?>/>
 		    	<label for="<?php echo $this->get_field_id('cs_sermon_list_speaker'); ?>"><?php _e('Show Speaker Name?'); ?></label>
 		    </p>
 
 		<?php }
 }
 
 
 add_action('widgets_init', create_function('', 'return register_widget(\'cs_sermon_list\');'));