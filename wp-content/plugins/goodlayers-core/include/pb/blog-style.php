<?php
	/*	
	*	Goodlayers Blog Item Style
	*/
	
	if( !class_exists('gdlr_core_blog_style') ){
		class gdlr_core_blog_style{

			private $blog_info_prefix = array();

			function __construct(){

				$this->blog_info_prefix = apply_filters('gdlr_core_blog_info_prefix', array(
					'date' => '<i class="icon_clock_alt" ></i>',
					'tag' => '<i class="icon_tags_alt" ></i>',
					'category' => '<i class="icon_folder-alt" ></i>',
					'comment' => '<i class="icon_comment_alt" ></i>',
					'like' => '<i class="icon_heart_alt" ></i>',
					'author' => '<i class="icon_documents_alt" ></i>',
					'comment-number' => '<i class="icon_comment_alt" ></i>',
				));

			}

			// get the content of the blog item
			function get_content( $args ){

				$ret = apply_filters('gdlr_core_blog_style_content', '', $args, $this);
				if( !empty($ret) ) return $ret;

				switch( $args['blog-style'] ){
					case 'blog-full': 
					case 'blog-full-with-frame': 
						return $this->blog_full( $args ); 
						break;
					case 'blog-column': 
					case 'blog-column-no-space': 
					case 'blog-column-with-frame': 
						return $this->blog_grid( $args );
						break;
					case 'blog-image':
					case 'blog-image-no-space': 
						return $this->blog_modern( $args ); 
						break;	
					case 'blog-metro':
					case 'blog-metro-no-space': 
						return $this->blog_metro( $args ); 
						break;	
					case 'blog-left-thumbnail': 
					case 'blog-right-thumbnail':
						return $this->blog_medium( $args ); 
						break;
					case 'blog-widget': 
						return $this->blog_widget( $args ); 
						break;
					case 'blog-list': 
					case 'blog-list-center': 
						return $this->blog_list( $args ); 
						break;
				}
				
			}
			
			// get blog excerpt from $args
			function get_blog_excerpt( $args ){

				$ret = '';

				if( $args['excerpt'] == 'specify-number' ){
					if( !empty($args['excerpt-number']) ){
						$ret .= '<div class="gdlr-core-blog-content" >';
						$ret .= $this->blog_excerpt($args['excerpt-number']);
						if( !empty($args['show-read-more']) && $args['show-read-more'] == 'enable' ){
							$ret .= '<div class="clear"></div>';

							$blog_read_more = apply_filters('gdlr_core_blog_read_more', '');
							if( empty($blog_read_more) ){
								$blog_read_more  = '<a class="gdlr-core-excerpt-read-more gdlr-core-button gdlr-core-rectangle" href="' . get_permalink() . '" >';
								$blog_read_more .= esc_html__('Read More', 'goodlayers-core');
								$blog_read_more .= '</a>';
							}

							$ret .= $blog_read_more;
						}
						$ret .= '</div>';
					}
				}else if( $args['excerpt'] != 'none' ){
					$ret .= '<div class="gdlr-core-blog-content" >' . gdlr_core_content_filter(get_the_content(), true) . '</div>';
				}

				return $ret;
			}

			// get blog excerpt
			function blog_excerpt( $excerpt_length ) {
				
				$post = get_post();

				if( empty($post) || post_password_required() ){ return ''; }
			
				$excerpt = $post->post_excerpt;
				if( empty($excerpt) ){
					$excerpt = get_the_content('');
					$excerpt = strip_shortcodes($excerpt);
					
					$excerpt = apply_filters('the_content', $excerpt);
					$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
				}
				
				$excerpt_more = apply_filters('excerpt_more', '...');
				$excerpt = wp_trim_words($excerpt, $excerpt_length, $excerpt_more);
				
				$excerpt = apply_filters('wp_trim_excerpt', $excerpt, $post->post_excerpt);		
				$excerpt = apply_filters('get_the_excerpt', $excerpt);
				
				return $excerpt;
			}			
			
			// get blog thumbnail
			function blog_thumbnail( $args = array() ){

				$ret = '';


				if( !empty($args['post-format']) ){
					global $pages;

					// strip the media based on post format
					if( $args['post-format'] == 'video' ){
						if( !preg_match('#^https?://\S+#', $pages[0], $match) ){
							if( !preg_match('#^\[video\s.+\[/video\]#', $pages[0], $match) ){
								preg_match('#^\[embed.+\[/embed\]#', $pages[0], $match);
							}
						}

						if( !empty($match[0]) ){
							if( isset($args['post-format-thumbnail']) && $args['post-format-thumbnail'] === false ){
								$thumbnail_size = 'full';
							}else{
								$thumbnail_size = $args['thumbnail-size'];
							}

							$ret .= '<div class="gdlr-core-blog-thumbnail gdlr-core-media-video" >';
							$ret .= gdlr_core_get_video($match[0], $thumbnail_size);
							$ret .= '</div>';

							$pages[0] = substr($pages[0], strlen($match[0]));
						}
					}else if( $args['post-format'] == 'audio' ){

						if( !preg_match('#^https?://\S+#', $pages[0], $match) ){
							preg_match('#^\[audio\s.+\[/audio\]#', $pages[0], $match);
						}

						if( !empty($match[0]) ){
							$ret .= '<div class="gdlr-core-blog-thumbnail gdlr-core-media-audio" >';
							$ret .= gdlr_core_get_audio($match[0]);
							$ret .= '</div>';

							$pages[0] = substr($pages[0], strlen($match[0]));
						}

					}else if( $args['post-format'] == 'image' ){

						if( preg_match('#^<a.+<img.+/></a>|^<img.+/>#', $pages[0], $match) ){ 
							$post_format_image = $match[0];
						}else if( preg_match('#^https?://\S+#', $pages[0], $match) ){
							$post_format_image = gdlr_core_get_image($match[0]);
						}

						if( !empty($post_format_image) ){
							$thumbnail_wrap_class  = '';
							if( empty($args['opacity-on-hover']) || $args['opacity-on-hover'] == 'enable' ){
								$thumbnail_wrap_class .= ' gdlr-core-opacity-on-hover';
							}
							if( empty($args['zoom-on-hover']) || $args['zoom-on-hover'] == 'enable' ){
								$thumbnail_wrap_class .= ' gdlr-core-zoom-on-hover';
							}
							if( !empty($args['grayscale-effect']) && $args['grayscale-effect'] == 'enable' ){
								$thumbnail_wrap_class .= ' gdlr-core-grayscale-effect';
							}
							
							$ret .= '<div class="gdlr-core-blog-thumbnail gdlr-core-media-image ' . esc_attr($thumbnail_wrap_class) . '" >';
							$ret .= $post_format_image;
							$ret .= '</div>';

							$pages[0] = substr($pages[0], strlen($match[0]));
						}

					}else if( $args['post-format'] == 'gallery' ){
						if( preg_match('#^\[gallery[^\]]+]#', $pages[0], $match) ){ 
							$pages[0] = substr($pages[0], strlen($match[0]));
							$ret .= '<div class="gdlr-core-blog-thumbnail gdlr-core-media-gallery" >';

							// convert the gallery to slider
							if( !empty($args['post-format-gallery']) && $args['post-format-gallery'] == 'slider' ){
								if( preg_match('#^\[gallery.+ids\s?=\s?\"([^\"]+).+]#', $match[0], $match2) ){
									
									$gallery_atts = array(
										'gallery'=>array(),
										'thumbnail-size'=>$args['thumbnail-size'],
										'style'=>'slider',
										'padding-bottom' => '0px',
										'no-pdlr' => true
									);
									$gallery_ids = explode(',', $match2[1]);
									foreach( $gallery_ids as $gallery_id ){
										$gallery_atts['gallery'][] = array( 'id' => $gallery_id );
									}
									$ret .= gdlr_core_pb_element_gallery::get_content($gallery_atts);

								}

							// display gallery as it is
							}else{
								$ret .= do_shortcode($match[0]);
							}
							$ret .= '</div>';
						}
					}

				}else{

					$feature_image = get_post_thumbnail_id();

					if( !empty($feature_image) ){
						$thumbnail_wrap_class  = '';
						if( empty($args['opacity-on-hover']) || $args['opacity-on-hover'] == 'enable' ){
							$thumbnail_wrap_class .= ' gdlr-core-opacity-on-hover';
						}
						if( empty($args['zoom-on-hover']) || $args['zoom-on-hover'] == 'enable' ){
							$thumbnail_wrap_class .= ' gdlr-core-zoom-on-hover';
						}
						if( !empty($args['grayscale-effect']) && $args['grayscale-effect'] == 'enable' ){
							$thumbnail_wrap_class .= ' gdlr-core-grayscale-effect';
						}
							
						$ret .= '<div class="gdlr-core-blog-thumbnail gdlr-core-media-image ' . esc_attr($thumbnail_wrap_class) . '" ><a href="' . get_permalink() . '" >';
						$ret .= gdlr_core_get_image($feature_image, $args['thumbnail-size'], array('placeholder' => false));
						if( is_sticky() ){	
							$ret .= '<div class="gdlr-core-sticky-banner gdlr-core-title-font" ><i class="fa fa-bolt" ></i>' . esc_html__('Sticky Post', 'goodlayers-core') . '</div>';
						}
						$ret .= '</a></div>';
					}else{
						if( is_sticky() ){
							$ret .= '<div class="gdlr-core-sticky-banner gdlr-core-title-font" ><i class="fa fa-bolt" ></i>' . esc_html__('Sticky Post', 'goodlayers-core') . '</div>';
						}
					}
				}
				
				return $ret;
			}
			
			// get the blog date
			function blog_date( $args, $order = array('d', 'M') ){

				if( !empty($args['blog-date-feature']) && $args['blog-date-feature'] == 'disable' ) return;
				
				$ret  = '<div class="gdlr-core-blog-date-wrapper gdlr-core-skin-divider">';
				foreach( $order as $date ){
					switch( $date ){
						case 'd':
							$ret .= '<div class="gdlr-core-blog-date-day gdlr-core-skin-caption">' .  get_the_time('d') . '</div>';
							break;
						case 'M': 
							$ret .= '<div class="gdlr-core-blog-date-month gdlr-core-skin-caption">' . get_the_time('M') . '</div>';
							break;
						case 'Y': 
							$ret .= '<div class="gdlr-core-blog-date-year gdlr-core-skin-caption">' .  get_the_time('Y') . '</div>';
							break;
					}
				}
				$ret .= '</div>';
				
				return $ret;
			}
			
			// get the blog info
			function blog_info( $args ){
				
				$ret = '';
				
				if( !empty($args['display']) ){
					foreach( $args['display'] as $blog_info ){
						
						$ret_temp = '';
						
						switch( $blog_info ){
							case 'date':
								$ret_temp .= '<a href="' . get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '">';
								$ret_temp .= get_the_date();
								$ret_temp .= '</a>';
								break;
								
							case 'tag':
								$ret_temp .= get_the_term_list(get_the_ID(), 'post_tag', '', '<span class="gdlr-core-sep">,</span> ' , '');							
								break;
								
							case 'category':
								$ret_temp .= get_the_term_list(get_the_ID(), 'category', '', '<span class="gdlr-core-sep">,</span> ' , '' );;					
								break;
								
							case 'comment-number':
								if( (!isset($args['icon']) || $args['icon'] !== false) && !empty($this->blog_info_prefix[$blog_info]) ){
									$ret_temp .= '<a href="' . get_permalink() . '#respond" >';
									$ret_temp .= get_comments_number() . ' ';
									$ret_temp .= '</a>';
									break;
								}
							
							case 'comment':
								ob_start();
								comments_number(
									esc_html__('no comments', 'goodlayers-core'), 
									esc_html__('one comment', 'goodlayers-core'), 
									esc_html__('% comments', 'goodlayers-core') 
								);
								$ret_temp .= '<a href="' . get_permalink() . '#respond" >';
								$ret_temp .= ob_get_contents();
								$ret_temp .= '</a>';
								ob_end_clean();								
								break;
								
							case 'author':

								ob_start();
								the_author_posts_link();
								$ret_temp .= ob_get_contents();
								ob_end_clean();					
								break;
						} // switch
						
						if( !empty($ret_temp) ){
							
							$ret .= '<span class="gdlr-core-blog-info gdlr-core-blog-info-font gdlr-core-skin-caption gdlr-core-blog-info-' . esc_attr($blog_info) . '">';
							if( !empty($args['separator']) ){
								$ret .= '<span class="gdlr-core-blog-info-sep" >' . $args['separator'] . '</span>';
							}
							if( (!isset($args['icon']) || $args['icon'] !== false) && !empty($this->blog_info_prefix[$blog_info]) ){
								$ret .= '<span class="gdlr-core-head" >' . $this->blog_info_prefix[$blog_info] . '</span>';
							}
							$ret .= $ret_temp;
							$ret .= '</span>';
						}
						
					} // foreach
				} // $args['display']
				
				if( !empty($ret) && !empty($args['wrapper']) ){
					$ret = '<div class="gdlr-core-blog-info-wrapper gdlr-core-skin-divider" >' . $ret . '</div>';
				}
				
				return $ret;
			}

			// blog title
			function blog_title( $args, $permalink = '' ){

				$ret  = '<h3 class="gdlr-core-blog-title gdlr-core-skin-title" ' . gdlr_core_esc_style(array(
					'font-size' => empty($args['blog-title-font-size'])? '': $args['blog-title-font-size'],
					'font-weight' => empty($args['blog-title-font-weight'])? '': $args['blog-title-font-weight'],
					'letter-spacing' => empty($args['blog-title-letter-spacing'])? '': $args['blog-title-letter-spacing'],
					'text-transform' => (empty($args['blog-title-text-transform']) || $args['blog-title-text-transform'] == 'none')? '': $args['blog-title-text-transform']
				)) . ' >';
				if( empty($permalink) ){
					$ret .= '<a href="' . get_permalink() . '" >';
				}else{
					$ret .= '<a href="' . esc_attr($permalink) . '" target="_blank" >';
				}
				$ret .= get_the_title();
				$ret .= '</a>';
				$ret .= '</h3>';

				return  $ret;
			}

			// blog aside
			function blog_format( $args, $post_format ){

				$extra_class  = empty($args['extra-class'])? '': $args['extra-class'];
				$extra_class .= (strpos($args['blog-style'], 'blog-column') === false)? ' gdlr-core-item-list': '';

				$ret  = '<div class="gdlr-core-blog-' . esc_attr($post_format) . '-format ' . esc_attr($extra_class) . '" >';
				if( $post_format == 'aside' ){

					$ret .= $this->get_blog_excerpt($args);

				}else if( $post_format == 'quote' ){

					global $pages;

					if( !preg_match('#^\[gdlr_core_quote[\s\S]+\[/gdlr_core_quote\]#', $pages[0], $match) ){ 
						preg_match('#^<blockquote[\s\S]+</blockquote>#', $pages[0], $match);
					}

					if( !empty($match[0]) ){
						$blockquote = $match[0];
						$author = substr($pages[0], strlen($match[0]));
					}else{
						$blockquote = '';
						$author = $pages[0];
					}

					$ret .= '<div class="gdlr-core-blog-content" >';
					$thumbnail_id = get_post_thumbnail_id();
					if( !empty($thumbnail_id) ){
						$quote_background = gdlr_core_get_image_url(get_post_thumbnail_id());
						$ret .= '<div class="gdlr-core-blog-quote-background" ' . gdlr_core_esc_style(array(
							'background-image' => $quote_background
						)) . ' ></div>';
					}

					$ret .= '<div class="gdlr-core-blog-quote gdlr-core-quote-font" >&#8220;</div>';
					
					$ret .= '<div class="gdlr-core-blog-content-wrap" >';
					if( !empty($blockquote) ){
						$ret .= '<div class="gdlr-core-blog-quote-content gdlr-core-info-font">' . gdlr_core_content_filter($blockquote, true) . '</div>';
					}
					if( !empty($author) ){
						$ret .= '<div class="gdlr-core-blog-quote-author gdlr-core-info-font" >' . gdlr_core_text_filter($author) . '</div>';
					}
					$ret .= '</div>';
					$ret .= '</div>';

				}else if( $post_format == 'link' ){

					global $pages;

					if( preg_match('#^<a.+href=[\'"]([^\'"]+).+</a>#', $pages[0], $match) ){ 
						$post_format_link = $match[1];
						$pages[0] = substr($pages[0], strlen($match[0]));
					}else if( preg_match('#^https?://\S+#', $pages[0], $match) ){
						$post_format_link = $match[0];
						$pages[0] = substr($pages[0], strlen($match[0]));
					}else{
						$post_format_link = get_permalink();
					}

					$ret .= '<div class="gdlr-core-blog-content-outer-wrap" >';
					$ret .= '<a class="gdlr-core-blog-icon-link" href="' . esc_url($post_format_link) . '" target="_blank" ><i class="icon_link" ></i></a>';

					$ret .= '<div class="gdlr-core-blog-content-wrap" >';
					$ret .= $this->blog_title( $args, $post_format_link );
					$ret .= $this->get_blog_excerpt( $args );
					$ret .= '</div>';
					$ret .= '</div>';

				}
				$ret .= '</div>';

				return $ret;
			}
			
			// blog full
			function blog_full( $args ){
				
				$post_format = get_post_format();
				if( in_array($post_format, array('aside', 'quote', 'link')) ){
					$args['extra-class']  = ' gdlr-core-blog-full gdlr-core-large';
					$args['extra-class'] .= (!empty($args['layout']) && $args['layout'] == 'carousel')? '': ' gdlr-core-item-pdlr';

					return $this->blog_format( $args, $post_format );
				}

				$additional_class  = (!empty($args['layout']) && $args['layout'] == 'carousel')? '': ' gdlr-core-item-pdlr';
				$additional_class .= (!empty($args['blog-full-alignment']))? ' gdlr-core-style-' . $args['blog-full-alignment']: '';

				$ret  = '<div class="gdlr-core-item-list gdlr-core-blog-full ' . esc_attr($additional_class) . '" >';
				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $this->blog_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size'],
						'post-format' => $post_format,
						'post-format-thumbnail' => false,
						'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
						'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
						'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
					)); 
				}
				
				$ret .= ($args['blog-style'] == 'blog-full-with-frame')? '<div class="gdlr-core-blog-full-frame gdlr-core-skin-e-background">': '';
				$ret .= '<div class="gdlr-core-blog-full-head clearfix">';
				$ret .= $this->blog_date($args);
				
				$ret .= '<div class="gdlr-core-blog-full-head-right">';
				$ret .= $this->blog_title( $args );
				$ret .= $this->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true
				));
				$ret .= '</div>'; // gdlr-core-blog-full-head-right
				$ret .= '</div>'; // gdlr-core-blog-full-head
				
				$ret .= $this->get_blog_excerpt($args);
				
				$ret .= ($args['blog-style'] == 'blog-full-with-frame')? '</div>': '';
				$ret .= '</div>'; // gdlr-core-blog-full
				
				return $ret;
			}
			
			// blog medium
			function blog_medium( $args ){
				
				$post_format = get_post_format();
				if( in_array($post_format, array('aside', 'quote', 'link')) ){
					$args['extra-class']  = ' gdlr-core-blog-medium gdlr-core-large';
					$args['extra-class'] .= (!empty($args['layout']) && $args['layout'] == 'carousel')? '': ' gdlr-core-item-pdlr';
					return $this->blog_format( $args, $post_format );
				}

				$additional_class  = empty($args['blog-style'])? '': 'gdlr-core-' . $args['blog-style'];
				$additional_class .= (!empty($args['layout']) && $args['layout'] == 'carousel')? '': ' gdlr-core-item-pdlr';
				
				$ret  = '<div class="gdlr-core-item-list gdlr-core-blog-medium clearfix ' . esc_attr($additional_class) . '" >';
				$ret .= '<div class="gdlr-core-blog-thumbnail-wrap clearfix" >';
				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $this->blog_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size'],
						'post-format' => ($post_format == 'audio')? '': $post_format,
						'post-format-gallery' => 'slider',
						'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
						'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
						'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
					
					));
				}
				$ret .= $this->blog_date($args);
				$ret .= '</div>';

				$ret .= '<div class="gdlr-core-blog-medium-content-wrapper clearfix">';
				if( $post_format == 'audio' ){
					$ret .= $this->blog_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size'],
						'post-format' => 'audio',
						'post-format-gallery' => 'slider',
						'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
						'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
						'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
					));
				}
				$ret .= $this->blog_title( $args );

				$ret .= $this->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true
				));
				
				$ret .= $this->get_blog_excerpt($args);
				
				$ret .= '</div>'; // gdlr-core-blog-medium-content-wrapper
				$ret .= '</div>'; // gdlr-core-blog-medium
				
				return $ret;
			} 
			
			// blog column
			function blog_grid( $args ){

				$post_format = get_post_format();
				if( in_array($post_format, array('aside', 'quote', 'link')) ){
					$args['extra-class']  = ' gdlr-core-blog-grid gdlr-core-small';
					
					return $this->blog_format( $args, $post_format );
				}

				$additional_class  = ($args['blog-style'] == 'blog-column-with-frame')? ' gdlr-core-blog-grid-with-frame gdlr-core-item-mgb': '';

				$ret  = '<div class="gdlr-core-blog-grid ' . esc_attr($additional_class) . '" >';
				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $this->blog_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size'],
						'post-format' => $post_format,
						'post-format-gallery' => 'slider',
						'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
						'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
						'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
					));
				}
				
				if( $args['blog-style'] == 'blog-column-with-frame' ){
					$ret .= '<div class="gdlr-core-blog-grid-frame gdlr-core-skin-e-background gdlr-core-js" data-sync-height="blog-grid-with-frame" >';
				}else{
					$ret .= '<div class="gdlr-core-blog-grid-content-wrap">';
				}
				if( ($key = array_search('date', $args['meta-option'])) !== false ) {
					$ret .= '<div class="gdlr-core-blog-grid-date" >';
					$ret .= $this->blog_info(array('display' => array('date')));
					$ret .= '</div>';

					unset($args['meta-option'][$key]);
				}
				
				$ret .= $this->blog_title($args);
				$ret .= $this->get_blog_excerpt($args);
				
				$ret .= '<div class="gdlr-core-blog-info-wrapper gdlr-core-skin-divider" data-sync-height-offset >';
				$ret .= $this->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => false
				));
				$ret .= '</div>';
				$ret .= '</div>'; // gdlr-core-blog-grid-content-wrap
				$ret .= '</div>'; // gdlr-core-blog-grid
				
				return $ret;
			} 		

			// blog modern
			function blog_modern( $args ){
				
				$feature_image = get_post_thumbnail_id();
				$additional_class  = empty($feature_image)? ' gdlr-core-no-image': ' gdlr-core-with-image';
				$content_overlay = '';
				if( empty($args['always-show-overlay-content']) || $args['always-show-overlay-content'] == 'disable' ){
					$additional_class .= ' gdlr-core-hover-overlay-content';
				}else{
					$content_overlay = '<div class="gdlr-core-blog-modern-content-overlay" ></div>';
				}
				if( empty($args['enable-thumbnail-opacity-on-hover']) || $args['enable-thumbnail-opacity-on-hover'] == 'enable' ){
					$additional_class .= ' gdlr-core-opacity-on-hover';
				}
				if( empty($args['enable-thumbnail-zoom-on-hover']) || $args['enable-thumbnail-zoom-on-hover'] == 'enable' ){
					$additional_class .= ' gdlr-core-zoom-on-hover';
				}
				if( !empty($args['enable-thumbnail-grayscale-effect']) && $args['enable-thumbnail-grayscale-effect'] == 'enable' ){
					$additional_class .= ' gdlr-core-grayscale-effect';
				}
				
				$ret  = '<div class="gdlr-core-blog-modern ' . esc_attr($additional_class) . '" >';
				$ret .= '<div class="gdlr-core-blog-modern-inner">';

				if( !empty($feature_image) ){
					$ret .= '<div class="gdlr-core-blog-thumbnail gdlr-core-media-image" >';
					$ret .= gdlr_core_get_image($feature_image, $args['thumbnail-size'], array('placeholder' => false));
					$ret .= '</div>';
				}
				
				$ret .= $content_overlay;
				$ret .= '<div class="gdlr-core-blog-modern-content">';
				$ret .= $this->blog_title($args);
				$ret .= $this->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true
				));
				$ret .= '</div>'; // gdlr-core-blog-modern-content
				$ret .= '</div>'; // gdlr-core-blog-modern-inner
				$ret .= '</div>'; // gdlr-core-blog-modern
				
				return $ret;
			} 			

			// blog metro
			function blog_metro( $args ){
				
				$feature_image = get_post_thumbnail_id();
				$additional_class  = empty($feature_image)? ' gdlr-core-no-image': ' gdlr-core-with-image';
				if( empty($args['enable-thumbnail-opacity-on-hover']) || $args['enable-thumbnail-opacity-on-hover'] == 'enable' ){
					$additional_class .= ' gdlr-core-opacity-on-hover';
				}
				if( empty($args['enable-thumbnail-zoom-on-hover']) || $args['enable-thumbnail-zoom-on-hover'] == 'enable' ){
					$additional_class .= ' gdlr-core-zoom-on-hover';
				}
				if( !empty($args['enable-thumbnail-grayscale-effect']) && $args['enable-thumbnail-grayscale-effect'] == 'enable' ){
					$additional_class .= ' gdlr-core-grayscale-effect';
				}
					
				$ret  = '<div class="gdlr-core-blog-metro ' . esc_attr($additional_class) . '" >';
				$ret .= '<div class="gdlr-core-blog-metro-inner ' .  (($args['blog-style'] == 'blog-metro')? ' gdlr-core-metro-rvpdlr': '') . '" >';

				if( !empty($feature_image) ){
					$ret .= '<div class="gdlr-core-blog-thumbnail gdlr-core-media-image" >';
					$ret .= gdlr_core_get_image($feature_image, $args['thumbnail-size'], array('placeholder' => false));
					$ret .= '</div>';
				}
				
				$ret .= '<div class="gdlr-core-blog-metro-content">';
				$ret .= $this->blog_title($args);
				$ret .= $this->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true
				));
				$ret .= '</div>'; // gdlr-core-blog-metro-content
				$ret .= '</div>'; // gdlr-core-blog-metro-inner
				$ret .= '</div>'; // gdlr-core-blog-metro
				
				return $ret;
			} 			

			// blog list
			function blog_widget( $args ){

				$additional_class  = empty($args['text-align'])? '': ' gdlr-core-' . $args['text-align'] . '-align';
				$additional_class .= empty($args['item-size'])? '': 'gdlr-core-style-' . $args['item-size']; 

				$ret  = '<div class="gdlr-core-item-list gdlr-core-blog-widget gdlr-core-item-mglr clearfix ' . esc_attr($additional_class) . '" >';
				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $this->blog_thumbnail(array(
						'thumbnail-size' => 'thumbnail',
						'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
						'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
						'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
					));
				}

				$ret .= '<div class="gdlr-core-blog-widget-content" >';
				$ret .= $this->blog_title($args);
				$ret .= $this->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true
				));
				$ret .= '</div>'; // gdlr-core-blog-widget-content
				$ret .= '</div>'; // gdlr-core-blog-widget
				
				return $ret;
			} 			

			// blog list
			function blog_list( $args ){

				$with_frame = ( !empty($args['blog-list-with-frame']) && $args['blog-list-with-frame'] == 'enable' );
				$additional_class = ($args['blog-style'] == 'blog-list-center')? ' gdlr-core-center-align': '';
				$additional_class = ($with_frame)? ' gdlr-core-blog-list-with-frame': '';
				
				$ret  = '<div class="gdlr-core-item-list gdlr-core-blog-list gdlr-core-item-pdlr ' . esc_attr($additional_class) . '" >';
				$ret .= $with_frame? '<div class="gdlr-core-blog-list-frame gdlr-core-skin-e-background">': '';
				$ret .= $this->blog_title($args);
				$ret .= $this->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true,
					'icon' => false,
					'separator' => '/'
				));
				$ret .= $with_frame? '</div>': '';
				$ret .= '</div>'; // gdlr-core-blog-list
				
				return $ret;
			} 				
			
		} // gdlr_core_blog_item
	} // class_exists
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	