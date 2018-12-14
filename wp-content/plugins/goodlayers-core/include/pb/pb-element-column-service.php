<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('column-service', 'gdlr_core_pb_element_column_service'); 
	
	if( !class_exists('gdlr_core_pb_element_column_service') ){
		class gdlr_core_pb_element_column_service{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-align-left',
					'title' => esc_html__('Column Service', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;

				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'media-type' => array(
								'title' => esc_html__('Media Type', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'icon' => esc_html__('Icon', 'goodlayers-core'),
									'image' => esc_html__('Image', 'goodlayers-core'),
								),
								'default' => 'icon',
							),
							'icon' => array(
								'title' => esc_html__('Icon Selector', 'goodlayers-core'),
								'type' => 'icons',
								'default' => 'fa fa-gear',
								'wrapper-class' => 'gdlr-core-fullsize',
								'condition' => array( 'media-type' => 'icon' )
							),
							'icon-style' => array(
								'title' => esc_html__('Icon Style', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'normal' => esc_html__('Normal', 'goodlayers-core'),
									'round' => esc_html__('Round Background', 'goodlayers-core'),
								),
								'condition' => array( 'media-type' => 'icon' )
							),
							'image' => array(
								'title' => esc_html__('Upload', 'goodlayers-core'),
								'type' => 'upload',
								'condition' => array( 'media-type' => 'image' )
							),
							'title' => array(
								'title' => esc_html__('Title', 'goodlayers-core'),
								'type' => 'text',
								'default' => esc_html__('Column Service Title', 'goodlayers-core'),
							),
							'caption' => array(
								'title' => esc_html__('Caption', 'goodlayers-core'),
								'type' => 'textarea',
							),
							'content' => array(
								'title' => esc_html__('Content', 'goodlayers-core'),
								'type' => 'tinymce',
								'default' => esc_html__('Column service content area', 'goodlayers-core'),
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'read-more-text' => array(
								'title' => esc_html__('Read More Text', 'goodlayers-core'),
								'type' => 'text',
								'default' => esc_html__('Read More', 'goodlayers-core')
							),
							'read-more-link' => array(
								'title' => esc_html__('Read More Link', 'goodlayers-core'),
								'type' => 'text',
								'default' => '#'
							),	
						),
					),
					'style' => array(
						'title' => esc_html('Style', 'goodlayers-core'),
						'options' => array(
							'style' => array(
								'title' => esc_html__('Column Service Style', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => array(
									'center_icon-top' => GDLR_CORE_URL . '/include/images/column-service/center-icon-top.png',
									'left_icon-top' => GDLR_CORE_URL . '/include/images/column-service/left-icon-top.png',
									'left_icon-left' => GDLR_CORE_URL . '/include/images/column-service/left-icon-left.png',
									'left_icon-left-title' => GDLR_CORE_URL . '/include/images/column-service/left-icon-left-title.png',
									'right_icon-top' => GDLR_CORE_URL . '/include/images/column-service/right-icon-top.png',
									'right_icon-left' => GDLR_CORE_URL . '/include/images/column-service/right-icon-left.png',
									'right_icon-left-title' => GDLR_CORE_URL . '/include/images/column-service/right-icon-left-title.png',
								),
								'default' => 'center_icon-top',
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							
						),
					),
					'typography' => array(
						'title' => esc_html('Typography', 'goodlayers-core'),
						'options' => array(
							'icon-size' => array(
								'title' => esc_html__('Icon Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '30px'
							),
							'title-size' => array(
								'title' => esc_html__('Title Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '14px'
							),
							'title-font-weight' => array(
								'title' => esc_html__('Title Font Weight', 'goodlayers-core'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'goodlayers-core')
							),
							'title-letter-spacing' => array(
								'title' => esc_html__('Title Letter Spacing', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'title-text-transform' => array(
								'title' => esc_html__('Title Text Transform', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'uppercase' => esc_html__('Uppercase', 'goodlayers-core'),
									'lowercase' => esc_html__('Lowercase', 'goodlayers-core'),
									'capitalize' => esc_html__('Capitalize', 'goodlayers-core'),
									'none' => esc_html__('None', 'goodlayers-core'),
								),
								'default' => 'uppercase'
							),
							'caption-size' => array(
								'title' => esc_html__('Caption Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '14px'
							),
							'content-size' => array(
								'title' => esc_html__('Content Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '15px'
							),
							'read-more-size' => array(
								'title' => esc_html__('Read More Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '14px'
							),
						)
					),					
					'color' => array(
						'title' => esc_html('Color', 'goodlayers-core'),
						'options' => array(
							'icon-color' => array(
								'title' => esc_html__('Icon Color', 'goodlayers-core'),
								'type' => 'colorpicker'
							),
							'icon-background' => array(
								'title' => esc_html__('Icon Background Color', 'goodlayers-core'),
								'type' => 'colorpicker'
							),
							'background-color' => array(
								'title' => esc_html__('Column Service Background Color', 'goodlayers-core'),
								'type' => 'colorpicker',
							),
						)
					),
					'background' => array(
						'title' => esc_html('Spacing', 'goodlayers-core'),
						'options' => array(						
							'media-margin' => array(
								'title' => esc_html__('Icon/Image Margin', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'wrapper-class' => 'gdlr-core-no-link',
								'description' => esc_html__('Leave this field blank for default value.', 'goodlayers-core'),
							),
							'title-top-padding' => array(
								'title' => esc_html__('Title Top Padding', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'description' => esc_html__('Leave this field blank for default value.', 'goodlayers-core'),
							),
							'title-bottom-margin' => array(
								'title' => esc_html__('Title Bottom Margin', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),							
							'caption-top-margin' => array(
								'title' => esc_html__('Caption Top Margin', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'read-more-top-margin' => array(
								'title' => esc_html__('Read More Top Margin', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'description' => esc_html__('The value will be added to the initial value ( 20px )', 'goodlayers-core'),
							),
							'padding' => array(
								'title' => esc_html__('Padding Spaces ( Inside Background )', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'wrapper-class' => 'gdlr-core-no-link',
								'default' => array( 'top'=>'', 'right'=>'', 'bottom'=>$gdlr_core_item_pdb, 'left'=>'', 'settings'=>'unlink' )
							),
							'margin' => array(
								'title' => esc_html__('Padding Spaces ( Outside Background )', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link' )
							),
						)
					)
				);
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-column-service-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-column-service-<?php echo esc_attr($id); ?>').parent().gdlr_core_content_script();
});
</script><?php	
				$content .= ob_get_contents();
				ob_end_clean();
				
				return $content;
			}		
			
			// get the content from settings
			static function get_content( $settings = array() ){

				// default variable
				if( empty($settings) ){
					$settings = array(
						'icon' => 'fa fa-gear',
						'title' => esc_html__('Column Service Title', 'goodlayers-core'),
						'caption' => '',
						'content' => esc_html__('Column service content area', 'goodlayers-core'),
						'read-more-text' => esc_html__('Read More', 'goodlayers-core'),
						'read-more-link' => '#',
						'style' => 'center_icon-top'
					);
				}
				
				// default size
				$settings['icon-size'] = (empty($settings['icon-size']) || $settings['icon-size'] == '30px')? '': $settings['icon-size'];
				$settings['title-size'] = (empty($settings['title-size']) || $settings['title-size'] == '14px')? '': $settings['title-size'];
				$settings['caption-size'] = (empty($settings['caption-size']) || $settings['caption-size'] == '14px')? '': $settings['caption-size'];
				$settings['content-size'] = (empty($settings['content-size']) || $settings['content-size'] == '15px')? '': $settings['content-size'];
				$settings['read-more-size'] = (empty($settings['read-more-size']) || $settings['read-more-size'] == '14px')? '': $settings['read-more-size'];
				
				$cs_style = explode('_', $settings['style']);
				$text_align = empty($cs_style[0])? 'center': $cs_style[0];
				$style = empty($cs_style[1])? 'icon-top': $cs_style[1];
				
				// start printing item
				$extra_class  = ' gdlr-core-' . $text_align . '-align';
				$extra_class .= ($text_align == 'center')? '': ' gdlr-core-column-service-' . $style;
				$extra_class .= empty($settings['caption'])? ' gdlr-core-no-caption': ' gdlr-core-with-caption';
				$extra_class .= empty($settings['no-pdlr'])? ' gdlr-core-item-pdlr': '';
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="gdlr-core-column-service-item gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				$ret .= gdlr_core_esc_style(array(
					'background-color' => empty($settings['background-color'])? '': $settings['background-color'],
					'padding'=> (empty($settings['padding']) || $settings['padding'] == array(
						'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'unlink'
					))? '': $settings['padding'],
					'margin'=> (empty($settings['margin']) || $settings['margin'] == array(
						'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link'
					))? '': $settings['margin'],
				));
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				
				// media
				$media_html = '';
				if( empty($settings['media-type']) || $settings['media-type'] != 'none' ){
					$media_atts = array(
						'margin' => empty($settings['media-margin'])? array(): $settings['media-margin'],
					); 
				
					if( empty($settings['media-type']) || $settings['media-type'] == 'icon' ){
						$icon_class = '';
						$icon_inner_class = '';
						if( !empty($settings['icon-style']) && $settings['icon-style'] == 'round' ){
							$icon_class .= ' gdlr-core-icon-style-round';
							$icon_inner_class .= ' gdlr-core-skin-e-background gdlr-core-skin-e-content';
						}

						$media_html  = '<div class="gdlr-core-column-service-media gdlr-core-media-icon ' . $icon_class . '" ' . gdlr_core_esc_style($media_atts) . ' >';
						$media_html .= '<i class="' . esc_attr($settings['icon']) . esc_attr($icon_inner_class) . '" ' . gdlr_core_esc_style(array(
							'font-size'=>$settings['icon-size'],
							'line-height'=>$settings['icon-size'],
							'width'=>$settings['icon-size'],
							'color'=>(empty($settings['icon-color'])? '': $settings['icon-color']),
							'background-color'=>(empty($settings['icon-background'])? '': $settings['icon-background'])
						)) . ' ></i>';
						$media_html .= '</div>';
					}else if( !empty($settings['media-type']) && $settings['media-type'] == 'image' && !empty($settings['image']) ){
						$media_html  = '<div class="gdlr-core-column-service-media gdlr-core-media-image" ' . gdlr_core_esc_style($media_atts) . ' >';
						$media_html .= gdlr_core_get_image($settings['image']);
						$media_html .= '</div>';
					}
				}
				
				if( ($text_align == 'center' || $style != 'icon-left-title') ){
					$ret .= $media_html;
					$ret .= '<div class="gdlr-core-column-service-content-wrapper" >';
				}else{
					$ret .= '<div class="gdlr-core-column-service-content-wrapper" >';
					$ret .= $media_html;
				}
				
				// title
				$ret .= '<div class="gdlr-core-column-service-title-wrap" ' . gdlr_core_esc_style(array(
					'margin-bottom' => empty($settings['title-bottom-margin'])? '': $settings['title-bottom-margin']
				)) . ' >';
				if( !empty($settings['title']) ){
					$ret .= '<h3 class="gdlr-core-column-service-title" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['title-size'],
						'padding-top' => empty($settings['title-top-padding'])? '': $settings['title-top-padding'],
						'font-weight' => empty($settings['title-font-weight'])? '': $settings['title-font-weight'],
						'letter-spacing' => empty($settings['title-letter-spacing'])? '': $settings['title-letter-spacing'],
						'text-transform' => (empty($settings['title-text-transform']) || $settings['title-text-transform'] == 'uppercase')? '': $settings['title-text-transform']
					)) . ' >' . gdlr_core_text_filter($settings['title']) . '</h3>';
				}
				if( !empty($settings['caption']) ){
					$ret .= '<div class="gdlr-core-column-service-caption gdlr-core-info-font gdlr-core-skin-caption" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['caption-size'],
						'margin-top' => empty($settings['caption-top-margin'])? '': $settings['caption-top-margin']
					)) . ' >' . gdlr_core_text_filter($settings['caption']) . '</div>';
				}
				$ret .= '</div>'; // gdlr-core-column-service-title-wrap
				
				// content
				if( !empty($settings['content']) || (!empty($settings['read-more-text']) && !empty($settings['read-more-link'])) ){
					$ret .= '<div class="gdlr-core-column-service-content" ' . gdlr_core_esc_style(array('font-size'=>$settings['content-size'])) . ' >';
					if( !empty($settings['content']) ){
						$ret .= gdlr_core_content_filter($settings['content']);
					}
					if( !empty($settings['read-more-text']) && !empty($settings['read-more-link']) ){
						$ret .= '<a class="gdlr-core-column-service-read-more gdlr-core-info-font" href="' . esc_attr($settings['read-more-link']) . '" ';
						$ret .= gdlr_core_esc_style(array(
							'font-size'=>$settings['read-more-size'],
							'margin-top' => empty($settings['read-more-top-margin'])? '': $settings['read-more-top-margin']
						)) . ' >' . gdlr_core_escape_content($settings['read-more-text']) . '</a>';
					}
					$ret .= '</div>'; // gdlr-core-column-service-content
				}
				$ret .= '</div>'; // gdlr-core-column-service-content-wrapper
				$ret .= '</div>'; // gdlr-core-column-service-content-wrapper
				
				return $ret;
			}			
			
		} // gdlr_core_pb_element_column_service
	} // class_exists	

	// [gdlr_core_column_service icon="" title="" caption="" style="left_icon-left" ][/gdlr_core_column_service]
	add_shortcode('gdlr_core_column_service', 'gdlr_core_column_service_shortcode');
	if( !function_exists('gdlr_core_column_service_shortcode') ){
		function gdlr_core_column_service_shortcode($atts, $content = ''){
			$atts = wp_parse_args($atts, array(
				'no-pdlr' => true, 
				'style' => 'left_icon-left'
			));

			$atts['content'] = $content;

			return gdlr_core_pb_element_column_service::get_content($atts);
		}
	}