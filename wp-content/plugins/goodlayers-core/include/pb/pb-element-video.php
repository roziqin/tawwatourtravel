<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('video', 'gdlr_core_pb_element_video'); 
	
	if( !class_exists('gdlr_core_pb_element_video') ){
		class gdlr_core_pb_element_video{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-video-camera',
					'title' => esc_html__('Video', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'video-type' => array(
								'title' => esc_html__('Video Type', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => array(
									'html5' => GDLR_CORE_URL . '/include/images/video/html5.png',
									'youtube' => GDLR_CORE_URL . '/include/images/video/youtube.png',
									'vimeo' => GDLR_CORE_URL . '/include/images/video/vimeo.png',
								),
								'default' => 'youtube',
								'wrapper-class' => 'gdlr-core-fullsize'
							),		
							'video-url' => array(
								'title' => esc_html__('Video URL', 'goodlayers-core'),
								'type' => 'text',
								'default' => 'https://www.youtube.com/watch?v=Ow2Shb_nkOw',
								'condition' => array( 'video-type' => array('youtube','vimeo') )
							),
							'video-url-mp4' => array(
								'title' => esc_html__('Background Video URL (MP4)', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'video-type' => 'html5' ),
							),
							'video-url-webm' => array(
								'title' => esc_html__('Background Video URL (WEBM)', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'video-type' => 'html5' ),
							),
							'video-url-ogg' => array(
								'title' => esc_html__('Background Video URL (ogg)', 'goodlayers-core'),
								'type' => 'text',
								'condition' => array( 'video-type' => 'html5' ),
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
?><script type="text/javascript" id="gdlr-core-preview-video-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-video-<?php echo esc_attr($id); ?>').parent().gdlr_core_content_script().gdlr_core_mejs_ajax();
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
						'video-type' => 'youtube',
						'video-url' => 'https://www.youtube.com/watch?v=Ow2Shb_nkOw',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				$settings['video-type'] = empty($settings['video-type'])? 'youtube': $settings['video-type'];

				// start printing item
				$extra_class  = empty($settings['class'])? '': $settings['class'];
				$ret  = '<div class="gdlr-core-video-item gdlr-core-item-pdlr gdlr-core-item-pdb ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';


				$ret .= '<div class="gdlr-core-video-item-type-' . esc_attr($settings['video-type']) . '" >';
				if( $settings['video-type'] == 'html5' ){
					$video_atts = array();
					if( !empty($settings['video-url-mp4']) ){
						$video_atts['mp4'] = $settings['video-url-mp4'];
					}
					if( !empty($settings['video-url-webm']) ){
						$video_atts['webm'] = $settings['video-url-webm'];
					}
					if( !empty($settings['video-url-ogg']) ){
						$video_atts['ogg'] = $settings['video-url-ogg'];
					}
					$ret .= wp_video_shortcode($video_atts);
				}else{
					if( !empty($settings['video-url']) ){
						$ret .= gdlr_core_get_video($settings['video-url']);
					}
				}
				$ret .= '</div>'; // video-item-type

				$ret .= '</div>';
				
				return $ret;
			}
			
		} // gdlr_core_pb_element_video
	} // class_exists	