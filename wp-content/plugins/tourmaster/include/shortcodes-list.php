<?php
	/*	
	*	Tourmaster Custom Shortcodes
	*	---------------------------------------------------------------------
	*/

	add_action('init', 'tourmaster_register_tinymce_button');
	if( !function_exists('tourmaster_register_tinymce_button') ){
		function tourmaster_register_tinymce_button() {
		    add_filter('mce_buttons', 'tourmaster_add_tinymce_button');
		    add_filter('mce_external_plugins', 'tourmaster_set_tinymce_button_script');
		}
	}

	if( !function_exists('tourmaster_add_tinymce_button') ){
		function tourmaster_add_tinymce_button($buttons){
		   array_push($buttons, 'tourmaster');
		   return $buttons;
		}
	}

	if( !function_exists('tourmaster_set_tinymce_button_script') ){
		function tourmaster_set_tinymce_button_script($plugin_array){
		    $plugin_array['tourmaster'] = TOURMASTER_URL . '/include/js/shortcode-list.js';
		    return $plugin_array;
		}
	}

	add_action('admin_print_scripts', 'tourmaster_print_shortcodes_variable');
	if( !function_exists('tourmaster_print_shortcodes_variable') ){
		function tourmaster_print_shortcodes_variable(){
			$shortcode_list = apply_filters('tourmaster_shortcode_list', array());
			$count = 0;

			echo '<script type="text/javascript">';
			echo 'var tourmaster_shortcodes = [';
			foreach( $shortcode_list as $shortcode ){
				if( $count > 0 ){
					echo ', ';
				}
				if( !empty($shortcode['title']) && !empty($shortcode['value']) ){
					echo '{ title: \'' . $shortcode['title'] . '\', value: \'' . $shortcode['value'] . '\' }';
				}
				$count++;
			}
			echo '];';
			echo '</script>';
		}
	}

	// register the shortcode items
	if( is_admin() ){ add_filter('tourmaster_shortcode_list', 'tourmaster_register_shortcode_list'); }
	if( !function_exists('tourmaster_register_shortcode_list') ){
		function tourmaster_register_shortcode_list( $shortcode_list ){
			$shortcode_list = array_merge($shortcode_list, array(
				array(
					'title' => 'Test',
					'value' => '[Test]'
				),
			));

			return $shortcode_list;
		}
	}