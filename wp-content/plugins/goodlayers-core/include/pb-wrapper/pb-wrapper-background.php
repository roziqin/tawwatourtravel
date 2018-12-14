<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( !class_exists('gdlr_core_pb_wrapper_background') ){
		class gdlr_core_pb_wrapper_background{
			
			// get the element settings
			static function get_settings(){
				return array(	
					'feature' => true,
					'type' => 'background',
					'title' => esc_html__('Wrapper', 'goodlayers-core'),
					'thumbnail' => GDLR_CORE_URL . '/framework/images/page-builder/wrapper.png',
				);
			}
			
			// return the element options
			static function get_options(){
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'content-layout' => array(
								'title' => esc_html__('Content Layout', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'boxed' => esc_html__('Boxed ( content stays within container area )', 'goodlayers-core'),
									'full' => esc_html__('Full', 'goodlayers-core'),
									'custom' => esc_html__('Custom Width', 'goodlayers-core'),
								)
							),
							'max-width' => array(
								'title' => esc_html__('Max Width', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'description' => esc_html__('Maximum width of this wrapper item.', 'goodlayers-core'),
								'condition' => array( 'content-layout' => 'custom' )
							),
							'enable-space' => array(
								'title' => esc_html__('Allow Item Padding ( default left / right spaces )', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable',
								'condition' => array( 'content-layout' => 'full' )
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
								'data-input-type' => 'pixel',
								'default' => '0px',
								'condition' => array( 'full-height' => 'enable' )
							),
							'centering-content' => array(
								'title' => esc_html__('Center Content At The Middle', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable',
								'condition' => array( 'full-height' => 'enable' )
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
								'default' => '',
								'condition' => array( 'background-type' => 'image' ), 
								'description' => esc_html__('Fill the number between 0 to 1', 'goodlayers-core')
							),  
							'pattern-opacity' => array(
								'title' => esc_html__('Pattern Opacity', 'goodlayers-core'),
								'type' => 'text',
								'default' => 1,
								'condition' => array( 'background-type' => 'pattern' ), 
								'description' => esc_html__('Fill the number between 0 to 1', 'goodlayers-core')
							), 
							'parallax-speed' => array(
								'title' => esc_html__('Parallax Speed', 'goodlayers-core'),
								'type' => 'text',
								'default' => 0.8,
								'condition' => array( 'background-type' => array('image', 'video', 'html5-video', 'pattern') ), 
								'description' => esc_html__('Fill the number between -1 to 1, ( value 1 equals to background-attachment: fixed )', 'goodlayers-core')
							),
							'overflow' => array(
								'title' => esc_html__('Content Overflow', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'visible' => esc_html__('Visible', 'goodlayers-core'),
									'hidden' => esc_html__('Hidden', 'goodlayers-core'),
								),
								'default' => 'visible',
								'description' => esc_html__('Set to hidden to cut the content which flowing out of this wrapper. * Effects will only apply to front end of the site.', 'goodlayers-core')
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
								'default' => array( 'top'=>'60px', 'right'=>'0px', 'bottom'=>'30px', 'left'=>'0px', 'settings'=>'unlink' ),
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
						),
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
					'margin' => (empty($options['value']['margin']) || $options['value']['margin'] == array(
							'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link'
						))? '': $options['value']['margin'],
					'padding' => (empty($options['value']['padding']) || $options['value']['padding'] == array( 
							'top'=>'60px', 'right'=>'0px', 'bottom'=>'30px', 'left'=>'0px', 'settings'=>'unlink' 
						))? '': $options['value']['padding']
				);
				$content_style_atts = array();
				
				// for background
				$wrapper_background = '';
				if( !empty($options['value']['background-type']) ){
					
					// color background
					if( $options['value']['background-type'] == 'color' ){
						$wrapper_style_atts['background-color'] = empty($options['value']['background-color'])? '': $options['value']['background-color'];
						
					// image background
					}else if( $options['value']['background-type'] == 'image' ){
						$bgi_atts = array(
							'opacity' => empty($options['value']['background-opacity'])? '': $options['value']['background-opacity'],
							'background-image' => empty($options['value']['background-image'])? '': $options['value']['background-image'],
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
						if( !empty($options['value']['parallax-speed']) && $options['value']['parallax-speed'] == 1 ){
							$bgi_atts['background-attachment'] = 'fixed';
 						}

						
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
							'background-color' => empty($options['value']['background-color'])? '': $options['value']['background-color'],
						)) . ' >';
						if( empty($bgi_atts['background-attachment']) ){
							$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style($bgi_atts);
							$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
							$wrapper_background .= ' ></div>';
						}else{
							$wrapper_background .= '<div class="gdlr-core-pbf-background" ' . gdlr_core_esc_style($bgi_atts) . ' ></div>';
						}
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					
					// pattern background
					}else if( $options['value']['background-type'] == 'pattern' ){
						$bgi_atts = array(
							'background-image' => GDLR_CORE_URL . '/include/images/pattern/' . (empty($options['value']['background-pattern'])? 'pattern-1': $options['value']['background-pattern']) . '.png',
							'background-repeat' => 'repeat',
							'background-position' => 'center',
							'opacity' => empty($options['value']['pattern-opacity'])? '1': $options['value']['pattern-opacity'],
						);
						if( !empty($options['value']['parallax-speed']) && $options['value']['parallax-speed'] == 1 ){
							$bgi_atts['background-attachment'] = 'fixed';
 						}
						
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap">';
						if( empty($bgi_atts['background-attachment']) ){
							$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style($bgi_atts);
							$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
							$wrapper_background .= ' ></div>';
						}else{
							$wrapper_background .= '<div class="gdlr-core-pbf-background" ' . gdlr_core_esc_style($bgi_atts) . ' ></div>';
						}
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					
					// video background
					}else{
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap">';
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

				// border
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
				
				$wrapper  = '<div class="gdlr-core-page-builder-wrapper gdlr-core-page-builder-background-wrapper" data-template="wrapper" data-type="background" ';
				$wrapper .= (empty($options['value'])? '': 'data-value="' . esc_attr(json_encode($options['value'])) . '" ');
				$wrapper .= (empty($options['value']['skin'])? '': 'data-skin="' . esc_attr($options['value']['skin']) . '" ');
				$wrapper .= '>';
				
				$wrapper .= '<div class="gdlr-core-page-builder-wrapper-content" >';
				$wrapper .= '<div class="gdlr-core-page-builder-wrapper-head">';
				$wrapper .= '<span class="gdlr-core-page-builder-wrapper-head-title" >' . esc_html__('Wrapper', 'goodlayers-core') . '</span>';
				$wrapper .= '<div class="gdlr-core-page-builder-wrapper-settings">';
				$wrapper .= '<i class="fa fa-edit gdlr-core-page-builder-wrapper-edit" ></i>';
				$wrapper .= '<i class="fa fa-copy gdlr-core-page-builder-wrapper-copy" ></i>';
				$wrapper .= '<i class="fa fa-download gdlr-core-page-builder-wrapper-save" ></i>';
				$wrapper .= '<i class="fa fa-remove gdlr-core-page-builder-wrapper-remove" ></i>';
				$wrapper .= '</div>'; // gdlr-core-page-builder-wrapper-settings
				$wrapper .= '</div>'; // gdlr-core-page-builder-wrapper-head
				
				$wrapper_display_class  = empty($options['value']['class'])? '': $options['value']['class'];

				$container_class = '';
				$container_style_atts = array();
				if( empty($options['value']['content-layout']) || $options['value']['content-layout'] == 'boxed' ){
					$container_class .= 'gdlr-core-container';
				}else if( $options['value']['content-layout'] == 'custom' ){
					$container_class .= 'gdlr-core-container-custom';
					if( !empty($options['value']['max-width']) ){
						$container_style_atts['max-width'] = $options['value']['max-width'];
					}
				}else if( $options['value']['content-layout'] == 'full' ){
					if( empty($options['value']['enable-space']) || $options['value']['enable-space'] == 'disable' ){
						$container_class .= 'gdlr-core-pbf-wrapper-full-no-space';
					}else{
						$container_class .= 'gdlr-core-pbf-wrapper-full';
					}
				}

				$wrapper .= '<div class="gdlr-core-page-builder-wrapper-content-margin ' . esc_attr($wrapper_display_class) . '" ' . gdlr_core_esc_style($wrapper_style_atts) . ' >';
				$wrapper .= $wrapper_background;
				$wrapper .= '<div class="gdlr-core-page-builder-wrapper-content-wrap gdlr-core-pbf-wrapper-content gdlr-core-js" ' . gdlr_core_esc_style($content_style_atts) . ' ';
				$wrapper .= gdlr_core_get_animation_atts(array(
					'animation' => (empty($options['value']['animation'])? '': $options['value']['animation']),
					'location' => (empty($options['value']['animation-location'])? '': $options['value']['animation-location'])
				)) . ' >';
				$wrapper .= '<div class="gdlr-core-page-builder-wrapper-container gdlr-core-wrapper-sortable clearfix ' . esc_attr($container_class) . '" ' . gdlr_core_esc_style($container_style_atts) . '>';
				if( !empty($options['items']) ){
					$wrapper .= gdlr_core_escape_content(call_user_func($callback, $options['items']));
				}
				$wrapper .= '</div>';
				$wrapper .= '</div>'; // gdlr-core-page-builder-wrapper-content-wrap
				$wrapper .= '</div>'; // gdlr-core-page-builder-wrapper-content-margin
				$wrapper .= '</div>'; // gdlr-core-page-builder-wrapper-content

				// script for background wrapper
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-background-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	var background_wrap = jQuery('#gdlr-core-preview-background-<?php echo esc_attr($id); ?>').parent();
	background_wrap.gdlr_core_parallax_background().gdlr_core_fluid_video().gdlr_core_ux();
	jQuery(window).trigger('scroll');
});
</script><?php	
				$wrapper .= ob_get_contents();
				ob_end_clean();				
				
				$wrapper .= '</div>'; // gdlr-core-page-builder-wrapper
				
				return $wrapper;
				
			}
			
			// get element content for front end page builder
			static function get_content( $options = array(), $callback = '' ){
				
				$wrapper_style_atts = array(
					'margin' => (empty($options['value']['margin']) || $options['value']['margin'] == array(
							'top'=>'0px', 'right'=>'0px', 'bottom'=>'0px', 'left'=>'0px', 'settings'=>'link'
						))? '': $options['value']['margin'],
					'padding' => (empty($options['value']['padding']) || $options['value']['padding'] == array( 
						'top'=>'60px', 'right'=>'0px', 'bottom'=>'30px', 'left'=>'0px', 'settings'=>'unlink' 
					))? '': $options['value']['padding'],
					'overflow' => (empty($options['value']['overflow']) || $options['value']['overflow'] == 'visible')? '': $options['value']['overflow']
				);
				$content_style_atts = array();

				// for background
				$wrapper_background = '';
				if( !empty($options['value']['background-type']) ){
					
					// color background
					if( $options['value']['background-type'] == 'color' ){
						
						if( !empty($options['value']['background-color']) ){
							$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
								'background-color' => $options['value']['background-color']
							)) . ' ></div>';
						}
					
					// image background
					}else if( $options['value']['background-type'] == 'image' ){
						$bgi_atts = array(
							'opacity' => empty($options['value']['background-opacity'])? '': $options['value']['background-opacity'],
							'background-image' => empty($options['value']['background-image'])? '': $options['value']['background-image']
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
						if( !empty($options['value']['parallax-speed']) && $options['value']['parallax-speed'] == 1 ){
							$bgi_atts['background-attachment'] = 'fixed';
 						}
						
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap" ' . gdlr_core_esc_style(array(
							'background-color' => empty($options['value']['background-color'])? '': $options['value']['background-color'],
						)) . ' >';
						if( empty($bgi_atts['background-attachment']) ){
							$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style($bgi_atts);
							$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
							$wrapper_background .= ' ></div>';
						}else{
							$wrapper_background .= '<div class="gdlr-core-pbf-background" ' . gdlr_core_esc_style($bgi_atts) . ' ></div>';
						}
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					
					// pattern background
					}else if( $options['value']['background-type'] == 'pattern' ){
						$bgi_atts = array(
							'background-image' => GDLR_CORE_URL . '/include/images/pattern/' . (empty($options['value']['background-pattern'])? 'pattern-1': $options['value']['background-pattern']) . '.png',
							'background-repeat' => 'repeat',
							'background-position' => 'center',
							'opacity' => empty($options['value']['pattern-opacity'])? '1': $options['value']['pattern-opacity'],
						);
						if( !empty($options['value']['parallax-speed']) && $options['value']['parallax-speed'] == 1 ){
							$bgi_atts['background-attachment'] = 'fixed';
 						}
						
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap">';
						if( empty($bgi_atts['background-attachment']) ){
							$wrapper_background .= '<div class="gdlr-core-pbf-background gdlr-core-parallax gdlr-core-js" ' . gdlr_core_esc_style($bgi_atts);
							$wrapper_background .= ' data-parallax-speed="' . (empty($options['value']['parallax-speed'])? 0: $options['value']['parallax-speed']) . '" ';
							$wrapper_background .= ' ></div>';
						}else{
							$wrapper_background .= '<div class="gdlr-core-pbf-background" ' . gdlr_core_esc_style($bgi_atts) . '></div>';
						}
						$wrapper_background .= '</div>'; // gdlr-core-pbf-background-wrap
					
					// video background
					}else{
						$wrapper_background  = '<div class="gdlr-core-pbf-background-wrap">';
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
				} // wrapper-background
				
				// border
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

				// device display class
				$wrapper_display_class = '';
				$wrapper_content_class = '';
				if( !empty($options['value']['hide-this-wrapper-in']) && $options['value']['hide-this-wrapper-in'] != 'none' ){
					$wrapper_display_class .= ' gdlr-core-hide-in-' . $options['value']['hide-this-wrapper-in'];
				}
				if( !empty($options['value']['full-height']) && $options['value']['full-height'] == 'enable' ){
					$wrapper_display_class .= ' gdlr-core-wrapper-full-height gdlr-core-js';

					if( !empty($options['value']['centering-content']) && $options['value']['centering-content'] == 'enable' ){
						$wrapper_display_class .= ' gdlr-core-full-height-center';
						$wrapper_content_class .= ' gdlr-core-full-height-content';
					}
				}
				$wrapper_display_class .= empty($options['value']['class'])? '': ' ' . $options['value']['class'];

				$container_class = '';
				$container_style_atts = array();
				if( empty($options['value']['content-layout']) || $options['value']['content-layout'] == 'boxed' ){
					$container_class .= 'gdlr-core-container';
				}else if( $options['value']['content-layout'] == 'custom' ){
					$container_class .= 'gdlr-core-container-custom';
					if( !empty($options['value']['max-width']) ){
						$container_style_atts['max-width'] = $options['value']['max-width'];
					}
				}else if( $options['value']['content-layout'] == 'full' ){
					gdlr_core_set_container(false);

					if( empty($options['value']['enable-space']) || $options['value']['enable-space'] == 'disable' ){
						$container_class .= 'gdlr-core-pbf-wrapper-full-no-space';
					}else{
						$container_class .= 'gdlr-core-pbf-wrapper-full';
					}
				}

				$wrapper  = '<div class="gdlr-core-pbf-wrapper ' . esc_attr($wrapper_display_class) . '" ' . gdlr_core_esc_style($wrapper_style_atts);
				$wrapper .= (empty($options['value']['skin'])? '': 'data-skin="' . esc_attr($options['value']['skin']) . '" ');
				$wrapper .= (empty($options['value']['id'])? '': ' id="' . esc_attr($options['value']['id']) . '" ');
				$wrapper .= (empty($options['value']['decrease-height']) || $options['value']['decrease-height'] == '0px')? '': ' data-decrease-height="' . esc_attr($options['value']['decrease-height']) . '"';
				$wrapper .= '>' . $wrapper_background;
				$wrapper .= '<div class="gdlr-core-pbf-wrapper-content gdlr-core-js ' . esc_attr($wrapper_content_class) . '" ' . gdlr_core_esc_style($content_style_atts) . ' ';
				$wrapper .= gdlr_core_get_animation_atts(array(
					'animation' => (empty($options['value']['animation'])? '': $options['value']['animation']),
					'location' => (empty($options['value']['animation-location'])? '': $options['value']['animation-location'])
				)) . ' >';
				$wrapper .= '<div class="gdlr-core-pbf-wrapper-container clearfix ' . esc_attr($container_class) . '" ' . gdlr_core_esc_style($container_style_atts) .'>';
				if( !empty($options['items']) ){
					$wrapper .= gdlr_core_escape_content(call_user_func($callback, $options['items']));
				}
				$wrapper .= '</div>'; // gdlr-core-pbf-wrapper-container
				$wrapper .= '</div>'; // gdlr-core-pbf-wrapper-content
				$wrapper .= '</div>'; // gdlr-core-pbf-wrapper
				
				gdlr_core_set_container(true);

				return $wrapper;
				
			}
			
		} // gdlr_core_pb_wrapper_background
	} // class_exists	