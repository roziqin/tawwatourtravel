<?php
	/*	
	*	Goodlayers Blog Item Style
	*/
	
	if( !class_exists('gdlr_core_portfolio_style') ){
		class gdlr_core_portfolio_style{

			private $portfolio_medium_count = 0;

			// get portfolio icon class
			function portfolio_icon_class( $icon_type = 'image' ){

				$icon_class = apply_filters('gdlr_core_portfolio_hover_icon_class', $icon_type);
				if( !empty($icon_class) ) return $icon_class;

				$icon_class = array(
					'image' => 'icon_zoom-in_alt',
					'link' => 'icon_link_alt',
					'video' => 'icon_film'
				);
				return $icon_class[$icon_type];

			}

			// get the content of the blog item
			function get_content( $args ){

				$ret = apply_filters('gdlr_core_portfolio_style_content', '', $args, $this);
				if( !empty($ret) ) return $ret;

				switch( $args['portfolio-style'] ){
					case 'modern':
					case 'modern-no-space': 
						return $this->portfolio_modern( $args ); 
						break;
					case 'modern-desc':
					case 'modern-desc-no-space': 
						return $this->portfolio_modern_desc( $args ); 
						break;
					case 'metro':
					case 'metro-no-space': 
						return $this->portfolio_metro( $args ); 
						break;
					case 'grid':
					case 'grid-no-space': 
						return $this->portfolio_grid( $args ); 
						break;	
					case 'medium': 
						return $this->portfolio_medium( $args ); 
						break;
				}
				
			}

			// get blog excerpt
			function get_excerpt( $excerpt_length, $excerpt_more = ' [&hellip;]' ) {

				$post = get_post();
				if( empty($post) || post_password_required() ){ return ''; }
			
				$excerpt = $post->post_excerpt;
				if( empty($excerpt) ){
					$excerpt = get_the_content('');
					$excerpt = strip_shortcodes($excerpt);
					
					$excerpt = apply_filters('the_content', $excerpt);
					$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
				}
				
				$excerpt_more = apply_filters('excerpt_more', $excerpt_more);
				$excerpt = wp_trim_words($excerpt, $excerpt_length, $excerpt_more);

				$excerpt = apply_filters('wp_trim_excerpt', $excerpt, $post->post_excerpt);		
				$excerpt = apply_filters('get_the_excerpt', $excerpt);
				
				return $excerpt;
			}

			// get the portfolio title
			function portfolio_title( $args ){
				if( !empty($args['lightbox-group']) ){
					$args['lightbox-group'] .= 't';
				}

				$portfolio_info = get_post_meta(get_the_ID(), 'gdlr-core-page-option', true);
				if( !empty($portfolio_info) && $portfolio_info['thumbnail-type'] == 'feature-image' && $portfolio_info['title-link-to'] == 'icon' ){
					$link_attr = $this->get_thumbnail_link( $portfolio_info, $args );
					$link_tag = $link_attr['link-tag'];
				}else{
					$link_tag = '<a href="' . get_permalink() . '" >';
				}

				$ret  = '<h3 class="gdlr-core-portfolio-title gdlr-core-skin-title" ' . gdlr_core_esc_style(array(
					'margin-bottom' => empty($args['portfolio-title-bottom-margin'])? '': $args['portfolio-title-bottom-margin'],
					'font-size' => empty($args['portfolio-title-font-size'])? '': $args['portfolio-title-font-size'],
					'font-weight' => empty($args['portfolio-title-font-weight'])? '': $args['portfolio-title-font-weight'],
					'letter-spacing' => empty($args['portfolio-title-letter-spacing'])? '': $args['portfolio-title-letter-spacing'],
					'text-transform' => (empty($args['portfolio-title-text-transform']) || $args['portfolio-title-text-transform'] == 'uppercase')? '': $args['portfolio-title-text-transform']
				)) . ' >';
				$ret .= $link_tag . get_the_title() . '</a>';
				$ret .= '</h3>';


				return $ret;
			}

			// get portfolio 
			function portfolio_badge( $portfolio_info ){

				$ret = '';
				if( (empty($portfolio_info['enable-badge']) || $portfolio_info['enable-badge'] == 'enable') && !empty($portfolio_info['badge-text']) ){
					$ret .= '<div class="gdlr-core-portfolio-badge gdlr-core-outer-frame-element" ' . gdlr_core_esc_style(array(
						'color' => empty($portfolio_info['badge-text-color'])? '': $portfolio_info['badge-text-color'],
						'background-color' => empty($portfolio_info['badge-background-color'])? '': $portfolio_info['badge-background-color']
					)) . ' >';
					$ret .= gdlr_core_text_filter($portfolio_info['badge-text']);
					$ret .= '</div>';
				}
				return $ret;

			}

			// get portfolio thumbnail icon link
			function get_thumbnail_link( $portfolio_info, $args ){

				$icon_type = 'image';
				$link_tag = '<a ';
				if( empty($portfolio_info['hover-icon-link-to']) || $portfolio_info['hover-icon-link-to'] == 'lb-full-image' ){
					$feature_image = get_post_thumbnail_id();
					if( !empty($feature_image) ){
						$link_tag .= gdlr_core_get_lightbox_atts(array( 
							'url' => gdlr_core_get_image_url($feature_image),
							'caption' => gdlr_core_get_image_info($feature_image, 'caption'),
							'group' => empty($args['lightbox-group'])? '': $args['lightbox-group'],
						));
					}
				}else if( $portfolio_info['hover-icon-link-to'] == 'lb-custom-image' ){
					if( is_numeric($portfolio_info['hover-icon-custom-image']) ){
						$lb_image_url = gdlr_core_get_image_url($portfolio_info['hover-icon-custom-image']);
						$lb_image_caption = gdlr_core_get_image_info($portfolio_info['hover-icon-custom-image'], 'caption');
					}else{
						$lb_image_url = $portfolio_info['hover-icon-custom-image'];
						$lb_image_caption = '';
					}

					$link_tag .= gdlr_core_get_lightbox_atts(array( 
						'url' => $lb_image_url,
						'caption' => $lb_image_caption,
						'group' => empty($args['lightbox-group'])? '': $args['lightbox-group'],
					));
				}else if( $portfolio_info['hover-icon-link-to'] == 'lb-video' ){
					$icon_type = 'video';
					$link_tag .= gdlr_core_get_lightbox_atts(array( 
						'type' => 'video',
						'group' => empty($args['lightbox-group'])? '': $args['lightbox-group'],
						'url' => empty($portfolio_info['hover-icon-video-url'])? '': $portfolio_info['hover-icon-video-url'],
					));
				}else if( $portfolio_info['hover-icon-link-to'] == 'custom-url' ){
					$icon_type = 'link';
					$link_tag .= empty($portfolio_info['hover-icon-custom-url'])? '': 'href="' . esc_url($portfolio_info['hover-icon-custom-url']) . '" ';
					$link_tag .= empty($portfolio_info['hover-icon-custom-link-target'])? '': 'target="' . esc_attr($portfolio_info['hover-icon-custom-link-target']) . '" ';
				}else if( $portfolio_info['hover-icon-link-to'] == 'portfolio' ){
					$icon_type = 'link';
					$link_tag .= 'href="' . get_permalink() . '" ';
				}
				$link_tag .= '>';

				return array(
					'link-tag' => $link_tag,
					'icon-type' => $icon_type
				);
			}

			// get the portfolio thumbnail
			function get_thumbnail( $args, $has_content = true ){
				
				$ret = '';
				
				$thumbnail_size = empty($args['thumbnail-size'])? 'full': $args['thumbnail-size'];
				$portfolio_info = get_post_meta(get_the_ID(), 'gdlr-core-page-option', true);

				// image thumbnail
				if( empty($portfolio_info['thumbnail-type']) || $portfolio_info['thumbnail-type'] == 'feature-image' || !empty($args['only-image']) ){
					$feature_image = get_post_thumbnail_id();
					
					$overlay_class  = ' gdlr-core-portfolio-overlay';
					$overlay_class .= in_array($args['portfolio-style'], array('modern-desc', 'modern-desc-no-space'))? ' gdlr-core-image-overlay-center gdlr-core-js': ' gdlr-core-image-overlay-center-icon gdlr-core-js';
					$overlay_class .= (!empty($args['hover-info']) && in_array('margin', $args['hover-info']))? ' gdlr-core-with-margin':'';

					$overlay_content = '';
					$overlay_outer = '';
					if( !empty($args['hover-info']) ){
						foreach( $args['hover-info'] as $port_info ){
					
							switch( $port_info ){
					
								case 'date':
									$overlay_content .= '<span class="gdlr-core-portfolio-info gdlr-core-portfolio-date-wrap" >';
									$overlay_content .= get_the_date();
									$overlay_content .= '</span>';
									break;

								case 'icon':
									$link_attr = $this->get_thumbnail_link($portfolio_info, $args); 
									$overlay_content .= '<span class="gdlr-core-portfolio-icon-wrap" >';
									$overlay_content .= $link_attr['link-tag'];
									$overlay_content .= '<i class="gdlr-core-portfolio-icon ' . $this->portfolio_icon_class($link_attr['icon-type']) . '" ></i>';
									$overlay_content .= '</a>';
									$overlay_content .= '</span>';
									break;

								case 'title':
								case 'title_bottom':
									$port_title_hover_atts = array(
										'font-size' => empty($args['portfolio-hover-title-font-size'])? '': $args['portfolio-hover-title-font-size'],
										'font-weight' => empty($args['portfolio-hover-title-font-weight'])? '': $args['portfolio-hover-title-font-weight'],
										'letter-spacing' => empty($args['portfolio-hover-title-letter-spacing'])? '': $args['portfolio-hover-title-letter-spacing'],
										'text-transform' => (empty($args['portfolio-hover-title-text-transform']) || $args['portfolio-hover-title-text-transform'] == 'uppercase')? '': $args['portfolio-hover-title-text-transform']
									);

									$args['lightbox-group'] .= 't';
									$link_attr = $this->get_thumbnail_link($portfolio_info, $args); 
									$args['lightbox-group'] = substr($args['lightbox-group'], 0, -1);

									if( empty($portfolio_info['title-link-to']) || $portfolio_info['title-link-to'] == 'title' ){
										$title_html = '<span class="gdlr-core-portfolio-title gdlr-core-title-font" ' . gdlr_core_esc_style($port_title_hover_atts) . ' ><a href="' . get_permalink() . '" >' . get_the_title() . '</a></span>';
									}else{
										$title_html = '<span class="gdlr-core-portfolio-title gdlr-core-title-font" ' . gdlr_core_esc_style($port_title_hover_atts) . ' >' . $link_attr['link-tag'] . get_the_title() . '</a></span>';
									}

									if( $port_info == 'title_bottom' ){
										$overlay_outer .= $title_html;
									}else{
										$overlay_content .= $title_html;
									}
									
									break;
					
								case 'tag':
									$tag = get_the_term_list(get_the_ID(), 'portfolio_tag', '', ' <span class="gdlr-core-sep">/</span> ' , '');

									if( !empty($tag) ){
										$overlay_content .= '<span class="gdlr-core-portfolio-info gdlr-core-portfolio-info-tag gdlr-core-info-font" >';
										$overlay_content .= $tag;
										$overlay_content .= '</span>';
									}
									break;
									
								case 'category':
									$category = get_the_term_list(get_the_ID(), 'portfolio_category', '', ' <span class="gdlr-core-sep">/</span> ' , '');

									if( !empty($category) ){
										$overlay_content .= '<span class="gdlr-core-portfolio-info gdlr-core-portfolio-info-tag gdlr-core-info-font" >';
										$overlay_content .= $category;							
										$overlay_content .= '</span>';		
									}
									break;
									
								case 'excerpt':
									if( $args['excerpt'] == 'specify-number' ){
										if( !empty($args['excerpt-number']) ){
											$overlay_content .= '<span class="gdlr-core-portfolio-content" >' . $this->get_excerpt($args['excerpt-number']) . '</span>';
										}
									}else if( $args['excerpt'] != 'none' ){
										$overlay_content .= '<span class="gdlr-core-portfolio-content" >' . gdlr_core_content_filter(get_the_content(), true) . '</span>';
									}
									break;
					
								default:
									break;
					
							} // switch
							
						} // foreach
					} // $args['hover-info']

					$extra_class  = empty($args['hover'])? '': ' gdlr-core-style-' . $args['hover'];
					$extra_class .= empty($args['extra-class'])? '': ' ' . $args['extra-class'];
					if( !empty($feature_image) ){

						$image_effect = '';
						if( empty($args['enable-thumbnail-zoom-on-hover']) || $args['enable-thumbnail-zoom-on-hover'] == 'enable' ){
							$image_effect .= ' gdlr-core-zoom-on-hover';
						}
						if( !empty($args['enable-thumbnail-grayscale-effect']) && $args['enable-thumbnail-grayscale-effect'] == 'enable' ){
							$image_effect .= ' gdlr-core-grayscale-effect';
						}

						$image_overlay_background = '';
						if( !empty($args['overlay-color']) ){
							if( empty($args['overlay-opacity']) ){
								$args['overlay-opacity'] = 1;
							}
							$image_overlay_background = array($args['overlay-color'], $args['overlay-opacity']);
						}
						
						$ret .= '<div class="gdlr-core-portfolio-thumbnail gdlr-core-media-image ' . esc_attr($extra_class) . '" >';
						if( !empty($args['enable-badge']) && $args['enable-badge'] == 'enable' ){
							$ret .= $this->portfolio_badge($portfolio_info); 
						}
						$ret .= '<div class="gdlr-core-portfolio-thumbnail-image-wrap ' . esc_attr($image_effect) . '" >';
						$ret .= gdlr_core_get_image($feature_image, $args['thumbnail-size'], array(
							'image-overlay-class' => $overlay_class,
							'image-overlay-content' => $overlay_content,
							'image-overlay-content-outer' => $overlay_outer,
							'image-overlay-background' => $image_overlay_background,
							'placeholder' => false
						));	
						$ret .= '</div>'; // gdlr-core-portfolio-thumbnail-image-wrap
						$ret .= '</div>'; // gdlr-core-portfolio-thumbnail
					}else if( empty($has_content) ){
						$ret .= '<div class="gdlr-core-portfolio-thumbnail gdlr-core-no-image ' . esc_attr($extra_class) . '" >';
						$ret .= $overlay_content;
						$ret .= $overlay_outer;
						$ret .= '</div>';
					}

				// video thumbnail
				}else if( $portfolio_info['thumbnail-type'] == 'video' ){

					if( !empty($portfolio_info['video-url']) ){
						$ret .= '<div class="gdlr-core-portfolio-thumbnail gdlr-core-media-video" >';
						if( !empty($args['enable-badge']) && $args['enable-badge'] == 'enable' ){
							$ret .= $this->portfolio_badge($portfolio_info); 
						}
						$ret .= gdlr_core_get_video($portfolio_info['video-url'], $thumbnail_size);
						$ret .= '</div>';
					}

				// slider thumbnail
				}else if( $portfolio_info['thumbnail-type'] == 'slider' ){

					if( class_exists('gdlr_core_pb_element_gallery') ){
						if( !empty($portfolio_info['slider']) ){
							$ret .= '<div class="gdlr-core-portfolio-thumbnail gdlr-core-media-slider" >';
							if( !empty($args['enable-badge']) && $args['enable-badge'] == 'enable' ){
								$ret .= $this->portfolio_badge($portfolio_info); 
							}
							$ret .= gdlr_core_pb_element_gallery::get_flexslider_slider(
								$portfolio_info['slider'], 
								array( 'thumbnail-size' => $thumbnail_size ),
								(empty($args['lightbox-group'])? '': $args['lightbox-group'])
							);
							$ret .= '</div>';
						}
					}

				} 

				return $ret;
			}

			// portfolio info
			function get_info( $type ){

				$ret = '';

				switch( $type ){
					case 'date':
						$ret .= '<span class="gdlr-core-portfolio-info gdlr-core-portfolio-info-date gdlr-core-info-font gdlr-core-skin-caption" >';
						$ret .= '<a href="' . get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '">';
						$ret .= get_the_date();
						$ret .= '</a>';
						$ret .= '</span>';

						break;

					case 'tag':
						$tag = get_the_term_list(get_the_ID(), 'portfolio_tag', '', ' <span class="gdlr-core-sep">/</span> ' , '');

						if( !empty($tag) ){
							$ret .= '<span class="gdlr-core-portfolio-info gdlr-core-portfolio-info-tag gdlr-core-info-font gdlr-core-skin-caption" >';
							$ret .= $tag;
							$ret .= '</span>';
						}
						break;
						
					case 'category':
						$category = get_the_term_list(get_the_ID(), 'portfolio_category', '', ' <span class="gdlr-core-sep">/</span> ' , '');

						if( !empty($category) ){
							$ret .= '<span class="gdlr-core-portfolio-info gdlr-core-portfolio-info-tag gdlr-core-info-font" >';
							$ret .= $category;							
							$ret .= '</span>';		
						}
						break;
					default: 
						break;
				}

				return $ret;
			}


			// portfolio medium
			function portfolio_medium( $args ){

				$this->portfolio_medium_count++;

				$size = empty($args['portfolio-medium-size'])? 'small': $args['portfolio-medium-size'];
				$style = empty($args['portfolio-medium-style'])? 'left': $args['portfolio-medium-style'];

				$extra_class  = ' gdlr-core-size-' . $size; 
				if( $style == 'switch' ){
					$extra_class .= ' gdlr-core-style-' . (($this->portfolio_medium_count % 2 == 0)? 'right': 'left');
				}else{
					$extra_class .= ' gdlr-core-style-' . $style;
				}
				$extra_class .= (!empty($args['layout']) && $args['layout'] == 'carousel')? '': ' gdlr-core-item-pdlr';

				$thumbnail = $this->get_thumbnail($args);
				$thumbnail = empty($thumbnail)? '': '<div class="gdlr-core-portfolio-thumbnail-wrap">' . $thumbnail . '</div>';
				
				$ret  = '<div class="gdlr-core-item-list gdlr-core-portfolio-medium ' . esc_attr($extra_class) . '" >';
				if( $style == 'left' || ($style == 'switch' && $this->portfolio_medium_count % 2 == 1) ){ 
					$ret .= $thumbnail;
				}

				$ret .= '<div class="gdlr-core-portfolio-content-wrap" >';
				$ret .= $this->portfolio_title($args);
				if( empty($args['enable-portfolio-tag']) || $args['enable-portfolio-tag'] == 'enable' ){
					$ret .= $this->get_info('tag');
				}

				if( $args['excerpt'] == 'specify-number' ){
					if( !empty($args['excerpt-number']) ){
						$ret .= '<div class="gdlr-core-portfolio-content" >' . $this->get_excerpt($args['excerpt-number']) . '</div>';
					}
				}else if( $args['excerpt'] != 'none' ){
					$ret .= '<div class="gdlr-core-portfolio-content" >' . gdlr_core_content_filter(get_the_content(), true) . '</div>';
				}

				if( !empty($args['read-more-button']) && $args['read-more-button'] == 'enable' ){
					$ret .= '<a class="gdlr-core-portfolio-read-more" href="' . get_permalink() . '" >' . esc_html__('View Details', 'goodlayers-core-portfolio') . '</a>';
				}
				$ret .= '</div>'; // gdlr-core-portfolio-content-wrap

				if( $style == 'right' || ($style == 'switch' && $this->portfolio_medium_count % 2 == 0) ){ 
					$ret .= $thumbnail;
				}
				$ret .= '</div>'; // gdlr-core-blog-medium
				
				return $ret;
			} 
			
			// portfolio modern
			function portfolio_modern( $args ){
				
				$ret  = '<div class="gdlr-core-portfolio-modern" >';
				$ret .= $this->get_thumbnail($args, false);
				$ret .= '</div>'; // gdlr-core-portfolio-modern
				
				return $ret;
			} 
			
			// portfolio modern desc
			function portfolio_modern_desc( $args ){
			
				$args['hover-info'] = array('icon', 'title');
				if( empty($args['enable-portfolio-tag']) || $args['enable-portfolio-tag'] == 'enable' ){
					$args['hover-info'][] = 'tag';
				} 
				$args['hover-info'][] = 'excerpt';
				$args['hover'] = '';
				
				$ret  = '<div class="gdlr-core-portfolio-modern-desc" >';
				$ret .= $this->get_thumbnail($args, false);
				$ret .= '</div>'; // gdlr-core-portfolio-modern
				
				return $ret;
			} 	

			// portfolio metro
			function portfolio_metro( $args ){
				
				if( $args['portfolio-style'] == 'metro' ){
					$args['extra-class'] = ' gdlr-core-metro-rvpdlr';
				}
				
				$ret = '';

				if( !empty($args['enable-badge']) && $args['enable-badge'] == 'enable' ){
					$portfolio_info = get_post_meta(get_the_ID(), 'gdlr-core-page-option', true);

					$ret .= '<div class="gdlr-core-portfolio-metro-badge" >';
					$ret .= $this->portfolio_badge($portfolio_info); 
					$ret .= '</div>';

					$args['enable-badge'] = 'disable';
				}

				$ret .= '<div class="gdlr-core-portfolio-metro" >';
				$ret .= $this->get_thumbnail($args, false);
				$ret .= '</div>'; // gdlr-core-portfolio-modern
				
				return $ret;
			} 
			
			// portfolio grid
			function portfolio_grid( $args ){
				
				$extra_class  = ' gdlr-core-' . (empty($args['portfolio-grid-text-align'])? 'left': $args['portfolio-grid-text-align']) . '-align';
				$extra_class .= ' gdlr-core-style-' . (empty($args['portfolio-grid-style'])? 'normal': $args['portfolio-grid-style']);
				
				$ret  = '<div class="gdlr-core-portfolio-grid ' . esc_attr($extra_class) . '" >';
				$ret .= $this->get_thumbnail($args);
				// portfolio-frame-opacity
				$ret .= '<div class="gdlr-core-portfolio-content-wrap gdlr-core-skin-divider" >';
				if( !empty($args['portfolio-grid-style']) && $args['portfolio-grid-style'] == 'with-frame' ){
					$ret .= '<div class="gdlr-core-portfolio-grid-frame gdlr-core-skin-e-background" ' . gdlr_core_esc_style(array(
						'opacity' => isset($args['portfolio-frame-opacity'])? $args['portfolio-frame-opacity']: ''
					)) . ' ></div>';
				}

				$ret .= $this->portfolio_title($args);
				if( empty($args['enable-portfolio-tag']) || $args['enable-portfolio-tag'] == 'enable' ){
					$ret .= $this->get_info('tag');
				}
				if( !empty($args['enable-portfolio-date']) && $args['enable-portfolio-date'] == 'enable' ){
					$ret .= $this->get_info('date');
				}
				
				if( $args['excerpt'] == 'specify-number' ){
					if( !empty($args['excerpt-number']) ){
						$ret .= '<div class="gdlr-core-portfolio-content" >' . $this->get_excerpt($args['excerpt-number']) . '</div>';
					}
				}else if( $args['excerpt'] != 'none' ){
					$ret .= '<div class="gdlr-core-portfolio-content" >' . gdlr_core_content_filter(get_the_content(), true) . '</div>';
				}

				if( !empty($args['read-more-button']) && $args['read-more-button'] == 'enable' ){
					$ret .= '<div class="gdlr-core-portfolio-read-more-wrap" >';
					$ret .= '<a class="gdlr-core-portfolio-read-more" href="' . get_permalink() . '" >' . esc_html__('Read More', 'goodlayers-core-portfolio') . '</a>';
					$ret .= '</div>';
				}
				$ret .= '</div>'; // gdlr-core-portfolio-content-wrap
				$ret .= '</div>'; // gdlr-core-portfolio-modern
				
				return $ret;
			} 				
			
		} // gdlr_core_blog_item
	} // class_exists
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	