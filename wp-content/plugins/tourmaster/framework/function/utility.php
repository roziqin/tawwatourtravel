<?php
	/*	
	*	Utility Files
	*	---------------------------------------------------------------------
	*	This file contains the function that helps doing things
	*	---------------------------------------------------------------------
	*/

	// include utility function for uses 
	// make sure to call this function inside wp_enqueue_script action
	if( !function_exists('tourmaster_include_utility_script') ){
		function tourmaster_include_utility_script( $settings = array() ){

			tourmaster_enqueue_icon();
			wp_enqueue_style('google-Montserrat', '//fonts.googleapis.com/css?family=Montserrat:400,700');

			if( !empty($settings['font-family']) && $settings['font-family'] == 'Open Sans' ){
				wp_enqueue_style('google-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,700');
			}

			wp_enqueue_style('tourmaster-utility', TOURMASTER_URL . '/framework/css/utility.css');

			wp_enqueue_script('tourmaster-utility', TOURMASTER_URL . '/framework/js/utility.js', array('jquery'), false, true);
			wp_localize_script('tourmaster-utility', 'tourmaster_utility', array(
				'confirm_head' => esc_html__('Just to confirm', 'tourmaster'),
				'confirm_text' => esc_html__('Are you sure to do this ?', 'tourmaster'),
				'confirm_sub' => esc_html__('* Please noted that this could not be undone.', 'tourmaster'),
				'confirm_yes' => esc_html__('Yes', 'tourmaster'),
				'confirm_no' => esc_html__('No', 'tourmaster'),
			));

		} // tourmaster_include_utility_script
	} // function_exists

	if( !function_exists('tourmaster_enqueue_icon') ){
		function tourmaster_enqueue_icon(){
			
			$font_awesome = tourmaster_get_option('plugin', 'font-awesome', 'enable');
			if( $font_awesome == 'enable' ){
				wp_enqueue_style('font-awesome', TOURMASTER_URL . '/plugins/font-awesome/css/font-awesome.min.css');
			}

			$elegant_icon = tourmaster_get_option('plugin', 'elegant-icon', 'enable');
			if( $elegant_icon = 'enable' ){
				wp_enqueue_style('elegant-icon', TOURMASTER_URL . '/plugins/elegant-font/style.css');
			}

		} // tourmaster_include_fontawesome
	} // function_exists

	// page builder content/text filer to execute the shortcode	
	if( !function_exists('tourmaster_content_filter') ){
		add_filter( 'tourmaster_the_content', 'wptexturize'        ); add_filter( 'tourmaster_the_content', 'convert_smilies'    );
		add_filter( 'tourmaster_the_content', 'convert_chars'      ); add_filter( 'tourmaster_the_content', 'wpautop'            );
		add_filter( 'tourmaster_the_content', 'shortcode_unautop'  ); add_filter( 'tourmaster_the_content', 'prepend_attachment' );	
		add_filter( 'tourmaster_the_content', 'do_shortcode', 11   );
		function tourmaster_content_filter( $content, $main_content = false ){
			if($main_content) return str_replace( ']]>', ']]&gt;', apply_filters('the_content', $content) );
			
			$content = preg_replace_callback( '|(https?://[^\s"<]+)|im', 'tourmaster_content_oembed', $content );
			
			return apply_filters('tourmaster_the_content', $content);
		}		
	}
	if( !function_exists('tourmaster_content_oembed') ){
		function tourmaster_content_oembed( $link ){

			if( preg_match('/youtube|youtu\.be|vimeo/', $link[1]) ){
				$html = wp_oembed_get($link[1]);
				
				if( $html ) return $html;
			}
			return $link[1];
		}
	}
	if( !function_exists('tourmaster_text_filter') ){
		add_filter('tourmaster_text_filter', 'do_shortcode', 11);
		function tourmaster_text_filter( $text ){
			return apply_filters('tourmaster_text_filter', $text);
		}
	}

	// process data sent from the post variable
	if( !function_exists('tourmaster_process_post_data') ){
		function tourmaster_process_post_data( $post ){
			return stripslashes_deep($post);
		} // tourmaster_process_post_data
	} // function_exists

	// use to add style attribute
	if( !function_exists('tourmaster_esc_style') ){
		function tourmaster_esc_style($atts, $wrap = true){
			if( empty($atts) ) return '';

			$att_style = '';
			foreach($atts as $key => $value){
				if( empty($value) ) continue;
				
				switch($key){
					
					case 'border-radius': 
						$att_style .= "border-radius: {$value};";
						$att_style .= "-moz-border-radius: {$value};";
						$att_style .= "-webkit-border-radius: {$value};";
						break;
					
					case 'gradient': 
						if( is_array($value) && sizeOf($value) > 1 ){
							$att_style .= "background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-moz-background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-o-background: linear-gradient({$value[0]}, {$value[1]});";
							$att_style .= "-webkit-background: linear-gradient({$value[0]}, {$value[1]});";
						}
						break;
					
					case 'background':
					case 'background-color':
					case 'border':
					case 'border-color':
					case 'border-top-color':
					case 'border-right-color':
					case 'border-bottom-color':
					case 'border-left-color':
						if( is_array($value) ){
							$rgba_value = tourmaster_format_datatype($value[0], 'rgba');
							$att_style .= "{$key}: rgba({$rgba_value}, {$value[1]});";
						}else{
							$att_style .= "{$key}: {$value};";
						}
						break;

					case 'background-image':
						if( is_numeric($value) ){
							$image_url = tourmaster_get_image_url($value);
							if( !empty($image_url) ){
								$att_style .= "background-image: url({$image_url});";
							}
						}else{
							$att_style .= "background-image: url({$value});";
						}
						break;
					
					case 'padding':
					case 'margin':
					case 'border-width':
						if( is_array($value) ){
							if( !empty($value['top']) && !empty($value['right']) && !empty($value['bottom']) && !empty($value['left']) ){
								$att_style .= "{$key}: {$value['top']} {$value['right']} {$value['bottom']} {$value['left']};";
							}else{
								foreach($value as $pos => $val){
									if( $pos != 'settings' && (!empty($val) || $val === '0') ){
										if( $key == 'border-width' ){
											$att_style .= "border-{$pos}-width: {$val};";
										}else{
											$att_style .= "{$key}-{$pos}: {$val};";
										}
									}
								}
							}
						}else{
							$att_style .= "{$key}: {$value};";
						}
						break;
					
					default: 
						$value = is_array($value)? ((empty($value[0]) || $value[0] === '0')? '': $value[0]): $value;
						$att_style .= "{$key}: {$value};";
				}
			}
			
			if( !empty($att_style) ){
				if( $wrap ){
					return 'style="' . esc_attr($att_style) . '" ';
				}
				return $att_style;
			}
			return '';
		}
	}

	// get table html data
	if( !function_exists('tourmaster_get_table_head') ){
		function tourmaster_get_table_head( $data, $settings = array() ){
			echo '<tr>';
			foreach( $data as $column ){
				echo '<th>' . $column . '</th>';
			}
			echo '</tr>';
		}
	}
	if( !function_exists('tourmaster_get_table_content') ){
		function tourmaster_get_table_content( $data, $settings = array() ){
			echo '<tr>';
			foreach( $data as $column ){
				echo '<td>' . $column . '</td>';
			}
			echo '</tr>';
		}
	}

	// format data to specific type
	if( !function_exists('tourmaster_format_datatype') ){
		function tourmaster_format_datatype( $value, $data_type ){
			if( $data_type == 'color' ){
				return (strpos($value, '#') === false)? '#' . $value: $value; 
			}else if( $data_type == 'rgba' ){
				$value = str_replace('#', '', $value);
				if(strlen($value) == 3) {
					$r = hexdec(substr($value,0,1) . substr($value,0,1));
					$g = hexdec(substr($value,1,1) . substr($value,1,1));
					$b = hexdec(substr($value,2,1) . substr($value,2,1));
				}else{
					$r = hexdec(substr($value,0,2));
					$g = hexdec(substr($value,2,2));
					$b = hexdec(substr($value,4,2));
				}
				return $r . ', ' . $g . ', ' . $b;
			}else if( $data_type == 'text' ){
				return trim($value);
			}else if( $data_type == 'pixel' ){
				return (is_numeric($value))? $value . 'px': $value;
			}else if( $data_type == 'file' ){
				if(is_numeric($value)){
					$image_src = wp_get_attachment_image_src($value, 'full');	
					return (!empty($image_src))? $image_src[0]: false;
				}else{
					return $value;
				}
			}else if( $data_type == 'font'){
				return trim($value);
			}else if( $data_type == 'percent' ){
				return (is_numeric($value))? $value . '%': $value;
			}else if( $data_type == 'opacity' ){
				return (intval($value) / 100);
			} 
		}
	}	

	// get option for uses
	if( !function_exists('tourmaster_get_option') ){
		function tourmaster_get_option($option, $key = '', $default = ''){
			$option = 'tourmaster_' . $option;
			
			if( empty($GLOBALS[$option]) ){
				$GLOBALS[$option] = get_option($option, '');
			}
				
			if( !empty($key) ){
				if( !empty($GLOBALS[$option][$key]) || (isset($GLOBALS[$option][$key]) && $GLOBALS[$option][$key] === '0') ){
					return $GLOBALS[$option][$key];
				}else{
					return $default;
				}
			}else{
				return $GLOBALS[$option];
			}
		}
	}
	if( !function_exists('tourmaster_get_post_meta') ){
		function tourmaster_get_post_meta($post_id, $key = ''){
			global $tourmaster_post_meta;

			if( empty($tourmaster_post_meta['id']) || $tourmaster_post_meta['id'] != $post_id ){
				$tourmaster_post_meta = array(
					'id' => $post_id,
					'value' => get_post_meta($post_id, $key, true)
				);
			}
			return $tourmaster_post_meta['value'];
		}
	}

	// retrieve all posts from each post type
	if( !function_exists('tourmaster_get_post_list') ){	
		function tourmaster_get_post_list( $post_type, $with_none = false ){
			$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>99));

			$ret = array();
			if( !empty($with_none) ){
				$ret[''] = esc_html__('None', 'tourmaster');
			}

			if( !empty($post_list) ){
				foreach( $post_list as $post ){
					$ret[$post->ID] = $post->post_title;
				}
			}
				
			return $ret;
		}	
	}

	// get all thumbnail name
	if( !function_exists('tourmaster_get_thumbnail_list') ){
		function tourmaster_get_thumbnail_list(){
			$ret = array();
			
			$thumbnails = get_intermediate_image_sizes();
			$ret['full'] = esc_html__('full size', 'tourmaster');
			foreach( $thumbnails as $thumbnail ) {
				if( !empty($GLOBALS['_wp_additional_image_sizes'][$thumbnail]) ){
					$width = $GLOBALS['_wp_additional_image_sizes'][$thumbnail]['width'];
					$height = $GLOBALS['_wp_additional_image_sizes'][$thumbnail]['height'];
				}else{
					$width = get_option($thumbnail . '_size_w', '');
					$height = get_option($thumbnail . '_size_h', '');
				}
				$ret[$thumbnail] = $thumbnail . ' ' . $width . '-' . $height;
			}
			return $ret;
		}
	}

	// get all sidebar name
	if( !function_exists('tourmaster_get_sidebar_list') ){
		function tourmaster_get_sidebar_list( $settings = array() ){
			global $wp_registered_sidebars;
			
			$sidebars = array();
			if( !empty($settings['with-none']) ){
				$sidebars['none'] = esc_html__('None', 'tourmaster');
			}
			if( !empty($settings['with-default']) ){
				$sidebars['default'] = esc_html__('Default', 'tourmaster');
			}
			if( !empty($wp_registered_sidebars) && is_array($wp_registered_sidebars) ){
				foreach( $wp_registered_sidebars as $sidebar_id => $value ) {
					$sidebars[$sidebar_id] = $value['name'];
				}
			}
			
			return $sidebars;
		}
	}