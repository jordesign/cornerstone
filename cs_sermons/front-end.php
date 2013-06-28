<?php 
/**
 *  Front-End Output Functions
 *
 *  Functions to output the sermon/s within templates. Also used later for the widgets & Shortcodes
 *  
 */
 
 
//
//
//Output a list of sermons by date
function cs_list_sermons(
    $sermonCount = NULL,     //Number of Sermons to show. Defaults to 1
    $sermonSpeaker = false,      //Show Speaker Name (True/False)
    $sermonSeries = false,   //Show Series Title (True/False)
    $sermonImage = false     //Show Series Image
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
    		    
    		    <div class="cs_sermon <?php if ($sermonImage) { echo 'hasimage';} ?>">
    		    
    		        <?php if ($sermonImage) {
    		            $size = apply_filters( 'cs_sermon_img_size', "cs_sermon_img" ); // (thumbnail, medium, large, full or custom size)
    		            print apply_filters( 'taxonomy-images-list-the-terms', '',array(
    		            'image_size' => $size,
    		            'class' => 'sermonImage',
    		            'taxonomy' => 'series',
    		            'after'        => '',
    		            'after_image'  => '',
    		            'before'       => '',
    		            'before_image' => '',
    		            ) );
    		        }  ?>
    		        
    		        <p class="cs_sermon_title">
    		            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> 
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
 
 
 
 //
 //
 //Output a single sermon identified by its ID
 function cs_single_sermon(
     $sermonID = NULL,     //ID of the sermon to include
     $sermonSpeaker = false,      //Show Speaker Name (True/False)
     $sermonSeries = false,   //Show Series Title (True/False)
     $sermonImage = false     //Show Series Image
 ){
 
 
     // The Query
     $cs_sermon_query = new WP_Query("post_type=sermon&p=$sermonID&post_per_page=1" );
 
     // The Loop
     if ( $cs_sermon_query->have_posts() ) {
     	while ( $cs_sermon_query->have_posts() ) {
     		$cs_sermon_query->the_post(); ?>
     		    
     		    <div class="cs_sermon <?php if ($sermonImage) { echo 'hasimage';} ?>">
     		    
         		    <?php if ($sermonImage) {
         		        $size = apply_filters( 'cs_sermon_img_size', "cs_sermon_img" ); // (thumbnail, medium, large, full or custom size)
         		        print apply_filters( 'taxonomy-images-list-the-terms', '',array(
         		        'image_size' => $size,
         		        'class' => 'sermonImage',
         		        'taxonomy' => 'series',
         		        'after'        => '',
         		        'after_image'  => '',
         		        'before'       => '',
         		        'before_image' => '',
         		        ) );
         		    }  ?>
     		        
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
  
  
 
 //
 //
 // Output CS Sermons taxonomy summary
 function cs_sermon_taxonomy_details() { 
     if (is_tax('speaker')){
         $cs_sermon_tax = get_the_terms( get_the_ID(), 'speaker' );
     }
     if (is_tax('series')){
         $cs_sermon_tax = get_the_terms( get_the_ID(), 'series' );
     } ?>
         
     <?php foreach ( $cs_sermon_tax as $term ) {  ?>
         <p class="cs_sermon_taxonomy_name">
             <?php echo $term->taxonomy; ?>
         </p>
         <h1><?php echo $term->name; ?></h1>
     <?php } ?>
     
     <div class="cs_sermon_tax_details">
     
         <?php if (is_tax('speaker')){
             print apply_filters( 'taxonomy-images-list-the-terms', '',array(
                 'image_size' => 'medium',
                 'class' => 'cs_sermon_tax_image',
                 'taxonomy' => 'speaker',
                 'after'        => '',
                     'after_image'  => '',
                     'before'       => '',
                     'before_image' => '',
                 ) ); 
                 echo term_description( '', get_query_var( 'speaker' ) ); 
         }
         if (is_tax('series')){
             print apply_filters( 'taxonomy-images-list-the-terms', '',array(
                 'image_size' => 'medium',
                 'class' => 'cs_sermon_tax_image',
                 'taxonomy' => 'series',
                 'after'        => '',
                     'after_image'  => '',
                     'before'       => '',
                     'before_image' => '',
                 ) ); 
                 echo term_description( '', get_query_var( 'series' ) );
         }
         
          ?>
     </div>
 
 <?php }
 
 
 
 
 /**
  *  Front-End Filters
  *
  *  Filter the existing the_post() and the_title() to include data from the 'sermon' CPT
  *  
  */
  
 //
 //
 //Filter the_title() to include date for sermons
 function cs_sermon_filter_title($title) {
 	if( is_main_query() && get_post_type() == 'sermon' && in_the_loop() ) {
 		
 				
 		$new_title = ' <span class="cs_sermon_date">';
 		$new_title .= get_the_date();
 		$new_title .= '</span>';
 	    $title =  $title . $new_title;	
 	}	
 	
 
 	return $title; 	
 	
 }
 add_filter('the_title', 'cs_sermon_filter_title');
 
 
 //
 //
 //Filter the_content() for sermons
 function cs_sermon_filter_content($content) {
 	if( is_main_query() && get_post_type() == 'sermon' ) {
 	
 	    $cs_speakers = get_the_terms( get_the_ID(), 'speaker' );
 	    $cs_series = get_the_terms( get_the_ID(), 'series');
 	    $new_content = '';
 	    if ( is_singular() ){
 	        //add the audio player
 	        $new_content = '<audio src="';
 	        $new_content .= get_field('sermon_audio');
 	        $new_content .='" controls="controls"></audio>';
 	    }
 	    
 		$new_content .= '<p class="cs_sermon_meta">';
 		
 		// Add speakers
 		if ( $cs_speakers && ! is_wp_error( $cs_speakers ) ) : 
 		    
 		    $new_content .= '<span class="cs_sermon_speaker">Speaker: ';
 		
 			foreach ( $cs_speakers as $term ) {
 			    $new_content .= '<a href="' . home_url() . '/' . $term->taxonomy . '/' .  $term->slug . '">' . $term->name . '</a> &nbsp;';
 				
 			}
 			$new_content .= '</span>';
 			
         endif;
         
         // add series
         if ( $cs_series && ! is_wp_error( $cs_series ) ) : 
             
             $new_content .= '<span class="cs_sermon_series">Series: ';
         
         	foreach ( $cs_series as $term ) {
         	    $new_content .= '<a href="' . home_url() . '/' . $term->taxonomy . '/' . $term->slug . '">' . $term->name . '</a> &nbsp;';
         		
         	}
         	$new_content .= '</span>';
         	
         endif;
 		  		
 		  $new_content .= '</p>';		
 	    $content = $new_content . $content;	
 	}	
 	return $content;
 }
 add_filter('the_content', 'cs_sermon_filter_content');