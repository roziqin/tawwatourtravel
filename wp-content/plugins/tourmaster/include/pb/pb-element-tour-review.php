<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/

	add_action('plugins_loaded', 'tourmaster_add_pb_element_tour_review');
	if( !function_exists('tourmaster_add_pb_element_tour_review') ){
		function tourmaster_add_pb_element_tour_review(){

			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('tour_review', 'tourmaster_pb_element_tour_review'); 
			}
			
		}
	}
	
	if( !class_exists('tourmaster_pb_element_tour_review') ){
		class tourmaster_pb_element_tour_review{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-star',
					'title' => esc_html__('Tour Review', 'tourmaster')
				);
			}
			
			// return the element options
			static function get_options(){
				return apply_filters('tourmaster_tour_item_options', array(		
					'general' => array(
						'title' => esc_html__('General', 'tourmaster'),
						'options' => array(
							'num-display' => array(
								'title' => esc_html__('Num Display', 'tourmaster'),
								'type' => 'text',
								'default' => 3
							),
						)
					),			
					'spacing' => array(
						'title' => esc_html('Spacing', 'tourmaster'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'tourmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '30px'
							)
						)
					),
				));
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				return $content;
			}			

			// get the content from settings
			static function get_content( $settings = array() ){
				
				// default variable
				$settings = empty($settings)? array('num-display' => 3): $settings;
	
				$ret  = '<div class="tourmaster-tour-review-item tourmaster-item-pdlr clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != '30px' ){
					$ret .= tourmaster_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				
				$results = tourmaster_get_booking_data(
					array('review_score' => 'IS NOT NULL', 'order_status' => array( 'condition' => '!=', 'value' => 'cancel' )), 
					array('num-fetch' => $settings['num-display'], 'paged' => 1, 'orderby' => 'review_date', 'order' => 'desc', 'with-review' => true),
					'tour_id, user_id, review_score'
				);

				if( !empty($results) ){
					foreach( $results as $result ){
						$ret .= '<div class="tourmaster-tour-review-item-list" >';
						$ret .= '<div class="tourmaster-tour-review-item-avatar tourmaster-media-image" >';
						$ret .= get_avatar($result->user_id, 85);
						$ret .= '</div>'; 

						$ret .= '<div class="tourmaster-tour-review-item-content" >';
						$ret .= '<h3 class="tourmaster-tour-review-item-title" ><a href="' . get_permalink($result->tour_id) . '" >' . get_the_title($result->tour_id) . '</a></h3>';
						$ret .= '<div class="tourmaster-tour-review-item-rating" >';
						$ret .= tourmaster_get_rating($result->review_score);
						$ret .= '<span class="tourmaster-tour-review-item-user" >' . tourmaster_get_user_meta($result->user_id) . '</span>';
						$ret .= '</div>';
						$ret .= '</div>';
						$ret .= '</div>';
					}
				}
				
				$ret .= '</div>'; // tourmaster-tour-search-item
				
				return $ret;
			}		

		} // tourmaster_pb_element_tour
	} // class_exists	