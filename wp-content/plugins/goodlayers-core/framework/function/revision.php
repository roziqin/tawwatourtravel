<?php
	/*	
	*	Goodlayers Revision
	*	---------------------------------------------------------------------
	*	File which store the revision
	*	---------------------------------------------------------------------
	*/
	
	if( !class_exists('gdlr_core_revision') ){
		
		class gdlr_core_revision{
			
			// static function for field registration
			private static $revision_fields = array();
			
			static function add_field( $field ){
				self::$revision_fields[] = $field;
			}	

			// starting revision object
			private $num_revision;
			
			function __construct( $num_revision = 5 ){
				
				$this->num_revision = $num_revision;
				add_filter('wp_revisions_to_keep', array(&$this, 'filter_function_name'), 10, 2);
				
				add_action('init', array(&$this, 'add_revision_action'));
			}
			function add_revision_action(){
				add_filter('wp_save_post_revision_post_has_changed', array(&$this, 'check_revision_field_changes'), 10, 3);
				add_action('_wp_put_post_revision', array(&$this, 'update_revision_meta_field'));
				add_action('wp_restore_post_revision', array(&$this, 'restore_revision_meta_filed'), 10, 2);

				// for preview revision
				global $pagenow; 
				if( !empty($pagenow) && ( $pagenow == 'revision.php' || ($pagenow == 'admin-ajax.php' && $_POST['action'] == 'get-revision-diffs') ) ){
					add_filter('_wp_post_revision_fields', array(&$this, 'add_preview_revision_fields'));
					foreach( self::$revision_fields as $revision_field ){
						if( !empty($revision_field['callback']) ){
							add_filter('_wp_post_revision_field_' . $revision_field['meta_key'], $revision_field['callback']);
						}
					}
				}
			}
			
			// define the number of revision user can stored
			function filter_function_name( $num, $post ) {
				return $this->num_revision;
			}

			// check if there are any changes to meta fields
			function check_revision_field_changes( $post_has_changed, $last_revision, $post ){
				foreach( self::$revision_fields as $revision_field ){
					if( get_post_meta($post->ID, $revision_field['meta_key'], true) != get_post_meta($last_revision->ID, $revision_field['meta_key'], true) ){
						$post_has_changed = true;
					}
				}
				
				return $post_has_changed;
			}
			
			// update meta field when revision is updated
			function update_revision_meta_field( $revision_id ){
				$post_parent = wp_is_post_revision($revision_id);
				
				foreach( self::$revision_fields as $revision_field ){
					$meta_value = get_post_meta($post_parent, $revision_field['meta_key'], true);
					if( !empty($meta_value) ){
						add_metadata('post', $revision_id, $revision_field['meta_key'], $meta_value);
					}
				}
			}
			
			// restore meta field when revision is restored
			function restore_revision_meta_filed( $post_id, $revision_id ){
				foreach( self::$revision_fields as $revision_field ){
					$revision_data = get_post_meta($revision_id, $revision_field['meta_key'], true);
					if( !empty($revision_data) ){
						update_post_meta($post_id, $revision_field['meta_key'], $revision_data);
					}
				}
			}
			
			// for previewing the revision
			function add_preview_revision_fields( $fields ){
				foreach( self::$revision_fields as $revision_field ){
					$fields[$revision_field['meta_key']] = $revision_field['meta_name'];
				}
				return $fields;
			}
			
		} // gdlr_core_revision

	} // class_exists