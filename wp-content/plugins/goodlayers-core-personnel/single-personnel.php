<?php
	/**
	 * The template for displaying all single personnel post type
	 */

get_header(); 

	while( have_posts() ){ the_post();

		do_action('gdlr_core_print_page_builder');
		
	}

get_footer(); 

?>