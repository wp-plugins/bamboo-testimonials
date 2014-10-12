<?php
/**************************************************************************************************/
/*
Plugin Name: Bamboo Testimonials
Plugin URI:  http://www.bamboosolutions.co.uk/wordpress/bamboo-testimonials
Author:      Bamboo Solutions
Author URI:  http://www.bamboosolutions.co.uk
Version:     1.0
Description: Easily manage testimonials and display them throughout your website.
*/
/**************************************************************************************************/

	add_action( 'init', 'bamboo_testimonials_init' );
	add_filter( 'enter_title_here', 'bamboo_testimonials_enter_title_here' );
	add_shortcode( 'bamboo-testimonial', 'bamboo_testimonial' );

/**************************************************************************************************/

	function bamboo_testimonials_init() {

		// Create the testimonial post type
		$labels = array(
			'name' 			=> 'Testimonials',
			'singular_name'	=> 'Testimonial',
			'menu_name' 	=> 'Testimonials',
			'all_items' 	=> 'All Testimonials',
			'add_new_item'	=> 'Add New Testimonial',
			'edit_item' 	=> 'Edit Testimonial',
			'new_item' 		=> 'New Testimonial',
			'view_item' 	=> 'View Testimonial',
			'search_items' 	=> 'Search Testimonials'
		);
		$supports = array( 'title', 'editor' );
		$args = array(
			'labels' 				=> $labels,
			'supports' 				=> $supports,
			'public' 				=> true,
			'has_archive' 			=> false,
			'exclude_from_search'	=> true,
			'show_in_nav_menus' 	=> false,
			'menu_position' 		=> 5,
			'menu_icon' 			=> 'dashicons-format-chat',
			'rewrite' 				=> array( 'slug' => 'testimonial' )
		);
		register_post_type( 'bamboo_testimonial', $args );

	}

/**************************************************************************************************/

	function bamboo_testimonials_enter_title_here( $prompt ) {

		global $post_type;

		if( is_admin() && 'bamboo_testimonial'==$post_type ) {
			return "Enter testimonial author here";
		}

		return $prompt;

	}

/**************************************************************************************************/

	function bamboo_testimonial( $atts, $content = null ) {

		$args = array( 'post_type'=>'bamboo_testimonial', 'orderby'=>'rand', 'order'=>'ASC', 'posts_per_page'=>'1');
		$loop = new WP_Query( $args );
		$html = '';
		while ($loop->have_posts()) : $loop->the_post();
			$author = get_the_title();
			$content = get_the_content();
			$html = '<blockquote class="bamboo-testimonial"><i>&ldquo;</i>' . $content . '<i>&rdquo;</i><span>' . $author .'</span></blockquote>';
		endwhile;

		return $html;
	}

/**************************************************************************************************/
?>