<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('button', 'gdlr_core_pb_element_button'); 
	
	if( !class_exists('gdlr_core_pb_element_button') ){
		class gdlr_core_pb_element_button{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-square-o',
					'title' => esc_html__('Button', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('Button 1', 'goodlayers-core'),
						'options' => array(
							'button-text' => array(
								'title' => esc_html__('Button Text', 'goodlayers-core'),
								'type' => 'text',
								'default' => esc_html__('Learn More', 'goodlayers-core'),
							),
							'link-to' => array(
								'title' => esc_html__('Button Link To', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'custom-url' => esc_html__('Custom Url', 'goodlayers-core'),
									'lb-custom-image' => esc_html__('Lightbox with custom image', 'goodlayers-core'),
									'lb-video' => esc_html__('Video Lightbox', 'goodlayers-core'),
								),
								'default' => 'custom-url'
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
							'button-link' => array(
								'title' => esc_html__('Button Link', 'goodlayers-core'),
								'type' => 'text',
								'default' => '#',
								'condition' => array( 'link-to' => 'custom-url' )
							),
							'button-link-target' => array(
								'title' => esc_html__('Button Link Target', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'_self' => esc_html__('Current Screen', 'goodlayers-core'),
									'_blank' => esc_html__('New Window', 'goodlayers-core'),
								),
								'default' => '_self',
								'condition' => array( 'link-to' => 'custom-url' )
							),
							'icon-position' => array(
								'title' => esc_html__('Icon Position', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'left' => esc_html__('Left', 'goodlayers-core'),
									'right' => esc_html__('Right', 'goodlayers-core'),
								)
							),
							'icon' => array(
								'title' => esc_html__('Icon Selector', 'goodlayers-core'),
								'type' => 'icons',
								'default' => 'fa fa-gear',
								'wrapper-class' => 'gdlr-core-fullsize',
								'condition' => array( 'icon-position' => array('left', 'right') )
							),
						)
					),
					'style' => array(
						'title' => esc_html('Button Style', 'goodlayers-core'),
						'options' => array(
							'text-align' => array(
								'title' => esc_html__('Button Align', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'center'
							),
							'full-width-button' => array(
								'title' => esc_html__('Full Width Button', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
							'button-padding' => array(
								'title' => esc_html__('Button Padding', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'15px', 'right'=>'33px', 'bottom'=>'15px', 'left'=>'33px', 'settings'=>'unlink' )
							),
							'border-radius' => array(
								'title' => esc_html__('Button Border Radius', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '25px'
							),
							'button-background' => array(
								'title' => esc_html__('Button Background', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'transparent' => esc_html__('Transparent', 'goodlayers-core'),
									'solid' => esc_html__('Solid', 'goodlayers-core'),
									'gradient' => esc_html__('Gradient', 'goodlayers-core'),
								),
								'default' => 'gradient'
							),
							'button-border' => array(
								'title' => esc_html__('Button Border', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
							'border-width' => array(
								'title' => esc_html__('Button Border Width', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'1px', 'right'=>'1px', 'bottom'=>'1px', 'left'=>'1px', 'settings'=>'link' ),
								'condition' => array( 'button-border' => 'enable' )
							),
							'text-color' => array(
								'title' => esc_html__('Button Text Color', 'goodlayers-core'),
								'type' => 'colorpicker'
							),
							'text-hover-color' => array(
								'title' => esc_html__('Button Text Hover Color', 'goodlayers-core'), 
								'type' => 'colorpicker'
							),
							'background-color' => array(
								'title' => esc_html__('Button Background Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button-background' => array('solid', 'gradient') ) 
							),
							'background-hover-color' => array(
								'title' => esc_html__('Button Background Hover Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button-background' => array('solid') ) 
							),
							'background-gradient-color' => array(
								'title' => esc_html__('Button Background Gradient Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button-background' => array('gradient') ) 
							),
							'border-color' => array(
								'title' => esc_html__('Button Border Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button-border' => 'enable' )
							),
							'border-hover-color' => array(
								'title' => esc_html__('Button Border Hover Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button-border' => 'enable' )
							),
						)
					),
					'button-2' => array(
						'title' => esc_html('Button 2', 'goodlayers-core'),
						'options' => array(
							'button2-text' => array(
								'title' => esc_html__('Button 2 Text', 'goodlayers-core'),
								'type' => 'text'
							),
							'button2-link-to' => array(
								'title' => esc_html__('Button 2 Link To', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'custom-url' => esc_html__('Custom Url', 'goodlayers-core'),
									'lb-custom-image' => esc_html__('Lightbox with custom image', 'goodlayers-core'),
									'lb-video' => esc_html__('Video Lightbox', 'goodlayers-core'),
								),
								'default' => 'custom-url'
							),
							'button2-custom-image' => array(
								'title' => esc_html__('Upload Custom Image', 'goodlayers-core'),
								'type' => 'upload',
								'condition' => array( 'button2-link-to' => 'lb-custom-image' )
							),
							'button2-video-url' => array(
								'title' => esc_html__('Video Url ( Youtube / Vimeo )', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'button2-link-to' => 'lb-video' )
							),					
							'button2-button-link' => array(
								'title' => esc_html__('Button 2 Link', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'button2-link-to' => 'custom-url' )
							),
							'button2-link-target' => array(
								'title' => esc_html__('Button 2 Link Target', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'_self' => esc_html__('Current Screen', 'goodlayers-core'),
									'_blank' => esc_html__('New Window', 'goodlayers-core'),
								),
								'default' => '_self',
								'condition' => array( 'link-to' => 'custom-url' )
							),
							'button2-icon-position' => array(
								'title' => esc_html__('Button 2 Icon Position', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'left' => esc_html__('Left', 'goodlayers-core'),
									'right' => esc_html__('Right', 'goodlayers-core'),
								)
							),
							'button2-icon' => array(
								'title' => esc_html__('Button 2 Icon Selector', 'goodlayers-core'),
								'type' => 'icons',
								'default' => 'fa fa-gear',
								'wrapper-class' => 'gdlr-core-fullsize',
								'condition' => array( 'button2-icon-position' => array('left', 'right') )
							),
						)
					),
					'style-2' => array(
						'title' => esc_html('Button 2 Style', 'goodlayers-core'),
						'options' => array(
							'button2-padding' => array(
								'title' => esc_html__('Button Padding', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'15px', 'right'=>'33px', 'bottom'=>'15px', 'left'=>'33px', 'settings'=>'unlink' )
							),
							'border2-radius' => array(
								'title' => esc_html__('Button Border Radius', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '25px'
							),
							'button2-background' => array(
								'title' => esc_html__('Button Background', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'transparent' => esc_html__('Transparent', 'goodlayers-core'),
									'solid' => esc_html__('Solid', 'goodlayers-core'),
									'gradient' => esc_html__('Gradient', 'goodlayers-core'),
								),
								'default' => 'gradient'
							),
							'button2-border' => array(
								'title' => esc_html__('Button Border', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
							'border2-width' => array(
								'title' => esc_html__('Button Border Width', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'1px', 'right'=>'1px', 'bottom'=>'1px', 'left'=>'1px', 'settings'=>'link' ),
								'condition' => array( 'button2-border' => 'enable' )
							),
							'text2-color' => array(
								'title' => esc_html__('Button Text Color', 'goodlayers-core'),
								'type' => 'colorpicker'
							),
							'text2-hover-color' => array(
								'title' => esc_html__('Button Text Hover Color', 'goodlayers-core'), 
								'type' => 'colorpicker'
							),
							'background2-color' => array(
								'title' => esc_html__('Button Background Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button2-background' => array('solid', 'gradient') ) 
							),
							'background2-hover-color' => array(
								'title' => esc_html__('Button Background Hover Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button2-background' => array('solid') ) 
							),
							'background2-gradient-color' => array(
								'title' => esc_html__('Button Background Gradient Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button2-background' => array('gradient') ) 
							),
							'border2-color' => array(
								'title' => esc_html__('Button Border Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button2-border' => 'enable' )
							),
							'border2-hover-color' => array(
								'title' => esc_html__('Button Border Hover Color', 'goodlayers-core'),
								'type' => 'colorpicker',
								'condition' => array( 'button2-border' => 'enable' )
							),
						)
					),
					'typography' => array(
						'title' => esc_html('Typography', 'goodlayers-core'),
						'options' => array(
							'text-size' => array(
								'title' => esc_html__('Button Text Size', 'goodlayers-core'),
								'type' => 'fontslider',
								'default' => '13px'
							),
							'text-transform' => array(
								'title' => esc_html__('Button Text Transform', 'goodlayers-core'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'' => esc_html__('Default', 'goodlayers-core'),
									'none' => esc_html__('None', 'goodlayers-core'),
									'uppercase' => esc_html__('Uppercase', 'goodlayers-core'),
									'lowercase' => esc_html__('Lowercase', 'goodlayers-core'),
									'capitalize' => esc_html__('Capitalize', 'goodlayers-core'),
								),
							),
							'icon-size' => array(
								'title' => esc_html__('Button Icon Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),					
						)
					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'goodlayers-core'),
						'options' => array(
							'button2-left-margin' => array(
								'title' => esc_html__('Button 2 Left Margin', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '10px'
							),
							'item-top-margin' => array(
								'title' => esc_html__('Top Margin ( Item )', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '0px'
							),
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							),
						)
					),
				);
			}
			
			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings, true);
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array(), $preview = false ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'button-text' => esc_html__('Learn More', 'goodlayers-core'),
						'button-link' => '#', 'button-link-target' => '_self',
						'text-align' => 'center', 'text-size' => '13px', 'border-radius' => '25px', 'button-padding' => '', 'button-background' => 'gradient', 
						'text-color' => '', 'text-hover-color' => '', 
						'background-color' => '', 'background-hover-color' => '', 'background-gradient-color' => '',
						'button-border' => 'disable', 'border-width' => '', 'border-color' => '', 'border-hover-color' => '',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				if( !empty($settings['button2-text']) ){
					$settings['button-margin'] = '0px ' . (empty($settings['button2-left-margin'])? '10px': $settings['button2-left-margin']) . ' 10px 0px';
				}

				// start printing item
				$extra_class  = 'gdlr-core-' . (empty($settings['text-align'])? 'left': $settings['text-align']) . '-align'; 
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="gdlr-core-button-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ' . gdlr_core_esc_style(array(
					'padding-bottom' => (!empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb)? $settings['padding-bottom']: '',
					'margin-top' => (empty($settings['item-top-margin']) || $settings['item-top-margin'] == '0px')? '': $settings['item-top-margin']
				));
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				$ret .= gdlr_core_get_button($settings, $preview);

				// button 2
				if( !empty($settings['button2-text']) ){
					$settings['button-text'] = empty($settings['button2-text'])? '': $settings['button2-text']; 
						unset($settings['button2-text']);
					$settings['link-to'] = empty($settings['button2-link-to'])? '': $settings['button2-link-to']; 
						unset($settings['button2-link-to']);
					$settings['custom-image'] = empty($settings['button2-custom-image'])? '': $settings['button2-custom-image']; 
						unset($settings['button2-custom-image']);
					$settings['video-url'] = empty($settings['button2-video-url'])? '': $settings['button2-video-url']; 
						unset($settings['button2-video-url']);
					$settings['button-link'] = empty($settings['button2-button-link'])? '': $settings['button2-button-link']; 
						unset($settings['button2-button-link']);
					$settings['button-link-target'] = empty($settings['button2-link-target'])? '': $settings['button2-link-target']; 
						unset($settings['button2-link-target']);
					$settings['icon-position'] = empty($settings['button2-icon-position'])? '': $settings['button2-icon-position']; 
						unset($settings['button2-icon-position']);
					$settings['icon'] = empty($settings['button2-icon'])? '': $settings['button2-icon']; 
						unset($settings['button2-icon']);
					$settings['button-padding'] = empty($settings['button2-padding'])? '': $settings['button2-padding']; 
						unset($settings['button2-padding']);
					$settings['border-radius'] = empty($settings['border2-radius'])? '': $settings['border2-radius']; 
						unset($settings['border2-radius']);
					$settings['button-background'] = empty($settings['button2-background'])? '': $settings['button2-background']; 
						unset($settings['button2-background']);
					$settings['button-border'] = empty($settings['button2-border'])? '': $settings['button2-border']; 
						unset($settings['button2-border']);
					$settings['border-width'] = empty($settings['border2-width'])? '': $settings['border2-width']; 
						unset($settings['border2-width']);
					$settings['text-color'] = empty($settings['text2-color'])? '': $settings['text2-color']; 
						unset($settings['text2-color']);
					$settings['text-hover-color'] = empty($settings['text2-hover-color'])? '': $settings['text2-hover-color']; 
						unset($settings['text2-hover-color']);
					$settings['background-color'] = empty($settings['background2-color'])? '': $settings['background2-color']; 
						unset($settings['background2-color']);
					$settings['background-hover-color'] = empty($settings['background2-hover-color'])? '': $settings['background2-hover-color']; 
						unset($settings['background2-hover-color']);
					$settings['background-gradient-color'] = empty($settings['background2-gradient-color'])? '': $settings['background2-gradient-color']; 
						unset($settings['background2-gradient-color']);
					$settings['border-color'] = empty($settings['border2-color'])? '': $settings['border2-color']; 
						unset($settings['border2-color']);
					$settings['border-hover-color'] = empty($settings['border2-hover-color'])? '': $settings['border2-hover-color']; 
						unset($settings['border2-hover-color']);
					
					unset($settings['button-margin']);

					$ret .= gdlr_core_get_button($settings, $preview);
				}
				$ret .= '</div>';
				
				return $ret;
			}
			
		} // gdlr_core_pb_element_content
	} // class_exists	
	
	if( !function_exists('gdlr_core_get_button') ){
		function gdlr_core_get_button( $atts, $preview = false ){
			
			$atts['text-size'] = (empty($atts['text-size']) || $atts['text-size'] == '13px')? '': $atts['text-size']; 
			
			$ret  = '';
			$extra_class = '';
			
			$css_atts = array(
				'font-size' => $atts['text-size'],
				'color' => empty($atts['text-color'])? '': $atts['text-color'],
				'padding' => (empty($atts['button-padding']) || $atts['button-padding'] == array(
						'top' => '15px', 'right' => '33px', 'bottom' => '15px', 'left' => '33px', 'settings' => 'unlink'
					))? '': $atts['button-padding'],
				'text-transform' => empty($atts['text-transform'])? '': $atts['text-transform'], 
				'margin' => empty($atts['button-margin'])? '': $atts['button-margin'], 
				'border-radius' => (empty($atts['border-radius']) || $atts['border-radius'] == '25px')? '': $atts['border-radius'],
			);
			
			// background
			$atts['button-background'] = empty($atts['button-background'])? 'gradient': $atts['button-background'];
			$extra_class .= ' gdlr-core-button-' . $atts['button-background'];
			if( $atts['button-background'] == 'solid' ){
				$css_atts['background'] = empty($atts['background-color'])? '': $atts['background-color'];
			}else if( $atts['button-background'] == 'gradient' ){
				if( !empty($atts['background-color']) ){
					$css_atts['background'] = $atts['background-color'];
					
					if( !empty($atts['background-gradient-color']) ){
						$css_atts['gradient'] = array(
							$atts['background-color'],
							$atts['background-gradient-color']
						);
					}
				}
			}
			
			// border
			if( (empty($atts['button-border']) && $atts['button-background'] != 'transparent' ) || (!empty($atts['button-border']) && $atts['button-border'] == 'disable') ){	
				$extra_class .= ' gdlr-core-button-no-border';
			}else{
				$extra_class .= ' gdlr-core-button-with-border';
				$css_atts['border-width'] = (empty($atts['border-width']) || $atts['border-width'] == array( 
						'top'=>'1px', 'right'=>'1px', 'bottom'=>'1px', 'left'=>'1px', 'settings'=>'link'
					))? '': $atts['border-width'];
				$css_atts['border-color'] = empty($atts['border-color'])? '': $atts['border-color'];
			}
			
			if( !empty($atts['full-width-button']) && $atts['full-width-button'] == 'enable' ){
				$extra_class .= ' gdlr-core-button-full-width';
			} 

			// hover css for 'text-hover-color''background-hover-color''border-hover-color'
			$hover_style = gdlr_core_esc_style(array(
				'color' => empty($atts['text-hover-color'])? '': $atts['text-hover-color'],
				'border-color' => empty($atts['border-hover-color'])? '': $atts['border-hover-color'],
				'background-color' => (!empty($atts['background-hover-color']) && $atts['button-background'] == 'solid')? $atts['background-hover-color']: ''
			), false);
			
			if( !empty($hover_style) ){
				global $gdlr_core_button_id; 
				$gdlr_core_button_id = empty($gdlr_core_button_id)? array(): $gdlr_core_button_id;
				
				// generate unique id so it does not get overwritten in admin area
				$rnd_button_id = mt_rand(0, 99999);
				while( in_array($rnd_button_id, $gdlr_core_button_id) ){
					$rnd_button_id = mt_rand(0, 99999);
				}
				$gdlr_core_button_id[] = $rnd_button_id;
				
				$extra_style  = '#gdlr-core-button-id-' . $rnd_button_id . '{' . gdlr_core_esc_style($css_atts, false) . '}';
				$extra_style .= '#gdlr-core-button-id-' . $rnd_button_id . ':hover{' . $hover_style . '}';
				if( $preview ){
					$extra_style = '<style type="text/css" scoped >' . $extra_style . '</style>';
				}else{
					gdlr_core_add_inline_style($extra_style);
					$extra_style = '';
				}
				$css_atts = array();
			}
			
			// printing item
			if( !empty($atts['button-text']) ){

				if( !empty($atts['icon-position']) && $atts['icon-position'] != 'none' && !empty($atts['icon']) ){
					$button_icon = '<i class="gdlr-core-pos-' . esc_attr($atts['icon-position']) . ' ' . $atts['icon'] . '" ' . gdlr_core_esc_style(array(
						'font-size' => empty($atts['icon-size'])? '': $atts['icon-size']
					)) . ' ></i>';
				}

				$ret .= '<a ';
				if( empty($atts['link-to']) || $atts['link-to'] == 'custom-url' ){
					$ret .= 'class="gdlr-core-button ' . esc_attr($extra_class) . '" href="' . esc_url($atts['button-link']) . '" ';
					$ret .= (empty($atts['button-link-target']) || $atts['button-link-target'] == '_self')? '': 'target="' . esc_attr($atts['button-link-target']) . '" ';
				}else if( $atts['link-to'] == 'lb-custom-image' ){
					$image_url = '';
					$caption = '';
					if( !empty($atts['custom-image']) ){
						if( is_numeric($atts['custom-image']) ){
							$image_url = gdlr_core_get_image_url($atts['custom-image']);
							$caption = gdlr_core_get_image_info($atts['custom-image'], 'caption');;
						}else{
							$image_url = $atts['custom-image'];
						}
					}

					$ret .= gdlr_core_get_lightbox_atts(array(
						'class'=>'gdlr-core-button ' . $extra_class,
						'url'=>$image_url,
						'caption'=>$caption
					));
				}else if( $atts['link-to'] == 'lb-video' ){
					$ret .= gdlr_core_get_lightbox_atts(array(
						'class'=>'gdlr-core-button ' . $extra_class,
						'url'=>$atts['video-url'],
						'type'=>'video'
					));
				}
				$ret .= empty($rnd_button_id)? '': 'id="gdlr-core-button-id-' . esc_attr($rnd_button_id) . '" ';
				$ret .= gdlr_core_esc_style($css_atts) . ' >';
				if( !empty($button_icon) && $atts['icon-position'] == 'left' ){
					$ret .= $button_icon;
					$ret .= '<span class="gdlr-core-content" >' . gdlr_core_escape_content($atts['button-text']) . '</span>';
				}else if( !empty($button_icon) && $atts['icon-position'] == 'right' ){
					$ret .= '<span class="gdlr-core-content" >' . gdlr_core_escape_content($atts['button-text']) . '</span>';
					$ret .= $button_icon;
				}else{
					$ret .= '<span class="gdlr-core-content" >' . gdlr_core_escape_content($atts['button-text']) . '</span>';
				}
				$ret .= '</a>';
				$ret .= empty($extra_style)? '': $extra_style;
			}
			
			return $ret;
		}
	}
	
	// [gdlr_core_button button-text="Learn More" button-link="#" button-link-target="_blank" margin-right="20px" ]
	add_shortcode('gdlr_core_button', 'gdlr_core_button_shortcode');
	if( !function_exists('gdlr_core_button_shortcode') ){
		function gdlr_core_button_shortcode($atts, $content = ''){
			$atts = wp_parse_args($atts, array(
				'no-pdlr' => true,
				'margin-right' => '20px',
				'button-text' => 'Learn More'
			));

			$atts['button-margin'] = array(
				'right' => (empty($atts['margin-right']) || $atts['margin-right'] == '0px')? '': $atts['margin-right'],
				'left' => (empty($atts['margin-left']) || $atts['margin-left'] == '0px')? '': $atts['margin-left'],
				'bottom' => (empty($atts['margin-bottom']) || $atts['margin-bottom'] == '0px')? '': $atts['margin-bottom']
			);
			$atts['button-padding'] = empty($atts['padding'])? '': $atts['padding'];

			if( !empty($atts['border-width']) ){
				$atts['button-border'] = 'enable';
			}
			
			if( !empty($atts['video-url']) ){
				$atts['link-to'] = 'lb-video';
			}else if( !empty($atts['custom-image']) ){
				$atts['link-to'] = 'lb-custom-image';
			}

			return gdlr_core_get_button($atts);
		}
	}