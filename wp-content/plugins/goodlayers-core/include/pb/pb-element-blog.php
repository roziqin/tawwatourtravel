<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('blog', 'gdlr_core_pb_element_blog'); 
	
	if( !class_exists('gdlr_core_pb_element_blog') ){
		class gdlr_core_pb_element_blog{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-newspaper-o',
					'title' => esc_html__('Blog', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return apply_filters('gdlr_core_blog_item_options', array(					
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
								'default' => 9,
								'data-input-type' => 'number',
								'description' => esc_html__('The number of posts showing on the blog item', 'goodlayers-core')
							),
							'prepend-sticky' => array(
								'title' => esc_html__('Prepend Sticky Post', 'goodlayers-core'),
								'type' => 'checkbox',
								'description' => esc_html__('Prepend sticky post at the top of the post.', 'goodlayers-core')
							),
							'orderby' => array(
								'title' => esc_html__('Order By', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'date' => esc_html__('Publish Date', 'goodlayers-core'), 
									'title' => esc_html__('Title', 'goodlayers-core'), 
									'rand' => esc_html__('Random', 'goodlayers-core'), 
									'menu_order' => esc_html__('Menu Order', 'goodlayers-core'), 
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
							'pagination' => array(
								'title' => esc_html__('Pagination', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none'=>esc_html__('None', 'goodlayers-core'), 
									'page'=>esc_html__('Page', 'goodlayers-core'), 
									'load-more'=>esc_html__('Load More', 'goodlayers-core'), 
								),
								'description' => esc_html__('Pagination is not supported and will be automatically disabled on carousel layout.', 'goodlayers-core'),
							),
							'pagination-style' => array(
								'title' => esc_html__('Pagination Style', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'default' => esc_html__('Default', 'goodlayers-core'),
									'plain' => esc_html__('Plain', 'goodlayers-core'),
									'rectangle' => esc_html__('Rectangle', 'goodlayers-core'),
									'rectangle-border' => esc_html__('Rectangle Border', 'goodlayers-core'),
									'round' => esc_html__('Round', 'goodlayers-core'),
									'round-border' => esc_html__('Round Border', 'goodlayers-core'),
									'circle' => esc_html__('Circle', 'goodlayers-core'),
									'circle-border' => esc_html__('Circle Border', 'goodlayers-core'),
								),
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
							'pagination-align' => array(
								'title' => esc_html__('Pagination Alignment', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'with-default' => true,
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
							'offset' => array(
								'title' => esc_html__('Query Offset', 'goodlayers-core'),
								'type' => 'text',
								'default' => 0,
								'data-input-type' => 'number',
								'condition' => array( 'pagination' => 'none' ),
								'description' => esc_html__('The number of posts you want to skip, cannot be used with pagination.', 'goodlayers-core')
							),					
						),
					),
					'settings' => array(
						'title' => esc_html('Blog Style', 'goodlayers-core'),
						'options' => array(
							'blog-style' => array(
								'title' => esc_html__('Blog Style', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => array(
									'blog-full' => GDLR_CORE_URL . '/include/images/blog-style/blog-full.png',
									'blog-full-with-frame' => GDLR_CORE_URL . '/include/images/blog-style/blog-full-with-frame.png',
									'blog-column' => GDLR_CORE_URL . '/include/images/blog-style/blog-column.png',
									'blog-column-with-frame' => GDLR_CORE_URL . '/include/images/blog-style/blog-column-with-frame.png',
									'blog-column-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-column-no-space.png',
									'blog-image' => GDLR_CORE_URL . '/include/images/blog-style/blog-image.png',
									'blog-image-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-image-no-space.png',
									'blog-left-thumbnail' => GDLR_CORE_URL . '/include/images/blog-style/blog-left-thumbnail.png',
									'blog-right-thumbnail' => GDLR_CORE_URL . '/include/images/blog-style/blog-right-thumbnail.png',
									'blog-metro' => GDLR_CORE_URL . '/include/images/blog-style/blog-metro.png',
									'blog-metro-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-metro-no-space.png',
									'blog-list' => GDLR_CORE_URL . '/include/images/blog-style/blog-list.png',
									'blog-list-center' => GDLR_CORE_URL . '/include/images/blog-style/blog-list-center.png',
									'blog-widget' => GDLR_CORE_URL . '/include/images/blog-style/blog-widget.png',
								),
								'default' => 'blog-full',
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'blog-full-alignment' => array(
								'title' => esc_html__('Blog Full Alignment', 'goodlayers-core'),
								'type' => 'combobox',
								'default' => 'enable',
								'options' => array(
									'left' => esc_html__('Left', 'goodlayers-core'),
									'center' => esc_html__('Center', 'goodlayers-core'),
								),
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame') )
							),
							'blog-list-with-frame' => array(
								'title' => esc_html__('Blog List With Frame', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable',
								'condition' => array( 'blog-style' => array('blog-list', 'blog-list-center') )
							),
							'always-show-overlay-content' => array(
								'title' => esc_html__('Always Show Overlay Content', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable',
								'condition' => array( 'blog-style' => array('blog-image', 'blog-image-no-space') )
							),
							'show-thumbnail' => array(
								'title' => esc_html__('Show Thumbnail', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-widget') )
							),
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => 'thumbnail-size',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-metro', 'blog-metro-no-space','blog-widget') , 'show-thumbnail' => array( 'enable' ) )
							),
							'enable-thumbnail-opacity-on-hover' => array(
								'title' => esc_html__('Thumbnail Opacity on Hover', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-metro', 'blog-metro-no-space','blog-widget') , 'show-thumbnail' => array( 'enable' ) )
							),
							'enable-thumbnail-zoom-on-hover' => array(
								'title' => esc_html__('Thumbnail Zoom on Hover', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-metro', 'blog-metro-no-space','blog-widget') , 'show-thumbnail' => array( 'enable' ) )
							),
							'enable-thumbnail-grayscale-effect' => array(
								'title' => esc_html__('Enable Thumbnail Grayscale Effect', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'disable',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-metro', 'blog-metro-no-space','blog-widget') , 'show-thumbnail' => array( 'enable' ) ),
								'description' => esc_html__('Only works with browser that supports css3 filter ( http://caniuse.com/#feat=css-filters ).', 'goodlayers-core')
							),
							'column-size' => array(
								'title' => esc_html__('Column Size', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
								'default' => 20,
								'condition' => array( 'blog-style' => array('blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space', 'blog-metro', 'blog-metro-no-space') )
							),
							'layout' => array(
								'title' => esc_html__('Layout', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array( 
									'fitrows' => esc_html__('Fit Rows', 'goodlayers-core'),
									'carousel' => esc_html__('Carousel', 'goodlayers-core'),
									'masonry' => esc_html__('Masonry', 'goodlayers-core'),
								),
								'default' => 'fitrows',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space') )
							),
							'carousel-autoslide' => array(
								'title' => esc_html__('Autoslide Carousel', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space'), 'layout' => 'carousel' )
							),
							'carousel-navigation' => array(
								'title' => esc_html__('Carousel Navigation', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'navigation' => esc_html__('Only Navigation', 'goodlayers-core'),
									'bullet' => esc_html__('Only Bullet', 'goodlayers-core'),
									'both' => esc_html__('Both Navigation and Bullet', 'goodlayers-core'),
								),
								'default' => 'navigation',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space'), 'layout' => 'carousel' )
							),
							'item-size' => array(
								'title' => esc_html__('Item Size', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array( 
									'small' => esc_html__('Small', 'goodlayers-core'),
									'large' => esc_html__('Large', 'goodlayers-core'),
								),
								'default' => 'small',
								'condition' => array( 'blog-style' => 'blog-widget' )
							),
							'excerpt' => array(
								'title' => esc_html__('Excerpt Type', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'specify-number' => esc_html__('Specify Number', 'goodlayers-core'),
									'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'goodlayers-core'),
								),
								'default' => 'specify-number',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space','blog-left-thumbnail', 'blog-right-thumbnail') )
							),
							'excerpt-number' => array(
								'title' => esc_html__('Excerpt Number', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 55,
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail'), 'excerpt' => 'specify-number' )
							),
							'blog-date-feature' => array(
								'title' => esc_html__('Enable Blog Date Feature', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail') )
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
								'default' => array('date', 'author', 'category')
							),
							'show-read-more' => array(
								'title' => esc_html__('Show Read More Button', 'goodlayers-core'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail'), )
							),
						),
					),	
					'typography' => array(
						'title' => esc_html('Typography', 'goodlayers-core'),
						'options' => array(
							'blog-title-font-size' => array(
								'title' => esc_html__('Blog Title Font Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'blog-title-font-weight' => array(
								'title' => esc_html__('Blog Title Font Weight', 'goodlayers-core'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'goodlayers-core')
							),
							'blog-title-letter-spacing' => array(
								'title' => esc_html__('Blog Title Letter Spacing', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'blog-title-text-transform' => array(
								'title' => esc_html__('Blog Title Text Transform', 'goodlayers-core'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'uppercase' => esc_html__('Uppercase', 'goodlayers-core'),
									'lowercase' => esc_html__('Lowercase', 'goodlayers-core'),
									'capitalize' => esc_html__('Capitalize', 'goodlayers-core'),
								),
								'default' => 'uppercase'
							),
						),
					),
					'Spacing' => array(
						'title' => esc_html('Spacing', 'goodlayers-core'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							),
						),
					),
					'item-title' => array(
						'title' => esc_html('Item Title', 'goodlayers-core'),
						'options' => gdlr_core_block_item_option()
					)
				));
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-blog-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-blog-<?php echo esc_attr($id); ?>').parent().gdlr_core_flexslider().gdlr_core_isotope().gdlr_core_content_script();
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
						'category' => '', 'tag' => '', 'num-fetch' => '9', 'prepend-sticky' => 'disable', 'thumbnail-size' => 'full', 'orderby' => 'date', 'order' => 'desc',
						'blog-style' => 'blog-full', 'excerpt' => 'specify-number', 'excerpt-number' => 55, 'show-read-more' => 'enable', 'column-size' => 20,
						'show-thumbnail' => 'enable',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				$settings['meta-option'] = empty($settings['meta-option'])? array(): $settings['meta-option'];
				if( !is_array($settings['meta-option']) ){
					$settings['meta-option'] = array_map('trim', explode(',', $settings['meta-option']));
				}
				$settings['blog-style'] = empty($settings['blog-style'])? 'blog-full': $settings['blog-style'];
				$settings['no-space'] = (strpos($settings['blog-style'], 'no-space') !== false)? 'yes': 'no';
				$settings['layout'] = empty($settings['layout'])? 'fitrows': $settings['layout'];
				if( in_array($settings['blog-style'], array('blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space')) ){
					$settings['has-column'] = 'yes';
				}else if( in_array($settings['blog-style'], array('blog-metro', 'blog-metro-no-space')) ){
					$settings['has-column'] = 'yes';
					$settings['layout'] = 'masonry';
				}else{
					$settings['has-column'] = 'no';
					$settings['column-size'] = 60;
					if( $settings['layout'] == 'masonry' ){
						$settings['layout'] = 'fitrows';
					}else if( $settings['layout'] == 'carousel' ){
						if( !in_array($settings['blog-style'], array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail')) ){
							$settings['layout'] = 'fitrows';
						}
					}
				}

				// start printing item
				$extra_class = ' gdlr-core-style-' . $settings['blog-style'];
				$title_settings = $settings;
				if( $settings['no-space'] == 'yes' || $settings['layout'] == 'carousel' ){
					$title_settings['pdlr'] = false;
					$extra_class .= ' gdlr-core-item-pdlr';
				}
				if( $settings['layout'] == 'carousel' ){
					if( empty($settings['carousel-navigation']) || in_array($settings['carousel-navigation'], array('navigation', 'both')) ){
						$title_settings['carousel'] = 'enable';
					}
				}
				$extra_class .= empty($settings['class'])? '': ' ' . $settings['class'];

				$ret  = '<div class="gdlr-core-blog-item gdlr-core-item-pdb clearfix ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				// print title
				$ret .= gdlr_core_block_item_title($title_settings);
				
				// pring blog item
				$blog_item = new gdlr_core_blog_item($settings);

				$ret .= $blog_item->get_content();
				
				$ret .= '</div>'; // gdlr-core-blog-item
				
				return $ret;
			}			
			
		} // gdlr_core_pb_element_blog
	} // class_exists	

	add_shortcode('gdlr_core_blog', 'gdlr_core_blog_shortcode');
	if( !function_exists('gdlr_core_blog_shortcode') ){
		function gdlr_core_blog_shortcode($atts){
			$atts = wp_parse_args($atts, array(
				
			));

			$ret  = '<div class="gdlr-core-blog-shortcode clearfix gdlr-core-item-rvpdlr" >';
			$ret .= gdlr_core_pb_element_blog::get_content($atts);
			$ret .= '</div>';

			return $ret;
		}
	}