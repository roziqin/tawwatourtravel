<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('post-slider', 'gdlr_core_pb_element_post_slider'); 
	
	if( !class_exists('gdlr_core_pb_element_post_slider') ){
		class gdlr_core_pb_element_post_slider{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-arrows-h',
					'title' => esc_html__('Post Slider', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(					
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'category' => array(
								'title' => esc_html__('Category', 'goodlayers-core'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('category'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'goodlayers-core'),
							),
							'tag' => array(
								'title' => esc_html__('Tag', 'goodlayers-core'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('post_tag')
							),
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 9,
								'description' => esc_html__('The number of posts showing on the post slider item', 'goodlayers-core')
							),
							'orderby' => array(
								'title' => esc_html__('Order By', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'date' => esc_html__('Publish Date', 'goodlayers-core'), 
									'title' => esc_html__('Title', 'goodlayers-core'), 
									'rand' => esc_html__('Random', 'goodlayers-core'), 
								)
							),
							'order' => array(
								'title' => esc_html__('Order', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'desc'=>esc_html__('Descending Order', 'goodlayers-core'), 
									'asc'=> esc_html__('Ascending Order', 'goodlayers-core'), 
								)
							),
						),
					),
					'style' => array(
						'title' => esc_html('Style', 'goodlayers-core'),
						'options' => array(
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => 'thumbnail-size'
							),
							'meta-option' => array(
								'title' => esc_html__('Meta Option', 'goodlayers-core'),
								'type' => 'multi-combobox',
								'options' => array( 
									'date' => esc_html__('Date', 'goodlayers-core'),
									'author' => esc_html__('Author', 'goodlayers-core'),
									'category' => esc_html__('Category', 'goodlayers-core'),
									'tag' => esc_html__('Tag', 'goodlayers-core'),
									'comment' => esc_html__('Comment', 'goodlayers-core'),
									'comment-number' => esc_html__('Comment Number', 'goodlayers-core'),
								),
								'default' => array('date', 'author', 'tag')
							),
							'text-align' => array(
								'title' => esc_html__('Text Align', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'center'
							),
							'slider-navigation' => array(
								'title' => esc_html__('Slider Navigation', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'navigation' => esc_html__('Only Navigation', 'goodlayers-core'),
									'bullet' => esc_html__('Only Bullet', 'goodlayers-core'),
									'both' => esc_html__('Both Navigation and Bullet', 'goodlayers-core'),
								),
								'default' => 'navigation'
							),
							'slider-effects' => array(
								'title' => esc_html__('Slider Effects', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'default' => esc_html__('Default', 'goodlayers-core'),
									'kenburn' => esc_html__('Kenburn', 'goodlayers-core'),
								),
								'default' => 'default'
							)
						),
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
?><script type="text/javascript" id="gdlr-core-preview-post-slider-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-post-slider-<?php echo esc_attr($id); ?>').parent().gdlr_core_flexslider();
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
						'category' => '', 'tag' => '', 'num-fetch' => '9', 'thumbnail-size' => 'full', 'orderby' => 'date', 'order' => 'desc',
						'meta-option' => array('date', 'author', 'tag'),
						'text-align' => 'center', 'padding-bottom' => $gdlr_core_item_pdb
					);
				}
			
				$settings['text-align'] = empty($settings['text-align'])? 'center': $settings['text-align'];
				$settings['thumbnail-size'] = empty($settings['thumbnail-size'])? 'full': $settings['thumbnail-size'];
				$settings['meta-option'] = empty($settings['meta-option'])? array(): $settings['meta-option'];

				// start printing item
				$extra_class  = empty($settings['class'])? '': $settings['class'];
				$ret  = '<div class="gdlr-core-post-slider-item gdlr-core-item-pdb gdlr-core-item-pdlr clearfix ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				// query
				$args = array( 'post_type' => 'post', 'suppress_filters' => false );
				
				// category - tag selection
				if( !empty($settings['category']) || !empty($settings['tag']) ){
					$args['tax_query'] = array('relation' => 'OR');
					
					if( !empty($settings['category']) ){
						array_push($args['tax_query'], array('terms'=>$settings['category'], 'taxonomy'=>'category', 'field'=>'slug'));
					}
					if( !empty($settings['tag']) ){
						array_push($args['tax_query'], array('terms'=>$settings['tag'], 'taxonomy'=>'post_tag', 'field'=>'slug'));
					}
				}
				
				// variable
				$args['posts_per_page'] = $settings['num-fetch'];
				$args['orderby'] = $settings['orderby'];
				$args['order'] = $settings['order'];
				
				$query = new WP_Query( $args );

				// prepare slider
				$slides = array();
				$flex_atts = array(
					'navigation' => empty($settings['slider-navigation'])? 'navigation': $settings['slider-navigation'],
					'effect' => empty($settings['slider-effects'])? '': $settings['slider-effects']
				);

				while( $query->have_posts() ){ $query->the_post(); 

					$blog_style = new gdlr_core_blog_style();
					$feature_image = get_post_thumbnail_id();
					if( !empty($feature_image) ){
						$slide  = '<div class="gdlr-core-post-slider-slide" >';
						$slide .= '<div class="gdlr-core-post-slider-image gdlr-core-media-image" >';
						$slide .= gdlr_core_get_image($feature_image, $settings['thumbnail-size']);
						$slide .= '</div>'; // gdlr-core-post-slider-image

						$slide .= '<div class="gdlr-core-post-slider-caption gdlr-core-' . esc_attr($settings['text-align']) . '-align" >';
						$slide .= '<h3 class="gdlr-core-post-slider-title" ><a href="' . get_permalink() . '" >' . get_the_title() . '</a></h3>';
						$slide .= '<div class="gdlr-core-post-slider-widget-info">' . $blog_style->blog_info(array(
								'display' => $settings['meta-option'],
								'separator' => '/',
								'icon' => false
						)) . '</div>';

						$slide .= '</div>'; // gdlr-core-post-slider-caption
						$slide .= '</div>'; // gdlr-core-post-slider-slide

						$slides[] = $slide;
					}
				}	
				wp_reset_postdata();

				$ret .= gdlr_core_get_flexslider($slides, $flex_atts);

				$ret .= '</div>'; // gdlr-core-blog-item
				
				return $ret;
			}			
			
		} // gdlr_core_pb_element_post_slider
	} // class_exists	