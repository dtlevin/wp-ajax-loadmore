<!-- blog post load more  -->

<?php //remove this  before adding it to your functions.phph file 
	function misha_my_load_more_scripts() {
	 
		global $wp_query; 
	 
		// In most cases it is already included on the page and this line can be removed
		wp_enqueue_script('jquery');
	 
		// register our main script but do not enqueue it yet
		wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/myloadmore.js', array('jquery') );
	 
		// now the most interesting part
		// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
		// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
		wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
			'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
			'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
			'max_page' => $wp_query->max_num_pages
		) );
	 
	 	wp_enqueue_script( 'my_loadmore' );
	}
	 
	add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );


	// ajax handler for load more 
	function misha_loadmore_ajax_handler(){
 
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	$args['post_type'] = array('blog');
 
	// it is always better to use WP_Query but not here
	query_posts( $args );
 
	if( have_posts() ) :
 
		// run the loop
		while( have_posts() ): the_post(); 

			$terms = get_the_terms( get_the_ID(), 'blog_categories' );
	
			?>
 			
			<!-- you template for each result goes here. test with the_title() -->
 			<?php the_title(); ?>	
 		<?php
		endwhile;
 
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
 
 
 
add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}