<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('image', 'gdlr_core_pb_element_image'); 
	
	if( !class_exists('gdlr_core_pb_element_image') ){
		class gdlr_core_pb_element_image{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_image',
					'title' => esc_html__('Image', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'image' => array(
								'title' => esc_html__('Upload Image', 'goodlayers-core'),
								'type' => 'upload'
							),
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => 'thumbnail-size'
							),
							'link-to' => array(
								'title' => esc_html__('Link To', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'lb-full-image' => esc_html__('Lightbox with full image', 'goodlayers-core'),
									'lb-custom-image' => esc_html__('Lightbox with custom image', 'goodlayers-core'),
									'lb-video' => esc_html__('Video Lightbox', 'goodlayers-core'),
									'page-url' => esc_html__('Specific Page', 'goodlayers-core'),
									'custom-url' => esc_html__('Custom Url', 'goodlayers-core'),
									'none' => esc_html__('None', 'goodlayers-core')
								),
								'default' => 'lb-full-image'
							),
							'custom-image' => array(
								'title' => esc_html__('Upload Custom Image', 'goodlayers-core'),
								'type' => 'upload',
								'condition' => array( 'link-to' => 'lb-custom-image' )
							),
							'video-url' => array(
								'title' => esc_html__('Video Url ( Youtube / Vimeo )', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'link-to' => 'lb-video' )
							),
							'page-id' => array(
								'title' => esc_html__('Page Id', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => gdlr_core_get_post_list('page'),
								'condition' => array( 'link-to' => 'page-url' )
							),
							'custom-url' => array(
								'title' => esc_html__('Custom Url', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'link-to' => 'custom-url' )
							),
							'custom-link-target' => array(
								'title' => esc_html__('Custom Link Target', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'_self' => esc_html__('Current Screen', 'goodlayers-core'),
									'_blank' => esc_html__('New Window', 'goodlayers-core'),
								),
								'condition' => array( 'link-to' => 'custom-url' )
							),
							'overlay-icon-type' => array(
								'title' => esc_html__('Overlay Icon', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'default' => esc_html__('Default', 'goodlayers-core'),
									'custom' => esc_html__('Custom', 'goodlayers-core'),
									'none' => esc_html__('None ( Background Overlay )', 'goodlayers-core'),
									'no-overlay' => esc_html__('No Overlay', 'goodlayers-core'),
								)
							),
							'overlay-icon-style' => array(
								'title' => esc_html__('Overlay Icon Style', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'on-hover' => esc_html__('On Hover', 'goodlayers-core'),
									'always-show' => esc_html__('Always Show ( With Round Icon )', 'goodlayers-core'),
								),
								'condition' => array( 'overlay-icon-type' => 'custom' ),
							),
							'overlay-icon' => array(
								'title' => esc_html__('Icon', 'goodlayers-core'),
								'type' => 'icons',
								'allow-none' => true,
								'default' => 'fa fa-android',
								'condition' => array( 'overlay-icon-type' => 'custom' ),
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'enable-caption' => array(
								'title' => esc_html__('Enable Caption', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
						)
					),
					'style' => array(
						'title' => esc_html__('Style', 'goodlayers-core'),
						'options' => array(
							'max-width' => array(
								'title' => esc_html__('Max Width', 'goodlayers-core'),
								'type' => 'text',
							),
							'alignment' => array(
								'title' => esc_html__('Alignment ( If max width option is specified )', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'center'
							),
							'enable-shadow' => array(
								'title' => esc_html__('Enable Shadow', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable'
							),		
							'frame-style' => array(
								'title' => esc_html__('Frame Style', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'rectangle' => esc_html__('Rectangle', 'goodlayers-core'),
									'round' => esc_html__('Round', 'goodlayers-core'),
									'circle' => esc_html__('Circle', 'goodlayers-core'),
								)
							),
							'border-radius' => array(
								'title' => esc_html__('Border Radius', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '3px',
								'condition' => array( 'frame-style' => 'round' )
							),
							'border-width' => array(
								'title' => esc_html__('Border Width', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '0px'
							),
							'overlay-icon-size' => array(
								'title' => esc_html__('Overlay Icon Size', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'15' => esc_html__('Small', 'goodlayers-core'),
									'22' => esc_html__('Medium', 'goodlayers-core'),
									'28' => esc_html__('Large', 'goodlayers-core'),
								),
								'default' => '22'
							),
						)
					),
					'color' => array(
						'title' => esc_html('Color', 'goodlayers-core'),
						'options' => array(
							'border-color' => array(
								'title' => esc_html__('Border Color', 'goodlayers-core'),
								'type' => 'colorpicker'
							),		
							'overlay-color' => array(
								'title' => esc_html__('Overlay Background Color', 'goodlayers-core'),
								'type' => 'colorpicker'
							),		
							'overlay-icon-color' => array(
								'title' => esc_html__('Overlay Icon Color', 'goodlayers-core'),
								'type' => 'colorpicker'
							),		
							'overlay-icon-background' => array(
								'title' => esc_html__('Overlay Icon Background Color ( Round Icon Style )', 'goodlayers-core'),
								'type' => 'colorpicker'
							),
							'overlay-background-opacity' => array(
								'title' => esc_html__('Overlay Background Opacity', 'goodlayers-core'),
								'type' => 'text',
								'default' => '0.6',
								'description' => esc_html__('Fill the decimal number between 0 to 1', 'goodlayers-core')
							)
						)
					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'goodlayers-core'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							)
						)
					)
				);
			}
			
			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-image-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-image-<?php echo esc_attr($id); ?>').parent().gdlr_core_lightbox();
});
</script><?php	
				$content .= ob_get_contents();
				ob_end_clean();
				
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array() ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'image' => '', 'link-to' => 'lb-full-image', 'enable-shadow' => 'disable',
						'enable-caption' => 'enable',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				// start printing item
				$extra_class  = ' gdlr-core-' . (empty($settings['alignment'])? 'center': $settings['alignment']) . '-align';
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="gdlr-core-image-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				$image_wrap_class  = (empty($settings['enable-shadow']) || $settings['enable-shadow'] == 'disable')? '': ' gdlr-core-with-shadow';
				$image_wrap_class .= ' gdlr-core-image-item-style-' . (empty($settings['frame-style'])? 'rectangle': $settings['frame-style']);
				
				$ret .= '<div class="gdlr-core-image-item-wrap gdlr-core-media-image ' . esc_attr($image_wrap_class) . '" ' . gdlr_core_esc_style(array(
					'border-radius' => (empty($settings['border-radius']) || $settings['border-radius'] == '3px')? '': $settings['border-radius'],
					'border-width' => empty($settings['border-width'])? '0px': $settings['border-width'],
					'border-color' => empty($settings['border-color'])? '': $settings['border-color'],
					'max-width' => empty($settings['max-width'])? '': $settings['max-width']
				)) . ' >'; 

				$image_atts = array();

				if( !empty($settings['link-to']) && $settings['link-to'] != 'none' ){
								
					if( $settings['link-to'] == 'lb-full-image' ){
						$image_atts['lightbox'] = true;
					}else if( $settings['link-to'] == 'lb-custom-image' ){
						if( !empty($settings['custom-image']) ){
							$image_atts['lightbox'] = 'image';
							$image_atts['lightbox-image'] = $settings['custom-image'];
						}
					}else if( $settings['link-to'] == 'lb-video' ){
						if( !empty($settings['video-url']) ){
							$image_atts['lightbox'] = 'video';
							$image_atts['lightbox-video'] = $settings['video-url'];
						}
					}else if( $settings['link-to'] == 'page-url' ){
						if( !empty($settings['page-id']) ){
							$image_atts['link'] = get_permalink($settings['page-id']);
						}
					}else if( $settings['link-to'] == 'custom-url' ){
						if( !empty($settings['custom-url']) ){
							$image_atts['link'] = $settings['custom-url'];
							$image_atts['link-target'] = empty($settings['custom-link-target'])? '': $settings['custom-link-target'];
						}
					}

					if( empty($settings['overlay-icon-type']) || $settings['overlay-icon-type'] != 'no-overlay' ){
						$image_atts['image-overlay'] = true;
						$image_atts['image-overlay-radius'] = (empty($settings['border-radius']) || $settings['border-radius'] == '3px')? '': $settings['border-radius'];
						if( isset($settings['overlay-background-opacity']) ){
							$image_atts['image-overlay-background'] = empty($settings['overlay-color'])? '': array($settings['overlay-color'], $settings['overlay-background-opacity']);
						}else{
							$image_atts['image-overlay-background'] = empty($settings['overlay-color'])? '': array($settings['overlay-color'], 0.6);
						}
						$image_atts['image-overlay-icon-size'] = empty($settings['overlay-icon-size'])? '': 'gdlr-core-size-' . $settings['overlay-icon-size'];
						$image_atts['image-overlay-icon-color'] = empty($settings['overlay-icon-color'])? '': $settings['overlay-icon-color'];

						if( !empty($settings['overlay-icon-type']) && $settings['overlay-icon-type'] == 'custom' && !empty($settings['overlay-icon']) ){
							$image_atts['image-overlay-icon'] = $settings['overlay-icon'];
							$image_atts['image-overlay-icon-type'] = 'custom';
						}else if( !empty($settings['overlay-icon-type']) && $settings['overlay-icon-type'] == 'none' ){
							$image_atts['image-overlay-icon-type'] = 'none';
						} 

						if( !empty($settings['overlay-icon-style']) && $settings['overlay-icon-style'] == 'always-show' ){
							$image_atts['image-overlay-icon-background'] = empty($settings['overlay-icon-background'])? '': $settings['overlay-icon-background'];
							$image_atts['image-overlay-class'] = 'gdlr-core-no-hover gdlr-core-transparent gdlr-core-round-icon';
						}
					}
				}

				$thumbnail_size = empty($settings['thumbnail-size'])? 'full': $settings['thumbnail-size'];
				$ret .= gdlr_core_get_image($settings['image'], $thumbnail_size, $image_atts);
				$ret .= '</div>'; // gdlr-core-image-item-wrap

				if( !empty($settings['image']) && empty($settings['enable-caption']) || $settings['enable-caption'] == 'enable' ){
					$caption = gdlr_core_get_image_info($settings['image'], 'caption');

					if( !empty($caption) ){
						$ret .= '<div class="gdlr-core-image-item-caption gdlr-core-line-height" >';
						$ret .= gdlr_core_text_filter($caption);
						$ret .= '</div>';
					}
				}
				$ret .= '</div>'; // gdlr-core-image-item
				
				return $ret;
			}
			
		} // gdlr_core_pb_element_image
	} // class_exists	