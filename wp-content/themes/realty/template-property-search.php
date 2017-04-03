<?php get_header();
/*
Template Name: Property Search Results (obsolete)
*/

global $realty_theme_option;

if ( isset( $realty_theme_option['property-listing-default-view'] ) ) {
	$listing_view = $realty_theme_option['property-listing-default-view'];
} else {
	$listing_view = 'grid-view';
}
?>

<div class="container">
	<p class="alert alert-danger"><?php esc_html_e( 'Page template "Property Search Results" is no longer supported in Realty 3.0. Please use page template "Default Template" instead and insert shortcode "Property Search Form" and "Property Listing".', 'realty' ); ?></p>
</div>

<div class="container">

	<?php
	// Property Search Form
	if ( isset( $_GET['searchid'] ) ) {
		echo do_shortcode(base64_decode($_GET['searchid']));
	} else {
		get_template_part( 'lib/inc/template/search-form' );
	}

	// Build Property Search Query

	$search_results_args = array();
	$search_results_args = apply_filters( 'property_search_args', $search_results_args );

	$query_search_results = new WP_Query( $search_results_args );

	if ( $query_search_results->have_posts() ) :
	  $count_results = $query_search_results->found_posts;
	?>

	<h2 class="page-title"><?php echo __( 'Search Results', 'realty' ) . ' (<span>' . $count_results . '</span>)'; ?></h2>

	<?php the_content(); ?>

	<?php echo tt_property_listing_sorting_and_view( null, $listing_view ); ?>

	<div class="loader-container">
		<div class="svg-loader"></div>
	</div>

	<div id="property-search-results" data-view="<?php if ( isset( $listing_view ) ) { echo $listing_view; } else { echo 'grid-view'; } ?>">
		<div class="property-items show-compare">

			<?php  get_template_part( 'lib/inc/template/property', 'comparison' ); ?>

			<ul class="row list-unstyled">
				<?php
					while ( $query_search_results->have_posts() ) : $query_search_results->the_post();

					if ( isset( $realty_theme_option['property-listing-columns'] ) ) {
						$columns = $realty_theme_option['property-listing-columns'];
					} else {
						$columns = "col-md-6";
					}
				?>
				<li class="<?php echo $columns; ?>">
					<?php get_template_part( 'lib/inc/template/property', 'item' );	?>
				</li>
				<?php endwhile; ?>
			</ul>

			<?php wp_reset_query(); ?>

			<div id="pagination">
				<?php
					// Built Property Pagination
					$big = 999999999; // need an unlikely integer
					echo paginate_links( array(
						'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' 			=> '?page=%#%',
						'total' 			=> $query_search_results->max_num_pages,
						'end_size'    => 4,
						'mid_size'    => 2,
						'type'				=> 'list',
						'current'     => $search_results_args['paged'],
						'prev_text' 	=> '<i class="icon-arrow-left"></i>',
						'next_text' 	=> '<i class="icon-arrow-right"></i>',
					) );
				?>
			</div>

			<?php
			else : ?>
			<p class="lead text-center text-muted"><?php _e( 'No Properties Match Your Search Criteria.', 'realty' ); ?></p>
			<?php
			endif;
			?>

		</div>
	</div>

</div>

<script>
jQuery('.loader-container').fadeTo(800, 0.5);

setTimeout(function() {
	jQuery('.loader-container').remove();
}, 800);
</script>

<?php get_footer(); ?>