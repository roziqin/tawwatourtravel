<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('divider', 'gdlr_core_pb_element_divider'); 
	
	if( !class_exists('gdlr_core_pb_element_divider') ){
		class gdlr_core_pb_element_divider{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-minus',
					'title' => esc_html__('Divider', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(	
							'type' => array(
								'title' => esc_html__('Divider Type', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => array(
									'normal' => GDLR_CORE_URL . '/include/images/divider/normal.png',
									'with-icon' => GDLR_CORE_URL . '/include/images/divider/with-icon.png',
									'small-center' => GDLR_CORE_URL . '/include/images/divider/small-center.png',
									'small-left' => GDLR_CORE_URL . '/include/images/divider/small-left.png',
									'small-right' => GDLR_CORE_URL . '/include/images/divider/small-right.png',
								),
								'default' => 'normal',
								'wrapper-class' => 'gdlr-core-fullsize'
							), 
							'icon-type' => array(
								'title' => esc_html__('Icon Type', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'icon' => esc_html__('Icon', 'goodlayers-core'),
									'image' => esc_html__('Image', 'goodlayers-core'),
								),
								'condition' => array( 'type' => 'with-icon' ),
							), 
							'image' => array(
								'title' => esc_html__('Upload Icon', 'goodlayers-core'),
								'type' => 'upload',
								'condition' => array( 'type' => 'with-icon', 'icon-type' => 'image' ),
							),
							'icon' => array(
								'title' => esc_html__('Icon', 'goodlayers-core'),
								'type' => 'icons',
								'default' => 'fa fa-film',
								'wrapper-class' => 'gdlr-core-fullsize',
								'condition' => array( 'type' => 'with-icon', 'icon-type' => 'icon' ),
								
							),
							'style' => array(
								'title' => esc_html__('Divider Style', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => array(
									'solid' => GDLR_CORE_URL . '/include/images/divider/solid.png',
									'double' => GDLR_CORE_URL . '/include/images/divider/double.png',
									'dotted' => GDLR_CORE_URL . '/include/images/divider/dotted.png',
									'dashed' => GDLR_CORE_URL . '/include/images/divider/dashed.png'
								),
								'default' => 'solid',
								'condition' => array( 'type' => array('normal', 'with-icon') ),
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'align' => array(
								'title' => esc_html__('Divider Align', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'center',
								'condition' => array( 'type' => array('normal', 'with-icon') )
							),
							'icon-size' => array(
								'title' => esc_html__('Icon Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '15px',
								'condition' => array( 'type' => 'with-icon', 'icon-type' => 'icon' ),
							),
							'divider-size' => array(
								'title' => esc_html__('Divider Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '1px',
								'condition' => array( 'type' => array('normal', 'with-icon') ),
								'description' => esc_html__('At least "4px" is required for double divider style', 'goodlayers-core')
							),
							'divider-width' => array(
								'title' => esc_html__('Max Divider Width', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '',
							), 						
						)
					),
					'spacing' => array(
						'title' => esc_html('Spacing', 'goodlayers-core'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
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
							'divider-color' => array(
								'title' => esc_html__('Divider Color', 'goodlayers-core'),
								'type' => 'colorpicker'
							),
						)
					),
				);
			}
			
			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-divider-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-divider-<?php echo esc_attr($id); ?>').parent().gdlr_core_divider();
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
						'type' => 'normal', 'icon-type' => 'icon', 'image' => '', 'icon' => 'fa fa-film', 'icon-size' => '15px',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				$border_atts = array(
					'border-color' => (empty($settings['divider-color'])? '': $settings['divider-color']),
					'border-bottom-style' => ((empty($settings['style']) || $settings['style'] == 'solid')? '': $settings['style']),
					'border-bottom-width' => ((empty($settings['divider-size']) || $settings['divider-size'] == '1px')? '': $settings['divider-size'])
				);
					
				// start printing item
				$extra_class  = 'gdlr-core-divider-item-' . $settings['type'];
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="gdlr-core-divider-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				if( !empty($settings['divider-width']) ){
					$align_class = 'gdlr-core-' . (empty($settings['align'])? 'center': $settings['align']) . '-align';
					$ret .= '<div class="gdlr-core-divider-container ' . esc_attr($align_class) . '" ' . gdlr_core_esc_style(array(
						'max-width' => $settings['divider-width']
					)) . ' >';
				}

				if( $settings['type'] == 'normal' ){
					$ret .= '<div class="gdlr-core-divider-line gdlr-core-skin-divider" ' . gdlr_core_esc_style($border_atts) . '></div>';
				}else if( $settings['type'] == 'with-icon' ){
					$ret .= '<div class="gdlr-core-divider-item-with-icon-inner gdlr-core-js">';
					$ret .= '<div class="gdlr-core-divider-line gdlr-core-left gdlr-core-skin-divider" ' . gdlr_core_esc_style($border_atts) . '></div>';
					if( $settings['icon-type'] == 'icon' ){
						if( !empty($settings['icon']) ){
							$ret .= '<i class="' . esc_attr($settings['icon']) . '" ' . gdlr_core_esc_style(array(
								'color' => (empty($settings['icon-color'])? '': $settings['icon-color']),
								'font-size' => ((empty($settings['icon-size']) || $settings['icon-size'] == '15px')? '': $settings['icon-size'])
							)) . ' ></i>';
						}
					}else if( $settings['icon-type'] == 'image' ){
						if( !empty($settings['image']) ){
							$ret .= gdlr_core_get_image($settings['image']);
						}
					}
					$ret .= '<div class="gdlr-core-divider-line gdlr-core-skin-divider gdlr-core-right" ' . gdlr_core_esc_style($border_atts) . '></div>';
					$ret .= '</div>';
				}else{
					$divider_color = array( 'border-color' => (empty($settings['divider-color'])? '': $settings['divider-color']) );
					$ret .= '<div class="gdlr-core-divider-line gdlr-core-skin-divider" ' . gdlr_core_esc_style($divider_color) . ' >';
					$ret .= '<div class="gdlr-core-divider-line-bold  gdlr-core-skin-divider" ' . gdlr_core_esc_style($divider_color) . ' ></div>';
					$ret .= '</div>';
				}

				if( !empty($settings['divider-width']) ){
					$ret .= '</div>'; // gdlr-core-divider-container
				}
				
				$ret .= '</div>'; // gdlr-core-divider-item
				
				return $ret;
			}
			
		} // gdlr_core_pb_element_divider
	} // class_exists	