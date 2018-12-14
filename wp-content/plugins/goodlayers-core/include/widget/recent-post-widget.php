<?php
	/**
	 * A widget that show recent posts ( Specified by category ).
	 */

	add_action('widgets_init', 'gdlr_core_recent_post_widget');
	if( !function_exists('gdlr_core_recent_post_widget') ){
		function gdlr_core_recent_post_widget() {
			register_widget( 'Goodlayers_Core_Recent_Post_Widget' );
		}
	}

	if( !class_exists('Goodlayers_Core_Recent_Post_Widget') ){
		class Goodlayers_Core_Recent_Post_Widget extends WP_Widget{

			// Initialize the widget
			function __construct() {

				parent::__construct(
					'gdlr-core-recent-post-widget', 
					esc_html__('Recent Post Widget ( Goodlayers )', 'goodlayers-core'), 
					array('description' => esc_html__('A widget that show latest posts', 'goodlayers-core'))
				);  

			}

			// Output of the widget
			function widget( $args, $instance ) {
	
				$title = empty($instance['title'])? '': apply_filters('widget_title', $instance['title']);
				$category = empty($instance['category'])? '': $instance['category'];
				$num_fetch = empty($instance['num-fetch'])? '': $instance['num-fetch'];
					
				// Opening of widget
				echo gdlr_core_escape_content($args['before_widget']);
				
				// Open of title tag
				if( !empty($title) ){ 
					echo gdlr_core_escape_content($args['before_title'] . $title . $args['after_title']); 
				}
					
				// Widget Content
				$query_args = array(
					'post_type' => 'post', 
					'suppress_filters' => false,
					'orderby' => 'post_date',
					'order' => 'desc',
					'paged' => 1,
					'ignore_sticky_posts' => 1,
					'posts_per_page' => $num_fetch,
					'category_name' => $category,
					'post__not_in' => array(get_the_ID())
				);
				$query = new WP_Query( $query_args );
				$blog_style = new gdlr_core_blog_style();
				
				if($query->have_posts()){
					echo '<div class="gdlr-core-recent-post-widget-wrap">';
					while($query->have_posts()){ $query->the_post();

						$feature_image = get_post_thumbnail_id();

						echo '<div class="gdlr-core-recent-post-widget clearfix">';
						if( !empty($feature_image) ){
							echo '<div class="gdlr-core-recent-post-widget-thumbnail gdlr-core-media-image" >' . gdlr_core_get_image($feature_image, 'thumbnail') . '</div>';
						}

						echo '<div class="gdlr-core-recent-post-widget-content">';
						echo '<div class="gdlr-core-recent-post-widget-title"><a href="' . get_permalink() . '" >' . get_the_title() . '</a></div>';

						echo '<div class="gdlr-core-recent-post-widget-info">' . $blog_style->blog_info(array(
							'display' => array('date', 'author')
						)) . '</div>';
						echo '</div>'; // gdlr-core-recent-post-widget-content
						echo '</div>'; // gdlr-core-recent-post-widget
					}
					echo '</div>'; // gdlr-core-recent-post-widget-wrap
				}
				wp_reset_postdata();
						
				// Closing of widget
				echo gdlr_core_escape_content($args['after_widget']);

			}

			// Widget Form
			function form( $instance ) {

				if( class_exists('gdlr_core_widget_util') ){
					gdlr_core_widget_util::get_option(array(
						'title' => array(
							'type' => 'text',
							'id' => $this->get_field_id('title'),
							'name' => $this->get_field_name('title'),
							'title' => esc_html__('Title', 'goodlayers-core'),
							'value' => (isset($instance['title'])? $instance['title']: '')
						),
						'category' => array(
							'type' => 'combobox',
							'id' => $this->get_field_id('category'),
							'name' => $this->get_field_name('category'),
							'title' => esc_html__('Category', 'goodlayers-core'),
							'options' => gdlr_core_get_term_list('category', '', true),
							'value' => (isset($instance['category'])? $instance['category']: '')
						),
						'num-fetch' => array(
							'type' => 'text',
							'id' => $this->get_field_id('num-fetch'),
							'name' => $this->get_field_name('num-fetch'),
							'title' => esc_html__('Display Number', 'goodlayers-core'), 
							'value' => (isset($instance['num-fetch'])? $instance['num-fetch']: '3')
						),
					));
				}

			}
			
			// Update the widget
			function update( $new_instance, $old_instance ) {

				if( class_exists('gdlr_core_widget_util') ){
					return gdlr_core_widget_util::get_option_update($new_instance);
				}

				return $new_instance;
			}	
		} // class
	} // class_exists
?>