<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( !class_exists('gdlr_core_pb_wrapper_column') ){
		class gdlr_core_pb_wrapper_column{

			private static $col_list = array(
				60 => '1/1', 30 => '1/2', 20 => '1/3', 
				40 => '2/3', 15 => '1/4', 45 => '3/4', 
				12 => '1/5', 24 => '2/5', 36 => '3/5', 
				48 => '4/5', 10 => '1/6', 50 => '5/6', 
			);
			
			// get the element settings
			static function get_settings(){
				return array(	
					'type' => 'column',
					'image_dir' => GDLR_CORE_URL . '/framework/images/page-builder',
					'list' => self::$col_list
				);
			}
			
			static function get_options(){
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'max-width' => array(
								'title' => esc_html__('Max Width', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'description' => esc_html__('Maximum width of this item. Leave blank for full size.', 'goodlayers-core'),
							),
							'min-height' => array(
								'title' => esc_html__('Min Height', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'hide-this-wrapper-in' => array(
								'title' => esc_html__('Hide This Wrapper In', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'desktop' => esc_html__('Desktop', 'goodlayers-core'),
									'desktop-tablet' => esc_html__('Desktop & Tablet', 'goodlayers-core'),
									'tablet' => esc_html__('Tablet', 'goodlayers-core'),
									'tablet-mobile' => esc_html__('Tablet & Mobile', 'goodlayers-core'),
									'mobile' => esc_html__('Mobile', 'goodlayers-core'),
								)
							),
							'animation' => array(
								'title' => esc_html__('Animation', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => gdlr_core_get_animation_option(),
								'default' => 'none'
							),
							'animation-location' => array(
								'title' => esc_html__('Animation Location', 'goodlayers-core'),
								'type' => 'text',
								'default' => '0.8',
								'description' => esc_html__('The location of the object which the animation take places.', 'goodlayers-core') . '<br>' .
									esc_html__('Fill 0 : Animation will start when the item reach the top of the screen', 'goodlayers-core') . '<br>' . 
									esc_html__('Fill 1 : Animation will start when the item is at the bottom of the screen.', 'goodlayers-core')
							),
						),
					),
					'background' => array(
						'title' => esc_html('Background', 'goodlayers-core'),
						'options' => array(
							'full-height' => array(
								'title' => esc_html__('Full Height Wrapper', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable',
								'description' => esc_html__('Effects will only be shown at the front end of the site', 'goodlayers-core'),
							),
							'decrease-height' => array(
								'title' => esc_html__('Decrease Height Of Full Height', 'goodlayers-core'),
								'type' => 'text',
								'default' => '0px',
								'condition' => array( 'full-height' => 'enable' )
							),
							'sync-height' => array(
								'title' => esc_html__('Sync Height', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array('full-height' => 'disable'),
								'description' => esc_html__('Use to sync the height among an items with the same keyword. The height will be fixed so be cautious not to use it on item with dynamic height.', 'goodlayers-core'),
							),
							'centering-sync-height-content' => array(
								'title' => esc_html__('Positioning Content In The Middle Of This Item ( When sync hieght / Full height is being used )', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
							'background-type' => array(
								'title' => esc_html__('Background Type', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'color' => esc_html__('Color', 'goodlayers-core'),
									'image' => esc_html__('Image', 'goodlayers-core'),
									'video' => esc_html__('Video ( Youtube & Vimeo )', 'goodlayers-core'),
									'html5-video' => esc_html__('Html5 Video', 'goodlayers-core'),
									'pattern' => esc_html__('Pattern', 'goodlayers-core'),
								),
								'default' => 'color'
							),
							'background-extending' => array(
								'title' => esc_html__('Background Extending', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'left' => esc_html__('Extend Left', 'goodlayers-core'),
									'right' => esc_html__('Extend Right', 'goodlayers-core'),
								),
								'default' => 'none'
							),
							'background-color' => array(
								'title' => esc_html__('Background Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'background-type' => array('color', 'image') ),
								'description' => esc_html__('Can also be use as a base color of an image (with opacity) as well.', 'goodlayers-core')
							),
							'background-image' => array(
								'title' => esc_html__('Background Image', 'goodlayers-core'),
								'type' => 'upload',
								'condition' => array( 'background-type' => 'image' )
							),
							'background-image-style' => array(
								'title' => esc_html__('Background Image Style', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'cover' => esc_html__('Cover ( full width and height )', 'goodlayers-core'),
									'no-repeat' => esc_html__('No Repeat', 'goodlayers-core'),
									'repeat' => esc_html__('Repeat X & Y', 'goodlayers-core'),
									'repeat-x' => esc_html__('Repeat X', 'goodlayers-core'),
									'repeat-y' => esc_html__('Repeat Y', 'goodlayers-core'),
								),
								'default' => 'cover',
								'condition' => array( 'background-type' => 'image' )
							), 
							'background-image-position' => array(
								'title' => esc_html__('Background Image Position', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'center' => esc_html__('Center', 'goodlayers-core'),
									'top-left' => esc_html__('Top Left', 'goodlayers-core'),
									'top-center' => esc_html__('Top Center', 'goodlayers-core'),
									'top-right' => esc_html__('Top Right', 'goodlayers-core'),
									'center-left' => esc_html__('Center Left', 'goodlayers-core'),
									'center-right' => esc_html__('Center Right', 'goodlayers-core'),
									'bottom-left' => esc_html__('Bottom Left', 'goodlayers-core'),
									'bottom-center' => esc_html__('Bottom Center', 'goodlayers-core'),
									'bottom-right' => esc_html__('Bottom Right', 'goodlayers-core'),
								),
								'default' => 'center',
								'condition' => array( 'background-type' => 'image' )
							),
							'background-video-url' => array(
								'title' => esc_html__('Background Video URL', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'background-type' => 'video' ),
							),
							'background-video-url-mp4' => array(
								'title' => esc_html__('Background Video URL (MP4)', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'background-type' => 'html5-video' ),
							),
							'background-video-url-webm' => array(
								'title' => esc_html__('Background Video URL (WEBM)', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'background-type' => 'html5-video' ),
							),
							'background-video-url-ogg' => array(
								'title' => esc_html__('Background Video URL (ogg)', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'background-type' => 'html5-video' ),
							),
							'background-video-image' => array(
								'title' => esc_html__('Background Image Fallback', 'goodlayers-core'),
								'type' => 'upload',
								'condition' => array( 'background-type' => array('video', 'html5-video') ),
								'description' => esc_html__('This background will be showing up when the device you\'re using cannot render the video as background ( eg. mobile device )', 'goodlayers-core'),
							),
							'background-pattern' => array(
								'title' => esc_html__('Background Pattern', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'pattern',
								'default' => 'pattern-1',
								'wrapper-class' => 'gdlr-core-fullsize',
								'condition' => array( 'background-type' => 'pattern' )
							), 
							'background-opacity' => array(
								'title' => esc_html__('Background Opacity', 'goodlayers-core'),
								'type' => 'text',
								'default' => 1,
								'condition' => array( 'background-type' => array('pattern', 'image', 'color') ), 
								'description' => esc_html__('Fill the number between 0 to 1', 'goodlayers-core')
							), 
							'border-radius' => array(
								'title' => esc_html__('Border Radius', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' ),
							),
							'parallax-speed' => array(
								'title' => esc_html__('Parallax Speed', 'goodlayers-core'),
								'type' => 'text',
								'default' => 0.8,
								'condition' => array( 'background-type' => array('image', 'video', 'html5-video', 'pattern') ), 
								'description' => esc_html__('Fill the number between -1 to 1, ( value 1 equals to background-attachment: fixed )', 'goodlayers-core')
							),
						),
					),
					'border' => array(
						'title' => esc_html('Border', 'goodlayers-core'),
						'options' => array(
							'border-type' => array(
								'title' => esc_html__('Border Type', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'outer-border' => esc_html__('Outer Border', 'goodlayers-core'),
									'inner-border' => esc_html__('Inner Border', 'goodlayers-core'),
								),
								'default' => 'none'
							),
							'border-pre-spaces' => array(
								'title' => esc_html__('Spaces Before Inner Border', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'20px', 'right'=>'20px', 'bottom'=>'20px', 'left'=>'20px', 'settings'=>'link' ),
								'condition' => array( 'border-type' => 'inner-border' ),
							), 
							'border-width' => array(
								'title' => esc_html__('Border Width', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'1px', 'right'=>'1px', 'bottom'=>'1px', 'left'=>'1px', 'settings'=>'link' ),
								'condition' => array( 'border-type' => array('outer-border', 'inner-border') ),
							),
							'border-color' => array(
								'title' => esc_html__('Border Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'default' => '#ffffff',
								'condition' => array( 'border-type' => array('outer-border', 'inner-border') ),
							),
							'border-style' => array(
								'title' => esc_html__('Border Style', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'solid' => esc_html__('solid', 'goodlayers-core'),
									'dotted' => esc_html__('dotted', 'goodlayers-core'),
									'dashed' => esc_html__('dashed', 'goodlayers-core'),
									'double' => esc_html__('double', 'goodlayers-core'),
									'groove' => esc_html__('groove', 'goodlayers-core'),
									'ridge' => esc_html__('ridge', 'goodlayers-core'),
									'inset' => esc_html__('inset', 'goodlayers-core'),
									'outset' => esc_html__('outset', 'goodlayers-core'),
								),
								'default' => 'solid',
								'condition' => array( 'border-type' => array('outer-border', 'inner-border') ),
							),
						)
					),
					'spacing' => array(
						'title' => esc_html__('Spacing', 'goodlayers-core'),
						'options' => array(
							'padding' => array(
								'title' => esc_html__('Padding Spaces', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link' ),
								'description' => esc_html__('Spaces before/after the item inside it. ( including the background area )', 'goodlayers-core')
							),
							'margin' => array(
								'title' => esc_html__('Margin Spaces', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link' ),
								'description' => esc_html__('Spaces before/after this wrapper. ( outside the background area )', 'goodlayers-core')
							),
						)
					),
					'skin' => array(
						'title' => esc_html__('Custom Skin', 'goodlayers-core'),
						'options' => array(
							'skin' => array(
								'title' => esc_html__('Skin', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => 'skin'
							),
						)
					)
					
				);
			}
			
			// get element template for page builder
			static function get_template( $options = array(), $callback = '' ){
				
				$wrapper_style_atts = array(
					'min-height' => empty($options['value']['min-height'])? '': $options['value']['min-height'],
					'margin' => (empty($options['value']['margin']) || $options['value']['margin'] == array(
							'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link'
						))? '': $options['value']['margin'],
					'padding' => (empty($options['value']['padding']) || $options['value']['padding'] == array( 
							'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link' 
						))? '': $options['value']['padding']			
				);
				$content_style_atts = array(
					'max-width' => empty($options['value']['max-width'])? '': $options['value']['max-width']
				);	
				
				// for background
				$wrapper_background = '';
				if( !empty($options['value']['background-type']) ){
					
					// color background
					if( $options['value']['background-type'] == 'color' ){
						
						if( !empty($options['value']['background-color']) ){
							$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
								'background-color' => $options['value']['background-color'],
								'opacity' => (empty($options['value']['background-opacity']) || $options['value']['background-opacity'] == 1)? '': $options['value']['background-opacity'],
								'border-radius' => (empty($options['value']['border-radius']) || $options['value']['border-radius'] == array( 
										'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' 
									))? '': $options['value']['border-radius']
							)) . ' ></div>';
						}
					
					// image background
					}else if( $options['value']['background-type'] == 'image' ){
						$bgi_atts = array(
							'background-image' => empty($options['value']['background-image'])? '': $options['value']['background-image'],
							'opacity' => (empty($options['value']['background-opacity']) || $options['value']['background-opacity'] == 1)? '': $options['value']['background-opacity']
						);
						if( !empty($options['value']['background-image-style']) ){
							if( $options['value']['background-image-style'] == 'cover' ){
								$bgi_atts['background-size'] = 'cover';
							}else{
								$bgi_atts['background-repeat'] = $options['value']['background-image-style'];
							}
							if( !empty($options['value']['background-image-position']) ){
								$bgi_atts['background-position'] = str_replace('-', ' ', $options['value']['background-image-position']);
							}
						}
						
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
							'background-color' => empty($options['value']['background-color'])? '': $options['value']['background-color'],
							'border-radius' => (empty($options['value']['border-radius']) || $options['value']['border-radius'] == array( 
									'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' 
								))? '': $options['value']['border-radius']
						)) . ' >';
						$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style($bgi_atts);
						$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
						$wrapper_background .= ' ></div>';
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					
					// pattern background
					}else if( $options['value']['background-type'] == 'pattern' ){
						$bgi_atts = array(
							'background-image' => GDLR_CORE_URL . '/include/images/pattern/' . (empty($options['value']['background-pattern'])? 'pattern-1': $options['value']['background-pattern']) . '.png',
							'background-repeat' => 'repeat',
							'background-position' => 'center',
							'opacity' => (empty($options['value']['background-opacity']) || $options['value']['background-opacity'] == 1)? '': $options['value']['background-opacity'],
						);
						
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
							'border-radius' => (empty($options['value']['border-radius']) || $options['value']['border-radius'] == array( 
									'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' 
								))? '': $options['value']['border-radius']
						)) . ' >';
						$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style($bgi_atts);
						$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
						$wrapper_background .= ' ></div>';
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					
					// video background
					}else{
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
							'border-radius' => (empty($options['value']['border-radius']) || $options['value']['border-radius'] == array( 
									'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' 
								))? '': $options['value']['border-radius']
						)) . ' >';
						$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style(array(
							'background-position' => 'center',
							'background-size' => 'cover',
						));
						$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
						$wrapper_background .= ' data-video-fallback="' . (empty($options['value']['background-video-image'])? '': gdlr_core_get_image_url($options['value']['background-video-image'])) . '" ';
						$wrapper_background .= ' >';
						$wrapper_background .= '<div class="gdlr-core-pbf-background-video" data-background-type="video" >';
						
						if( $options['value']['background-type'] == 'video' ){
							if( !empty($options['value']['background-video-url']) ){
								$wrapper_background .= gdlr_core_get_video(
									$options['value']['background-video-url'], 
									array('width' => '100%', 'height' => '100%'), 
									array('background' => 1)
								);
							}
						}else if( $options['value']['background-type'] == 'html5-video' ){
							$wrapper_background .= '<video autoplay loop muted >';
							if( $options['value']['background-video-url-mp4'] ){
								$wrapper_background .= '<source src="' . esc_url($options['value']['background-video-url-mp4']) . '" type="video/mp4">';
							}
							if( $options['value']['background-video-url-webm'] ){
								$wrapper_background .= '<source src="' . esc_url($options['value']['background-video-url-webm']) . '" type="video/webm">';
							}
							if( $options['value']['background-video-url-ogg'] ){
								$wrapper_background .= '<source src="' . esc_url($options['value']['background-video-url-ogg']) . '" type="video/ogg">';
							}
							$wrapper_background .= '</video>';
						}
						$wrapper_background .= '</div>';
						$wrapper_background .= '</div>'; // gdlr-cpre-pbc-background
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					}
				}				

				// inner border
				if( !empty($options['value']['border-type']) ){
					if( $options['value']['border-type'] == 'outer-border' ){
						$wrapper_style_atts['border-width'] = empty($options['value']['border-width'])? '': $options['value']['border-width'];
						$wrapper_style_atts['border-color'] = empty($options['value']['border-color'])? '': $options['value']['border-color'];
						$wrapper_style_atts['border-style'] = empty($options['value']['border-style'])? '': $options['value']['border-style'];
					}else if( $options['value']['border-type'] == 'inner-border' ){
						$wrapper_background .= '<div class="gdlr-core-pbf-background-frame" ' . gdlr_core_esc_style(array(
							'margin' => (empty($options['value']['border-pre-spaces']))? '0px': $options['value']['border-pre-spaces'],
							'border-width' => empty($options['value']['border-width'])? '': $options['value']['border-width'],
							'border-style' => empty($options['value']['border-style'])? '': $options['value']['border-style'],
							'border-color' => empty($options['value']['border-color'])? '': $options['value']['border-color']
						)) . ' ></div>';
					}
				}				
				
				$column_class  = 'gdlr-core-page-builder-column';
				$column_class .= empty($options['column'])? '': ' gdlr-core-column-' . $options['column'];
				
				$column  = '<div class="' . esc_attr($column_class) . '" data-template="wrapper" data-type="column" ';
				$column .= (empty($options['column'])? '': 'data-column="' . esc_attr($options['column']) . '"');
				$column .= (empty($options['value'])? '': 'data-value="' . esc_attr(json_encode($options['value'])) . '"');
				$column .= (empty($options['value']['skin'])? '': 'data-skin="' . esc_attr($options['value']['skin']) . '" ');
				$column .= '>';
				
				$column .= '<div class="gdlr-core-page-builder-column-content">';
				
				$column .= '<div class="gdlr-core-page-builder-column-head">';
				$column .= '<div class="gdlr-core-page-builder-column-size">';
				$column .= '<i class="fa fa-plus gdlr-core-page-builder-column-increase" ></i>';
				$column .= '<i class="fa fa-minus gdlr-core-page-builder-column-decrease" ></i>';
				$column .= '</div>'; // gdlr-core-page-builder-column-size
				$column .= '<span class="gdlr-core-page-builder-column-head-title" >' . (empty($options['column'])? '': self::$col_list[$options['column']]) . '</span>';
				$column .= '<div class="gdlr-core-page-builder-column-settings">';
				$column .= '<i class="fa fa-edit gdlr-core-page-builder-column-edit" ></i>';
				$column .= '<i class="fa fa-copy gdlr-core-page-builder-column-copy" ></i>';
				$column .= '<i class="fa fa-download gdlr-core-page-builder-column-save" ></i>';
				$column .= '<i class="fa fa-remove gdlr-core-page-builder-column-remove" ></i>';
				$column .= '</div>'; // gdlr-core-page-builder-column-settings				
				$column .= '</div>'; // gdlr-core-page-builder-column-head
				
				$column_item_class  = (empty($options['value']['background-extending']) || $options['value']['background-extending'] == 'none')? '': ' gdlr-core-column-extend-' . $options['value']['background-extending'];
				$column_item_class .= empty($options['value']['class'])? '': ' ' . $options['value']['class'];
				$column .= '<div class="gdlr-core-page-builder-column-content-margin gdlr-core-pbf-column-content-margin gdlr-core-js ' . esc_attr($column_item_class) . '" ';
				$column .= gdlr_core_esc_style($wrapper_style_atts) . ' ';
				if( !empty($options['value']['sync-height']) ){
					$column .= ' data-sync-height="' . esc_attr($options['value']['sync-height']) . '" ';
					if( !empty($options['value']['centering-sync-height-content']) && $options['value']['centering-sync-height-content'] == 'enable' ){
						$column .= ' data-sync-height-center';
					}
				}
				$column .= ' >';
				$column .= $wrapper_background;
				$column .= '<div class="gdlr-core-page-builder-column-content-wrap gdlr-core-pbf-column-content gdlr-core-sync-height-content gdlr-core-js clearfix" ' . gdlr_core_esc_style($content_style_atts) . ' ';
				$column .= gdlr_core_get_animation_atts(array(
					'animation' => (empty($options['value']['animation'])? '': $options['value']['animation']),
					'location' => (empty($options['value']['animation-location'])? '': $options['value']['animation-location'])
				)) . ' >';
				$column .= '<div class="gdlr-core-page-builder-column-container gdlr-core-column-sortable">';
				if( !empty($options['items']) ){
					$column .= gdlr_core_escape_content(call_user_func($callback, $options['items']));
				} 
				$column .= '</div>'; 
				$column .= '</div>'; // gdlr-core-page-builder-column-content-margin
				$column .= '</div>'; // gdlr-core-page-builder-column-content-wrap
				$column .= '</div>'; // gdlr-core-page-builder-column-content
				
				// script for column wrapper
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-column-background-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	var parallax_bg_script = jQuery('#gdlr-core-preview-column-background-<?php echo esc_attr($id); ?>');
<?php	
	if( !empty($options['value']['sync-height']) ){
		echo 'new gdlr_core_sync_height(parallax_bg_script.closest(\'.gdlr-core-page-builder-body\'));';
	}
?>	
	parallax_bg_script.parent().gdlr_core_parallax_background().gdlr_core_fluid_video();
	parallax_bg_script.parent().gdlr_core_ux();
	jQuery(window).trigger('scroll');
});
</script><?php	
				$column .= ob_get_contents();
				ob_end_clean();					
				
				$column .= '</div>'; // gdlr-core-page-builder-column				
				
				return $column;
			}
			
			// get element content for front end page builder
			static function get_content( $options = array(), $callback = '' ){
				
				$wrapper_style_atts = array(
					'min-height' => empty($options['value']['min-height'])? '': $options['value']['min-height'],
					'margin' => (empty($options['value']['margin']) || $options['value']['margin'] == array(
							'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link'
						))? '': $options['value']['margin'],
					'padding' => (empty($options['value']['padding']) || $options['value']['padding'] == array( 
							'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link' 
						))? '': $options['value']['padding']
				);
				$content_style_atts = array(
					'max-width' => empty($options['value']['max-width'])? '': $options['value']['max-width']
				);
				
				// for background
				$wrapper_background = '';
				if( !empty($options['value']['background-type']) ){
					
					// color background
					if( $options['value']['background-type'] == 'color' ){

						if( !empty($options['value']['background-color']) ){
							$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
								'background-color' => $options['value']['background-color'],
								'opacity' => (empty($options['value']['background-opacity']) || $options['value']['background-opacity'] == 1)? '': $options['value']['background-opacity'],
								'border-radius' => (empty($options['value']['border-radius']) || $options['value']['border-radius'] == array( 
										'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' 
									))? '': $options['value']['border-radius']
							)) . ' ></div>';
						}

					// image background
					}else if( $options['value']['background-type'] == 'image' ){
						$bgi_atts = array(
							'background-image' => empty($options['value']['background-image'])? '': $options['value']['background-image'],
							'opacity' => (empty($options['value']['background-opacity']) || $options['value']['background-opacity'] == 1)? '': $options['value']['background-opacity']
						);
						if( !empty($options['value']['background-image-style']) ){
							if( $options['value']['background-image-style'] == 'cover' ){
								$bgi_atts['background-size'] = 'cover';
							}else{
								$bgi_atts['background-repeat'] = $options['value']['background-image-style'];
							}
							if( !empty($options['value']['background-image-position']) ){
								$bgi_atts['background-position'] = str_replace('-', ' ', $options['value']['background-image-position']);
							}
						}
						
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
							'background-color' => empty($options['value']['background-color'])? '': $options['value']['background-color'],
							'border-radius' => (empty($options['value']['border-radius']) || $options['value']['border-radius'] == array( 
									'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' 
								))? '': $options['value']['border-radius']
						)) . ' >';
						$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style($bgi_atts);
						$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
						$wrapper_background .= ' ></div>';
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					
					// pattern background
					}else if( $options['value']['background-type'] == 'pattern' ){
						$bgi_atts = array(
							'background-image' => GDLR_CORE_URL . '/include/images/pattern/' . (empty($options['value']['background-pattern'])? 'pattern-1': $options['value']['background-pattern']) . '.png',
							'background-repeat' => 'repeat',
							'background-position' => 'center',
							'opacity' => (empty($options['value']['background-opacity']) || $options['value']['background-opacity'] == 1)? '': $options['value']['background-opacity']
						);
						
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
							'border-radius' => (empty($options['value']['border-radius']) || $options['value']['border-radius'] == array( 
									'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' 
								))? '': $options['value']['border-radius']
						)) . ' >';
						$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style($bgi_atts);
						$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
						$wrapper_background .= ' ></div>';
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					
					// video background
					}else{
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
							'border-radius' => (empty($options['value']['border-radius']) || $options['value']['border-radius'] == array( 
									'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'link' 
								))? '': $options['value']['border-radius']
						)) . ' >';
						$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style(array(
							'background-position' => 'center',
							'background-size' => 'cover',
						));
						$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
						$wrapper_background .= ' data-video-fallback="' . (empty($options['value']['background-video-image'])? '': gdlr_core_get_image_url($options['value']['background-video-image'])) . '" ';
						$wrapper_background .= ' >';
						$wrapper_background .= '<div class="gdlr-core-pbf-background-video" data-background-type="video" >';
						
						if( $options['value']['background-type'] == 'video' ){
							if( !empty($options['value']['background-video-url']) ){
								$wrapper_background .= gdlr_core_get_video(
									$options['value']['background-video-url'], 
									array('width' => '100%', 'height' => '100%'), 
									array('background' => 1)
								);
							}
						}else if( $options['value']['background-type'] == 'html5-video' ){
							$wrapper_background .= '<video autoplay loop muted >';
							if( $options['value']['background-video-url-mp4'] ){
								$wrapper_background .= '<source src="' . esc_url($options['value']['background-video-url-mp4']) . '" type="video/mp4">';
							}
							if( $options['value']['background-video-url-webm'] ){
								$wrapper_background .= '<source src="' . esc_url($options['value']['background-video-url-webm']) . '" type="video/webm">';
							}
							if( $options['value']['background-video-url-ogg'] ){
								$wrapper_background .= '<source src="' . esc_url($options['value']['background-video-url-ogg']) . '" type="video/ogg">';
							}
							$wrapper_background .= '</video>';
						}
						$wrapper_background .= '</div>';
						$wrapper_background .= '</div>'; // gdlr-cpre-pbc-background
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					}
				}

				// inner border
				if( !empty($options['value']['border-type']) ){
					if( $options['value']['border-type'] == 'outer-border' ){
						$wrapper_style_atts['border-width'] = empty($options['value']['border-width'])? '': $options['value']['border-width'];
						$wrapper_style_atts['border-color'] = empty($options['value']['border-color'])? '': $options['value']['border-color'];
						$wrapper_style_atts['border-style'] = empty($options['value']['border-style'])? '': $options['value']['border-style'];
					}else if( $options['value']['border-type'] == 'inner-border' ){
						$wrapper_background .= '<div class="gdlr-core-pbf-background-frame" ' . gdlr_core_esc_style(array(
							'margin' => (empty($options['value']['border-pre-spaces']))? '0px': $options['value']['border-pre-spaces'],
							'border-width' => empty($options['value']['border-width'])? '': $options['value']['border-width'],
							'border-style' => empty($options['value']['border-style'])? '': $options['value']['border-style'],
							'border-color' => empty($options['value']['border-color'])? '': $options['value']['border-color']
						)) . ' ></div>';
					}
				}
				
				$column_class  = 'gdlr-core-pbf-column';
				$column_class .= empty($options['column'])? '': ' gdlr-core-column-' . $options['column'];
				$column_class .= empty($options['first-column'])? '': ' gdlr-core-column-first';
				if( !empty($options['value']['hide-this-wrapper-in']) && $options['value']['hide-this-wrapper-in'] != 'none' ){
					$column_class .= ' gdlr-core-hide-in-' . $options['value']['hide-this-wrapper-in'];
				}
				
				$column  = '<div class="' . esc_attr($column_class) . '" ';
				$column .= (empty($options['value']['skin'])? '': 'data-skin="' . esc_attr($options['value']['skin']) . '" ');
				$column .= (empty($options['value']['id'])? '': ' id="' . esc_attr($options['value']['id']) . '" ');
				$column .= '>';			

				$column_item_class = (empty($options['value']['background-extending']) || $options['value']['background-extending'] == 'none')? '': ' gdlr-core-column-extend-' . $options['value']['background-extending'];	
				$column_content_class = '';
				if( !empty($options['value']['full-height']) && $options['value']['full-height'] == 'enable' ){
					$column_item_class .= ' gdlr-core-column-full-height';

					if( !empty($options['value']['centering-sync-height-content']) && $options['value']['centering-sync-height-content'] == 'enable' ){
						$column_item_class .= ' gdlr-core-full-height-center';
						$column_content_class .= ' gdlr-core-full-height-content';
					}
					$options['value']['sync-height'] = '';
				}
				$column_item_class .= empty($options['value']['class'])? '': ' ' . $options['value']['class'];

				// set container size for srcset
				if( !empty($options['column']) ){
					gdlr_core_set_container_multiplier($options['column'] / 60);
				}

				$column .= '<div class="gdlr-core-pbf-column-content-margin gdlr-core-js ' . esc_attr($column_item_class) . '" ';
				$column .= gdlr_core_esc_style($wrapper_style_atts) . ' ';
				$column .= (empty($options['value']['decrease-height']) || $options['value']['decrease-height'] == '0px')? '': ' data-decrease-height="' . esc_attr($options['value']['decrease-height']) . '"';
				if( !empty($options['value']['sync-height']) ){
					$column_content_class .= ' gdlr-core-sync-height-content';

					$column .= ' data-sync-height="' . esc_attr($options['value']['sync-height']) . '" ';
					if( !empty($options['value']['centering-sync-height-content']) && $options['value']['centering-sync-height-content'] == 'enable' ){
						$column .= ' data-sync-height-center';
					}
				}
				$column .= ' >' . $wrapper_background;		
				$column .= '<div class="gdlr-core-pbf-column-content clearfix gdlr-core-js ' . esc_attr($column_content_class) . '" ' . gdlr_core_esc_style($content_style_atts) . ' ';
				$column .= gdlr_core_get_animation_atts(array(
					'animation' => (empty($options['value']['animation'])? '': $options['value']['animation']),
					'location' => (empty($options['value']['animation-location'])? '': $options['value']['animation-location'])
				)) . ' >';
				if( !empty($options['items']) ){
					$column .= gdlr_core_escape_content(call_user_func($callback, $options['items']));
				} 
				$column .= '</div>'; // gdlr-core-pbf-column-content
				$column .= '</div>'; // gdlr-core-pbf-column-content-margin	
				$column .= '</div>'; // gdlr-core-pbf-column				
				
				gdlr_core_set_container_multiplier(1);

				return $column;
			}
			
		} // gdlr_core_pb_wrapper_column
	} // class_exists	

	// [gdlr_core_row]
	// [gdlr_core_column size="1/3"]column content 1[/gdlr_core_column]
	// [gdlr_core_column size="1/3"]column content 2[/gdlr_core_column]
	// [gdlr_core_column size="1/3"]column content 3[/gdlr_core_column]
	// [/gdlr_core_row]
	add_shortcode('gdlr_core_row', 'gdlr_core_row_shortcode');
	if( !function_exists('gdlr_core_row_shortcode') ){
		function gdlr_core_row_shortcode($atts, $content = ''){
			$atts = shortcode_atts(array(), $atts, 'gdlr_core_row');

			global $gdlr_core_columns;
			$gdlr_core_columns = array();

			do_shortcode($content);

			$ret  = '<div class="gdlr-core-row-shortcode clearfix gdlr-core-item-rvpdlr" >';
			foreach( $gdlr_core_columns as $gdlr_core_column ){
				$ret .= $gdlr_core_column;
			}
			$ret .= '</div>';

			return $ret;
		}
	}

	add_shortcode('gdlr_core_column', 'gdlr_core_column_shortcode');
	if( !function_exists('gdlr_core_column_shortcode') ){
		function gdlr_core_column_shortcode($atts, $content = ''){
			$atts = shortcode_atts(array('size' => '1/3'), $atts, 'gdlr_core_column');

			global $gdlr_core_columns;

			$column_no = 0;
			switch( $atts['size'] ){
				case '1/1': $column_no = 60; break;
				case '1/2': $column_no = 30; break;
				case '1/3': $column_no = 20; break;
				case '2/3': $column_no = 40; break;
				case '1/4': $column_no = 15; break;
				case '3/4': $column_no = 45; break;
				case '1/5': $column_no = 12; break;
				case '2/5': $column_no = 24; break;
				case '3/5': $column_no = 36; break;
				case '4/5': $column_no = 48; break;
				case '1/6': $column_no = 10; break;
				case '5/6': $column_no = 50; break;
			}

			$ret  = '<div class="gdlr-core-column-shortcode gdlr-core-item-pdlr gdlr-core-column-' . esc_attr($column_no) . '" >';
			$ret .= gdlr_core_content_filter($content);
			$ret .= '</div>';

			$gdlr_core_columns[] = $ret;

			return;
		}
	}