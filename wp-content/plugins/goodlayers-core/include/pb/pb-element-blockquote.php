<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('blockquote', 'gdlr_core_pb_element_blockquote'); 
	
	if( !class_exists('gdlr_core_pb_element_blockquote') ){
		class gdlr_core_pb_element_blockquote{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-quote-left',
					'title' => esc_html__('Blockquote', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'content' => array(
								'title' => esc_html__('Content', 'goodlayers-core'),
								'type' => 'tinymce',
								'default' => esc_html__('Blockquote item sample content', 'goodlayers-core'),
								'wrapper-class' => 'gdlr-core-fullsize'
							),	
							'author' => array(
								'title' => esc_html__('By ( Author )', 'goodlayers-core'),
								'type' => 'text',
								'default' => esc_html__('Blockquote Author', 'goodlayers-core'),
							),							
						)
					),
					'style' => array(
						'title' => esc_html('Style', 'goodlayers-core'),
						'options' => array(
							'text-align' => array(
								'title' => esc_html__('Text Align', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'center'
							),
							'size' => array(
								'title' => esc_html__('Size', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'small' => esc_html__('Small', 'goodlayers-core'),
									'medium' => esc_html__('Medium', 'goodlayers-core'),
									'large' => esc_html__('Large', 'goodlayers-core'),
								),
								'default' => 'medium'
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
				);
			}
			
			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array() ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'content' => esc_html__('Blockquote item sample content', 'goodlayers-core'),
						'author' => esc_html__('Blockquote Author', 'goodlayers-core'),
						'text-align' => 'center', 'size' => 'medium',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				// start printing item
				$extra_class  = ' gdlr-core-' . (empty($settings['text-align'])? 'left': $settings['text-align']) . '-align';
				$extra_class .= ' gdlr-core-' . (empty($settings['size'])? 'left': $settings['size']) . '-size';
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="gdlr-core-blockquote-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				
				$ret .= '<div class="gdlr-core-blockquote gdlr-core-info-font" >';
				$ret .= '<div class="gdlr-core-blockquote-item-quote gdlr-core-quote-font gdlr-core-skin-icon" >' . (($settings['text-align'] == 'right')? '&#8221;': '&#8220;') . '</div>';
				$ret .= '<div class="gdlr-core-blockquote-item-content-wrap" >';
				if( !empty($settings['content']) ){
					$ret .= '<div class="gdlr-core-blockquote-item-content gdlr-core-skin-content">' . gdlr_core_content_filter($settings['content']) . '</div>';
				}
				if( !empty($settings['author']) ){
					$ret .= '<div class="gdlr-core-blockquote-item-author gdlr-core-skin-caption">' . gdlr_core_text_filter($settings['author']) . '</div>';
				}
				$ret .= '</div>';
				$ret .= '</div>';
				$ret .= '</div>';
				
				return $ret;
			}
			
		} // gdlr_core_pb_element_content
	} // class_exists	