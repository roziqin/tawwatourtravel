<?php
/**
 * The template for displaying pages
 */

	get_header();
	global $wpdb;

	echo do_shortcode( '[rev_slider alias="1"]' );
	?>
	<div class="gdlr-core-text-box-item gdlr-core-item-pdlr gdlr-core-item-pdb gdlr-core-left-align">
	   <div class="gdlr-core-text-box-item-content">
	      	<h3 class="text-uppercase ct-u-marginBottom10 text-center" style="text-align: center;margin-top: 40px;">PAKET TERPOPULER</h3>
	      	<p class="text-center" style="text-align: center;">Kami menyediakan berbagai pilihan paket wisata yang dapat anda pilih sesuai kebutuhan.</p>
	   </div>
	</div>

	<div class="gdlr-core-pbf-wrapper custom" >
	   <div class="gdlr-core-pbf-wrapper-content gdlr-core-js ">
	      <div class="gdlr-core-pbf-wrapper-container clearfix gdlr-core-container">
	         <div class="gdlr-core-pbf-element">
	            <div class="tourmaster-tour-item clearfix  tourmaster-tour-item-style-grid tourmaster-tour-item-column-3" style="padding-bottom: 0px;">
	               <div class="tourmaster-tour-item-holder gdlr-core-js-2 clearfix page-home" data-layout="fitrows">
						<?php
						$args = array(
							'post_type' => 'tour',
							'posts_per_page'=> 6,
							'tour_tag'		=> 'featured',
							'orderby' => 'ID',
							'order'   => 'ASC',
						);

						$the_query = new WP_Query( $args );
						// The Loop
						if ( $the_query->have_posts() ) {
							while ( $the_query->have_posts() ) {
								$thumb_id = get_post_thumbnail_id();
								$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);


								$the_query->the_post();
								$thumbnail = get_the_post_thumbnail_url($thumb_id,"full-size");
								$thumbnail_value = get_post_meta( get_the_ID(), 'tour_secondary-image_thumbnail_id', true );

								$url_tour = get_permalink();

								$result = $wpdb->get_results("SELECT * FROM wp_posts pt, wp_postmeta pm where pt.ID=pm.post_id and pt.ID='$thumbnail_value' and post_type='attachment' and meta_key='_wp_attached_file' ");
								foreach ($result as $post) {
								setup_postdata($post);
									$link_second = $post->meta_value;
								}


								?>
								<div class="col-xs-4 custom-box">
								   	<div class="ct-productBox ct-u-marginBottom40 box-paket" style="background-image: url('/newtawwatour/wp-content/uploads/<?php echo $link_second; ?>');">
								      <div class="overlay"></div>
								      	<a href="<?php echo $url_tour; ?>">
								         	<div class="ct-productBox-Description ct-u-colorWhite">
									            
								         	</div>
								      	</a>
								   	</div>
								</div>

								<?php
							}
							/* Restore original Post Data */
							wp_reset_postdata();
						} else {
							// no posts found
						}
						?>

			                  
	               </div>
	            </div>
	         </div>
	      </div>
	   </div>
	</div>
	
	<?php
	while( have_posts() ){ the_post();
	
		$post_option = traveltour_get_post_option(get_the_ID());
		$show_content = (empty($post_option['show-content']) || $post_option['show-content'] == 'enable')? true: false;

		if( empty($post_option['sidebar']) ){
			$sidebar_type = 'none';
			$sidebar_left = '';
			$sidebar_right = '';
		}else{
			$sidebar_type = empty($post_option['sidebar'])? 'none': $post_option['sidebar'];
			$sidebar_left = empty($post_option['sidebar-left'])? '': $post_option['sidebar-left'];
			$sidebar_right = empty($post_option['sidebar-right'])? '': $post_option['sidebar-right'];
		}

		if( $sidebar_type == 'none' ){

			// content from wordpress editor area
			ob_start();
			the_content();
			$content = ob_get_contents();
			ob_end_clean();

			if( ($show_content && trim($content) != "") || post_password_required() ){
				echo '<div class="traveltour-content-container traveltour-container">';
				echo '<div class="traveltour-content-area traveltour-item-pdlr traveltour-sidebar-style-none clearfix" >';
				echo gdlr_core_escape_content($content);
				echo '</div>'; // traveltour-content-area
				echo '</div>'; // traveltour-content-container
			}

			if( !post_password_required() ){
				do_action('gdlr_core_print_page_builder');
			}

			// comments template
			if( comments_open() || get_comments_number() ){
				echo '<div class="traveltour-page-comment-container traveltour-container" >';
				echo '<div class="traveltour-page-comments traveltour-item-pdlr" >';
				comments_template();
				echo '</div>';
				echo '</div>';
			}

		}else{

			echo '<div class="traveltour-content-container traveltour-container">';
			echo '<div class="' . traveltour_get_sidebar_wrap_class($sidebar_type) . '" >';

			// sidebar content
			echo '<div class="' . traveltour_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
			
			// content from wordpress editor area
			ob_start();
			the_content();
			$content = ob_get_contents();
			ob_end_clean();

			if( ($show_content && trim($content) != "") || post_password_required() ){
				echo '<div class="traveltour-content-area traveltour-item-pdlr" >' . $content . '</div>'; // traveltour-content-wrapper
			}

			if( !post_password_required() ){
				do_action('gdlr_core_print_page_builder');
			}

			// comments template
			if( comments_open() || get_comments_number() ){
				echo '<div class="traveltour-page-comments traveltour-item-pdlr" >';
				comments_template();
				echo '</div>';
			}

			echo '</div>'; // traveltour-get-sidebar-class

			// sidebar left
			if( $sidebar_type == 'left' || $sidebar_type == 'both' ){
				echo traveltour_get_sidebar($sidebar_type, 'left', $sidebar_left);
			}

			// sidebar right
			if( $sidebar_type == 'right' || $sidebar_type == 'both' ){
				echo traveltour_get_sidebar($sidebar_type, 'right', $sidebar_right);
			}

			echo '</div>'; // traveltour-get-sidebar-wrap-class
		 	echo '</div>'; // traveltour-content-container

		}
		
	} // while



	get_footer(); 
?>