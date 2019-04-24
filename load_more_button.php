<!--  Load more button. plave it befreo your wp_reset_postdata(); -->
<?php
// don't display the button if there are not enough posts
if (  $wp_query->max_num_pages > 1 ) : ?>
	<div class="text-center">
			<div class="button misha_loadmore">More posts</div>
		</div>
<?php endif; ?>	

<!-- set custom query variable to pass on use unique name myajax -->
<script>
	var posts_myajax = '<?php echo serialize( $wp_query->query_vars ) ?>',
    current_page_myajax = 1,
    max_page_myajax = <?php echo $wp_query->max_num_pages ?>
</script>	